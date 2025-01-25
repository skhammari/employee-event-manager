<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipation;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class MemberController extends Controller
{
    public function dashboard(): Response
    {
        $member = Auth::guard('member')->user();
        $participations = $member->eventParticipations()
            ->with('event')
            ->get();

        return Inertia::render('Member/Dashboard', [
            'member' => $member,
            'participations' => $participations,
        ]);
    }

    public function profile(): Response
    {
        return Inertia::render('Member/Profile', [
            'member' => Auth::guard('member')->user(),
        ]);
    }

    public function events(): Response
    {
        $member = Auth::guard('member')->user();
        $events = Event::where('is_active', true)
            ->where('end_date', '>', now())
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'description' => $event->description,
                    'start_date' => $event->start_date,
                    'end_date' => $event->end_date,
                    'location' => $event->location,
                    'participation_limit' => $event->participation_limit,
                    'remaining_spaces' => $event->remaining_spaces,
                ];
            });

        return Inertia::render('Member/Events', [
            'events' => $events,
            'canParticipate' => $member->eventParticipations()->count() < 3,
            'currentParticipations' => $member->eventParticipations()->count(),
        ]);
    }

    public function participate(Event $event): RedirectResponse
    {
        $member = Auth::guard('member')->user();

        if ($member->eventParticipations()->count() >= 3) {
            return back()->with('error', 'شما نمی‌توانید در بیش از ۳ رویداد شرکت کنید.');
        }

        if ($event->eventParticipations()->where('is_validated', true)->count() >= $event->participation_limit) {
            return back()->with('error', 'ظرفیت این رویداد تکمیل شده است.');
        }

        if ($member->eventParticipations()->where('event_id', $event->id)->exists()) {
            return back()->with('error', 'شما قبلاً در این رویداد ثبت‌نام کرده‌اید.');
        }

        EventParticipation::create([
            'member_id' => $member->id,
            'event_id' => $event->id,
            'validation_code' => Str::random(10),
        ]);

        return back()->with('success', 'ثبت‌نام شما با موفقیت انجام شد.');
    }
}

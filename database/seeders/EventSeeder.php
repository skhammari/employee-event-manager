<?php

namespace Database\Seeders;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'همایش بزرگ برنامه‌نویسان',
                'description' => 'همایش سالانه برنامه‌نویسان با حضور اساتید برجسته و کارگاه‌های تخصصی',
                'start_date' => Carbon::now()->addDays(10),
                'end_date' => Carbon::now()->addDays(12),
                'participation_limit' => 100,
                'location' => 'سالن همایش‌های رازی',
                'is_active' => true,
            ],
            [
                'title' => 'کارگاه هوش مصنوعی',
                'description' => 'آشنایی با مفاهیم پایه و پیشرفته هوش مصنوعی و یادگیری ماشین',
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addDays(15),
                'participation_limit' => 50,
                'location' => 'دانشکده فنی دانشگاه تهران',
                'is_active' => true,
            ],
            [
                'title' => 'نمایشگاه فناوری‌های نوین',
                'description' => 'نمایشگاه دستاوردهای جدید در حوزه فناوری اطلاعات و ارتباطات',
                'start_date' => Carbon::now()->addDays(20),
                'end_date' => Carbon::now()->addDays(25),
                'participation_limit' => 200,
                'location' => 'نمایشگاه بین‌المللی تهران',
                'is_active' => true,
            ],
            [
                'title' => 'کنفرانس امنیت سایبری',
                'description' => 'بررسی چالش‌های امنیتی در فضای سایبری و راهکارهای مقابله با تهدیدات',
                'start_date' => Carbon::now()->addDays(30),
                'end_date' => Carbon::now()->addDays(31),
                'participation_limit' => 80,
                'location' => 'پژوهشگاه ارتباطات و فناوری اطلاعات',
                'is_active' => true,
            ],
            [
                'title' => 'جشنواره وب و موبایل',
                'description' => 'معرفی برترین وب‌سایت‌ها و اپلیکیشن‌های موبایل سال',
                'start_date' => Carbon::now()->addDays(40),
                'end_date' => Carbon::now()->addDays(41),
                'participation_limit' => 150,
                'location' => 'برج میلاد',
                'is_active' => true,
            ],
            [
                'title' => 'کارگاه برنامه‌نویسی پایتون',
                'description' => 'آموزش عملی برنامه‌نویسی پایتون از مبتدی تا پیشرفته',
                'start_date' => Carbon::now()->addDays(5),
                'end_date' => Carbon::now()->addDays(7),
                'participation_limit' => 30,
                'location' => 'مرکز نوآوری دانشگاه شریف',
                'is_active' => true,
            ],
            [
                'title' => 'سمینار بلاکچین و رمزارزها',
                'description' => 'بررسی فناوری بلاکچین و آینده ارزهای دیجیتال',
                'start_date' => Carbon::now()->addDays(25),
                'end_date' => Carbon::now()->addDays(25),
                'participation_limit' => 120,
                'location' => 'سالن همایش‌های صدا و سیما',
                'is_active' => true,
            ],
            [
                'title' => 'کارگاه طراحی رابط کاربری',
                'description' => 'اصول طراحی رابط کاربری و تجربه کاربری در وب و موبایل',
                'start_date' => Carbon::now()->addDays(18),
                'end_date' => Carbon::now()->addDays(19),
                'participation_limit' => 40,
                'location' => 'دانشکده هنر دانشگاه تهران',
                'is_active' => true,
            ],
            [
                'title' => 'همایش استارتاپ‌های موفق',
                'description' => 'معرفی استارتاپ‌های موفق و تجربیات کارآفرینان',
                'start_date' => Carbon::now()->addDays(35),
                'end_date' => Carbon::now()->addDays(35),
                'participation_limit' => 180,
                'location' => 'مرکز همایش‌های برج میلاد',
                'is_active' => true,
            ],
            [
                'title' => 'کارگاه مدیریت پروژه‌های نرم‌افزاری',
                'description' => 'آموزش متدولوژی‌های چابک و مدیریت پروژه‌های نرم‌افزاری',
                'start_date' => Carbon::now()->addDays(45),
                'end_date' => Carbon::now()->addDays(46),
                'participation_limit' => 60,
                'location' => 'پارک علم و فناوری پردیس',
                'is_active' => true,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventParticipationResource\Pages;
use App\Filament\Resources\EventParticipationResource\RelationManagers;
use App\Models\EventParticipation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class EventParticipationResource extends Resource
{
    protected static ?string $model = EventParticipation::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    
    protected static ?string $navigationLabel = 'مدیریت شرکت‌کنندگان';

    protected static ?string $modelLabel = 'شرکت‌کننده';

    protected static ?string $pluralModelLabel = 'شرکت‌کنندگان';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('event_id')
                    ->relationship('event', 'title')
                    ->required()
                    ->label('رویداد'),
                Forms\Components\Select::make('member_id')
                    ->relationship('member', 'name')
                    ->required()
                    ->label('عضو'),
                Forms\Components\Toggle::make('is_validated')
                    ->label('تایید شده'),
                Forms\Components\DateTimePicker::make('validated_at')
                    ->label('تاریخ تایید'),
                Forms\Components\TextInput::make('validation_code')
                    ->label('کد تایید')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event.title')
                    ->label('رویداد')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('member.name')
                    ->label('عضو')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_validated')
                    ->label('تایید شده')
                    ->boolean(),
                Tables\Columns\TextColumn::make('validated_at')
                    ->label('تاریخ تایید')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('validation_code')
                    ->label('کد تایید')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('event')
                    ->relationship('event', 'title')
                    ->label('رویداد'),
                Tables\Filters\TernaryFilter::make('is_validated')
                    ->label('وضعیت تایید'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('scan')
                    ->label('اسکن QR')
                    ->icon('heroicon-o-qr-code')
                    ->form([
                        TextInput::make('qr_code')
                            ->label('کد QR')
                            ->required(),
                    ])
                    ->action(function (EventParticipation $record, array $data): void {
                        $qrData = json_decode(base64_decode($data['qr_code']), true);
                        
                        if (!$qrData || !isset($qrData['personal_id'])) {
                            Notification::make()
                                ->title('خطا')
                                ->body('کد QR نامعتبر است.')
                                ->danger()
                                ->send();
                            return;
                        }

                        if ($record->member->personal_id !== $qrData['personal_id']) {
                            Notification::make()
                                ->title('خطا')
                                ->body('این کد QR متعلق به عضو دیگری است.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $record->update([
                            'is_validated' => true,
                            'validated_at' => now(),
                        ]);

                        Notification::make()
                            ->title('موفقیت')
                            ->body('حضور عضو با موفقیت تایید شد.')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEventParticipations::route('/'),
            'create' => Pages\CreateEventParticipation::route('/create'),
            'edit' => Pages\EditEventParticipation::route('/{record}/edit'),
        ];
    }
}

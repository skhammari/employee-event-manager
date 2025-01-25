<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    
    protected static ?string $modelLabel = 'رویداد';
    protected static ?string $pluralModelLabel = 'رویدادها';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('عنوان')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('توضیحات')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('start_date')
                    ->label('تاریخ شروع')
                    ->required(),
                Forms\Components\DateTimePicker::make('end_date')
                    ->label('تاریخ پایان')
                    ->required()
                    ->after('start_date'),
                Forms\Components\TextInput::make('participation_limit')
                    ->label('ظرفیت')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                Forms\Components\TextInput::make('location')
                    ->label('مکان')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')
                    ->label('فعال')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('تاریخ شروع')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('تاریخ پایان')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('participation_limit')
                    ->label('ظرفیت')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('remainingSpaces')
                    ->label('ظرفیت باقیمانده')
                    ->numeric(),
                Tables\Columns\TextColumn::make('location')
                    ->label('مکان')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('تاریخ بروزرسانی')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('ویرایش'),
                Tables\Actions\DeleteAction::make()->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف'),
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}

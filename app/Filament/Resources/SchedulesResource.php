<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchedulesResource\Pages;
use App\Models\Schedules;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SchedulesResource extends Resource
{
    protected static ?string $model = Schedules::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-date-range';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->required(),
                                Forms\Components\Select::make('shifts_id')
                                    ->relationship('shifts', 'name')
                                    ->required(),
                                Forms\Components\Select::make('offices_id')
                                    ->relationship('offices', 'name')
                                    ->required(),
                                Forms\Components\Toggle::make('is_wfa'),
                            ]),
                    ]),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                // $is_super_admin = Auth::user()->hasRoles('super_admin');
                $is_super_admin = Auth::user()->hasRole('super_admin');
                if (! $is_super_admin) {
                    $query->where('user_id', Auth::user()->id);
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->sortable(),

                Tables\Columns\BooleanColumn::make('is_wfa')
                    ->label('WFA'),
                Tables\Columns\TextColumn::make('shifts.name')
                    ->description(fn (Schedules $record) => $record->shifts->start_time.' - '.$record->shifts->end_time)
                    ->sortable(),

                Tables\Columns\TextColumn::make('offices_id')
                    ->label('Office')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedules::route('/create'),
            'edit' => Pages\EditSchedules::route('/{record}/edit'),
        ];
    }
}

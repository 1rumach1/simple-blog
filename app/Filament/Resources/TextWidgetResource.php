<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TextWidgetResource\Pages;
use App\Filament\Resources\TextWidgetResource\RelationManagers;
use App\Models\TextWidget;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TextWidgetResource extends Resource
{
    protected static ?string $model = TextWidget::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->disk('public')
                    ->directory('widgets')
                    ->visibility('public'),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(50),
                Forms\Components\RichEditor::make('content'),
                Forms\Components\Toggle::make('active')
                    ->required(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->disk('public')
                    ->visibility('public')
                    ->url(fn($record) => asset('storage/' . $record->image)),
                Tables\Columns\TextColumn::make('key'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListTextWidgets::route('/'),
            'create' => Pages\CreateTextWidget::route('/create'),
            'edit' => Pages\EditTextWidget::route('/{record}/edit'),
        ];
    }
}

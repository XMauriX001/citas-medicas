<?php

namespace App\Filament\Resources\Pacientes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Infolists\Components\TextEntry;

class PacientesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('apellido')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('dui')
                    ->label('DUI')
                    ->searchable(),
                TextColumn::make('fecha_nacimiento')
                    ->label('Fecha Nac.')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('telefono')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('expedienteClinico.tipo_sangre')
                    ->label('Tipo Sangre')
                    ->badge()
                    ->color('info')
                    ->default('N/A'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('verExpediente')
                    ->label('Ver Expediente')
                    ->icon('heroicon-o-document-text')
                    ->color('info')
                    ->modalHeading(fn ($record) => ' Expediente de ' . $record->nombre . ' ' . $record->apellido)
                    ->infolist([
                        TextEntry::make('nombre')->label('Nombre'),
                        TextEntry::make('apellido')->label('Apellido'),
                        TextEntry::make('dui')->label('DUI'),
                        TextEntry::make('fecha_nacimiento')
                            ->label('Fecha de Nacimiento')
                            ->date('d/m/Y'),
                        TextEntry::make('telefono')
                            ->label('Teléfono')
                            ->default('No registrado'),
                        TextEntry::make('email')
                            ->label('Email')
                            ->default('No registrado'),
                        TextEntry::make('expedienteClinico.tipo_sangre')
                            ->label('Tipo de Sangre')
                            ->badge()
                            ->color('info')
                            ->default('No registrado'),
                        TextEntry::make('expedienteClinico.alergias')
                            ->label('Alergias')
                            ->default('Ninguna registrada'),
                        TextEntry::make('expedienteClinico.antecedentes')
                            ->label('Antecedentes Médicos')
                            ->default('Ninguno registrado'),
                        TextEntry::make('expedienteClinico.medicamentos_actuales')
                            ->label(' Medicamentos Actuales')
                            ->default('Ninguno registrado'),
                    ])
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Cerrar'),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
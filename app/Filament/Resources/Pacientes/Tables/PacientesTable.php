<?php

namespace App\Filament\Resources\Pacientes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\IconEntry;

class PacientesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('apellido')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('dui')
                    ->label('DUI')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('DUI copiado'),
                TextColumn::make('fecha_nacimiento')
                    ->label('Fecha Nac.')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('telefono')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->limit(25),
                TextColumn::make('expedienteClinico.tipo_sangre')
                    ->label('Tipo Sangre')
                    ->badge()
                    ->color('danger')
                    ->default('N/A'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('verExpediente')
                    ->label('Ver Expediente Completo')
                    ->icon('heroicon-o-document-text')
                    ->color('info')
                    ->size('lg')
                    ->modalHeading(fn ($record) => '📋 Expediente Médico Completo')
                    ->modalDescription(fn ($record) => 'Paciente: ' . $record->nombre . ' ' . $record->apellido . ' | DUI: ' . $record->dui)
                    ->modalWidth('4xl')
                    ->infolist([
                        
                        TextEntry::make('nombre')
                            ->label('👤 NOMBRE')
                            ->size('lg')
                            ->weight('bold')
                            ->color('primary'),
                        
                        TextEntry::make('apellido')
                            ->label('👤 APELLIDO')
                            ->size('lg')
                            ->weight('bold')
                            ->color('primary'),
                        
                        TextEntry::make('dui')
                            ->label('🆔 DOCUMENTO DE IDENTIDAD')
                            ->copyable()
                            ->copyMessage('DUI copiado al portapapeles')
                            ->weight('semibold'),
                        
                        TextEntry::make('fecha_nacimiento')
                            ->label('🎂 FECHA DE NACIMIENTO')
                            ->date('d/m/Y')
                            ->weight('semibold'),
                        
                        TextEntry::make('telefono')
                            ->label('📞 TELÉFONO')
                            ->default('No registrado')
                            ->copyable()
                            ->copyMessage('Teléfono copiado'),
                        
                        TextEntry::make('email')
                            ->label('📧 CORREO ELECTRÓNICO')
                            ->default('No registrado')
                            ->copyable()
                            ->copyMessage('Email copiado'),
                        
             
                        TextEntry::make('expedienteClinico.tipo_sangre')
                            ->label('🩸 TIPO DE SANGRE')
                            ->badge()
                            ->size('xl')
                            ->color('danger')
                            ->default('⚠️ NO REGISTRADO')
                            ->weight('bold'),
                            
                        TextEntry::make('expedienteClinico.alergias')
                            ->label('⚠️ ALERGIAS CONOCIDAS')
                            ->default('✓ Ninguna alergia registrada')
                            ->color('warning')
                            ->columnSpanFull()
                            ->weight('semibold'),
                        
                        TextEntry::make('expedienteClinico.antecedentes')
                            ->label('📋 ANTECEDENTES MÉDICOS')
                            ->default('✓ Sin antecedentes médicos registrados')
                            ->color('gray')
                            ->columnSpanFull()
                            ->weight('semibold'),
                        
                        TextEntry::make('expedienteClinico.medicamentos_actuales')
                            ->label('💊 MEDICAMENTOS ACTUALES')
                            ->default('✓ Sin medicamentos registrados')
                            ->color('success')
                            ->columnSpanFull()
                            ->weight('semibold'),
                    ])
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('✕ Cerrar Expediente')
                    ->slideOver(),
                    
                EditAction::make()
                    ->label('Editar')
                    ->icon('heroicon-o-pencil'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('nombre', 'asc')
            ->striped()
            ->paginated([10, 25, 50]);
    }
}
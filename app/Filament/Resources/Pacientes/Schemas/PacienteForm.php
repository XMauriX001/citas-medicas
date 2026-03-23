<?php

namespace App\Filament\Resources\Pacientes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class PacienteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Información del Paciente
                TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                    
                TextInput::make('apellido')
                    ->required()
                    ->maxLength(255),
                    
                TextInput::make('dui')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->length(10)
                    ->mask('99999999-9')
                    ->placeholder('12345678-9'),
                    
                DatePicker::make('fecha_nacimiento')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->maxDate(now()),
                    
                TextInput::make('telefono')
                    ->tel()
                    ->maxLength(15),
                    
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->maxLength(255),

                // Expediente Clínico
                Select::make('expedienteClinico.tipo_sangre')
                    ->label('Tipo de Sangre')
                    ->options([
                        'A+' => 'A+',
                        'A-' => 'A-',
                        'B+' => 'B+',
                        'B-' => 'B-',
                        'AB+' => 'AB+',
                        'AB-' => 'AB-',
                        'O+' => 'O+',
                        'O-' => 'O-',
                    ])
                    ->searchable()
                    ->placeholder('Seleccione'),
                
                Textarea::make('expedienteClinico.alergias')
                    ->label('Alergias')
                    ->placeholder('Ej: Penicilina, Polen, Mariscos...')
                    ->rows(3)
                    ->columnSpanFull(),
                
                Textarea::make('expedienteClinico.antecedentes')
                    ->label('Antecedentes Médicos')
                    ->placeholder('Ej: Diabetes, Hipertensión...')
                    ->rows(3)
                    ->columnSpanFull(),
                
                Textarea::make('expedienteClinico.medicamentos_actuales')
                    ->label('Medicamentos Actuales')
                    ->placeholder('Ej: Metformina 500mg...')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
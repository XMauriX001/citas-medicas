<?php

namespace App\Filament\Resources\Pacientes;

use App\Filament\Resources\Pacientes\Pages\CreatePaciente;
use App\Filament\Resources\Pacientes\Pages\EditPaciente;
use App\Filament\Resources\Pacientes\Pages\ListPacientes;
use App\Filament\Resources\Pacientes\Pages\ViewPaciente;
use App\Filament\Resources\Pacientes\Schemas\PacienteForm;
use App\Filament\Resources\Pacientes\Tables\PacientesTable;
use App\Models\Paciente;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PacienteResource extends Resource
{
    protected static ?string $model = Paciente::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    // Solo admin y asistente ven el menú de Pacientes
    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return in_array($user?->role, ['admin', 'asistente']);
    }

    // Solo admin y asistente pueden editar
    public static function canEdit($record): bool
    {
        return in_array(auth()->user()->role, ['admin', 'asistente']);
    }

    // Solo admin y asistente pueden crear
    public static function canCreate(): bool
    {
        return in_array(auth()->user()->role, ['admin', 'asistente']);
    }

    // Solo admin puede eliminar
    public static function canDelete($record): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function form(Schema $schema): Schema
    {
        return PacienteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PacientesTable::configure($table);
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
            'index' => ListPacientes::route('/'),
            'create' => CreatePaciente::route('/create'),
            'edit' => EditPaciente::route('/{record}/edit'),
        ];
    }
}
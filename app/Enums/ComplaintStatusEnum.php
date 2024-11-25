<?php
namespace App\Enums;

enum ComplaintStatusEnum: string
{
    case PENDING = 'Pendiente';
    case REVIEWED = 'Revisado';
    case RESOLVED = 'Solucionados';

    public static function getValues(): array
    {
        return array_map(fn ($enum) => $enum->value, self::cases());
    }
}
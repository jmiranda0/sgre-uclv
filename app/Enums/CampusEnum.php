<?php
namespace App\Enums;

enum CampusEnum :string{
    case UNI = "Universitaria";
    case VAREL = "Félix Varela";
    case FAJARDO = "Manuel Fajardo";

    public static function getValues(): array
    {
        return array_map(fn ($enum) => $enum->value, self::cases());
    }
}
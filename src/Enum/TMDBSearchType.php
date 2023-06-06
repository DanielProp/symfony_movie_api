<?php

namespace App\Enum;

enum TMDBSearchType: string
{
    case Movie = 'movie';
    case Tv = 'tv';
    case Person = 'person';
    case Multi = 'multi';

    public static function fromString(string $search):TMDBSearchType | bool
    {
        foreach(TMDBSearchType::cases() as $type)
        {
            if($type->value == $search)
                return $type;
        }
        return false;
    }
}
<?php

namespace App\Domains\Platform\Enums;

enum SettingType: string
{
    case String = 'string';
    case Integer = 'integer';
    case Boolean = 'boolean';
    case Json = 'json';

    public function label(): string
    {
        return match ($this) {
            self::String => 'String',
            self::Integer => 'Integer',
            self::Boolean => 'Boolean',
            self::Json => 'JSON',
        };
    }
}

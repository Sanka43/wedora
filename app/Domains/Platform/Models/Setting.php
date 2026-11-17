<?php

namespace App\Domains\Platform\Models;

use App\Domains\Platform\Enums\SettingType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'type' => SettingType::class,
            'is_public' => 'boolean',
        ];
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();

        if (! $setting) {
            return $default;
        }

        return match ($setting->type) {
            SettingType::Integer => (int) $setting->value,
            SettingType::Boolean => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            SettingType::Json => json_decode($setting->value, true),
            default => $setting->value,
        };
    }

    public static function set(string $key, mixed $value, string $group = 'general', bool $isPublic = false): self
    {
        $type = match (true) {
            is_int($value) => SettingType::Integer,
            is_bool($value) => SettingType::Boolean,
            is_array($value) => SettingType::Json,
            default => SettingType::String,
        };

        $stringValue = is_array($value) ? json_encode($value) : (is_bool($value) ? ($value ? '1' : '0') : (string) $value);

        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $stringValue,
                'type' => $type,
                'group' => $group,
                'is_public' => $isPublic,
            ]
        );
    }
}

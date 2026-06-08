<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get a setting by key.
     */
    public static function get(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        if ($setting) {
            $decoded = json_decode($setting->value, true);
            return json_last_error() === JSON_ERROR_NONE ? $decoded : $setting->value;
        }
        return $default;
    }

    /**
     * Set a setting key-value pair.
     */
    public static function set(string $key, $value): void
    {
        $valueStr = is_array($value) || is_object($value) ? json_encode($value) : (string)$value;
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $valueStr]
        );
    }
}

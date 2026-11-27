<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyParameter extends Model
{
    protected $table = 'survey_parameters';

    protected $fillable = [
        'key',
        'label',
        'value',
        'sort_order',
    ];

    protected $casts = [
        'value' => 'float',
    ];

    /** All values by key, loaded once per request */
    private static ?array $values = null;

    protected static function booted(): void
    {
        // A changed value must be read again
        static::saved(fn () => static::$values = null);
        static::deleted(fn () => static::$values = null);
    }

    /** Every parameter as [key => value] */
    public static function values(): array
    {
        if (static::$values === null) {
            static::$values = static::query()->pluck('value', 'key')->map(fn ($value) => (float) $value)->all();
        }

        return static::$values;
    }

    /** One parameter, e.g. SurveyParameter::value('hourly_rate') */
    public static function value(string $key): float
    {
        $values = static::values();

        if (! array_key_exists($key, $values)) {
            throw new \RuntimeException("Survey parameter [{$key}] is missing. Add it on the Survey Configuration page or in the survey_parameters table.");
        }

        return $values[$key];
    }

    /** A value without trailing zeros, e.g. 0.1000 => "0.1", 28.7500 => "28.75" */
    public static function format(float|string $value): string
    {
        return rtrim(rtrim(number_format((float) $value, 4, '.', ''), '0'), '.');
    }
}

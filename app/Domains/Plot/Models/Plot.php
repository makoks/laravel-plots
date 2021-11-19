<?php

namespace App\Domains\Plot\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class Plot extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'number',
        'address',
        'price',
        'area',
    ];

    public static function saveBiglandApiPlots($plots) {
        $result = [];
        foreach ($plots as $plot) {
            $savedPlot = self::updateOrCreate(
                ['number' => Arr::get($plot, 'attrs.plot_number')],
                [
                    'address' => Arr::get($plot, 'attrs.plot_address'),
                    'price' => Arr::get($plot, 'attrs.plot_price'),
                    'area' => Arr::get($plot, 'attrs.plot_area'),
                ]
            );
            $result[] = $savedPlot->only('number', 'address', 'price', 'area');
            $savedPlot->touch();
        }

        return collect($result);
    }
}

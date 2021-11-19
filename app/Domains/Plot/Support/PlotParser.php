<?php

namespace App\Domains\Plot\Support;

use App\Domains\Plot\Models\Plot;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class PlotParser
{
    /**
     * Parses Plots by given array of Plot numbers.
     *
     * @param array $plotNumbers Plot numbers.
     *
     * @throws ValidationException if one of the Plot numbers is not in the
     *                             correct format.
     *
     * @return Illuminate\Support\Collection Collection of Plots.
     */
    public static function parsePlots($plotNumbers) {
        $validated = self::validatePlots($plotNumbers);

        $upToDate = Plot::whereIn('number', $validated)
            ->where('updated_at', '>', now()->subHour())
            ->get();

        $toUpdate = collect($validated)->diff($upToDate->pluck('number'));
        $plotsFromBiglandApi = self::getPlotsFromBiglandApi($toUpdate);

        $updated = Plot::saveBiglandApiPlots($plotsFromBiglandApi);

        return $updated->concat($upToDate);
    }

    /**
     * Validates that Plot numbers are in format 00:00:0000000:0000.
     *
     * @param array $plotNumbers Plot numbers.
     *
     * @throws ValidationException if at least one of the Plot numbers is not
     *                             in the correct format.
     *
     * @return array Validated Plot numbers.
     */
    public static function validatePlots($plotNumbers) {
        $result = [];
        $errors = [];
        foreach ($plotNumbers as $number) {
            $plot = Str::of($number)
                ->trim()
                ->match('/^\d{1,2}:\d{1,2}:\d{6,7}:\d{1,4}$/');

            if ($plot->isEmpty()) {
                $errors['plots'][] = "Проверьте правильность номера $number.";
            } else {
                $result[] = $plot;
            }
        }

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }

        return $result;
    }

    /**
     * Gets Plot data from BigLand API by given Plot numbers.
     *
     * @param iterable $plotNumbers Plot numbers.
     *
     * @throws Illuminate\Http\Client\RequestException if API response with
     *                                                 status code 400 on given
     *                                                 Plot numbers.
     *
     * @return array Plot data.
     */
    public static function getPlotsFromBiglandApi($plotNumbers) {
        $query = json_encode(['collection' => ['plots' => $plotNumbers]]);

        return Http::acceptJson()
            ->withBody($query, 'application/json')
            ->get('http://api.pkk.bigland.ru/test/plots')
            ->throw()
            ->json();
    }
}

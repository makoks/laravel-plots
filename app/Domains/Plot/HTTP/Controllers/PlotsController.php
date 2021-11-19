<?php

namespace App\Domains\Plot\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\Plot\Support\PlotParser;

class PlotsController extends Controller
{
    /**
     * Responds with Plots data on request containing Plots numbers.
     *
     * @param Request Http request containing string of Plot numbers separated
     *                by commas.
     *
     * @throws ValidationException if there is no Plot string  or one of the
     *                             Plot numbers is not in the correct format.
     *
     * @return Illuminate\Http\JsonResponse Response with Plot data in JSON
     *                                      format.
     */
    public function index(Request $request) {
        $validated = $request->validate([
            'plots' => 'required|string',
        ]);
        $plotNumbers = Str::of($validated['plots'])->explode(',');

        $plotsData = PlotParser::parsePlots($plotNumbers);

        return response()->json($plotsData, 200);
    }
}

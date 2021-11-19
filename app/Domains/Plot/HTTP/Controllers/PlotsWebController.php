<?php

namespace App\Domains\Plot\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\Plot\Support\PlotParser;

class PlotsWebController extends Controller
{
    /**
     * Responds with Plots data on request containing Plots numbers.
     *
     * @param Request Http request containing string of Plot numbers separated
     *                by commas.
     *
     * @throws ValidationException if at least one of the Plot numbers is not
     *                             in the correct format.
     * @throws Symfony\Component\HttpKernel\Exception\HttpException if API error.
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

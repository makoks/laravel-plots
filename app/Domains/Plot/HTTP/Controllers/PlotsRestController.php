<?php

namespace App\Domains\Plot\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\Plot\Support\PlotParser;
use App\Domains\Plot\Http\Resources\PlotResource;

class PlotsRestController extends Controller
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
     * @return Illuminate\Http\Resources\Json\AnonymousResourceCollection Plot
     *                                                                    data.
     */
    public function index(Request $request) {
        $validated = $request->validate(['plots' => 'required|array']);
        $plotNumbers = $validated['plots'];

        $plotsData = PlotParser::parsePlots($plotNumbers);

        return PlotResource::collection($plotsData);
    }
}

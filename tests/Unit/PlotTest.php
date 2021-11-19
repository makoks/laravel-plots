<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Domains\Plot\Support\PlotParser;

class PlotTest extends TestCase
{
    public function testParsedDataContainsDataOnGivenNumber()
    {
        $givenNumber = '69:27:0000022:1306';

        $parsedPlots = PlotParser::parsePlots([$givenNumber]);
        $parsedNumber = $parsedPlots->first()->number;

        $this->assertEquals($givenNumber, $parsedNumber);
    }
}

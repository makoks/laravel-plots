<?php

namespace App\Domains\Plot\Console\Commands;

use Throwable;
use Illuminate\Console\Command;
use App\Domains\Plot\Support\PlotParser;

class ParsePlots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plots:parse {plots*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses Plots data by given Plot numbers.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(PlotParser $parser)
    {
        try {
            $plotsData = $parser::parsePlots($this->argument('plots'));
            $this->table(['Number', 'Address', 'Price', 'Area'], $plotsData);
            return Command::SUCCESS;

        } catch(Throwable $e) {
            $error = $e->getMessage();
            $this->error($error !== '' ? $error : 'Something went wrong.');
            return Command::FAILURE;
        }
    }
}

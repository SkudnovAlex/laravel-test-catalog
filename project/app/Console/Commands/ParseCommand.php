<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ParseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:site
                            {class : The class for parsing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse site';

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
    public function handle()
    {
        $class = '\\App\\Parser\\' . $this->argument('class');
        if (!class_exists($class)) {
            $this->error($class . " isn't exist");
        }

        $parser = app()->make($class);
        $this->info($parser->run());

        return 0;
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BillGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bill:validateall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->info('La tarea programada se ejecutó con éxito');
        return Command::SUCCESS;
    }
}

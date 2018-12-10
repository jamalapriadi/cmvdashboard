<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReminderSam extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:sam';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Untuk merimender sam yang belum dieksekusi setelah 3 hari';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info("Testing yaa");
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReplicatecekMail;

class ReplicateCek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replicate:cek';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $cek=\DB::select("SHOW SLAVE STATUS");

        if(count($cek)>0){
            $this->info("Ada Error nih, bentar ya kita kirim ke email dulu errornya...");
            foreach($cek as $row){
                if($row->Slave_IO_Running=='No' || $row->Slave_SQL_Running=='No'){
                    Mail::to('jamal.apriadi@mncgroup.com')->send(new ReplicatecekMail($row->Last_Error));
                }
            }
        }else{
            Mail::to('jamal.apriadi@mncgroup.com')->send(new ReplicatecekMail('Sukses'));
            $this->info("Tidak ada kesalah, sukses bray...");
        }
    }
}

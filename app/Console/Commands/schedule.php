<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class schedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minute:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clean db table';

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
        DB::table('prestasi_dosen')->where('deadline', '<=', Carbon::now())->update([
            'is_verification' => 1
        ]);

        DB::table('aktivitas')->where('deadline', '<=', Carbon::now())->update([
            'is_verification' => 1
        ]);

        DB::table('kegiatan')->where('deadline', '<=', Carbon::now())->update([
            'is_verification' => 1
        ]);

        DB::table('data_pkm')->where('deadline', '<=', Carbon::now())->update([
            'is_verification' => 1
        ]);

        DB::table('data_penelitian')->where('deadline', '<=', Carbon::now())->update([
            'is_verification' => 1
        ]);

        DB::table('produk')->where('deadline', '<=', Carbon::now())->update([
            'is_verification' => 1
        ]);

        DB::table('artikel_dosen')->where('deadline', '<=', Carbon::now())->update([
            'is_verification' => 1
        ]);
    }
}

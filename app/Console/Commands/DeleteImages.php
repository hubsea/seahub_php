<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete daily image';

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
        $folderPath = storage_path('app/public/' . date('Ymd', time() - 86400 * 2));
        $publicPath = public_path('storage/' . date('Ymd', time() - 86400 * 2));
        $return = exec('rm -rf ' . $publicPath, $v);
        Storage::deleteDirectory($folderPath);
    }
}

<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PesertaImport;
use Illuminate\Support\Facades\Storage;

class ImportPesertaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function handle()
    {
        $filePath = 'public/' . $this->path;

        // Jalankan import Excel
        Excel::import(new PesertaImport, storage_path('app/' . $filePath));

        // Hapus file setelah selesai diimport
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
    }
}

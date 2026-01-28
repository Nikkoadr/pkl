<?php

namespace App\Jobs;

use ZipArchive;
use App\Models\Peserta;
use Illuminate\Bus\Queueable;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportFotoPesertaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function handle(): void
    {
        // ZIP path (disk public)
        $zipPath = Storage::disk('public')->path($this->path);

        // TEMP path (workspace)
        $extractPath = Storage::disk('public')->path('temp/foto_pkl');

        if (!file_exists($zipPath)) {
            return;
        }

        if (!is_dir($extractPath)) {
            mkdir($extractPath, 0777, true);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath) !== true) {
            return;
        }

        $zip->extractTo($extractPath);
        $zip->close();

        foreach (scandir($extractPath) as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }

            $fullFile = $extractPath . '/' . $file;
            if (!is_file($fullFile)) {
                continue;
            }

            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
                continue;
            }

            $nis = pathinfo($file, PATHINFO_FILENAME);

            $peserta = Peserta::where('nis', $nis)->first();
            if (!$peserta || !$peserta->user_id) {
                continue;
            }

            $user = $peserta->user;
            $filename = $nis . '.' . $ext;

            if (
                $user->foto_profil &&
                Storage::disk('public')->exists('foto_profil/' . $user->foto_profil)
            ) {
                Storage::disk('public')->delete('foto_profil/' . $user->foto_profil);
            }

            Storage::disk('public')->putFileAs(
                'foto_profil',
                new File($fullFile),
                $filename
            );

            $user->update([
                'foto_profil' => $filename,
            ]);
        }

        Storage::disk('public')->delete($this->path);

        foreach (glob($extractPath . '/*') as $file) {
            @unlink($file);
        }

        @rmdir($extractPath);
    }
}

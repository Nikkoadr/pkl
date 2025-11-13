<?php

use App\Models\Tahun_ajaran;

if (!function_exists('tahunAktif')) {
    /**
     * Mengembalikan tahun ajaran yang aktif.
     *
     * @return Tahun_ajaran|null
     */
    function tahunAktif()
    {
        return Tahun_ajaran::where('status', 'aktif')->first();
    }
}

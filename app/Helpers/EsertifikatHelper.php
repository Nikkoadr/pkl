<?php

namespace App\Helpers;

class EsertifikatHelper
{
    public static function predikat($n)
    {
        if ($n >= 90) return 'Sangat Baik';
        if ($n >= 80) return 'Baik';
        if ($n >= 70) return 'Cukup Baik';
        return 'Belum Baik';
    }

    public static function catatan_sikap($nilaiAspek)
    {
        $max = max($nilaiAspek);
        $min = min($nilaiAspek);

        if (self::predikat($max) === self::predikat($min)) {
            return "Selama pelaksanaan PKL, peserta didik menunjukkan capaian sikap yang konsisten pada kategori " .
                self::predikat($max) . ".";
        }

        return "Selama pelaksanaan PKL, peserta didik menunjukkan capaian sikap " .
            self::predikat($max) . " pada aspek " . array_search($max, $nilaiAspek) .
            ", sementara pada aspek " . array_search($min, $nilaiAspek) .
            " berada pada kategori " . self::predikat($min) . ".";
    }
}

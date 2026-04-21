<?php

namespace App\Helpers;

class Terbilang
{
    private static array $satuan = [
        '', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima',
        'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas',
    ];

    public static function convert(int $angka): string
    {
        if ($angka < 0)   return 'Minus ' . self::convert(abs($angka));
        if ($angka < 12)  return self::$satuan[$angka];
        if ($angka < 20)  return self::convert($angka - 10) . ' Belas';
        if ($angka < 100) return self::convert((int) ($angka / 10)) . ' Puluh ' . self::convert($angka % 10);
        if ($angka < 200) return 'Seratus ' . self::convert($angka - 100);
        if ($angka < 1_000) return self::convert((int) ($angka / 100)) . ' Ratus ' . self::convert($angka % 100);
        if ($angka < 2_000) return 'Seribu ' . self::convert($angka - 1_000);
        if ($angka < 1_000_000) return self::convert((int) ($angka / 1_000)) . ' Ribu ' . self::convert($angka % 1_000);
        if ($angka < 1_000_000_000) return self::convert((int) ($angka / 1_000_000)) . ' Juta ' . self::convert($angka % 1_000_000);
        return self::convert((int) ($angka / 1_000_000_000)) . ' Miliar ' . self::convert($angka % 1_000_000_000);
    }

    public static function rupiah(float|int $amount): string
    {
        $result = trim(self::convert((int) round($amount)));
        // collapse multiple spaces
        $result = preg_replace('/\s+/', ' ', $result);
        return '#' . $result . ' Rupiah#';
    }
}

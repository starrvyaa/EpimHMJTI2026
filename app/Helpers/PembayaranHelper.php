<?php

namespace App\Helpers;

class PembayaranHelper
{
    /**
     * Mapping ID kategori_lomba → informasi pembayaran
     */
    public static function getInfo(int $idLomba): array
    {
        $data = [
            1 => [ // Web Programming
                'nominal'   => 75000,
                'bank'      => 'BRI',
                'rekening'  => '1234-5678-9012',
                'an'        => 'JULIANA INTAN',
                'label'     => 'Web Programming',
            ],
            2 => [ // Design Poster
                'nominal'   => 50000,
                'bank'      => 'BRI',
                'rekening'  => '1234-5678-9012',
                'an'        => 'JULIANA INTAN',
                'label'     => 'Design Poster',
            ],
            3 => [ // Design Packaging
                'nominal'   => 50000,
                'bank'      => 'Mandiri',
                'rekening'  => '9876-5432-1098',
                'an'        => 'AGNESS SHERLYTA ANGG',
                'label'     => 'Design Packaging',
            ],
            4 => [ // Videography
                'nominal'   => 50000,
                'bank'      => 'Mandiri',
                'rekening'  => '9876-5432-1098',
                'an'        => 'AGNESS SHERLYTA ANGG',
                'label'     => 'Videography',
            ],
        ];

        return $data[$idLomba] ?? [
            'nominal'   => 0,
            'bank'      => '-',
            'rekening'  => '-',
            'an'        => '-',
            'label'     => 'Unknown',
        ];
    }

    /**
     * Format nominal ke Rupiah
     */
    public static function formatRupiah(int $nominal): string
    {
        return 'Rp ' . number_format($nominal, 0, ',', '.');
    }

    /**
     * Teks lengkap tujuan transfer
     */
    public static function teksTransfer(int $idLomba): string
    {
        $info = self::getInfo($idLomba);
        return $info['bank'] . ' : ' . $info['rekening'] . ' a.n. ' . $info['an'];
    }
}

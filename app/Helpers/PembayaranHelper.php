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
                'nominal'   => 85000,
                'bank'      => 'Mandiri',
                'rekening'  => '1710-0162-8888-1',
                'an'        => 'AGNESS SHERLYTA ANGG',
                'label'     => 'Web Programming',
            ],
            2 => [ // Desain Jaringan (Network Engineering)
                'nominal'   => 85000,
                'bank'      => 'Mandiri',
                'rekening'  => '1710-0162-8888-1',
                'an'        => 'AGNESS SHERLYTA ANGG',
                'label'     => 'Network Engineering',
            ],
            3 => [ // Design Packaging
                'nominal'   => 60000,
                'bank'      => 'Mandiri',
                'rekening'  => '1710-0162-8888-1',
                'an'        => 'AGNESS SHERLYTA ANGG',
                'label'     => 'Design Packaging',
            ],
            4 => [ // Videography
                'nominal'   => 60000,
                'bank'      => 'Mandiri',
                'rekening'  => '1710-0162-8888-1',
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

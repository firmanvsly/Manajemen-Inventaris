<?php

namespace App\Exports;

use App\Models\Inventaris;
use App\Models\InventarisKategori;
use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventarisExport implements FromArray, WithHeadings
{
    protected $request;

    function __construct($request)
    {
        $this->request = $request;
    }

    public function array(): array
    {
        $datas = Inventaris::where('type', $this->request->type);

        if ($this->request->bulan) {
            $datas->whereMonth('created_at', $this->request->bulan);
        }

        if ($this->request->tahun) {
            $datas->whereYear('created_at', $this->request->tahun);
        }

        $datas = $datas->get();

        $datas->map(function ($item, $index) {
            $item->no = $index + 1;
            $id_kategori = InventarisKategori::where('id_inventaris', $item->id)->pluck('id_kategori');
            if ($id_kategori->count()) {
                $kategori = Kategori::whereIn('id', $id_kategori)->pluck('nama_kategori');
                $kategoris = $kategori->implode(', ');
            } else {
                $kategoris = '-';
            }
            return $item->kategori = $kategoris;
        });

        $no = 1;
        foreach ($datas as $data) {
            $inventaris[] = [
                'no'         => $no++,
                'nama'       => $data->nama,
                'kategori'   => $data->kategori,
                'jumlah'     => $data->jumlah,
                'kondisi'    => $data->kondisi,
                'ketarangan' => $data->keterangan
            ];
        }

        return $inventaris;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Kategori',
            'Jumlah',
            'Kondisi',
            'Keterangan'
        ];
    }
}

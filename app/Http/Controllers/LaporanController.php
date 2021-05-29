<?php

namespace App\Http\Controllers;

use App\Exports\InventarisExport;
use App\Models\Inventaris;
use App\Models\InventarisKategori;
use App\Models\Kategori;
use Illuminate\Http\Request;
use PDF;
use Excel;

class LaporanController extends Controller
{
    public function index()
    {
        return view('pages.laporan.index');
    }

    public function pdf(Request $request)
    {
        $request->validate([
            'type' => 'required'
        ], [
            'type.required' => 'Inventaris harus diisi!'
        ]);

        $type = ucwords($request->type);
        $data = $this->_filter($request);
        $pdf = PDF::loadView('pages.laporan.pdf', ['type' => $type, 'data' => $data]);
        return $pdf->download('Inventaris-' . $type . '.pdf');
    }
    
    public function excel(Request $request)
    {
        $type = ucwords($request->type);
        return Excel::download(new InventarisExport($request), 'Inventaris-' . $type . '.xlsx');
    }

    private function _filter($request)
    {
        $data = Inventaris::where('type', $request->type);

        if ($request->bulan) {
            $data->whereMonth('created_at', $request->bulan);
        }

        if ($request->tahun) {
            $data->whereYear('created_at', $request->tahun);
        }

        $data = $data->get();

        $data->map(function ($item) {
            $id_kategori = InventarisKategori::where('id_inventaris', $item->id)->pluck('id_kategori');
            if ($id_kategori->count()) {
                $kategori = Kategori::whereIn('id', $id_kategori)->pluck('nama_kategori');
                $kategoris = $kategori->implode(', ');
            } else {
                $kategoris = '-';
            }
            return $item->kategori = $kategoris;
        });

        return $data;
    }
}

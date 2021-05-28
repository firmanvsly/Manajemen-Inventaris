<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\InventarisKategori;
use App\Models\Kategori;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kategori = Kategori::all();
        if (!$kategori->count()) {
            return redirect()->route('kategori.index')->with('info','Tambah Kategori Terlebih Dahulu');
        }
        if ($request->ajax()) {
            $data = Inventaris::barang()->latest()->get();
            return datatables()->of($data)
                ->editColumn('kondisi', '{{ ucwords($kondisi) }}')
                ->addColumn('kategori', function ($data) {
                    $kategori = InventarisKategori::where('id_inventaris',$data->id)->get();
                    if ($kategori->count()) {
                        $kategoris = '';
                        foreach ($kategori as $k) {
                            $kategoris .= '<span class="badge badge-secondary">'.$k->kategori->nama_kategori.'</span>&nbsp;';
                        }
                    }else{
                        $kategoris = '-';
                    }

                    return $kategoris;
                })
                ->addColumn('action', function ($data) {
                    $button = '<a href="/barang/' . $data->id . '/edit" class="text-warning" data-toggle="tooltip" data-placement="top" title="Ubah Barang"><i class="fa fa-edit"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="#" data-id="' . $data->id . '" class="text-danger btn-delete" data-toggle="tooltip" data-placement="top" title="Hapus Barang"><i class="fa fa-trash-o"></i></a>';
                    // $button .= '<button onclick="deletedatainstansi('.$data->id_instansi.')" class="btn btn-danger">Hapus</button>';
                    return $button;
                })
                ->rawColumns(['kategori','action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('pages.barang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Kategori::all();
        if (!$kategori->count()) {
            return redirect()->route('kategori.index')->with('info','Tambah Kategori Terlebih Dahulu');
        }
        
        return view('pages.barang.create',compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'nama' => 'required|max:255',
            'kategori' => 'required',
            'jumlah' => 'required|numeric|digits_between:1,4|min:0',
            'kondisi' => 'required',
            'keterangan' => 'required|max:255',
        ]);

        $barang = Inventaris::create($request->all());
        for ($i=0; $i < count($request->kategori); $i++) { 
            $kategori[] = [
                'id_inventaris' => $barang->id,
                'id_kategori' => $request->kategori[$i],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }
        InventarisKategori::insert($kategori);
        return redirect()->route('barang.index')->with('success','Barang Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategori = Kategori::all();
        if (!$kategori->count()) {
            return redirect()->route('kategori.index')->with('info','Tambah Kategori Terlebih Dahulu');
        }
        
        $data = Inventaris::findOrFail($id);

        $kategori->map(function($item) use($data) {
            $ik = InventarisKategori::where('id_inventaris',$data->id)
                ->where('id_kategori',$item->id)
                ->first();

            if ($ik){
                return $item->checked = 1;
            }else{
                return $item->checked = 0;
            }
        });

        return view('pages.barang.edit',compact('data','kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required',
            'nama' => 'required|max:255',
            'jumlah' => 'required|numeric|digits_between:1,4|min:0',
            'kondisi' => 'required',
            'keterangan' => 'required|max:255',
        ]);

        $barang             = Inventaris::find($id);
        $barang->nama       = $request->nama;
        $barang->jumlah     = $request->jumlah;
        $barang->kondisi    = $request->kondisi;
        $barang->keterangan = $request->keterangan;
        $barang->save();

        InventarisKategori::where('id_inventaris',$id)->delete();

        for ($i=0; $i < count($request->kategori); $i++) { 
            $kategori[] = [
                'id_inventaris' => $barang->id,
                'id_kategori' => $request->kategori[$i],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        InventarisKategori::insert($kategori);

        return redirect()->route('barang.index')->with('success','Barang Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Inventaris::find($id);
        $data->inventaris_kategori()->delete();
        $data->delete();
    }
}

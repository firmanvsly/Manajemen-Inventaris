<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\InventarisKategori;
use App\Models\Kategori;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RuanganController extends Controller
{
    private function _checkRole($permission)
    {
        if (!Auth::user()->hasPermission('ruangan', $permission)) {
            abort(404);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->_checkRole('read');
        if ($request->ajax()) {
            $data = Inventaris::ruangan()->latest()->get();
            return datatables()->of($data)
                ->editColumn('kondisi', '{{ ucwords($kondisi) }}')
                ->addColumn('kategori', function ($data) {
                    $kategori = InventarisKategori::where('id_inventaris', $data->id)->get();
                    if ($kategori->count()) {
                        $kategoris = '';
                        foreach ($kategori as $k) {
                            $kategoris .= '<span class="badge badge-secondary">' . $k->kategori->nama_kategori . '</span>&nbsp;';
                        }
                    } else {
                        $kategoris = '-';
                    }

                    return $kategoris;
                })
                ->addColumn('action', function ($data) {
                    $button = '';
                    if (Auth::user()->hasPermission('ruangan', 'update')) {
                        $button .= '<a href="/ruangan/' . $data->id . '/edit" class="text-warning" data-toggle="tooltip" data-placement="top" title="Ubah ruangan"><i class="fa fa-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                    }
                    if (Auth::user()->hasPermission('ruangan', 'delete')) {
                        $button .= '<a href="#" data-id="' . $data->id . '" class="text-danger btn-delete" data-toggle="tooltip" data-placement="top" title="Hapus ruangan"><i class="fa fa-trash-o"></i></a>';
                    }
                    // $button .= '<button onclick="deletedatainstansi('.$data->id_instansi.')" class="btn btn-danger">Hapus</button>';
                    return $button;
                })
                ->rawColumns(['kategori', 'action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('pages.ruangan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->_checkRole('create');
        $kategori = Kategori::all();

        return view('pages.ruangan.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->_checkRole('create');
        $request->validate([
            'type' => 'required',
            'nama' => 'required|max:255',
            'jumlah' => 'required|numeric|digits_between:1,4|min:0',
            'kondisi' => 'required',
            'keterangan' => 'required|max:255',
        ]);

        $ruangan = Inventaris::create($request->all());
        if ($request->kategori) {
            for ($i = 0; $i < count($request->kategori); $i++) {
                $kategori[] = [
                    'id_inventaris' => $ruangan->id,
                    'id_kategori' => $request->kategori[$i],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            InventarisKategori::insert($kategori);
        }
        return redirect()->route('ruangan.index')->with('success', 'Ruangan Berhasil Ditambahkan!');
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
        $this->_checkRole('update');
        $kategori = Kategori::all();

        $data = Inventaris::findOrFail($id);

        $kategori->map(function ($item) use ($data) {
            $ik = InventarisKategori::where('id_inventaris', $data->id)
                ->where('id_kategori', $item->id)
                ->first();

            if ($ik) {
                return $item->checked = 1;
            } else {
                return $item->checked = 0;
            }
        });

        return view('pages.ruangan.edit', compact('data', 'kategori'));
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
        $this->_checkRole('update');
        $request->validate([
            'type' => 'required',
            'nama' => 'required|max:255',
            'jumlah' => 'required|numeric|digits_between:1,4|min:0',
            'kondisi' => 'required',
            'keterangan' => 'required|max:255',
        ]);

        $ruangan             = Inventaris::find($id);
        $ruangan->nama       = $request->nama;
        $ruangan->jumlah     = $request->jumlah;
        $ruangan->kondisi    = $request->kondisi;
        $ruangan->keterangan = $request->keterangan;
        $ruangan->save();

        InventarisKategori::where('id_inventaris', $id)->delete();

        if ($request->kategori) {
            for ($i = 0; $i < count($request->kategori); $i++) {
                $kategori[] = [
                    'id_inventaris' => $ruangan->id,
                    'id_kategori' => $request->kategori[$i],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }

            InventarisKategori::insert($kategori);
        }

        return redirect()->route('ruangan.index')->with('success', 'Ruangan Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->_checkRole('delete');
        $data = Inventaris::find($id);
        $data->inventaris_kategori()->delete();
        $data->delete();
    }
}

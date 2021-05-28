<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kategori::latest()->get();
            return datatables()->of($data)
                ->addColumn('action', function ($data) {
                    $button = '<a href="/kategori/' . $data->id . '/edit" class="text-warning" data-toggle="tooltip" data-placement="top" title="Ubah Kategori"><i class="fa fa-edit"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="#" data-id="' . $data->id . '" class="text-danger btn-delete" data-toggle="tooltip" data-placement="top" title="Hapus Kategori"><i class="fa fa-trash-o"></i></a>';
                    // $button .= '<button onclick="deletedatainstansi('.$data->id_instansi.')" class="btn btn-danger">Hapus</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('pages.kategori.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.kategori.create');
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
            'nama_kategori' => 'required|max:255|unique:kategori,nama_kategori',
        ]);

        Kategori::create($request->all());
        return redirect()->route('kategori.index')->with('success','Kategori Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Kategori::findOrFail($id);

        return view('pages.kategori.edit',compact('data'));
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
            'nama_kategori' => 'required|max:255|unique:kategori,nama_kategori,'.$id,
        ]);

        $kategori                = Kategori::find($id);
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return redirect()->route('kategori.index')->with('success','Kategori Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Kategori::find($id);
        $data->delete();
    }
}

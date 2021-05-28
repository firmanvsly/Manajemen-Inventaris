<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return datatables()->of($data)
                ->addColumn('role', function($data) {
                    return $data->role->nama_role;
                })
                ->addColumn('action', function ($data) {
                    $button = '<a href="user/' . $data->id . '/edit" class="text-warning" data-toggle="tooltip" data-placement="top" title="Ubah User"><i class="fa fa-edit"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="user/' . $data->id . '/password" class="text-primary" data-toggle="tooltip" data-placement="top" title="Ubah Password"><i class="fa fa-lock"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="#" data-id="' . $data->id . '" class="text-danger btn-delete" data-toggle="tooltip" data-placement="top" title="Hapus User"><i class="fa fa-trash-o"></i></a>';
                    // $button .= '<button onclick="deletedatainstansi('.$data->id_instansi.')" class="btn btn-danger">Hapus</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('pages.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::all();
        return view('pages.user.create', compact('role'));
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
            'name' => 'required|min:3|max:255',
            'username' => 'required|min:3|max:255',
            'password' => 'required|confirmed|min:6|max:255',
            'id_role' => 'required',
        ]);

        User::create($request->all());
        return redirect()->route('user.index')->with('success','User Berhasil Ditambahkan!');
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
        $data = User::findOrFail($id);
        $role = Role::all();

        return view('pages.user.edit',compact('data','role'));
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
            'name' => 'required|min:3|max:255',
            'username' => 'required|min:3|max:255',
            'id_role' => 'required',
        ]);

        $user           = User::find($id);
        $user->name     = $request->name;
        $user->username = $request->username;
        $user->id_role  = $request->id_role;
        $user->save();

        return redirect()->route('user.index')->with('success','User Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::find($id);
        $data->delete();
    }

    public function password($id)
    {
        $data = User::findOrFail($id);
        return view('pages.user.password',compact('data'));
    }

    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6|max:255',
        ]);

        $user           = User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('user.index')->with('success','User Password Berhasil Diubah!');
    }
}

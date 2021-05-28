<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
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
                    if ($data->role->nama_role != 'Owner') {
                        $button .= '<a href="user/' . $data->id . '/permission" class="text-secondary" data-toggle="tooltip" data-placement="top" title="Manage Permission"><i class="fa fa-tasks"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                    }
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
            'username' => 'required|min:3|max:255|unique:users,username',
            'password' => 'required|confirmed|min:6|max:255',
            'id_role' => 'required',
        ]);

        $user = User::create($request->all());

        $this->_makePermission($user);

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
            'username' => 'required|min:3|max:255|unique:users,username,'.$id,
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
        
        Permission::where('id_user',$id)->delete();
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

    public function permission($id)
    {
        $data = User::findOrFail($id);
        if ($data->role->nama_role == 'Owner') {
            abort(404);
        }
        $permissions = Permission::where('id_user',$id)->get();
        $permission = array();
        foreach ($permissions as $p) {
            if ($p->type == 'laporan') {
                $permission[$p->type]['download'] = $p->download;
            }else{
                $permission[$p->type]['create'] = $p->create;
                $permission[$p->type]['read']   = $p->read;
                $permission[$p->type]['update'] = $p->update;
                $permission[$p->type]['delete'] = $p->delete;
            }
        }
        return view('pages.user.permission',compact('data','permission'));
    }

    public function storePermission(Request $request)
    {
        $id_user = $request->id_user;
        
        Permission::where('id_user',$id_user)->delete();

        $data = [];
        if ($request->has('user_create') || $request->has('user_read') || $request->has('user_update')) {
            $data[] = [
                'id_user'  => $id_user,
                'type'     => 'user',
                'create'   => $request->user_create ?? 0,
                'read'     => $request->user_read ?? 0,
                'update'   => $request->user_update ?? 0,
                'delete'   => 0,
                'download' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }
        if ($request->has('barang_create') || $request->has('barang_read') || $request->has('barang_update') || $request->has('barang_delete')) {
            $data[] = [
                'id_user'  => $id_user,
                'type'     => 'barang',
                'create'   => $request->barang_create ?? 0,
                'read'     => $request->barang_read ?? 0,
                'update'   => $request->barang_update ?? 0,
                'delete'   => $request->barang_delete ?? 0,
                'download' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }
        if ($request->has('ruangan_create') || $request->has('ruangan_read') || $request->has('ruangan_update') || $request->has('ruangan_delete')) {
            $data[] = [
                'id_user'  => $id_user,
                'type'     => 'ruangan',
                'create'   => $request->ruangan_create ?? 0,
                'read'     => $request->ruangan_read ?? 0,
                'update'   => $request->ruangan_update ?? 0,
                'delete'   => $request->ruangan_delete ?? 0,
                'download' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }
        if ($request->has('kategori_create') || $request->has('kategori_read') || $request->has('kategori_update') || $request->has('kategori_delete')) {
            $data[] = [
                'id_user'  => $id_user,
                'type'     => 'kategori',
                'create'   => $request->kategori_create ?? 0,
                'read'     => $request->kategori_read ?? 0,
                'update'   => $request->kategori_update ?? 0,
                'delete'   => $request->kategori_delete ?? 0,
                'download' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }
        if ($request->has('laporan')) {
            $data[] = [
                'id_user'  => $id_user,
                'type'     => 'laporan',
                'create'   => 0,
                'read'     => 0,
                'update'   => 0,
                'delete'   => 0,
                'download' => $request->laporan ?? 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        Permission::insert($data);

        return redirect()->route('user.index')->with('success','Permission Berhasil Diubah!');
    }

    private function _makePermission($user) {
        if ($user->role->nama_role == 'Owner') {
            $permission = [
                [
                    'id_user'    => $user->id,
                    'type'       => 'user',
                    'create'     => 1,
                    'read'       => 1,
                    'update'     => 1,
                    'delete'     => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ], [
                    'id_user'    => $user->id,
                    'type'       => 'barang',
                    'create'     => 1,
                    'read'       => 1,
                    'update'     => 1,
                    'delete'     => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ], [
                    'id_user'    => $user->id,
                    'type'       => 'ruangan',
                    'create'     => 1,
                    'read'       => 1,
                    'update'     => 1,
                    'delete'     => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ], [
                    'id_user'    => $user->id,
                    'type'       => 'kategori',
                    'create'     => 1,
                    'read'       => 1,
                    'update'     => 1,
                    'delete'     => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
            ];
        } else if ($user->role->nama_role == 'Manager') {
            $permission = [
                [
                    'id_user'    => $user->id,
                    'type'       => 'user',
                    'create'     => 1,
                    'read'       => 1,
                    'update'     => 1,
                    'delete'     => 0,
                    'download'   => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ], [
                    'id_user'    => $user->id,
                    'type'       => 'barang',
                    'create'     => 1,
                    'read'       => 1,
                    'update'     => 1,
                    'delete'     => 1,
                    'download'   => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ], [
                    'id_user'    => $user->id,
                    'type'       => 'ruangan',
                    'create'     => 1,
                    'read'       => 1,
                    'update'     => 1,
                    'delete'     => 1,
                    'download'   => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ], [
                    'id_user'    => $user->id,
                    'type'       => 'kategori',
                    'create'     => 1,
                    'read'       => 1,
                    'update'     => 1,
                    'delete'     => 1,
                    'download'   => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],[
                    'id_user'    => $user->id,
                    'type'       => 'laporan',
                    'create'     => 0,
                    'read'       => 0,
                    'update'     => 0,
                    'delete'     => 0,
                    'download'   => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
            ];
        } else {
            $permission = [
                [
                    'id_user'    => $user->id,
                    'type'       => 'barang',
                    'create'     => 1,
                    'read'       => 1,
                    'update'     => 1,
                    'delete'     => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ], [
                    'id_user'    => $user->id,
                    'type'       => 'ruangan',
                    'create'     => 1,
                    'read'       => 1,
                    'update'     => 1,
                    'delete'     => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            ];
        }

        Permission::insert($permission);
    }
}

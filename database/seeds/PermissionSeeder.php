<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission')->insert([
            [
                'id_user'    => '1',
                'type'       => 'user',
                'create'     => 1,
                'read'       => 1,
                'update'     => 1,
                'delete'     => 1,
                'download'   => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'id_user'    => '1',
                'type'       => 'barang',
                'create'     => 1,
                'read'       => 1,
                'update'     => 1,
                'delete'     => 1,
                'download'   => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'id_user'    => '1',
                'type'       => 'ruangan',
                'create'     => 1,
                'read'       => 1,
                'update'     => 1,
                'delete'     => 1,
                'download'   => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'id_user'    => '1',
                'type'       => 'kategori',
                'create'     => 1,
                'read'       => 1,
                'update'     => 1,
                'delete'     => 1,
                'download'   => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'id_user'    => '1',
                'type'       => 'laporan',
                'create'     => 0,
                'read'       => 0,
                'update'     => 0,
                'delete'     => 0,
                'download'   => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'id_user'    => '2',
                'type'       => 'user',
                'create'     => 1,
                'read'       => 1,
                'update'     => 1,
                'delete'     => 0,
                'download'   => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'id_user'    => '2',
                'type'       => 'barang',
                'create'     => 1,
                'read'       => 1,
                'update'     => 1,
                'delete'     => 1,
                'download'   => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'id_user'    => '2',
                'type'       => 'ruangan',
                'create'     => 1,
                'read'       => 1,
                'update'     => 1,
                'delete'     => 1,
                'download'   => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'id_user'    => '2',
                'type'       => 'kategori',
                'create'     => 1,
                'read'       => 1,
                'update'     => 1,
                'delete'     => 1,
                'download'   => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'id_user'    => '2',
                'type'       => 'laporan',
                'create'     => 0,
                'read'       => 0,
                'update'     => 0,
                'delete'     => 0,
                'download'   => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'id_user'    => '3',
                'type'       => 'barang',
                'create'     => 1,
                'read'       => 1,
                'update'     => 1,
                'delete'     => 1,
                'download'   => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'id_user'    => '3',
                'type'       => 'ruangan',
                'create'     => 1,
                'read'       => 1,
                'update'     => 1,
                'delete'     => 1,
                'download'   => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}

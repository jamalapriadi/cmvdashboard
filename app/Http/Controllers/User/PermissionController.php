<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(Request $request){
        if($request->has('role')){
            \DB::statement(\DB::raw('set @rownum=0'));
            $role=Role::select('id','name')
                ->with(
                    [
                        'permissions'=>function($q){
                            $q->select(
                                [
                                    'id',
                                    'name'
                                ]
                            );
                        }
                    ]
                )->find($request->input('role'));

            return $role;
        }
    }

    public function store(Request $request){
        $rules=[
            'role'=>'required',
            'name'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi gagal',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $role=Role::find($request->input('role'));
            $permission=Permission::create(['name'=>$request->input('name')]);

            $permission->assignRole($role);

            $data=array(
                'success'=>true,
                'pesan'=>"Data berhasil disimpan",
                'error'=>''
            );
        }

        return $data;
    }

    public function show($id){
        $permission=Permission::findOrFail($id);

        return $permission;
    }

    public function update(Request $request,$id){
        $rules=[
            'name'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi gagal',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $permission=Permission::find($id);
            $permission->name=$request->input('name');
            $permission->save();

            $data=array(
                'success'=>true,
                'pesan'=>"Data berhasil diupdate",
                'error'=>''
            );
        }

        return $data;
    }

    public function destroy(Request $request,$id){
        $rules=[
            'role'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>"Validasi Gagal",
                'error'=>$validasi->errors()->all()
            );
        }else{
            $permission=Permission::find($id);
            $role=Role::find($request->input('role'));

            $permission->removeRole($role);

            $permission->delete();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil dihapus',
                'error'=>''
            );
        }

        return $data;
    }
}
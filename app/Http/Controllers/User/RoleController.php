<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\User;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(){
        \DB::statement(\DB::raw('set @rownum=0'));

        $role=Role::select('id','name','guard_name',
            \DB::raw('@rownum := @rownum + 1 AS no'));

        return \Datatables::of($role)
            ->addColumn('action',function($query){
                $html="<div class='btn-group'>";
                $html.="<a href='".\URL::to('sosmed/role/'.$query->id.'/permission')."' class='btn btn-sm btn-info' kode='".$query->id."' title='Permissions'><i class='icon-gear'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->id."' title='Edit'><i class='fa fa-edit'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->id."' title='Hapus'><i class='fa fa-trash'></i></a>";
                $html.="</div>";

                return $html;
            })
            ->make(true);
    }

    public function store(Request $request){
        $rules=[
            'name'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }else{
            $role = Role::create(['name' => $request->input('name')]);

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil disimpan',
                'error'=>''
            );
        }

        return $data;
    }

    public function show($id){
        $role=Role::findOrFail($id);

        return $role;
    }

    public function update(Request $request,$id){
        $rules=[
            'name'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }else{
            $role=Role::find($id)            
                ->update(
                    [
                        'name'=>$request->input('name')
                    ]
                );

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil disimpan',
                'error'=>''
            );
        }

        return $data;
    }

    public function destroy($id){
        $role=Role::find($id);

        $hapus=$role->delete();

        if($hapus){
            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil dihapus',
                'error'=>''
            );
        }else{
            $data=array(
                'success'=>false,
                'pesan'=>'Data gagal dihapus',
                'error'=>''
            );
        }

        return $data;
    }

    public function list_role_with_permission(){
        $user=\App\User::with('permissions')->find(\Auth::user()->id);
        $role=Role::with('permissions')->get();

        return array(
            'user'=>$user,
            'role'=>$role
        );
    }
}
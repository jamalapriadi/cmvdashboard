<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
    public function index(){
        if(!auth()->user()->can('Read User')){
            return abort('403');
        }

        \DB::statement(\DB::raw('set @rownum=0'));

        $user=User::select('id','name','email','unit_id',
            \DB::raw('@rownum := @rownum + 1 AS no'))
            ->with('unitsosmed')
            ->where('id','<>',auth()->user()->id);

        return \Datatables::of($user)
        ->addColumn('action',function($query){
            $html="<div class='btn-group'>";
            
            $html.="<a href='#' class='btn btn-sm btn-info resetpassword' kode='".$query->id."' title='Reset Password'><i class='icon-reset'></i></a>";

            if(auth()->user()->can('Setting Role')){
                $html.="<a href='".\URL::to('sosmed/user/'.$query->id.'/role')."' class='btn btn-sm btn-success' kode='".$query->id."' title='Role'><i class='icon-gear'></i></a>";
            }

            if(auth()->user()->can('Edit User')){
                $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->id."' title='Edit'><i class='fa fa-edit'></i></a>";
            }
            
            if(auth()->user()->can('Delete User')){
                $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->id."' title='Hapus'><i class='fa fa-trash'></i></a>";
            }
            $html.="</div>";

            return $html;
        })
        ->make(true);

    }

    public function store(Request $request){
        $rules=[
            'unit'=>'required|max:15|regex:/^[a-zA-Z0-9_\- ]*$/',
            'name'=>'required|min:3|max:60|regex:/^[a-zA-Z0-9_\- ]*$/',
            'email'=>'required|min:5|max:45|regex:/^[a-zA-Z0-9_\-@. ]*$/|email|unique:users,email',
            'password'=>'required|min:12|max:18|regex:/^[a-zA-Z0-9_\- ]*$/',
            'password_confirm'=>'required|min:12|max:18|regex:/^[a-zA-Z0-9_\- ]*$/|same:password'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $user=new User;
            $user->name=$request->input('name');
            $user->unit_id=$request->input('unit');
            $user->email=$request->input('email');
            $user->password=bcrypt($request->input('password'));
            
            $simpan=$user->save();

            if($simpan){
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
        }

        return $data;
    }

    public function show($id){
        $user=User::findOrFail($id);
        $unit=\App\Models\Sosmed\Businessunit::select('id','unit_name')->get();

        return array(
            'unit'=>$unit,
            'user'=>$user
        );
    }

    public function update(Request $request,$id){
        $rules=[
            'unit'=>'required|max:15|regex:/^[a-zA-Z0-9_\- ]*$/',
            'name'=>'required|min:5|min:3|max:60|regex:/^[a-zA-Z0-9_\- ]*$/',
            'email'=>'required|max:45|regex:/^[a-zA-Z0-9_\- ]*$/'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $user=User::find($id);
            $user->name=$request->input('name');
            $user->unit_id=$request->input('unit');
            $user->email=$request->input('email');
            $user->password=bcrypt($request->input('password'));
            
            $simpan=$user->save();

            if($simpan){
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
        }

        return $data;
    }

    public function destroy($id){
        $user=User::find($id);

        $hapus=$user->delete();

        if($hapus){
            $data=array(
                'success'=>true,
                'pesan'=>"Data berhasil dihapus",
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

    public function list_role(Request $request,$id){
        $user=User::with('roles')->find($id);

        return $user;
    }

    public function save_role_user(Request $request){
        $rules=['permission'=>'required','user'=>'required'];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi gagal',
                'error'=>''
            );
        }else{
            $user=User::find($request->input('user'));

            $permission=$request->input('permission');
            foreach($permission as $key=>$val){
                $user->givePermissionTo($val);
            }

            $data=array(
                'success'=>true,
                'pesan'=>'Permission berhasil disimpan',
                'error'=>''
            );
        }

        return $data;
    }

    public function hapus_role_user(Request $request){
        $rules=['permission'=>'required','user'=>'required'];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'error'=>''
            );
        }else{
            $user=User::find($request->input('user'));

            $permission=$request->input('permission');

            $user->revokePermissionTo($permission);

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil dihapus',
                'error'=>''
            );
        }
        
        return $data;
    }

    public function user_handle_unit($id){
        $user=User::with('unit')
            ->find($id);

        $unit=\App\Models\Sosmed\Businessunit::all();

        return array(
            'user'=>$user,
            'unit'=>$unit
        );
    }

    public function save_user_handle_unit(Request $request){
        $rules=[
            'user'=>'required',
            'unit'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $user=$request->input('user');
            $unit=$request->input('unit');

            \DB::table('user_handle_unit')
                ->where('user_id',$user)
                ->delete();

            foreach($unit as $key=>$val){
                \DB::table('user_handle_unit')
                    ->insert(
                        [
                            'user_id'=>$user,
                            'business_unit_id'=>$key
                        ]
                    );
            }

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil disimpan',
                'error'=>''
            );
        }

        return $data;
    }

    public function change_password(Request $request){
        if($request->ajax()){
            $rules=[
                'current'=>'required|alpha_num|min:12|max:18',
                'password'=>'required|alpha_num|min:12|max:18',
                'password_confirmation'=>'required|same:password|alpha_num|min:12|max:18'
            ];

            $pesan=[
                'current.required'=>'Current password harus diisi',
                'password.required'=>'Password harus diisi',
                'password_confirmation.required'=>'Confirmasi password harus diisi'
            ];

            $validasi=\Validator::make($request->all(),$rules,$pesan);

            if($validasi->fails()){
                $data=array(
                    'success'=>false,
                    'pesan'=>'Validasi gagal',
                    'error'=>$validasi->errors()->all()
                );
            }else{
                if(\Hash::check($request->input('current'), \Auth::user()->password)){
                    $user=\App\User::find(auth()->user()->id);
                    $user->password=\Bcrypt($request->input('password'));
                    $user->save();

                    $data=array(
                        'success'=>true,
                        'pesan'=>'Password has been change',
                        'error'=>''
                    );

                    \Auth::logout();
                }else{
                    $data=array(
                        'success'=>false,
                        'pesan'=>'Current password wrong',
                        'error'=>''
                    );
                }
            }

            return $data;
        }
    }

    public function list_activity_user(Request $request){
        $act=\App\Models\Sosmed\Activity::select('id','on_page','relasi_id',
            'description','tanggal','follower','insert_user','created_at','updated_at')
            ->orderBy('created_at','desc')
            ->with('user')
            ->get();

        return $act;
    }

    public function recent_login_user(Request $request){
        $user=\App\Userloginactivity::with('user')
            ->orderBy('created_at','desc')
            ->get();

        return $user;
    }

    public function recent_access_log(){
        $log=\DB::table('access_logs as a')
            ->leftJoin('users as b','b.id','=','a.user_id')
            ->select('a.id','b.name','a.path','a.ip_address','a.created_at','a.updated_at')
            ->where('modul','SOSMED')
            ->get();

        return $log;
    }

    public function reset_password(Request $request){
        $rules=[
            'user'=>'required',
            'password'=>'required|alpha_num|min:6|max:18',
            'password_confirmation'=>'required|same:password|alpha_num|min:6|max:18'
        ];

        $pesan=[
            'user.required'=>'Pilih User',
            'password.required'=>'Password harus diisi',
            'password_confirmation.required'=>'Confirmasi password harus diisi'
        ];

        $validasi=\Validator::make($request->all(),$rules,$pesan);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi gagal',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $user=\App\User::find($request->input('user'));
            $user->password=\Bcrypt($request->input('password'));
            $user->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Password has been change',
                'error'=>''
            );
        }

        return $data;
    }
}
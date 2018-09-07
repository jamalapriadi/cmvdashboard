<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Sosmed\Programunit;

class ProgramunitController extends Controller
{
    public function index(Request $request){
        if(!auth()->user()->can('Read Program')){
            return abort('403');
        }

        \DB::statement(\DB::raw('set @rownum=0'));
        $var=Programunit::with('businessunit')
            ->with('sosmed')
            ->select('id','business_unit_id','program_name',
            \DB::raw('@rownum := @rownum + 1 AS no'));

        return \Datatables::of($var)
            ->filter(function($query) use($request){
                if($request->has('unit') && $request->input('unit')!=null){
                    $query->where('business_unit_id',$request->input('unit'));
                }

                if($request->has('group') && $request->input('group')!=null){
                    $group=$request->input('group');

                    $query->whereHas('businessunit',function($q) use($group){
                        $q->where('group_unit_id',$group);
                    });
                }
            })
            ->addColumn('jumsosmed',function($q){
                $jumsosmed=count($q->sosmed);
                if(auth()->user()->can('Update Sosmed Program')){
                    if($jumsosmed>=4){
                        return "<label class='label label-danger editsosmed' kode='".$q->id."'>".count($q->sosmed)." Sosmed Account</label>";
                    }else if($jumsosmed>=3){
                        return "<label class='label label-success editsosmed' kode='".$q->id."'>".count($q->sosmed)." Sosmed Account</label>";
                    }else if($jumsosmed>=2){
                        return "<label class='label label-warning editsosmed' kode='".$q->id."'>".count($q->sosmed)." Sosmed Account</label>";
                    }else{
                        return "<label class='label label-info editsosmed' kode='".$q->id."'>".count($q->sosmed)." Jumlah Sosmed</label>";
                    }
                }else{
                    return "<label class='label label-default' disabled>".$jumsosmed." Jumlah Sosmed</label>";
                }
            })
            ->addColumn('action',function($query){
                $html="<div class='btn-group'>";
                if(auth()->user()->can('Summary Program')){
                    $html.="<a href='".\URL::to('sosmed/program/'.$query->id.'/summary')."' class='btn btn-sm btn-success' kode='".$query->id."' title='Summary'><i class='icon-stats-dots'></i></a>";
                }

                if(auth()->user()->can('Edit Program')){
                    $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->id."' title='Edit'><i class='fa fa-edit'></i></a>";
                }

                if(auth()->user()->can('Delete Program')){
                    $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->id."' title='Hapus'><i class='fa fa-trash'></i></a>";
                }

                $html.="</div>";

                return $html;
            })
            ->rawColumns(['jumsosmed','action'])
            ->make(true);
    }

    public function store(Request $request){
        $rules=[
            'unit'=>'required|max:30',
            'name'=>'required|max:30',
            'sosmed'=>'required|array|min:3',
            'sosmed.*'=>'nullable|string|min:3|max:60'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $var=new Programunit;
            $var->business_unit_id=$request->input('unit');
            $var->program_name=$request->input('name');

            $simpan=$var->save();

            if($simpan){
                if($request->has('sosmed')){
                    $sosmed=$request->input('sosmed');
                    
                    //add db transaction
                    \DB::transaction(function() use($sosmed,$var){
                        foreach($sosmed as $key=>$val){
                            if($val!=null){
                                $s=new \App\Models\Sosmed\Unitsosmed;
                                $s->type_sosmed="program";
                                $s->business_program_unit=$var->id;
                                $s->sosmed_id=$key;
                                $s->unit_sosmed_name=$val;
                                $s->save();
                            }
                        }
                    });
                }

                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil disimpan',
                    'error'=>''
                );
            }else{
                $data=array(
                    'success'=>false,
                    'pesan'=>'Data gagal disimpan',
                    'error'=>''
                );
            }
        }

        return $data;
    }

    public function edit($id){
        $var=Programunit::find($id);

        return $var;
    }

    public function show($id){
        $var=Programunit::with('sosmed')->findOrFail($id);
        $unit=\App\Models\Sosmed\Businessunit::all();
        $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();

        return array('program'=>$var,'unit'=>$unit,'sosmed'=>$sosmed);
    }

    public function update(Request $request,$id){
        $rules=[
            'unit'=>'required|max:30',
            'name'=>'required|max:30',
            'sosmed'=>'required|array|min:3',
            'sosmed.*'=>'nullable|string|min:3|max:60'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $var=Programunit::find($id);
            $var->business_unit_id=$request->input('unit');
            $var->program_name=$request->input('name');

            $simpan=$var->save();

            if($simpan){
                
                if($request->has('sosmed')){
                    $sosmed=$request->input('sosmed');
                    $tes=array();

                    \DB::transaction(function() use($sosmed,$id){
                        foreach($sosmed as $key=>$val){
                            if($val!=null){
                                $ceksosmed=\App\Models\Sosmed\Unitsosmed::where('sosmed_id',$key)
                                    ->where('business_program_unit',$id)
                                    ->where('type_sosmed','program')
                                    ->first();
                                
                                if($ceksosmed!=null){
                                    $s=\App\Models\Sosmed\Unitsosmed::find($ceksosmed->id);
                                    $s->type_sosmed="program";
                                    $s->unit_sosmed_name=$val;
                                    $s->save();
                                }else{
                                    $s=new \App\Models\Sosmed\Unitsosmed;
                                    $s->type_sosmed="program";
                                    $s->business_program_unit=$id;
                                    $s->sosmed_id=$key;
                                    $s->unit_sosmed_name=$val;
                                    $s->save();
                                }
                            }   
                        }
                    });

                }

                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil update',
                    'error'=>''
                );
            }else{
                $data=array(
                    'success'=>false,
                    'pesan'=>'Data gagal disimpan',
                    'error'=>''
                );
            }
        }

        return $data;
    }

    public function destroy($id){
        $var=Programunit::find($id);

        $hapus=$var->delete();

        if($hapus){
            $s=\App\Models\Sosmed\Unitsosmed::where('type_sosmed','program')
                ->where('business_program_unit',$id)
                ->delete();

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

    public function target(Request $request,$id){
        if($request->has('type')){
            $type=$request->input('type');
            switch($type){
                case 'corporate':
                        $program=\App\Models\Sosmed\Businessunit::with('sosmed','sosmed.sosmed','sosmed.target')->find($id);
                    break;
                case 'program':
                        $program=Programunit::with('sosmed','sosmed.sosmed','sosmed.target')->find($id);
                    break;
            }
        }else{
            $program=Programunit::with('sosmed','sosmed.sosmed','sosmed.target')->find($id);
        }

        return $program;
    }

    public function save_target_program(Request $request){
        $rules=[
            'tahun'=>'required',
            'sosmed'=>'required',
            'target'=>'required|max:30|regex:/^[a-zA-Z0-9_\- ]*$/'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{

            $cektarget=\App\Models\Sosmed\Unitsosmedtarget::where('unit_sosmed_id',$request->input('sosmed'))
                ->where('tahun',$request->input('tahun'))
                ->first();

            if($cektarget!=null){
                $updatetarget=\App\Models\Sosmed\Unitsosmedtarget::where('unit_sosmed_id',$request->input('sosmed'))
                ->where('tahun',$request->input('tahun'))
                ->update(
                    [
                        'target'=>$request->input('target')
                    ]
                );

                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil diupdate',
                    'error'=>''
                );
            }else{
                $newtarget=new \App\Models\Sosmed\Unitsosmedtarget;
                $newtarget->unit_sosmed_id=$request->input('sosmed');
                $newtarget->tahun=$request->input('tahun');
                $newtarget->target=$request->input('target');
                $newtarget->save();

                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil disimpan',
                    'error'=>''
                );
            }
        }

        return $data;
    }

    public function list_target_by_unit_sosmed($id){
        $target=\App\Models\Sosmed\Unitsosmedtarget::where('unit_sosmed_id',$id)
            ->get();

        return $target;
    }

    public function use_target_program(Request $request,$id){
        $rules=[
            'set'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>''
            );
        }else{
            $unit=\App\Models\Sosmed\Unitsosmed::find($id);
            $unit->target_use=$request->input('set');
            $unit->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Set target sukses',
                'error'=>''
            );
        }

        return $data;
    }

    public function list_program_by_unit($id){
        $program=Programunit::where('business_unit_id',$id)
            ->get();

        return $program;
    }

    public function list_sosmed_by_id(Request $request){
        $unit=\App\Models\Sosmed\Unitsosmed::with('sosmed');

        if($request->has('type')){
            $type=$request->input('type');

            $unit=$unit->where('type_sosmed',$type);
            
            switch($type){
                case 'program':
                        $unit=$unit->where('business_program_unit',$request->input('program'));
                    break;
                case 'coprorate':
                        $unit=$unit->where('business_program_unit',$request->input('unit'));
                    break;
            }
        }

        $unit=$unit->get();

        return $unit;
    }

    public function list_sosmed_by_unit(Request $request,$id){
        $unit=\App\Models\Sosmed\Businessunit::with('sosmed','sosmed.sosmed')->find($id);

        return $unit;
    }

    public function list_sosmed_by_program(Request $request,$id){
        $sekarang=date('Y-m-d');
        $kemarin = date('Y-m-d', strtotime('-7 day', strtotime($sekarang)));

        $type=$request->input('type');

        switch($type){
            case 'program':
                    $unit=\App\Models\Sosmed\Programunit::with(
                        [
                            'sosmed',
                            'sosmed.sosmed',
                            'sosmed.followers'=>function($q) use($sekarang,$kemarin){
                                $q->whereBetween('tanggal',[$kemarin,$sekarang]);
                            }
                        ]
                    )->find($id);
                break;
            case 'corporate':
                    $unit=\App\Models\Sosmed\Businessunit::with(
                        [
                            'sosmed',
                            'sosmed.sosmed',
                            'sosmed.followers'=>function($q) use($sekarang,$kemarin){
                                $q->whereBetween('tanggal',[$kemarin,$sekarang]);
                            }
                        ]
                    )->find($id);
                break;
        }

        return array(
            'unit'=>$unit,
            'kemarin'=>$kemarin,
            'sekarang'=>$sekarang
        );
    }

    public function cek_daily_report(Request $request){
        $rules=[
            'tanggal'=>'required',
            'unit'=>'required',
            'sosmed'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $list=array();
            $sosmed=$request->input('sosmed');
            foreach($sosmed as $key=>$val){
                array_push($list,$key);
            }
            
            $cekfollower=\App\Models\Sosmed\Unitsosmedfollower::where('tanggal',date('Y-m-d',strtotime($request->input('tanggal'))))
                ->whereIn('unit_sosmed_id',$list)
                ->get();

            if(count($cekfollower)>0){
                $data=array(
                    'success'=>false,
                    'pesan'=>'You have stored the data for today!',
                    'error'=>''
                );
            }else{
                $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));

                $datasekarang=array();
                $official=array();
                foreach($sosmed as $k=>$v){
                    $official[]=array(
                        'unit_sosmed_id'=>$k,
                        'sosmed_name'=>$request->input('official')[$k]
                    );

                    if($request->input('last')[$k]>0){
                        $l=($v/$request->input('last')[$k]-1)*100;
                    }else{
                        $l=0;
                    }

                    $datasekarang[]=array(
                        'unit_sosmed_id'=>$k,
                        'tanggal'=>date('Y-m-d',strtotime($request->input('tanggal'))),
                        'last'=>$request->input('last')[$k],
                        'follower'=>$v,
                        'num_of_growth'=>$v-$request->input('last')[$k],
                        'growth'=>$l
                    );
                }

                $datakemarin=\App\Models\Sosmed\Unitsosmedfollower::whereIn('unit_sosmed_id',$list)
                    ->orderBy('tanggal','desc')
                    ->get();

                $data=array(
                    'success'=>true,
                    'pesan'=>'Silahkan cek dulu data anda',
                    'datakemarin'=>$datakemarin,
                    'datasekarang'=>$datasekarang,
                    'tanggal_sekarang'=>$sekarang,
                    'tanggal_kemarin'=>$kemarin,
                    'official'=>$official
                );
            }
            
        }

        return $data;   
    }

    public function save_daily_report(Request $request){
        $rules=[
            'tanggal'=>'required',
            'unit'=>'required',
            'sosmed'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $list=array();
            $sosmed=$request->input('sosmed');
            foreach($sosmed as $key=>$val){
                array_push($list,$key);
            }

            $cekfollower=\App\Models\Sosmed\Unitsosmedfollower::where('tanggal',date('Y-m-d',strtotime($request->input('tanggal'))))
                ->whereIn('unit_sosmed_id',$list)
                ->get();

            if(count($cekfollower)>0){
                $data=array(
                    'success'=>false,
                    'pesan'=>'You have stored the data for today!',
                    'error'=>''
                );
            }else{
                \DB::transaction(function() use($sosmed,$request){
                    foreach($sosmed as $k=>$v){
                        $new=new \App\Models\Sosmed\Unitsosmedfollower;
                        $new->tanggal=date('Y-m-d',strtotime($request->input('tanggal')));
                        $new->unit_sosmed_id=$k;
                        $new->follower=$v;
                        $new->insert_user=\Auth::user()->email;
                        $new->save();
    
                        $update=new \App\Models\Sosmed\Unitsosmedactivity;
                        $update->on_page="Insert Daily Report";
                        $update->relasi_id=$k;
                        $update->description=\Auth::user()->name." Menambah Data Follower";
                        $update->tanggal=date('Y-m-d',strtotime($request->input('tanggal')));
                        $update->follower=$v;
                        $update->insert_user=\Auth::user()->email;
                        $update->save();
                    }
                });

                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil disimpan',
                    'error'=>''
                );
            }
            
        }

        return $data;
    }

    public function daily_report(Request $request){
        if($request->has('periode')){
            $pecah=explode("-", $request->input('periode'));
            $kemarin=date('Y-m-d',strtotime($pecah[0]));
            $sekarang=date('Y-m-d',strtotime($pecah[1]));
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-7 day', strtotime($sekarang)));
        }

        \DB::statement(\DB::raw('set @rownum=0'));

        $user=\App\User::with('unit')->find(auth()->user()->id);

        $listUnit=array();
        if($request->has('unit') && $request->input('unit')!=null){
            array_push($listUnit,$request->input('unit'));
        }else{
            foreach($user->unit as $row){
                array_push($listUnit,$row->id);
            }
        }

        if($request->has('sosmed')){
            $type=$request->input('sosmed');
            switch($type){
                case 'twitter':
                        $sosmed=1;
                    break;
                case 'facebook':
                        $sosmed=2;
                    break;
                case 'instagram':
                        $sosmed=3;
                    break;
                case 'youtube':
                        $sosmed=4;
                    break;
            }
        }else{
            $type="Twitter";
            $sosmed=1;
        }
        
        $program=\DB::table('program_unit')
                ->leftJoin('unit_sosmed',function($join){
                    $join->on('business_program_unit','=','program_unit.id')
                        ->where('type_sosmed','=','program');
                })
                ->leftJoin('unit_sosmed_follower',function($join) use($sekarang,$kemarin){
                    $join->on('unit_sosmed_id','=','unit_sosmed.id')
                        ->whereBetween('tanggal',[$kemarin,$sekarang]);
                })
                ->select(
                    'unit_sosmed_follower.id as idfollower',
                    'program_unit.id',
                    'program_name',
                    'type_sosmed',
                    'sosmed_id',
                    'unit_sosmed_name',
                    'tanggal',
                    'follower'
                )
                ->whereIn('business_unit_id',$listUnit)
                ->where('sosmed_id',$sosmed);

        $daily=\DB::table('business_unit')
                ->leftJoin('unit_sosmed',function($join){
                    $join->on('business_program_unit','=','business_unit.id')
                        ->where('type_sosmed','=','corporate');
                })
                ->leftJoin('unit_sosmed_follower',function($join) use($sekarang,$kemarin){
                    $join->on('unit_sosmed_id','=','unit_sosmed.id')
                        ->whereBetween('tanggal',[$kemarin,$sekarang]);
                })
                ->select(
                    'unit_sosmed_follower.id as idfollower',
                    'business_unit.id',
                    'unit_name',
                    'type_sosmed',
                    'sosmed_id',
                    'unit_sosmed_name',
                    'tanggal',
                    'follower'
                )
                ->whereIn('business_unit.id',$listUnit)
                ->where('sosmed_id',$sosmed)
                ->union($program)
                ->get();

        return view('sosmed.view.daily_report')
                ->with('daily',$daily)
                ->with('sosmed',$sosmed);
    }

    public function daily_report_by_id($id){
        $daily=\App\Models\Sosmed\Unitsosmedfollower::with(
            [
                'unitsosmed',
                'unitsosmed.businessunit',
                'unitsosmed.sosmed',
                'unitsosmed.program',
                'unitsosmed.program.businessunit'
            ]
        )->find($id);

        return $daily;
    }

    public function daily_report_update(Request $request,$id){
        $rules=[
            'tanggal'=>'required',
            'type'=>'required',
            'follower'=>'required|regex:/^[a-zA-Z0-9_\- ]*$/',
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            \DB::transaction(function () use($request,$id){
                $old=\App\Models\Sosmed\Unitsosmedfollower::find($id);
                $new=\App\Models\Sosmed\Unitsosmedfollower::find($id);
                $new->tanggal=date('Y-m-d',strtotime($request->input('tanggal')));
                $new->follower=$request->input('follower');
                $new->update_user=\Auth::user()->email;

                $update=new \App\Models\Sosmed\Unitsosmedactivity;
                $update->on_page="Daily Report";
                $update->relasi_id=$id;
                $update->description=\Auth::user()->name." Mengupdate Data Follower";
                $update->tanggal=$old->tanggal;
                $update->follower=$old->follower;
                $update->insert_user=\Auth::user()->email;
                $update->save();

                $new->save();
            });

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil disimpan',
                'error'=>''
            );
            
        }

        return $data;
    }

    public function daily_report_destroy($id){
        $new=\App\Models\Sosmed\Unitsosmedfollower::find($id);

        $hapus=$new->delete();

        if($hapus){
            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil dihapus',
                'error'=>''
            );
        }else{
            $data=array(
                'success'=>false,
                'pesan'=>'Data gagal berhasil dihapus',
                'error'=>''
            );
        }

        return $data;
    }

    public function daily_report_sample(Request $request){
        $unitsosmed=\App\Models\Sosmed\Unitsosmed::select('id','type_sosmed','business_program_unit','sosmed_id','unit_sosmed_name','target_use')
            ->get();

        $unitfollower=\App\Models\Sosmed\Unitsosmedfollower::select('id','unit_sosmed_id','tanggal','follower')->limit(5)->get();

        return \Excel::create('daily report'.date('Y-m-d H:i:s'),function($excel) use($unitsosmed,$unitfollower){
            $excel->sheet('sheet1',function($sheet) use($unitfollower){
                $sheet->fromArray($unitfollower);
            });

            $excel->sheet('unit_sosmed',function($sheet) use($unitsosmed){
                $sheet->fromArray($unitsosmed);
            });
            

        })->export('xlsx');
    }

    public function daily_report_import(Request $request){
        $rules=['file'=>'required'];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $file=$request->file('file');

            $excels=\Excel::selectSheets('sheet1')->load($file,function($reader){})->get();

            $list=array();
            foreach($excels as $key=>$val){
                array_push($list,$val['unit_sosmed_id']);
            }

            $pesan=array();

            \DB::transaction(function() use($excels){
                foreach($excels as $k=>$v){
                    $cekfollower=\App\Models\Sosmed\Unitsosmedfollower::where('tanggal',date('Y-m-d',strtotime($v['tanggal'])))
                        ->where('unit_sosmed_id',$val['unit_sosmed_id'])
                        ->get();
                    
                    if(count($cekfollower)>0){
                        continue;
                    }
    
                    $new=new \App\Models\Sosmed\Unitsosmedfollower;
                    $new->tanggal=date('Y-m-d',strtotime($v['tanggal']));
                    $new->unit_sosmed_id=$v['unit_sosmed_id'];
                    $new->follower=$v['follower'];
                    $new->insert_user=\Auth::user()->email;
                    $new->save();
                }
            });              

            $data=array(
                'success'=>true,
                'pesan'=>$pesan,
                'error'=>''
            );
        }

        return $data;
    }

    public function all_target(Request $request,$id){
        if($request->has('type')){
            $type=$request->input('type');
            switch($type){
                case 'corporate':
                        $program=\App\Models\Sosmed\Businessunit::with('sosmed','sosmed.sosmed','sosmed.target')->find($id);
                    break;

                case 'program':
                        $program=Programunit::with('sosmed','sosmed.sosmed','sosmed.alltarget')->find($id);
                    break;
            }
        }else{
            $program=Programunit::with('sosmed','sosmed.sosmed','sosmed.alltarget')->find($id);
        }

        $data=array();
        $targetsosmed=array();

        foreach($program->sosmed as $key=>$val){
            array_push($targetsosmed,$val->id);
        }

        $target=\App\Models\Sosmed\Unitsosmedtarget::with('unitsosmed','unitsosmed.sosmed')
            ->whereIn('unit_sosmed_id',$targetsosmed)
            ->get();

        $tahuntarget=\App\Models\Sosmed\Unitsosmedtarget::select('tahun')
            ->whereIn('unit_sosmed_id',$targetsosmed)
            ->groupBy('tahun')
            ->get();

        $listtahun=array();
        
        foreach($tahuntarget as $t){
            array_push($listtahun,$t->tahun);
        }

        foreach($listtahun as $p){
            $result=array();
            for($a=0;$a<count($target);$a++){
                if($target[$a]->tahun==$p){
                    array_push($result,array(
                        'sosmed'=>$target[$a]->unitsosmed->sosmed->sosmed_name,
                        'unit_sosmed_name'=>$target[$a]->unitsosmed->unit_sosmed_name,
                        'target'=>$target[$a]->target
                    ));
                }
            }
            $data[]=array(
                'tahun'=>$p,
                'sosmed'=>$result
            );
        }

        return array('program'=>$program,'result'=>$data);
    }

    public function import(Request $request){
        if(auth()->user()->can('Backup Excel')){
            $group=\App\Models\Sosmed\Groupunit::select('id','group_name')->get();

            $unit=\App\Models\Sosmed\Businessunit::select('id','group_unit_id','unit_name')->get();

            $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();

            $var = \App\Models\Sosmed\Programunit::select('id','business_unit_id','program_name')
                ->get();

            $unitsosmed=\App\Models\Sosmed\Unitsosmed::select('id','type_sosmed','business_program_unit','sosmed_id','unit_sosmed_name','target_use')
                ->get();

            $unitfollower=\App\Models\Sosmed\Unitsosmedfollower::select('id','unit_sosmed_id','tanggal','follower')->get();

            $unittarget=\App\Models\Sosmed\Unitsosmedtarget::select('id','unit_sosmed_id','tahun','target')->get();

            return \Excel::create('backup'.date('Y-m-d H:i:s'),function($excel) use($var,$unitsosmed,$group,$unit,$sosmed,$unitfollower,$unittarget){
                $excel->sheet('group',function($sheet) use($group){
                    $sheet->fromArray($group);
                });

                $excel->sheet('unit',function($sheet) use($unit){
                    $sheet->fromArray($unit);
                });

                $excel->sheet('sosmed',function($sheet) use($sosmed){
                    $sheet->fromArray($sosmed);
                });

                $excel->sheet('program',function($sheet) use($var){
                    $sheet->fromArray($var);
                });

                $excel->sheet('unit_sosmed',function($sheet) use($unitsosmed){
                    $sheet->fromArray($unitsosmed);
                });

                $excel->sheet('unit_sosmedfollower',function($sheet) use($unitfollower){
                    $sheet->fromArray($unitfollower);
                });

                $excel->sheet('unit_sosmedtarget',function($sheet) use($unittarget){
                    $sheet->fromArray($unittarget);
                });

            })->export('xlsx');
        }

        return abort('403');
        
    }

    public function list_official_and_program(Request $request,$id){
        if($request->has('tanggal')){
            $tanggal=date('Y-m-d',strtotime($request->input('tanggal')));
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($tanggal)));
        }else{
            $tanggal=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($tanggal)));
        }

        if($request->has('sosmed')){
            $type=$request->input('sosmed');
            switch($type){
                case 'twitter':
                        $sosmed=1;
                    break;
                case 'facebook':
                        $sosmed=2;
                    break;
                case 'instagram':
                        $sosmed=3;
                    break;
                case 'youtube':
                        $sosmed=4;
                    break;
            }
        }else{
            $type="Twitter";
            $sosmed=1;
        }

        $alltanggal=\DB::select("select total.tanggal from (
            select c.tanggal from business_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id
            where a.id=$id and b.sosmed_id=$sosmed
            group by c.tanggal
            )as total
            order by total.tanggal desc");

        if(count($alltanggal)>0){
            $tgl=date('Y-m-d',strtotime($alltanggal[0]->tanggal));
        }else{
            $tgl=date('Y-m-d');
        }
        
        $account=\DB::select("select 'corporate' as urut,a.id, a.group_unit_id, a.unit_name, 
            b.type_sosmed, b.unit_sosmed_account_id,b.unit_sosmed_name, c.tanggal,
            sum(if(b.sosmed_id=$sosmed,b.id,'')) as idsosmed,
            sum(if(c.tanggal='$tgl' and b.sosmed_id=$sosmed,c.follower,0)) as follower
            from business_unit a
            left join unit_sosmed as b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$tgl'
            where a.id=$id and b.sosmed_id='$sosmed'
            group by a.id
            union all 
            select 'program' as urut,d.id, d.group_unit_id, d.unit_name, 
            b.type_sosmed,b.unit_sosmed_account_id ,b.unit_sosmed_name,c.tanggal, 
            sum(if(b.sosmed_id=$sosmed,b.id,'')) as idsosmed,
            sum(if(c.tanggal='$tgl' and b.sosmed_id=$sosmed, c.follower,0)) as follower
            from program_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$tgl'
            left join business_unit d on d.id=a.business_unit_id
            where d.id=$id and b.sosmed_id='$sosmed'
            group by a.id
            order by id, urut,type_sosmed");

        return view('sosmed.view.add_new_report')
            ->with('account',$account)
            ->with('sosmed',$type)
            ->with('idsosmed',$sosmed);
    }
}
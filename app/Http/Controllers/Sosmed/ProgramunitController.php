<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Sosmed\Programunit;

class ProgramunitController extends Controller
{
    public function index(Request $request){
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
            'unit'=>'required',
            'name'=>'required',
            'sosmed'=>'required'
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

                    foreach($sosmed as $key=>$val){
                        $s=new \App\Models\Sosmed\Unitsosmed;
                        $s->type_sosmed="program";
                        $s->business_program_unit=$var->id;
                        $s->sosmed_id=$key;
                        $s->unit_sosmed_name=$val;
                        $s->save();
                    }
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
            'unit'=>'required',
            'name'=>'required'
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
                    foreach($sosmed as $key=>$val){
                        $ceksosmed=\App\Models\Sosmed\Unitsosmed::where('sosmed_id',$key)
                            ->where('business_program_unit',$id)
                            ->where('type_sosmed','program')
                            ->first();
                        
                        if(count($ceksosmed)>0){
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
            'target'=>'required'
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

            if(count($cektarget)>0){
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
            'type'=>'required',
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
                    'pesan'=>'Anda sudah pernah memasukan data ini',
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

                    $datasekarang[]=array(
                        'unit_sosmed_id'=>$k,
                        'tanggal'=>date('Y-m-d',strtotime($request->input('tanggal'))),
                        'follower'=>$v
                    );
                }

                $datakemarin=\App\Models\Sosmed\Unitsosmedfollower::where('tanggal',$kemarin)
                    ->whereIn('unit_sosmed_id',$list)
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
            'type'=>'required',
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
                    'pesan'=>'Anda sudah pernah memasukan data ini',
                    'error'=>''
                );
            }else{
                foreach($sosmed as $k=>$v){
                    $new=new \App\Models\Sosmed\Unitsosmedfollower;
                    $new->tanggal=date('Y-m-d',strtotime($request->input('tanggal')));
                    $new->unit_sosmed_id=$k;
                    $new->follower=$v;
                    $new->insert_user=\Auth::user()->email;
                    $new->save();
                }

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

        $daily=\App\Models\Sosmed\Unitsosmedfollower::with(
            [
                'unitsosmed',
                'unitsosmed.businessunit',
                'unitsosmed.sosmed',
                'unitsosmed.program',
                'unitsosmed.program.businessunit'
            ]
        )->whereHas('unitsosmed')
        ->select('id','unit_sosmed_id','tanggal',
        'follower','insert_user','update_user',\DB::raw('@rownum := @rownum + 1 AS no'))
        ->whereBetween('tanggal',[$kemarin,$sekarang]);

        if($request->has('type') && $request->input('type')!=null){
            $type=$request->input('type');

            switch($type){
                case 'corporate':
                        if($request->has('unit') && $request->input('unit')!=null){
                            $unit=$request->input('unit');

                            $daily=$daily->whereHas('unitsosmed.businessunit',function($w) use($unit){
                                $w->where('id',$unit);
                            });
                        }
                    break;
                case 'program':
                        if($request->has('program') && $request->input('program')!=null){
                            $program=$request->input('program');

                            $daily=$daily->whereHas('unitsosmed.program',function($r) use($program){
                                $r->where('id',$program);
                            });
                        }
                    break;
                default:

                    break;
            }
        }

        return \DataTables::of($daily)
            ->addColumn('unit',function($q){
                if($q->unitsosmed!=null){
                    if($q->unitsosmed->type_sosmed=="corporate"){
                        if($q->unitsosmed->businessunit!=null){
                            $html=$q->unitsosmed->businessunit->unit_name;
                        }else{
                            $html='-';
                        }
                    }else if($q->unitsosmed->type_sosmed="program"){
                        if($q->unitsosmed->program!=null){
                            $html=$q->unitsosmed->program->businessunit->unit_name;
                        }else{
                            $html='-';
                        }
                    }else{
                        $html="<label class='label label-alert'>Type Sosmed Not Found</label>";
                    }
                }else{
                    $html="<label class='label label-alert'>Unit Sosmed Not Found</label>";
                }

                return $html;
            })
            ->addColumn('program',function($q){
                if($q->unitsosmed!=null){
                    if($q->unitsosmed->type_sosmed=="corporate"){
                        if($q->unitsosmed->businessunit!=null){
                            $html=$q->unitsosmed->businessunit->unit_name;
                        }else{
                            $html='-';
                        }
                    }else if($q->unitsosmed->type_sosmed=="program"){
                        if($q->unitsosmed->program!=null){
                            $html=$q->unitsosmed->program->program_name;
                        }else{
                            $html='-';
                        }
                    }
                }else{
                    $html="<label class='label label-alert'>Salah</label>";
                }

                return $html;
            })
            ->addColumn('follow',function($q){
                if($q->follower!=null){
                    $html=number_format($q->follower,2);
                }else{
                    $html='<label class="label label-danger">Set Follower</label>';
                }

                return $html;
            })
            ->addColumn('action',function($query){
                $html="<div class='btn-group' data-toggle='buttons'>";
                if(auth()->user()->can('Edit Daily Report')){
                    $html.="<a href='#' class='btn btn-sm btn-warning editfollower' kode='".$query->id."' title='Edit'><i class='fa fa-edit'></i></a>";
                }
                
                if(auth()->user()->can('Delete Daily Report')){
                    $html.="<a href='#' class='btn btn-sm btn-danger hapusfollower' kode='".$query->id."' title='Hapus'><i class='fa fa-trash'></i></a>";
                }
                
                $html.="</div>";

                return $html;
            })
            ->rawColumns(['unit','program','follower','action','follow'])
            ->make(true);
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
            'follower'=>'required',
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'error'=>$validasi->errors()->all()
            );
        }else{
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
}
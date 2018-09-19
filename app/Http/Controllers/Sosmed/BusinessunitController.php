<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Sosmed\Businessunit;

class BusinessunitController extends Controller
{
    public function index(Request $request){
        if(!auth()->user()->can('Read Unit')){
            return abort('403');
        }

        \DB::statement(\DB::raw('set @rownum=0'));

        $var=Businessunit::with('groupunit','sosmed')
            ->select('id','group_unit_id','unit_name','type_unit','tier',
            \DB::raw('@rownum := @rownum + 1 AS no'));

        if($request->has('type') && $request->input('type')!=null){
            $var=$var->where('type_unit',$request->input('type'));
        }

        if($request->has('group') && $request->input('group')!=null){
            $group=$request->input('group');

            $var=$var->where('group_unit_id',$group);
        }


        return \Datatables::of($var)
            ->addColumn('jumsosmed',function($q){
                $jumsosmed=count($q->sosmed);
                if(auth()->user()->can('Update Sosmed')){
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

                if(auth()->user()->can('Summary Unit')){
                    $html.="<a href='".\URL::to('sosmed/business-unit/'.$query->id.'/summary')."' class='btn btn-sm btn-success' kode='".$query->id."' title='Summary'><i class='icon-gear'></i></a>";
                }

                if(auth()->user()->can('Edit Unit')){
                    $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->id."' title='Edit'><i class='fa fa-edit'></i></a>";
                }
                
                if(auth()->user()->can('Delete Unit')){
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
            'name'=>'required|max:30',
            'group'=>'required|max:30',
            'type'=>'required|max:30'
            // 'sosmed'=>'required|array|min:3',
            // 'sosmed.*'=>'nullable|string|min:3|max:60'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $var=new Businessunit;
            $var->group_unit_id=$request->input('group');
            $var->type_unit=$request->input('type');
            $var->unit_name=$request->input('name');
            $var->tier=$request->input('tier');

            if($request->hasFile('file')){
                if (!is_dir('uploads/logo/bu/')) {
                    mkdir('uploads/logo/bu/', 0777, TRUE);
                }

                $file=$request->file('file');
                $filename=str_random(5).'-'.$file->getClientOriginalName();
                $destinationPath='uploads/logo/bu/';
                $file->move($destinationPath,$filename);

                $var->logo=$filename;
            }

            $simpan=$var->save();

            if($simpan){

                // if($request->has('sosmed')){
                //     $sosmed=$request->input('sosmed');

                //     foreach($sosmed as $key=>$val){
                //         if($val!=null){
                //             $s=new \App\Models\Sosmed\Unitsosmed;
                //             $s->type_sosmed="corporate";
                //             $s->business_program_unit=$var->id;
                //             $s->sosmed_id=$key;
                //             $s->unit_sosmed_name=$val;
                //             $s->save();
                //         }
                //     }
                // }

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
        $var=Businessunit::with('sosmed')->find($id);

        return $var;
    }

    public function show($id){
        $var=Businessunit::with('sosmed')->findOrFail($id);
        $group=\App\Models\Sosmed\Groupunit::all();
        $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();

        return array('unit'=>$var,'group'=>$group,'sosmed'=>$sosmed);
    }

    public function update(Request $request,$id){
        $rules=[
            'name'=>'required|max:30',
            'group'=>'required|max:30',
            'type'=>'required|max:30'
            // 'sosmed'=>'required|array|min:3',
            // 'sosmed.*'=>'nullable|string|min:3|max:60'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $var=Businessunit::find($id);
            $var->group_unit_id=$request->input('group');
            $var->type_unit=$request->input('type');
            $var->unit_name=$request->input('name');
            $var->tier=$request->input('tier');

            if($request->hasFile('file')){
                if (!is_dir('uploads/logo/bu/')) {
                    mkdir('uploads/logo/bu/', 0777, TRUE);
                }

                $file=$request->file('file');
                $filename=str_random(5).'-'.$file->getClientOriginalName();
                $destinationPath='uploads/logo/bu/';
                $file->move($destinationPath,$filename);
                
                $var->logo=$filename;
            }

            $simpan=$var->save();

            if($simpan){

                // if($request->has('sosmed')){
                //     $sosmed=$request->input('sosmed');

                //     foreach($sosmed as $key=>$val){
                //         if($val!=null){
                //             $ceksosmed=\App\Models\Sosmed\Unitsosmed::where('sosmed_id',$key)
                //                 ->where('business_program_unit',$id)
                //                 ->where('type_sosmed','corporate')
                //                 ->first();
                            
                //             if($ceksosmed!=null){
                //                 $s=\App\Models\Sosmed\Unitsosmed::find($ceksosmed->id);
                //                 $s->type_sosmed="corporate";
                //                 $s->unit_sosmed_name=$val;
                //                 $s->save();
                //             }else{
                //                 $s=new \App\Models\Sosmed\Unitsosmed;
                //                 $s->type_sosmed="corporate";
                //                 $s->business_program_unit=$var->id;
                //                 $s->sosmed_id=$key;
                //                 $s->unit_sosmed_name=$val;
                //                 $s->save();
                //             }
                //         }
                //     }
                // }


                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil diupdate',
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
        $var=Businessunit::find($id);

        $hapus=$var->delete();

        if($hapus){
            $s=\App\Models\Sosmed\Unitsosmed::where('type_sosmed','corporate')
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

    public function list_unit(Request $request){
        $var=Businessunit::select('id','unit_name','group_unit_id');

        if($request->has('group')){
            $var=$var->where('group_unit_id',$request->input('group'));
        }

        if($request->has('typeunit')){
            $var=$var->where('type_unit',$request->input('typeunit'));
        }

        $var=$var->get();

        return $var;
    }

    public function import(Request $request){
        $var = \App\Models\Sosmed\Businessunit::select('id','group_unit_id','unit_name')->get();

        return \Excel::create('unit',function($excel) use($var){
            $excel->sheet('sheet1',function($sheet) use($var){
                $sheet->fromArray($var);
            });
        })->export('xlsx');
    }

    public function growth_unit(Request $request,$id){
        if($request->has('periode')){
            $periode=$request->input('periode');
        }else{
            $periode=date('Y-m');
        }

        $type=$request->input('type');
        switch($type){
            default:
            case 'all':

                break;
            case 'official':
                    $follower=\DB::select("select a.id, a.unit_name,b.sosmed_id, c.tanggal, 
                        @kemarin:=(
                            select cc.follower from business_unit aa
                            left join unit_sosmed bb on bb.business_program_unit=aa.id and bb.type_sosmed='corporate'
                            left join unit_sosmed_follower cc on cc.unit_sosmed_id=bb.id
                            where aa.id=a.id
                            and cc.tanggal < c.tanggal
                            and bb.sosmed_id=b.sosmed_id
                            order by cc.tanggal desc
                            limit 1
                        ) as kemarin,
                        c.follower,
                        ((c.follower / @kemarin) - 1)*100 as growth,
                        (c.follower - @kemarin) num_of_growth
                        from business_unit a
                        left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                        left join unit_sosmed_follower c on c.unit_sosmed_id=b.id
                        where a.id=$id
                        and date_format(c.tanggal,'%Y-%m')='$periode'
                        order by a.id");
                break;
            case 'program':
                    $follower=\DB::select("select a.id, a.program_name, b.sosmed_id,c.tanggal, 
                        @kemarin:=(
                            select cc.follower from program_unit aa
                            left join unit_sosmed bb on bb.business_program_unit=aa.id and bb.type_sosmed='program'
                            left join unit_sosmed_follower cc on cc.unit_sosmed_id=bb.id
                            where aa.id=a.id
                            and cc.tanggal < c.tanggal
                            and bb.sosmed_id=b.sosmed_id
                            order by cc.tanggal desc
                            limit 1
                        ) as kemarin,
                        c.follower,
                        ((c.follower / @kemarin) - 1)*100 as growth,
                        (c.follower - @kemarin) num_of_growth
                        from program_unit a
                        left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
                        left join unit_sosmed_follower c on c.unit_sosmed_id=b.id
                        where a.business_unit_id=$id
                        and date_format(c.tanggal,'%Y-%m')='$periode'
                        order by a.id");
                break;
        }

        $unit=\App\Models\Sosmed\Businessunit::find($id);

        return array('follower'=>$follower);
    }
}
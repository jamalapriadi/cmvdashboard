<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Brand\Brandunit;

class BrandunitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $unit=Brandunit::with('brand','advertiser');

        return \Datatables::of($unit)
            ->addColumn('action',function($query){
                $html="<div class='btn-group'>";
                $html.="<a href='".\URL::to('brand/brand-unit/'.$query->id.'/summary')."' class='btn btn-sm btn-success' kode='".$query->id."' title='Summary'><i class='icon-gear'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->id."' title='Edit'><i class='fa fa-edit'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->id."' title='Hapus'><i class='fa fa-trash'></i></a>";
                
                $html.="</div>";

                return $html;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);     
    }

    public function store(Request $request){
        $rules=[
            'name'=>'required',
            'brand'=>'required',
            'advertiser'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Valdiasi gagal',
                'errors'=>$validasi->errors()->all()
            );
        }else{
            $unit=new Brandunit;
            $unit->brand_name_alias=request('name');
            $unit->advertiser_id=request('advertiser');
            $simpan=$unit->save();

            if($simpan){
                $brand=request('brand');

                foreach($brand as $key=>$val){
                    $unit->brand()->attach($val);
                }
                
                $data=array(
                    'success'=>true,
                    'pesan'=>"Data berhasil disimpan",
                    'errors'=>array()
                );
            }else{
                $data=array(
                    'success'=>false,
                    'pesan'=>"Data gagal disimpan",
                    'errors'=>array()
                );
            }
        }

        return $data;
    }

    public function show($id){
        $unit=Brandunit::find($id);

        $var=\App\Models\Brand\Advertiser::select(
            'id_adv',
            'nama_adv',
            'id_typeadv',
            'id_demography',
            'is_group'
        )->get();

        return array('brand'=>$unit,'advertiser'=>$var);
    }

    public function update(Request $request,$id){
        $rules=[
            'name'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Valdiasi gagal',
                'errors'=>$validasi->errors()->all()
            );
        }else{
            $unit=Brandunit::find($id);
            $unit->brand_name_alias=request('name');
            $unit->advertiser_id=request('advertiser');
            $unit->save();

            $data=array(
                'success'=>true,
                'pesan'=>"Data berhasil disimpan",
                'errors'=>array()
            );
        }

        return $data;
    }

    public function destroy($id){
        $unit=Brandunit::find($id);

        $hapus=$unit->delete();

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

    public function save_brand_sosmed(Request $request){
        $rules=[
            'id'=>'required',
            'brand'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
            );
        }else{
            $unit=Brandunit::find(request('id'));

            $brand=request('brand');

            foreach($brand as $key=>$val){
                $unit->brand()->attach($val);
            }

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil disimpan',
                'errors'=>''
            );
        }

        return $data;
    }

    public function show_list_brand(Request $request,$id){
        $unit=Brandunit::with('brand','brand.sector','brand.category')->find($id);

        return $unit;
    }

    public function unit_sosmed_by_brand(Request $request,$id){
        $unit=Brandunit::with(
            [
                'sosmed',
                'sosmed.sosmed'
            ]
        )->find($id);

        return $unit;
    }

    public function unit_sosmed_by_agency(Request $request,$id){
        $unit=\App\Models\Brand\Agency::with(
            [
                'sosmed',
                'sosmed.sosmed'
            ]
        )->find($id);

        return $unit;
    }

    public function unit_sosmed_by_agency_pintu(Request $request,$id)
    {
        $unit=\App\Models\Brand\Agencypintu::with(
            [
                'sosmed',
                'sosmed.sosmed'
            ]
        )->find($id);

        return $unit;
    }

    public function hapus_related_brand(Request $request,$id){
        $unit=Brandunit::find($id);
        $related=request('related');

        $unit->brand()->detach($related);

        $data=array(
            'success'=>true,
            'pesan'=>'Data berhasil dihapus',
            'error'=>''
        );

        return $data;
    }

    public function list_brand_by_sector(Request $request){
        
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

        $daily=\DB::table('brand_unit')
                ->leftJoin('unit_sosmed',function($join){
                    $join->on('business_program_unit','=','brand_unit.id')
                        ->where('type_sosmed','=','brand')
                        ->where('status_active','Y');
                })
                ->leftJoin('unit_sosmed_follower',function($join) use($sekarang,$kemarin){
                    $join->on('unit_sosmed_id','=','unit_sosmed.id')
                        ->whereBetween('tanggal',[$kemarin,$sekarang]);
                })
                ->select(
                    'unit_sosmed_follower.id as idfollower',
                    'brand_unit.id',
                    'brand_name_alias',
                    'type_sosmed',
                    'sosmed_id',
                    'unit_sosmed_name',
                    'tanggal',
                    'follower'
                )
                ->where('sosmed_id',$sosmed);

        if($request->has('advertiser')){
            $daily=$daily->where('advertiser_id',request('advertiser'));
        }

        $daily=$daily->get();

        return view('brand.view.daily_report')
                ->with('daily',$daily)
                ->with('sosmed',$sosmed);
    }

    public function list_unit_sosmed_by_advertiser(Request $request,$id){
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
            select c.tanggal from brand_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='brand'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id
            where a.advertiser_id=$id and b.sosmed_id=$sosmed
            and b.status_active='Y'
            group by c.tanggal
            )as total
            order by total.tanggal desc");

        if(count($alltanggal)>0){
            $tgl=date('Y-m-d',strtotime($alltanggal[0]->tanggal));
        }else{
            $tgl=date('Y-m-d');
        }
        
        $account=\DB::select("select 'brand' as urut,a.id, a.advertiser_id, a.brand_name_alias, 
            b.type_sosmed, b.unit_sosmed_account_id,b.unit_sosmed_name, c.tanggal,
            sum(if(b.sosmed_id=$sosmed,b.id,'')) as idsosmed,
            sum(if(c.tanggal='$tgl' and b.sosmed_id=$sosmed,c.follower,0)) as follower
            from brand_unit a
            left join unit_sosmed as b on b.business_program_unit=a.id and b.type_sosmed='brand'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$tgl'
            where a.advertiser_id=$id and b.sosmed_id='$sosmed'
            and b.status_active='Y'
            group by a.id");

        return view('brand.view.add_new_report')
            ->with('account',$account)
            ->with('sosmed',$type)
            ->with('idsosmed',$sosmed);
    }

    public function cek_save_daily_report(Request $request){
        $rules=[
            'tanggal'=>'required',
            'advertiser'=>'required',
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
            'advertiser'=>'required',
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

    public function list_available_category(){
        $cat=\DB::select("select e.id_category, e.id_sector, f.name_category
            from brand_unit a
            left join brand_unit_detail d on d.brand_id=a.id
            left join intrasm.db_m_brand e on e.id_brand=d.brand_unit_id
            left join intrasm.db_m_category f on f.id_category=e.id_category
            where e.id_category is not null
            group by e.id_category");

        return $cat;
    }

    public function list_available_sector(){
        $sector=\DB::select("select e.id_sector, f.name_sector
            from brand_unit a
            left join brand_unit_detail d on d.brand_id=a.id
            left join intrasm.db_m_brand e on e.id_brand=d.brand_unit_id
            left join intrasm.db_m_sector f on f.id_sector=e.id_sector
            where e.id_sector is not null
            group by e.id_sector");

        return $sector;

    }
}
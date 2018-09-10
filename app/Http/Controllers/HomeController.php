<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Youtube;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->client = new Client([
            'base_uri' => 'graph.facebook.com',
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id="aqilajayaservice";
        $appid="330369550842883";
        $appsecret="ec82b95bd572837b38b2f1525e04970f";
        $json_url ='https://graph.facebook.com/'.$id.'?access_token='.$appid.'|'.$appsecret.'&fields=fan_count';
        $json = file_get_contents($json_url);
        $json_output = json_decode($json);
        //Extract the likes count from the JSON object
        if($json_output->fan_count){
            return $fan_count = $json_output->fan_count;
        }else{
            return 0;
        }

        $group=\App\Models\Sosmed\Groupunit::select('id','group_name')->get();

        return view('sosmed.dashboard')
            ->with('group',$group);
    }

    public function role(){
        if(auth()->user()->can('Read Role')){
            return view('user.role');
        }

        return abort('403');
    }

    public function permission($id){
        $role=Role::with('permissions')->find($id);

        return view('user.permission')
            ->with('role',$role);
    }

    public function user(){
        if(auth()->user()->can('Read User')){
            return view('user.user');
        }else{
            return view('errors.403');
        }
    }

    public function user_role($id){
        if(auth()->user()->can('Setting Role')){
            $sosmed=\App\Models\Sosmed\Sosmed::all();

            return view('user.user_role')
                ->with('id',$id)
                ->with('sosmed',$sosmed);
        }

        return abort('403');
    }

    public function sosmed_group(){
        if(auth()->user()->can('Read Group')){
            return view('sosmed.group');
        }

        return abort('403');
    }

    public function sosmed_unit(){
        if(auth()->user()->can('Read Unit')){
            $group=\App\Models\Sosmed\Groupunit::select('id','group_name')->get();

            return view('sosmed.unit')
                ->with('group',$group);
        }

        return abort('403');
    }

    public function sosmed_media(){
        return view('sosmed.media');
    }

    public function sosmed_program(){
        if(auth()->user()->can('Read Program')){
            $group=\App\Models\Sosmed\Groupunit::select('id','group_name')->get();
            $unit=\App\Models\Sosmed\Businessunit::select('id','unit_name','group_unit_id')->get();

            return view('sosmed.program')
                ->with('group',$group)
                ->with('unit',$unit);
        }

        return abort('403');
    }

    public function sosmed_summary_program($id){
        if(auth()->user()->can('Summary Program')){
            return view('sosmed.summary_program')
                ->with('id',$id);
        }

        return abort('403');
    }

    public function sosmed_summary_bu($id){
        return view('sosmed.summary_bu')
            ->with('id',$id);
    }

    public function sosmed_input_report_harian(){
        if(auth()->user()->can('Read Daily Report')){
            $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();
            $group=\App\Models\Sosmed\Groupunit::select('id','group_name')->get();
            $unit=\App\Models\Sosmed\Businessunit::select('id','unit_name','group_unit_id')->get();
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-7 day', strtotime($sekarang)));

            return view('sosmed.input_report_harian')
                ->with('sosmed',$sosmed)
                ->with('group',$group)
                ->with('unit',$unit)
                ->with('sekarang',$sekarang)
                ->with('kemarin',$kemarin);
        }

        return abort('403');
    }

    public function add_new_report_harian($id){
        if(auth()->user()->can('Add Daily Report')){
            $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();
            $bu=\App\User::with('unit')->find(auth()->user()->id);

            return view('sosmed.add_new_report_harian')
                ->with('sosmed',$sosmed)
                ->with('bu',$bu)
                ->with('id',$id);
        }

        return abort('403');
    }

    public function sosmed_rangking(){
        if(auth()->user()->can('Pdf Rank')){
            $group=\App\Models\Sosmed\Groupunit::select('id','group_name')->get();
            $unit=\App\Models\Sosmed\Businessunit::select('id','unit_name','group_unit_id')->get();
            $sosmed=\App\Models\Sosmed\Sosmed::all();

            return view('sosmed.rangking')
                ->with('group',$group)
                ->with('unit',$unit)
                ->with('sosmed',$sosmed);
        }
        
        return abort('403');
    }

    public function sosmed_daily_report(Request $request){
        if(auth()->user()->can('Pdf Daily Report')){
            if($request->has('tanggal')){
                $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
            }else{
                $sekarang=date('Y-m-d');
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
            }

            $sosmed=\App\Models\Sosmed\Sosmed::all();
            $group=\App\Models\Sosmed\Groupunit::all();
    
            return view('sosmed.daily_report')
                ->with('sekarang',$sekarang)
                ->with('kemarin',$kemarin)
                ->with('sosmed',$sosmed)
                ->with('group',$group);
        }

        return abort('403');
    }

    public function sosmed_ranking_soc_med(Request $request){
        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        $sosmed=\App\Models\Sosmed\Sosmed::all();

        return view('sosmed.ranking_soc_med')
            ->with('sekarang',$sekarang)
            ->with('kemarin',$kemarin)
            ->with('sosmed',$sosmed);
    }

    public function sosmed_chart($param){
        switch($param){
            case 'cross-channel':
                    return view('sosmed.chart.cross_channel');
                break;
            case 'twitter':
            case 'facebook':
            case 'instagram':
                return view('sosmed.chart.twitter')
                    ->with('param',$param);
                break;
            default: 

                break;
        }
    }

    public function official_and_program(Request $request){
        $group=\App\Models\Sosmed\Groupunit::with(
            [
                'unit',
                'unit.sosmed',
                'unit.sosmed.sosmed',
                'unit.sosmed.followers',
            ]
        )->get();

        return $group;
    }

    public function sosmed_input_report(Request $request,$id){
        $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();
        $group=\App\Models\Sosmed\Groupunit::select('id','group_name')->get();
        $user=\App\User::with('unit','unit.groupunit')->find(auth()->user()->id);
        $sekarang=date('Y-m-d');
        $kemarin = date('Y-m-d', strtotime('-7 day', strtotime($sekarang)));

        switch($id){
            case 'twitter':
                    if(!auth()->user()->can('Input Twitter')){
                        return abort('403');
                    }
                break;
            case 'facebook':
                    if(!auth()->user()->can('Input Facebook')){
                        return abort('403');
                    }
                break;
            case 'instagram':
                    if(!auth()->user()->can('Input Instagram')){
                        return abort('403');
                    }
                break;
            case 'youtube':
                    if(!auth()->user()->can('Input Youtube')){
                        return abort('403');
                    }
                break;
            default:

                break;
        }

        return view('sosmed.input_report')
                ->with('sosmed',$sosmed)
                ->with('group',$group)
                ->with('user',$user)
                ->with('sekarang',$sekarang)
                ->with('kemarin',$kemarin)
                ->with('id',$id);
    }

    public function log_login(){
        if(auth()->user()->can('Access Log')){
            return view('sosmed.log.login');
        }

        return abort('403');
    }

    public function log_activity(){
        if(auth()->user()->can('Access Log')){
            return view('sosmed.log.activity');
        }

        return abort('403');
    }

    public function access_log(){
        if(auth()->user()->can('Access Log')){
            return view('sosmed.log.access-log');
        }

        return abort('403');
    }

    public function change_password(){
        return view('user.change_password');
    }

    public function connect_provider($provider){
        return view('sosmed.social.connect_provider')
            ->with('provider',$provider);
    }

    public function instagram_follower($id){
        $raw = file_get_contents('https://www.instagram.com/'.$id); //replace with user
        preg_match('/\"edge_followed_by\"\:\s?\{\"count\"\:\s?([0-9]+)/',$raw,$m);
        return intval($m[1]);
    }

    public function sosmed_input_twitter(){
        return \Twitter::getUserTimeline(['screen_name' => 'ACI_TRANS7', 'count' => 20, 'format' => 'json']);
        $user=\App\User::with(
            [
                'unit',
                'unit.sosmed'=>function($q){
                    $q->where('sosmed_id',4);
                },
                'unit.program',
                'unit.program.sosmed'=>function($q){
                    $q->where('sosmed_id',4);
                }
            ]
        )->find(auth()->user()->id);

        return $user;

        $data=array();
        foreach($user->unit as $key=>$val){
            $sosmed=array();
            foreach($val->sosmed as $row){
                if($row->sosmed_id==1 && $row->business_program_unit!=4){
                    $fol=$this->twitter_follower($row->unit_sosmed_name);
                }elseif($row->sosmed_id==3 && $row->business_program_unit!=4){
                    $fol=$this->instagram_follower($row->unit_sosmed_name);
                }elseif($row->sosmed_id==4  && $row->business_program_unit!=4){
                    $fol=$this->youtube_follower($row->unit_sosmed_name);
                }

                $sosmed[]=array(
                    'sosmed_id'=>$row->sosmed_id,
                    'account_name'=>$row->unit_sosmed_name,
                    'follower'=>$fol
                );
            }
            $data[]=array(
                'unit_name'=>$val->unit_name,
                'sosmed'=>$sosmed
            );
        }

        return $data;
        return $user;
    }

    public function twitter_follower($id){
        $html=file_get_contents("https://twitter.com/".$id);
        preg_match("'followers_count&quot;:(.*?),&quot;'", $html, $match);
        return $title = (int)$match[1];
    }

    public function youtube_follower($id){
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://rctimobile.com/engine/ytsubs.php?id='.$id);

        return $res->getBody();
    }

    public function sosmed_input_facebook(Request $request){
        $token=$request->session()->get('token_facebook');
        // $json = file_get_contents('https://graph.facebook.com/PHP-Developer/103146756409401?access_token='.$token);
        // $obj = json_decode($json);
        // $new_facebook_followers= $obj->data[0]->values[0]->value;
        // return $new_facebook_followers;
        $fpageID = '133529600097002';
        
        $json_url ='https://graph.facebook.com/'.$fpageID.'?access_token='.$token;
        $json = file_get_contents($json_url);
        $json_output = json_decode($json);

        //Extract the likes count from the JSON object
        if($json_output->likes){
            return $likes = $json_output->likes;
        }else{
            return 0;
        }
    }
}

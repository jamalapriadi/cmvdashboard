<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function unit(){
        return view('unit');
    }

    public function brand(){
        return view('brand');
    }

    public function info(){
        phpinfo();
    }

    public function tes_follower(){
        $lis=\App\Models\Sosmed\Unitsosmedfollower::paginate(10000);

        $html="";
        $html.="<table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Unit Sosmed ID</th>
                    <th>Tanggal</th>
                    <th>Follower</th>
                </tr>
            </thead>
            <tbody>";
            $no=0;
            foreach($lis as $row){
                $no++;
                $html.="<tr>
                        <td>".$no."</td>
                        <td>".$row->unit_sosmed_id."</td>
                        <td>".$row->tanggal."</td>
                        <td>".$row->follower."</td>
                    </tr>";
            }
            $html.="</tbody>
        </table>";

        return $html;
    }

    public function tes_facebook(){
        $id="UC_vsErcsq56hOscPHkG-aVw";
        // return \Follower::youtube('UC_vsErcsq56hOscPHkG-aVw');
        $channel = \Youtube::getChannelByID($id);

        $youtube=$channel;

        // return json_encode($channel);
        if(isset($youtube->statistics)){
            return array(
                'subscriber'=>$youtube->statistics->subscriberCount,
                'view_count'=>$youtube->statistics->viewCount,
                'video_count'=>$youtube->statistics->videoCount
            );
        }else{
            return array(
                'subscriber'=>0,
                'view_count'=>0,
                'video_count'=>0
            );
        }
    }

    public function clear_cache(){
        Artisan::call('cache:clear');
        return "Cache is cleared";
    }
}
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
        $id="BigMoviesGTVID";

        // $client = new \GuzzleHttp\Client();
        // $request = $client->get('https://www.facebook.com/'.$id);
        // $response = $request->getBody()->getContents();
    
        // $page = response()->json($response);

        $bu=\DB::select("select a.id, a.unit_name,
                b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, 
                b.unit_sosmed_account_id
                from business_unit a
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                where b.sosmed_id is not null
                and b.status_active='Y'
                and b.sosmed_id=2
                limit 5");

        foreach($bu as $key=>$val)
        {
            $id=$val->unit_sosmed_id;
            
            \DB::table('tarikan_sementara')
                ->delete();

            $crawler = \Goutte::request('GET', 'https://www.facebook.com/'.$val->unit_sosmed_account_id);
            $crawler->filter('._4bl9')->each(function ($node) use($id) {
                // print($node->text());
                // preg_match("'(.*?) orang mengikuti ini'", $node->text(), $match);
                // return $match;

                if (strpos($node->text(), 'orang mengikuti ini') !== false) {
                    \DB::table('tarikan_sementara')
                        ->insert(
                            [
                                'unit_sosmed_id'=>$id,
                                'tanggal'=>date('Y-m-d'),
                                'hasil'=>$node->text(),
                                'created_at'=>date('Y-m-d H:i:s'),
                                'updated_at'=>date('Y-m-d H:i:s')
                            ]
                        );
                }

                $h=\DB::table('tarikan_sementara')->get();

                if(count($h) > 0){
                    $cektanggal=\DB::table('tarikan_sementara_final')->where('tanggal',date('Y-m-d'))
                        ->where('unit_sosmed_id',$id)
                        ->count();

                    if($cektanggal == 0)
                    {
                        $fo = str_replace("orang mengikuti ini","",$h[0]->hasil);
                        $final = str_replace(".","",$fo);
                        
                        \DB::table('tarikan_sementara_final')
                            ->insert(
                                [
                                    'unit_sosmed_id'=>$id,
                                    'tanggal'=>date('Y-m-d'),
                                    'hasil'=>$final,
                                    'created_at'=>date('Y-m-d H:i:s'),
                                    'updated_at'=>date('Y-m-d H:i:s')
                                ]
                            );   
                    }
                }

            });

        }

        
        return "sukses";
    }

    public function clear_cache(){
        Artisan::call('cache:clear');
        return "Cache is cleared";
    }
}
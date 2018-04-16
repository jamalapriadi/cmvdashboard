<?php
namespace App\Http\Middleware;

use Closure;
use DB;
use DateTime;

class AccessLogSosmed
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $cek=DB::table('access_logs')
            ->where('path',$request->path())
            ->where('ip_address',$request->getClientIp())
            ->where('modul','SOSMED')
            ->where(DB::raw("date_format(created_at,'%Y-%m-%d')"),date('Y-m-d'))
            ->get();
        
        if(count($cek)>0){
            
        }else{
            DB::table('access_logs')->insert(
                [
                    'user_id'=>auth()->user()->id,
                    'path'=>$request->path(),
                    'ip_address'=>$request->getClientIp(),
                    'modul'=>'SOSMED',
                    'created_at'=>new DateTime,
                    'updated_at'=>new DateTime,
                ]
            );
        }

        return $response;
    }
}
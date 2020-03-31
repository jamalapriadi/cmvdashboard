<?php

namespace App\Http\Controllers\Sosmed;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sosmed\Crowdtangle;
use App\Imports\ImportCrowdtangle;

class CrowdtangleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model=Crowdtangle::select('*');

        if($request->has('q') && $request->input('q')!=null){
            $model=$model->where('page_name','like','%'.$request->input('q').'%');
        }

        if($request->has('halaman')){
            $halaman=$request->input('halaman');
        }else{
            $halaman=25;
        }

        $model=$model->paginate($halaman);

        return $model;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=['file'=>'required'];
        $pesan=['file.required'=>'File harus diisi'];

        $validasi=\Validator::make($request->all(),$rules,$pesan);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi gagal',
                'errors'=>$validasi->errors()->all()
            );
        }else{
            \Excel::import(new ImportCrowdtangle, request()->file('file'));

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil diimport',
                'error'=>''
            );
        }

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

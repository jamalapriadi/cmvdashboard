@extends('layouts.coreui.main')

@section('content')
    <div class="card">
        <div class="card-header">
            Input Report # {{strtoupper($id)}}
        </div>
        <div class="card-body">
            <form action="">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="control-label">Tanggal</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="icon-calendar5"></i>
                            </span>
                            <input type="text" id="tanggal" name="tanggal" class="form-control daterange-single">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
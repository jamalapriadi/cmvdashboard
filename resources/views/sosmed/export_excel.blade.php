@extends('layouts.coreui.main')

@section('title')
    Dashboard
@endsection

@section('extra-style')
    <style>
        table.floatThead-table {
            border-top: none;
            border-bottom: none;
            background-color: #fff;
        }
        .daterangepicker{z-index:1151 !important;}
        #ui-datepicker-div{z-index:1151 !important;}
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">Export Excel</div>
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active show" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Group</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Official</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="false">Program</a>
                </li>
            </ul>
            
            <div class="tab-content">
                <div class="tab-pane active show" id="home" role="tabpanel">
                    <form class="form-horizontal" target="new target" id="form" action="{{URL::to('sosmed/data/export-excel')}}">
                        <div class="form-group">
                            <label class="col-lg-2">Type Unit</label>
                            <div class="col-lg-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="icon-archive"></i></span>
                                    </div>
                                    <select name="typeunit" id="typeunit" class="form-control">
                                        <option value="">--Pilih Unit--</option>
                                        <option value="TV">TV</option>
                                        <option value="Publisher">Hardnews Portal</option>
                                        <option value="Radio">Radio</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2">Type Account</label>
                            <div class="col-lg-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="icon-archive"></i></span>
                                    </div>
                                    <select name="typeaccount" id="typeaccount" class="form-control">
                                        <option value="" disabled selected>--Pilih Account--</option>
                                        <option value="corporate">Corporate</option>
                                        <option value="program">Program</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                                <label class="col-lg-2">Start Date</label>
                            <div class="col-lg-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                                    </div>
                                    <input class="form-control daterange-single-sekarang" name="start" id="start">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2">End Date</label>
                            <div class="col-lg-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                                    </div>
                                    <input class="form-control daterange-single-sekarang" name="end" id="end">
                                </div>
                            </div>
                        </div>

                        <div class="form-group well">
                            <label class="col-lg-2"></label>
                            <div class="col-lg-4">
                                <button class='btn btn-primary'>    
                                    <i class="icon-file-text2"></i> Export Excel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="profile" role="tabpanel">
                    
                </div>
                <div class="tab-pane" id="messages" role="tabpanel">
                    
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    
@stop
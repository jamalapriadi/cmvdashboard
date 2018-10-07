@extends('layouts.coreui.main')

@section('content')
    <div class="card">
        <div class="card-header">Daily Report {{strtoupper($id)}}</div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="" class="control-label">Brand</label>
                        <select name="brand" id="brand" class="form-control">

                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="" class="control-label">Category</label>
                        <select name="category" id="category" class="form-control">

                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="" class="control-label">Sector</label>
                        <select name="sector" id="sector" class="form-control">

                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="control-label">Periode</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                            <input type="text" name="searchperiode" id="searchperiode" class="form-control daterange-basic" value="10/02/2018 - 10/09/2018"> 
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <button class="btn btn-primary" style="margin-top:25px;">
                            <i class="icon-filter4"></i> Filter 
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <a class="btn btn-primary" href="{{URL::to('brand/add-new-report-daily/'.$id)}}">
                <i class="icon-add"></i> &nbsp;
                Add New Report
            </a>
        </div>
    </div>
@stop
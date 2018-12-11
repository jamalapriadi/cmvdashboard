@extends('layouts.coreui.main')

@section('content')
    <div class="card card-default">
        <div class="card-header">Export Rank Social Media</div>
        <div class="card-body">
            <form class="form-horizontal" action="{{URL::to('sosmed/data/report/pdf-rank-for-sosical-media-all-tv')}}" method="GET" target="new target">
                <div class="form-group row">
                    <label class="col-lg-2">Type Unit</label>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="icon-archive"></i></span>
                            <select name="typeunit" id="typeunit" class="form-control" required>
                                @foreach($typeunit as $row)
                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-2">Social Media</label>
                    <div class="col-lg-4">
                        @foreach($sosmed as $row)
                        <div class="checkbox">
                            <label><input type="checkbox" name="sosmed[]" value="{{$row->id}}" checked="checked">{{$row->sosmed_name}}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-2">Date</label>
                    <div class="col-lg-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                            </div>
                            <input class="form-control daterange-single-sekarang" data-value="{{date('Y/m/d')}}" name="tanggal" id="tanggal">
                        </div>
                    </div>
                </div>
                <div id="anotherDate"></div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="pilih" id="pilih"> <small>check to compare data with another date?</small>
                    </label>
                </div>
                <br>
                <div class="form-group row well">
                    <label class="col-lg-2"></label>
                    <div class="col-lg-4">
                        <button class='btn btn-primary'>
                            <i class="icon-file-pdf"></i> Export PDF
                        </button>
                    </div>
                </div>
            </form>     
        </div>
    </div>

    <div id="divModal"></div>
@stop

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        $(function(){
            var sekarang = new Date();
            var kemarin = new Date(sekarang);
            kemarin.setDate(sekarang.getDate() - 1);

            $('.daterange-single-sekarang').pickadate({ 
                format: 'yyyy/mm/dd',
                formatSubmit: 'yyyy/mm/dd',
                max:true,
            });
            
            $(document).on("click","#pilih",function(){
                if($(this).is(':checked')){
                    var el="";
                    el+='<div class="form-group row">'+
                        '<label class="col-lg-2 control-label">Compare With</label>'+
                        '<div class="col-lg-4">'+
                            '<div class="input-group mb-3">'+
                                '<div class="input-group-prepend">'+
                                    '<span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>'+
                                '</div>'+
                                '<input class="form-control daterange-single-kemarin" data-value="'+kemarin+'" name="kemarin" id="kemarin">'+
                            '</div>'+
                        '</div>'+
                    '</div>';

                    $("#anotherDate").empty().html(el);

                    $('.daterange-single-kemarin').pickadate({ 
                        format: 'yyyy/mm/dd',
                        formatSubmit: 'yyyy/mm/dd',
                        max:true,
                    });
                }else{
                    $("#anotherDate").empty();
                }
            })
        })
    </script>
@stop
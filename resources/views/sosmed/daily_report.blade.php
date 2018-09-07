@extends('layouts.sosmed')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Export Daily Report</div>
        <div class="panel-body">
            <div class="tabbable">
                <ul class="nav nav-tabs nav-tabs-highlight">
                    <li class="active"><a href="#highlight-tab1" data-toggle="tab">ALL</a></li>
                    <li><a href="#highlighted-tab2" data-toggle="tab">BY GROUP</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="highlight-tab1">
                        <form class="form-horizontal" action="{{URL::to('sosmed/data/report/pdf-sosmed-daily-report')}}" method="GET" target="new target">
                            <div class="form-group">
                                <label class="col-lg-2">Type Unit</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="icon-archive"></i></span>
                                        <select name="typeunit" id="typeunit" class="form-control" required>
                                            <option value="TV">TV</option>
                                            <option value="Publisher">Publisher</option>
                                            <option value="Radio">Radio</option>
                                            <option value="KOL">KOL</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2">Social Media</label>
                                <div class="col-lg-4">
                                    @foreach($sosmed as $row)
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="sosmed[]" value="{{$row->id}}" checked="checked">{{$row->sosmed_name}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2">Date</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="icon-calendar"></i></span>
                                        <input class="form-control daterange-single-sekarang" name="tanggal" id="tanggal">
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
                            <div class="form-group well">
                                <label class="col-lg-2"></label>
                                <div class="col-lg-4">
                                    <button class='btn btn-primary'>
                                        <i class="icon-file-pdf"></i> Export PDF
                                    </button>
                                </div>
                            </div>
                        </form>     
                    </div>

                    <div class="tab-pane" id="highlighted-tab2">
                        <form class="form-horizontal" action="{{URL::to('sosmed/data/report/pdf-sosmed-daily-report-by-group')}}" method="GET" target="new target">
                            <div class="form-group">
                                <label for="" class="col-lg-2">Group</label>
                                <div class="col-lg-4">
                                    <select name="group" id="group" class="form-control">
                                        @foreach($group as $row)
                                            <option value="{{$row->id}}">{{$row->group_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-lg-2">Media</label>
                                <div class="col-lg-4">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="media[]" value="TV" checked="checked">TV</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="media[]" value="Publisher" checked="checked">Publisher</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="media[]" value="Radio" checked="checked">Radio</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2">Date</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="icon-calendar"></i></span>
                                        <input class="form-control daterange-single-sekarang2" name="tanggal2" id="tanggal2">
                                    </div>
                                </div>
                            </div>
                            <div id="anotherDate2"></div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="pilih2" id="pilih2"> <small>check to compare data with another date?</small>
                                </label>
                            </div>
                            <br>
                            <div class="form-group well">
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
            </div>
        </div>
    </div>

    <div id="divModal"></div>
@stop

@push('extra-script')
    <script type="text/javascript" src="{{URL::asset('assets/js/core/libraries/jquery_ui/datepicker.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/core/libraries/jquery_ui/effects.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/notifications/jgrowl.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/ui/moment/moment.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/pickers/daterangepicker.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/pickers/anytime.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/pickers/pickadate/picker.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/pickers/pickadate/picker.date.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/pickers/pickadate/picker.time.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/pickers/pickadate/legacy.js')}}"></script>
    <script>
        $(function(){
            var sekarang = new Date();
            var kemarin = new Date(sekarang);
            kemarin.setDate(sekarang.getDate() - 1);

            var sekarang2 = new Date();
            var kemarin2 = new Date(sekarang);
            kemarin2.setDate(sekarang2.getDate() - 1);

            $('.daterange-single-sekarang').datepicker({ 
                singleDatePicker: true,
                selectMonths: true,
                selectYears: true
            });

            $('.daterange-single-sekarang2').datepicker({ 
                singleDatePicker: true,
                selectMonths: true,
                selectYears: true
            });

            $('.daterange-single-sekarang').datepicker('setDate',sekarang);
            $('.daterange-single-sekarang2').datepicker('setDate',sekarang2);
            
            $(document).on("click","#pilih",function(){
                if($(this).is(':checked')){
                    var el="";
                    el+='<div class="form-group">'+
                        '<label class="col-lg-2">Compare With</label>'+
                        '<div class="col-lg-4">'+
                            '<div class="input-group">'+
                                '<span class="input-group-addon"><i class="icon-calendar"></i></span>'+
                                '<input class="form-control daterange-single-kemarin" name="kemarin" id="kemarin">'+
                            '</div>'+
                        '</div>'+
                    '</div>';

                    $("#anotherDate").empty().html(el);

                    $('.daterange-single-kemarin').datepicker({ 
                        singleDatePicker: true,
                        selectMonths: true,
                        selectYears: true
                    });

                    $('.daterange-single-kemarin').datepicker('setDate',kemarin);
                }else{
                    $("#anotherDate").empty();
                }
            })

            $(document).on("click","#pilih2",function(){
                if($(this).is(':checked')){
                    var el="";
                    el+='<div class="form-group">'+
                        '<label class="col-lg-2">Compare With</label>'+
                        '<div class="col-lg-4">'+
                            '<div class="input-group">'+
                                '<span class="input-group-addon"><i class="icon-calendar"></i></span>'+
                                '<input class="form-control daterange-single-kemarin2" name="kemarin2" id="kemarin2">'+
                            '</div>'+
                        '</div>'+
                    '</div>';

                    $("#anotherDate2").empty().html(el);

                    $('.daterange-single-kemarin2').datepicker({ 
                        singleDatePicker: true,
                        selectMonths: true,
                        selectYears: true
                    });

                    $('.daterange-single-kemarin2').datepicker('setDate',kemarin);
                }else{
                    $("#anotherDate").empty();
                }
            })
        })
    </script>
@endpush
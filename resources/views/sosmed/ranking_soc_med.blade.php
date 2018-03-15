@extends('layouts.sosmed')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Export Rank Social Media</div>
        <div class="panel-body">
            <form class="form-horizontal" action="{{URL::to('sosmed/data/report/pdf-rank-for-sosical-media-all-tv')}}" method="GET" target="new target">
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

            $('.daterange-single-sekarang').datepicker({ 
                singleDatePicker: true,
                selectMonths: true,
                selectYears: true
            });

            $('.daterange-single-sekarang').datepicker('setDate',sekarang);
            
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
        })
    </script>
@endpush
@extends('layouts.sosmed')

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
<div class="panel panel-primary">
        <div class="panel-heading">Export Excel</div>
        <div class="panel-body">
            <div class="tabbable">
                <ul class="nav nav-tabs nav-tabs-highlight">
                    <li class="active"><a href="#highlight-tab1" data-toggle="tab">Follower</a></li>
                    <!-- <li><a href="#highlighted-tab2" data-toggle="tab">ALL PROGRAM GROWTH</a></li> -->
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="highlight-tab1">
                        <form class="form-horizontal" target="new target" id="form" action="{{URL::to('sosmed/data/export-excel')}}">
                            <div class="form-group">
                                <label class="col-lg-2">Type Unit</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="icon-archive"></i></span>
                                        <select name="typeunit" id="typeunit" class="form-control">
                                            <option value="">--Pilih Unit--</option>
                                            <option value="TV">TV</option>
                                            <option value="Publisher">Publisher</option>
                                            <option value="Radio">Radio</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2">Type Account</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="icon-archive"></i></span>
                                        <select name="typeaccount" id="typeaccount" class="form-control">
                                            <option value="">--Pilih Account--</option>
                                            <option value="corporate">Corporate</option>
                                            <option value="program">Program</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2">Start Date</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="icon-calendar"></i></span>
                                        <input class="form-control daterange-single-sekarang" name="start" id="start">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2">End Date</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="icon-calendar"></i></span>
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
                    <div class="tab-pane" id="highlighted-tab2">
                        
                    </div>
                </div>
            </div>  
        </div>
    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/floatthead/2.1.1/jquery.floatThead.js"></script>
    <script>
        $(function(){
            var sekarang = new Date();
            var kemarin = new Date(sekarang);
            kemarin.setDate(sekarang.getDate() - 1);

            $('.daterange-single-sekarang').datepicker({ 
                singleDatePicker: true,
                selectMonths: true,
                selectYears: true,
                dateFormat: 'dd-mm-yy'
            });

            $('.daterange-single-sekarang').datepicker('setDate',sekarang);
        })
    </script>
@endpush
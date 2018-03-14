@extends('layouts.sosmed')

@section('title')
    Dashboard
@endsection

@section('extra-style')

@endsection

@section('content')
<div class="container-fluid">
    <!-- OVERVIEW -->
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title text-center">SUMMARY</h3>
        </div>
        <div class="panel-body">
            <div class="tabbable">
                <ul class="nav nav-tabs nav-tabs-highlight">
                    <li class="active"><a href="#highlight-tab1" data-toggle="tab">TARGET VS ACHIEVEMENT</a></li>
                    <li><a href="#highlighted-tab2" data-toggle="tab">OFFICIAL ACCOUNT ALL TV</a></li>
                    <li><a href="#highlighted-tab3" data-toggle="tab">SOSMED OFFICIAL AND PROGRAM</a></li>
                    <li><a href="#highlighted-tab4" data-toggle="tab">DETAIL OFFICIAL AND PROGRAM</a></li>
                    
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="highlight-tab1">
                        <form id="formTargetAchievement" onsubmit="return false">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Group</label>
                                        <select name="form-control" name="group" id="group" class="form-control">
                                            @foreach($group as $row)
                                                <option value="{{$row->id}}">{{$row->group_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Periode</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="icon-calendar5"></i></span>
                                            <input type="text" id="tanggal" name="tanggal" class="form-control daterange-single">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <button class='btn btn-primary' style="margin-top:25px;">
                                        <i class="icon-filter4"></i> &nbsp;
                                        Filter 
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div style="margin-top:10px;"></div>

                        <div class="table-responsive">
                            <div id="divTargetVsAchievement"></div>
                        </div>
                    </div>

                    <div class="tab-pane" id="highlighted-tab2">
                        <form id="formofficialAccountAllTv" onsubmit="return false">
                            <div class="row">
                                <!-- <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Group</label>
                                        <select name="form-control" id="group2" name="group" class="form-control">
                                            <option value="">--Select Group--</option>
                                            @foreach($group as $row)
                                                <option value="{{$row->id}}">{{$row->group_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Periode</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="icon-calendar5"></i></span>
                                            <input type="text" name="tanggal" id="tanggal2" class="form-control daterange-single">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <button class='btn btn-primary' style="margin-top:25px;">
                                        <i class="icon-filter4"></i> &nbsp;
                                        Filter 
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <div id="divofficialAccountAllTv"></div>
                        </div>
                    </div>

                    <div class="tab-pane" id="highlighted-tab3">
                        <form id="formsosmedOfficialAndProgram" onsubmit="return false">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Periode</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="icon-calendar5"></i></span>
                                            <input type="text" name="tanggal" id="tanggal3" class="form-control daterange-single">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <button class='btn btn-primary' style="margin-top:25px;">
                                        <i class="icon-filter4"></i> &nbsp;
                                        Filter 
                                    </button>
                                </div>
                            </div>
                        </form>


                        <div class="table-responsive">
                            <div id="sosmedOfficialAndProgram"></div>
                        </div>
                    </div>

                    <div class="tab-pane" id="highlighted-tab4">
                        <form id="formofficialAndProgram" onsubmit="return false">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Group</label>
                                        <select name="form-control" id="group4" name="group" class="form-control">
                                            @foreach($group as $row)
                                                <option value="{{$row->id}}">{{$row->group_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Periode</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="icon-calendar5"></i></span>
                                            <input type="text" name="tanggal" id="tanggal4" class="form-control daterange-single">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <button class='btn btn-primary' style="margin-top:25px;">
                                        <i class="icon-filter4"></i> &nbsp;
                                        Filter 
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <div id="officialAndProgram"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END OVERVIEW -->

</div>

<div id="divModal"></div>
@endsection


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
            var kode="";

            $('.pickadate-accessibility').pickadate({
                labelMonthNext: 'Go to the next month',
                labelMonthPrev: 'Go to the previous month',
                labelMonthSelect: 'Pick a month from the dropdown',
                labelYearSelect: 'Pick a year from the dropdown',
                selectMonths: true,
                selectYears: true
            });

            $('.daterange-single').daterangepicker({ 
                singleDatePicker: true,
                selectMonths: true,
                selectYears: true
            });

            function addKoma(nStr)
            {
                nStr += '';
                x = nStr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            }

            function targetVsAchievement(){
                var group=$("#group option:selected").val();
                var tanggal=$("#tanggal").val();

                var el="";
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/target-vs-achievement')}}",
                    type:"GET",
                    data:"group="+group+"&tanggal="+tanggal,
                    beforeSend:function(){
                        $("#divTargetVsAchievement").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                    },
                    success:function(result){
                        $("#divTargetVsAchievement").empty().append(result);
                    },
                    error:function(){

                    }
                })
            }

            function officialAccountAllTv(){
                var el="";
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/official-account-all-tv')}}",
                    type:"GET",
                    beforeSend:function(){
                        $("#divofficialAccountAllTv").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                    },
                    success:function(result){
                        $("#divofficialAccountAllTv").empty().append(result);
                    },
                    error:function(){

                    }
                })
            }

            function sosmedOfficialAndProgram(){
                var el="";
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/sosmed-official-and-program')}}",
                    type:"GET",
                    beforeSend:function(){
                        $("#sosmedOfficialAndProgram").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                    },
                    success:function(result){
                        $("#sosmedOfficialAndProgram").empty().append(result);
                    },
                    error:function(){

                    }
                })
            }

            function officialAndProgram(){
                var group=$("#group4 option:selected").val();
                var tanggal=$("#tanggal4").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/official-and-program')}}",
                    type:"GET",
                    data:"group="+group+"&tanggal="+tanggal,
                    beforeSend:function(){
                        $("#officialAndProgram").empty().html("<div class='alert alert-info'>Please Wait . . . </div>");
                    },
                    success:function(result){
                        $("#officialAndProgram").empty().append(result);
                    },
                    error:function(){

                    }
                })
            }

            $(document).on("submit","#formTargetAchievement",function(e){
                targetVsAchievement();
            });

            $(document).on("submit","#formofficialAccountAllTv",function(e){
                var group=$("#group2 option:selected").val();
                var tanggal=$("#tanggal2").val();

                var el="";
                if($("#formofficialAccountAllTv")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url:"{{URL::to('sosmed/data/report/official-account-all-tv')}}",
                        type:"GET",
                        data:"group="+group+"&tanggal="+tanggal,
                        beforeSend:function(){
                            $("#divofficialAccountAllTv").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                        },
                        success:function(result){
                            $("#divofficialAccountAllTv").empty().append(result);
                        },
                        error:function(){

                        }
                    })
                }else console.log("invalid form");
            })

            $(document).on("submit","#formsosmedOfficialAndProgram",function(e){
                var group=$("#group3 option:selected").val();
                var tanggal=$("#tanggal3").val();

                var el="";
                if($("#formsosmedOfficialAndProgram")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url:"{{URL::to('sosmed/data/report/sosmed-official-and-program')}}",
                        type:"GET",
                        data:"tanggal="+tanggal,
                        beforeSend:function(){
                            $("#sosmedOfficialAndProgram").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                        },
                        success:function(result){
                            $("#sosmedOfficialAndProgram").empty().append(result);
                        },
                        error:function(){

                        }
                    })
                }else console.log("invalid form");
            })

            $(document).on("submit","#formofficialAndProgram",function(e){
                officialAndProgram();
            });


            

            targetVsAchievement();
            officialAccountAllTv();
            sosmedOfficialAndProgram();
            officialAndProgram();

            $(document).on("click","#exportpdf",function(){
                var el="";
                el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                    '<div class="modal-dialog">'+
                        '<form id="formExportPdf" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header bg-primary">'+
                                    '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                    '<h5 class="modal-title" id="modal-title">Export PDF</h5>'+
                                '</div>'+

                                '<div class="modal-body">'+
                                    '<div id="pesan"></div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Date</label>'+
                                        '<input class="form-control" name="tanggal" id="tanggal" placeholder="Date" required>'+
                                    '</div>'+

                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Compare Date</label>'+
                                        '<input class="form-control" name="compare" id="compare" placeholder="Compare Date" required>'+
                                    '</div>'+
                                '</div>'+

                                '<div class="modal-footer">'+
                                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                    '<button type="submit" class="btn btn-primary btn-ladda btn-ladda-spinner" > <span class="ladda-label"><i class="icon-file-pdf"></i> Export File</span> </button>'+
                                '</div>'+
                            '</div>'+
                        '</form>'+
                    '</div>'+
                '</div>';

                $("#divModal").empty().html(el);
                $("#modal_default").modal("show");
            })

            $(document).on("submit","#formExportPdf",function(e){
                var data = new FormData(this);
                if($("#formExportPdf")[0].checkValidity()) {

                }else console.log("invalid form");
            })
        })
    </script>
@endpush
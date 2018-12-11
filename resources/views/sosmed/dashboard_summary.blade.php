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
<div class="container-fluid">
    <!-- OVERVIEW -->
    <div class="card card-primary">
        <div class="card-header">
            <h5 class="card-title text-center">SUMMARY</h5>
        </div>
        <div class="card-body">
            <div class="default-tab">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#highlight-tab1" role="tab" aria-controls="nav-home" aria-selected="true">TARGET VS ACHIEVEMENT</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#highlight-tab2" role="tab" aria-controls="nav-profile" aria-selected="false">OFFICIAL ACCOUNT ALL</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#highlight-tab3" role="tab" aria-controls="nav-contact" aria-selected="false">SOCMED OFFICIAL AND PROGRAM</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#highlight-tab4" role="tab" aria-controls="nav-contact" aria-selected="false">DETAIL OFFICIAL AND PROGRAM</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#highlight-tab5" role="tab" aria-controls="nav-contact" aria-selected="false">RANKING</a>
                    </div>
                </nav>
                <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="highlight-tab1" role="tabpanel" aria-labelledby="nav-home-tab">
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
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                                            </div>
                                            <input type="text" id="tanggal" data-value="{{date('Y/m/d')}}" name="tanggal" class="form-control daterange-single">
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
                    <div class="tab-pane fade" id="highlight-tab2" role="tabpanel" aria-labelledby="nav-profile-tab">
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
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                                            </div>
                                            <input type="text" name="tanggal" id="tanggal2" data-value="{{date('Y/m/d')}}" class="form-control daterange-single">
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="pilih" id="pilih"> <small>check to compare data with another date?</small>
                                            </label>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group row">
                                        <label class="control-label">Unit Type</label>
                                        <div class="input-group mb3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-archive"></i></span>
                                            </div>
                                            <select name="typeunit" id="typeunit1" class="form-control" required>
                                                @foreach($typeunit as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div id="anotherDate"></div>

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
                    <div class="tab-pane fade" id="highlight-tab3" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <form id="formsosmedOfficialAndProgram" onsubmit="return false">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Periode</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                                            </div>
                                            <input type="text" name="tanggal" id="tanggal3" data-value="{{date('Y/m/d')}}" class="form-control daterange-single">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group row">
                                        <label class="control-label">Unit Type</label>
                                        <div class="input-group mb3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-archive"></i></span>
                                            </div>
                                            <select name="typeunit" id="typeunit2" class="form-control" required>
                                                @foreach($typeunit as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                @endforeach
                                            </select>
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
                    <div class="tab-pane fade" id="highlight-tab4" role="tabpanel" aria-labelledby="nav-contact-tab">
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
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                                            </div>
                                            <input type="text" name="tanggal" id="tanggal4" data-value="{{date('Y/m/d')}}" class="form-control daterange-single">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group row">
                                        <label class="control-label">Unit Type</label>
                                        <div class="input-group mb3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-archive"></i></span>
                                            </div>
                                            <select name="typeunit" id="typeunit3" class="form-control" required>
                                                @foreach($typeunit as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                @endforeach
                                            </select>
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
                    <div class="tab-pane fade" id="highlight-tab5" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <form id="formRangking" onsubmit="return false">
                            <div class="row">

                                <div class="col-lg-3">
                                    <div class="form-group row">
                                        <label class="control-label">Unit Type</label>
                                        <div class="input-group mb3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-archive"></i></span>
                                            </div>
                                            <select name="typeunit" id="typeunit5" class="form-control" required>
                                                @foreach($typeunit as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Periode</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                                            </div>
                                            <input type="text" name="tanggal" id="tanggal5" data-value="{{date('Y/m/d')}}" class="form-control daterange-single">
                                        </div> 
                                    </div>
                                </div>

                                <div id="anotherDate2"></div>
                                <div class="col-lg-3">
                                    <button class='btn btn-primary' style="margin-top:25px;">
                                        <i class="icon-filter4"></i> &nbsp;
                                        Filter 
                                    </button>
                                </div>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="pilih" id="pilih2"> <small>check to compare data with another date?</small>
                                </label>
                            </div> 
                        </form>

                        <div id="rangAllAccountGroup"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="divModal"></div>
@endsection


@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/floatthead/2.1.1/jquery.floatThead.js"></script>
    <script>
        $(function(){
            var kode="";

            var sekarang = new Date();
            var kemarin = new Date(sekarang);
            kemarin.setDate(sekarang.getDate() - 1);    

            $('.pickadate-accessibility').pickadate({
                labelMonthNext: 'Go to the next month',
                labelMonthPrev: 'Go to the previous month',
                labelMonthSelect: 'Pick a month from the dropdown',
                labelYearSelect: 'Pick a year from the dropdown',
                selectMonths: true,
                selectYears: true
            });

            $('.daterange-single').pickadate({
                format: 'yyyy/mm/dd',
                formatSubmit: 'yyyy/mm/dd',
                max:true,
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

            $(document).on("click","#pilih",function(){
                if($(this).is(':checked')){
                    var el="";
                    el+='<div class="form-group">'+
                        '<label class="control-label">Compare With</label>'+
                        '<div class="input-group mb-3">'+
                            '<div class="input-group-prepend">'+
                                '<span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>'+
                            '</div>'+
                            '<input class="form-control daterange-single-kemarin" data-value="'+kemarin+'" name="kemarin" id="kemarin">'+
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

            $(document).on("click","#pilih2",function(){
                if($(this).is(':checked')){
                    var el="";
                    el+='<div class="form-group">'+
                        '<label class="control-label">Compare With</label>'+
                        '<div class="input-group mb-3">'+
                            '<div class="input-group-prepend">'+
                                '<span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>'+
                            '</div>'+
                            '<input class="form-control daterange-single-kemarin" data-value="'+kemarin+'" name="kemarin" id="kemarin2">'+
                        '</div>'+
                    '</div>';

                    $("#anotherDate2").empty().html(el);

                    $('.daterange-single-kemarin').pickadate({
                        format: 'yyyy/mm/dd',
                        formatSubmit: 'yyyy/mm/dd',
                        max:true,
                    });
                }else{
                    $("#anotherDate2").empty();
                }
            })

            function targetVsAchievement(){
                var group=$("#group option:selected").val();
                var tanggal=$("#tanggal").val();

                var el="";
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/target-vs-achievement')}}",
                    type:"GET",
                    data:"group="+group+"&tanggal="+tanggal,
                    beforeSend:function(){
                        $("#divTargetVsAchievement").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>Please Wait...</div>");
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
                        $("#divofficialAccountAllTv").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>Please Wait...</div>");
                    },
                    success:function(result){
                        $("#divofficialAccountAllTv").empty().append(result);
                        // $(".sticky-header").floatThead({scrollingTop:50});
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
                        $("#sosmedOfficialAndProgram").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>Please Wait...</div>");
                    },
                    success:function(result){
                        $("#sosmedOfficialAndProgram").empty().append(result);
                        // $(".sticky-header").floatThead({scrollingTop:50});
                    },
                    error:function(){

                    }
                })
            }

            function officialAndProgram(){
                var group=$("#group4 option:selected").val();
                var tanggal=$("#tanggal4").val();
                var typeunit=$("#typeunit3").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/official-and-program')}}",
                    type:"GET",
                    data:"group="+group+"&tanggal="+tanggal+"&typeunit="+typeunit,
                    beforeSend:function(){
                        $("#officialAndProgram").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>Please Wait . . . </div>");
                    },
                    success:function(result){
                        $("#officialAndProgram").empty().append(result);
                        // $(".sticky-header").floatThead({scrollingTop:50});
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
                var typeunit=$("#typeunit1").val();
                
                if($("#pilih").is(':checked')){
                    var pilih=$("#pilih").val();
                    var kemarin=$("#kemarin").val();
                }else{
                    var pilih="";
                    var kemarin="";
                }

                var el="";
                if($("#formofficialAccountAllTv")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url:"{{URL::to('sosmed/data/report/official-account-all-tv')}}",
                        type:"GET",
                        data:"group="+group+"&tanggal="+tanggal+"&pilih="+pilih+"&kemarin="+kemarin+"&typeunit="+typeunit,
                        beforeSend:function(){
                            $("#divofficialAccountAllTv").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>Please Wait...</div>");
                        },
                        success:function(result){
                            $("#divofficialAccountAllTv").empty().append(result);
                            // $(".sticky-header").floatThead({scrollingTop:50});
                        },
                        error:function(){

                        }
                    })
                }else console.log("invalid form");
            })

            $(document).on("submit","#formsosmedOfficialAndProgram",function(e){
                var group=$("#group3 option:selected").val();
                var tanggal=$("#tanggal3").val();
                var typeunit=$("#typeunit2").val();

                var el="";
                if($("#formsosmedOfficialAndProgram")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url:"{{URL::to('sosmed/data/report/sosmed-official-and-program')}}",
                        type:"GET",
                        data:"tanggal="+tanggal+"&typeunit="+typeunit,
                        beforeSend:function(){
                            $("#sosmedOfficialAndProgram").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>Please Wait...</div>");
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

            // targetVsAchievement();
            // officialAccountAllTv();
            // sosmedOfficialAndProgram();
            officialAndProgram();


            /* ranking */
            function rangAllAccountGroup(){
                var tanggal=$("#tanggal5").val();
                var typeunit=$("#typeunit5").val();

                if($("#pilih2").is(':checked')){
                    var pilih=$("#pilih2").val();
                    var kemarin=$("#kemarin2").val();
                }else{
                    var pilih="";
                    var kemarin="";
                }

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/rank-of-official-account-all-group')}}",
                    type:"GET",
                    data:"tanggal="+tanggal+"&pilih="+pilih+"&kemarin="+kemarin+"&typeunit="+typeunit,
                    beforeSend:function(){
                        $("#rangAllAccountGroup").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>Please Wait . . .</div>");
                    },
                    success:function(result){
                        $("#rangAllAccountGroup").empty().append(result);
                    },
                    error:function(){

                    }
                })
            }

            /* rank */
            rangAllAccountGroup();

            $(document).on("submit","#formRangking",function(){
                rangAllAccountGroup(); 
            })

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
@stop
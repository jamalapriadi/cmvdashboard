@extends('layouts.sosmed')

@section('extra-style')
<style>
    fieldset{
        border: 1px solid #ddd !important;
        margin: 0;
        xmin-width: 0;
        padding: 10px;       
        position: relative;
        border-radius:4px;
        background-color:#f5f5f5;
        padding-left:10px!important;
    }	

    legend{
        font-size:14px;
        font-weight:bold;
        margin-bottom: 0px; 
        width: 35%; 
        border: 1px solid #ddd;
        border-radius: 4px; 
        padding: 5px 5px 5px 10px; 
        background-color: #d8dfe5;
        color:#222;
    }
    .daterangepicker{z-index:1151 !important;}
</style>
@stop

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Add New Daily Report # {{$id}}</div>
        <div class="panel-body">
            <div id="pesansukses"></div>
            <div id="showKonfirmasi"></div>
            <div id="showForm"></div>
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
    {{Html::script('limitless1/assets/js/plugins/jquery-number/jquery.number.min.js')}}
    <script>
        $(function(){
            var kode="";
            var data;

            $('.daterange-single').daterangepicker({ 
                singleDatePicker: true,
                selectMonths: true,
                selectYears: true
            });

            $(document).on("click","#tambah",function(){
                var el="";

                $.ajax({
                    url:"{{URL::to('sosmed/data/list-group')}}",
                    type:"GET",
                    data:"unit=unit&sosmed=sosmed",
                    beforeSend:function(){
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog">'+
                                '<form id="form" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                                    '<div class="modal-content">'+
                                        '<div class="modal-header bg-primary">'+
                                            '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                            '<h5 class="modal-title" id="modal-title">Add New Daily Report</h5>'+
                                        '</div>'+

                                        '<div class="modal-body">'+
                                            '<div id="showForm"></div>'+
                                        '</div>'+

                                        '<div class="modal-footer">'+
                                            '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                            '<button type="submit" class="btn btn-primary btn-ladda btn-ladda-spinner"id="simpan"> <span class="ladda-label">Save</span> </button>'+
                                        '</div>'+
                                    '</div>'+
                                '</form>'+
                            '</div>'+
                        '</div>';

                        $("#divModal").empty().html(el);
                        $("#modal_default").modal("show");
                        $("#showForm").empty().html(el);
                    },
                    success:function(result){
                        el+='<div class="form-group">'+
                                '<label class="control-label">Type</label>'+
                                "<select name='type' id='type' class='form-control'>"+
                                    '<option value="program">Program</option>'+
                                    '<option value="corporate">Corporate</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label">Tanggal</label>'+
                                '<div class="input-group">'+
                                    '<span class="input-group-addon"><i class="icon-calendar5"></i></span>'+
                                    '<input type="text" id="tanggal" name="tanggal" class="form-control daterange-single">'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">TV Station</label>'+
                                '<select name="unit" id="unit" class="form-control">'+
                                    '<option value="">--Select TV Station--</option>';
                                    $.each(result.unit,function(a,b){
                                        el+="<option value='"+b.id+"'>"+b.unit_name+"</option>";
                                    })
                                el+='</select>'+
                            '</div>'+
                            '<div id="showProgram">'+
                                '<div class="form-group">'+
                                    '<label class="control-label">Program</label>'+
                                    '<select name="program" id="program" class="form-control">'+
                                        "<option value=''>--Select Program--</option>";

                                    el+="</select>"+
                                '</div>'+
                            '</div>'+

                            '<hr>'+

                            '<div id="showSosmed"></div>'+

                            
                            '<div id="pesan"></div>';

                        $("#showForm").empty().html(el);

                        $('.daterange-single').daterangepicker({ 
                            singleDatePicker: true,
                            selectMonths: true,
                            selectYears: true
                        });
                    },
                    error:function(){
                        $("#showForm").empty().html("<div class='alert alert-danger'>Data Failed to load</div>");
                    }
                })
            });

            function showForm(){
                var el="";
                $("#showKonfirmasi").hide();

                $.ajax({
                    url:"{{URL::to('sosmed/data/list-group')}}",
                    type:"GET",
                    data:"unit=unit&sosmed=sosmed",
                    beforeSend:function(){
                        $("#showForm").empty().html("<div class='alert alert-info'>Please Wait....</div>");
                    },
                    success:function(result){
                        el+='<form id="form" onsubmit="return false;">'+
                            '<div class="row">'+
                                "<div class='col-lg-3'>"+
                                    '<div class="form-group">'+
                                        '<label class="control-label">Tanggal</label>'+
                                        '<div class="input-group">'+
                                            '<span class="input-group-addon"><i class="icon-calendar5"></i></span>'+
                                            '<input type="text" id="tanggal" name="tanggal" class="form-control daterange-single">'+
                                        '</div>'+
                                    '</div>'+
                                "</div>"+
                                "<div class='col-lg-3'>"+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">TV Station</label>'+
                                        '<select name="unit" id="unit" class="form-control">'+
                                            '<option value="">--Select TV Station--</option>';
                                            $.each(result.unit,function(a,b){
                                                el+="<option value='"+b.id+"'>"+b.unit_name+"</option>";
                                            })
                                        el+='</select>'+
                                    '</div>'+
                                "</div>"+
                            "</div>"+

                            '<br>'+

                            '<div id="showSosmed"></div>'+
                            '<div id="pesan"></div>'+

                            '<div id="showButton"></div>'+

                        '</form>';

                        $("#showForm").empty().html(el);

                        $("#showForm").show();

                        $('.daterange-single').daterangepicker({ 
                            singleDatePicker: true,
                            selectMonths: true,
                            selectYears: true
                        });
                    },
                    error:function(){
                        $("#showForm").empty().html("<div class='alert alert-danger'>Data Failed to load</div>");
                    }
                })
            }

            $(document).on("change","#type",function(){
                var type=$("#type option:selected").val();

                switch(type){
                    case 'program':
                            $("#unit").val('');
                            $("#showSosmed").empty();
                            var el="";
                            el+='<div class="form-group">'+
                                '<label class="control-label">Program</label>'+
                                '<select name="program" id="program" class="form-control">'+
                                    "<option value=''>--Select Program--</option>";

                                el+="</select>"+
                            '</div>';

                            $("#showProgram").empty().html(el);
                        break;
                    case 'corporate':
                            $("#unit").val('');
                            $("#showProgram").empty();
                            $("#showSosmed").empty();
                        break;
                    default:

                        break;
                }
            })

            $(document).on("change","#unit",function(){
                var unit=$("#unit option:selected").val();
                var tanggal=$("#tanggal").val();
                var sosmed="{{$id}}";

                $.ajax({
                    url:"{{URL::to('sosmed/data/list-official-and-program')}}/"+unit,
                    type:"GET",
                    data:"tanggal="+tanggal+"&sosmed="+sosmed,
                    beforeSend:function(){
                        $("#showSosmed").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                    },
                    success:function(result){
                        var kembali="{{URL::to('sosmed/input-report')}}/{{$id}}";

                        $("#showSosmed").empty().html(result);

                        var el="";
                        el+='<hr>'+

                        '<div class="form-group">'+
                            '<button class="btn btn-primary">'+
                                '<i class="icon-floppy-disk"></i> Save'+
                            '</button>'+

                            '<a href="'+kembali+'" class="btn btn-default">'+
                                'Back'+
                            '</a>'+
                        '</div>';

                        $("#showButton").empty().html(el);
                    },
                    error:function(){
                        $("#showSosmed").empty().html("<div class='alert alert-danger'>Failed to load data...</div>");
                    }
                })
            })

            $(document).on("change","#program",function(){
                var program=$("#program option:selected").val();
                var type=$("#type option:selected").val();
                var unit=$("#unit option:selected").val();
                var el="";

                $.ajax({
                    url:"{{URL::to('sosmed/data/list-sosmed-by-program')}}",
                    data:"program="+program+"&type="+type+"&unit="+unit,
                    type:"GET",
                    beforeSend:function(){
                        $("#showSosmed").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                    },
                    success:function(result){
                        el+='<fieldset>'+
                            '<legend>Sosial Media Follower</legend>';
                            $.each(result,function(c,d){
                                el+='<div class="form-group">'+
                                    '<label class="control-label">'+d.sosmed.sosmed_name+' # '+d.unit_sosmed_name+'</label>'+
                                    '<input type="hidden" class="form-control" name="official['+d.id+']" placeholder="'+d.sosmed.sosmed_name+'" value="'+d.sosmed.sosmed_name+'">'+
                                    '<input type="number" min="0" class="form-control" name="sosmed['+d.id+']" placeholder="'+d.sosmed.sosmed_name+'" required>'+
                                '</div>';
                            })
                        el+='</fieldset>';

                        $("#showSosmed").empty().html(el);
                    },
                    error:function(){

                    }
                })
            });

            $(document).on("submit","#form",function(e){
                data = new FormData(this);
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('sosmed/data/cek-save-daily-report')}}",
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $("#pesansukses").empty();
                            $('#pesan').empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {
                            if(data.success==true){
                                /* tampilkan data konfirmasi */
                                $("#pesan").empty();
                                var el="";
                                el+='<div class="alert alert-danger  alert-bordered alert-rounded">'+
                                    '<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>'+
                                    '<span class="text-semibold">Watch out!</span> Please make sure, you put the right data!'+
                                '</div>'+
                                "<div class='table-responsive'>"+
                                    "<table class='table table-striped'>"+
                                        "<thead>"+
                                            "<tr>"+
                                                '<th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">Official Account</th>'+
                                                "<th colspan='3' class='text-center' class='text-center' style='background:#222;color:white'>Tanggal</th>"+
                                            "</tr>"+
                                            "<tr>"+
                                                "<th class='text-center' style='background:#008ef6;color:white'>"+data.tanggal_kemarin+"</td>"+
                                                "<th class='text-center' style='background:#008ef6;color:white'>"+data.tanggal_sekarang+"</td>"+
                                                "<th class='text-center' style='background:#008ef6;color:white'>Additional Follower</td>"+
                                            "</tr>"+
                                        "</thead>"+
                                        "<tbody>";
                                            $.each(data.official,function(a,b){
                                                var kemarin=0;
                                                var sekarang=0;

                                                if(data.datakemarin.length>0){
                                                    for(a=0;a<data.datakemarin.length;a++){
                                                        if(data.datakemarin[a].unit_sosmed_id==b.unit_sosmed_id && data.datakemarin[a].tanggal==data.tanggal_kemarin){
                                                            kemarin=data.datakemarin[a].follower;
                                                        }
                                                    }
                                                }

                                                if(data.datasekarang.length>0){
                                                    for(a=0;a<data.datasekarang.length;a++){
                                                        if(data.datasekarang[a].unit_sosmed_id==b.unit_sosmed_id && data.datasekarang[a].tanggal==data.tanggal_sekarang){
                                                            sekarang=data.datasekarang[a].follower;
                                                        }
                                                    }
                                                }

                                                growth=sekarang/kemarin-1;

                                                el+="<tr>"+
                                                    "<td>"+b.sosmed_name+"</td>"+
                                                    "<td>"+kemarin+"</td>"+
                                                    "<td>"+sekarang+"</td>"+
                                                    "<td>";
                                                        if(growth>0){
                                                            el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+Math.round(growth)+" % </a>";
                                                        }else{
                                                            if(!isNaN(growth)){
                                                                el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+Math.round(growth)+" % </a>";
                                                            }else{
                                                                el+="-";
                                                            }
                                                        }
                                                    el+="</td>"+
                                                "</tr>";
                                            })
                                        el+="</tbody>"+
                                    "</table>"+
                                "</div>"+

                                "<div class='well'>"+
                                    "<div class='form-group'>"+
                                        "<a class='btn btn-primary' id='konfirmasi'><i class='icon-file-check2'></i> Konfirmasi</>"+
                                        "<a class='btn btn-default' id='kembali'><i class='icon-backward2'></i> Back</a>"+
                                    "</div>"+
                                "</div>";
                                
                                $("#showForm").hide();
                                $("#showKonfirmasi").empty().html(el);
                                $("#showKonfirmasi").show();
                                /* end tampilkan data konfirmasi */
                            }else{
                                new PNotify({
                                    title: 'Error!',
                                    text: data.pesan,
                                    addclass: 'alert-styled-right',
                                    type: 'error'
                                });

                                $("#pesan").empty().html("<div class='alert alert-danger'>"+data.pesan+"</div>");
                            }
                        },
                        error   :function() {  
                            $('#pesan').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            });

            $(document).on("click","#kembali",function(){
                $("#showForm").show();
                $("#showKonfirmasi").hide();
            });

            $(document).on("click","#konfirmasi",function(e){
                if($("#form")[0].checkValidity()) {
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('sosmed/data/save-daily-report')}}",
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $("#pesansukses").empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                            $('#pesan').empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {
                            if(data.success==true){
                                showForm();
                                $('#pesansukses').empty().html('<div class="alert alert-success">&nbsp;'+data.pesan+"</div>");
                            }else{
                                new PNotify({
                                    title: 'Error!',
                                    text: data.pesan,
                                    addclass: 'alert-styled-right',
                                    type: 'error'
                                });

                                $("#pesansukses").empty().html("<div class='alert alert-danger'>"+data.pesan+"</div>");
                            }
                        },
                        error   :function() {  
                            $('#pesansukses').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            })

            $(document).on("click",".editfollower",function(){
                kode=$(this).attr("kode");
                var el="";

                $.ajax({
                    url:"{{URL::to('sosmed/data/daily-report')}}/"+kode,
                    type:"GET",
                    beforeSend:function(){
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog">'+
                                '<form id="formUpdateDaily" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                                    '<div class="modal-content">'+
                                        '<div class="modal-header bg-primary">'+
                                            '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                            '<h5 class="modal-title" id="modal-title">Update Daily Report</h5>'+
                                        '</div>'+

                                        '<div class="modal-body">'+
                                            '<div id="showForm"></div>'+
                                        '</div>'+

                                        '<div class="modal-footer">'+
                                            '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                            '<button type="submit" class="btn btn-primary btn-ladda btn-ladda-spinner"id="simpan"> <span class="ladda-label">Save</span> </button>'+
                                        '</div>'+
                                    '</div>'+
                                '</form>'+
                            '</div>'+
                        '</div>';

                        $("#divModal").empty().html(el);
                        $("#modal_default").modal("show");
                        $("#showForm").empty().html(el);
                    },
                    success:function(result){
                        el+='<div id="pesan"></div>'+
                        '<div class="form-group">'+
                            '<label class="control-label">Type</label>'+
                            "<select name='type' class='form-control'>"+
                                '<option value="'+result.unitsosmed.type_sosmed+'">';
                                    if(result.unitsosmed.type_sosmed=='program'){
                                        el+="Program";
                                    }else if(result.unitsosmed.type_sosmed=='corporate'){
                                        el+="Corporate";
                                    }else{
                                        el+="--Select Type--";
                                    }
                                el+='</option>'+
                            '</select>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label">Tanggal</label>'+
                            "<input class='form-control' type='text' name='tanggal' value='"+result.tanggal+"'>"+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label text-semibold">TV Station</label>'+
                            '<select name="unit" class="form-control">';
                                if(result.unitsosmed.type_sosmed=="program"){
                                    el+='<option value="'+result.unitsosmed.program.businessunit.id+'">'+result.unitsosmed.program.businessunit.unit_name+'</option>';
                                }else if(result.unitsosmed.type_sosmed=="corporate"){
                                    el+='<option value="'+result.unitsosmed.businessunit.id+'">'+result.unitsosmed.businessunit.unit_name+'</option>';
                                }else{

                                }
                            el+='</select>'+
                        '</div>';
                        if(result.unitsosmed.type_sosmed=="program"){
                            el+='<div id="showProgram">'+
                                '<div class="form-group">'+
                                    '<label class="control-label">Program</label>'+
                                    '<select name="program" class="form-control">'+
                                        "<option value='"+result.unitsosmed.program.id+"'>"+result.unitsosmed.program.program_name+"</option>"+
                                    "</select>"+
                                '</div>'+
                            '</div>';
                        }

                        el+='<div class="form-group">'+
                            '<label class="control-label">'+result.unitsosmed.sosmed.sosmed_name+' Followers</label>'+
                            "<input class='form-control' type='text' name='follower' value='";
                                if(result.follower!=null){
                                    el+=result.follower;
                                }else{
                                    el+=0;
                                }
                            el+="'>"+
                        '</div>';

                        $("#showForm").empty().html(el);
                    },
                    error:function(){

                    }
                })
            });

            $(document).on("submit","#formUpdateDaily",function(e){
                var data = new FormData(this);
                data.append("_method","PUT");
                if($("#formUpdateDaily")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url			: "{{URL::to('sosmed/data/daily-report')}}/"+kode,
                        type		: 'post',
                        data		: data,
                        dataType	: 'JSON',
                        contentType	: false,
                        cache		: false,
                        processData	: false,
                        beforeSend	: function (){
                            $('#pesan').html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success	: function (result) {
                            if(result.success==true){
                                $('#pesan').html('&nbsp;'+result.pesan);
                                new PNotify({
                                    title: 'Info notice',
                                    text: result.pesan,
                                    addclass: 'alert-styled-left',
                                    type: 'info'
                                });
                                $("#modal_default").modal("hide");
                                showData();
                            }else{
                                $('#pesan').empty().html("<pre>"+result.error+"</pre><br>");
                                new PNotify({
                                    title: 'Info notice',
                                    text: result.pesan,
                                    addclass: 'alert-styled-left',
                                    type: 'error'
                                });
                            }
                        },
                        error	:function() {  
                            $('#pesan').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            });

            showForm();
        })
    </script>
@endpush
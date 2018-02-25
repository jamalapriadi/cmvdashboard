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
</style>
@stop

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Daily Report</div>
        <div class="panel-body">
            <a class="btn btn-primary" id="tambah">
                <i class="icon-add"></i> &nbsp;
                Add New Report
            </a>
            <hr>
            <!-- <table class="table table-striped datatable-colvis-basic"></table> -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Date</th>
                        <th rowspan="2">Unit</th>
                        <th rowspan="2">Program Name</th>
                        <th colspan="{{$sosmed->count()}}" class="text-center">Social Media</th>
                    </tr>
                    <tr>
                        @foreach($sosmed as $row)
                            <th>{{$row->sosmed_name}}</th>
                        @endforeach
                    </tr>
                </thead>
        </div>
    </div>

    <div id="divModal"></div>
@stop

@push('extra-script')
    <script>
        $(function(){
            var kode="";

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
                        el+='<div id="pesan"></div>'+
                            '<div class="form-group">'+
                                '<label class="control-label">Type</label>'+
                                "<select name='type' id='type' class='form-control'>"+
                                    '<option value="program">Program</option>'+
                                    '<option value="corporate">Corporate</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label">Tanggal</label>'+
                                "<input class='form-control' type='date' name='tanggal'>"+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Business Unit</label>'+
                                '<select name="unit" id="unit" class="form-control">'+
                                    '<option value="">--Select Business Unit--</option>';
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

                            '<div id="showSosmed"></div>';

                        $("#showForm").empty().html(el);
                    },
                    error:function(){
                        $("#showForm").empty().html("<div class='alert alert-danger'>Data Failed to load</div>");
                    }
                })
            });

            $(document).on("change","#unit",function(){
                var unit=$("#unit option:selected").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/list-program-by-unit')}}/"+unit,
                    type:"GET",
                    beforeSend:function(){
                        $("#showSosmed").empty();
                        $("#showProgram").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<div class='form-group'>"+
                            "<label class='control-label'>Program</label>"+
                        "<select name='program' id='program' class='form-control'>"+
                            '<option value="" disabled selected>--Select Program--</option>';
                        $.each(result,function(a,b){
                            el+="<option value='"+b.id+"'>"+b.program_name+"</option>";
                        })
                        el+="</select></div>";

                        $("#showProgram").empty().html(el);
                    },
                    error:function(){

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
                            '<legend>Sosial Media Official</legend>';
                            $.each(result,function(c,d){
                                el+='<div class="form-group">'+
                                    '<label class="control-label">'+d.sosmed.sosmed_name+' # '+d.unit_sosmed_name+'</label>'+
                                    '<input class="form-control" name="sosmed['+d.id+']" class="form-control" placeholder="'+d.sosmed.sosmed_name+'">'+
                                '</div>';
                            })
                        el+='</fieldset>';

                        $("#showSosmed").empty().html(el);
                    },
                    error:function(){

                    }
                })
            })

            $(document).on("submit","#form",function(e){
                var data = new FormData(this);
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
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
                            $('#pesan').empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {

                            if(data.success==true){
                                $('#pesan').empty().html('<div class="alert alert-success">&nbsp;'+data.pesan+"</div>");
                                $("#modal_default").modal("hide");
                            }else{
                                $("#pesan").empty().html("<div class='alert alert-danger'>"+data.pesan+"</div>");
                            }
                        },
                        error   :function() {  
                            $('#pesan').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            });
        })
    </script>
@endpush
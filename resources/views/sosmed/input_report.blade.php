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
        <div class="panel-heading">
            Daily Report {{$id}}
        </div>
        <div class="panel-body">
            <div class="row">
                <form id="formSearch" onsubmit="return false;">
                    <div style="float:left;margin-right:3px; width:160px">
                        <div class="form-group">
                            <label for="" class="control-label">Group</label>
                            <select name="searchgroup" id="searchgroup" class="form-control">
                                <option value="" selected>--Select Group--</option>
                                @foreach($group as $row)
                                    <option value="{{$row->id}}">{{$row->group_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div style="float:left;margin-right:3px; width:160px">
                        <div id="divsearchunit">
                            <div class="form-group">
                                <label for="" class="control-label">Unit</label>
                                <select name="searchunit" id="searchunit" class="form-control">
                                    <option value="all" disabled selected>--Select Unit--</option>
                                    @foreach($unit as $row)
                                        <option value="{{$row->id}}" data-group="{{$row->group_unit_id}}">{{$row->unit_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div style="float:left;margin-right:3px; width:160px">
                        <div id="divsearchprogram">

                        </div>
                    </div>
                    <div style="float:left;margin-right:3px; width:180px">
                        <div class="form-group">
                            <label class="control-label">Periode</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                <input type="text" name="searchperiode" id="searchperiode" class="form-control daterange-basic" value="{{date('m/d/Y',strtotime($kemarin))}} - {{date('m/d/Y',strtotime($sekarang))}}"> 
                            </div>
                        </div>
                    </div>
                    <div style="float:left;margin-right:3px; width:160px">
                        <div class="form-group">
                            <button class="btn btn-primary" style="margin-top:25px;">
                                <i class="icon-filter4"></i> Filter 
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="panel panel-flat">
        @if(auth()->user()->can('Add Daily Report'))
        <div class="panel-heading">
            <a class="btn btn-primary" href="{{URL::to('sosmed/add-new-report-harian/'.$id)}}">
                <i class="icon-add"></i> &nbsp;
                Add New Report
            </a>

            <a class="btn btn-success" id="import">
                <i class="icon-import"></i> &nbsp;
                Import File
            </a>
        </div>
        @endif
        <div class="panel-body">
            <!-- <table class="table table-striped datatable-colvis-basic"></table> -->
            <div class="table-responsive">
                <table class='table table-striped datatable-colvis-basic'></table>
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
            var kode="";

            $('.daterange-single').daterangepicker({ 
                singleDatePicker: true,
                selectMonths: true,
                selectYears: true
            });

            $('.daterange-basic').daterangepicker({
                applyClass: 'bg-slate-600',
                cancelClass: 'btn-default',
                opens: 'left'
            });

            // Setting datatable defaults
            $.extend( $.fn.dataTable.defaults, {
                autoWidth: false,
                columnDefs: [{ 
                    orderable: false,
                    width: '100px',
                    targets: [ 2 ]
                }],
                dom: '<"datatable-header"fCl><"datatable-scroll"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Filter:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                    $.uniform.update();
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
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

            function showData(){
                var f={
                    sosmed:"{{$id}}"
                }

                var table=$('.datatable-colvis-basic').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: true,
                    destroy: true,
                    ajax: {
                        url:"{{URL::to('sosmed/data/daily-report')}}",
                        data:f
                    },
                    columns: [
                        {data: 'no', name: 'no',title:'No.',searchable:false,width:'5%'},
                        {data: 'unit', name: 'unit',title:'Unit Name',width:'18%'},
                        {data: 'program', name: 'program',title:'Program Name'},
                        {data: 'unitsosmed.sosmed.sosmed_name', name: 'unitsosmed.sosmed.sosmed_name',title:'Sosmed Name'},
                        {data: 'unitsosmed.unit_sosmed_name', name: 'unitsosmed.unit_sosmed_name',title:'Account Name'},
                        {data: 'tanggal', name: 'tanggal',title:'Tanggal'},
                        {data: 'follow', name: 'follow',title:'Follower'},
                        {data: 'insert_user', name: 'insert_user',title:'Insert User',visible:false},
                        {data: 'created_at', name: 'created_at',title:'Created At',visible:false},
                        {data: 'updated_at', name: 'updated_at',title:'Updated At',visible:false},
                        {data: 'action', name: 'action',title:'Action',searchable:false,width:'22%'}
                    ],
                    buttons: [
                        'copy', 'excel', 'pdf'
                    ],
                    colVis: {
                        buttonText: "<i class='icon-three-bars'></i> <span class='caret'></span>",
                        align: "right",
                        overlayFade: 200,
                        showAll: "Show all",
                        showNone: "Hide all"
                    },
                    bDestroy: true
                }); 

                // Launch Uniform styling for checkboxes
                $('.ColVis_Button').addClass('btn btn-primary btn-icon').on('click mouseover', function() {
                    $('.ColVis_collection input').uniform();
                });


                // Add placeholder to the datatable filter option
                $('.dataTables_filter input[type=search]').attr('placeholder', 'Type and Enter...');


                // Enable Select2 select for the length option
                $('.dataTables_length select').select2({
                    minimumResultsForSearch: "-1"
                }); 

                $('.dataTables_filter input[type=search]').unbind().keyup(function(e) {
				    var value = $(this).val();

				    if (e.keyCode == 13) {
				    	table.search(value).draw();
				    }
				});
            }

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
                var type=$("#type option:selected").val();

                switch(type){
                    case 'program':
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
                        break;
                    case 'corporate':
                            $.ajax({
                                url:"{{URL::to('sosmed/data/list-sosmed-by-unit')}}/"+unit,
                                data:"type="+type+"&unit="+unit,
                                type:"GET",
                                beforeSend:function(){
                                    $("#showSosmed").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                                },
                                success:function(result){
                                    var el="";
                                    if(result.sosmed.length>0){
                                        el+='<fieldset>'+
                                            '<legend>Sosial Media Follower</legend>';
                                            $.each(result.sosmed,function(c,d){
                                                el+='<div class="form-group">'+
                                                    '<label class="control-label">'+d.sosmed.sosmed_name+' # '+d.unit_sosmed_name+'</label>'+
                                                    '<input class="form-control" name="sosmed['+d.id+']" class="form-control" placeholder="'+d.sosmed.sosmed_name+'" required>'+
                                                '</div>';
                                            })
                                        el+='</fieldset>';
                                    }else{
                                        el+="<div class='alert alert-info'>Sosmed Not Found</div>";
                                    }
                                    

                                    $("#showSosmed").empty().html(el);
                                },
                                error:function(){

                                }
                            })
                        break;

                    default:

                        break;
                }
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
                                new PNotify({
                                    title: 'Good Job!',
                                    text: data.pesan,
                                    addclass: 'alert-styled-right',
                                    type: 'success'
                                });
                                $('#pesan').empty().html('<div class="alert alert-success">&nbsp;'+data.pesan+"</div>");
                                $("#modal_default").modal("hide");
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
                            '<label class="control-label text-semibold">Business Unit</label>'+
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

            $(document).on("click",".hapusfollower",function(){
                kode=$(this).attr("kode");

                swal({
                    title: "Are you sure?",
                    text: "You will delete data!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            url:"{{URL::to('sosmed/data/daily-report')}}/"+kode,
                            type:"DELETE",
                            success:function(result){
                                if(result.success=true){
                                    swal("Deleted!", result.pesan, "success");
                                    showData();
                                }else{
                                    swal("Error!", result.pesan, "error");
                                }
                            }
                        })
                    } else {
                        swal("Cancelled", "Your data is safe :)", "error");
                    }
                });
            })

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

            $(document).on("change","#searchgroup",function(){
                var group=$("#searchgroup option:selected").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/list-unit')}}",
                    type:"GET",
                    data:"group="+group,
                    beforeSend:function(){
                        $("#divsearchunit").empty().html("<div class='alert alert-info'>Please Wait . . .</div>");
                    },
                    success:function(result){
                        var el="";
                        if(result.length>0){
                            el+="<div class='form-group'>"+
                                "<label class='control-label'>Unit</label>"+
                                '<select name="searchunit" id="searchunit" class="form-control">'+
                                '<option value="" selected>--Select Unit--</option>';
                                $.each(result,function(a,b){
                                    el+="<option value='"+b.id+"' data-group='"+b.group_unit_id+"'>"+b.unit_name+"</option>";
                                })
                            el+="</select>"+
                            '</div>';
                        }else{
                            var unit=@json($unit);

                            el+="<div class='form-group'>"+
                                "<label class='control-label'>Unit</label>"+
                                '<select name="searchunit" id="searchunit" class="form-control">'+
                                '<option value="" selected>--Select Unit--</option>';
                                $.each(unit,function(a,b){
                                    el+="<option value='"+b.id+"' data-group='"+b.group_unit_id+"'>"+b.unit_name+"</option>";
                                })
                            el+="</select>"+
                            '</div>';
                        }

                        $("#divsearchunit").empty().html(el);
                    },
                    error:function(){
                        
                    }
                })
            })

            $(document).on("change","#searchunit",function(){
                var unit=$("#searchunit option:selected").val();
                var selected=$(this).find('option:selected');
                var group=selected.data("group");

                $("#searchgroup").val(group);
            })

            $(document).on("change","#searchtype",function(){
                var type=$("#searchtype option:selected").val();
                var unit=$("#searchunit option:selected").val();

                switch(type){
                    case 'program':
                            $.ajax({
                                url:"{{URL::to('sosmed/data/list-program-by-unit')}}/"+unit,
                                type:"GET",
                                data:"unit="+unit,
                                beforeSend:function(){
                                    $("#divsearchprogram").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                                },
                                success:function(result){   
                                    var el="";
                                    el+="<div class='form-group'>"+
                                        "<label class='control-label'>Program</label>"+
                                        "<select class='form-control' name='searchprogram' id='searchprogram'>"+
                                            '<option value="" selected>--Select Program--</option>';
                                            $.each(result,function(a,b){
                                                el+="<option value='"+b.id+"'>"+b.program_name+"</option>";
                                            })
                                        el+="</select>"+
                                    "</div>";

                                    $("#divsearchprogram").empty().html(el);
                                },
                                error:function(){

                                }
                            })
                        break;
                    case 'corporate':
                            $("#divsearchprogram").empty();
                        break;
                    default:
                            $("#divsearchprogram").empty();
                        break;
                }
            })

            $(document).on("submit","#formSearch",function(e){
                var formData={
                    group:$("#searchgroup option:selected").val(),
                    unit:$("#searchunit option:selected").val(),
                    program:$("#searchprogram option:selected").val(),
                    periode:$("#searchperiode").val(),
                    sosmed:"{{$id}}"
                }

                if($("#formSearch")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    
                    var table=$('.datatable-colvis-basic').DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: true,
                        destroy: true,
                        ajax: {
                            url:"{{URL::to('sosmed/data/daily-report')}}",
                            data:formData
                        },
                        columns: [
                            {data: 'no', name: 'no',title:'No.',searchable:false,width:'5%'},
                            {data: 'unit', name: 'unit',title:'Unit Name',width:'18%'},
                            {data: 'program', name: 'program',title:'Program Name'},
                            {data: 'unitsosmed.sosmed.sosmed_name', name: 'unitsosmed.sosmed.sosmed_name',title:'Sosmed Name'},
                            {data: 'unitsosmed.unit_sosmed_name', name: 'unitsosmed.unit_sosmed_name',title:'Account Name'},
                            {data: 'tanggal', name: 'tanggal',title:'Tanggal'},
                            {data: 'follow', name: 'follow',title:'Follower'},
                            {data: 'insert_user', name: 'insert_user',title:'Insert User',visible:false},
                            {data: 'created_at', name: 'created_at',title:'Created At',visible:false},
                            {data: 'updated_at', name: 'updated_at',title:'Updated At',visible:false},
                            {data: 'action', name: 'action',title:'Action',searchable:false,width:'22%'}
                        ],
                        buttons: [
                            'copy', 'excel', 'pdf'
                        ],
                        colVis: {
                            buttonText: "<i class='icon-three-bars'></i> <span class='caret'></span>",
                            align: "right",
                            overlayFade: 200,
                            showAll: "Show all",
                            showNone: "Hide all"
                        },
                        bDestroy: true
                    }); 

                    // Launch Uniform styling for checkboxes
                    $('.ColVis_Button').addClass('btn btn-primary btn-icon').on('click mouseover', function() {
                        $('.ColVis_collection input').uniform();
                    });


                    // Add placeholder to the datatable filter option
                    $('.dataTables_filter input[type=search]').attr('placeholder', 'Type and Enter...');


                    // Enable Select2 select for the length option
                    $('.dataTables_length select').select2({
                        minimumResultsForSearch: "-1"
                    }); 

                    $('.dataTables_filter input[type=search]').unbind().keyup(function(e) {
                        var value = $(this).val();

                        if (e.keyCode == 13) {
                            table.search(value).draw();
                        }
                    });

                }else console.log("invalid form");
            })

            $(document).on("click","#import",function(){
                var sample="{{URL::to('sosmed/data/sample-daily-report')}}";

                var el="";
                el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                    '<div class="modal-dialog">'+
                        '<form id="formImport" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header bg-primary">'+
                                    '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                    '<h5 class="modal-title" id="modal-title">Import Data Followers</h5>'+
                                '</div>'+

                                '<div class="modal-body">'+
                                    '<div id="pesan"></div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">File</label>'+
                                        '<input type="file" class="form-control" name="file" id="file" placeholder="File" required>'+
                                    '</div>'+

                                    "<p><small>You can download 'Format DB Daily Report' if you want to upload data to make sure that your data will upload has appropriate with format</small> <a href='"+sample+"'><label class='label label-success'>Click to Download Format DB Daily Report</label></a>"+
                                '</div>'+

                                '<div class="modal-footer">'+
                                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                    '<button type="submit" class="btn btn-primary btn-ladda btn-ladda-spinner"> <span class="ladda-label">Upload</span> </button>'+
                                '</div>'+
                            '</div>'+
                        '</form>'+
                    '</div>'+
                '</div>';

                $("#divModal").empty().html(el);
                $("#modal_default").modal("show");
            })

            $(document).on("submit","#formImport",function(e){
                var data = new FormData(this);
                if($("#formImport")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url			: "{{URL::to('sosmed/data/import-daily-report')}}",
                        type		: 'post',
                        data		: data,
                        dataType	: 'JSON',
                        contentType	: false,
                        cache		: false,
                        processData	: false,
                        beforeSend	: function (){
                            $('#pesan').empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success	: function (result) {
                            if(result.success==true){
                                $('#pesan').empty().html('&nbsp;'+result.pesan);
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
            })

            showData();
        })
    </script>
@endpush
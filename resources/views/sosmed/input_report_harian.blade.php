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
        <div class="panel-heading">Daily Report</div>
        <div class="panel-body">
            <a class="btn btn-primary" href="{{URL::to('sosmed/add-new-report-harian')}}">
                <i class="icon-add"></i> &nbsp;
                Add New Report
            </a>
            <hr>
            <!-- <table class="table table-striped datatable-colvis-basic"></table> -->
            <div class="table-responsive">
                <div id="showReport"></div>
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
                $.ajax({
                    url:"{{URL::to('sosmed/data/daily-report')}}",
                    type:"GET",
                    beforeSend:function(){
                        $("#showReport").empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                    },
                    success:function(result){
                        var el="";
                        el+="<table class='table table-striped' id='tabeldaily'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th width='5%'>No.</th>"+
                                    "<th>Unit</th>"+
                                    "<th>Program Name</th>"+
                                    "<th>Sosial Media Name</th>"+
                                    "<th>Official Account</th>"+
                                    "<th>Tanggal</th>"+
                                    "<th>Follower</th>"+
                                    "<th></th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody>";
                                var no=0;
                                $.each(result,function(a,b){
                                    no++;
                                    el+="<tr>"+
                                        "<td>"+no+"</td>"+
                                        "<td>";
                                            if(b.unitsosmed.type_sosmed=="corporate"){
                                                if(b.unitsosmed.businessunit!=null){
                                                    el+=b.unitsosmed.businessunit.unit_name;
                                                }else{
                                                    el+='-';
                                                }
                                            }else if(b.unitsosmed.type_sosmed=="program"){
                                                if(b.unitsosmed.program!=null){
                                                    el+=b.unitsosmed.program.businessunit.unit_name;
                                                }else{
                                                    el+='-';
                                                }
                                            }
                                        el+="</td>"+
                                        "<td>";
                                            if(b.unitsosmed.program!=null){
                                                el+=b.unitsosmed.program.program_name;
                                            }else{
                                                el+="-";
                                            }
                                        el+="</td>"+
                                        "<td>"+b.unitsosmed.sosmed.sosmed_name+"</td>"+
                                        "<td>"+b.unitsosmed.unit_sosmed_name+"</td>"+
                                        "<td>"+b.tanggal+"</td>"+
                                        "<td>";
                                            if(b.follower!=null){
                                                el+=addKoma(b.follower);
                                            }else{
                                                el+='<label class="label label-danger">Set Follower</label>';
                                            }
                                        el+="</td>"+
                                        "<td><a class='btn btn-warning editfollower' kode='"+b.id+"'><i class='icon-pencil4'></i></a></td>"+
                                    "</tr>";
                                })
                            el+="</tbody>"+
                        "</table>";

                        $("#showReport").empty().html(el);

                        $("#tabeldaily").DataTable({
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
                        })

                        // Launch Uniform styling for checkboxes
                        $('.ColVis_Button').addClass('btn btn-primary btn-icon').on('click mouseover', function() {
                            $('.ColVis_collection input').uniform();
                        });


                        // Add placeholder to the datatable filter option
                        $('.dataTables_filter input[type=search]').attr('placeholder', 'Type to filter...');


                        // Enable Select2 select for the length option
                        $('.dataTables_length select').select2({
                            minimumResultsForSearch: "-1"
                        }); 
                    },
                    error:function(){

                    }
                })
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

            showData();
        })
    </script>
@endpush
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
        <div class="panel-heading">Program</div>
        <div class="panel-body">
            <a class="btn btn-primary" id="tambah">
                <i class="icon-add"></i> &nbsp;
                Add New Program
            </a>
            <br><br>

            <fieldset>
                <legend>Filter</legend>
                <div class="row" style="padding-left:10px;">
                    <form id="formSearch" onsubmit="return false;">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="" class="control-label">Group</label>
                                <select name="searchgroup" id="searchgroup" class="form-control">
                                    <option value="" disabled selected>--Select Group--</option>
                                    @foreach($group as $row)
                                        <option value="{{$row->id}}">{{$row->group_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="" class="control-label">Unit</label>
                                <select name="searchunit" id="searchunit" class="form-control">
                                    <option value="" disabled selected>--Select Unit--</option>
                                    @foreach($unit as $row)
                                        <option value="{{$row->id}}" kode="{{$row->group_unit_id}}">{{$row->unit_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <button class="btn btn-primary" style="margin-top:25px">
                                <i class="icon-filter4"></i> Filter
                            </button>
                        </div>
                    </form>
                </div>
            </fieldset>
            
            <table class="table table-striped datatable-colvis-basic"></table>
        </div>
    </div>

    <div id="divModal"></div>
@stop

@push('extra-script')
    <script>
        $(function(){
            var kode="";

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

            function showData(){
                var f={
                    group:$("#searchgroup option:selected").val(),
                    unit:$("#searchunit option:selected").val()
                }
                
                $('.datatable-colvis-basic').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: true,
                    destroy: true,
                    ajax:{
                        url:"{{URL::to('sosmed/data/program-unit')}}",
                        data:f
                    },
                    columns: [
                        {data: 'no', name: 'no',title:'No.',searchable:false,width:'5%'},
                        {data: 'businessunit.unit_name', name: 'businessunit.unit_name',title:'Unit Name', width:'15%'},
                        {data: 'program_name', name: 'program_name',title:'Program Name',width:'30%'},
                        {data: 'action', name: 'action',title:'Action',searchable:false,width:'17%'}
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
                $('.dataTables_filter input[type=search]').attr('placeholder', 'Type to filter...');


                // Enable Select2 select for the length option
                $('.dataTables_length select').select2({
                    minimumResultsForSearch: "-1"
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
                                            '<h5 class="modal-title" id="modal-title">Add New Program</h5>'+
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
                                '<label class="control-label text-semibold">Business Unit</label>'+
                                '<select name="unit" class="form-control">'+
                                    '<option value="">--Select Business Unit--</option>';
                                    $.each(result.unit,function(a,b){
                                        el+="<option value='"+b.id+"'>"+b.unit_name+"</option>";
                                    })
                                el+='</select>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Program Name</label>'+
                                '<input class="form-control" name="name" id="name" placeholder="Program Name" required>'+
                            '</div>'+

                            '<hr>'+
                            '<fieldset>'+
                                '<legend>Sosial Media Official</legend>';
                                $.each(result.sosmed,function(a,b){
                                    el+='<div class="form-group">'+
                                        '<label class="control-label">'+b.sosmed_name+'</label>'+
                                        '<input class="form-control" name="sosmed['+b.id+']" class="form-control" placeholder="'+b.sosmed_name+'">'+
                                    '</div>';
                                })
                            el+='</fieldset>';

                        $("#showForm").empty().html(el);
                    },
                    error:function(){
                        $("#showForm").empty().html("<div class='alert alert-danger'>Data Failed to load</div>");
                    }
                })
            });

            $(document).on("submit","#form",function(e){
                var data = new FormData(this);
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('sosmed/data/program-unit')}}",
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $('#pesan').html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {
                            $('#pesan').html('&nbsp;'+data.pesan);

                            if(data.success==true){
                                showData();
                                $("#modal_default").modal("hide");
                            }else{
                                $("#pesan").empty().html("<pre>"+data.error+"</pre>");
                            }
                        },
                        error   :function() {  
                            $('#pesan').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            });

            $(document).on("click",".edit",function(){
                kode=$(this).attr("kode");
                var el="";

                $.ajax({
                    url:"{{URL::to('sosmed/data/program-unit')}}/"+kode,
                    type:"GET",
                    beforeSend:function(){
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog">'+
                                '<form id="formUpdate" onsubmit="return false;" enctype="multipart/form-data">'+
                                    '<div class="modal-content">'+
                                        '<div class="modal-header bg-primary">'+
                                            '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                            '<h5 class="modal-title" id="modal-title">Edit Program Unit</h5>'+
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
                        $("#showForm").empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                    },
                    success:function(result){
                        el+='<div id="pesan"></div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Business Unit</label>'+
                                '<select name="unit" id="unit" class="form-control">'+
                                    '<option value="">--Select Business Unit--</option>';
                                    $.each(result.unit,function(a,b){
                                        el+="<option value='"+b.id+"'>"+b.unit_name+"</option>";
                                    })
                                el+='</select>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Program Name</label>'+
                                '<input class="form-control" name="name" id="name" value="'+result.program.program_name+'" placeholder="Program Name" required>'+
                            '</div>'+

                            '<hr>'+
                            '<fieldset>'+
                                '<legend>Sosial Media Official</legend>';
                                $.each(result.sosmed,function(c,d){
                                    if(result.program.sosmed.length>0){
                                        var isi="";

                                        for(a=0; a<result.program.sosmed.length;a++){
                                            if(result.program.sosmed[a].sosmed_id==d.id){
                                                isi=result.program.sosmed[a].unit_sosmed_name;
                                            }
                                        }
                                        

                                        el+='<div class="form-group">'+
                                            '<label class="control-label">'+d.sosmed_name+'</label>'+
                                            '<input class="form-control" name="sosmed['+d.id+']" value="'+isi+'" class="form-control" placeholder="'+d.sosmed_name+'">'+
                                        '</div>';
                                    }else{
                                        el+='<div class="form-group">'+
                                            '<label class="control-label">'+d.sosmed_name+'</label>'+
                                            '<input class="form-control" name="sosmed['+d.id+']" class="form-control" placeholder="'+d.sosmed_name+'">'+
                                        '</div>';
                                    }
                                })
                            el+='</fieldset>';

                        $("#showForm").empty().html(el);

                        $("#unit").val(result.program.business_unit_id);
                    },
                    error:function(){
                        $("#showForm").empty().html("<div class='alert alert-danger'>Data Failed to load</div>");
                    }
                })
            });

            $(document).on("submit","#formUpdate",function(e){
                var data = new FormData(this);
                data.append("_method","PUT");
                if($("#formUpdate")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url			: "{{URL::to('sosmed/data/program-unit')}}/"+kode,
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

            $(document).on("click",".hapus",function(){
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
                            url:"{{URL::to('sosmed/data/program-unit')}}/"+kode,
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
            });

            $(document).on("change","#searchgroup",function(){
                var group=$("#searchgroup option:selected").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/list-unit')}}",
                    type:"GET",
                    data:"group="+group,
                    beforeSend:function(){
                        $("#searchunit").empty();
                    },
                    success:function(result){
                        $('#searchunit').append($('<option>', { 
                            value: '',
                            text : '--Select Unit--'
                        }));

                        $.each(result,function(a,b){
                            $('#searchunit').append($('<option>', { 
                                value: b.id,
                                text : b.unit_name
                            }));
                        })
                    },
                    error:function(){
                        
                    }
                })
            })

            $(document).on("change","#searchunit",function(){
                var unit=$("#searchunit option:selected").val();
                var group=$("#searchunit option:selected").attr("kode");

                $("#searchgroup").val(group);
            })

            $(document).on("submit","#formSearch",function(){
                showData();
            })

            showData();
        })
    </script>
@endpush
@extends('layouts.tabler')

@section('js')
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

            function showTa(){
                $('.datatable-colvis-basic').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: true,
                    destroy: true,
                    ajax: "{{URL::to('cmv/data/target-audience')}}",
                    columns: [
                        //{data: 'no', name: 'no',title:'No.',searchable:false,width:'5%'},
                        {data: 'ta_id', name: 'ta_id',title:'ID TA',width:'17%'},
                        {data: 'ta_name', name: 'ta_name',title:'TA NAME'},
                        {data: 'action', name: 'action',title:'ACTION',searchable:false,width:'22%'}
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

            $(document).on("click","#addta",function(){
                var el="";
                el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                    '<div class="modal-dialog">'+
                        '<form id="form" class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header bg-primary text-white">'+
                                    '<h5 class="modal-title" id="modal-title">Add New Target Audience</h5>'+
                                    '<button type="button" class="close" data-dismiss="modal"></button>'+
                                '</div>'+

                                '<div class="modal-body">'+
                                    '<div id="pesan"></div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">ID TA</label>'+
                                        '<input class="form-control" name="idta" id="idta" placeholder="ID TA" required>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">NAME</label>'+
                                        '<input class="form-control" name="name" id="name" placeholder="NAME" required>'+
                                    '</div>'+
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
            })

            $(document).on("submit","#form",function(e){
                var data = new FormData(this);
                data.append("_token","{{ csrf_token() }}");
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('cmv/data/target-audience')}}",
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
                                showTa();
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

            $(document).on("click",".editta",function(){
                kode=$(this).attr("kode");
                var el="";

                $.ajax({
                    url:"{{URL::to('cmv/data/target-audience')}}/"+kode,
                    type:"GET",
                    beforeSend:function(){
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog">'+
                                '<form id="formUpdate" class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                                    '<div id="divForm">'+
                                        '<div class="modal-body">'+
                                            '<div class="alert alert-info">Please Wait....</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</form>'+
                            '</div>'+
                        '</div>';
        
                        $("#divModal").empty().html(el);
                        $("#modal_default").modal("show");
                    },
                    success:function(result){
                        el+='<div class="modal-content">'+
                                '<div class="modal-header bg-primary text-white">'+
                                    '<h5 class="modal-title" id="modal-title">Edit Target Audience</h5>'+
                                    '<button type="button" class="close" data-dismiss="modal"></button>'+
                                '</div>'+

                                '<div class="modal-body">'+
                                    '<div id="pesan"></div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">ID TA</label>'+
                                        '<input class="form-control" name="idta" id="idta" placeholder="ID TA" value="'+result.ta_id+'" required>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">NAME</label>'+
                                        '<input class="form-control" name="name" id="name" placeholder="NAME" value="'+result.ta_name+'" required>'+
                                    '</div>'+
                                '</div>'+

                                '<div class="modal-footer">'+
                                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                    '<button type="submit" class="btn btn-primary btn-ladda btn-ladda-spinner"id="simpan"> <span class="ladda-label">Save</span> </button>'+
                                '</div>'+
                            '</div>';

                        $("#divForm").empty().html(el);
                    },
                    error:function(){
                        alert('link target audience not found');
                    }
                })
            });

            $(document).on("submit","#formUpdate",function(e){
                var data = new FormData(this);
                data.append("_method","PUT");
                data.append("_token","{{ csrf_token() }}");
                if($("#formUpdate")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url			: "{{URL::to('cmv/data/target-audience')}}/"+kode,
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
                                showTa();
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

            $(document).on("click",".hapusta",function(){
                kode=$(this).attr("kode");
                var token="{{ csrf_token() }}";

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
                            url:"{{URL::to('cmv/data/target-audience')}}/"+kode,
                            type:"DELETE",
                            data:"_token="+token,
                            success:function(result){
                                if(result.success=true){
                                    swal("Deleted!", result.pesan, "success");
                                    showTa();
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

            showTa();
        })
    </script>
@stop

@section('content')
    <div class="page-header">
        <h1 class="page-title">
            TARGET AUDIENCE
        </h1>
        <!-- <div class="page-subtitle">1 - 12 of 1713 photos</div> -->
        <div class="page-options d-flex">
        <div class="btn-group pull-right" role="group">
            <a href="#" class="btn btn-primary btn-labeled heading-btn" id="addta"><b><i class="icon-task"></i></b> Create Target Audience</a>
        </div>
        </div>
    </div>


    <div class="card card-default">
        <div class="card-body">
            <table class="table table-striped datatable-colvis-basic"></table>
        </div>
    </div>

    <div id="divModal"></div>
@stop
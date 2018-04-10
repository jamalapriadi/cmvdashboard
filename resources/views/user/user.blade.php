@extends('layouts.sosmed')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Data User</div>
        <div class="panel-body">
            @if(auth()->user()->can('Create User'))
                <a class="btn btn-primary" id="tambah">
                    <i class="icon-add"></i> &nbsp;
                    Add New User
                </a>
            @endif
            <hr>
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
                $('.datatable-colvis-basic').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: true,
                    destroy: true,
                    ajax: "{{URL::to('sosmed/data/users')}}",
                    columns: [
                        {data: 'no', name: 'no',title:'No.',searchable:false,width:'5%'},
                        {data: 'name', name: 'name',title:'Name',width:'30%'},
                        {data: 'email', name: 'email',title:'Email'},
                        {data: 'unitsosmed.unit_name', name: 'unitsosmed.unit_name',title:'Unit',width:'10%'},
                        {data: 'action', name: 'action',title:'Action',searchable:false,width:'25%'}
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
                    data:"unit=unit",
                    beforeSend:function(){
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog">'+
                                '<form id="form" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                                    '<div class="modal-content">'+
                                        '<div class="modal-header bg-primary">'+
                                            '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                            '<h5 class="modal-title" id="modal-title">Add New User</h5>'+
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
                                '<label class="control-label text-semibold">TV Station</label>'+
                                '<select name="unit" class="form-control">'+
                                    '<option value="" disabled selected>--Select TV Station--</option>';
                                    $.each(result.unit,function(a,b){
                                        el+="<option value='"+b.id+"'>"+b.unit_name+"</option>";
                                    })
                                el+='</select>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Name</label>'+
                                '<input class="form-control" name="name" id="name" placeholder="Name" required>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Email</label>'+
                                '<input class="form-control" type="email" name="email" id="email" placeholder="Email" required>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Password</label>'+
                                '<input class="form-control" type="password" name="password" id="password" placeholder="Password" required>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Password Confirm</label>'+
                                '<input class="form-control" type="password" name="password_confirm" id="password_confirm" placeholder="Password Confirm" required>'+
                            '</div>';

                        $("#showForm").empty().html(el);
                    },
                    error:function(){
                        $("#showForm").empty().html("<div class='alert alert-danger'>Data Failed to load</div>");
                    }
                })
            });

            $(document).on("submit","#form",function(e){
                var data = new FormData(this);
                data.append("_token","{{ csrf_token() }}");
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('sosmed/data/users')}}",
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
                    url:"{{URL::to('sosmed/data/users')}}/"+kode,
                    type:"GET",
                    beforeSend:function(){
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog">'+
                                '<form id="formUpdate" onsubmit="return false;" enctype="multipart/form-data">'+
                                    '<div class="modal-content">'+
                                        '<div class="modal-header bg-primary">'+
                                            '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                            '<h5 class="modal-title" id="modal-title">Edit Sosial Media</h5>'+
                                        '</div>'+

                                        '<div class="modal-body">'+
                                            '<div id="showForm"></div>'+
                                        '</div>'+

                                        '<div class="modal-footer">'+
                                            '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                            '<button type="submit" class="btn btn-primary btn-ladda btn-ladda-spinner"> <span class="ladda-label">Save</span> </button>'+
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
                                '<label class="control-label text-semibold">TV Station</label>'+
                                '<select name="unit" id="unit" class="form-control">'+
                                    '<option value="">--Select TV Station--</option>';
                                    $.each(result.unit,function(a,b){
                                        el+="<option value='"+b.id+"'>"+b.unit_name+"</option>";
                                    })
                                el+='</select>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Name</label>'+
                                '<input class="form-control" name="name" id="name" placeholder="Name" value="'+result.user.name+'" required>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Email</label>'+
                                '<input class="form-control" type="email" name="email" id="email" value="'+result.user.email+'" placeholder="Email" required>'+
                            '</div>';

                        $("#showForm").empty().html(el);
                        $("#unit").val(result.user.unit);
                    },
                    error:function(){
                        $("#showForm").empty().html("<div class='alert alert-danger'>Data Failed to load</div>");
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
                        url			: "{{URL::to('sosmed/data/users')}}/"+kode,
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
                            url:"{{URL::to('sosmed/data/users')}}/"+kode,
                            type:"DELETE",
                            data:"_token={{ csrf_token() }}",
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

            showData();
        })
    </script>
@endpush
@extends('layouts.coreui.main')

@section('content')
<div class="card card-default">
    <div class="card-header">
        Data Sector
    </div>
    <div class="card-body">
        <table class="table table-striped datatable-colvis-basic"></table>
    </div>
</div>

<div id="tampilmodal"></div>
@stop

@section('js')
<script>
    $(function(){
        var kode="";

        function showData(){
            $('.datatable-colvis-basic').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: true,
                destroy: true,
                ajax: "{{URL::to('brand/data/sector')}}",
                columns: [
                    {data: 'DT_Row_Index', name: 'DT_Row_Index',title:'No.',width:'5%',searchable:false,'orderable':false},
                    {data: 'id_sector', name: 'id_sector',title:'ID Sector',width:'15%'},
                    {data: 'name_sector', name: 'name_sector',title:'Sector'}
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
                el+='<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">'+
                '<div class="modal-dialog" role="document">'+
                '<form class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" id="form">'+
                '<div class="modal-content">'+
                '<div class="modal-header bg-primary">'+
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<h4 class="modal-title" id="myModalLabel">New Sector</h4>'+
                '</div>'+
                '<div class="modal-body">'+
                '<div id="pesan"></div>'+
                '<div class="form-group">'+
                '<label class="col-lg-3 control-label text-semibold">Nama Sector</label>'+
                '<div class="col-lg-8">'+
                '<input class="form-control" name="name_sector" required>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '<div class="modal-footer">'+
                '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                '<button type="submit" class="btn btn-primary">Save changes</button>'+
                '</div>'+
                '</div>'+
                '</form>'+
                '</div>'+
                '</div>';

                $('#tampilmodal').empty().html(el);
                $("#myModal").modal('show');
            });

            $(document).on("submit","#form",function(e){
                var data = new FormData(this);
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('brand/data/sector')}}",
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
                            if(data.success==true){
                                new PNotify({
                                    title: 'Success!',
                                    text: data.pesan,
                                    addclass: 'bg-success'
                                });
                                showData();
                                $("#myModal").modal('hide');
                            }else{
                                new PNotify({
                                    title: 'Error!',
                                    text: data.pesan,
                                    addclass: 'bg-danger'
                                });
                            }
                            $('#pesan').empty();
                        },
                        error   :function() {
                            new PNotify({
                                title: 'Error!',
                                text: 'Error data',
                                addclass: 'bg-danger'
                            });
                            $('#pesan').empty();
                        }
                    });
                }else console.log("invalid form");
            });

            $(document).on("click",".edit",function(){
                kode=$(this).attr("kode");

                $.ajax({
                    url:"{{URL::to('brand/data/sector')}}/"+kode,
                    type:"GET",
                    success:function(result){
                        var el="";
                        el+='<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">'+
                        '<div class="modal-dialog" role="document">'+
                        '<form class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" id="formUpdate">'+
                        '<div class="modal-content">'+
                        '<div class="modal-header bg-primary">'+
                        '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<h4 class="modal-title" id="myModalLabel">Edit Sector</h4>'+
                        '</div>'+
                        '<div class="modal-body">'+
                        '<div id="pesan"></div>'+
                        '<div class="form-group">'+
                        '<label class="col-lg-3 control-label text-semibold">Sector</label>'+
                        '<div class="col-lg-8">'+
                        '<input class="form-control" name="name_sector" value="'+result.name_sector+'">'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '<div class="modal-footer">'+
                        '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                        '<button type="submit" class="btn btn-primary">Save changes</button>'+
                        '</div>'+
                        '</div>'+
                        '</form>'+
                        '</div>'+
                        '</div>';

                        $('#tampilmodal').empty().html(el);
                        $("#level2").select2();
                        $("#myModal").modal('show');
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
                        url         : "{{URL::to('brand/data/sector')}}/"+kode,
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
                            if(data.success==true){
                                new PNotify({
                                    title: 'Success!',
                                    text: data.pesan,
                                    addclass: 'bg-success'
                                });
                                showData();
                                $("#myModal").modal('hide');
                            }else{
                                new PNotify({
                                    title: 'Error!',
                                    text: data.pesan,
                                    addclass: 'bg-danger'
                                });
                            }
                            $('#pesan').empty();
                        },
                        error   :function() {
                            new PNotify({
                                title: 'Error!',
                                text: 'Error data',
                                addclass: 'bg-danger'
                            });
                            $('#pesan').empty();
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
                            url:"{{URL::to('brand/data/sector')}}/"+kode,
                            type:"DELETE",
                            success:function(result){
                                if(result.success==true){
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

            $(document).on("click","#import",function(){
                var sample="{{URL::to('brand/data/api/sample-sector')}}";

                var el="";
                el+='<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">'+
                '<div class="modal-dialog" role="document">'+
                '<form class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" id="formImport">'+
                '<div class="modal-content">'+
                '<div class="modal-header bg-primary">'+
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<h4 class="modal-title" id="myModalLabel">Upload New Sector</h4>'+
                '</div>'+
                '<div class="modal-body">'+
                '<div id="pesan"></div>'+
                '<input class="form-control" type="hidden" name="action" value="insert" id="action">'+
                '<div class="form-group">'+
                '<label class="col-lg-3 control-label">File</label>'+
                '<div class="col-lg-8">'+
                '<input class="form-control" type="file" name="file" id="file">'+
                '</div>'+
                '</div>'+

                "<p><small>You can download 'Format DB Sector' if you want to upload data to make sure that your data will upload has appropriate with format</small> <a href='"+sample+"'><label class='label label-success'>Click to Download Format DB Sector</label></a>"+
                '</div>'+
                '<div class="modal-footer">'+
                '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                '<button type="submit" class="btn btn-primary">Save changes</button>'+
                '</div>'+
                '</div>'+
                '</form>'+
                '</div>'+
                '</div>';

                $('#tampilmodal').empty().html(el);
                $("#myModal").modal('show');  
            })

            $(document).on("click","#editlist",function(){
                var sample="{{URL::to('brand/data/api/sample-sectorlist')}}";

                var el="";
                el+='<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">'+
                '<div class="modal-dialog" role="document">'+
                '<form class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" id="formImport">'+
                '<div class="modal-content">'+
                '<div class="modal-header bg-primary">'+
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<h4 class="modal-title" id="myModalLabel">Upload Edit Sector</h4>'+
                '</div>'+
                '<div class="modal-body">'+
                '<div id="pesan"></div>'+
                '<input class="form-control" type="hidden" name="action" value="update" id="action">'+
                '<div class="form-group">'+
                '<label class="col-lg-3 control-label">File</label>'+
                '<div class="col-lg-8">'+
                '<input class="form-control" type="file" name="file" id="file">'+
                '</div>'+
                '</div>'+

                "<p><small>You can download 'Format DB Sector' if you want to upload data to make sure that your data will upload has appropriate with format</small> <a href='"+sample+"'><label class='label label-success'>Click to Download Format DB Sector</label></a>"+
                '</div>'+
                '<div class="modal-footer">'+
                '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                '<button type="submit" class="btn btn-primary">Save changes</button>'+
                '</div>'+
                '</div>'+
                '</form>'+
                '</div>'+
                '</div>';

                $('#tampilmodal').empty().html(el);
                $("#myModal").modal('show');  
            })

            $(document).on("submit","#formImport",function(e){
                var data = new FormData(this);
                if($("#formImport")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('brand/data/api/import-sector')}}",
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
                            if(data.success==true){
                                new PNotify({
                                    title: 'Success!',
                                    text: data.pesan,
                                    addclass: 'bg-success'
                                });
                                showData();
                                $("#myModal").modal('hide');
                            }else{
                                new PNotify({
                                    title: 'Error!',
                                    text: data.pesan,
                                    addclass: 'bg-danger'
                                });
                            }
                            $('#pesan').empty();
                        },
                        error   :function() {
                            new PNotify({
                                title: 'Error!',
                                text: 'Error data',
                                addclass: 'bg-danger'
                            });
                            $('#pesan').empty();
                        }
                    });
                }else console.log("invalid form");
            });

            showData();
        })
    </script>
    @stop
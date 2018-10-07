@extends('layouts.coreui.main')

@section('content')
<div class="card card-default">
    <div class="card-header">Data Brand
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable-colvis-basic"></table>
        </div>
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
            ajax: "{{URL::to('brand/data/brand')}}",
            columns: [
                {data: 'DT_Row_Index', name: 'DT_Row_Index',title:'No.',width:'5%',searchable:false,'orderable':false},
                {data: 'id_brand', name: 'id_brand',title:'ID BRAND',width:'15%'},
                {data: 'nama_brand', name: 'nama_brand',title:'BRAND'},
                {data: 'category.name_category', name: 'category.name_category',title:'CATEGORY',defaultContent: "Data Not Found"},
                {data: 'sector.name_sector', name: 'sector.name_sector',title:'SECTOR',defaultContent: "Data Not Found"}
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

        $('.ColVis_Button').addClass('btn btn-primary btn-icon').on('click mouseover', function() {
            $('.ColVis_collection input').uniform();
        });


        $('.dataTables_filter input[type=search]').attr('placeholder', 'Type to filter...');


        $('.dataTables_length select').select2({
            minimumResultsForSearch: "-1"
        }); 
    } 

    $(document).on("click","#tambah",function(){
        $.ajax({
            url:"{{URL::to('brand/data/api/add-new-brand')}}",
            type:"GET",
            success:function(result){
                console.log(result);
                var el="";
                el+='<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">'+
                '<div class="modal-dialog" role="document">'+
                '<form class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" id="form">'+
                '<div class="modal-content">'+
                '<div class="modal-header bg-primary">'+
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<h4 class="modal-title" id="myModalLabel">New Brand</h4>'+
                '</div>'+
                '<div class="modal-body">'+
                '<div id="pesan"></div>'+
                '<div class="form-group">'+
                '<label class="col-lg-3 control-label text-semibold">Brand</label>'+
                '<div class="col-lg-8">'+
                '<input class="form-control" name="nama_brand" required>'+
                '</div>'+
                '</div>'+
                '<div class="form-group">'+
                '<label class="col-lg-3 control-label text-semibold">Category</label>'+
                '<div class="col-lg-8">'+
                '<select name="category" id="category">'+
                '<option value="">--Select Category--</option>';
                $.each(result.category,function(a,b){
                    el+="<option value='"+b.id_category+"'>"+b.name_category+"</option>";
                })
                el+='</select>'+
                '</div>'+
                '</div>'+
                '<div class="form-group">'+
                '<label class="col-lg-3 control-label text-semibold">Sector</label>'+
                '<div class="col-lg-8">'+
                '<select name="sector" id="sector">'+
                '<option value="">--Select Sector--</option>';
                $.each(result.sector,function(a,b){
                    el+="<option value='"+b.id_sector+"'>"+b.name_sector+"</option>";
                })
                el+='</select>'+
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
                $("#category").select2();
                $("#sector").select2();
                $("#myModal").modal('show');
            }
        })
    });

    $(document).on("click",".edit",function(){
        kode=$(this).attr("kode");

        $.ajax({
            url:"{{URL::to('brand/data/brand')}}/"+kode,
            type:"GET",
            success:function(result){
                console.log(result);
                var el="";
                el+='<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">'+
                '<div class="modal-dialog" role="document">'+
                '<form class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" id="formUpdate">'+
                '<div class="modal-content">'+
                '<div class="modal-header bg-primary">'+
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<h4 class="modal-title" id="myModalLabel">Edit Brand</h4>'+
                '</div>'+
                '<div class="modal-body">'+
                '<div id="pesan"></div>'+
                '<div class="form-group">'+
                '<label class="col-lg-3 control-label text-semibold">Brand</label>'+
                '<div class="col-lg-8">'+
                '<input class="form-control" name="nama_brand" value="'+result.brand.nama_brand+'">'+
                '</div>'+
                '</div>'+
                '<div class="form-group">'+
                '<label class="col-lg-3 control-label text-semibold">Category</label>'+
                '<div class="col-lg-8">'+
                '<select name="category" id="category">'+
                '<option value="">--Select Category--</option>';
                $.each(result.category,function(a,b){
                    var pilih="";
                    if(result.brand.id_category==b.id_category){
                        pilih="selected='selected'";
                    }else{
                        pilih="";
                    }
                    el+="<option value='"+b.id_category+"' "+pilih+">"+b.name_category+"</option>";
                })
                el+='</select>'+
                '</div>'+
                '</div>'+
                '<div class="form-group">'+
                '<label class="col-lg-3 control-label text-semibold">Sector</label>'+
                '<div class="col-lg-8">'+
                '<select name="sector" id="sector">'+
                '<option value="">--Select Sector--</option>';
                $.each(result.sector,function(a,b){
                    var pilih="";
                    if(result.brand.id_sector==b.id_sector){
                        pilih="selected='selected'";
                    }else{
                        pilih="";
                    }

                    el+="<option value='"+b.id_sector+"' "+pilih+">"+b.name_sector+"</option>";
                })
                el+='</select>'+
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
                $("#category").select2();
                $("#sector").select2();
                $("#myModal").modal('show');
            }
        })
    })

    $(document).on("submit","#form",function(e){
        var data = new FormData(this);
        if($("#form")[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
                url         : "{{URL::to('brand/data/brand')}}",
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

    $(document).on("submit","#formUpdate",function(e){
        var data = new FormData(this);
        data.append("_method","PUT");

        if($("#formUpdate")[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
                url         : "{{URL::to('brand/data/brand')}}/"+kode,
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
                    url:"{{URL::to('brand/data/brand')}}/"+kode,
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

    $(document).on("click","#import",function(){
        var sample="{{URL::to('brand/data/api/sample-brand')}}";

        var el="";
        el+='<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">'+
        '<div class="modal-dialog" role="document">'+
        '<form class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" id="formImport">'+
        '<div class="modal-content">'+
        '<div class="modal-header bg-primary">'+
        '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
        '<h4 class="modal-title" id="myModalLabel">Upload New Brand</h4>'+
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

        "<p><small>You can download 'Format DB Brand' if you want to upload data to make sure that your data will upload has appropriate with format</small> <a href='"+sample+"'><label class='label label-success'>Click to Download Format DB Brand</label></a>"+
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
        var sample="{{URL::to('brand/data/api/sample-brandlist')}}";

        var el="";
        el+='<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">'+
        '<div class="modal-dialog" role="document">'+
        '<form class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" id="formImport">'+
        '<div class="modal-content">'+
        '<div class="modal-header bg-primary">'+
        '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
        '<h4 class="modal-title" id="myModalLabel">Upload Edit Brand</h4>'+
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

        "<p><small>You can download 'Format DB Brand' if you want to upload data to make sure that your data will upload has appropriate with format</small> <a href='"+sample+"'><label class='label label-success'>Click to Download Format DB Brand</label></a>"+
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
            e.preventDefault();
            $.ajax({
                url         : "{{URL::to('brand/data/api/import-brand')}}",
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
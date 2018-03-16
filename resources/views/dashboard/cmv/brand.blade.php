@extends('layouts.dashboard')

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

            function showBrand(page){
                $.ajax({
                    url:"{{URL::to('cmv/data/brand')}}?page="+page,
                    type:"GET",
                    beforeSend:function(){
                        $("#tampilData").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        $("#tampilData").empty().html(result);
                    },
                    error:function(){

                    }
                })
            }

            $(document).on('click', '.pagination a', function (e) {
                showBrand($(this).attr('href').split('page=')[1]);
                e.preventDefault();
            });


            $(document).on("click","#addbrand",function(){
                var el="";

                $.ajax({
                    url:"{{URL::to('cmv/data/list-sector')}}",
                    type:"GET",
                    beforeSend:function(){
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog">'+
                                '<form id="form" class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
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
                                '<div class="modal-header bg-primary">'+
                                    '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                    '<h5 class="modal-title" id="modal-title">Add New Brand</h5>'+
                                '</div>'+

                                '<div class="modal-body">'+
                                    '<div id="pesan"></div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">SECTOR ID</label>'+
                                        '<select name="sector" id="sector" class="form-control">'+
                                            '<option value="" disabled selected>--Choose Sector</option>';
                                            $.each(result,function(a,b){
                                                el+="<option value='"+b.sector_id+"'>"+b.text+"</option>";
                                            })
                                        el+='</select>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">CATEGORY ID</label>'+
                                        '<select name="category" class="form-control" id="category"></select>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">BRAND ID</label>'+
                                        '<input class="form-control" name="brand" id="brand" placeholder="BRAND ID" required>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">BRAND NAME</label>'+
                                        '<input class="form-control" name="name" id="name" placeholder="BRAND NAME" required>'+
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

                    }
                })

            })

            $(document).on("change","#sector",function(){
                var sector=$("#sector option:selected").val();

                $.ajax({
                    url:"{{URL::to('cmv/data/list-category')}}",
                    type:"GET",
                    data:"sector="+sector,
                    beforeSend:function(){
                        $("#category").empty().html("");
                    },
                    success:function(result){
                        var el="";
                        $.each(result,function(a,b){
                            $('#category')
                                .append($("<option></option>")
                                            .attr("value",b.category_id)
                                            .text(b.text)); 
                        })
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
                        url         : "{{URL::to('cmv/data/brand')}}",
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
                                showBrand(1);
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

            $(document).on("click",".editbrand",function(){
                kode=$(this).attr("kode");
                var el="";

                $.ajax({
                    url:"{{URL::to('cmv/data/brand')}}/"+kode,
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
                                '<div class="modal-header bg-primary">'+
                                    '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                    '<h5 class="modal-title" id="modal-title">Edit Brand</h5>'+
                                '</div>'+

                                '<div class="modal-body">'+
                                    '<div id="pesan"></div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">CATEGORY ID</label>'+
                                        '<select name="category" id="category" class="form-control">'+
                                            '<option value="" disabled selected>--Choose Category</option>';
                                            $.each(result.category,function(a,b){
                                                var pilih="";
                                                if(result.brand.category_id==b.category_id){
                                                    pilih="selected='selected'";
                                                }else{
                                                    pilih="";
                                                }

                                                el+="<option value='"+b.category_id+"' "+pilih+">"+b.text+"</option>";
                                            })
                                        el+='</select>'+
                                    '</div>'+

                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">BRAND ID</label>'+
                                        '<input class="form-control" value="'+result.brand.brand_id+'" name="brand" id="brand" placeholder="BRAND ID" required>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">BRAND NAME</label>'+
                                        '<input class="form-control" value="'+result.brand.brand_name+'" name="name" id="name" placeholder="BRAND NAME" required>'+
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
                        alert('link policy not found');
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
                        url			: "{{URL::to('cmv/data/brand')}}/"+kode,
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
                                showBrand(1);
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

            $(document).on("click",".hapusbrand",function(){
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
                            url:"{{URL::to('cmv/data/brand')}}/"+kode,
                            type:"DELETE",
                            success:function(result){
                                if(result.success=true){
                                    swal("Deleted!", result.pesan, "success");
                                    showBrand(1);
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
                var sample="{{URL::to('cmv/data/sample-brand')}}";
                var el="";
                el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                    '<div class="modal-dialog">'+
                        '<form id="formImport" class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header bg-primary">'+
                                    '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                    '<h5 class="modal-title" id="modal-title">Import Data Brand</h5>'+
                                '</div>'+

                                '<div class="modal-body">'+
                                    '<div id="pesan"></div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">FILE</label>'+
                                        '<input class="form-control" type="file" name="file" id="file" placeholder="SECTOR ID" required>'+
                                    '</div>'+
                                    "<p><small>You can download 'Format DB Brand' if you want to upload data to make sure that your data will upload has appropriate with format</small> <a href='"+sample+"'><label class='label label-success'>Click to Download Format DB Brand</label></a>"+
                                '</div>'+

                                '<div class="modal-footer">'+
                                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                    '<button type="submit" class="btn btn-primary btn-ladda btn-ladda-spinner"id="simpan"> <span class="ladda-label">Upload</span> </button>'+
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
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('cmv/data/import-brand')}}",
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
                                $('#pesan').empty().html('<div class="alert alert-info">'+data.pesan+'</div>');
                                showBrand(1);
                            }else{
                                $('#pesan').empty().html('<div class="alert alert-info">'+data.pesan+'<pre>'+data.error+'</pre></div>');
                            }
                        },
                        error   :function() {  
                            $('#pesan').empty().html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            });

            $(document).on("submit","#formCari",function(e){
                var cari=$("#cari").val();
                var category=$("#category option:selected").val();

                $.ajax({
                    url:"{{URL::to('cmv/data/brand')}}",
                    type:"get",
                    data:"cari="+cari+"&category="+category,
                    beforeSend:function(){
                        $('#tampilData').empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                    },
                    success:function(result){
                        $('#tampilData').empty().html(result);
                    },
                    error:function(){
                        $('#tampilData').empty().html('<div class="alert alert-danger">Load Data Error. . .</div>');
                    }
                })
            })

            showBrand(1);
        })
    </script>
@stop

@section('heading-element')
    <div class="heading-elements">
        <div class="btn-group pull-right" role="group">
            <a href="#" class="btn bg-blue btn-labeled heading-btn" id="addbrand"><b><i class="icon-task"></i></b> Create Brand</a>

            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:60px;">                <i class="icon-gear"></i>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a href="#" href="#" id="import">
                        <i class="icon-import"></i>
                        Import Excel
                    </a>
                </li>
                <li>
                    <a href="{{URL::to('cmv/data/export-brand')}}">
                        <i class="icon-file-excel"></i>
                        Export Excel
                    </a>
                </li>
            </ul>
        </div>
    </div>
@stop

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">BRAND</h6>
        </div>

        <div class="panel-body">
        <div class="row well">
                <form onsubmit="return false;" id="formCari">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="" class="control-label">Category</label>
                            <select name="category" id="category" class="form-control">
                                <option value="" disabled selected>--Select Category--</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="" class="control-label">Keyword</label>
                            <input type="text" class="form-control" name="cari" id="cari" placeholder="Brand ID / Brand Name">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="" class="control-label"></label>
                            <button class="btn btn-primary" style="margin-top:25px;">
                                <i class="icon-filter4"></i> Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div id="tampilData"></div>
        </div>
    </div>

    <div id="divModal"></div>
@stop
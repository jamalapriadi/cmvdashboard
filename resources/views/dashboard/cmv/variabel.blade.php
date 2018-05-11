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

            function showSector(page){
                var brand=$("#brand").val();
                var sub=$("#sub").val();
                var quartal=$("#quartal").val();

                $.ajax({
                    url:"{{URL::to('cmv/data/variabel')}}?page="+page,
                    type:"GET",
                    data:"brand="+brand+"&sub="+sub+"&quartal="+quartal,
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
                showSector($(this).attr('href').split('page=')[1]);
                e.preventDefault();
            });

            $(document).on("click","#addsector",function(){
                var el="";
                el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                    '<div class="modal-dialog">'+
                        '<form id="form" class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header bg-primary text-white">'+
                                    '<h5 class="modal-title" id="modal-title">Input New Variabel</h5>'+
                                    '<button type="button" class="close" data-dismiss="modal"></button>'+
                                '</div>'+

                                '<div class="modal-body">'+
                                    '<div id="pesan"></div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Brand</label>'+
                                        '<input class="remote-data-brand" name="brand" id="brand">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Subdemo Name</label>'+
                                        '<input class="remote-data-list-sub-demo" name="subdemo" id="subdemo">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Quartal</label>'+
                                        '<input type="number" class="form-control" name="quartal" id="quartal">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Total Thousand</label>'+
                                        '<input type="number" class="form-control" name="thousand" id="thousand">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Total Vertikal</label>'+
                                        '<input type="number" class="form-control" name="vertikal" id="vertikal">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Total Horizontal</label>'+
                                        '<input type="number" class="form-control" name="horizontal" id="horizontal">'+
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

                $(".remote-data-brand").select2({
                    ajax: {
                        url: "{{URL::to('cmv/data/list-brand')}}",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params, // search term
                                page_limit: 30
                            };
                        },
                        results: function (data, page){
                            return {
                                results: data.data
                            };
                        },
                        cache: true,
                        pagination: {
                            more: true
                        }
                    },
                    formatResult: function(m){
                        var markup="<option value='"+m.id+"'>"+m.text+"</option>";
        
                        return markup;                
                    },
                    formatSelection: function(m){
                        return m.text;
                    },
                    escapeMarkup: function (m) { return m; }
                })

                $(".remote-data-list-sub-demo").select2({
                    ajax: {
                        url: "{{URL::to('cmv/data/list-sub-demo')}}",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params, // search term
                                page_limit: 30
                            };
                        },
                        results: function (data, page){
                            return {
                                results: data.data
                            };
                        },
                        cache: true,
                        pagination: {
                            more: true
                        }
                    },
                    formatResult: function(m){
                        var markup="<option value='"+m.id+"'>"+m.text+"</option>";
        
                        return markup;                
                    },
                    formatSelection: function(m){
                        return m.text;
                    },
                    escapeMarkup: function (m) { return m; }
                })
            })

            $(document).on("submit","#form",function(e){
                var data = new FormData(this);
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('cmv/data/variabel')}}",
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
                                showSector(1);
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

            $(document).on("click",".editvariabel",function(){
                kode=$(this).attr("kode");

                $.ajax({
                    url:"{{URL::to('cmv/data/variabel')}}/"+kode+"/edit",
                    type:"GET",
                    success:function(result){
                        var el="";
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog">'+
                                '<form class="form-horizontal" id="formUpdate" onsubmit="return false;" enctype="multipart/form-data">'+
                                    '<div class="modal-content">'+
                                        '<div class="modal-header bg-primary text-white">'+
                                            '<h5 class="modal-title" id="modal-title">Edit Demography</h5>'+
                                            '<button type="button" class="close" data-dismiss="modal"></button>'+
                                        '</div>'+

                                        '<div class="modal-body">'+
                                            '<div id="pesan"></div>'+
                                            '<div class="form-group">'+
                                                '<label class="control-label text-semibold">Brand</label>'+
                                                '<input class="remote-data-brand" name="brand" id="brand" value="'+result.brand_id+'">'+
                                            '</div>'+
                                            '<div class="form-group">'+
                                                '<label class="control-label text-semibold">Subdemo Name</label>'+
                                                '<input class="remote-data-list-sub-demo" name="subdemo" id="subdemo" value="'+result.subdemo_id+'">'+
                                            '</div>'+
                                            '<div class="form-group">'+
                                                '<label class="control-label text-semibold">Quartal</label>'+
                                                '<input type="number" class="form-control" name="quartal" id="quartal" value="'+result.quartal+'">'+
                                            '</div>'+
                                            '<div class="form-group">'+
                                                '<label class="control-label text-semibold">Total Thousand</label>'+
                                                '<input type="number" class="form-control" name="thousand" id="thousand" value="'+result.totals_thousand+'">'+
                                            '</div>'+
                                            '<div class="form-group">'+
                                                '<label class="control-label text-semibold">Total Vertikal</label>'+
                                                '<input type="number" class="form-control" name="vertikal" id="vertikal" value="'+result.totals_ver+'">'+
                                            '</div>'+
                                            '<div class="form-group">'+
                                                '<label class="control-label text-semibold">Total Horizontal</label>'+
                                                '<input type="number" class="form-control" name="horizontal" id="horizontal" value="'+result.total_hor+'">'+
                                            '</div>'+
                                        '</div>'+

                                        '<div class="modal-footer">'+
                                            '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                            '<button type="submit" class="btn btn-primary btn-ladda btn-ladda-spinner"id="simpan"> <span class="ladda-label">Simpan</span> </button>'+
                                        '</div>'+
                                    '</div>'+
                                '</form>'+
                            '</div>'+
                        '</div>';

                        $("#divModal").empty().html(el);
                        $("#modal_default").modal("show");          

                        $(".remote-data-brand").select2({
                            initSelection: function(element, callback) {
                                callback({id: result.brand_id, text: result.brand.brand_name });
                            },
                            ajax: {
                                url: "{{URL::to('cmv/data/list-brand')}}",
                                dataType: 'json',
                                delay: 250,
                                data: function (params) {
                                    return {
                                        q: params, // search term
                                        page_limit: 30
                                    };
                                },
                                results: function (data, page){
                                    return {
                                        results: data.data
                                    };
                                },
                                cache: true,
                                pagination: {
                                    more: true
                                }
                            },
                            formatResult: function(m){
                                var markup="<option value='"+m.id+"'>"+m.text+"</option>";
                
                                return markup;                
                            },
                            formatSelection: function(m){
                                return m.text;
                            },
                            escapeMarkup: function (m) { return m; }
                        })

                        $(".remote-data-list-sub-demo").select2({
                            initSelection: function(element, callback) {
                                callback({id: result.subdemo_id, text: result.subdemo.subdemo_name });
                            },
                            ajax: {
                                url: "{{URL::to('cmv/data/list-sub-demo')}}",
                                dataType: 'json',
                                delay: 250,
                                data: function (params) {
                                    return {
                                        q: params, // search term
                                        page_limit: 30
                                    };
                                },
                                results: function (data, page){
                                    return {
                                        results: data.data
                                    };
                                },
                                cache: true,
                                pagination: {
                                    more: true
                                }
                            },
                            formatResult: function(m){
                                var markup="<option value='"+m.id+"'>"+m.text+"</option>";
                
                                return markup;                
                            },
                            formatSelection: function(m){
                                return m.text;
                            },
                            escapeMarkup: function (m) { return m; }
                        })
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
                        url			: "{{URL::to('cmv/data/variabel')}}/"+kode,
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
                                showSector(1);
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

            $(document).on("click",".hapusvariabel",function(){
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
                            url:"{{URL::to('cmv/data/variabel')}}/"+kode,
                            type:"DELETE",
                            success:function(result){
                                if(result.success=true){
                                    swal("Deleted!", result.pesan, "success");
                                    showSector(1);
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
                var sample="{{URL::to('cmv/data/sample-variabel')}}";
                var el="";
                el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                    '<div class="modal-dialog">'+
                        '<form id="formImport" class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header bg-primary text-white">'+
                                    '<h5 class="modal-title" id="modal-title">Import Data Variabel</h5>'+
                                    '<button type="button" class="close" data-dismiss="modal"></button>'+
                                '</div>'+

                                '<div class="modal-body">'+
                                    '<div id="pesan"></div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">FILE</label>'+
                                        '<input class="form-control" type="file" name="file" id="file" placeholder="SECTOR ID" required>'+
                                    '</div>'+
                                    "<p><small>You can download 'Format DB variabel' if you want to upload data to make sure that your data will upload has appropriate with format</small> <a href='"+sample+"'><label class='label label-success'>Click to Download Format DB variabel</label></a>"+
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

            $(document).on("click","#rollback",function(){
                var sample="{{URL::to('cmv/data/sample-variabel')}}";
                var el="";
                el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                    '<div class="modal-dialog">'+
                        '<form id="formRollback" class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header bg-primary text-white">'+
                                    '<h5 class="modal-title" id="modal-title">Rollback Data Variabel</h5>'+
                                    '<button type="button" class="close" data-dismiss="modal"></button>'+
                                '</div>'+

                                '<div class="modal-body">'+
                                    '<div id="pesan"></div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">FILE</label>'+
                                        '<input class="form-control" type="file" name="file" id="file" placeholder="SECTOR ID" required>'+
                                    '</div>'+
                                    "<p><small>You can download 'Format DB variabel' if you want to upload data to make sure that your data will upload has appropriate with format</small> <a href='"+sample+"'><label class='label label-success'>Click to Download Format DB variabel</label></a>"+
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
                data.append("_token","{{ csrf_token() }}");
                if($("#formImport")[0].checkValidity()) {
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('cmv/data/import-variabel')}}",
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
                                showSector(1);
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

            $(document).on("submit","#formRollback",function(e){
                var data = new FormData(this);
                data.append("_token","{{ csrf_token() }}");
                if($("#formRollback")[0].checkValidity()) {
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('cmv/data/rollback-variabel')}}",
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
                                showSector(1);
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
                showSector(1);
            })

            $(".remote-data-brand").select2({
                ajax: {
                    url: "{{URL::to('cmv/data/list-brand')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params, // search term
                            page_limit: 30
                        };
                    },
                    results: function (data, page){
                        return {
                            results: data.data
                        };
                    },
                    cache: true,
                    pagination: {
                        more: true
                    }
                },
                formatResult: function(m){
                    var markup="<option value='"+m.id+"'>"+m.text+"</option>";
    
                    return markup;                
                },
                formatSelection: function(m){
                    return m.text;
                },
                escapeMarkup: function (m) { return m; }
            })

            $(".remote-data-list-sub-demo").select2({
                ajax: {
                    url: "{{URL::to('cmv/data/list-sub-demo')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params, // search term
                            page_limit: 30
                        };
                    },
                    results: function (data, page){
                        return {
                            results: data.data
                        };
                    },
                    cache: true,
                    pagination: {
                        more: true
                    }
                },
                formatResult: function(m){
                    var markup="<option value='"+m.id+"'>"+m.text+"</option>";
    
                    return markup;                
                },
                formatSelection: function(m){
                    return m.text;
                },
                escapeMarkup: function (m) { return m; }
            })

            showSector(1);
        })
    </script>
@stop

@section('heading-element')
    <div class="heading-elements">
        <div class="btn-group pull-right" role="group">
            <a href="#" class="btn bg-blue btn-labeled heading-btn" id="addsector"><b><i class="icon-task"></i></b> Create Input Variabel</a>

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
                    <a href="{{URL::to('cmv/data/export-demography')}}">
                        <i class="icon-file-excel"></i>
                        Export Excel
                    </a>
                </li>
                <li>
                    <a href="#" href="#" id="rollback">
                        <i class="icon-history"></i>
                        Rollback Excel
                    </a>
                </li>
            </ul>
        </div>
    </div>
@stop

@section('content')
    <div class="page-header">
        <h1 class="page-title">
            VARIABEL
        </h1>
        <!-- <div class="page-subtitle">1 - 12 of 1713 photos</div> -->
        <div class="page-options d-flex">
        <div class="btn-group pull-right" role="group">
            <a href="#" class="btn btn-primary btn-labeled heading-btn" id="addsector"><b><i class="icon-task"></i></b> Create Input Variabel</a>
            <div class="dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-gear"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" id="import">Import Excel</a>
                    <a class="dropdown-item" href="{{URL::to('cmv/data/export-category')}}">Export Excel</a>
                    <a class="dropdown-item" href="#" id="rollback">Rollback Excel</a>
                </div>
            </div>
        </div>
        </div>
    </div>


    <div class="card card-default">
        <div class="card-body">
            <form onsubmit="return false;" id="formCari">
                <div class="row well">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="" class="control-label">Brand</label>
                            <input type="text" name="brand" id="brand" class="remote-data-brand">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="" class="control-label">Subdemography Name</label>
                            <input type="text" name="sub" id="sub" class="remote-data-list-sub-demo">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="" class="control-label">Quartal</label>
                            <select name="quartal" id="quartal" class="form-control">
                                <option value="" disabled selected>--Quartal--</option>
                            </select>
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
                </div>
            </form>
            <div id="tampilData"></div>
        </div>
    </div>

    <div id="divModal"></div>
@stop
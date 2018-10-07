@extends('layouts.coreui.main')

@section('content')
<div class="card card-default">
    <div class="card-header">Data Product
    </div>
    <div class="card-body">
        <table class="table table-striped datatable-colvis-basic"></table>
    </div>
</div>

<div id="tampilmodal"></div>
<div id="modalBrand"></div>
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
                ajax: "{{URL::to('brand/data/produk')}}",
                columns: [
                    {data: 'DT_Row_Index', name: 'DT_Row_Index',title:'No.',width:'5%',searchable:false,'orderable':false},
                    {data: 'id_produk', name: 'id_produk',title:'ID PRODUK',width:'15%',visible:false},
                    {data: 'nama_produk', name: 'nama_produk',title:'PRODUCT'},
                    {data: 'brand.nama_brand', name: 'brand.nama_brand',title:'BRAND',defaultContent: "Data Not Found"},
                    {data: 'advertiser.nama_adv', name: 'advertiser.nama_adv',title:'ADVERTISER',defaultContent: "Data Not Found"},
                    {data: 'sector.name_sector', name: 'sector.name_sector',title:'SECTOR',defaultContent: "Data Not Found"},
                    {data: 'category.name_category', name: 'category.name_category',title:'CATEGORY',visible:false,defaultContent: "Data Not Found"}
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
                '<div class="modal-content">'+
                '<div class="modal-header bg-primary">'+
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<h4 class="modal-title" id="myModalLabel">New Product</h4>'+
                '</div>'+
                '<div class="modal-body">'+
                '<div id="pesan"></div>'+
                '<div>'+
                '<form class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" id="form">'+
                '<div class="form-group">'+
                '<label class="col-lg-3 control-label text-semibold">Name Product</label>'+
                '<div class="col-lg-8">'+
                '<input class="form-control" name="nama_produk" placeholder="Name Product" required>'+
                '</div>'+
                '</div>'+
                '<div class="form-group">'+
                '<label class="col-lg-3 control-label text-semibold">Category</label>'+
                '<div class="col-lg-8">'+
                '<input type="hidden" name="category" id="category" placeholder="category">'+
                '<input type="text" class="remote-data-category" id="remote-category">'+
                '</div>'+
                '</div>'+
                '<div class="form-group">'+
                '<label class="col-lg-3 control-label text-semibold">Sector</label>'+
                '<div class="col-lg-8">'+
                '<input type="hidden" name="sector" id="sector" placeholder="sector">'+
                '<input type="text" class="remote-data-sector">'+
                '</div>'+
                '</div>'+
                '<div class="form-group">'+
                '<label class="col-lg-3 control-label text-semibold">Brand</label>'+
                '<div class="col-lg-7">'+
                '<input type="hidden" name="brand" id="brand" placeholder="brand">'+
                '<input type="text" class="remote-data-brand" id="brands">'+
                '</div>'+
                '<div class="col-lg-1">'+
                '<a class="btn btn-primary btn-sm" href="javascript:void(0)" id="addBrand">'+
                '<i class="icon-add"></i>'+
                '</a>'+
                '</div>'+
                '</div>'+
                '<div class="form-group">'+
                '<label class="col-lg-3 control-label text-semibold">Advertiser</label>'+
                '<div class="col-lg-7">'+
                '<input type="hidden" name="advertiser" id="advertiser" placeholder="advertiser">'+
                '<input type="text" class="remote-data-advertiser">'+
                '</div>'+
                '<div class="col-lg-1">'+
                '<a class="btn btn-primary btn-sm" href="javascript:void(0)" id="addAdvertiser">'+
                '<i class="icon-add"></i>'+
                '</a>'+
                '</div>'+
                '</div>'+
                '<div class="form-group">'+
                '<label class="col-lg-3 control-label text-semibold">Target Audience</label>'+
                '<div class="col-lg-7">'+
                '<input type="hidden" name="ta" id="ta" placeholder="target audience">'+
                '<input type="text" class="remote-data-ta">'+
                '</div>'+
                '</div>'+
                '<hr>'+
                '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                '<button type="submit" class="btn btn-primary">Save changes</button>'+
                '</form>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '</div>';

                $('#tampilmodal').empty().html(el);
                $("#myModal").modal('show');

                remoteBrand();
                remoteAdvertiser();
                remoteCategory();
                remoteSector();
                remoteTA();
            });

function remoteBrand(){
    $(".remote-data-brand").select2({
        minimumInputLength: 2,
        placeholder: "Search for a Brand",
        ajax: {
            url: "{{URL::to('sosmed/data/api/list-brand')}}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                                q: params, // search term
                                page_limit: 100,
                            };
                        },
                        results: function (data, page){
                            return {
                                results: data.brand
                            };
                        },
                        cache: true
                    },
                    formatResult: brandFormatResult,
                    formatSelection: brandFormatSelection,
                    escapeMarkup: function (m) { return m; }
                })
}

function remoteTA(){
    $(".remote-data-ta").select2({
        placeholder: "Search for a targetaudience",
        ajax: {
            url: "{{URL::to('sosmed/data/api/list-ta')}}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params, 
                    page_limit: 10,
                };
            },
            results: function (data, page){
                return {
                    results: data.ta
                };
            },
            cache: true
        },
        formatResult: taFormatResult,
        formatSelection: taFormatSelection,
        escapeMarkup: function (m) { return m; }
    })
}

function showCategory(){
    $.ajax({
        url:"{{URL::to('sosmed/data/api/list-category')}}",
        type:"GET",
        success:function(result){
            var el="";
            el+="<select name='category' id='categorys'>"+
            '<option value="">--Select Category--</option>';
            $.each(result.category,function(a,b){
                el+="<option value='"+b.id+"'>"+b.text+"</option>";
            })
            el+='</select>';

            $("#divCategory").empty().html(el);
            $("#categorys").select2();
        }
    })
}

function showSector(){
    $.ajax({
        url:"{{URL::to('sosmed/data/api/list-sector')}}",
        type:"GET",
        success:function(result){
            var el="";
            el+="<select name='sector' id='sectors'>"+
            '<option value="">--Select Sector--</option>';
            $.each(result.sector,function(a,b){
                el+="<option value='"+b.id+"'>"+b.text+"</option>";
            })
            el+='</select>';

            $("#divSector").empty().html(el);
            $("#sectors").select2();
        }
    })   
}

function showTypeAdvertiser(){
    $.ajax({
        url:"{{URL::to('sosmed/data/api/list-advertiser-type')}}",
        type:"GET",
        success:function(result){
            var el="";
            el+="<select name='type' id='type' class='form-control'>"+
            '<option value="">--Select Type--</option>';
            $.each(result,function(a,b){
                el+="<option value='"+b.id_advtype+"'>"+b.name_advtype+"</option>";
            })
            el+="</select>";

            $("#divTypeAdvertiser").empty().html(el);
        }
    })
}

function brandFormatResult(brand) {
    var markup="<option value='"+brand.id+"'>"+brand.text+"</option>";

    return markup;
}
function taFormatResult(ta) {
    var markup="<option value='"+ta.id+"'>"+ta.text+"</option>";

    return markup;
}

            // Format selection
            function brandFormatSelection(data){
                $("#brand").val(data.id);
                return data.text;
            }

            function taFormatSelection(data){
                $("#ta").val(data.id);
                return data.text;
            }

            function remoteAdvertiser(){
                $(".remote-data-advertiser").select2({
                    minimumInputLength: 2,
                    placeholder: "Search for a Advertiser",
                    ajax: {
                        url: "{{URL::to('sosmed/data/api/list-advertiser')}}",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params, // search term
                                page_limit: 10,
                            };
                        },
                        results: function (data, page){
                            return {
                                results: data.advertiser
                            };
                        },
                        cache: true
                    },
                    formatResult: advertiserFormatResult,
                    formatSelection: advertiserFormatSelection,
                    escapeMarkup: function (m) { return m; }
                })
            }

            function advertiserFormatResult(data) {
                var markup="<option value='"+data.id+"'>"+data.text+"</option>";
                
                return markup;
            }

            // Format selection
            function advertiserFormatSelection(data) {
                $("#advertiser").val(data.id);
                return data.text;
            }

            function remoteCategory(){
                $(".remote-data-category").select2({
                    placeholder: "Search for a Category",
                    ajax: {
                        url: "{{URL::to('sosmed/data/api/list-category')}}",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params, // search term
                                page_limit: 10,
                            };
                        },
                        results: function (data, page){
                            return {
                                results: data.category
                            };
                        },
                        cache: true
                    },
                    formatResult: categoryFormatResult,
                    formatSelection: categoryFormatSelection,
                    escapeMarkup: function (m) { return m; }
                })
            }

            function categoryFormatResult(category) {
                var markup="<option value='"+category.id+"'>"+category.text+"</option>";
                
                return markup;
            }

            // Format selection
            function categoryFormatSelection(category) { 
                $("#category").val(category.id);
                return category.text;
            }

            function remoteSector(){
                $(".remote-data-sector").select2({
                    placeholder: "Search for a Sector",
                    ajax: {
                        url: "{{URL::to('sosmed/data/api/list-sector')}}",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params, // search term
                                page_limit: 10,
                            };
                        },
                        results: function (data, page){
                            return {
                                results: data.sector
                            };
                        },
                        cache: true
                    },
                    formatResult: sectorFormatResult,
                    formatSelection: sectorFormatSelection,
                    escapeMarkup: function (m) { return m; }
                })
            }

            function sectorFormatResult(sector) {
                var markup="<option value='"+sector.id+"'>"+sector.text+"</option>";
                
                return markup;
            }

            // Format selection
            function sectorFormatSelection(sector) { 
                $("#sector").val(sector.id);
                return sector.text;
            }

            $(document).on("submit","#form",function(e){
                var data = new FormData(this);
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('sosmed/data/produk')}}",
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
                                $('#myModal').modal('hide');
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

            $(document).on("click","#import",function(){
                var sample="{{URL::to('sosmed/data/api/sample-produk')}}";

                var el="";
                el+='<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">'+
                '<div class="modal-dialog" role="document">'+
                '<form class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" id="formImport">'+
                '<div class="modal-content">'+
                '<div class="modal-header bg-primary">'+
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<h4 class="modal-title" id="myModalLabel">Upload New Product</h4>'+
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

                "<p><small>You can download 'Format DB Product' if you want to upload data to make sure that your data will upload has appropriate with format</small> <a href='"+sample+"'><label class='label label-success'>Click to Download Format DB Product</label></a>"+
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
                var sample="{{URL::to('sosmed/data/api/sample-produklist')}}";

                var el="";
                el+='<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">'+
                '<div class="modal-dialog" role="document">'+
                '<form class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" id="formImport">'+
                '<div class="modal-content">'+
                '<div class="modal-header bg-primary">'+
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<h4 class="modal-title" id="myModalLabel">Upload Edit Product</h4>'+
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

                "<p><small>You can download 'Format DB Product' if you want to upload data to make sure that your data will upload has appropriate with format</small> <a href='"+sample+"'><label class='label label-success'>Click to Download Format DB Product</label></a>"+
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
                        url         : "{{URL::to('sosmed/data/api/import-produk')}}",
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
                                $('#myModal').modal('hide');
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
                    url:"{{URL::to('sosmed/data/produk')}}/"+kode,
                    type:"GET",
                    success:function(result){
                        var el="";
                        el+='<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">'+
                        '<div class="modal-dialog" role="document">'+
                        '<div class="modal-content">'+
                        '<div class="modal-header bg-primary">'+
                        '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<h4 class="modal-title" id="myModalLabel">Edit Product</h4>'+
                        '</div>'+
                        '<div class="modal-body">'+
                        '<div id="pesan"></div>'+
                        '<div>'+
                        '<form class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" id="formUpdate">'+
                        '<div class="form-group">'+
                        '<label class="col-lg-3 control-label text-semibold">Name Product</label>'+
                        '<div class="col-lg-8">'+
                        '<input class="form-control" name="nama_produk" placeholder="Name Product" value="'+result.nama_produk+'">'+
                        '</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                        '<label class="col-lg-3 control-label text-semibold">Category</label>'+
                        '<div class="col-lg-8">'+
                        '<input type="hidden" name="category" id="category" placeholder="category" value="'+result.id_category+'">'+
                        '<input type="text" class="remote-data-category">'+
                        '</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                        '<label class="col-lg-3 control-label text-semibold">Sector</label>'+
                        '<div class="col-lg-8">'+
                        '<input type="hidden" name="sector" id="sector" placeholder="sector" value="'+result.id_sector+'">'+
                        '<input type="text" class="remote-data-sector">'+
                        '</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                        '<label class="col-lg-3 control-label text-semibold">Brand</label>'+
                        '<div class="col-lg-7">'+
                        '<input type="hidden" name="brand" id="brand" placeholder="brand" value="'+result.id_brand+'">'+
                        '<input type="text" class="remote-data-brand">'+
                        '</div>'+
                        '<div class="col-lg-1">'+
                        '<a class="btn btn-primary btn-sm" href=javascript:void(0) id="addBrand">'+
                        '<i class="icon-add"></i>'+
                        '</a>'+
                        '</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                        '<label class="col-lg-3 control-label text-semibold">Advertiser</label>'+
                        '<div class="col-lg-7">'+
                        '<input type="hidden" name="advertiser" id="advertiser" placeholder="advertiser" value="'+result.id_brand+'">'+
                        '<input type="text" class="remote-data-advertiser">'+
                        '</div>'+
                        '<div class="col-lg-1">'+
                        '<a class="btn btn-primary btn-sm" href=javascript:void(0) id="addAdvertiser">'+
                        '<i class="icon-add"></i>'+
                        '</a>'+
                        '</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                        '<label class="col-lg-3 control-label text-semibold">Target Audience</label>'+
                        '<div class="col-lg-7">'+
                        '<input type="hidden" name="ta" id="ta" placeholder="target audience" value="'+result.id_ta+'">'+
                        '<input type="text" class="remote-data-ta">'+
                        '</div>'+
                        '</div>'+
                        '<hr>'+
                        '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                        '<button type="submit" class="btn btn-primary">Save changes</button>'+
                        '</form>'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '</div>';

                        $('#tampilmodal').empty().html(el);
                        $("#myModal").modal('show');

                        $(".remote-data-category").select2({
                            initSelection: function(element, callback) {
                                callback({id: result.id_category, text: result.category.name_category });
                            },
                            ajax: {
                                url: "{{URL::to('sosmed/data/api/list-category')}}",
                                dataType: 'json',
                                quietMillis: 100,
                                data: function (term, page) {
                                    return {
                                        q: term //search term
                                    };
                                },
                                results: function (data, page) {
                                    return {results: data.category, more: false};
                                }
                            },
                            formatResult: categoryFormatResult,
                            formatSelection: categoryFormatSelection,
                            escapeMarkup: function (m) { return m; }
                        });

                        $(".remote-data-brand").select2({
                            initSelection: function(element, callback) {
                                callback({id: result.id_brand, text: result.brand.nama_brand });
                            },
                            minimumInputLength: 3,
                            ajax: {
                                url: "{{URL::to('sosmed/data/api/list-brand')}}",
                                dataType: 'json',
                                quietMillis: 100,
                                data: function (term, page) {
                                    return {
                                        q: term //search term
                                    };
                                },
                                results: function (data, page) {
                                    return {results: data.brand, more: false};
                                }
                            },
                            formatResult: brandFormatResult,
                            formatSelection: brandFormatSelection,
                            escapeMarkup: function (m) { return m; }
                        });

                        $(".remote-data-sector").select2({
                            initSelection: function(element, callback) {
                                callback({id: result.id_sector, text: result.sector.name_sector });
                            },
                            ajax: {
                                url: "{{URL::to('sosmed/data/api/list-sector')}}",
                                dataType: 'json',
                                quietMillis: 100,
                                data: function (term, page) {
                                    return {
                                        q: term //search term
                                    };
                                },
                                results: function (data, page) {
                                    return {results: data.sector, more: false};
                                }
                            },
                            formatResult: sectorFormatResult,
                            formatSelection: sectorFormatSelection,
                            escapeMarkup: function (m) { return m; }
                        });

                        $(".remote-data-advertiser").select2({
                            initSelection: function(element, callback) {
                                callback({id: result.id_adv, text: result.advertiser.nama_adv });
                            },
                            minimumInputLength: 3,
                            ajax: {
                                url: "{{URL::to('sosmed/data/api/list-advertiser')}}",
                                dataType: 'json',
                                quietMillis: 100,
                                data: function (term, page) {
                                    return {
                                        q: term //search term
                                    };
                                },
                                results: function (data, page) {
                                    return {results: data.advertiser, more: false};
                                }
                            },
                            formatResult: advertiserFormatResult,
                            formatSelection: advertiserFormatSelection,
                            escapeMarkup: function (m) { return m; }
                        });
                        $(".remote-data-ta").select2({
                            initSelection: function(element, callback) {
                                callback({id: result.id_ta, text: result.ta.TA_NAME });
                            },
                            ajax: {
                                url: "{{URL::to('sosmed/data/api/list-ta')}}",
                                dataType: 'json',
                                quietMillis: 100,
                                data: function (term, page) {
                                    return {
                                        q: term //search term
                                    };
                                },
                                results: function (data, page) {
                                    return {results: data.ta, more: false};
                                }
                            },
                            formatResult: taFormatResult,
                            formatSelection: taFormatSelection,
                            escapeMarkup: function (m) { return m; }
                        });

                    }
                })
})

$(document).on("submit","#formUpdate",function(e){
    var data = new FormData(this);
    data.append("_method","PUT");
    if($("#formUpdate")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('sosmed/data/produk')}}/"+kode,
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
                                $('#myModal').modal('hide');
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
                url:"{{URL::to('sosmed/data/produk')}}/"+kode,
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

$(document).on("click","#addBrand",function(){
    var el="";
    el+='<div class="modal fade" id="myModalBrand" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">'+
    '<div class="modal-dialog" role="document">'+
    '<div class="modal-content">'+
    '<div class="modal-header bg-warning">'+
    '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
    '<h4 class="modal-title" id="myModalLabel">Add New Brand</h4>'+
    '</div>'+
    '<div class="modal-body">'+
    '<div id="modalNew">'+
    '<form class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" id="formBrand">'+
    '<div id="pesanBrand"></div>'+
    '<div class="form-group">'+
    '<label class="col-lg-3 control-label text-semibold">Brand</label>'+
    '<div class="col-lg-8">'+
    '<input class="form-control" name="nama_brand" placeholder="Brand" required>'+
    '</div>'+
    '</div>'+
    '<div class="form-group">'+
    '<label class="col-lg-3 control-label text-semibold">Category</label>'+
    '<div class="col-lg-8">'+
    '<div id="divCategory"></div>'+
    '</div>'+
    '</div>'+
    '<div class="form-group">'+
    '<label class="col-lg-3 control-label text-semibold">Sector</label>'+
    '<div class="col-lg-8">'+
    '<div id="divSector"></div>'+
    '</div>'+
    '</div>'+
    '<hr>'+
    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
    '<button type="submit" class="btn btn-primary">Save changes</button>'+
    '</form>'+
    '</div>'+
    '</div>'+
    '</div>'+
    '</div>'+
    '</div>';
    $("#modalBrand").empty().html(el);
    $("#myModal").modal('hide');
    $("#myModalBrand").modal("show");
    showCategory();
    showSector();
})

$(document).on('hide.bs.modal','#myModalBrand', function () {
    $("#myModal").modal('show');
});

$(document).on("submit","#formBrand",function(e){
    var data = new FormData(this);
    if($("#formBrand")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('sosmed/data/api/add-new-brand')}}",
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $('#pesanBrand').html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {
                            if(data.success==true){
                                $('#pesanBrand').empty().html('<div class="alert alert-info">'+data.pesan+'</div>');
                                $("#myModalBrand").modal("hide");
                                $("#myModal").modal('show');
                                
                                $(".remote-data-brand").select2({
                                    initSelection: function(element, callback) {
                                        callback({id: data.id_brand, text: data.nama_brand });
                                    },
                                    minimumInputLength: 3,
                                    ajax: {
                                        url: "{{URL::to('sosmed/data/api/list-brand')}}",
                                        dataType: 'json',
                                        quietMillis: 100,
                                        data: function (term, page) {
                                            return {
                                                q: term //search term
                                            };
                                        },
                                        results: function (data, page) {
                                            return {results: data.brand, more: false};
                                        }
                                    },
                                    formatResult: brandFormatResult,
                                    formatSelection: brandFormatSelection,
                                    escapeMarkup: function (m) { return m; }
                                });
                            }else{
                                $('#pesanBrand').empty().html('<div class="alert alert-info">'+data.pesan+'<pre>'+data.error+'</pre></div>');
                            }
                        },
                        error   :function() {  
                            $('#pesanBrand').empty().html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            });

$(document).on("click","#addAdvertiser",function(){
    var el="";
    el+='<div class="modal fade" id="myModalBrand" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">'+
    '<div class="modal-dialog" role="document">'+
    '<div class="modal-content">'+
    '<div class="modal-header bg-warning">'+
    '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
    '<h4 class="modal-title" id="myModalLabel">Add New Advertiser</h4>'+
    '</div>'+
    '<div class="modal-body">'+
    '<div id="modalNew">'+
    '<form class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" id="formAdvertiser">'+
    '<div id="pesanBrand"></div>'+
    '<div class="form-group">'+
    '<label class="col-lg-3 control-label text-semibold">Advertiser</label>'+
    '<div class="col-lg-8">'+
    '<input class="form-control" name="nama_adv" placeholder="Advertiser" required>'+
    '</div>'+
    '</div>'+
    '<div class="form-group">'+
    '<label class="col-lg-3 control-label text-semibold">Type</label>'+
    '<div class="col-lg-8">'+
    '<div id="divTypeAdvertiser"></div>'+
    '</div>'+
    '</div>'+
    '<div class="form-group">'+
    '<label class="col-lg-3 control-label text-semibold">Is Group</label>'+
    '<div class="col-lg-8">'+
    '<select name="group" id="group" class="form-control">'+
    '<option value="">--Select Group--</option>'+
    '<option value="N">No</option>'+
    '<option value="Y">Yes</option>'+
    '</select>'+
    '</div>'+
    '</div>'+
    '<hr>'+
    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
    '<button type="submit" class="btn btn-primary">Save changes</button>'+
    '</form>'+
    '</div>'+
    '</div>'+
    '</div>'+
    '</div>'+
    '</div>';
    $("#modalBrand").empty().html(el);
    $("#myModal").modal('hide');
    $("#myModalBrand").modal("show");
    showTypeAdvertiser();
});

$(document).on("submit","#formAdvertiser",function(e){
    var data = new FormData(this);
    if($("#formAdvertiser")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('sosmed/data/api/add-new-advertiser')}}",
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $('#pesanBrand').html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {
                            if(data.success==true){
                                $('#pesanBrand').empty().html('<div class="alert alert-info">'+data.pesan+'</div>');
                                $("#myModalBrand").modal("hide");
                                $("#myModal").modal('show');
                                
                                $(".remote-data-advertiser").select2({
                                    initSelection: function(element, callback) {
                                        callback({id: data.id_advertiser, text: data.nama_adv });
                                    },
                                    minimumInputLength: 3,
                                    ajax: {
                                        url: "{{URL::to('sosmed/data/api/list-advertiser')}}",
                                        dataType: 'json',
                                        quietMillis: 100,
                                        data: function (term, page) {
                                            return {
                                                q: term //search term
                                            };
                                        },
                                        results: function (data, page) {
                                            return {results: data.advertiser, more: false};
                                        }
                                    },
                                    formatResult: advertiserFormatResult,
                                    formatSelection: advertiserFormatSelection,
                                    escapeMarkup: function (m) { return m; }
                                });
                            }else{
                                $('#pesanBrand').empty().html('<div class="alert alert-info">'+data.pesan+'<pre>'+data.error+'</pre></div>');
                            }
                        },
                        error   :function() {  
                            $('#pesanBrand').empty().html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            });

showData();
})
</script>
@stop
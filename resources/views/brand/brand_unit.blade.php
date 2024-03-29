@extends('layouts.coreui.main')

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
    <div class="card card-default">
        <div class="card-header">Data Brand
        </div>
        <div class="card-body">
            <a class="btn btn-primary text-white" id="tambah">
                <i class="icon-add"></i>
                Add New Brand
            </a>
            <hr>
            <fieldset>
                <legend>Filter</legend>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="" class="control-label">Advertiser</label>
                            <select name="advertiser" id="advertiser" class="form-control select2">
                                <option value="" disabled selected>--Pilih Advertiser--</option>
                                @foreach ($advertiser as $row)
                                    <option value="{{$row->id_adv}}">{{$row->nama_adv}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <button class="btn btn-primary" id="filter" style="margin-top:25px;">
                            <i class="fa fa-filter"></i>
                            Filter
                        </button>
                    </div>
                </div>
            </fieldset>
            <br><br>

            <div class="table-responsive">
                <table class="table table-striped datatable-colvis-basic"></table>
            </div>
        </div>
    </div>
    
    <div id="divModal"></div>
@stop

@section('js')
    <script>
        $(function(){
            var kode="";
            var sector=@json($sector);
            var category=@json($category);
            var adv=@json($advertiser);

            $('.select2').select2();

            function showData(){
                $('.datatable-colvis-basic').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: true,
                    destroy: true,
                    ajax: "{{URL::to('brand/data/brand-unit')}}",
                    columns: [
                        {data: 'DT_Row_Index', name: 'DT_Row_Index',title:'No.',width:'8%',searchable:false,'orderable':false},
                        {data: 'brand_name_alias', name: 'brand_name_alias',title:'Brand Name Alias'},
                        {data: 'advertiser.nama_adv', name: 'advertiser.nama_adv',title:'Advertiser',searchable:false,'orderable':false},
                        {data: 'action', name: 'action',title:'',width:'18%',searchable:false,'orderable':false}
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

            $(document).on("click","#filter",function(){
                var advertiser=$("#advertiser").val();
                var param={
                    advertiser:advertiser
                }

                $('.datatable-colvis-basic').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: true,
                    destroy: true,
                    ajax: {
                        url:"{{URL::to('brand/data/brand-unit')}}",
                        data:param
                    },
                    columns: [
                        {data: 'DT_Row_Index', name: 'DT_Row_Index',title:'No.',width:'8%',searchable:false,'orderable':false},
                        {data: 'brand_name_alias', name: 'brand_name_alias',title:'Brand Name Alias'},
                        {data: 'advertiser.nama_adv', name: 'advertiser.nama_adv',title:'Advertiser',searchable:false,'orderable':false},
                        {data: 'action', name: 'action',title:'',width:'18%',searchable:false,'orderable':false}
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
            })

            $(document).on("click","#tambah",function(){
                var el="";

                el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                    '<div class="modal-dialog">'+
                        '<form id="form" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header bg-primary">'+
                                    '<h5 class="modal-title" id="modal-title">Add New Brand</h5>'+
                                    '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                '</div>'+

                                '<div class="modal-body">'+
                                    '<div id="pesan"></div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Brand Alias Name</label>'+
                                        '<input class="form-control" name="name" id="name" placeholder="Brand Alias Name" required>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Advertiser</label>'+
                                        '<select name="idadvertiser" id="idadvertiser" class="form-control">'+
                                            '<option value="" disabled selected>--Pilih Advertiser--</option>'+
                                        '</select>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Brand</label>'+
                                        '<select name="idbrand" id="idbrand" class="form-control">'+
                                            '<option value="" disabled>--Pilih Brand--</option>'+
                                        '</select>'+
                                    '</div>'+
                                    '<div id="showRemoteBrand">'+
                                        '<div class="form-group">'+
                                            '<div class="label control-label">Produk</div>'+
                                            '<select name="produk[]" id="idproduk" class="select2-multiple" multiple>'+
                                                '<option value="">--Pilih Produk--</option>'+
                                            '</select>'+
                                        '</div>'+
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

                $.fn.select2.defaults.set( "theme", "bootstrap" );

                var placeholder = "Select a State";

                $( ".select2-multiple" ).select2( {
                    placeholder: placeholder,
                    width: null,
                    containerCssClass: ':all:'
                } );

                $('#idadvertiser').select2({
                    placeholder: "Search for a Advertiser",
                    minimumInputLength: 1,
                    ajax: {
                        url: "{{URL::to('brand/data/remote-data-advertiser')}}",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params, 
                                page_limit: 10,
                                produk:$("#idproduk").val(),
                                brand:$("#idbrand").val()

                            };
                        },
                        results: function (data, page){
                            return {
                                results: data.data
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data.data
                                // results: $.map(data, function (item) {
                                //     return {
                                //         text: item.tag_value,
                                //         id: item.tag_id
                                //     }
                                // })
                            };
                        },
                        cache: true
                    },
                    formatResult: function(m){
                        var markup="<option value='"+m.id+"'>"+m.text+"</option>";
                    
                        return markup;    
                    },
                    formatSelection: function(m){
                        return m.text;
                    },
                    escapeMarkup: function (m) { return m; }
                });

                $("#idbrand").select2({
                    placeholder: "Search for a Brand",
                    minimumInputLength: 1,
                    multiple:true,
                    ajax: {
                        url: "{{URL::to('brand/data/remote-data-brand')}}",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params,
                                page_limit: 10,
                                advertiser:$("#idadvertiser").val(),
                                produk:$("#idproduk").val()
                            };
                        },
                        results: function (data, page){
                            return {
                                results: data.data
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data.data
                            };
                        },
                        cache: true
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

                
                $('#idproduk').select2({
                    placeholder: "Search for a Produk",
                    minimumInputLength: 2,
                    multiple:true,
                    ajax: {
                        url: "{{URL::to('brand/data/remote-data-produk')}}",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params, // search term,
                                page_limit: 10,
                                advertiser:$("#idadvertiser").val(),
                                brand:$("#idbrand").val()
                            };
                        },
                        results: function (data, page){
                            return {
                                results: data.data
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data.data
                            };
                        },
                        cache: true
                    },
                    formatResult: function(m){
                        var markup="<option value='"+m.id+"'>"+m.text+"</option>";
                    
                        return markup;    
                    },
                    formatSelection: function(m){
                        return m.text;
                    },
                    escapeMarkup: function (m) { return m; }
                });
            });

            $(document).on("change","#sector",function(){
                changeSectorCategory();
            })

            $(document).on("change","#category",function(){
                changeSectorCategory();
            })

            $(document).on("change","#advertiser",function(){
                var adv=$("#advertiser option:selected").val();

                $.ajax({
                    url:"{{URL::to('brand/data/list-brand-by-advertiser')}}",
                    type:"GET",
                    data:"advertiser="+adv,
                    beforeSend:function(){
                        $("#showRemoteBrand").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+='<div class="form-group">'+
                                '<div class="label control-label">Brand</div>'+
                                '<select name="brand[]" id="brand" class="select2-multiple" multiple>'+
                                    '<option value="">--Pilih Brand--</option>';
                                    $.each(result.produk,function(a,b){
                                        el+="<option value='"+b.id_brand+"'>"+b.brand.nama_brand+"</option>";
                                    })
                                el+='</select>'+
                            '</div>';

                        $("#showRemoteBrand").empty().html(el);

                        $.fn.select2.defaults.set( "theme", "bootstrap" );

                        var placeholder = "Select a State";

                        $( ".select2-multiple" ).select2( {
                            placeholder: placeholder,
                            width: null,
                            containerCssClass: ':all:'
                        } );
                    },
                    errors:function(){
                        $("#showRemoteBrand").empty().html("<div class='alert alert-danger'>Failed to load data..</div>");
                    }
                })
            })

            function changeSectorCategory(){
                var sector=$("#sector option:selected").val();
                var category=$("#category option:selected").val();

                var param={
                    sector:sector,
                    category:category
                };

                $.ajax({
                    url:"{{URL::to('brand/data/list-brand')}}",
                    type:"GET",
                    data:param,
                    beforeSend:function(){
                        $("#showRemoteBrand").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+='<div class="form-group">'+
                                '<div class="label control-label">Brand</div>'+
                                '<select name="brand[]" id="brand" class="select2-multiple" multiple>'+
                                    '<option value="">--Pilih Brand--</option>';
                                    $.each(result,function(a,b){
                                        el+="<option value='"+b.id+"'>"+b.text+"</option>";
                                    })
                                el+='</select>'+
                            '</div>';

                        $("#showRemoteBrand").empty().html(el);

                        $.fn.select2.defaults.set( "theme", "bootstrap" );

                        var placeholder = "Select a State";

                        $( ".select2-multiple" ).select2( {
                            placeholder: placeholder,
                            width: null,
                            containerCssClass: ':all:'
                        } );
                    },
                    errors:function(){

                    }
                })
            }

            $(document).on("submit","#form",function(e){
                var data = new FormData(this);
                data.append("_token","{{ csrf_token() }}");
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url			: "{{URL::to('brand/data/brand-unit')}}",
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
                                $("#modal_default").modal("hide");
                                showData();
                            }else{
                                $('#pesan').empty().html("<pre>"+result.error+"</pre><br>");
                            }
                        },
                        error	:function() {  
                            $('#pesan').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            });

            $(document).on("click",".edit",function(){
                kode=$(this).attr("kode");
                var el="";

                $.ajax({
                    url:"{{URL::to('brand/data/brand-unit')}}/"+kode,
                    type:"GET",
                    beforeSend:function(){
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog">'+
                                '<form id="formUpdate" onsubmit="return false;" enctype="multipart/form-data">'+
                                    '<div class="modal-content">'+
                                        '<div class="modal-header bg-primary">'+
                                            '<h5 class="modal-title" id="modal-title">Edit Brand Unit</h5>'+
                                            '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
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
                                '<label class="control-label text-semibold">Advertiser</label>'+
                                '<select name="advertiser" id="advertiser" class="form-control">'+
                                    '<option value="">--Pilih Advertiser--</option>';
                                    $.each(result.advertiser,function(a,b){
                                        el+="<option value='"+b.id_adv+"'>"+b.nama_adv+"</option>";
                                    })
                                el+='</select>'+
                            '</div>'+

                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Brand Alias Name</label>'+
                                '<input class="form-control" name="name" value="'+result.brand.brand_name_alias+'" id="name" placeholder="Brand Alias Name" required>'+
                            '</div>';

                        $("#showForm").empty().html(el);
                        $("#advertiser").val(result.brand.advertiser_id);
                        $("#advertiser").select2();
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
                        url			: "{{URL::to('brand/data/brand-unit')}}/"+kode,
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
                                $('#pesan').html('<div class="alert alert-success">&nbsp;'+result.pesan+"</div>");
                                $("#modal_default").modal("hide");
                                showData();
                            }else{
                                $('#pesan').empty().html("<pre>"+result.error+"</pre><br>");
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
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url:"{{URL::to('brand/data/brand-unit')}}/"+kode,
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
                        swal("Your data is safe!");
                    }
                });
            });

            $(document).on("change","#sector",function(){
                var sect=$("#sector option:selected").val();

                $.ajax({
                    url:"{{URL::to('brand/data/list-brand-by-sector')}}",
                    type:"GET",
                    beforeSend:function(){

                    },
                    success:function(result){

                    },
                    errors:function(){

                    }
                })
            })

            showData();
        })
    </script>
@stop
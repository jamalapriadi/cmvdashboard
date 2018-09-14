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
        <div class="card-header">Bussiness Unit</div>
        <div class="card-body">
            @if(auth()->user()->can('Add Unit'))
            <a class="btn btn-primary text-white" id="tambah">
                <i class="icon-add"></i> &nbsp;
                Add New Business Unit
            </a>
            @endif
            <br><br>
            <fieldset style="margin-bottom:30px;">
                <legend>Filter</legend>
                
                <form id="formSearch" onsubmit="return false;">
                    <div class="row" style="padding-left:10px;">
                        <div class="col-lg-3 col-xl-3">
                            <div class="form-group">
                                <label for="" class="control-label">Group</label>
                                <select name="searchgroup" id="searchgroup" class="form-control">
                                    <option value="" selected>--Select Group--</option>
                                    @foreach($group as $row)
                                        <option value="{{$row->id}}">{{$row->group_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-xl-3">
                            <div id="divsearchunit">
                                <div class="form-group">
                                    <label for="" class="control-label">Type Unit</label>
                                    <select name="searchtype" id="searchtype" class="form-control">
                                        <option value="" disabled selected>--Select Type Unit--</option>
                                        <option value="TV">TV</option>
                                        <option value="Publisher">Publisher</option>
                                        <option value="Radio">Radio</option>
                                        <option value="KOL">KOL</option>
                                        <option value="Animation Production">Animation Production</option>
                                        <option value="Production House">Production House</option>
                                        <option value="PAYTV,IPTV,OOT">PAYTV,IPTV,OOT</option>
                                        <option value="Newspaper">Newspaper</option>
                                        <option value="Magazine">Magazine</option>
                                        <option value="SMN Channel">SMN Channel</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <button class="btn btn-primary" style="margin-top:25px">
                                <i class="icon-filter4"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </fieldset>

            <table class="table table-striped datatable-colvis-basic"></table>
        </div>
    </div>

    <div id="divModal"></div>
@stop

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

            function showData(){
                var f={
                    group:$("#searchgroup option:selected").val(),
                    type:$("#searchtype option:selected").val()
                }

                $('.datatable-colvis-basic').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: true,
                    destroy: true,
                    ajax:{
                        url:"{{URL::to('sosmed/data/business-unit')}}",
                        data:f
                    },
                    columns: [
                        {data: 'no', name: 'no',title:'No.',searchable:false,width:'5%'},
                        {data: 'groupunit.group_name', name: 'groupunit.group_name',title:'Group Name',width:'20%',defaultContent: "Data Not Found"},
                        {data: 'unit_name', name: 'unit_name',title:'Unit Name',width:'20%',searchable:true},
                        {data: 'type_unit', name: 'type_unit',title:'Type Unit'},
                        {data: 'tier', name: 'tier',title:'Tier'},
                        // {data: 'jumsosmed', name: 'jumsosmed',title:'Jumlah Sosmed',width:'20%'},
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

            $(document).on("submit","#formSearch",function(){
                showData();
            })

            $(document).on("click","#tambah",function(){
                var el="";

                $.ajax({
                    url:"{{URL::to('sosmed/data/list-group')}}",
                    type:"GET",
                    data:"group=group&sosmed=sosmed",
                    beforeSend:function(){
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog">'+
                                '<form id="form" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                                    '<div class="modal-content">'+
                                        '<div class="modal-header bg-primary">'+
                                            '<h5 class="modal-title" id="modal-title">Add New Business Unit</h5>'+
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
                        $("#showForm").empty().html(el);
                    },
                    success:function(result){
                        el+='<div id="pesan"></div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Group</label>'+
                                '<select name="group" class="form-control">'+
                                    '<option value="">--Select Group--</option>';
                                    $.each(result.group,function(a,b){
                                        el+="<option value='"+b.id+"'>"+b.group_name+"</option>";
                                    })
                                el+='</select>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Type Unit</label>'+
                                '<select name="type" id="type" class="form-control" required>'+
                                    "<option value='TV'>TV</option>"+
                                    "<option value='Publisher'>Publisher</option>"+
                                    "<option value='Radio'>Radio</option>"+
                                    "<option value=KOL'>KOL</option>"+
                                    '<option value="Animation Production">Animation Production</option>'+
                                    '<option value="Production House">Production House</option>'+
                                    '<option value="PAYTV,IPTV,OOT">PAYTV,IPTV,OOT</option>'+
                                    '<option value="Newspaper">Newspaper</option>'+
                                    '<option value="Magazine">Magazine</option>'+
                                    '<option value="SMN Channel">SMN Channel</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Business Unit Name</label>'+
                                '<input class="form-control" name="name" id="name" placeholder="Business Unit Name" required>'+
                            '</div>'+

                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Tier</label>'+
                                '<input class="form-control" name="tier" id="tier" placeholder="Tier" required>'+
                            '</div>';

                            // '<hr>'+
                            // '<fieldset>'+
                            //     '<legend>Sosial Media Official</legend>';
                            //     $.each(result.sosmed,function(a,b){
                            //         el+='<div class="form-group">'+
                            //             '<label class="control-label">'+b.sosmed_name+'</label>';
                            //             if(b.id==4){
                            //                 el+='<div class="row">'+
                            //                     '<div class="col-lg-6">'+
                            //                         '<input class="form-control" name="sosmed['+b.id+']" class="form-control" placeholder="'+b.sosmed_name+'">'+
                            //                     '</div>'+
                            //                     '<div class="col-lg-6">'+
                            //                         '<input class="form-control" name="sosmedid['+b.id+']" class="form-control" placeholder="Sosmed ID">'+
                            //                     '</div>'+
                            //                 '</div>';
                            //             }else{
                            //                 el+='<input class="form-control" name="sosmed['+b.id+']" class="form-control" placeholder="'+b.sosmed_name+'">';
                            //             }
                            //         el+='</div>';
                            //     })
                            // el+='</fieldset>';

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
                        url         : "{{URL::to('sosmed/data/business-unit')}}",
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
                    url:"{{URL::to('sosmed/data/business-unit')}}/"+kode,
                    type:"GET",
                    beforeSend:function(){
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog">'+
                                '<form id="formUpdate" onsubmit="return false;" enctype="multipart/form-data">'+
                                    '<div class="modal-content">'+
                                        '<div class="modal-header bg-primary">'+
                                            '<h5 class="modal-title" id="modal-title">Edit Sosial Media</h5>'+
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
                                '<label class="control-label text-semibold">Group</label>'+
                                '<select name="group" id="group" class="form-control">'+
                                    '<option value="">--Select Group--</option>';
                                    $.each(result.group,function(a,b){
                                        el+="<option value='"+b.id+"'>"+b.group_name+"</option>";
                                    })
                                el+='</select>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Type Unit</label>'+
                                '<select name="type" id="type" class="form-control" required>'+
                                    "<option value='TV'>TV</option>"+
                                    "<option value='Publisher'>Publisher</option>"+
                                    "<option value='Radio'>Radio</option>"+
                                    "<option value=KOL'>KOL</option>"+
                                    '<option value="Animation Production">Animation Production</option>'+
                                    '<option value="Production House">Production House</option>'+
                                    '<option value="PAYTV,IPTV,OOT">PAYTV,IPTV,OOT</option>'+
                                    '<option value="Newspaper">Newspaper</option>'+
                                    '<option value="Magazine">Magazine</option>'+
                                    '<option value="SMN Channel">SMN Channel</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Business Unit Name</label>'+
                                '<input class="form-control" name="name" value="'+result.unit.unit_name+'" id="name" placeholder="Business Unit Name" required>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Tier</label>'+
                                '<input class="form-control" name="tier" value="'+result.unit.tier+'" id="tier" placeholder="Tier">'+
                            '</div>';

                            // '<hr>'+
                            // '<fieldset>'+
                            //     '<legend>Sosial Media Official</legend>';
                            //     $.each(result.sosmed,function(c,d){
                            //         if(result.unit.sosmed.length>0){
                            //             var isi="";

                            //             for(a=0; a<result.unit.sosmed.length;a++){
                            //                 if(result.unit.sosmed[a].sosmed_id==d.id){
                            //                     isi=result.unit.sosmed[a].unit_sosmed_name;
                            //                 }
                            //             }
                                        

                            //             el+='<div class="form-group">'+
                            //                 '<label class="control-label">'+d.sosmed_name+'</label>'+
                            //                 '<input class="form-control" name="sosmed['+d.id+']" value="'+isi+'" class="form-control" placeholder="'+d.sosmed_name+'">'+
                            //             '</div>';
                            //         }else{
                            //             el+='<div class="form-group">'+
                            //                 '<label class="control-label">'+d.sosmed_name+'</label>'+
                            //                 '<input class="form-control" name="sosmed['+d.id+']" class="form-control" placeholder="'+d.sosmed_name+'">'+
                            //             '</div>';
                            //         }
                            //     })
                            // el+='</fieldset>';

                        $("#showForm").empty().html(el);

                        $("#group").val(result.unit.group_unit_id);
                        $("#type").val(result.unit.type_unit);
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
                        url			: "{{URL::to('sosmed/data/business-unit')}}/"+kode,
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
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url:"{{URL::to('sosmed/data/business-unit')}}/"+kode,
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

            $(document).on("click",".editsosmed",function(){
                kode=$(this).attr("kode");
                var el="";

                $.ajax({
                    url:"{{URL::to('sosmed/data/list-sosmed-by-program')}}/"+kode,
                    type:"GET",
                    data:"type=corporate",
                    beforeSend:function(){
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog modal-lg">'+
                                '<form id="form" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                                    '<div class="modal-content">'+
                                        '<div class="modal-header bg-primary">'+
                                            '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                            '<h5 class="modal-title" id="modal-title">Last Activity</h5>'+
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
                        el+='<fieldset>'+
                                "<form onsubmit='return false'>"+
                                    '<div class="row">'+
                                        "<div class='col-lg-3'>"+
                                            "<div class='form-group'>"+
                                                '<label class="control-label">Social Media</label>'+
                                                '<select name="sosmed" id="sosmed" class="form-control">'+
                                                    '<option value="" disabled selected>--Pilih Social Media--</option>';
                                                    $.each(result.sosmed,function(a,b){
                                                        el+="<option value='"+b.id+"'>"+b.sosmed_name+"</option>";
                                                    })
                                                el+='</select>'+
                                            "</div>"+
                                        "</div>"+
                                        "<div class='col-lg-3'>"+
                                            "<label class='control-label'>Account Name</label>"+
                                            "<input class='form-control'>"+
                                        "</div>"+
                                    '</div>'+
                                "</form>"+
                            "</fieldset>"+
                            "<table class='table table-striped'>"+
                                "<thead>"+
                                    "<tr>"+
                                        "<th rowspan='2'>Account</th>"+
                                        "<th rowspan='2'>Official Account</th>"+
                                        "<th rowspan='2'>Total Activity ( 1 Week )</th>"+
                                        "<th rowspan='2'>Action</th>"+
                                    "</tr>"+
                                "</thead>"+
                                "<tbody>";
                                    $.each(result.unit.sosmed,function(a,b){
                                        el+="<tr>"+
                                            "<td>"+b.sosmed.sosmed_name+"</td>"+
                                            "<td>"+b.unit_sosmed_name+"</td>"+
                                            "<td class='text-center'>"+b.followers.length+"</td>"+
                                            "<td><a class='btn btn-sm btn-danger hapusosmed' sosmedid='"+b.id+"'><i class='icon-trash'></i></td>"+
                                        "</tr>";
                                    })
                                el+="</tbody>"+
                            "</table>";

                        $("#showForm").empty().html(el);
                    },
                    error:function(){

                    }
                })
            })

            $(document).on("click",".hapusosmed",function(){
                var sosmedid=$(this).attr("sosmedid");
                var parentrow=$(this).closest ('tr');

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
                            url:"{{URL::to('sosmed/data/unit-sosmed')}}/"+sosmedid,
                            type:"DELETE",
                            data:"_token={{ csrf_token() }}",
                            success:function(result){
                                if(result.success=true){
                                    swal("Deleted!", result.pesan, "success");
                                    parentrow.remove ();
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
            })

            showData();
        })
    </script>
@stop
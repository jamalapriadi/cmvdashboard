@extends('layouts.coreui.main')

@section('content')
    <div class="card card-default">
        <div class="card-header">Crowdtangle</div>
        <div class="card-body">
            <a href="#" class="btn btn-primary" id="add">
                <i class="icon-add"></i> Import New 
            </a>
            <br><br>
        
            <div id="showData"></div>
        </div>
    </div>
    

    <div id="divModal"></div>
@stop

@section('js')
    <script>
        $(function(){
            var kode="";
            var alldata="";

            function showData(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/crowdtangle')}}",
                    type:"GET",
                    beforeSend:function(){
                        $("#showData").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                    },
                    success:function(result){
                        if(result.length>0){
                            var el='';
                            
                            el+='<table class="table table-striped" id="table">'+ 
                                "<thead>"+
                                    "<tr>"+
                                        "<th>No.</th>"+
                                        "<th>Page Name</th>"+
                                        "<th>User Name</th>"+
                                        "<th>Page ID</th>"+
                                        "<th>Page Likes</th>"+
                                        "<th>Post Count</th>"+
                                        "<th>Comment</th>"+
                                        "<th>Share</th>"+
                                        "<th>Likes</th>"+
                                        "<th></th>"+
                                    "</tr>"+
                                "</thead>"+
                                "<tbody>";
                                    var n=0;
                                    $.each(result,function(a,b){
                                        var url="{{URL::to('sosmed/crowdtangle')}}/"+b.id;

                                        n++;
                                        el+="<tr>"+
                                            "<td>"+n+"</td>"+
                                            "<td>"+b.page_name+"</td>"+
                                            "<td>"+b.user_name+"</td>"+
                                            "<td>"+b.page_id+"</td>"+
                                            "<td>"+b.page_likes+"</td>"+
                                            "<td>"+b.post_count+"</td>"+
                                            "<td>"+b.comments+"</td>"+
                                            "<td>"+b.shares+"</td>"+
                                            "<td>"+b.likes+"</td>"+
                                            "<td>"+
                                                "<a href='"+url+"' class='btn btn-warning text-white'>Detail</a>"+
                                            "</td>"+
                                        "</tr>";
                                    })
                                el+="</tbody>"+
                            "</table>";

                            $("#showData").empty().html(el);

                            $("#table").DataTable();
                        }else{
                            $("#showData").empty().html("<div class='alert alert-success'>Data not found</div>");
                        }
                    },
                    errors:function(){

                    }
                })
            }

            $(document).on("click","#add",function(){
                var el="";
                el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                    '<div class="modal-dialog">'+
                        '<form id="form" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header bg-primary">'+
                                    '<h5 class="modal-title" id="modal-title">Import New</h5>'+
                                    '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                '</div>'+

                                '<div class="modal-body">'+
                                    '<div id="pesan"></div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Pilih File</label>'+
                                        '<input type="file" name="file" id="file" class="form-control">'+
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
                        url			: "{{URL::to('sosmed/data/crowdtangle')}}",
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
                                $('#pesan').empty().html('<div class="alert alert-success">&nbsp;'+result.pesan+'</div>');
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
            })

            $(document).on("click",".edit",function(){
                kode=$(this).attr("kode");
                var el="";

                $.ajax({
                    url:"{{URL::to('sosmed/data/insight')}}/"+kode,
                    type:"GET",
                    beforeSend:function(){
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog">'+
                                '<form id="formUpdate" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                                    '<div class="modal-content">'+
                                        '<div class="modal-header bg-primary">'+
                                            '<h5 class="modal-title" id="modal-title">Add New Insight</h5>'+
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
                        $("#showForm").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                    },
                    success:function(result){
                        el='<div id="pesan"></div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Title</label>'+
                                '<input class="form-control" name="title" value="'+result.title+'" id="title" placeholder="Title" required>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Teaser</label>'+
                                '<textarea name="teaser" id="teaser" class="form-control">'+result.teaser+'</textarea>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Slide</label>'+
                                '<input type="file" multiple="true" name="file[]" id="file" class="form-control">'+
                            '</div>'+
                            
                            '<div id="detailInsight">'+
                                '<table class="table table-striped">'+
                                    "<thead>"+
                                        "<tr>"+
                                            "<th>No.</th>"+
                                            "<th></th>"+
                                            "<th></th>"+
                                        "</tr>"+
                                    "</thead>"+
                                    "<tbody>";
                                    var no=0;
                                    $.each(result.detail,function(a,b){
                                        no++;
                                        var url="{{asset('uploads/insight/')}}/"+b.insight_id+"/"+b.nama_file;
                                        el+="<tr>"+
                                            "<td>"+no+"</td>"+
                                            "<td>"+
                                                '<img class="d-block w-100 img-fluid" src='+url+'>'+
                                            "</td>"+
                                            "<td>"+
                                                "<a class='btn btn-danger text-white hapusdetail' kode='"+b.id+"' insight='"+b.insight_id+"'>"+
                                                    "<i class='icon-trash'></i>"+
                                                "</a>"+
                                            "</td>"+
                                        "</tr>";
                                    })
                                    el+="</tbody>"+
                                "</table>"+
                            '</div>';

                        $("#showForm").empty().html(el);
                    },
                    errors:function(){

                    }
                })
            })

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
                            url:"{{URL::to('sosmed/data/insight')}}/"+kode,
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
            })

            $(document).on("submit","#formUpdate",function(e){
                var data = new FormData(this);
                data.append("_method","PUT");
                data.append("_token","{{ csrf_token() }}");
                if($("#formUpdate")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url			: "{{URL::to('sosmed/data/insight')}}/"+kode,
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
            })

            showData();
        })
    </script>
@stop
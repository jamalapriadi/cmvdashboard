@extends('layouts.sosmed')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            List Role 
        </div>
        <div class="panel-body">
            <div class="tabbable">
                <ul class="nav nav-tabs nav-tabs-highlight">
                    <li class="active"><a href="#highlighted-tab1" data-toggle="tab">Role</a></li>
                    <li><a href="#highlighted-tab2" data-toggle="tab">Unit Handle</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="highlighted-tab1">
                        <div id="pesan"></div>
                        <div id="divRole"></div>
                    </div>

                    <div class="tab-pane" id="highlighted-tab2">
                        <div id="pesanHandleUnit"></div>
                        <div id="showUnit"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('extra-script')
    <script>
        $(function(){
            var id="{{$id}}";

            function showRole(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/list-role-with-permission')}}/"+id,
                    type:"GET",
                    beforeSend:function(){
                        $("#divRole").empty().html("<div class='alert alert-info'>Please Wait. . . </div>");
                    },
                    success:function(result){
                        var el="";
                        el+='<form id="formRoleUser" onsubmit="return false;">'+
                        '<table class="table table-striped">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th width="7%">No.</th>'+
                                    '<th>Role</th>'+
                                    '<th>Permission</th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tbody>';
                                var no=0;
                                $.each(result.role,function(a,b){
                                    no++;
                                    el+="<tr>"+
                                        "<td>"+no+"</td>"+
                                        "<td>"+b.name+"</td>"+
                                        "<td>";
                                            if(b.permissions.length>0){
                                                $.each(b.permissions,function(c,d){
                                                    var pilih="class='styled'";

                                                    for(a=0;a<result.user.permissions.length;a++){
                                                        if(result.user.permissions[a].id==d.id){
                                                            pilih="checked='checked' class='unrole' rolename='"+d.name+"'";
                                                        }

                                                    }
                                                    el+='<label class="checkbox-inline">'+
                                                        '<input type="checkbox" name="permission['+d.id+']" value="'+d.name+'" '+pilih+'>'+
                                                        d.name+
                                                    '</label>';
                                                })
                                            }else{
                                                el+="";
                                            }
                                        el+="</td>"+
                                    "</tr>";
                                })
                            el+='</tbody>'+
                        '</table>'+

                        '<div class="row well">'+
                            '<button class="btn btn-primary"> &nbsp; <i class="icon-git-compare"></i> Update Permission</button>'+
                        '</div>'+
                        '</form>';

                        $("#divRole").empty().html(el);
                    },
                    error:function(){

                    }
                })
            }

            function showUnit(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/list-user')}}/"+id+"/handle-unit",
                    type:"GET",
                    beforeSend:function(){
                        $("#showUnit").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<form id='formHandleUnit' onsubmit='return false;'>";
                        if(result.unit.length>0){
                            $.each(result.unit,function(a,b){
                                var c="";
                                for(a=0;a<result.user.unit.length;a++){
                                    if(result.user.unit[a].id==b.id){
                                        c='checked="checked"';
                                    }
                                }

                                el+="<div class='checkbox'>"+
                                    '<label>'+
                                        '<input type="checkbox" class="styled" name="unit['+b.id+']" value="'+b.id+'" '+c+'>'+
                                        b.unit_name+
                                    '</label>'+
                                '</div>';
                            })
                        }

                        el+='<div class="row well">'+
                            '<button class="btn btn-primary"> &nbsp; <i class="icon-git-compare"></i> Update Unit</button>'+
                        '</div>'+
                        '</form>';

                        $("#showUnit").empty().html(el);
                    },
                    error:function(){
                        $("#showUnit").empty().html("<div class='alert alert-danger'>Data failed to load. . .</div>");
                    }
                })
            }

            $(document).on("submit","#formRoleUser",function(e){
                var data = new FormData(this);
                data.append("user",id);
                
                if($("#formRoleUser")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('sosmed/data/save-role-user')}}",
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $('#pesan').empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {
                            if(data.success==true){
                                $("#pesan").empty().html('<div class="alert alert-success">'+data.pesan+'</div>');
                                showRole();
                            }else{
                                $("#pesan").empty().html('<div class="alert alert-danger">'+data.pesan+'</div>');
                            }
                        },
                        error   :function() {  
                            $('#pesan').empty().html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            });

            $(document).on("click",".unrole",function(){
                var rolename=$(this).attr("rolename");
                var checkbox=$(this);

                swal({
                    title: "Are you sure?",
                    text: "You will delete this role!",
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
                            url:"{{URL::to('sosmed/data/hapus-role-user')}}",
                            type:"POST",
                            data:"permission="+rolename+"&user="+id,
                            beforeSend:function(){
                                $("#pesan").empty();
                            },
                            success:function(result){
                                if(result.success==true){
                                    showRole();
                                    swal("Deleted!", result.pesan, "success");
                                }else{
                                    swal("Error!", result.pesan, "error");
                                }
                            },
                            error:function(){

                            }
                        })
                    } else {
                        checkbox.prop('checked', true); 
                        swal("Cancelled", "Your data is safe :)", "error");
                    }
                });
            })

            $(document).on("submit","#formHandleUnit",function(e){
                var data = new FormData(this);
                data.append("user",id);
                
                if($("#formHandleUnit")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('sosmed/data/save-user-handle-unit')}}",
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $('#pesanHandleUnit').empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {
                            if(data.success==true){
                                $("#pesanHandleUnit").empty().html('<div class="alert alert-success">'+data.pesan+'</div>');
                                showUnit();
                            }else{
                                $("#pesanHandleUnit").empty().html('<div class="alert alert-danger">'+data.pesan+'</div>');
                            }
                        },
                        error   :function() {  
                            $('#pesanHandleUnit').empty().html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            })

            showRole();
            showUnit();
        })
    </script>
@endpush
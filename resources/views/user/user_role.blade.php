@extends('layouts.sosmed')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            List Role 
        </div>
        <div class="panel-body">
            <div id="divRole"></div>
        </div>
    </div>
@stop

@push('extra-script')
    <script>
        $(function(){
            function showRole(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/list-role-with-permission')}}",
                    type:"GET",
                    beforeSend:function(){
                        $("#divRole").empty().html("<div class='alert alert-info'>Please Wait. . . </div>");
                    },
                    success:function(result){
                        var el="";
                        el+='<form id="formRoleUser" onsubmit="return false;">'+
                        '<div id="pesan"></div>'+
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

            $(document).on("submit","#formRoleUser",function(e){
                var data = new FormData(this);
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
                            data:"permission="+rolename,
                            beforeSend:function(){

                            },
                            success:function(result){
                                console.log(result);
                            },
                            error:function(){

                            }
                        })
                    } else {
                        swal("Cancelled", "Your data is safe :)", "error");
                    }
                });
            })

            showRole();
        })
    </script>
@endpush
@extends('layouts.mam')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Data Advertiser Type</h6>
        </div>
        <div class="panel-body">
            <table class="table table-striped datatable-colvis-basic"></table>
        </div>
    </div>
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
                $('.datatable-colvis-basic').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: true,
                    destroy: true,
                    ajax: "{{URL::to('mam/dashboard/advertiser-type')}}",
                    columns: [
                        {data: 'no', name: 'no',title:'No.',searchable:false},
                        {data: 'name_advtype', name: 'name_advtype',title:'Name'},
                        {data: 'action', name: 'action',title:'Actions',searchable:false,width:'18%'}
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

            showData();
        $(document).on("click",".edit",function(){
                kode=$(this).attr("kode");

                $.ajax({
                    url:"{{URL::to('mam/dashboard/advertiser-type')}}/"+kode,
                    type:"GET",
                    success:function(result){
                        var el="";
                        el+='<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">'+
                        '<div class="modal-dialog" role="document">'+
                        '<form class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" id="formUpdate">'+
                        '<div class="modal-content">'+
                        '<div class="modal-header bg-primary">'+
                        '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<h4 class="modal-title" id="myModalLabel">Edit Advertiser Type</h4>'+
                        '</div>'+
                        '<div class="modal-body">'+
                        '<div id="pesan"></div>'+
                        '<div class="form-group">'+
                        '<label class="col-lg-3 control-label text-semibold">Brand</label>'+
                        '<div class="col-lg-8">'+
                        '<input class="form-control" name="nama" placeholder="Advertiser Type" value="'+result.adv.name_advtype+'">'+
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
                        $("#group").val(result.adv.is_group);
                        $("#myModal").modal('show');
                    }
                })
            })
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
                            url:"{{URL::to('mam/dashboard/advertiser-type')}}/"+kode,
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
    });
    </script>
@stop
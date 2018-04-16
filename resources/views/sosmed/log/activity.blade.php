@extends('layouts.sosmed')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Recent Activity User
        </div>
        <div class="panel-body">
            <div id="showActivitys"></div>
        </div>
    </div>
@stop

@push('extra-script')
    <script>
        $(function(){
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

            /* activity login */
            function showActivity(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/list-activity-user')}}",
                    type:"GET",
                    beforeSend:function(){
                        $("#showActivitys").empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                    },
                    success:function(result){
                        var el="";
                        el+="<table class='table table-striped' id='activityData'>"+
                            '<thead>'+
                                '<tr>'+
                                    '<th width="5%">No.</th>'+
                                    '<th width="10%"></th>'+
                                    '<th>Description</th>'+
                                    '<th width="20%">Created At</th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tbody>';
                            var n=0;
                            $.each(result,function(a,b){
                                n++;
                                el+='<tr>'+
                                    '<td>'+n+'</td>';
                                    if(b.user!=null){
                                        var path="https://www.baxter.com/assets/images/products/Renal/thumb_image_not_available.png";
                                        el+='<td><img src="'+b.images+'" onerror=this.src="'+path+'"; alt="'+b.user.name+'" class="img-circle pull-left avatar" style="width:80px;height:80px"></td>';        
                                    }else{
                                        el+='<td><img src="https://cdn.iconscout.com/public/images/icon/free/png-512/avatar-user-coder-3579ca3abc3fd60f-512x512.png" alt="Avatar" class="img-circle pull-left avatar" style="width:80px;height:80px"></td>';        
                                    }
                                    el+='<td>'+b.description+'</td>'+
                                    '<td>'+b.created_at+'</td>'+
                                '</tr>';
                            })
                            el+='</tbody>'+
                        '</table>';

                        $("#showActivitys").empty().html(el);
                        $("#activityData").DataTable({
                            colVis: {
                                buttonText: "<i class='icon-three-bars'></i> <span class='caret'></span>",
                                align: "right",
                                overlayFade: 200,
                                showAll: "Show all",
                                showNone: "Hide all"
                            }
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
                    },
                    error:function(){
                        
                    }
                })
            }

            showActivity();
        })
    </script>
@endpush
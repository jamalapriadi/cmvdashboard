@extends('layouts.sosmed')

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

            function lastLogin(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/recent-access-log')}}",
                    type:"GET",
                    beforeSend:function(){
                        $("#loginActivity").empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                    },
                    success:function(result){
                        var el="";
                        el+='<table class="table table-striped" id="loginData">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th width="5%">No.</th>'+
                                    '<th width="20%">Name</th>'+
                                    '<th width="20%">Path</th>'+
                                    '<th width="15%">IP Address</th>'+
                                    '<th width="20%">Date</th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tbody>';
                            var no=0;
                            $.each(result,function(a,b){
                                no++;
                                el+="<tr>"+
                                    "<td>"+no+"</td>"+
                                    "<td>"+b.name+"</td>"+
                                    "<td>"+b.path+"</td>"+
                                    "<td>"+b.ip_address+"</td>"+    
                                    "<td>"+b.created_at+"</td>"+
                                "</tr>";
                            })
                            el+="</tbody>"+ 
                        '</table>';

                        $("#loginActivity").empty().html(el);
                        $("#loginData").DataTable({
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

            lastLogin();
        })
    </script>
@endpush

@section('content')
    @if(auth()->user()->can('Access Log'))
    <!-- END OVERVIEW -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-defult">
                <div class="panel-heading">
                    Recent Login User
                </div>
                <div class="panel-body">
                    <div id="loginActivity"></div>
                </div>
                <!-- <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-right"><a href="#" class="btn btn-primary">View All Activity</a></div>
                    </div>
                </div> -->
            </div>
        </div>

    </div>
    @endif
@stop
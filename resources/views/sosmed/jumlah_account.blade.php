@extends('layouts.coreui.main')

@section('content')
    <div class="card card-default">
        <div class="card-header">Jumlah Account</div>
        <div class="card-body">
            <a href="{{URL::to('sosmed/data/report/jumlah-account?export=excel')}}" class="btn btn-success">
                <i class="icon-file-text2"></i>
                Export Excel
            </a>
            <hr>
            <div class="table-responsive">
                <div id="showData"></div>
            </div>
        </div>
    </div>
@stop

@section('js')
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

            function showData(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/jumlah-account')}}",
                    type:"GET",
                    beforeSend:function(){
                        $("#showData").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<table class='table table-striped' id='tabeldata'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th>No.</th>"+
                                    "<th>TYPE</th>"+
                                    "<th>NAME</th>"+
                                    "<th>UNIT NAME</th>"+
                                    "<th>TWITTER</th>"+
                                    "<th>FACEBOOK</th>"+
                                    "<th>INSTAGRAM</th>"+
                                    "<th>YOUTUBE</th>"+
                                    "<th>WEBSITE</th>"+
                                    "<th>JUMLAH ACCOUNT</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody>";
                            var no=0;
                            $.each(result,function(a,b){
                                no++;
                                el+="<tr>"+
                                    "<td>"+no+"</td>"+
                                    "<td>"+b.TYPE+"</td>"+
                                    "<td>"+b.NAME+"</td>"+
                                    "<td>"+b.group_name+"</td>"+
                                    "<td>"+b.twitter+"</td>"+
                                    "<td>"+b.facebook+"</td>"+
                                    "<td>"+b.instagram+"</td>"+
                                    "<td>"+b.youtube+"</td>"+
                                    "<td>"+b.website+"</td>"+
                                    "<td>"+b.total+"</td>"+
                                "</tr>";
                            })
                            el+="</tbody>"+
                        "</table>";
                        $("#showData").empty().html(el);

                        $("#tabeldata").DataTable();
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
                    errors:function(){

                    }
                })
            } 

            showData();
        })
    </script>
@stop
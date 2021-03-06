@extends('layouts.coreui.main')

@section('content')
<div class="card card-default">
    <div class="card-header">Data Agency Pintu
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable-colvis-basic"></table>
        </div>
    </div>
</div>

<div id="tampilmodal"></div>
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
                    ajax: "{{URL::to('brand/data/agency-pintu')}}",
                    columns: [
                        {data: 'DT_Row_Index', name: 'DT_Row_Index',title:'No.',width:'5%',searchable:false,'orderable':false},
                        {data: 'id_agcyptu', name: 'id_agcyptu',title:'ID Agency Pintu', width:'14%',searchable:false,'orderable':false},
                        {data: 'nama_agencypintu', name: 'nama_agencypintu',title:'Agency Pintu', width:'25%', searchable:true},
                        // {data: 'agen', name: 'agen',title:'Agency', width:'25%',searchable:false,'orderable':false},
                        {data: 'cluster', name: 'cluster',title:'Cluster', width:'5%',searchable:false,'orderable':false},
                        {data: 'action', name: 'action',title:'', width:'5%'}
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
        })
    </script>
    @stop
@extends('layouts.coreui.main')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            Data Unit Sosmed
        </div>
        <div class="card-body">
            <table class="table table-striped datatable-colvis-basic"></table>
        </div>
    </div>
    
    <div id="tampilmodal"></div>
@stop

@section('js')
    <script>
        $(function(){
            var kode="";
            function showData(){
                $('.datatable-colvis-basic').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: true,
                    destroy: true,
                    ajax: "{{URL::to('brand/data/brand-sosmed')}}",
                    columns: [
                        {data: 'DT_Row_Index', name: 'DT_Row_Index',title:'No.',width:'5%',searchable:false,'orderable':false},
                        {data: 'type_sosmed', name: 'type_sosmed',title:'Type Sosmed',width:'15%'},
                        {data: 'brand_name_alias', name: 'brand_name_alias',title:'Brand Alias'},
                        {data: 'unit_sosmed_name', name: 'unit_sosmed_name',title:'Unit Sosmed Name'},
                        {data: 'brand', name: 'brand',title:'Brand',searchable:false,'orderable':false},
                        {data: 'action', name: 'action',title:'',searchable:false,'orderable':false}
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
@extends('layouts.dashboard')

@section('js')
    <script>
        $(function(){
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


            $(document).on("change","#sector",function(){
                var sector=$("#sector option:selected").val();

                $.ajax({
                    url:"{{URL::to('cmv/data/list-category')}}",
                    type:"GET",
                    data:"sector="+sector,
                    beforeSend:function(){
                        $("#category").empty().html("");
                        $("#brand").empty().html("");
                    },
                    success:function(result){
                        $("#category").append($("<option></option>")
                                    .attr("value","")
                                    .text("--Choose Category--")); 

                        $.each(result,function(a,b){
                            $('#category')
                                .append($("<option></option>")
                                            .attr("value",b.category_id)
                                            .text(b.text)); 
                        })
                    },
                    error:function(){

                    }
                })
            })

            $(document).on("change","#category",function(){
                var category=$("#category option:selected").val();

                $.ajax({
                    url:"{{URL::to('cmv/data/list-brand')}}",
                    type:"GET",
                    data:"category="+category,
                    beforeSend:function(){
                        $("#brand").empty().html("");
                    },
                    success:function(result){
                        $("#brand").append($("<option></option>")
                                    .attr("value","")
                                    .text("--Choose Brand--")); 

                        $.each(result,function(a,b){
                            $('#brand')
                                .append($("<option></option>")
                                            .attr("value",b.brand_id)
                                            .text(b.text)); 
                        })
                    },
                    error:function(){

                    }
                })
            })

            $(document).on("submit","#formSearch",function(e){
                var data = new FormData(this);
                data.append("_method","GET");
                if($("#formSearch")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('cmv/data/search')}}",
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $('#pesan').html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (result) {
                            console.log(result.data);
                            var el="";
                            if(result.success==true){
                                el+="<div class='panel panel-flat'>"+
                                    "<div class='panel-body'>"+
                                    "<table class='table text-nowrap tablesector'>"+
                                        "<thead>"+
                                            "<tr>"+
                                                "<th>SUBDEMOGRAPHY</th>"+
                                                "<th>TOTALS THOUSAND</th>"+
                                                "<th>TOTALS VERTICAL</th>"+
                                                "<th>TOTAL PERSEN</th>"+
                                            "</tr>"+
                                        "</thead>"+
                                        "<tbody>";
                                            $.each(result.data,function(a,b){
                                                el+="<tr class='active border-double' style='background:lightgray'>"+
                                                    "<th>"+b.demo+"</th>"+
                                                    "<th></th>"+
                                                    "<th></th>"+
                                                    "<th></th>"+
                                                "</tr>";
                                                $.each(b.subdemo,function(c,d){
                                                    el+="<tr>"+
                                                        "<td>"+d.subdemo+"</td>"+
                                                        "<td>"+d.total_thousand+"</td>"+
                                                        "<td>"+d.total_vertical+"</td>"+
                                                        "<td>"+d.total_persen+" %</td>"+
                                                    "</tr>";
                                                })
                                            
                                            })
                                        el+="</tbody>"+
                                    "</table>"+
                                "</div></div>";

                                $("#tampil").empty().html(el);

                                $(".tablesector").DataTable({
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

                            }else{
                                
                            }
                        },
                        error   :function() {  
                            $('#pesan').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            });
        })
    </script>
@stop

@section('content')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form id="formSearch" onsubmit="return false" name="formSearch">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">Sector</label>
                            <select name="sector" id="sector" class="form-control">
                                <option value="" disabled selected>--Select Sector--</option>
                                @foreach($sector as $row)
                                    <option value="{{$row->sector_id}}">{{$row->sector_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">Category</label>
                            <select name="category" id="category" class="form-control">
                                <option value="">--Select Category--</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">Brand</label>
                            <select name="brand" id="brand" class="form-control">
                                <option value="">--Select Brand--</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <button class="btn btn-primary" style="margin-top:25px;">
                                <i class="icon-filter4"></i>
                                Filter 
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="tampil"></div>
@stop

@section('tes')
<div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th rowspan="3">No.</th>
                    <th rowspan="3">Category</th>
                    <th rowspan="3">Brand</th>
                    @foreach($demo as $d)
                        <th colspan="{{count($d->subdemo)*2}}" class="text-center">{{$d->demo_name}}</th>
                    @endforeach
                </tr>
                <tr>
                    @foreach($demo as $r)
                        @foreach($r->subdemo as $sb)
                            <th colspan="2" class="text-center">{{$sb->subdemo_name}}</th>
                        @endforeach
                    @endforeach
                </tr>
                <tr>
                    @foreach($demo as $r)
                        @foreach($r->subdemo as $sb)
                            <th class="text-center">Totals (000)s</th>
                            <th class="text-center">Totals Ver</th>
                        @endforeach
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <?php $no=0;?>
                @foreach($brand as $row)
                    <?php $no++;?>
                    <tr>
                        <td>{{$no}}</td>
                        <td>{{$row->category->category_name}}</td>
                        <td>{{$row->brand_name}}</td>
                        @foreach($row->variabel as $k)
                            <td>{{$k->pivot->totals_thousand}}</td>
                            <td>{{$k->pivot->totals_ver}}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tr>
        </table>
    </div>

    <hr>
    {{$brand->links()}}
@stop
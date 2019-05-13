@extends('layouts.coreui.main')

@section('extra-style')
<style>
    .daterangepicker{z-index:1151 !important;}
    #ui-datepicker-div{z-index:1151 !important;}
</style>
@stop

@section('content')
    <div class="card card-default">
        <div class="card-header">Jumlah Account</div>
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">Jumlah Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-controls="profile">Compare Youtube TV & Program</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#messages" role="tab" aria-controls="messages">Nama Akun Official dan Program</a>
                </li>
            </ul>
            
            <div class="tab-content">
                <div class="tab-pane active" id="home" role="tabpanel">
                    <a href="{{URL::to('sosmed/data/report/jumlah-account?export=excel')}}" class="btn btn-success">
                        <i class="icon-file-text2"></i>
                        Export Excel
                    </a>
                    <hr>

                    <div class="table-responsive">
                        <div id="showData"></div>
                    </div>
                </div>
                <div class="tab-pane" id="profile" role="tabpanel">
                    <form class="form-horizontal" target="new target" id="form" onsubmit="return false;">
                        <div class="form-group row">
                            <label class="col-lg-2">Compare Date</label>
                            <div class="col-lg-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                                    </div>
                                    <input class="form-control daterange-single-sekarang" data-value="{{date('Y/m/d')}}" name="kemarin" id="kemarin">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2">Compare With Date</label>
                            <div class="col-lg-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                                    </div>
                                    <input class="form-control daterange-single-sekarang" data-value="{{date('Y/m/d')}}" name="sekarang" id="sekarang">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-lg-2"></label>
                            <div class="col-lg-4">
                                <button class="btn btn-primary" style="margin-top:25px" id="cari">
                                    <i class="icon-filter4"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <div id="showYoutube"></div>
                    </div>
                </div>
                <div class="tab-pane" id="messages" role="tabpanel">
                    <a href="{{URL::to('sosmed/data/report/nama-akun-official-dan-program?export=excel')}}" class="btn btn-success">
                        <i class="icon-file-excel"></i> Export Excel
                    </a>
                    <hr>
                    <div id="tampilNama"></div>
                </div>
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

            $('.daterange-single-sekarang').pickadate({ 
                format: 'yyyy/mm/dd',
                formatSubmit: 'yyyy/mm/dd',
                max:true,
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
                                    "<th>GROUP NAME</th>"+
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
                                    "<td>"+b.unit_name+"</td>"+
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

            $(document).on("click","#cari",function(){
                var kemarin=$("#kemarin").val();
                var sekarang=$("#sekarang").val();


                $.ajax({
                    url:"{{URL::to('sosmed/data/report/youtube-tv-and-program')}}",
                    type:"GET",
                    data:"kemarin="+kemarin+"&sekarang="+sekarang,
                    beforeSend:function(){
                        $("#showYoutube").empty().html("<div class='alert alert-info'>Please wait...</div>");
                    },
                    success:function(result){
                        var url="{{URL::to('sosmed/data/report/youtube-tv-and-program')}}?kemarin="+kemarin+"&sekarang="+sekarang+"&export=excel";

                        var el="";
                        el+="<a class='btn btn-success' href='"+url+"'>Export Excel</a><hr>";

                        el+="<table classs='table table-striped' id='tabelyoutube'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th>No.</th>"+
                                    "<th>Type Socmed</th>"+
                                    "<th>Name</th>"+
                                    "<th>Group Name</th>"+
                                    "<th>Unit Name</th>"+
                                    "<th>Unit / Program</th>"+
                                    "<th>Socmed Name</th>"+
                                    "<th>Unit Socmed Name</th>"+
                                    "<th>Follower "+kemarin+"</th>"+
                                    "<th>View Count "+kemarin+"</th>"+
                                    "<th>Video Count "+kemarin+"</th>"+
                                    "<th>Follower "+sekarang+"</th>"+
                                    "<th>View Count "+sekarang+"</th>"+
                                    "<th>Video Count "+sekarang+"</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody>";
                                var no=0;
                                $.each(result,function(a,b){
                                    no++;
                                    el+="<tr>"+
                                        "<td>"+no+"</td>"+
                                        "<td>"+b.type_sosmed+"</td>"+
                                        "<td>"+b.name+"</td>"+
                                        "<td>"+b.group_name+"</td>"+
                                        "<td>"+b.unit_name+"</td>"+
                                        "<td>"+b.unit_or_program+"</td>"+
                                        "<td>"+b.sosmed_name+"</td>"+
                                        "<td>"+b.unit_sosmed_name+"</td>"+
                                        "<td>"+b.follower_kemarin+"</td>"+
                                        "<td>"+b.view_count_kemarin+"</td>"+
                                        "<td>"+b.video_count_kemarin+"</td>"+
                                        "<td>"+b.follower_sekarang+"</td>"+
                                        "<td>"+b.view_count_sekarang+"</td>"+
                                        "<td>"+b.video_count_sekarang+"</td>"+
                                    "</tr>";
                                })
                            el+="</tbody>"+
                        "</table>";
                        $("#showYoutube").empty().html(el);

                        $("#tabelyoutube").DataTable();
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
            })

            function showNamaAkun(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/nama-akun-official-dan-program')}}",
                    type:"GET",
                    beforeSend:function(){
                        $("#tampilNama").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<table class='table table-striped' id='tampilnama'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th>No.</th>"+
                                    "<th>Group Name</th>"+
                                    "<th>Unit Name</th>"+
                                    "<th>Type Unit</th>"+
                                    "<th>Type Akun</th>"+
                                    "<th>Twitter</th>"+
                                    "<th>Facebook</th>"+
                                    "<th>Instagram</th>"+
                                    "<th>Youtube</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody>";
                                var no=0;
                                $.each(result,function(a,b){
                                    no++;
                                    el+="<tr>"+
                                        "<td>"+no+"</td>"+
                                        "<td>"+b.group_name+"</td>"+
                                        "<td>"+b.unit_name+"</td>"+
                                        "<td>"+b.name+"</td>"+
                                        "<td>"+b.typenya+"</td>"+
                                        "<td>"+b.twitter+"</td>"+
                                        "<td>"+b.facebook+"</td>"+
                                        "<td>"+b.instagram+"</td>"+
                                        "<td>"+b.youtube+"</td>"+
                                    "</tr>";
                                })
                            el+="</tbody>"+
                        "</table>";
                        $("#tampilNama").empty().html(el);

                        $("#tampilnama").DataTable();
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
            showNamaAkun();
        })
    </script>
@stop
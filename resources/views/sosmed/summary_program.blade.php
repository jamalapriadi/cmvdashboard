@extends('layouts.coreui.main')

@section('extra-style')
    <style>
        #zingchart-1 {
            height: 400px;
            width: 960px;
        }

        #zingchart-2 {
            height: 200px;
            width: 480px;
        }

        #zingchart-3 {
            height: 200px;
            width: 480px;
        }

        #zingchart-4 {
            height: 200px;
            width: 480px;
        }

        #chartOfficial{
            height: 400px;
            width: 960px;
        }

        #growthProgram{
            height: 400px;
            width: 960px;
        }

        #officialTwitter{
            height: 400px;
            width: 480px;
        }

        #top10TwitterProgram{
            height: 400px;
            width: 480px;
        }

        #top10TwitterOfficial{
            height: 400px;
            width: 480px;
        }

        #top10{
            height: 400px;
            width: 480px;
        }

        .zingchart-tooltip {
                padding: 7px 5px;
            border-radius: 1px;
            line-height: 20px;
            background-color: #fff;
            border: 1px solid #dcdcdc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            -webkit-font-smoothing: antialiased;
        }
        .zingchart-tooltip .scalex-value {
            font-size: 14px !important;
            font-weight: normal !important;
            line-height: 24px;
            color: #838383;
        }
        .zingchart-tooltip .scaley-value {
            color: #4184f3;
            font-size: 24px !important;
            font-weight: normal !important;
        }

        .zc-ref {
            display: none;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-header">Program #{{$bu->program_name}}</div>
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#highlight-tab1" role="tab" aria-controls="nav-home" aria-selected="true">SUMMARY</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#highlight-tab2" role="tab" aria-controls="nav-profile" aria-selected="false">SOCIAL MEDIA</a>
                            {{-- <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#highlight-tab3" role="tab" aria-controls="nav-contact" aria-selected="false">TARGET</a> --}}
                        </div>
                    </nav>
                    <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="highlight-tab1" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="" class="control-label">Periode</label>
                                        <div id="divPeriode"></div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="" class="control-label"></label>
                                        <button class="btn btn-primary" id="filterOfficial" style="margin-top:25px;"><i class="icon-filter3"></i> Filter</button>
                                    </div>
                                </div>

                            </div>
                            <div id="chartOfficial"></div>
                        </div>

                        <div class="tab-pane fade" id="highlight-tab2" role="tabpanel" aria-labelledby="nav-home-tab">
                            <a href="#" class="btn btn-primary" id="tambahsosmed">
                                <i class="icon-add"></i> Add New Account
                            </a>
                            <hr>

                            <div id="divSosmed"></div>
                        </div>

                        {{-- <div class="tab-pane fade" id="highlight-tab3" role="tabpanel" aria-labelledby="nav-home-tab">
                            <a class="btn btn-primary" id="tambahtarget">
                                <i class="icon-add"></i> &nbsp; Add New Target 
                            </a>
                            <hr>
                            <div id="divTarget"></div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">SOCMED LIVE</div>
        <div class="card-body">
            <div class="row">
                @foreach($bu->sosmed as $row)
                    @if($row->sosmed_id==1)
                        <div class="col-lg-6">
                            <div class="card card-accent-success">
                                <div class="card-header" bg-info>Twitter</div>
                                <div class="card-body">
                                    <a class="twitter-timeline" data-height="600" data-theme="light" data-link-color="#E81C4F" href="https://twitter.com/{{$row->unit_sosmed_name}}?ref_src=twsrc%5Etfw">Tweets by {{$row->unit_sosmed_name}}</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                </div>
                            </div>
                        </div>
                    @endif
            
                    @if($row->sosmed_id==2)
                        <div class="col-lg-6">
                            <div class="card card-accent-primary">
                                <div class="card-header">Facebook</div>
                                <div class="card-body">
                                    <div id="fb-root"></div>
                
                                    {!! facebookFrame($row->unit_sosmed_account_id) !!}
                                </div>
                            </div>
                        </div>
                    @endif
            
                    @if($row->sosmed_id==3)
                        <div class="col-lg-6">
                            <div class="card card-accent-warning">
                                <div class="card-header">Instagram</div>
                                <div class="card-body">
                                    {!! $row->unit_sosmed_account_id !!}
                                </div>
                            </div>
                        </div>
                    @endif
            
                    @if($row->sosmed_id==4)
                        <div class="col-lg-6">
                            <div class="card card-accent-danger">
                                <div class="card-header">Youtube</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            @if(isset($youtube->snippet))
                                                <img src="{{$youtube->snippet->thumbnails->default->url}}" alt="" class="img-fluid">
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            @if(isset($youtube->snippet->customUrl))
                                                @php 
                                                    $url=$youtube->snippet->customUrl;
                                                @endphp 
                                            @else 
                                                @php 
                                                    $url="";
                                                @endphp
                                            @endif
                                            <a href="https://youtube.com/{{$url}}" target="new target">
                                                @if(isset($youtube->snippet))
                                                    <h3>{{$youtube->snippet->title}}</h3>
                                                @endif
                                            </a>
                                            @if(isset($youtube->statistics))
                                                <p class="text-muted">{{number_format($youtube->statistics->subscriberCount)}} subscriber</p>
                                            @endif
                                        </div>
                                        <div class="col-lg-3">
                                            @if(isset($youtube->statistics))
                                                <a href="#" class="btn btn-youtube">SUBSCRIBE {{number_format($youtube->statistics->subscriberCount)}}</a></a>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5>Statistik</h5>
                                            @if(isset($youtube->snippet))
                                                <p class="small">Bergabung pada : {{date('d F Y',strtotime($youtube->snippet->publishedAt))}}</p>
                                            @endif 
                                            
                                            @if(isset($youtube->statistics))
                                                <p>{{number_format($youtube->statistics->viewCount)}} x penayangan</p>
                                            @endif
                                        </div>
                                        
                                        @if(isset($youtube->snippet->country))
                                            <div class="col-lg-6">
                                                <h5>Detail</h5>
                                                <p class="text-muted">Lokasi : {{$youtube->snippet->country}}</p>
                                            </div>
                                        @endif
                                    </div>
                
                                    <hr>
                                    <div id="showYoutube">
                                        <div class="row">
                                            @if(isset($activity))
                                                @foreach($activity as $key=>$row)
                                                    @if($key<4)
                                                        <div class="col-lg-6" style="margin-bottom:10px;">
                                                            @if(isset($row->contentDetails->upload))
                                                                {{youtubeUrl($row->contentDetails->upload->videoId)}}
                                                            @endif
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="row">
        
    </div>

    <div id="divModal"></div>
     
@stop

@section('js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.js"></script>
    <script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
    <script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9","ee6b7db5b51705a13dc2339db3edaf6d"];</script>

    <script>
        $(function(){
            var id="{{$id}}";
            var kode="";
            var idunitsosmed="";
            var unitsosmedtarget="";
            var sos=@json($bu);
            var bulan="{{date('Y-m')}}";

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

            function showSosmed(){
                var el="";
                el+="<table class='table table-striped'>"+
                    "<thead>"+
                        "<tr>"+
                            "<th>No.</th>"+
                            "<th>Sosmed Name</th>"+
                            "<th>Account Name</th>"+
                            "<th></th>"+
                        "</tr>"+
                    "</thead>"+
                    "<tbody>";
                    var no=0;
                    $.each(sos.sosmed,function(a,b){
                        no++;
                        el+="<tr>"+
                            "<td>"+no+"</td>"+
                            "<td>"+b.sosmed.sosmed_name+"</td>"+
                            "<td>"+b.unit_sosmed_name+"</td>"+
                            "<td><a class='btn btn-danger btn-sm' kode='"+b.id+"'><i class='icon-trash'></i></a></td>"+
                        "</tr>";
                    })
                    el+="</tbody>"+
                "</table>";

                $("#showSosmed").empty().html(el);
            }

            function sosmed(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/target-sosmed-program')}}/"+id,
                    data:"type=program",
                    beforeSend:function(){

                    },
                    success:function(result){
                        var el=""
                        el+='<table class="table table-striped" id="tabelsosmed">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th width="5%">No.</th>'+
                                    '<th width="15%">Sosial Media</th>'+
                                    '<th width="20%">Official Account</th>'+
                                    '<th width="10%">Active</th>'+
                                    // '<th width="15%">Target</th>'+
                                    '<th width="15%"></th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tbody>';
                                var no=0;
                                $.each(result.sosmed,function(a,b){
                                    no++;
                                    el+="<tr>"+
                                        "<td>"+no+"</td>"+
                                        "<td>"+b.sosmed.sosmed_name+"</td>"+
                                        "<td>"+b.unit_sosmed_name+"</td>"+
                                        // "<td>"+b.status_active+"</td>";
                                        "<td>";
                                            if(b.status_active=="Y"){
                                                el+='<input type="checkbox" name="my-checkbox" class="checkboxnya" status="pilih" kode="'+b.id+'" checked>';
                                            }else{
                                                el+='<input type="checkbox" name="my-checkbox" class="checkboxnya" status="tidakpilih" kode="'+b.id+'">';
                                            }
                                            
                                        el+="</td>";
                                        // if(b.target!=null){
                                        //     el+="<td><a class='setupdatetarget' kode='"+b.id+"' utarget='"+b.target.id+"'><label class='label label-info'>"+b.target.target+"</label></a></td>";
                                        // }else{
                                        //     el+="<td><a class='settarget' kode='"+b.id+"'><label class='label label-warning'><i class='fa fa-spinner icon-gear'></i> Please Set Target</label></a></td>";
                                        // }
                                        el+="<td>"+
                                            "<div class='btn-group'>"+
                                                "<a class='btn btn-warning editsosmed' kode='"+b.id+"'><i class='icon-pencil4'></i></a>"+
                                                "<a class='btn btn-danger hapusosmed' kode='"+b.id+"'><i class='icon-trash'></i></a>"+
                                            "</div>"+
                                        "</td>"+
                                    "</tr>";
                                })
                            el+='</tbody>'+
                        '</table>';

                        $("#divSosmed").empty().html(el);
                        $(".checkboxnya").bootstrapSwitch();

                        $("#tabelsosmed").DataTable({
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
                    },
                    error:function(){

                    }
                })
            }

            $(document).on("click","#tambahtarget",function(){
                var el="";

                $.ajax({
                    url:"{{URL::to('sosmed/data/target-sosmed-program')}}/"+id,
                    type:"GET",
                    data:"type=program",
                    beforeSend:function(){
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog">'+
                                '<form id="formTarget" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                                    '<div class="modal-content">'+
                                        '<div class="modal-header bg-primary">'+
                                            '<h5 class="modal-title" id="modal-title">Add New Target</h5>'+
                                            '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                        '</div>'+

                                        '<div class="modal-body">'+
                                            '<div id="showForm"></div>'+
                                        '</div>'+

                                        '<div class="modal-footer">'+
                                            '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                            '<button type="submit" class="btn btn-primary btn-ladda btn-ladda-spinner"id="simpan"> <span class="ladda-label">Save</span> </button>'+
                                        '</div>'+
                                    '</div>'+
                                '</form>'+
                            '</div>'+
                        '</div>';

                        $("#divModal").empty().html(el);
                        $("#modal_default").modal("show");
                        $("#showForm").empty().html(el);
                    },
                    success:function(result){
                        el+='<div id="pesan"></div>'+
                            '<div class="form-group">'+
                                "<label class='control-label'>Tahun</label>"+
                                "<select name='tahun' id='tahun' class='form-control'>"+
                                    "<option value='2019'>2019</option>"+
                                    "<option value='2018' selected>2018</option>"+
                                    "<option value='2017'>2017</option>"+
                                    "<option value='2016'>2016</option>"+
                                "</select>"+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Sosial Media</label>'+
                                '<select name="sosmed" class="form-control">'+
                                    '<option value="" disabled selected>--Select Sosial Media--</option>';
                                    $.each(result.sosmed,function(a,b){
                                        el+="<option value='"+b.id+"'>"+b.sosmed.sosmed_name+"</option>";
                                    })
                                el+='</select>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label text-semibold">Target</label>'+
                                '<input class="form-control" name="target" id="target" placeholder="Target" required>'+
                            '</div>';

                        $("#showForm").empty().html(el);
                    },
                    error:function(){

                    }
                })
            })

            $(document).on("submit","#formTarget",function(e){
                var data = new FormData(this);
                data.append("_token","{{ csrf_token() }}");
                if($("#formTarget")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('sosmed/data/save-target-program')}}",
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $('#pesan').html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {
                            $('#pesan').html('&nbsp;'+data.pesan);

                            if(data.success==true){
                                target();
                                $("#modal_default").modal("hide");
                            }else{
                                $("#pesan").empty().html("<pre>"+data.error+"</pre>");
                            }
                        },
                        error   :function() {  
                            $('#pesan').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            });

            $(document).on("click",".settarget",function(){
                idunitsosmed=$(this).attr("kode");
                var el="";

                $.ajax({
                    url:"{{URL::to('sosmed/data/list-target-by-unit-sosmed')}}/"+idunitsosmed,
                    beforeSend:function(){
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog">'+
                                '<form id="formSetTarget" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                                    '<div class="modal-content">'+
                                        '<div class="modal-header bg-primary">'+
                                            '<h5 class="modal-title" id="modal-title">Set Target</h5>'+
                                            '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                        '</div>'+

                                        '<div class="modal-body">'+
                                            '<div id="showForm"></div>'+
                                        '</div>'+

                                        '<div class="modal-footer">'+
                                            '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                            '<button type="submit" class="btn btn-primary btn-ladda btn-ladda-spinner"id="simpan"> <span class="ladda-label">Save</span> </button>'+
                                        '</div>'+
                                    '</div>'+
                                '</form>'+
                            '</div>'+
                        '</div>';

                        $("#divModal").empty().html(el);
                        $("#modal_default").modal("show");
                        $("#showForm").empty().html(el);
                    },
                    success:function(result){
                        el+='<table class="table table-striped table-bordered" id="tabeltarget">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th width="5%" rowspan="2"></th>'+
                                    '<th>Tahun</th>'+
                                    '<th>Target</th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tbody>';
                                var no=0;
                                $.each(result,function(c,d){
                                    no++;
                                    el+="<tr>"+
                                        "<td><input type='radio' name='set' value='"+d.id+"'></td>"+
                                        "<td>"+d.tahun+"</td>"+
                                        "<td>"+d.target+"</td>"+
                                    "</tr>";
                                })
                            el+='</tbody>'+
                        '</table>';

                        $("#showForm").empty().html(el);
                    },
                    error:function(){

                    }
                })
            })

            $(document).on("submit","#formSetTarget",function(e){
                var data = new FormData(this);
                data.append("_token","{{ csrf_token() }}");
                data.append("_method","put");
                if($("#formSetTarget")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('sosmed/data/use-target-program')}}/"+idunitsosmed,
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $('#pesan').html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {
                            $('#pesan').html('&nbsp;'+data.pesan);

                            if(data.success==true){
                                sosmed();
                                $("#modal_default").modal("hide");
                            }else{
                                $("#pesan").empty().html("<pre>"+data.error+"</pre>");
                            }
                        },
                        error   :function() {  
                            $('#pesan').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            });

            $(document).on("click",".setupdatetarget",function(){
                idunitsosmed=$(this).attr("kode");
                unitsosmedtarget=$(this).attr("utarget");
                var el="";

                $.ajax({
                    url:"{{URL::to('sosmed/data/list-target-by-unit-sosmed')}}/"+idunitsosmed,
                    beforeSend:function(){
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog">'+
                                '<form id="formSetTarget" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                                    '<div class="modal-content">'+
                                        '<div class="modal-header bg-primary">'+
                                            '<h5 class="modal-title" id="modal-title">Set Target</h5>'+
                                            '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                        '</div>'+

                                        '<div class="modal-body">'+
                                            '<div id="showForm"></div>'+
                                        '</div>'+

                                        '<div class="modal-footer">'+
                                            '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                            '<button type="submit" class="btn btn-primary btn-ladda btn-ladda-spinner"id="simpan"> <span class="ladda-label">Save</span> </button>'+
                                        '</div>'+
                                    '</div>'+
                                '</form>'+
                            '</div>'+
                        '</div>';

                        $("#divModal").empty().html(el);
                        $("#modal_default").modal("show");
                        $("#showForm").empty().html(el);
                    },
                    success:function(result){
                        el+='<table class="table table-striped table-bordered" id="tabeltarget">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th width="5%" rowspan="2"></th>'+
                                    '<th>Tahun</th>'+
                                    '<th>Target</th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tbody>';
                                var no=0;
                                $.each(result,function(c,d){
                                    no++;
                                    var pilih="";
                                    if(unitsosmedtarget==d.id){
                                        pilih="checked='checked'";
                                    }
                                    el+="<tr>"+
                                        "<td><input type='radio' name='set' value='"+d.id+"' "+pilih+"></td>"+
                                        "<td>"+d.tahun+"</td>"+
                                        "<td>"+d.target+"</td>"+
                                    "</tr>";
                                })
                            el+='</tbody>'+
                        '</table>';

                        $("#showForm").empty().html(el);
                    },
                    error:function(){

                    }
                })
            })

            function showOfficial(){
                var periode=$("#periode").val();
                var typeunit=$("#typeunit").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/growth_program_by_id')}}/"+id,
                    type:"GET",
                    data:"type=program",
                    beforeSend:function(){
                        $("#chartOfficial").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>");
                    },
                    success:function(result){
                        console.log(result);
                        $("#chartOfficial").empty();
                        var series=[];
                        var tanggal=[];
                        var facebook=[];
                        var twitter=[];
                        var instagram=[];
                        var youtube=[];

                        $.each(result.follower,function(a,b){
                            if(b.sosmed_id==1){
                                twitter.push(b.num_of_growth);
                                tanggal.push(b.tanggal);
                            }

                            if(b.sosmed_id==2){
                                facebook.push(b.num_of_growth);
                            }

                            if(b.sosmed_id==3){
                                instagram.push(b.num_of_growth);
                            }   

                            if(b.sosmed_id==4){
                                youtube.push(b.num_of_growth);
                            }
                        })

                        series.push({
                            "values":twitter,
                            "text":"Twitter",
                            "line-color":"#008ef6",
                            "marker":{
                                "background-color":"#008ef6",
                                "border-color":"#008ef6"
                            }
                        });

                        series.push({
                            "values":facebook,
                            "text":"Facebook",
                            "line-color":"#5054ab",
                            "marker":{
                                "background-color":"#5054ab",
                                "border-color":"#5054ab"
                            }
                        });

                        series.push({
                            "values":instagram,
                            "text":"Instagram",
                            "line-color":"#a200b2",
                            "marker":{
                                "background-color":"#a200b2",
                                "border-color":"#a200b2"
                            }
                        });

                        series.push({
                            "values":youtube,
                            "text":"Youtube",
                            "line-color":"#222222",
                            "marker":{
                                "background-color":"#222222",
                                "border-color":"#222222"
                            }
                        });

                        zingchart.THEME="classic";
                        var myConfig = {
                            "background-color":"white",
                            "type":"line",
                            "legend":{
                                "layout":"x1",
                                "margin-top":"5%",
                                "border-width":"0",
                                "shadow":false,
                                "marker":{
                                    "cursor":"hand",
                                    "border-width":"0"
                                },
                                "background-color":"white",
                                "item":{
                                    "cursor":"hand"
                                },
                                "toggle-action":"remove"
                            },
                            "scaleX":{
                                "values":tanggal
                            },
                            "scaleY":{
                                "line-color":"#333"
                            },
                            "tooltip":{
                                "text":"%t: %v outbreaks in %k"
                            },
                            "plot":{
                                "line-width":3,
                                "marker":{
                                    "size":2
                                },
                                "selection-mode":"multiple",
                                "background-mode":"graph",
                                "selected-state":{
                                    "line-width":4
                                },
                                "background-state":{
                                    "line-color":"#eee",
                                    "marker":{
                                        "background-color":"none"
                                    }
                                }
                            },
                            "plotarea":{
                                "margin":"15% 25% 10% 7%"
                            },
                            "series":series
                        };
                        
                        
                        zingchart.render({ 
                            id : 'chartOfficial', 
                            data : myConfig, 
                            height: '100%', 
                            width: '100%' 
                        });
                    }
                })
            }
            
            function periode(){
				var pilih=""
				$.ajax({
					url:"{{URL::to('sosmed/data/periode')}}",
					type:"GET",
                    beforeSend:function(){
                        $("#divPeriode").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
					success:function(result){
						console.log(result);

						var p="<select name='periode' id='periode' class='form-control'>"+
							"<option value='' selected='selected'>--Periode--</option>";
							$.each(result,function(a,b){

								p+="<option value='"+b.key+"'>"+b.value+"</option>";
							})
						p+="</select>";


						$("#divPeriode").empty().html(p);
                        $("#periode").val(bulan);
					}
				})
            }
            
            $(document).on("click",'#filterOfficial',function(){
                var periode=$("#periode").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/growth_program_by_id')}}/"+id,
                    type:"GET",
                    data:"type=program&periode="+periode,
                    beforeSend:function(){
                        $("#chartOfficial").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>");
                    },
                    success:function(result){
                        $("#chartOfficial").empty();
                        var series=[];
                        var tanggal=[];
                        var facebook=[];
                        var twitter=[];
                        var instagram=[];
                        var youtube=[];

                        $.each(result.follower,function(a,b){
                            if(b.sosmed_id==1){
                                twitter.push(b.num_of_growth);
                                tanggal.push(b.tanggal);
                            }

                            if(b.sosmed_id==2){
                                facebook.push(b.num_of_growth);
                            }

                            if(b.sosmed_id==3){
                                instagram.push(b.num_of_growth);
                            }   

                            if(b.sosmed_id==4){
                                youtube.push(b.num_of_growth);
                            }
                        })

                        series.push({
                            "values":twitter,
                            "text":"Twitter",
                            "line-color":"#008ef6",
                            "marker":{
                                "background-color":"#008ef6",
                                "border-color":"#008ef6"
                            }
                        });

                        series.push({
                            "values":facebook,
                            "text":"Facebook",
                            "line-color":"#5054ab",
                            "marker":{
                                "background-color":"#5054ab",
                                "border-color":"#5054ab"
                            }
                        });

                        series.push({
                            "values":instagram,
                            "text":"Instagram",
                            "line-color":"#a200b2",
                            "marker":{
                                "background-color":"#a200b2",
                                "border-color":"#a200b2"
                            }
                        });

                        series.push({
                            "values":youtube,
                            "text":"Youtube",
                            "line-color":"#222222",
                            "marker":{
                                "background-color":"#222222",
                                "border-color":"#222222"
                            }
                        });

                        zingchart.THEME="classic";
                        var myConfig = {
                            "background-color":"white",
                            "type":"line",
                            "legend":{
                                "layout":"x1",
                                "margin-top":"5%",
                                "border-width":"0",
                                "shadow":false,
                                "marker":{
                                    "cursor":"hand",
                                    "border-width":"0"
                                },
                                "background-color":"white",
                                "item":{
                                    "cursor":"hand"
                                },
                                "toggle-action":"remove"
                            },
                            "scaleX":{
                                "values":tanggal
                            },
                            "scaleY":{
                                "line-color":"#333"
                            },
                            "tooltip":{
                                "text":"%t: %v outbreaks in %k"
                            },
                            "plot":{
                                "line-width":3,
                                "marker":{
                                    "size":2
                                },
                                "selection-mode":"multiple",
                                "background-mode":"graph",
                                "selected-state":{
                                    "line-width":4
                                },
                                "background-state":{
                                    "line-color":"#eee",
                                    "marker":{
                                        "background-color":"none"
                                    }
                                }
                            },
                            "plotarea":{
                                "margin":"15% 25% 10% 7%"
                            },
                            "series":series
                        };
                        
                        
                        zingchart.render({ 
                            id : 'chartOfficial', 
                            data : myConfig, 
                            height: '100%', 
                            width: '100%' 
                        });
                    }
                })
            })

            $(document).on("click","#tambahsosmed",function(){
                var el="";
                el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                    '<div class="modal-dialog">'+
                        '<form id="formSosmed" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header bg-primary">'+
                                    '<h5 class="modal-title" id="modal-title">Add New Social Media</h5>'+
                                    '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                '</div>'+

                                '<div class="modal-body">'+
                                    '<div id="pesan"></div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Social Media</label>'+
                                        '<select name="sosmedid" id="sosmedid" class="form-control">'+
                                            '<option disabled selected>--Pilih Socmed--</option>'+       
                                            '<option value="1">Twitter</option>'+
                                            '<option value="2">Facebook</option>'+
                                            '<option value="3">Instagram</option>'+
                                            '<option value="4">Youtube</option>'+
                                        '</select>'+
                                    '</div>'+

                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Account Name</label>'+
                                        '<input class="form-control" name="name_sosmed" id="name_sosmed" placeholder="Account Name" required>'+
                                    '</div>'+

                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Account ID</label>'+
                                        '<textarea name="account_id" rows="10" cols="50" id="accoount_id" class="form-control" required></textarea>'+
                                    '</div>'+
                                '</div>'+

                                '<div class="modal-footer">'+
                                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                    '<button type="submit" class="btn btn-primary btn-ladda btn-ladda-spinner"id="simpan"> <span class="ladda-label">Save</span> </button>'+
                                '</div>'+
                            '</div>'+
                        '</form>'+
                    '</div>'+
                '</div>';

                $("#divModal").empty().html(el);
                $("#modal_default").modal("show");
            })

            $(document).on("submit","#formSosmed",function(e){
                var data = new FormData(this);
                data.append("_token","{{ csrf_token() }}");
                data.append("type","program");
                data.append("program_unit",id);
                if($("#formSosmed")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('sosmed/data/unit-sosmed')}}",
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $('#pesan').html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {
                            $('#pesan').html('&nbsp;'+data.pesan);

                            if(data.success==true){
                                sosmed();
                                // liveSocmed();
                                location.reload();
                                $("#modal_default").modal("hide");
                            }else{
                                $("#pesan").empty().html("<pre>"+data.error+"</pre>");
                            }
                        },
                        error   :function() {  
                            $('#pesan').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            })

            $(document).on("click",".editsosmed",function(){
                var el="";
                kode=$(this).attr("kode");

                $.ajax({
                    url:"{{URL::to('sosmed/data/unit-sosmed')}}/"+kode,
                    type:"GET",
                    data:"type=program",
                    beforeSend:function(){
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog">'+
                                '<form id="formSosmedUpdate" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                                    '<div class="modal-content">'+
                                        '<div class="modal-header bg-primary">'+
                                            '<h5 class="modal-title" id="modal-title">Add New Social Media</h5>'+
                                            '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                        '</div>'+

                                        '<div class="modal-body">'+
                                            '<div id="pesan"></div>'+
                                            '<div id="showProgress"></div>'+
                                        '</div>'+

                                        '<div class="modal-footer">'+
                                            '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                            '<button type="submit" class="btn btn-primary btn-ladda btn-ladda-spinner"id="simpan"> <span class="ladda-label">Save</span> </button>'+
                                        '</div>'+
                                    '</div>'+
                                '</form>'+
                            '</div>'+
                        '</div>';

                        $("#divModal").empty().html(el);
                        $("#modal_default").modal("show");
                        $("#showProgress").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        el+='<div class="form-group">'+
                            '<label class="control-label text-semibold">Social Media</label>'+
                            '<select name="sosmedid" id="sosmedid" class="form-control" readonly>'+
                                '<option disabled selected>--Pilih Socmed--</option>'+       
                                '<option value="1">Twitter</option>'+
                                '<option value="2">Facebook</option>'+
                                '<option value="3">Instagram</option>'+
                                '<option value="4">Youtube</option>'+
                            '</select>'+
                        '</div>'+

                        '<div class="form-group">'+
                            '<label class="control-label text-semibold">Account Name</label>'+
                            '<input class="form-control" value="'+result.unit_sosmed_name+'" name="name_sosmed" id="name_sosmed" placeholder="Account Name" required>'+
                        '</div>'+

                        '<div class="form-group">'+
                            '<label class="control-label text-semibold">Account ID</label>'+
                            '<textarea name="account_id" rows="10" cols="50" id="accoount_id" class="form-control" required>'+result.unit_sosmed_account_id+'</textarea>'+
                        '</div>';


                        $("#showProgress").empty().html(el);
                        $("#sosmedid").val(result.sosmed_id);
                    },
                    errors:function(){

                    }
                })
            })

            $(document).on("submit","#formSosmedUpdate",function(e){
                var data = new FormData(this);
                data.append("_token","{{ csrf_token() }}");
                data.append("type","program");
                data.append("program_unit",id);
                data.append("_method","PUT");
                if($("#formSosmedUpdate")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('sosmed/data/unit-sosmed')}}/"+kode,
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $('#pesan').html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {
                            $('#pesan').html('&nbsp;'+data.pesan);

                            if(data.success==true){
                                sosmed();
                                // liveSocmed();
                                location.reload();
                                $("#modal_default").modal("hide");
                            }else{
                                $("#pesan").empty().html("<pre>"+data.error+"</pre>");
                            }
                        },
                        error   :function() {  
                            $('#pesan').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            })

            $(document).on("click",".hapusosmed",function(){
                kode=$(this).attr("kode");

                swal({
                    title: "Are you sure?",
                    text: "You will delete data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url:"{{URL::to('sosmed/data/unit-sosmed')}}/"+kode,
                            type:"DELETE",
                            data:"_token={{ csrf_token() }}",
                            success:function(result){
                                if(result.success=true){
                                    swal("Deleted!", result.pesan, "success");
                                    sosmed();
                                    // liveSocmed();
                                    location.reload();
                                }else{
                                    swal("Error!", result.pesan, "error");
                                }
                            }
                        })
                    } else {
                        swal("Your data is safe!");
                    }
                });
            })

            $(document).on("switchChange.bootstrapSwitch",'.checkboxnya',function(event,state){
                var kode=$(this).attr("kode");

                /* jika true berarti dari off ke on */
                if(state==true){
                    var status="Y";    
                }else if(state==false){
                    var status="N";
                }

                var param={
                    "status":status,
                    "kode":kode,
                    "_token":"{{ csrf_token() }}"
                }

                swal({
                    title: "Are you sure?",
                    text: "You will to change status data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url:"{{URL::to('sosmed/data/aktif-non-aktif-program')}}/"+kode,
                            type:"PUT",
                            data:param,
                            success:function(result){
                                if(result.success=true){
                                    swal("Changed!", result.pesan, "success");
                                    location.reload();
                                }else{
                                    swal("Error!", result.pesan, "error");
                                }
                            }
                        })
                    } else {
                        swal("Your data is safe!");
                    }
                });

                /* jika false berarti dari on ke off */

            })

            function liveSocmed(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/live-socmed-by-id')}}/"+id,
                    type:"GET",
                    data:"type=program",
                    beforeSend:function(){
                        $("#divLiveSocmed").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        $("#divLiveSocmed").empty().html(result);
                    },
                    errors:function(){

                    }
                })
            }
            
            periode();
            sosmed();
            showSosmed();
            showOfficial();
            // liveSocmed();
        })
    </script>
@stop
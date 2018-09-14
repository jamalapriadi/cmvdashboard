@extends('layouts.coreui.main')

@section('content')
    <div class="row">
        @foreach($bu->sosmed as $row)
            @if($row->sosmed_id==1)
                <div class="col-sm-6 col-lg-3">
                    <div class="brand-card">
                        <div class="brand-card-header bg-facebook">
                            <i class="fa fa-facebook"></i>
                            <div class="chart-wrapper">
                                <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                    <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                        <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                        <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                    </div>
                                </div>
                                <canvas id="social-box-chart-1" height="96" width="387" class="chartjs-render-monitor" style="display: block; width: 387px; height: 96px;"></canvas>
                            </div>
                        </div>
                        <div class="brand-card-body">
                            <div>
                                <div class="text-value">89k</div>
                                <div class="text-uppercase text-muted small">friends</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($row->sosmed_id==2)
                <div class="col-sm-6 col-lg-3">
                    <div class="brand-card">
                        <div class="brand-card-header bg-facebook">
                            <i class="fa fa-facebook"></i>
                            <div class="chart-wrapper">
                                <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                    <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                        <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                        <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                    </div>
                                </div>
                                <canvas id="social-box-chart-1" height="96" width="387" class="chartjs-render-monitor" style="display: block; width: 387px; height: 96px;"></canvas>
                            </div>
                        </div>
                        <div class="brand-card-body">
                            <div>
                                <div class="text-value">89k</div>
                                <div class="text-uppercase text-muted small">friends</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-header">Summary Business Unit</div>
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#highlight-tab1" role="tab" aria-controls="nav-home" aria-selected="true">SUMMARY</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#highlight-tab2" role="tab" aria-controls="nav-profile" aria-selected="false">SOCIAL MEDIA</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#highlight-tab3" role="tab" aria-controls="nav-contact" aria-selected="false">TARGET</a>
                        </div>
                    </nav>
                    <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="highlight-tab1" role="tabpanel" aria-labelledby="nav-home-tab">

                        </div>

                        <div class="tab-pane fade" id="highlight-tab2" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div id="divSosmed"></div>
                        </div>

                        <div class="tab-pane fade" id="highlight-tab3" role="tabpanel" aria-labelledby="nav-home-tab">
                            <a class="btn btn-primary" id="tambahtarget">
                                <i class="icon-add"></i> &nbsp; Add New Target 
                            </a>
                            <hr>
                            <div id="divTarget"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($bu->sosmed as $row)
            @if($row->sosmed_id==1)
                <div class="col-lg-4">
                    <div class="card card-default">
                        <div class="card-header">Twitter</div>
                        <div class="card-body">
                            <a class="twitter-timeline" data-height="560" data-theme="light" data-link-color="#E81C4F" href="https://twitter.com/{{$row->unit_sosmed_name}}?ref_src=twsrc%5Etfw">Tweets by {{$row->unit_sosmed_name}}</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                        </div>
                    </div>
                </div>
            @endif

            @if($row->sosmed_id==2)
                <div class="col-lg-4">
                    <div class="card card-default">
                        <div class="card-header">Facebook</div>
                        <div class="card-body">
                            <div id="fb-root"></div>
        
                            <div class="fb-page" data-href="https://www.facebook.com/OfficialRCTI.TV/" data-tabs="timeline" data-height="560" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/OfficialRCTI.TV/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/OfficialRCTI.TV/">Official RCTI</a></blockquote></div>
                        </div>
                    </div>
                </div>
            @endif

            @if($row->sosmed_id==3)
                <div class="col-lg-4">
                    <div class="card card-default">
                        <div class="card-header">Instagram</div>
                        <div class="card-body" style="height:600px;">
                            <script src="https://apps.elfsight.com/p/platform.js" defer></script>
                            <div class="elfsight-app-5c80d96b-e512-43ab-9c2b-e55ee38a0acc" style="max-height:100px;"></div>
                        </div>
                    </div>
                </div>
            @endif

            @if($row->sosmed_id==4)
                <div class="col-lg-4">
                    <div class="card card-default">
                        <div class="card-header">Youtube</div>
                        <div class="card-body">
                            <iframe src="http://youtube.com/embed/?listType=user_uploads&list=RCTIOfficialChannel" height="560px" frameborder="o"></iframe>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <div id="divModal"></div>
     
@stop

@section('js')
<!-- Ini untuk script Facebook API -->
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId            : '326236844797670',
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v3.1'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    
   </div>

    <script>
        $(function(){
            var id="{{$id}}";
            var kode="";
            var idunitsosmed="";
            var unitsosmedtarget="";
            var sos=@json($bu);

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
                    data:"type=corporate",
                    beforeSend:function(){

                    },
                    success:function(result){
                        var el=""
                        el+='<table class="table table-striped" id="tabelsosmed">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th width="5%">No.</th>'+
                                    '<th width="20%">Sosial Media</th>'+
                                    '<th width="20%">Official Account</th>'+
                                    '<th width="15%">Target</th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tbody>';
                                var no=0;
                                $.each(result.sosmed,function(a,b){
                                    no++;
                                    el+="<tr>"+
                                        "<td>"+no+"</td>"+
                                        "<td>"+b.sosmed.sosmed_name+"</td>"+
                                        "<td>"+b.unit_sosmed_name+"</td>";
                                        if(b.target!=null){
                                            el+="<td><a class='setupdatetarget' kode='"+b.id+"' utarget='"+b.target.id+"'><label class='label label-info'>"+b.target.target+"</label></a></td>";
                                        }else{
                                            el+="<td><a class='settarget' kode='"+b.id+"'><label class='label label-warning'><i class='fa fa-spinner icon-gear'></i> Please Set Target</label></a></td>";
                                        }
                                    el+="</tr>";
                                })
                            el+='</tbody>'+
                        '</table>';

                        $("#divSosmed").empty().html(el);

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

            function target(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/alltarget-sosmed-program')}}/"+id,
                    data:"type=corporate",
                    beforeSend:function(){

                    },
                    success:function(result){
                        var el=""
                        el+='<table class="table table-striped table-bordered" id="tabeltarget">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th width="5%" rowspan="2">No.</th>'+
                                    '<th width="20%" rowspan="2">Tahun</th>'+
                                    '<th width="20%" colspan="'+result.program.sosmed.length+'" class="text-center">Sosial Media</th>'+
                                '</tr>'+
                                '<tr>';
                                    $.each(result.program.sosmed,function(a,b){
                                        el+="<th>"+b.sosmed.sosmed_name+"</th>";
                                    })
                                el+='</tr>';
                            '</thead>'+
                            '<tbody>';
                                var no=0;
                                $.each(result.result,function(c,d){
                                    no++;
                                    el+="<tr>"+
                                        "<td>"+no+"</td>"+
                                        "<td>"+d.tahun+"</td>";
                                        $.each(d.sosmed,function(e,f){
                                            el+="<td>"+f.target+"</td>";
                                        })
                                    el+="</tr>";
                                })
                            el+='</tbody>'+
                        '</table>';

                        $("#divTarget").empty().html(el); 
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
                    data:"type=corporate",
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

            sosmed();
            target();
            showSosmed();
        })
    </script>
@stop
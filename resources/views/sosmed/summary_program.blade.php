@extends('layouts.sosmed')

@section('extra-style')
    <style>
        .zc-ref {
            display: none;
        }
        #myChart{
            height:100%;
            width:100%;
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Summary Program</div>
        <div class="panel-body">
            <ul class="nav nav-tabs nav-tabs-highlight">
                <li class="active"><a href="#highlighted-tab1" data-toggle="tab">Summary</a></li>
                <li><a href="#highlighted-tab2" data-toggle="tab">Sosial Media</a></li>
                <li><a href="#highlighted-tab3" data-toggle="tab">Target</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="highlighted-tab1">
                    Highlight top border of the active tab by adding <code>.nav-tabs-highlight</code> class.
                </div>

                <div class="tab-pane" id="highlighted-tab2">
                    <div id="divSosmed"></div>
                </div>

                <div class="tab-pane" id="highlighted-tab3">
                    <a class="btn btn-primary" id="tambahtarget">
                        <i class="icon-add"></i> &nbsp; Add New Target 
                    </a>
                    <hr>
                    <div id="divTarget"></div>
                </div>

                <div class="tab-pane" id="highlighted-tab4">
                    Aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthet.
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Recent Activity
                </div>
                <div class="panel-body">
                    <div id="myChart"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="divModal"></div>
@stop

@push('extra-script')
    <script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js"></script>
    {{Html::script('limitless1/assets/js/plugins/tables/datatables/extensions/fixed_columns.min.js')}}

    <script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
	<script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
	ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9","ee6b7db5b51705a13dc2339db3edaf6d"];</script>
	<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script src="https://www.amcharts.com/lib/3/pie.js"></script>
    <script>
        $(function(){
            var id="{{$id}}";
            var kode="";
            var idunitsosmed="";
            var unitsosmedtarget="";

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

            function sosmed(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/target-sosmed-program')}}/"+id,
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

            function showChart(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/chart/daily-chart')}}/"+id+"/program",
                    type:"GET",
                    beforeSend:function(){

                    },
                    success:function(result){
                        var myConfig ={
                            type: "area",
                            stacked: true,
                            title:{
                                text: "Monthly Apparel Sales",
                                fontColor: "#424242",
                                adjustLayout: true,
                                marginTop: 15
                            },
                            subtitle:{
                                text: "In thousands (k)",
                                fontColor: "#616161",
                                adjustLayout: true,
                                marginTop: 45
                            },
                            plot:{
                                aspect: "spline",
                                alphaArea: 0.6
                            },
                            plotarea:{
                                margin: "dynamic"
                            },
                            tooltip:{visible:false},
                            scaleY:{
                                short:true,
                                shortUnit:'k',
                                lineColor: "#AAA5A5",
                            tick:{
                                lineColor: "#AAA5A5"
                            },
                            item:{
                                fontColor: "#616161",
                                paddingRight: 5
                            },
                            guide:{
                                lineStyle: "dotted",
                                lineColor: "#AAA5A5"
                            },
                            label:{
                                text: "Quantity",
                                fontColor: "#616161"
                            }
                            },
                            scaleX:{
                                lineColor: "#AAA5A5",
                                labels:result.tanggal,
                                tick:{
                                    lineColor: "#AAA5A5"
                                },
                                item:{
                                    fontColor: "#616161",
                                    paddingTop: 5
                                },
                                label:{
                                    text: "2016",
                                    fontColor: "#616161"
                                }
                            },
                            crosshairX:{
                            lineColor: "#AAA5A5",
                            plotLabel:{
                                backgroundColor:"#EBEBEC",
                                borderColor: "#AAA5A5",
                                borderWidth: 2,
                                borderRadius: 2, 	
                                thousandsSeparator:',',
                                fontColor:'#616161'
                            },
                            scaleLabel:{
                                backgroundColor: "#EBEBEC",
                                borderColor: "#AAA5A5",
                                fontColor: "#424242"
                            }
                            },
                            series : [
                                {
                                    values : result.tw,
                                    text: "Twitter",
                                    backgroundColor: "#4CAF50",
                                    lineColor: "#4CAF50",
                                    marker:{
                                    backgroundColor: "#4CAF50",
                                    borderColor: "#4CAF50"
                        
                                    }
                                },
                                {
                                    values : result.fb,
                                    text: "Facebook",
                                    backgroundColor: "#E53935",
                                    lineColor: "#E53935",
                                    marker:{
                                    backgroundColor: "#E53935",
                                    borderColor: "#E53935"
                        
                                    }
                                },
                                {
                                    values : result.ig,
                                    text: "Instagram",
                                    backgroundColor: "#00BCD4",
                                    lineColor: "#00BCD4",
                                    marker:{
                                    backgroundColor: "#00BCD4",
                                    borderColor: "#00BCD4"
                        
                                    }
                                }
                            ]
                        };
                        
                        zingchart.render({ 
                            id : 'myChart', 
                            data : myConfig 
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
                    beforeSend:function(){
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog">'+
                                '<form id="formTarget" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                                    '<div class="modal-content">'+
                                        '<div class="modal-header bg-primary">'+
                                            '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                            '<h5 class="modal-title" id="modal-title">Add New Target</h5>'+
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
                                            '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                            '<h5 class="modal-title" id="modal-title">Set Target</h5>'+
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
                                            '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                            '<h5 class="modal-title" id="modal-title">Set Target</h5>'+
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
            showChart();
        })
    </script>
@endpush
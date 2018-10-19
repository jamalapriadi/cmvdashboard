@extends('layouts.coreui.main')

@section('extra-style')
<style>
    fieldset{
        border: 1px solid #ddd !important;
        margin: 0;
        xmin-width: 0;
        padding: 10px;       
        position: relative;
        border-radius:4px;
        background-color:#f5f5f5;
        padding-left:10px!important;
    }	

    legend{
        font-size:14px;
        font-weight:bold;
        margin-bottom: 0px; 
        width: 35%; 
        border: 1px solid #ddd;
        border-radius: 4px; 
        padding: 5px 5px 5px 10px; 
        background-color: #d8dfe5;
        color:#222;
    }
    .daterangepicker{z-index:1151 !important;}
    table.floatThead-table {
        border-top: none;
        border-bottom: none;
        background-color: #fff;
    }
</style>
@stop

@section('content')
    <div class="card card-default">
        <div class="card-header">Add New Daily Report # {{$id}}</div>
        <div class="card-body">
            <div id="pesansukses"></div>
            <div id="showKonfirmasi"></div>
            <div id="showForm"></div>
        </div>
    </div>

    <div id="divModal"></div>
@stop

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    {{Html::script('limitless1/assets/js/plugins/jquery-number/jquery.number.min.js')}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/floatthead/2.1.1/jquery.floatThead.js"></script>
    <script>
        $(function(){
            var id="{{auth()->user()->id}}";
            var kode="";
            var data;

            $('.daterange-single').daterangepicker({ 
                singleDatePicker: true,
                selectMonths: true,
                selectYears: true
            });

            function showForm(){
                var el="";
                $("#showKonfirmasi").hide();

                $.ajax({
                    url:"{{URL::to('brand/data/list-advertiser')}}",
                    type:"GET",
                    data:"unit=unit&sosmed=sosmed",
                    beforeSend:function(){
                        $("#showForm").empty().html("<div class='alert alert-info'>Please Wait....</div>");
                    },
                    success:function(result){
                        el+='<form id="form" onsubmit="return false;">'+
                            '<div class="row">'+
                                "<div class='col-lg-3'>"+
                                    '<div class="form-group">'+
                                        '<label class="control-label">Tanggal</label>'+
                                        '<div class="input-group">'+
                                            '<span class="input-group-addon"><i class="icon-calendar5"></i></span>'+
                                            '<input type="text" id="tanggal" name="tanggal" class="form-control daterange-single">'+
                                        '</div>'+
                                    '</div>'+
                                "</div>"+
                                "<div class='col-lg-4'>"+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Advertiser</label>'+
                                        '<select name="advertiser" id="advertiser" class="form-control">'+
                                            '<option value="" disabled selected>--Select Advertiser--</option>';
                                            $.each(result,function(a,b){
                                                el+="<option value='"+b.advertiser_id+"'>"+b.advertiser.nama_adv+"</option>";
                                            })
                                        el+='</select>'+
                                    '</div>'+
                                "</div>"+
                            "</div>"+

                            '<br>'+

                            '<div id="showSosmed"></div>'+
                            '<div id="pesan"></div>'+

                            '<div id="showButton"></div>'+

                        '</form>';

                        $("#showForm").empty().html(el);

                        $("#showForm").show();

                        $("#advertiser").select2();

                        $('.daterange-single').daterangepicker({ 
                            singleDatePicker: true,
                            selectMonths: true,
                            selectYears: true
                        });
                    },
                    error:function(){
                        $("#showForm").empty().html("<div class='alert alert-danger'>Data Failed to load</div>");
                    }
                })
            }

            $(document).on("change","#advertiser",function(){
                var advertiser=$("#advertiser option:selected").val();
                var tanggal=$("#tanggal").val();
                var sosmed="{{$id}}";

                $.ajax({
                    url:"{{URL::to('brand/data/list-unit-sosmed-by-advertiser')}}/"+advertiser,
                    type:"GET",
                    data:"tanggal="+tanggal+"&sosmed="+sosmed,
                    beforeSend:function(){
                        $("#showSosmed").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                    },
                    success:function(result){
                        var kembali="{{URL::to('brand/input-report')}}/{{$id}}";

                        $("#showSosmed").empty().html(result);

                        var el="";
                        el+='<hr>'+

                        '<div class="form-group">'+
                            '<button class="btn btn-primary">'+
                                '<i class="icon-floppy-disk"></i> Save'+
                            '</button>'+

                            '<a href="'+kembali+'" class="btn btn-default">'+
                                'Back'+
                            '</a>'+
                        '</div>';

                        $("#showButton").empty().html(el);
                        $(".sticky-header").floatThead({scrollingTop:50});
                        $('form').on('focus', 'input[type=number]', function (e) {
                            $(this).on('mousewheel.disableScroll', function (e) {
                                e.preventDefault()
                            })
                        })
                        $('form').on('blur', 'input[type=number]', function (e) {
                            $(this).off('mousewheel.disableScroll')
                        })
                    },
                    error:function(){
                        $("#showSosmed").empty().html("<div class='alert alert-danger'>Failed to load data...</div>");
                    }
                })
            })

            $(document).on("submit","#form",function(e){
                data = new FormData(this);
                data.append("_token","{{ csrf_token() }}");
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('brand/data/cek-save-daily-report')}}",
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $("#pesansukses").empty();
                            $('#pesan').empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {
                            if(data.success==true){
                                /* tampilkan data konfirmasi */
                                $("#pesan").empty();
                                var el="";
                                el+='<div class="alert alert-danger  alert-bordered alert-rounded">'+
                                    '<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>'+
                                    '<span class="text-semibold">Watch out!</span> Please make sure you put the right data!'+
                                '</div>'+
                                "<div class='table-responsive'>"+
                                    "<table class='table table-striped'>"+
                                        "<thead>"+
                                            "<tr>"+
                                                '<th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">Official Account</th>'+
                                                "<th colspan='3' class='text-center' class='text-center' style='background:#222;color:white'>Tanggal</th>"+
                                            "</tr>"+
                                            "<tr>"+
                                                "<th class='text-center' style='background:#008ef6;color:white'>"+data.tanggal_kemarin+"</td>"+
                                                "<th class='text-center' style='background:#008ef6;color:white'>"+data.tanggal_sekarang+"</td>"+
                                                "<th class='text-center' style='background:#008ef6;color:white'>Additional Follower</td>"+
                                            "</tr>"+
                                        "</thead>"+
                                        "<tbody>";
                                            $.each(data.official,function(a,b){
                                                var kemarin=0;
                                                var sekarang=0;
                                                var growth=0;
                                                var num_of_growth=0;
                                                var last=0;

                                                if(data.datasekarang.length>0){
                                                    for(a=0;a<data.datasekarang.length;a++){
                                                        if(data.datasekarang[a].unit_sosmed_id==b.unit_sosmed_id && data.datasekarang[a].tanggal==data.tanggal_sekarang){
                                                            last=data.datasekarang[a].last;
                                                            sekarang=data.datasekarang[a].follower;
                                                            growth=data.datasekarang[a].growth;
                                                            num_of_growth=data.datasekarang[a].num_of_growth;
                                                        }
                                                    }
                                                }

                                                el+="<tr>"+
                                                    "<td>"+b.sosmed_name+"</td>"+
                                                    "<td>"+last+"</td>"+
                                                    "<td>"+sekarang+"</td>"+
                                                    "<td>";
                                                        if(growth>0){
                                                            el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+Math.round(growth)+" % ( "+num_of_growth+" )</a>";
                                                        }else{
                                                            if(!isNaN(growth)){
                                                                el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+Math.round(growth)+" % ( "+num_of_growth+" )</a>";
                                                            }else{
                                                                el+="-";
                                                            }
                                                        }
                                                    el+="</td>"+
                                                "</tr>";
                                            })
                                        el+="</tbody>"+
                                    "</table>"+
                                "</div>"+

                                "<div class='well'>"+
                                    "<div class='form-group'>"+
                                        "<a class='btn btn-primary' id='konfirmasi'><i class='icon-file-check2'></i> Konfirmasi</>"+
                                        "<a class='btn btn-default' id='kembali'><i class='icon-backward2'></i> Back</a>"+
                                    "</div>"+
                                "</div>";
                                
                                $("#showForm").hide();
                                $("#showKonfirmasi").empty().html(el);
                                $("#showKonfirmasi").show();
                                /* end tampilkan data konfirmasi */
                            }else{
                                // new PNotify({
                                //     title: 'Error!',
                                //     text: data.pesan,
                                //     addclass: 'alert-styled-right',
                                //     type: 'error'
                                // });

                                $("#pesan").empty().html("<div class='alert alert-danger'>"+data.pesan+"</div>");
                            }
                        },
                        error   :function() {  
                            $('#pesan').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            });

            $(document).on("click","#kembali",function(){
                $("#showForm").show();
                $("#showKonfirmasi").hide();
            });

            $(document).on("click","#konfirmasi",function(e){
                if($("#form")[0].checkValidity()) {
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('brand/data/save-daily-report')}}",
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $("#pesansukses").empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                            $('#pesan').empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {
                            if(data.success==true){
                                showForm();
                                $('#pesansukses').empty().html('<div class="alert alert-success">&nbsp;'+data.pesan+"</div>");
                            }else{
                                // new PNotify({
                                //     title: 'Error!',
                                //     text: data.pesan,
                                //     addclass: 'alert-styled-right',
                                //     type: 'error'
                                // });

                                $("#pesansukses").empty().html("<div class='alert alert-danger'>"+data.pesan+"</div>");
                            }
                        },
                        error   :function() {  
                            $('#pesansukses').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            })

            showForm();
        })
    </script>
@stop
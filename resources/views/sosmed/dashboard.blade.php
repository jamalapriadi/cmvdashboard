@extends('layouts.sosmed')

@section('title')
    Dashboard
@endsection

@section('extra-style')

@endsection

@section('content')
<div class="container-fluid">
    <!-- OVERVIEW -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title text-center">SUMMARY</h3>
        </div>
        <div class="panel-body">
            <div class="tabbable">
                <ul class="nav nav-tabs nav-tabs-highlight">
                    <li class="active"><a href="#highlight-tab1" data-toggle="tab">TARGET VS ACHIEVEMENT</a></li>
                    <li><a href="#highlighted-tab2" data-toggle="tab">OFFICIAL ACCOUNT ALL TV</a></li>
                    <li><a href="#highlighted-tab3" data-toggle="tab">SOSMED OFFICIAL AND PROGRAM</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="highlight-tab1">
                        <form id="formTargetAchievement" onsubmit="return false">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Group</label>
                                        <select name="form-control" name="group" id="group" class="form-control">
                                            @foreach($group as $row)
                                                <option value="{{$row->id}}">{{$row->group_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Periode</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="icon-calendar5"></i></span>
                                            <input type="text" id="tanggal" name="tanggal" class="form-control daterange-single">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <button class='btn btn-primary' style="margin-top:25px;">
                                        <i class="icon-filter4"></i> &nbsp;
                                        Filter 
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div style="margin-top:10px;"></div>

                        <div class="table-responsive">
                            <div id="divTargetVsAchievement"></div>
                        </div>
                    </div>

                    <div class="tab-pane" id="highlighted-tab2">
                        <form id="formofficialAccountAllTv" onsubmit="return false">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Group</label>
                                        <select name="form-control" id="group2" name="group" class="form-control">
                                            <option value="">--Select Group--</option>
                                            @foreach($group as $row)
                                                <option value="{{$row->id}}">{{$row->group_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Periode</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="icon-calendar5"></i></span>
                                            <input type="text" name="tanggal" id="tanggal2" class="form-control daterange-single">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <button class='btn btn-primary' style="margin-top:25px;">
                                        <i class="icon-filter4"></i> &nbsp;
                                        Filter 
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <div id="divofficialAccountAllTv"></div>
                        </div>
                    </div>

                    <div class="tab-pane" id="highlighted-tab3">
                        <div id="sosmedOfficialAndProgram"></div>
                    </div>

                    <div class="tab-pane" id="highlighted-tab4">
                        Aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthet.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END OVERVIEW -->
</div>
@endsection


@push('extra-script')
    <script type="text/javascript" src="{{URL::asset('assets/js/core/libraries/jquery_ui/datepicker.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/core/libraries/jquery_ui/effects.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/notifications/jgrowl.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/ui/moment/moment.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/pickers/daterangepicker.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/pickers/anytime.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/pickers/pickadate/picker.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/pickers/pickadate/picker.date.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/pickers/pickadate/picker.time.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/pickers/pickadate/legacy.js')}}"></script>

    <script>
        $(function(){
            var kode="";

            $('.pickadate-accessibility').pickadate({
                labelMonthNext: 'Go to the next month',
                labelMonthPrev: 'Go to the previous month',
                labelMonthSelect: 'Pick a month from the dropdown',
                labelYearSelect: 'Pick a year from the dropdown',
                selectMonths: true,
                selectYears: true
            });

            $('.daterange-single').daterangepicker({ 
                singleDatePicker: true,
                selectMonths: true,
                selectYears: true
            });

            function targetVsAchievement(){
                var group=$("#group option:selected").val();
                var tanggal=$("#tanggal").val();

                var el="";
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/target-vs-achievement')}}",
                    type:"GET",
                    data:"group="+group+"&tanggal="+tanggal,
                    beforeSend:function(){
                        $("#divTargetVsAchievement").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                    },
                    success:function(result){
                        el+='<table class="table table-striped table-bordered">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">Channel</th>';
                                    $.each(result.sosmed,function(a,b){
                                        el+="<th colspan='3' class='text-center' style='background:"+result.header[a]+";color:white'>"+b.sosmed_name+"</th>";
                                    })
                                el+='</tr>'+
                                '<tr>';
                                    $.each(result.sosmed,function(a,b){
                                        el+="<th class='text-center' style='background:"+result.header[a]+";color:white'>"+result.tanggal+"</th>"+
                                        "<th class='text-center' style='background:"+result.header[a]+";color:white'>Target</th>"+
                                        "<th class='text-center' style='background:"+result.header[a]+";color:white'>ACH</th>";
                                    })
                                el+='</tr>'+
                            '</thead>'+
                            '<tbody style="color:#222">';
                                    $.each(result.unit,function(a,b){
                                        el+="<tr>"+
                                            '<td>'+b.unit_name+'</td>';
                                            $.each(b.sosmed,function(c,d){
                                                var target=0;
                                                var tanggal=0;
                                                var ach=0;
                                                el+="<td class='text-center'>";
                                                    if(d.followers.length>0){
                                                        el+=d.followers[0].follower;
                                                        tanggal=d.followers[0].follower;
                                                    }else{
                                                        el+="-";
                                                    }
                                                el+="</td>"+
                                                "<td class='text-center'>";
                                                    if(d.target!=null){
                                                        el+=d.target.target;
                                                        target=d.target.target;
                                                    }else{
                                                        el+="-";
                                                    }
                                                el+="</td>"+
                                                "<td class='text-center'>";
                                                    if(d.followers.length>0){
                                                        el+=Math.round(tanggal/target*100)+" %";
                                                    }else{
                                                        el+="-";
                                                    }
                                                el+="</td>";
                                            })
                                        el+='</tr>';
                                    })
                            el+='</tbody>'+
                        '</table>';

                        $("#divTargetVsAchievement").empty().html(el);
                    },
                    error:function(){

                    }
                })
            }

            function officialAccountAllTv(){
                var el="";
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/official-account-all-tv')}}",
                    type:"GET",
                    beforeSend:function(){
                        $("#divofficialAccountAllTv").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                    },
                    success:function(result){
                        el+='<table class="table table-striped table-bordered">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">Channel</th>';
                                    $.each(result.sosmed,function(a,b){
                                        el+="<th colspan='3' class='text-center' class='text-center' style='background:"+result.header[a]+";color:white'>"+b.sosmed_name+"</th>";
                                    })
                                el+='</tr>'+
                                '<tr>';
                                    $.each(result.sosmed,function(a,b){
                                        el+="<th class='text-center' class='text-center' style='background:"+result.header[a]+";color:white'>"+result.kemarin+"</th>"+
                                        "<th class='text-center' class='text-center' style='background:"+result.header[a]+";color:white'>"+result.sekarang+"</th>"+
                                        "<th class='text-center' class='text-center' style='background:"+result.header[a]+";color:white'>GROWTH FROM YESTERDAY</th>";
                                    })
                                el+='</tr>'+
                            '</thead>'+
                            '<tbody style="color:#222">';
                                $.each(result.unit,function(a,b){
                                    $.each(b.unit,function(c,d){
                                        el+="<tr>"+
                                            "<td>"+d.unit_name+"</td>";
                                            if(d.sosmed.length>0){
                                                $.each(d.sosmed,function(e,f){
                                                    if(f.followers.length>0){
                                                        var sekarang=0;
                                                        var kemarin=0;
                                                        var growth=0;

                                                        for(a=0;a<f.followers.length;a++){
                                                            if(f.followers[a].tanggal==result.sekarang){
                                                                sekarang=f.followers[a].follower;
                                                            }else if(f.followers[a].tanggal=result.kemarin){
                                                                kemarin=f.followers[a].follower;
                                                            }
                                                        }

                                                        growth=sekarang/kemarin-1;

                                                        el+="<td>"+kemarin+"</td>"+
                                                            "<td>"+sekarang+"</td>"+
                                                            "<td>";
                                                            if(growth>0){
                                                                el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+Math.round(growth)+" % </a>";
                                                            }else{
                                                                if(!isNaN(growth)){
                                                                    el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+Math.round(growth)+" % </a>";
                                                                }else{
                                                                    el+="-";
                                                                }
                                                            }
                                                            el+="</td>";
                                                    }else{
                                                        el+="<td>-</td>"+
                                                            "<td>-</td>"+
                                                            "<td>-</td>";
                                                    }
                                                })
                                            }else{
                                                el+="<td>-</td>"+
                                                "<td>-</td>"+
                                                "<td>-</td>"+
                                                "<td>-</td>"+
                                                "<td>-</td>"+
                                                "<td>-</td>"+
                                                "<td>-</td>"+
                                                "<td>-</td>"+
                                                "<td>-</td>";
                                            }
                                        el+="</tr>";
                                    })
                                    el+="<tr style='background:#f2eff2;color:#222;font-weight:700'>"+
                                        "<td>"+b.group_name+"</td>";
                                        if(result.summary.length>0){
                                            $.each(result.sosmed,function(f,g){
                                                var sumsekarang=0;
                                                var sumkemarin=0;
                                                var sumgrowth=0;
                                                for(j=0;j<result.summary.length;j++){
                                                    if(result.summary[j].group_id==b.id && result.summary[j].tanggal==result.sekarang && result.summary[j].sos_id==g.id){
                                                        sumsekarang=result.summary[j].jumlah;
                                                    }

                                                    if(result.summary[j].group_id==b.id && result.summary[j].tanggal==result.kemarin && result.summary[j].sos_id==g.id){
                                                        sumkemarin=result.summary[j].jumlah;
                                                    }
                                                }
                                                sumgrowth=sumsekarang/sumkemarin-1;

                                                el+="<td>";
                                                    if(sumkemarin>0){
                                                        el+=sumkemarin;
                                                    }else{
                                                        el+="-";
                                                    }
                                                el+="</td>"+
                                                "<td>";
                                                    if(sumsekarang>0){
                                                        el+=sumsekarang;
                                                    }else{
                                                        el+="-";
                                                    }
                                                el+="</td>"+
                                                "<td>";
                                                    if(sumgrowth>0){
                                                        el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+Math.round(sumgrowth)+" % </a>";
                                                    }else{
                                                        if(!isNaN(sumgrowth)){
                                                            el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+Math.round(sumgrowth)+" % </a>";
                                                        }else{
                                                            el+="-";
                                                        }
                                                    }
                                                el+="</td>";
                                            })
                                        }else{
                                            el+="<td></td>"+
                                            "<td></td>"+
                                            "<td></td>"+
                                            "<td></td>"+
                                            "<td></td>"+
                                            "<td></td>"+
                                            "<td></td>"+
                                            "<td></td>"+
                                            "<td></td>";
                                        }
                                    el+="</tr>";
                                })                        
                            el+='</tbody>'+
                            //'<tfoot>'+
                            //    "<tr>"+
                                //    '<th style="background:#419F51;color:white" class="align-middle text-white">Nilai Rata - Rata</th>'+
                                //    "<th></th>"+
                                //    "<th></th>"+
                                //    "<th></th>"+
                                //    "<th></th>"+
                                //    "<th></th>"+
                                //    "<th></th>"+
                                //    "<th></th>"+
                                //    "<th></th>"+
                                //    "<th></th>"+
                            //"</tfoot>"+
                        '</table>';

                        $("#divofficialAccountAllTv").empty().html(el);
                    },
                    error:function(){

                    }
                })
            }

            function sosmedOfficialAndProgram(){
                var el="";
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/sosmed-official-and-program')}}",
                    type:"GET",
                    beforeSend:function(){
                        $("#sosmedOfficialAndProgram").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                    },
                    success:function(result){
                        el+="<table class='table table-striped'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th rowspan='2'>Channel</th>"+
                                    "<th>Twitter</th>"+
                                    "<th>Facebook</th>"+
                                    "<th>Instagram</th>"+
                                "</tr>"+
                                "<tr>"+
                                    "<th>"+result.tanggal+"</th>"+
                                    "<th>"+result.tanggal+"</th>"+
                                    "<th>"+result.tanggal+"</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody>";
                                $.each(result.group,function(a,b){
                                    for(a=0;a<result.sum.length;a++){
                                        
                                        if(result.sum[a].group_unit_id==b.id){
                                            el+="<tr>"+
                                            "<td>"+result.sum[a].unit_name+"</td>"+
                                            "<td>"+result.sum[a].twitter+"</td>"+
                                            "<td>"+result.sum[a].facebook+"</td>"+
                                            "<td>"+result.sum[a].instagram+"</td>"+
                                            "</tr>";
                                        }
                                    }
                                    el+="<tr>"+
                                        "<td>"+b.group_name+"</td>"+
                                        "<td></td>"+
                                        "<td></td>"+
                                        "<td></td>"+
                                    "</tr>";
                                })
                            "</tbody>"+
                        "</table>";

                        $("#sosmedOfficialAndProgram").empty().html(el);
                    },
                    error:function(){

                    }
                })
            }

            $(document).on("submit","#formTargetAchievement",function(e){
                targetVsAchievement();
            });

            $(document).on("submit","#formofficialAccountAllTv",function(e){
                var group=$("#group2 option:selected").val();
                var tanggal=$("#tanggal2").val();

                var el="";
                if($("#formofficialAccountAllTv")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url:"{{URL::to('sosmed/data/report/official-account-all-tv')}}",
                        type:"GET",
                        data:"group="+group+"&tanggal="+tanggal,
                        beforeSend:function(){
                            $("#divofficialAccountAllTv").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                        },
                        success:function(result){
                            el+='<table class="table table-striped table-bordered">'+
                                '<thead>'+
                                    '<tr>'+
                                        '<th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">Channel</th>';
                                        $.each(result.sosmed,function(a,b){
                                            el+="<th colspan='3' class='text-center' class='text-center' style='background:"+result.header[a]+";color:white'>"+b.sosmed_name+"</th>";
                                        })
                                    el+='</tr>'+
                                    '<tr>';
                                        $.each(result.sosmed,function(a,b){
                                            el+="<th class='text-center' class='text-center' style='background:"+result.header[a]+";color:white'>"+result.kemarin+"</th>"+
                                            "<th class='text-center' class='text-center' style='background:"+result.header[a]+";color:white'>"+result.sekarang+"</th>"+
                                            "<th class='text-center' class='text-center' style='background:"+result.header[a]+";color:white'>GROWTH FROM YESTERDAY</th>";
                                        })
                                    el+='</tr>'+
                                '</thead>'+
                                '<tbody style="color:#222">';
                                    $.each(result.unit,function(a,b){
                                        $.each(b.unit,function(c,d){
                                            el+="<tr>"+
                                                "<td>"+d.unit_name+"</td>";
                                                if(d.sosmed.length>0){
                                                    $.each(d.sosmed,function(e,f){
                                                        if(f.followers.length>0){
                                                            var sekarang=0;
                                                            var kemarin=0;
                                                            var growth=0;

                                                            for(a=0;a<f.followers.length;a++){
                                                                if(f.followers[a].tanggal==result.sekarang){
                                                                    sekarang=f.followers[a].follower;
                                                                }else if(f.followers[a].tanggal=result.kemarin){
                                                                    kemarin=f.followers[a].follower;
                                                                }
                                                            }

                                                            growth=sekarang/kemarin-1;

                                                            el+="<td>"+kemarin+"</td>"+
                                                                "<td>"+sekarang+"</td>"+
                                                                "<td>";
                                                                if(growth>0){
                                                                    el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+Math.round(growth)+" % </a>";
                                                                }else{
                                                                    if(!isNaN(growth)){
                                                                        el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+Math.round(growth)+" % </a>";
                                                                    }else{
                                                                        el+="-";
                                                                    }
                                                                }
                                                                el+="</td>";
                                                        }else{
                                                            el+="<td>-</td>"+
                                                                "<td>-</td>"+
                                                                "<td>-</td>";
                                                        }
                                                    })
                                                }else{
                                                    el+="<td>-</td>"+
                                                    "<td>-</td>"+
                                                    "<td>-</td>"+
                                                    "<td>-</td>"+
                                                    "<td>-</td>"+
                                                    "<td>-</td>"+
                                                    "<td>-</td>"+
                                                    "<td>-</td>"+
                                                    "<td>-</td>";
                                                }
                                            el+="</tr>";
                                        })
                                        el+="<tr style='background:#f2eff2;color:#222;font-weight:700'>"+
                                            "<td>"+b.group_name+"</td>";
                                            if(result.summary.length>0){
                                                $.each(result.sosmed,function(f,g){
                                                    var sumsekarang=0;
                                                    var sumkemarin=0;
                                                    var sumgrowth=0;
                                                    for(j=0;j<result.summary.length;j++){
                                                        if(result.summary[j].group_id==b.id && result.summary[j].tanggal==result.sekarang && result.summary[j].sos_id==g.id){
                                                            sumsekarang=result.summary[j].jumlah;
                                                        }

                                                        if(result.summary[j].group_id==b.id && result.summary[j].tanggal==result.kemarin && result.summary[j].sos_id==g.id){
                                                            sumkemarin=result.summary[j].jumlah;
                                                        }
                                                    }
                                                    sumgrowth=sumsekarang/sumkemarin-1;

                                                    el+="<td>";
                                                        if(sumkemarin>0){
                                                            el+=sumkemarin;
                                                        }else{
                                                            el+="-";
                                                        }
                                                    el+="</td>"+
                                                    "<td>";
                                                        if(sumsekarang>0){
                                                            el+=sumsekarang;
                                                        }else{
                                                            el+="-";
                                                        }
                                                    el+="</td>"+
                                                    "<td>";
                                                        if(sumgrowth>0){
                                                            el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+Math.round(sumgrowth)+" % </a>";
                                                        }else{
                                                            if(!isNaN(sumgrowth)){
                                                                el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+Math.round(sumgrowth)+" % </a>";
                                                            }else{
                                                                el+="-";
                                                            }
                                                        }
                                                    el+="</td>";
                                                })
                                            }else{
                                                el+="<td></td>"+
                                                "<td></td>"+
                                                "<td></td>"+
                                                "<td></td>"+
                                                "<td></td>"+
                                                "<td></td>"+
                                                "<td></td>"+
                                                "<td></td>"+
                                                "<td></td>";
                                            }
                                        el+="</tr>";
                                    })                        
                                el+='</tbody>'+
                            '</table>';

                            $("#divofficialAccountAllTv").empty().html(el);
                        },
                        error:function(){

                        }
                    })
                }else console.log("invalid form");
            })

            targetVsAchievement();
            officialAccountAllTv();
            sosmedOfficialAndProgram();
        })
    </script>
@endpush
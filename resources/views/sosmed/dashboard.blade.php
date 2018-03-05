@extends('layouts.sosmed')

@section('title')
    Dashboard
@endsection

@section('extra-style')

@endsection

@section('content')
<div class="container-fluid">
    <!-- OVERVIEW -->
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title text-center">SUMMARY</h3>
        </div>
        <div class="panel-body">
            <div class="tabbable">
                <ul class="nav nav-tabs nav-tabs-highlight">
                    <li class="active"><a href="#highlight-tab1" data-toggle="tab">TARGET VS ACHIEVEMENT</a></li>
                    <li><a href="#highlighted-tab2" data-toggle="tab">OFFICIAL ACCOUNT ALL TV</a></li>
                    <li><a href="#highlighted-tab3" data-toggle="tab">SOSMED OFFICIAL AND PROGRAM</a></li>
                    <li><a href="#highlighted-tab4" data-toggle="tab">OFFICIAL AND PROGRAM</a></li>
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
                        <form id="formsosmedOfficialAndProgram" onsubmit="return false">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Group</label>
                                        <select name="form-control" id="group3" name="group" class="form-control">
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
                                            <input type="text" name="tanggal" id="tanggal3" class="form-control daterange-single">
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
                            <div id="sosmedOfficialAndProgram"></div>
                        </div>
                    </div>

                    <div class="tab-pane" id="highlighted-tab4">
                        <form id="formofficialAndProgram" onsubmit="return false">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Group</label>
                                        <select name="form-control" id="group4" name="group" class="form-control">
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
                                            <input type="text" name="tanggal" id="tanggal4" class="form-control daterange-single">
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
                            <div id="officialAndProgram"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END OVERVIEW -->

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title text-center">RANGKING</h6>
        </div>
        <div class="panel-body">
            <form id="formRangking" onsubmit="return false">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">Periode</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icon-calendar5"></i></span>
                                <input type="text" name="tanggal" id="tanggal5" class="form-control daterange-single">
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
        </div>

        <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">1. RANK OF OFFICIAL ACCOUNT ALL GROUP <span style="color:red">BY TOTAL FOLLOWERS</span></h6>
                </div>

                <div class="panel-body">
                    <div id="rangAllAccountGroup"></div>
                </div>
            </div>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">2. RANK OF OFFICIAL ACCOUNT ALL TV <span style="color:red">BY TOTAL FOLLOWERS</span></h6>
                </div>

                <div class="panel-body">
                    <div id="rangAllAccountTv"></div>
                </div>
            </div>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">3. RANK OF GROWTH FROM YESTERDAY OFFICIAL ACCOUNT <span style="color:red">ALL TV BY % GROWTH</span></h6>
                </div>

                <div class="panel-body">
                    <div id="growthAllAccountTv"></div>
                </div>
            </div>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">4. RANK OF GROWTH FROM YESTERDAY OFFICIAL ACCOUNT <span style="color:red"> ALL GROUP BY % GROWTH</span></h6>
                </div>

                <div class="panel-body">
                    <div id="growthAllGrowthTv"></div>
                </div>
            </div>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">5. RANK OF OVERALL ACCOUNT <span style="color:red"> ALL BY TV % FOLLOWERS</span></h6>
                </div>

                <div class="panel-body">
                    <div id="rankOfOverallAccountAllTv"></div>
                </div>
            </div>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">6. RANK OF OVERALL ACCOUNT <span style="color:red"> ALL GROUP TOTAL FOLLOWERS</span></h6>
                </div>

                <div class="panel-body">
                    <div id="rankOfOverallGroup"></div>
                </div>
            </div>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">7. RANK OF OVERALL ACCOUNT <span style="color:red"> ALL TV BY % GROWTH FROM YESTERDAY</span></h6>
                </div>

                <div class="panel-body">
                    <div id="rankOfOverallAccountByFollower"></div>
                </div>
            </div>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">8. RANK OF OVERALL ACCOUNT <span style="color:red"> AS GROUP BY % GROWTH FROM YESTERDAY</span></h6>
                </div>

                <div class="panel-body">
                    <div id="rankOfOverallAsGroup"></div>
                </div>
            </div>
    </div>
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

            function addKoma(nStr)
            {
                nStr += '';
                x = nStr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            }

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
                                                        el+=addKoma(d.followers[0].follower);
                                                        tanggal=d.followers[0].follower;
                                                    }else{
                                                        el+="-";
                                                    }
                                                el+="</td>"+
                                                "<td class='text-center'>";
                                                    if(d.target!=null){
                                                        el+=addKoma(d.target.target);
                                                        target=d.target.target;
                                                    }else{
                                                        el+="-";
                                                    }
                                                el+="</td>"+
                                                "<td class='text-center'>";
                                                    if(d.followers.length>0){
                                                        el+=(tanggal/target*100).toFixed(2)+" %";
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
                                                    el+="<td>"+addKoma(f.followers.kemarin)+"</td>"+
                                                        "<td>"+addKoma(f.followers.sekarang)+"</td>"+
                                                        "<td>";
                                                            if(f.followers.growth>0){
                                                                el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+f.followers.growth+" % </a>";
                                                            }else{
                                                                if(!isNaN(f.followers.growth)){
                                                                    el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+f.followers.growth.toFixed(2)+" % </a>";
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
                                    });

                                    el+="<tr style='background:#f2eff2;color:#222;font-weight:700'>"+
                                        "<td>"+b.group_name+"</td>"
                                        for(c=0;c<result.summary.length;c++){
                                            if(result.summary[c].id==b.id){
                                                el+="<td>"+addKoma(result.summary[c].kemarin_twitter)+"</td>"+
                                                    "<td>"+addKoma(result.summary[c].sekarang_twitter)+"</td>"+
                                                    "<td>";
                                                        var ghtwitter=result.summary[c].sekarang_twitter/result.summary[c].kemarin_twitter-1;
                                                        if(ghtwitter>0){
                                                            el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+ghtwitter+" % </a>";
                                                        }else{
                                                            if(!isNaN(ghtwitter)){
                                                                el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+ghtwitter.toFixed(2)+" % </a>";
                                                            }else{
                                                                el+="-";
                                                            }
                                                        }
                                                    el+="</td>"+
                                                    "<td>"+addKoma(result.summary[c].kemarin_facebook)+"</td>"+
                                                    "<td>"+addKoma(result.summary[c].sekarang_facebook)+"</td>"+
                                                    "<td>";
                                                        var ghfacebook=result.summary[c].sekarang_facebook/result.summary[c].kemarin_facebook-1;
                                                        if(ghfacebook>0){
                                                            el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+ghfacebook+" % </a>";
                                                        }else{
                                                            if(!isNaN(ghfacebook)){
                                                                el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+ghfacebook.toFixed(2)+" % </a>";
                                                            }else{
                                                                el+="-";
                                                            }
                                                        }
                                                    el+="</td>"+
                                                    "<td>"+addKoma(result.summary[c].kemarin_instagram)+"</td>"+
                                                    "<td>"+addKoma(result.summary[c].sekarang_instagram)+"</td>"+
                                                    "<td>";
                                                        var ghinstagram=result.summary[c].sekarang_instagram/result.summary[c].kemarin_instagram-1;
                                                        if(ghinstagram>0){
                                                            el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+ghinstagram+" % </a>";
                                                        }else{
                                                            if(!isNaN(ghinstagram)){
                                                                el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+ghinstagram.toFixed(2)+" % </a>";
                                                            }else{
                                                                el+="-";
                                                            }
                                                        }
                                                    el+="</td>";
                                            }
                                        }
                                    "</tr>";
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
                                    '<th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">Channel</th>'+
                                    "<th class='text-center' style='background:#008ef6;color:white'>Twitter</th>"+
                                    "<th style='background:#5054ab;color:white'>Facebook</th>"+
                                    "<th style='background:#a200b2;color:white'>Instagram</th>"+
                                "</tr>"+
                                "<tr>"+
                                    "<th class='text-center' style='background:#008ef6;color:white'>"+result.tanggal+"</th>"+
                                    "<th style='background:#5054ab;color:white'>"+result.tanggal+"</th>"+
                                    "<th style='background:#a200b2;color:white'>"+result.tanggal+"</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody style='color:#222'>";
                                $.each(result.data,function(a,b){
                                    $.each(b.unit,function(c,d){
                                        el+="<tr>"+
                                            "<td>"+d.unit_name+"</td>"+
                                            "<td>"+addKoma(d.total.tw)+"</td>"+
                                            "<td>"+addKoma(d.total.fb)+"</td>"+
                                            "<td>"+addKoma(d.total.ig)+"</td>"+
                                        "</tr>";
                                    });

                                    el+="<tr style='background:#f2eff2;color:#222;font-weight:700'>"+
                                        "<td>"+addKoma(b.group_name)+"</td>"+
                                        "<td>"+addKoma(b.total.tw)+"</td>"+
                                        "<td>"+addKoma(b.total.fb)+"</td>"+
                                        "<td>"+addKoma(b.total.ig)+"</td>"+
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

            function officialAndProgram(){
                var group=$("#group4 option:selected").val();
                var tanggal=$("#tanggal4").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/official-and-program')}}",
                    type:"GET",
                    data:"group="+group+"&tanggal="+tanggal,
                    beforeSend:function(){
                        $("#officialAndProgram").empty().html("<div class='alert alert-info'>Please Wait . . . </div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<table class='table table-striped table-bordered'>"+
                            "<thead>"+
                                "<tr>"+ 
                                    '<th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">General Name</th>'+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>Twitter</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>Facebook</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>Instagram</th>"+
                                "</tr>"+
                            "</thead>"+
                            '<tbody style="color:#222">';
                                $.each(result.unit,function(a,b){
                                    /* official */
                                    el+="<tr>"+
                                        "<td>"+b.unit_name+" Official</td>";
                                        if(b.sosmed.length>0){
                                            $.each(b.sosmed,function(c,d){
                                                if(d.followers.length>0){
                                                    el+="<td>"+addKoma(d.followers[0].follower)+"</td>";
                                                }else{
                                                    el+="<td>-</td>";
                                                }
                                            })
                                        }else{
                                            el+="<td>-</td>"+
                                            "<td>-</td>"+
                                            "<td>-</td>";
                                        }
                                    el+="</tr>";

                                    if(b.program.length>0){
                                        $.each(b.program,function(e,f){
                                            el+="<tr>"+
                                                "<td>"+f.program_name+"</td>";
                                                if(f.sosmed.length>0){
                                                    $.each(f.sosmed,function(g,h){
                                                        if(h.followers.length>0){
                                                            el+="<td>"+addKoma(h.followers[0].follower)+"</td>";
                                                        }else{
                                                            el+="<td>-</td>";
                                                        }
                                                    })
                                                }else{
                                                    el+="<td></td>"+
                                                    "<td></td>"+
                                                    "<td></td>";
                                                }
                                        })
                                    }
                                            
                                    el+="<tr style='background:#f2eff2;color:#222;font-weight:700'>"+
                                        "<td>Total</td>";
                                        for(z=0;z<result.summary.length>0;z++){
                                            if(result.summary[z].id==b.id){
                                                el+="<td>"+addKoma(result.summary[z].total_twitter)+"</td>"+
                                                "<td>"+addKoma(result.summary[z].total_fb)+"</td>"+
                                                "<td>"+addKoma(result.summary[z].total_ig)+"</td>";
                                            }
                                        }
                                })
                            el+="</tbody>"+
                        "</table>";

                        $("#officialAndProgram").empty().html(el);

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
                                                    el+="<td>"+addKoma(f.followers.kemarin)+"</td>"+
                                                        "<td>"+addKoma(f.followers.sekarang)+"</td>"+
                                                        "<td>";
                                                            if(f.followers.growth>0){
                                                                el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+f.followers.growth.toFixed(2)+" % </a>";
                                                            }else{
                                                                if(!isNaN(f.followers.growth)){
                                                                    el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+f.followers.growth.toFixed(2)+" % </a>";
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
                                    });

                                    el+="<tr style='background:#f2eff2;color:#222;font-weight:700'>"+
                                        "<td>"+b.group_name+"</td>"
                                        for(c=0;c<result.summary.length;c++){
                                            if(result.summary[c].id==b.id){
                                                el+="<td>"+addKoma(result.summary[c].kemarin_twitter)+"</td>"+
                                                    "<td>"+addKoma(result.summary[c].sekarang_twitter)+"</td>"+
                                                    "<td>";
                                                        var ghtwitter=result.summary[c].sekarang_twitter/result.summary[c].kemarin_twitter-1;
                                                        if(ghtwitter>0){
                                                            el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+ghtwitter.toFixed(2)+" % </a>";
                                                        }else{
                                                            if(!isNaN(ghtwitter)){
                                                                el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+ghtwitter.toFixed(2)+" % </a>";
                                                            }else{
                                                                el+="-";
                                                            }
                                                        }
                                                    el+="</td>"+
                                                    "<td>"+addKoma(result.summary[c].kemarin_facebook)+"</td>"+
                                                    "<td>"+addKoma(result.summary[c].sekarang_facebook)+"</td>"+
                                                    "<td>";
                                                        var ghfacebook=result.summary[c].sekarang_facebook/result.summary[c].kemarin_facebook-1;
                                                        if(ghfacebook>0){
                                                            el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+ghfacebook.toFixed(2)+" % </a>";
                                                        }else{
                                                            if(!isNaN(ghfacebook)){
                                                                el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+ghfacebook.toFixed(2)+" % </a>";
                                                            }else{
                                                                el+="-";
                                                            }
                                                        }
                                                    el+="</td>"+
                                                    "<td>"+addKoma(result.summary[c].kemarin_instagram)+"</td>"+
                                                    "<td>"+addKoma(result.summary[c].sekarang_instagram)+"</td>"+
                                                    "<td>";
                                                        var ghinstagram=result.summary[c].sekarang_instagram/result.summary[c].kemarin_instagram-1;
                                                        if(ghinstagram>0){
                                                            el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+ghinstagram.toFixed(2)+" % </a>";
                                                        }else{
                                                            if(!isNaN(ghinstagram)){
                                                                el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+ghinstagram.toFixed(2)+" % </a>";
                                                            }else{
                                                                el+="-";
                                                            }
                                                        }
                                                    el+="</td>";
                                            }
                                        }
                                    "</tr>";
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
                }else console.log("invalid form");
            })

            $(document).on("submit","#formsosmedOfficialAndProgram",function(e){
                var group=$("#group3 option:selected").val();
                var tanggal=$("#tanggal3").val();

                var el="";
                if($("#formsosmedOfficialAndProgram")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url:"{{URL::to('sosmed/data/report/sosmed-official-and-program')}}",
                        type:"GET",
                        data:"group="+group+"&tanggal="+tanggal,
                        beforeSend:function(){
                            $("#sosmedOfficialAndProgram").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                        },
                        success:function(result){
                            el+="<table class='table table-striped'>"+
                                "<thead>"+
                                    "<tr>"+
                                        '<th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">Channel</th>'+
                                        "<th class='text-center' style='background:#008ef6;color:white'>Twitter</th>"+
                                        "<th style='background:#5054ab;color:white'>Facebook</th>"+
                                        "<th style='background:#a200b2;color:white'>Instagram</th>"+
                                    "</tr>"+
                                    "<tr>"+
                                        "<th class='text-center' style='background:#008ef6;color:white'>"+result.tanggal+"</th>"+
                                        "<th style='background:#5054ab;color:white'>"+result.tanggal+"</th>"+
                                        "<th style='background:#a200b2;color:white'>"+result.tanggal+"</th>"+
                                    "</tr>"+
                                "</thead>"+
                                "<tbody style='color:#222'>";
                                    $.each(result.data,function(a,b){
                                        $.each(b.unit,function(c,d){
                                            el+="<tr>"+
                                                "<td>"+d.unit_name+"</td>"+
                                                "<td>"+addKoma(d.total.tw)+"</td>"+
                                                "<td>"+addKoma(d.total.fb)+"</td>"+
                                                "<td>"+addKoma(d.total.ig)+"</td>"+
                                            "</tr>";
                                        });

                                        el+="<tr style='background:#f2eff2;color:#222;font-weight:700'>"+
                                            "<td>"+b.group_name+"</td>"+
                                            "<td>"+addKoma(b.total.tw)+"</td>"+
                                            "<td>"+addKoma(b.total.fb)+"</td>"+
                                            "<td>"+addKoma(b.total.ig)+"</td>"+
                                        "</tr>";
                                    })
                                "</tbody>"+
                            "</table>";

                            $("#sosmedOfficialAndProgram").empty().html(el);
                        },
                        error:function(){

                        }
                    })
                }else console.log("invalid form");
            })

            $(document).on("submit","#formofficialAndProgram",function(e){
                officialAndProgram();
            });


            /* rangking */
            function rangAllAccountGroup(){
                var tanggal=$("#tanggal5").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/rank-of-official-account-all-group')}}",
                    type:"GET",
                    data:"tanggal="+tanggal,
                    beforeSend:function(){
                        $("#rangAllAccountGroup").empty().html("<div class='alert alert-info'>Please Wait . . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<table class='table table-striped'>"+
                            "<thead>"+
                                "<tr>"+
                                    '<th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">CHANNEL</th>'+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#008ef6;color:white'>TWITTER</th>"+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#5054ab;color:white'>FACEBOOK</th>"+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#a200b2;color:white'>INSTAGRAM</th>"+
                                "</tr>"+
                                "<tr>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>% Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>TOTAL</th>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>RANK</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>% Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>TOTAL</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>RANK</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>% Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>TOTAL</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>RANK</th>"+
                                "</tr>"+
                            "</thead>"+
                            '<tbody style="color:#222">';
                                $.each(result,function(a,b){
                                    el+="<tr>"+
                                        "<td>"+b.group_name+"</td>"+
                                        "<td>"+b.follower.growth_twitter+"</td>"+
                                        "<td>"+addKoma(b.follower.tw_sekarang)+"</td>"+
                                        "<td>"+b.follower.rank_tw+"</td>"+
                                        "<td>"+b.follower.growth_fb+"</td>"+
                                        "<td>"+addKoma(b.follower.fb_sekarang)+"</td>"+
                                        "<td>"+b.follower.rank_fb+"</td>"+
                                        "<td>"+b.follower.growth_ig+"</td>"+
                                        "<td>"+addKoma(b.follower.ig_sekarang)+"</td>"+
                                        "<td>"+b.follower.rank_ig+"</td>"+
                                    "</tr>";
                                })
                            el+="</tbody>"+
                        "</table>";
                        $("#rangAllAccountGroup").empty().html(el);
                    },
                    error:function(){

                    }
                })
            }

            function rangAllAccountTv(){
                var tanggal=$("#tanggal5").val();
                
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/rank-of-official-account-all-tv')}}",
                    type:"GET",
                    data:"tanggal="+tanggal,
                    beforeSend:function(){
                        $("#rangAllAccountTv").empty().html("<div class='alert alert-info'>Please Wait . . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<table class='table table-striped'>"+
                            "<thead>"+
                                "<tr>"+
                                    '<th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">CHANNEL</th>'+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#008ef6;color:white'>TWITTER</th>"+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#5054ab;color:white'>FACEBOOK</th>"+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#a200b2;color:white'>INSTAGRAM</th>"+
                                "</tr>"+
                                "<tr>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>% Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>TOTAL</th>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>RANK</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>% Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>TOTAL</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>RANK</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>% Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>TOTAL</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>RANK</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody style='color:#222'>";
                                $.each(result,function(a,b){
                                    el+="<tr>"+
                                        "<td>"+b.unit_name+"</td>"+
                                        "<td>"+b.follower.growth_twitter+"</td>"+
                                        "<td>"+addKoma(b.follower.tw_sekarang)+"</td>"+
                                        "<td>"+b.follower.rank_tw+"</td>"+
                                        "<td>"+b.follower.growth_fb+"</td>"+
                                        "<td>"+addKoma(b.follower.fb_sekarang)+"</td>"+
                                        "<td>"+b.follower.rank_fb+"</td>"+
                                        "<td>"+b.follower.growth_ig+"</td>"+
                                        "<td>"+addKoma(b.follower.ig_sekarang)+"</td>"+
                                        "<td>"+b.follower.rank_ig+"</td>"+
                                    "</tr>";
                                })
                            el+="</tbody>"+
                        "</table>";
                        $("#rangAllAccountTv").empty().html(el);
                    },
                    error:function(){

                    }
                })
            }

            function growthAllAccountTv(){
                var tanggal=$("#tanggal5").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/rank-growth-from-yesterday-official-account-all-tv')}}",
                    type:"GET",
                    data:"tanggal="+tanggal,
                    beforeSend:function(){
                        $("#growthAllAccountTv").empty().html("<div class='alert alert-info'>Please Wait . . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<table class='table table-striped'>"+
                            "<thead>"+
                                "<tr>"+
                                    '<th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">CHANNEL</th>'+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#008ef6;color:white'>TWITTER</th>"+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#5054ab;color:white'>FACEBOOK</th>"+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#a200b2;color:white'>INSTAGRAM</th>"+
                                "</tr>"+
                                "<tr>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>Num Of Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>% Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>RANK</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>Num Of Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>% Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>RANK</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>Num Of Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>% Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>RANK</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody style='color:#222'>";
                                $.each(result,function(a,b){
                                    el+="<tr>"+
                                        "<td>"+b.unit_name+"</td>"+
                                        "<td>"+b.follower.num_of_twitter+"</td>"+
                                        "<td>"+b.follower.growth_twitter+"</td>"+
                                        "<td>"+b.follower.rank_tw+"</td>"+
                                        "<td>"+b.follower.num_of_fb+"</td>"+
                                        "<td>"+b.follower.growth_fb+"</td>"+
                                        "<td>"+b.follower.rank_fb+"</td>"+
                                        "<td>"+b.follower.num_of_ig+"</td>"+
                                        "<td>"+b.follower.growth_ig+"</td>"+
                                        "<td>"+b.follower.rank_ig+"</td>"+
                                    "</tr>";
                                })
                            el+="</tbody>"+
                        "</table>";
                        $("#growthAllAccountTv").empty().html(el);
                    },
                    error:function(){

                    }
                })
            }

            function growthAllGroupTv(){
                var tanggal=$("#tanggal5").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/rank-growth-from-yesterday-official-group')}}",
                    type:"GET",
                    data:"tanggal="+tanggal,
                    beforeSend:function(){
                        $("#growthAllGrowthTv").empty().html("<div class='alert alert-info'>Please Wait. . . </div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<table class='table table-striped'>"+
                            "<thead>"+
                                "<tr>"+
                                    '<th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">CHANNEL</th>'+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#008ef6;color:white'>TWITTER</th>"+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#5054ab;color:white'>FACEBOOK</th>"+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#a200b2;color:white'>INSTAGRAM</th>"+
                                "</tr>"+
                                "<tr>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>Num Of Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>% Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>RANK</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>Num Of Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>% Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>RANK</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>Num Of Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>% Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>RANK</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody style='color:#222'>";
                                $.each(result,function(a,b){
                                    el+="<tr>"+
                                        "<td>"+b.group_name+"</td>"+
                                        "<td>"+b.follower.num_of_tw+"</td>"+
                                        "<td>"+b.follower.growth_twitter+"</td>"+
                                        "<td>"+b.follower.rank_tw+"</td>"+
                                        "<td>"+b.follower.num_of_fb+"</td>"+
                                        "<td>"+b.follower.growth_fb+"</td>"+
                                        "<td>"+b.follower.rank_fb+"</td>"+
                                        "<td>"+b.follower.num_of_ig+"</td>"+
                                        "<td>"+b.follower.growth_ig+"</td>"+
                                        "<td>"+b.follower.rank_ig+"</td>"+
                                    "</tr>";
                                })
                            el+="</tbody>"+
                        "</table>";

                        $("#growthAllGrowthTv").empty().html(el);
                    },
                    error:function(){

                    }
                })
            }

            function rankOfOverallAccountAllTv(){
                var tanggal=$("#tanggal5").val();

                var el="";
                var ep="";

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/rank-overall-account-all-tv-by-total-followers')}}",
                    type:"GET",
                    data:"tanggal="+tanggal,
                    beforeSend:function(){
                        $("#rankOfOverallAccountAllTv").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        el+="<table class='table table-striped'>"+
                            "<thead>"+
                                "<tr>"+
                                    '<th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">CHANNEL</th>'+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#008ef6;color:white'>TWITTER</th>"+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#5054ab;color:white'>FACEBOOK</th>"+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#a200b2;color:white'>INSTAGRAM</th>"+
                                "</tr>"+
                                "<tr>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>% Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>TOTAL</th>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>RANK</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>% Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>TOTAL</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>RANK</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>% Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>TOTAL</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>RANK</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody style='color:#222'>";
                                $.each(result,function(a,b){
                                    el+="<tr>"+
                                        "<td>"+b.unit_name+"</td>"+
                                        "<td>";
                                            if(b.followers.tw.growth!=null){
                                                el+=b.followers.tw.growth;
                                            }else{
                                                el+=0;
                                            }
                                        el+="</td>"+
                                        "<td>"+addKoma(b.followers.tw.total)+"</td>"+
                                        "<td>"+b.followers.tw.rank+"</td>"+
                                        "<td>";
                                            if(b.followers.fb.growth!=null){
                                                el+=b.followers.fb.growth;
                                            }else{
                                                el+=0;
                                            }
                                        el+="</td>"+
                                        "<td>"+addKoma(b.followers.fb.total)+"</td>"+
                                        "<td>"+b.followers.fb.rank+"</td>"+
                                        "<td>";
                                            if(b.followers.ig.growth!=null){
                                                el+=b.followers.ig.growth;
                                            }else{
                                                el+=0;
                                            }
                                        el+="</td>"+
                                        "<td>"+addKoma(b.followers.ig.total)+"</td>"+
                                        "<td>"+b.followers.ig.rank+"</td>"+
                                    "</tr>";
                                })
                            el+="</tbody>"+
                        "</table>";
                        $("#rankOfOverallAccountAllTv").empty().html(el);

                        ep+="<table class='table table-striped'>"+
                            "<thead>"+
                                "<tr>"+
                                    '<th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">CHANNEL</th>'+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#008ef6;color:white'>TWITTER</th>"+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#5054ab;color:white'>FACEBOOK</th>"+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#a200b2;color:white'>INSTAGRAM</th>"+
                                "</tr>"+
                                "<tr>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>% Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>TOTAL</th>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>RANK</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>% Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>TOTAL</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>RANK</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>% Growth</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>TOTAL</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>RANK</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody style='color:#222'>";
                                $.each(result,function(a,b){
                                    ep+="<tr>"+
                                        "<td>"+b.unit_name+"</td>"+
                                        "<td>"+b.followers.tw.num_of_growth+"</td>"+
                                        "<td>";
                                            if(b.followers.tw.growth!=null){
                                                ep+=b.followers.tw.growth;
                                            }else{
                                                ep+=0;
                                            }
                                        ep+="</td>"+
                                        "<td>"+b.followers.tw.rank+"</td>"+
                                        "<td>"+b.followers.fb.num_of_growth+"</td>"+
                                        "<td>";
                                            if(b.followers.fb.growth!=null){
                                                ep+=b.followers.fb.growth;
                                            }else{
                                                ep+=0;
                                            }
                                        ep+="</td>"+
                                        "<td>"+b.followers.fb.rank+"</td>"+
                                        "<td>"+b.followers.ig.num_of_growth+"</td>"+
                                        "<td>";
                                            if(b.followers.ig.growth!=null){
                                                ep+=b.followers.ig.growth;
                                            }else{
                                                ep+=0;
                                            }
                                        ep+="</td>"+
                                        "<td>"+b.followers.ig.rank+"</td>"+
                                    "</tr>";
                                })
                            ep+="</tbody>"+
                        "</table>";
                        $("#rankOfOverallAccountByFollower").empty().html(ep);
                    },
                    error:function(){

                    }
                })
            }

            function rankOfOverallGroup(){
                var tanggal=$("#tanggal5").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/rank-of-overall-all-group-by-followers')}}",
                    type:"GET",
                    data:"tanggal="+tanggal,
                    beforeSend:function(){
                        $("#rankOfOverallGroup").empty().html("<div class='alert alert-info'>Please Wait. . . </div>");
                    },
                    success:function(result){
                        var el="";
                        var ep="";
                        el+="<table class='table table-striped'>"+
                            "<thead>"+
                                "<tr>"+
                                    '<th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">CHANNEL</th>'+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#008ef6;color:white'>TWITTER</th>"+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#5054ab;color:white'>FACEBOOK</th>"+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#a200b2;color:white'>INSTAGRAM</th>"+
                                "</tr>"+
                                "<tr>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>GROWTH</th>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>TOTAL</th>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>RANK</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>GROWTH</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>TOTAL</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>RANK</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>GROWTH</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>TOTAL</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>RANK</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody style='color:#222'>";
                                $.each(result,function(a,b){
                                    el+="<tr>"+
                                        "<td>"+b.group_name+"</td>"+
                                        "<td>";
                                            if(b.followers.tw.growth!=null){
                                                el+=b.followers.tw.growth;
                                            }else{
                                                el+=0;
                                            }
                                        el+="</td>"+
                                        "<td>"+addKoma(b.followers.tw.total)+"</td>"+
                                        "<td>"+b.followers.tw.rank+"</td>"+
                                        "<td>";
                                            if(b.followers.fb.growth!=null){
                                                el+=b.followers.fb.growth;
                                            }else{
                                                el+=0;
                                            }
                                        el+="</td>"+
                                        "<td>"+addKoma(b.followers.fb.total)+"</td>"+
                                        "<td>"+b.followers.fb.rank+"</td>"+
                                        "<td>";
                                            if(b.followers.ig.growth!=null){
                                                el+=b.followers.ig.growth;
                                            }else{
                                                el+=0;
                                            }
                                        el+="</td>"+
                                        "<td>"+addKoma(b.followers.ig.total)+"</td>"+
                                        "<td>"+b.followers.ig.rank+"</td>"+
                                    "</tr>";
                                })
                            el+="</tbody>"+
                        "</table>";

                        $("#rankOfOverallGroup").empty().html(el);

                        ep+="<table class='table table-striped'>"+
                            "<thead>"+
                                "<tr>"+
                                    '<th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">CHANNEL</th>'+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#008ef6;color:white'>TWITTER</th>"+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#5054ab;color:white'>FACEBOOK</th>"+
                                    "<th colspan='3' class='text-center' class='text-center' style='background:#a200b2;color:white'>INSTAGRAM</th>"+
                                "</tr>"+
                                "<tr>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>GROWTH</th>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>TOTAL</th>"+
                                    "<th class='text-center' class='text-center' style='background:#008ef6;color:white'>RANK</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>GROWTH</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>TOTAL</th>"+
                                    "<th class='text-center' class='text-center' style='background:#5054ab;color:white'>RANK</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>GROWTH</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>TOTAL</th>"+
                                    "<th class='text-center' class='text-center' style='background:#a200b2;color:white'>RANK</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody style='color:#222'>";
                                $.each(result,function(a,b){
                                    ep+="<tr>"+
                                        "<td>"+b.group_name+"</td>"+
                                        "<td>"+b.followers.tw.num_of_growth+"</td>"+
                                        "<td>";
                                            if(b.followers.tw.growth!=null){
                                                ep+=b.followers.tw.growth;
                                            }else{
                                                ep+=0;
                                            }
                                        ep+="</td>"+
                                        "<td>"+b.followers.tw.rank+"</td>"+
                                        "<td>"+b.followers.fb.num_of_growth+"</td>"+
                                        "<td>";
                                            if(b.followers.fb.growth!=null){
                                                ep+=b.followers.fb.growth;
                                            }else{
                                                ep+=0;
                                            }
                                        ep+="</td>"+
                                        "<td>"+b.followers.fb.rank+"</td>"+
                                        "<td>"+b.followers.ig.num_of_growth+"</td>"+
                                        "<td>";
                                            if(b.followers.ig.growth!=null){
                                                ep+=b.followers.ig.growth;
                                            }else{
                                                ep+=0;
                                            }
                                        ep+="</td>"+
                                        "<td>"+b.followers.ig.rank+"</td>"+
                                    "</tr>";
                                })
                            ep+="</tbody>"+
                        "</table>";
                        
                        $("#rankOfOverallAsGroup").empty().html(ep);
                    },
                    error:function(){

                    }
                })
            }
            /* end rangking */

            $(document).on("submit","#formRangking",function(){
                rangAllAccountGroup();
                rangAllAccountTv();
                growthAllAccountTv();
                growthAllGroupTv();
                rankOfOverallAccountAllTv();
                rankOfOverallGroup();    
            })

            targetVsAchievement();
            officialAccountAllTv();
            sosmedOfficialAndProgram();
            officialAndProgram();

            /* ranking show */
            rangAllAccountGroup();
            rangAllAccountTv();
            growthAllAccountTv();
            growthAllGroupTv();
            rankOfOverallAccountAllTv();
            rankOfOverallGroup();
            /* end rangking show */
        })
    </script>
@endpush
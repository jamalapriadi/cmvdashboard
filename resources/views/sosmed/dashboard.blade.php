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
                    <li><a href="#highlighted-tab4" data-toggle="tab">DETAIL OFFICIAL AND PROGRAM</a></li>
                    
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
                                <!-- <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Group</label>
                                        <select name="form-control" id="group2" name="group" class="form-control">
                                            <option value="">--Select Group--</option>
                                            @foreach($group as $row)
                                                <option value="{{$row->id}}">{{$row->group_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> -->
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
                    <div class="table-responsive">
                        <div id="rangAllAccountGroup"></div>
                    </div>
                </div>
            </div>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">2. RANK OF OFFICIAL ACCOUNT ALL TV <span style="color:red">BY TOTAL FOLLOWERS</span></h6>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="rangAllAccountTv"></div>
                    </div>
                </div>
            </div>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">3. RANK OF GROWTH FROM YESTERDAY OFFICIAL ACCOUNT <span style="color:red">ALL TV BY % GROWTH</span></h6>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="growthAllAccountTv"></div>
                    </div>
                </div>
            </div>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">4. RANK OF GROWTH FROM YESTERDAY OFFICIAL ACCOUNT <span style="color:red"> ALL GROUP BY % GROWTH</span></h6>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="growthAllGrowthTv"></div>
                    </div>
                </div>
            </div>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">5. RANK OF OVERALL ACCOUNT <span style="color:red"> ALL BY TV % FOLLOWERS</span></h6>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="rankOfOverallAccountAllTv"></div>
                    </div>
                </div>
            </div>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">6. RANK OF OVERALL ACCOUNT <span style="color:red"> ALL GROUP TOTAL FOLLOWERS</span></h6>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="rankOfOverallGroup"></div>
                    </div>
                </div>
            </div>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">7. RANK OF OVERALL ACCOUNT <span style="color:red"> ALL TV BY % GROWTH FROM YESTERDAY</span></h6>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="rankOfOverallAccountByFollower"></div>
                    </div>
                </div>
            </div>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">8. RANK OF OVERALL ACCOUNT <span style="color:red"> AS GROUP BY % GROWTH FROM YESTERDAY</span></h6>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="rankOfOverallAsGroup"></div>
                    </div>
                </div>
            </div>

            <div style="background:red;height:10px;width:100%"></div>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">RANK OF OFFICIAL ACCOUNT  <span style="color:red"> AMONG 4TV BY TOTAL FOLLOWERS</span></h6>
                </div>

                <div class="panel-body">
                    <form id="formrankOfficialAccountAmong4Tv" onsubmit="return false">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label">Group</label>
                                    <select name="form-control" id="group6" name="group" class="form-control">
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
                                        <input type="text" name="tanggal" id="tanggal6" class="form-control daterange-single">
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
                        <div id="rankOfficialAccountAmong4Tv"></div>
                    </div>
                </div>
            </div>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">RANK OF GROWTH FROM YESTERDAY <span style="color:red"> OFFICIAL ACCOUNT AMONG 4 TV BY % GROWTH</span></h6>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="rankOfficialAccountAmong4TvFromYesterday"></div>
                    </div>
                </div>
            </div>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">RANK OF OVERALL ACCOUNT AMONG 4 TV <span style="color:red"> BY % GROWTH</span></h6>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="rankOverallAmong4Tv"></div>
                    </div>
                </div>
            </div>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title text-center">RANK OF OVERALL ACCOUNT AMONG 4 TV <span style="color:red"> BY % GROWTH FROM YESTERDAY</span></h6>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="rankOverallAmong4TvYesterday"></div>
                    </div>
                </div>
            </div>
    </div>
</div>

<div id="divModal"></div>
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
                                    '<th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">Channel</th>'+
                                    "<th colspan='3' class='text-center' style='background:#008ef6;color:white'>Twitter</th>"+
                                    "<th colspan='3' class='text-center' style='background:#5054ab;color:white'>Facebook</th>"+
                                    "<th colspan='3' class='text-center' style='background:#a200b2;color:white'>Instagram</th>"+
                                "</tr>"+
                                "<tr>"+
                                    "<th class='text-center' style='background:#008ef6;color:white'>"+result.sekarang+"</th>"+
                                    "<th class='text-center' style='background:#008ef6;color:white'>Target</th>"+
                                    "<th class='text-center' style='background:#008ef6;color:white'>ACH</th>"+

                                    "<th class='text-center' style='background:#5054ab;color:white'>"+result.sekarang+"</th>"+
                                    "<th class='text-center' style='background:#5054ab;color:white'>Target</th>"+
                                    "<th class='text-center' style='background:#5054ab;color:white'>ACH</th>"+

                                    "<th class='text-center' style='background:#a200b2;color:white'>"+result.sekarang+"</th>"+
                                    "<th class='text-center' style='background:#a200b2;color:white'>Target</th>"+
                                    "<th class='text-center' style='background:#a200b2;color:white'>ACH</th>"+
                                "</tr>"+
                            "</thead>"+
                            '<tbody style="color:#222">';
                                $.each(result.target,function(a,b){
                                    el+="<tr>"+
                                        "<td>"+b.unit_name+"</td>"+
                                        "<td>"+addKoma(b.follower_tw)+"</td>"+
                                        "<td>"+addKoma(b.target_tw)+"</td>"+
                                        "<td>"+b.acv_tw+" %</td>"+
                                        "<td>"+addKoma(b.follower_fb)+"</td>"+
                                        "<td>"+addKoma(b.target_fb)+"</td>"+
                                        "<td>"+b.acv_fb+" %</td>"+
                                        "<td>"+addKoma(b.follower_ig)+"</td>"+
                                        "<td>"+addKoma(b.target_ig)+"</td>"+
                                        "<td>"+b.acv_ig+" %</td>"+
                                    "</tr>";
                                })
                            el+="</tbody>"
                        "</table>";

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
                                    '<th width="18%" rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">Channel</th>'+
                                    "<th colspan='3' class='text-center' style='background:#008ef6;color:white'>Twitter</th>"+
                                    "<th colspan='3' class='text-center' style='background:#5054ab;color:white'>Facebook</th>"+
                                    "<th colspan='3' class='text-center' style='background:#a200b2;color:white'>Instagram</th>"+
                                '</tr>'+
                                '<tr>'+
                                    "<th class='text-center' style='background:#008ef6;color:white'>"+result.kemarin+"</th>"+
                                    "<th class='text-center' style='background:#008ef6;color:white'>"+result.sekarang+"</th>"+
                                    "<th class='text-center' style='background:#008ef6;color:white'>Growth From Yesterday</th>"+

                                    "<th class='text-center' style='background:#5054ab;color:white'>"+result.sekarang+"</th>"+
                                    "<th class='text-center' style='background:#5054ab;color:white'>"+result.sekarang+"</th>"+
                                    "<th class='text-center' style='background:#5054ab;color:white'>Growth From Yesterday</th>"+

                                    "<th class='text-center' style='background:#a200b2;color:white'>"+result.sekarang+"</th>"+
                                    "<th class='text-center' style='background:#a200b2;color:white'>"+result.sekarang+"</th>"+
                                    "<th class='text-center' style='background:#a200b2;color:white'>Growth From Yesterday</th>"+
                                "</tr>"+
                            "</thead>"+
                            '<tbody style="color:#222">';
                                $.each(result.unit,function(a,b){
                                    if(b.id=="SUBTOTAL"){
                                        if(b.group_id=="TOTAL"){
                                            var nama="NILAI RATA - RATA";
                                            var color="background:#419F51;color:white;font-weight:700";

                                            el+="<tr style='"+color+"'>"+
                                                '<td>'+nama+'</td>'+
                                                '<td></td>'+
                                                '<td>'+addKoma((b.tw_sekarang/13).toFixed())+'</td>'+
                                                '<td></td>'+
                                                '<td></td>'+
                                                '<td>'+addKoma((b.fb_sekarang/13).toFixed())+'</td>'+
                                                '<td></td>'+
                                                '<td></td>'+
                                                '<td>'+addKoma((b.ig_sekarang/13).toFixed())+'</td>'+
                                                '<td></td>'+
                                            '</tr>';
                                        }else{
                                            var nama=b.group_name;
                                            var color="background:#f2eff2;color:#222;font-weight:700";

                                            el+='<tr style="'+color+'">'+
                                                '<td>'+nama+'</td>'+
                                                '<td>'+addKoma(b.tw_kemarin)+'</td>'+
                                                '<td>'+addKoma(b.tw_sekarang)+'</td>'+
                                                '<td>';
                                                    if(b.growth_tw>0){
                                                        el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+b.growth_tw+" % </a>";
                                                    }else{
                                                        if(!isNaN(b.growth_tw)){
                                                            el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+b.growth_tw+" % </a>";
                                                        }else{
                                                            el+="-";
                                                        }
                                                    }
                                                el+='</td>'+
                                                '<td>'+addKoma(b.fb_kemarin)+'</td>'+
                                                '<td>'+b.fb_sekarang+'</td>'+
                                                '<td>';
                                                    if(b.growth_fb>0){
                                                        el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+b.growth_fb+" % </a>";
                                                    }else{
                                                        if(!isNaN(b.growth_fb)){
                                                            el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+b.growth_fb+" % </a>";
                                                        }else{
                                                            el+="-";
                                                        }
                                                    }
                                                el+='</td>'+
                                                '<td>'+b.ig_kemarin+'</td>'+
                                                '<td>'+b.ig_sekarang+'</td>'+
                                                '<td>';
                                                    if(b.growth_ig>0){
                                                        el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+b.growth_ig+" % </a>";
                                                    }else{
                                                        if(!isNaN(b.growth_ig)){
                                                            el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+b.growth_ig+" % </a>";
                                                        }else{
                                                            el+="-";
                                                        }
                                                    }
                                                el+='</td>'+
                                            '</tr>';
                                        }
                                    }else{
                                        var nama=b.unit_name;
                                        var color="";

                                        if(b.id==4){
                                            el+='<tr style="'+color+'">'+
                                                '<td>'+nama+'</td>'+
                                                '<td>'+addKoma(b.tw_kemarin)+'</td>'+
                                                '<td>'+addKoma(b.tw_sekarang)+'</td>'+
                                                '<td>';
                                                    if(b.growth_tw>0){
                                                        el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+b.growth_tw+" % </a>";
                                                    }else{
                                                        if(!isNaN(b.growth_tw)){
                                                            el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+b.growth_tw+" % </a>";
                                                        }else{
                                                            el+="-";
                                                        }
                                                    }
                                                el+='</td>'+
                                                '<td>'+addKoma(b.fb_kemarin)+'</td>'+
                                                '<td>'+b.fb_sekarang+'</td>'+
                                                '<td>';
                                                    if(b.growth_fb>0){
                                                        el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+b.growth_fb+" % </a>";
                                                    }else{
                                                        if(!isNaN(b.growth_fb)){
                                                            el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+b.growth_fb+" % </a>";
                                                        }else{
                                                            el+="-";
                                                        }
                                                    }
                                                el+='</td>'+
                                                '<td>'+b.ig_kemarin+'</td>'+
                                                '<td>'+b.ig_sekarang+'</td>'+
                                                '<td>';
                                                    if(b.growth_ig>0){
                                                        el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+b.growth_ig+" % </a>";
                                                    }else{
                                                        if(!isNaN(b.growth_ig)){
                                                            el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+b.growth_ig+" % </a>";
                                                        }else{
                                                            el+="-";
                                                        }
                                                    }
                                                el+='</td>'+
                                            '</tr>';

                                            /*tambahkan unit disini */
                                            $.each(result.tambahanInews,function(f,g){
                                                if(g.id!="TOTAL"){
                                                    el+="<tr>"+
                                                        "<td style='color:red'>"+g.program_name+"</td>"+
                                                        '<td>'+addKoma(g.tw_kemarin)+'</td>'+
                                                        '<td>'+addKoma(g.tw_sekarang)+'</td>'+
                                                        '<td>';
                                                            if(g.growth_tw>0){
                                                                el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+g.growth_tw+" % </a>";
                                                            }else{
                                                                if(!isNaN(g.growth_tw)){
                                                                    el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+g.growth_tw+" % </a>";
                                                                }else{
                                                                    el+="-";
                                                                }
                                                            }
                                                        el+='</td>'+
                                                        '<td>'+addKoma(g.fb_kemarin)+'</td>'+
                                                        '<td>'+g.fb_sekarang+'</td>'+
                                                        '<td>';
                                                            if(g.growth_fb>0){
                                                                el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+g.growth_fb+" % </a>";
                                                            }else{
                                                                if(!isNaN(g.growth_fb)){
                                                                    el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+g.growth_fb+" % </a>";
                                                                }else{
                                                                    el+="-";
                                                                }
                                                            }
                                                        el+='</td>'+
                                                        '<td>'+g.ig_kemarin+'</td>'+
                                                        '<td>'+g.ig_sekarang+'</td>'+
                                                        '<td>';
                                                            if(g.growth_ig>0){
                                                                el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+g.growth_ig+" % </a>";
                                                            }else{
                                                                if(!isNaN(g.growth_ig)){
                                                                    el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+g.growth_ig+" % </a>";
                                                                }else{
                                                                    el+="-";
                                                                }
                                                            }
                                                        el+='</td>'+
                                                    "</tr>";
                                                }
                                            })
                                        }else{
                                            el+='<tr style="'+color+'">'+
                                                '<td>'+nama+'</td>'+
                                                '<td>'+addKoma(b.tw_kemarin)+'</td>'+
                                                '<td>'+addKoma(b.tw_sekarang)+'</td>'+
                                                '<td>';
                                                    if(b.growth_tw>0){
                                                        el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+b.growth_tw+" % </a>";
                                                    }else{
                                                        if(!isNaN(b.growth_tw)){
                                                            el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+b.growth_tw+" % </a>";
                                                        }else{
                                                            el+="-";
                                                        }
                                                    }
                                                el+='</td>'+
                                                '<td>'+addKoma(b.fb_kemarin)+'</td>'+
                                                '<td>'+b.fb_sekarang+'</td>'+
                                                '<td>';
                                                    if(b.growth_fb>0){
                                                        el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+b.growth_fb+" % </a>";
                                                    }else{
                                                        if(!isNaN(b.growth_fb)){
                                                            el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+b.growth_fb+" % </a>";
                                                        }else{
                                                            el+="-";
                                                        }
                                                    }
                                                el+='</td>'+
                                                '<td>'+b.ig_kemarin+'</td>'+
                                                '<td>'+b.ig_sekarang+'</td>'+
                                                '<td>';
                                                    if(b.growth_ig>0){
                                                        el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+b.growth_ig+" % </a>";
                                                    }else{
                                                        if(!isNaN(b.growth_ig)){
                                                            el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+b.growth_ig+" % </a>";
                                                        }else{
                                                            el+="-";
                                                        }
                                                    }
                                                el+='</td>'+
                                            '</tr>';
                                        }
                                    }
                                })
                            el+='</tbody>'+
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
                                    "<th class='text-center' style='background:#008ef6;color:white'>Twitter</th>"+
                                    "<th class='text-center' style='background:#5054ab;color:white'>Facebook</th>"+
                                    "<th class='text-center' style='background:#a200b2;color:white'>Instagram</th>"+
                                "</tr>"+
                                "<tr>"+
                                    "<th class='text-center' style='background:#008ef6;color:white'>"+result.sekarang+"</th>"+
                                    "<th class='text-center' style='background:#5054ab;color:white'>"+result.sekarang+"</th>"+
                                    "<th class='text-center' style='background:#a200b2;color:white'>"+result.sekarang+"</th>"+
                                "</tr>"+
                            "</thead>"+
                            '<tbody style="color:#222">';
                                $.each(result.data,function(a,b){
                                    if(b.urut=="total"){
                                        var warna="background:#f2eff2;color:#222;font-weight:700";
                                    }else{
                                        var warna="";
                                    }

                                    el+='<tr style="'+warna+'">'+
                                        '<td>';
                                            if(b.urut=="total"){
                                                el+="Total";
                                            }else if(b.urut=="corporate"){
                                                el+=b.unit_name+" Official";
                                            }else{
                                                el+=b.unit_sosmed_name;
                                            }
                                        el+='</td>'+
                                        "<td>"+addKoma(b.tw)+"</td>"+
                                        "<td>"+addKoma(b.fb)+"</td>"+
                                        "<td>"+addKoma(b.ig)+"</td>"+
                                    "</tr>";
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
                                        '<th width="18%" rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">Channel</th>'+
                                        "<th colspan='3' class='text-center' style='background:#008ef6;color:white'>Twitter</th>"+
                                        "<th colspan='3' class='text-center' style='background:#5054ab;color:white'>Facebook</th>"+
                                        "<th colspan='3' class='text-center' style='background:#a200b2;color:white'>Instagram</th>"+
                                    '</tr>'+
                                    '<tr>'+
                                        "<th class='text-center' style='background:#008ef6;color:white'>"+result.kemarin+"</th>"+
                                        "<th class='text-center' style='background:#008ef6;color:white'>"+result.sekarang+"</th>"+
                                        "<th class='text-center' style='background:#008ef6;color:white'>Growth From Yesterday</th>"+

                                        "<th class='text-center' style='background:#5054ab;color:white'>"+result.sekarang+"</th>"+
                                        "<th class='text-center' style='background:#5054ab;color:white'>"+result.sekarang+"</th>"+
                                        "<th class='text-center' style='background:#5054ab;color:white'>Growth From Yesterday</th>"+

                                        "<th class='text-center' style='background:#a200b2;color:white'>"+result.sekarang+"</th>"+
                                        "<th class='text-center' style='background:#a200b2;color:white'>"+result.sekarang+"</th>"+
                                        "<th class='text-center' style='background:#a200b2;color:white'>Growth From Yesterday</th>"+
                                    "</tr>"+
                                "</thead>"+
                                '<tbody style="color:#222">';
                                    $.each(result.unit,function(a,b){
                                        if(b.id=="SUBTOTAL"){
                                            if(b.group_id=="TOTAL"){
                                                var nama="NILAI RATA - RATA";
                                                var color="background:#419F51;color:white;font-weight:700";

                                                el+="<tr style='"+color+"'>"+
                                                    '<td>'+nama+'</td>'+
                                                    '<td></td>'+
                                                    '<td>'+addKoma((b.tw_sekarang/13).toFixed())+'</td>'+
                                                    '<td></td>'+
                                                    '<td></td>'+
                                                    '<td>'+addKoma((b.fb_sekarang/13).toFixed())+'</td>'+
                                                    '<td></td>'+
                                                    '<td></td>'+
                                                    '<td>'+addKoma((b.ig_sekarang/13).toFixed())+'</td>'+
                                                    '<td></td>'+
                                                '</tr>';
                                            }else{
                                                var nama=b.group_name;
                                                var color="background:#f2eff2;color:#222;font-weight:700";

                                                el+='<tr style="'+color+'">'+
                                                    '<td>'+nama+'</td>'+
                                                    '<td>'+addKoma(b.tw_kemarin)+'</td>'+
                                                    '<td>'+addKoma(b.tw_sekarang)+'</td>'+
                                                    '<td>';
                                                        if(b.growth_tw>0){
                                                            el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+b.growth_tw+" % </a>";
                                                        }else{
                                                            if(!isNaN(b.growth_tw)){
                                                                el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+b.growth_tw+" % </a>";
                                                            }else{
                                                                el+="-";
                                                            }
                                                        }
                                                    el+='</td>'+
                                                    '<td>'+addKoma(b.fb_kemarin)+'</td>'+
                                                    '<td>'+b.fb_sekarang+'</td>'+
                                                    '<td>';
                                                        if(b.growth_fb>0){
                                                            el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+b.growth_fb+" % </a>";
                                                        }else{
                                                            if(!isNaN(b.growth_fb)){
                                                                el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+b.growth_fb+" % </a>";
                                                            }else{
                                                                el+="-";
                                                            }
                                                        }
                                                    el+='</td>'+
                                                    '<td>'+b.ig_kemarin+'</td>'+
                                                    '<td>'+b.ig_sekarang+'</td>'+
                                                    '<td>';
                                                        if(b.growth_ig>0){
                                                            el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+b.growth_ig+" % </a>";
                                                        }else{
                                                            if(!isNaN(b.growth_ig)){
                                                                el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+b.growth_ig+" % </a>";
                                                            }else{
                                                                el+="-";
                                                            }
                                                        }
                                                    el+='</td>'+
                                                '</tr>';
                                            }
                                        }else{
                                            var nama=b.unit_name;
                                            var color="";
                                            
                                            /* tambahan untuk 4 program inews */
                                            if(b.id==4){
                                                var tws=0;
                                                var twk=0;
                                                var gtw=0
                                                var fbs=0;
                                                var fbk=0;
                                                var gfb=0;
                                                var igs=0;
                                                var igk=0;
                                                var gig=0;


                                                $.each(result.tambahanInews,function(f,g){
                                                    if(g.id=="TOTAL"){
                                                        tws=g.tw_sekarang;
                                                        twk=g.tw_kemarin;
                                                        gtw=g.growth_tw;
                                                        fbs=g.fb_sekarang;
                                                        fbk=g.fb_kemarin;
                                                        gfb=g.growth_fb;
                                                        igs=g.ig_sekarang;
                                                        igk=g.ig_kemarin;
                                                        gig=g.growth_ig;
                                                    }
                                                })

                                                el+='<tr style="'+color+'">'+
                                                    '<td>'+nama+'</td>'+
                                                    '<td>'+addKoma(twk)+'</td>'+
                                                    '<td>'+addKoma(tws)+'</td>'+
                                                    '<td>';
                                                        if(gtw>0){
                                                            el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+gtw+" % </a>";
                                                        }else{
                                                            if(!isNaN(gtw)){
                                                                el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+gtw+" % </a>";
                                                            }else{
                                                                el+="-";
                                                            }
                                                        }
                                                    el+='</td>'+
                                                    '<td>'+addKoma(fbk)+'</td>'+
                                                    '<td>'+addKoma(fbs)+'</td>'+
                                                    '<td>';
                                                        if(gfb>0){
                                                            el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+gfb+" % </a>";
                                                        }else{
                                                            if(!isNaN(gfb)){
                                                                el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+gfb+" % </a>";
                                                            }else{
                                                                el+="-";
                                                            }
                                                        }
                                                    el+='</td>'+
                                                    '<td>'+addKoma(igk)+'</td>'+
                                                    '<td>'+addKoma(igs)+'</td>'+
                                                    '<td>';
                                                        if(gig>0){
                                                            el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+gig+" % </a>";
                                                        }else{
                                                            if(!isNaN(gig)){
                                                                el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+gig+" % </a>";
                                                            }else{
                                                                el+="-";
                                                            }
                                                        }
                                                    el+='</td>'+
                                                '</tr>';

                                                /*tambahkan unit disini */
                                                $.each(result.tambahanInews,function(f,g){
                                                    if(g.id!="TOTAL"){
                                                        el+="<tr>"+
                                                            "<td style='color:red'>"+g.program_name+"</td>"+
                                                            '<td>'+addKoma(g.tw_kemarin)+'</td>'+
                                                            '<td>'+addKoma(g.tw_sekarang)+'</td>'+
                                                            '<td>';
                                                                if(g.growth_tw>0){
                                                                    el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+g.growth_tw+" % </a>";
                                                                }else{
                                                                    if(!isNaN(g.growth_tw)){
                                                                        el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+g.growth_tw+" % </a>";
                                                                    }else{
                                                                        el+="-";
                                                                    }
                                                                }
                                                            el+='</td>'+
                                                            '<td>'+addKoma(g.fb_kemarin)+'</td>'+
                                                            '<td>'+g.fb_sekarang+'</td>'+
                                                            '<td>';
                                                                if(g.growth_fb>0){
                                                                    el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+g.growth_fb+" % </a>";
                                                                }else{
                                                                    if(!isNaN(g.growth_fb)){
                                                                        el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+g.growth_fb+" % </a>";
                                                                    }else{
                                                                        el+="-";
                                                                    }
                                                                }
                                                            el+='</td>'+
                                                            '<td>'+g.ig_kemarin+'</td>'+
                                                            '<td>'+g.ig_sekarang+'</td>'+
                                                            '<td>';
                                                                if(g.growth_ig>0){
                                                                    el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+g.growth_ig+" % </a>";
                                                                }else{
                                                                    if(!isNaN(g.growth_ig)){
                                                                        el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+g.growth_ig+" % </a>";
                                                                    }else{
                                                                        el+="-";
                                                                    }
                                                                }
                                                            el+='</td>'+
                                                        "</tr>";
                                                    }
                                                })
                                            }else{
                                                el+='<tr style="'+color+'">'+
                                                    '<td>'+nama+'</td>'+
                                                    '<td>'+addKoma(b.tw_kemarin)+'</td>'+
                                                    '<td>'+addKoma(b.tw_sekarang)+'</td>'+
                                                    '<td>';
                                                        if(b.growth_tw>0){
                                                            el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+b.growth_tw+" % </a>";
                                                        }else{
                                                            if(!isNaN(b.growth_tw)){
                                                                el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+b.growth_tw+" % </a>";
                                                            }else{
                                                                el+="-";
                                                            }
                                                        }
                                                    el+='</td>'+
                                                    '<td>'+addKoma(b.fb_kemarin)+'</td>'+
                                                    '<td>'+b.fb_sekarang+'</td>'+
                                                    '<td>';
                                                        if(b.growth_fb>0){
                                                            el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+b.growth_fb+" % </a>";
                                                        }else{
                                                            if(!isNaN(b.growth_fb)){
                                                                el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+b.growth_fb+" % </a>";
                                                            }else{
                                                                el+="-";
                                                            }
                                                        }
                                                    el+='</td>'+
                                                    '<td>'+b.ig_kemarin+'</td>'+
                                                    '<td>'+b.ig_sekarang+'</td>'+
                                                    '<td>';
                                                        if(b.growth_ig>0){
                                                            el+="<a><i class='icon-arrow-up16' style='color:green'></i> "+b.growth_ig+" % </a>";
                                                        }else{
                                                            if(!isNaN(b.growth_ig)){
                                                                el+="<a><i class='icon-arrow-down16' style='color:red'></i> "+b.growth_ig+" % </a>";
                                                            }else{
                                                                el+="-";
                                                            }
                                                        }
                                                    el+='</td>'+
                                                '</tr>';
                                            }
                                        }
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
                                                el+=b.followers.tw.growth+" %";
                                            }else{
                                                el+=0+" %";
                                            }
                                        el+="</td>"+
                                        "<td>"+addKoma(b.followers.tw.total)+"</td>"+
                                        "<td>"+b.followers.tw.rank+"</td>"+
                                        "<td>";
                                            if(b.followers.fb.growth!=null){
                                                el+=b.followers.fb.growth+" %";
                                            }else{
                                                el+=0+" %";
                                            }
                                        el+="</td>"+
                                        "<td>"+addKoma(b.followers.fb.total)+"</td>"+
                                        "<td>"+b.followers.fb.rank+"</td>"+
                                        "<td>";
                                            if(b.followers.ig.growth!=null){
                                                el+=b.followers.ig.growth+" %";
                                            }else{
                                                el+=0+" %";
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
                                                ep+=b.followers.tw.growth+" %";
                                            }else{
                                                ep+=0+" %";
                                            }
                                        ep+="</td>"+
                                        "<td>"+b.followers.tw.rank+"</td>"+
                                        "<td>"+b.followers.fb.num_of_growth+"</td>"+
                                        "<td>";
                                            if(b.followers.fb.growth!=null){
                                                ep+=b.followers.fb.growth+" %";
                                            }else{
                                                ep+=0+" %";
                                            }
                                        ep+="</td>"+
                                        "<td>"+b.followers.fb.rank+"</td>"+
                                        "<td>"+b.followers.ig.num_of_growth+"</td>"+
                                        "<td>";
                                            if(b.followers.ig.growth!=null){
                                                ep+=b.followers.ig.growth+" %";
                                            }else{
                                                ep+=0+" %";
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
                                                el+=b.followers.tw.growth+" %";
                                            }else{
                                                el+=0+" %";
                                            }
                                        el+="</td>"+
                                        "<td>"+addKoma(b.followers.tw.total)+"</td>"+
                                        "<td>"+b.followers.tw.rank+"</td>"+
                                        "<td>";
                                            if(b.followers.fb.growth!=null){
                                                el+=b.followers.fb.growth+" %";
                                            }else{
                                                el+=0+" %";
                                            }
                                        el+="</td>"+
                                        "<td>"+addKoma(b.followers.fb.total)+"</td>"+
                                        "<td>"+b.followers.fb.rank+"</td>"+
                                        "<td>";
                                            if(b.followers.ig.growth!=null){
                                                el+=b.followers.ig.growth+" %";
                                            }else{
                                                el+=0+" %";
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
                                                ep+=b.followers.tw.growth+" %";
                                            }else{
                                                ep+=0+" %";
                                            }
                                        ep+="</td>"+
                                        "<td>"+b.followers.tw.rank+"</td>"+
                                        "<td>"+b.followers.fb.num_of_growth+"</td>"+
                                        "<td>";
                                            if(b.followers.fb.growth!=null){
                                                ep+=b.followers.fb.growth+" %";
                                            }else{
                                                ep+=0+" %";
                                            }
                                        ep+="</td>"+
                                        "<td>"+b.followers.fb.rank+"</td>"+
                                        "<td>"+b.followers.ig.num_of_growth+"</td>"+
                                        "<td>";
                                            if(b.followers.ig.growth!=null){
                                                ep+=b.followers.ig.growth+" %";
                                            }else{
                                                ep+=0+" %";
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

            function rankOfficialAccountAmong4Tv(){
                var group=$("#group6").val();
                var tanggal=$("#tanggal6").val();
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/rank-of-official-account-among-4tv')}}",
                    type:"GET",
                    data:"group="+group+"&tanggal="+tanggal,
                    beforeSend:function(){
                        $("#rankOfficialAccountAmong4Tv").empty().html("<div class='alert alert-info'>Please Wait. . . .</div>");
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
                                                el+=b.followers.tw.growth+" %";
                                            }else{
                                                el+=0+" %";
                                            }
                                        el+="</td>"+
                                        "<td>"+addKoma(b.followers.tw.total)+"</td>"+
                                        "<td>"+b.followers.tw.rank+"</td>"+
                                        "<td>";
                                            if(b.followers.fb.growth!=null){
                                                el+=b.followers.fb.growth+" %";
                                            }else{
                                                el+=0+" %";
                                            }
                                        el+="</td>"+
                                        "<td>"+addKoma(b.followers.fb.total)+"</td>"+
                                        "<td>"+b.followers.fb.rank+"</td>"+
                                        "<td>";
                                            if(b.followers.ig.growth!=null){
                                                el+=b.followers.ig.growth+" %";
                                            }else{
                                                el+=0+" %";
                                            }
                                        el+="</td>"+
                                        "<td>"+addKoma(b.followers.ig.total)+"</td>"+
                                        "<td>"+b.followers.ig.rank+"</td>"+
                                    "</tr>";
                                })
                            el+="</tbody>"+
                        "</table>";

                        $("#rankOfficialAccountAmong4Tv").empty().html(el);
                        
                        ep+="<table class='table table-striped'>"+
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
                                    ep+="<tr>"+
                                        "<td>"+b.unit_name+"</td>"+
                                        "<td>"+addKoma(b.followers.tw.num_of_growth)+"</td>"+
                                        "<td>";
                                            if(b.followers.tw.growth!=null){
                                                ep+=b.followers.tw.growth+" %";
                                            }else{
                                                ep+=0+" %";
                                            }
                                        ep+="</td>"+
                                        "<td>"+b.followers.tw.rank+"</td>"+
                                        "<td>"+addKoma(b.followers.fb.num_of_growth)+"</td>"+
                                        "<td>";
                                            if(b.followers.fb.growth!=null){
                                                ep+=b.followers.fb.growth+" %";
                                            }else{
                                                ep+=0+" %";
                                            }
                                        ep+="</td>"+
                                        "<td>"+b.followers.fb.rank+"</td>"+
                                        "<td>"+addKoma(b.followers.ig.num_of_growth)+"</td>"+
                                        "<td>";
                                            if(b.followers.ig.growth!=null){
                                                ep+=b.followers.ig.growth+" %";
                                            }else{
                                                ep+=0+" %";
                                            }
                                        ep+="</td>"+
                                        "<td>"+b.followers.ig.rank+"</td>"+
                                    "</tr>";
                                })
                            ep+="</tbody>"+
                        "</table>";

                        $("#rankOfficialAccountAmong4TvFromYesterday").empty().html(ep);
                    },
                    error:function(){

                    }
                })
            }

            function rankOverallAmong4Tv(){
                var group=$("#group6").val();
                var tanggal=$("#tanggal6").val();

                var el="";
                var ep="";

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/rank-overall-account-all-tv-by-total-followers')}}",
                    type:"GET",
                    data:"tanggal="+tanggal+"&group="+group,
                    beforeSend:function(){
                        $("#rankOverallAmong4Tv").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                        $("#rankOverallAmong4TvYesterday").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
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
                                                el+=b.followers.tw.growth+" %";
                                            }else{
                                                el+=0+" %";
                                            }
                                        el+="</td>"+
                                        "<td>"+addKoma(b.followers.tw.total)+"</td>"+
                                        "<td>"+b.followers.tw.rank+"</td>"+
                                        "<td>";
                                            if(b.followers.fb.growth!=null){
                                                el+=b.followers.fb.growth+" %";
                                            }else{
                                                el+=0+" %";
                                            }
                                        el+="</td>"+
                                        "<td>"+addKoma(b.followers.fb.total)+"</td>"+
                                        "<td>"+b.followers.fb.rank+"</td>"+
                                        "<td>";
                                            if(b.followers.ig.growth!=null){
                                                el+=b.followers.ig.growth+" %";
                                            }else{
                                                el+=0+" %";
                                            }
                                        el+="</td>"+
                                        "<td>"+addKoma(b.followers.ig.total)+"</td>"+
                                        "<td>"+b.followers.ig.rank+"</td>"+
                                    "</tr>";
                                })
                            el+="</tbody>"+
                        "</table>";
                        $("#rankOverallAmong4Tv").empty().html(el);

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
                                                ep+=b.followers.tw.growth+" %";
                                            }else{
                                                ep+=0+" %";
                                            }
                                        ep+="</td>"+
                                        "<td>"+b.followers.tw.rank+"</td>"+
                                        "<td>"+b.followers.fb.num_of_growth+"</td>"+
                                        "<td>";
                                            if(b.followers.fb.growth!=null){
                                                ep+=b.followers.fb.growth+" %";
                                            }else{
                                                ep+=0+" %";
                                            }
                                        ep+="</td>"+
                                        "<td>"+b.followers.fb.rank+"</td>"+
                                        "<td>"+b.followers.ig.num_of_growth+"</td>"+
                                        "<td>";
                                            if(b.followers.ig.growth!=null){
                                                ep+=b.followers.ig.growth+" %";
                                            }else{
                                                ep+=0+" %";
                                            }
                                        ep+="</td>"+
                                        "<td>"+b.followers.ig.rank+"</td>"+
                                    "</tr>";
                                })
                            ep+="</tbody>"+
                        "</table>";
                        $("#rankOverallAmong4TvYesterday").empty().html(ep);
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

            $(document).on("submit","#formrankOfficialAccountAmong4Tv",function(){
                rankOfficialAccountAmong4Tv();    
                rankOverallAmong4Tv();
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
            rankOfficialAccountAmong4Tv();
            rankOverallAmong4Tv();
            /* end rangking show */

            $(document).on("click","#exportpdf",function(){
                var el="";
                el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                    '<div class="modal-dialog">'+
                        '<form id="formExportPdf" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header bg-primary">'+
                                    '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                    '<h5 class="modal-title" id="modal-title">Export PDF</h5>'+
                                '</div>'+

                                '<div class="modal-body">'+
                                    '<div id="pesan"></div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Date</label>'+
                                        '<input class="form-control" name="tanggal" id="tanggal" placeholder="Date" required>'+
                                    '</div>'+

                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Compare Date</label>'+
                                        '<input class="form-control" name="compare" id="compare" placeholder="Compare Date" required>'+
                                    '</div>'+
                                '</div>'+

                                '<div class="modal-footer">'+
                                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                    '<button type="submit" class="btn btn-primary btn-ladda btn-ladda-spinner" > <span class="ladda-label"><i class="icon-file-pdf"></i> Export File</span> </button>'+
                                '</div>'+
                            '</div>'+
                        '</form>'+
                    '</div>'+
                '</div>';

                $("#divModal").empty().html(el);
                $("#modal_default").modal("show");
            })

            $(document).on("submit","#formExportPdf",function(e){
                var data = new FormData(this);
                if($("#formExportPdf")[0].checkValidity()) {

                }else console.log("invalid form");
            })
        })
    </script>
@endpush
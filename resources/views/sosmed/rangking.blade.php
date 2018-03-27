@extends('layouts.sosmed')

@section('title')
    Dashboard
@endsection

@section('extra-style')

@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Highlight</div>
        <div class="panel-body">
            <form class="form-horizontal" target="new target" id="form" onsubmit="return false;">
                <div class="form-group">
                    <label class="col-lg-2">Date</label>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="icon-calendar"></i></span>
                            <input class="form-control daterange-single-sekarang" name="tanggal" id="tanggal">
                        </div>
                    </div>
                </div>
                <div id="anotherDate"></div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="pilih" id="pilih"> <small>check to compare data with another date?</small>
                    </label>
                </div>
                <br>
                <div class="form-group well">
                    <label class="col-lg-2"></label>
                    <div class="col-lg-4">
                        <button class='btn btn-primary'>
                            <i class="icon-file-text2"></i> Show Highlight
                        </button>
                    </div>
                </div>
            </form>     
        </div>
    </div>

    <div class="panel panel-primary" id="panelShow" style="display:none;">
        <div class="panel-heading">
            <h6 class="panel-title text-center" id='panelTitle'>
                Report Highlights
            </h6>
        </div>

        <div class="panel-body">
            <dd>
                <dl>1. Official Account All TV By Total Followers
                    <div id="officalAccountAllTvByTotalFollowers"></div>
                </dl>
                <dl>2. Group Official Account by Total Followers
                    <div id="groupOfficialAccountByTotalFollowers"></div>
                </dl>
                <dl>3. Group Overall Accounts ( Official + Program ) by Total Followers
                    <div id="groupOverallAccount"></div>
                </dl>
                <dl>4. Program Accounts ALL TV by Additional Followers from yesterday
                    <div id="programAccountAllTv"></div>
                </dl>
                <dl>5. 4TV's Followers Achievement below 50%
                    <div id="tvAchievementbelow50"></div>
                </dl>
                <!-- <dl>6. Our 4TV's Followers Official Accounts for those Achievement above 50%
                    <div id="tvAchievementabove50"></div>
                    <br>
                </dl> -->
            </ul>
            
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
            var sekarang = new Date();
            var kemarin = new Date(sekarang);
            kemarin.setDate(sekarang.getDate() - 1);

            $('.daterange-single-sekarang').datepicker({ 
                singleDatePicker: true,
                selectMonths: true,
                selectYears: true
            });

            $('.daterange-single-sekarang').datepicker('setDate',sekarang);
            
            $(document).on("click","#pilih",function(){
                if($(this).is(':checked')){
                    var el="";
                    el+='<div class="form-group">'+
                        '<label class="col-lg-2">Compare With</label>'+
                        '<div class="col-lg-4">'+
                            '<div class="input-group">'+
                                '<span class="input-group-addon"><i class="icon-calendar"></i></span>'+
                                '<input class="form-control daterange-single-kemarin" name="kemarin" id="kemarin">'+
                            '</div>'+
                        '</div>'+
                    '</div>';

                    $("#anotherDate").empty().html(el);

                    $('.daterange-single-kemarin').datepicker({ 
                        singleDatePicker: true,
                        selectMonths: true,
                        selectYears: true
                    });

                    $('.daterange-single-kemarin').datepicker('setDate',kemarin);
                }else{
                    $("#anotherDate").empty();
                }
            })

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
            
            function officialAccountAllTvByTotalFollowers(){
                var tanggal=$("#tanggal").val();
                var k=$("#kemarin").val();
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/highlight-of-official-account-all-tv')}}",
                    type:"GET",
                    data:"tanggal="+tanggal+"&kemarin="+k,
                    beforeSend:function(){
                        $("#officalAccountAllTvByTotalFollowers").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<ul>"+
                            "<li>Twitter"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==1){
                                        el+="<li>1. "+result[a].unit_name+" "+addKoma(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_twitter+" / "+result[a].follower.num_of_growth_tw+")</li>";
                                    }
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==3){
                                        el+="<li>3. "+result[a].unit_name+" "+addKoma(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_twitter+" / "+result[a].follower.num_of_growth_tw+")</li>";
                                    }
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==2){
                                        el+="<li>2. "+result[a].unit_name+" "+addKoma(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_twitter+" / "+result[a].follower.num_of_growth_tw+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>Facebook"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==3){
                                        el+="<li>3. "+result[a].unit_name+" "+addKoma(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" / "+result[a].follower.num_of_growth_fb+")</li>";
                                    }
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==2){
                                        el+="<li>2. "+result[a].unit_name+" "+addKoma(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" / "+result[a].follower.num_of_growth_fb+")</li>";
                                    }
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==1){
                                        el+="<li>1. "+result[a].unit_name+" "+addKoma(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" / "+result[a].follower.num_of_growth_fb+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>Instagram"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==3){
                                        el+="<li>3. "+result[a].unit_name+" "+addKoma(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" / "+result[a].follower.num_of_growth_ig+")</li>";
                                    }
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==2){
                                        el+="<li>2. "+result[a].unit_name+" "+addKoma(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" / "+result[a].follower.num_of_growth_ig+")</li>";
                                    }
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==1){
                                        el+="<li>1. "+result[a].unit_name+" "+addKoma(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" / "+result[a].follower.num_of_growth_ig+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                        "</ul>";
                        $("#officalAccountAllTvByTotalFollowers").empty().html(el);
                    },
                    error:function(){

                    }
                })
            }

            function groupOfficialAccountByTotalFollowers(){
                var tanggal=$("#tanggal").val();
                var k=$("#kemarin").val();
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/highlight-group-official-account-by-total-followers')}}",
                    type:"GET",
                    data:"tanggal="+tanggal+"&kemarin="+k,
                    beforeSend:function(){
                        $("#groupOfficialAccountByTotalFollowers").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<ul>"+
                            "<li>Twitter"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==1){
                                        el+="<li>1. "+result[a].group_name+" "+addKoma(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_tw+" / "+result[a].follower.num_of_growth_tw+")</li>";
                                    }
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==3){
                                        el+="<li>3. "+result[a].group_name+" "+addKoma(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_tw+" / "+result[a].follower.num_of_growth_tw+")</li>";
                                    }
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==2){
                                        el+="<li>2. "+result[a].group_name+" "+addKoma(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_tw+" / "+result[a].follower.num_of_growth_tw+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>Facebook"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==3){
                                        el+="<li>3. "+result[a].group_name+" "+addKoma(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" / "+result[a].follower.num_of_growth_fb+")</li>";
                                    }
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==2){
                                        el+="<li>2. "+result[a].group_name+" "+addKoma(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" / "+result[a].follower.num_of_growth_fb+")</li>";
                                    }
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==1){
                                        el+="<li>1. "+result[a].group_name+" "+addKoma(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" / "+result[a].follower.num_of_growth_fb+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>Instagram"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==3){
                                        el+="<li>3. "+result[a].group_name+" "+addKoma(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" / "+result[a].follower.num_of_growth_ig+")</li>";
                                    }
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==2){
                                        el+="<li>2. "+result[a].group_name+" "+addKoma(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" / "+result[a].follower.num_of_growth_ig+")</li>";
                                    }
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==1){
                                        el+="<li>1. "+result[a].group_name+" "+addKoma(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" / "+result[a].follower.num_of_growth_ig+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                        "</ul>";
                        $("#groupOfficialAccountByTotalFollowers").empty().html(el);
                    },
                    error:function(){
                        $("#groupOfficialAccountByTotalFollowers").empty().html("<div class='alert alert-danger'>Load Data error</div>");
                    }
                })
            }

            function groupOverallAccount(){
                var tanggal=$("#tanggal").val();
                var k=$("#kemarin").val();
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/highlight-group-overall-account')}}",
                    type:"GET",
                    data:"tanggal="+tanggal+"&kemarin="+k,
                    beforeSend:function(){
                        $("#groupOverallAccount").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<ul>"+
                            "<li>Twitter"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==1){
                                        el+="<li>1. "+result[a].group_name+" "+addKoma(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_tw+" / "+result[a].follower.num_of_growth_tw+")</li>";
                                    }
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==3){
                                        el+="<li>3. "+result[a].group_name+" "+addKoma(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_tw+" / "+result[a].follower.num_of_growth_tw+")</li>";
                                    }
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==2){
                                        el+="<li>2. "+result[a].group_name+" "+addKoma(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_tw+" / "+result[a].follower.num_of_growth_tw+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>Facebook"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==3){
                                        el+="<li>3. "+result[a].group_name+" "+addKoma(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" / "+result[a].follower.num_of_growth_fb+")</li>";
                                    }
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==2){
                                        el+="<li>2. "+result[a].group_name+" "+addKoma(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" / "+result[a].follower.num_of_growth_fb+")</li>";
                                    }
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==1){
                                        el+="<li>1. "+result[a].group_name+" "+addKoma(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" / "+result[a].follower.num_of_growth_fb+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>Instagram"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==3){
                                        el+="<li>3. "+result[a].group_name+" "+addKoma(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" / "+result[a].follower.num_of_growth_ig+")</li>";
                                    }
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==2){
                                        el+="<li>2. "+result[a].group_name+" "+addKoma(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" / "+result[a].follower.num_of_growth_ig+")</li>";
                                    }
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==1){
                                        el+="<li>1. "+result[a].group_name+" "+addKoma(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" / "+result[a].follower.num_of_growth_ig+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                        "</ul>";
                        $("#groupOverallAccount").empty().html(el);
                    },
                    error:function(){

                    }
                })
            }

            function programAccountAllTv(){
                var tanggal=$("#tanggal").val();
                var k=$("#kemarin").val();
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/highlight-program-account-all-tv')}}",
                    type:"GET",
                    data:"tanggal="+tanggal+"&kemarin="+k,
                    beforeSend:function(){
                        $("#programAccountAllTv").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<ul>"+
                            "<li>Twitter"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==1){
                                        el+="<li>1. "+result[a].unit_name+" "+addKoma(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_tw+" / "+result[a].follower.num_of_growth_tw+")</li>";
                                    }
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==3){
                                        el+="<li>3. "+result[a].unit_name+" "+addKoma(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_tw+" / "+result[a].follower.num_of_growth_tw+")</li>";
                                    }
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==2){
                                        el+="<li>2. "+result[a].unit_name+" "+addKoma(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_tw+" / "+result[a].follower.num_of_growth_tw+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>Facebook"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==3){
                                        el+="<li>3. "+result[a].unit_name+" "+addKoma(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" / "+result[a].follower.num_of_growth_fb+")</li>";
                                    }
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==2){
                                        el+="<li>2. "+result[a].unit_name+" "+addKoma(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" / "+result[a].follower.num_of_growth_fb+")</li>";
                                    }
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==1){
                                        el+="<li>1. "+result[a].unit_name+" "+addKoma(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" / "+result[a].follower.num_of_growth_fb+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>Instagram"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==3){
                                        el+="<li>3. "+result[a].unit_name+" "+addKoma(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" / "+result[a].follower.num_of_growth_ig+")</li>";
                                    }
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==2){
                                        el+="<li>2. "+result[a].unit_name+" "+addKoma(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" / "+result[a].follower.num_of_growth_ig+")</li>";
                                    }
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==1){
                                        el+="<li>1. "+result[a].unit_name+" "+addKoma(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" / "+result[a].follower.num_of_growth_ig+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                        "</ul>";
                        $("#programAccountAllTv").empty().html(el);
                    },
                    error:function(){

                    }
                })
            }

            function tvAchievementbelow50(){
                var tanggal=$("#tanggal").val();
                var k=$("#kemarin").val();
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/highlight-target-achivement')}}",
                    type:"GET",
                    data:"tanggal="+tanggal+"&kemarin="+k,
                    beforeSend:function(){
                        $("#tvAchievementbelow50").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<ul>"+
                            "<li>Twitter"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.acv_tw < 50){
                                        el+="<li>1. "+result[a].unit_name+" "+result[a].follower.acv_tw+" %</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>Facebook"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.acv_fb < 50){
                                        el+="<li>1. "+result[a].unit_name+" "+result[a].follower.acv_fb+" %</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>Instagram"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.ig==3 && result[a].follower.acv_ig < 50){
                                        el+="<li>1. "+result[a].unit_name+" "+result[a].follower.acv_ig+" %</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                        "</ul>";
                        $("#tvAchievementbelow50").empty().html(el);
                    },
                    error:function(){

                    }
                })
            }

            function tvAchievementabove50(){

            }

            $(document).on("submit","#form",function(){
                var tanggal=$("#tanggal").val();
                var k=$("#kemarin").val();

                if($('#pilih').is(':checked')){
                    $("#panelTitle").empty().html("Report Highlights as of 2PM today ("+tanggal+") compared to ("+k+")");
                }else{
                    $("#panelTitle").empty().html("Report Highlights as of 2PM today ("+tanggal+")");
                }

                $("#panelShow").show();
                officialAccountAllTvByTotalFollowers();
                groupOfficialAccountByTotalFollowers();
                groupOverallAccount();
                programAccountAllTv();
                tvAchievementbelow50();
            })
            
        })
    </script>
@endpush
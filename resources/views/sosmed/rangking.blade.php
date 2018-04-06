@extends('layouts.sosmed')

@section('title')
    Dashboard
@endsection

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

    table.floatThead-table {
        border-top: none;
        border-bottom: none;
        background-color: #fff;
    }
    .daterangepicker{z-index:1151 !important;}
    #ui-datepicker-div{z-index:1151 !important;}
</style>
@stop

@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading">Highlight</div>
        <div class="panel-body">
            <div class="tabbable">
                <ul class="nav nav-tabs nav-tabs-highlight">
                    <li class="active"><a href="#highlight-tab1" data-toggle="tab">HIGLIGHT</a></li>
                    <li><a href="#highlighted-tab2" data-toggle="tab">ALL PROGRAM GROWTH</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="highlight-tab1">
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

                        <div class="panel panel-default" id="panelShow" style="display:none;">
                            <div class="panel-heading">
                                <h6 class="panel-title text-center" id='panelTitle'>
                                    Report Highlights
                                </h6>
                            </div>

                            <div class="panel-body">
                                <dd>
                                    <dl>1. *Official Account* All TV By *Total Followers*
                                        <div id="officalAccountAllTvByTotalFollowers"></div>
                                    </dl>
                                    <dl>2. *Group Official* Account by *Total Followers*
                                        <div id="groupOfficialAccountByTotalFollowers"></div>
                                    </dl>
                                    <dl>3. *Group Overall* Accounts ( Official + Program ) by *Total Followers*
                                        <div id="groupOverallAccount"></div>
                                    </dl>
                                    <dl>4. *Program Accounts* ALL TV by *Additional Followers* from yesterday
                                        <div id="programAccountAllTv"></div>
                                    </dl>
                                    <dl>5. *4TV's* Followers *Achievement below 50%*
                                        <div id="tvAchievementbelow50"></div>
                                    </dl>
                                    <dl>6. *Our 4TV's* Followers *Official Accounts* for those *Achievement above 50%*
                                        <div id="tvAchievementabove50"></div>
                                        <br>
                                    </dl>
                                </ul>
                                
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="highlighted-tab2">
                        <fieldset>
                            <legend>Filter</legend>
                            <div class="row" style="padding-left:10px;">
                                <form id="formSearch" onsubmit="return false;">
                                    <div class="col-lg-3">
                                        <div id="divsearchunit">
                                            <div class="form-group">
                                                <label for="" class="control-label">Unit</label>
                                                <select name="searchunit" id="searchunit" class="form-control">
                                                    <option value="" disabled selected>--Select Unit--</option>
                                                    @foreach($unit as $row)
                                                        <option value="{{$row->id}}" data-group="{{$row->group_unit_id}}">{{$row->unit_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label">Date</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-calendar"></i></span>
                                                <input class="form-control daterange-single-sekarang" name="tanggal2" id="tanggal2">
                                            </div>
                                        </div>
                                    </div>

                                    <div id="anotherDate2"></div>

                                    <div class="col-lg-2">
                                        <button class="btn btn-primary" style="margin-top:25px">
                                            <i class="icon-filter4"></i> Filter
                                        </button>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="pilih2" id="pilih2"> <small>check to compare data with another date?</small>
                                            </label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </fieldset>
                        <br>
                        <div id="growthProgram"></div>
                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/floatthead/2.1.1/jquery.floatThead.js"></script>
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

            $(document).on("click","#pilih2",function(){
                if($(this).is(':checked')){
                    var el="";
                    el+='<div class="col-lg-3"><div class="form-group">'+
                        '<label class="control-label">Compare With</label>'+
                        '<div class="input-group">'+
                            '<span class="input-group-addon"><i class="icon-calendar"></i></span>'+
                            '<input class="form-control daterange-single-kemarin2" name="kemarin2" id="kemarin2">'+
                        '</div>'+
                    '</div></div>';

                    $("#anotherDate2").empty().html(el);

                    $('.daterange-single-kemarin2').datepicker({ 
                        singleDatePicker: true,
                        selectMonths: true,
                        selectYears: true
                    });

                    $('.daterange-single-kemarin2').datepicker('setDate',kemarin);
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

            function convertMio(number){
                var milyar=1000000000;
                var juta=1000000;
                var ribuan=100000;
                var num=0;
                
                if(number>milyar){
                    num=number/milyar;
                    return num.toFixed(2)+" Million";
                }else if(number>=juta && number<milyar){
                    num=number/juta;
                    var tes=num.toString();
                    return tes.substring(0, 5)+" Mio";
                }else{
                    num=number/ribuan*100;

                    return num.toFixed(0)+" K";
                }
            }
            
            function officialAccountAllTvByTotalFollowers(){
                var tanggal=$("#tanggal").val();

                if($("#pilih").is(':checked')){
                    var pilih=$("#pilih").val();
                    var k=$("#kemarin").val();
                }else{
                    var pilih="";
                    var k="";
                }

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/highlight-of-official-account-all-tv')}}",
                    type:"GET",
                    data:"tanggal="+tanggal+"&kemarin="+k+"&pilih="+pilih,
                    beforeSend:function(){
                        $("#officalAccountAllTvByTotalFollowers").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<ul>"+
                            "<li>*Twitter*"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==1){
                                        el+="<li>1. "+result[a].unit_name+" "+convertMio(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_twitter+" / "+addKoma(result[a].follower.num_of_growth_tw)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==2){
                                        el+="<li>2. "+result[a].unit_name+" "+convertMio(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_twitter+" / "+addKoma(result[a].follower.num_of_growth_tw)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==3){
                                        el+="<li>3. "+result[a].unit_name+" "+convertMio(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_twitter+" / "+addKoma(result[a].follower.num_of_growth_tw)+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>*Facebook*"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==1){
                                        el+="<li>1. "+result[a].unit_name+" "+convertMio(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" / "+addKoma(result[a].follower.num_of_growth_fb)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==2){
                                        el+="<li>2. "+result[a].unit_name+" "+convertMio(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" / "+addKoma(result[a].follower.num_of_growth_fb)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==3){
                                        el+="<li>3. "+result[a].unit_name+" "+convertMio(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" / "+addKoma(result[a].follower.num_of_growth_fb)+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>*Instagram*"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==1){
                                        el+="<li>1. "+result[a].unit_name+" "+convertMio(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" / "+addKoma(result[a].follower.num_of_growth_ig)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==2){
                                        el+="<li>2. "+result[a].unit_name+" "+convertMio(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" / "+addKoma(result[a].follower.num_of_growth_ig)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==3){
                                        el+="<li>3. "+result[a].unit_name+" "+convertMio(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" / "+addKoma(result[a].follower.num_of_growth_ig)+")</li>";
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

                if($("#pilih").is(':checked')){
                    var pilih=$("#pilih").val();
                    var k=$("#kemarin").val();
                }else{
                    var pilih="";
                    var k="";
                }

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/highlight-group-official-account-by-total-followers')}}",
                    type:"GET",
                    data:"tanggal="+tanggal+"&kemarin="+k+"&pilih="+pilih,
                    beforeSend:function(){
                        $("#groupOfficialAccountByTotalFollowers").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<ul>"+
                            "<li>*Twitter*"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==1){
                                        el+="<li>1. "+result[a].group_name+" "+convertMio(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_tw+" % / "+addKoma(result[a].follower.num_of_growth_tw)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==2){
                                        el+="<li>2. "+result[a].group_name+" "+convertMio(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_tw+" % / "+addKoma(result[a].follower.num_of_growth_tw)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==3){
                                        el+="<li>3. "+result[a].group_name+" "+convertMio(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_tw+" % / "+addKoma(result[a].follower.num_of_growth_tw)+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>*Facebook*"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==1){
                                        el+="<li>1. "+result[a].group_name+" "+convertMio(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" % / "+addKoma(result[a].follower.num_of_growth_fb)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==2){
                                        el+="<li>2. "+result[a].group_name+" "+convertMio(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" % / "+addKoma(result[a].follower.num_of_growth_fb)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==3){
                                        el+="<li>3. "+result[a].group_name+" "+convertMio(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" % / "+addKoma(result[a].follower.num_of_growth_fb)+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>*Instagram*"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==1){
                                        el+="<li>1. "+result[a].group_name+" "+convertMio(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" % / "+addKoma(result[a].follower.num_of_growth_ig)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==2){
                                        el+="<li>2. "+result[a].group_name+" "+convertMio(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" % / "+addKoma(result[a].follower.num_of_growth_ig)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==3){
                                        el+="<li>3. "+result[a].group_name+" "+convertMio(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" % / "+addKoma(result[a].follower.num_of_growth_ig)+")</li>";
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
                
                if($("#pilih").is(':checked')){
                    var pilih=$("#pilih").val();
                    var k=$("#kemarin").val();
                }else{
                    var pilih="";
                    var k="";
                }

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/highlight-group-overall-account')}}",
                    type:"GET",
                    data:"tanggal="+tanggal+"&kemarin="+k+"&pilih="+pilih,
                    beforeSend:function(){
                        $("#groupOverallAccount").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<ul>"+
                            "<li>*Twitter*"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==1){
                                        el+="<li>1. "+result[a].group_name+" "+convertMio(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_tw+" % / "+addKoma(result[a].follower.num_of_growth_tw)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==2){
                                        el+="<li>2. "+result[a].group_name+" "+convertMio(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_tw+" % / "+addKoma(result[a].follower.num_of_growth_tw)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==3){
                                        el+="<li>3. "+result[a].group_name+" "+convertMio(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_tw+" % / "+addKoma(result[a].follower.num_of_growth_tw)+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>*Facebook*"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==1){
                                        el+="<li>1. "+result[a].group_name+" "+convertMio(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" % / "+addKoma(result[a].follower.num_of_growth_fb)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==2){
                                        el+="<li>2. "+result[a].group_name+" "+convertMio(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" % / "+addKoma(result[a].follower.num_of_growth_fb)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==3){
                                        el+="<li>3. "+result[a].group_name+" "+convertMio(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" % / "+addKoma(result[a].follower.num_of_growth_fb)+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>*Instagram*"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==1){
                                        el+="<li>1. "+result[a].group_name+" "+convertMio(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" % / "+addKoma(result[a].follower.num_of_growth_ig)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==2){
                                        el+="<li>2. "+result[a].group_name+" "+convertMio(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" % / "+addKoma(result[a].follower.num_of_growth_ig)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==3){
                                        el+="<li>3. "+result[a].group_name+" "+convertMio(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" % / "+addKoma(result[a].follower.num_of_growth_ig)+")</li>";
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
                
                if($("#pilih").is(':checked')){
                    var pilih=$("#pilih").val();
                    var k=$("#kemarin").val();
                }else{
                    var pilih="";
                    var k="";
                }

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/highlight-program-account-all-tv')}}",
                    type:"GET",
                    data:"tanggal="+tanggal+"&kemarin="+k+"&pilih="+pilih,
                    beforeSend:function(){
                        $("#programAccountAllTv").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<ul>"+
                            "<li>*Twitter*"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==1){
                                        el+="<li>1. "+result[a].unit_name+" "+convertMio(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_tw+" % / "+addKoma(result[a].follower.num_of_growth_tw)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==2){
                                        el+="<li>2. "+result[a].unit_name+" "+convertMio(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_tw+" % / "+addKoma(result[a].follower.num_of_growth_tw)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.rank_tw==3){
                                        el+="<li>3. "+result[a].unit_name+" "+convertMio(result[a].follower.tw_sekarang)+" ( "+result[a].follower.growth_tw+" % / "+addKoma(result[a].follower.num_of_growth_tw)+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>*Facebook*"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==1){
                                        el+="<li>1. "+result[a].unit_name+" "+convertMio(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" % / "+addKoma(result[a].follower.num_of_growth_fb)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==2){
                                        el+="<li>2. "+result[a].unit_name+" "+convertMio(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" % / "+addKoma(result[a].follower.num_of_growth_fb)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.rank_fb==3){
                                        el+="<li>3. "+result[a].unit_name+" "+convertMio(result[a].follower.fb_sekarang)+" ( "+result[a].follower.growth_fb+" % / "+addKoma(result[a].follower.num_of_growth_fb)+")</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>*Instagram*"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==1){
                                        el+="<li>1. "+result[a].unit_name+" "+convertMio(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" % / "+addKoma(result[a].follower.num_of_growth_ig)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==2){
                                        el+="<li>2. "+result[a].unit_name+" "+convertMio(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" % / "+addKoma(result[a].follower.num_of_growth_ig)+")</li>";
                                    }
                                }
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.ig==3 && result[a].follower.rank_ig==3){
                                        el+="<li>3. "+result[a].unit_name+" "+convertMio(result[a].follower.ig_sekarang)+" ( "+result[a].follower.growth_ig+" % / "+addKoma(result[a].follower.num_of_growth_ig)+")</li>";
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
                
                if($("#pilih").is(':checked')){
                    var pilih=$("#pilih").val();
                    var k=$("#kemarin").val();
                }else{
                    var pilih="";
                    var k="";
                }

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/highlight-target-achivement')}}",
                    type:"GET",
                    data:"tanggal="+tanggal+"&kemarin="+k+"&pilih="+pilih,
                    beforeSend:function(){
                        $("#tvAchievementbelow50").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<ul>"+
                            "<li>*Twitter*"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.acv_tw < 50){
                                        el+="<li>1. "+result[a].unit_name+" "+result[a].follower.acv_tw+" %</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>*Facebook*"+
                                "<ul>";
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.acv_fb < 50){
                                        el+="<li>1. "+result[a].unit_name+" "+result[a].follower.acv_fb+" %</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>*Instagram*"+
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
                var tanggal=$("#tanggal").val();
                
                if($("#pilih").is(':checked')){
                    var pilih=$("#pilih").val();
                    var k=$("#kemarin").val();
                }else{
                    var pilih="";
                    var k="";
                }

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/highlight-target-achivement')}}",
                    type:"GET",
                    data:"tanggal="+tanggal+"&kemarin="+k+"&pilih="+pilih,
                    beforeSend:function(){
                        $("#tvAchievementabove50").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<ul>"+
                            "<li>*Twitter*"+
                                "<ul>";
                                var no=0;
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.tw==1 && result[a].follower.acv_tw > 50){
                                        no++;
                                        el+="<li>"+no+". "+result[a].unit_name+" "+result[a].follower.acv_tw+" % #"+result[a].follower.rank_tw+"</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>*Facebook*"+
                                "<ul>";
                                var nos=0;
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.fb==2 && result[a].follower.acv_fb > 50){
                                        nos++;
                                        el+="<li>"+nos+". "+result[a].unit_name+" "+result[a].follower.acv_fb+" % #"+result[a].follower.rank_fb+"</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                            "<li>*Instagram*"+
                                "<ul>";
                                var nol=0;
                                for(a=0;a<result.length;a++){
                                    if(result[a].follower.ig==3 && result[a].follower.acv_ig > 50){
                                        nol++;
                                        el+="<li>"+nol+". "+result[a].unit_name+" "+result[a].follower.acv_ig+" % #"+result[a].follower.rank_ig+"</li>";
                                    }
                                }
                                el+="</ul>"+
                            "</li>"+
                        "</ul>";

                        el+="_note : the ranks are compared to 13 TVs in the industry_";
                        $("#tvAchievementabove50").empty().html(el);
                    },
                    error:function(){

                    }
                })
            }

            function growthProgram(){
                var tanggal=$("#tanggal2").val();
                var unit=$("#searchunit").val();

                if($("#pilih2").is(':checked')){
                    var pilih=$("#pilih2").val();
                    var k=$("#kemarin2").val();
                }else{
                    var pilih="";
                    var k="";
                }

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/all-program-growth')}}",
                    type:"GET",
                    data:"tanggal="+tanggal+"&kemarin="+k+"&pilih="+pilih+"&unit="+unit,
                    beforeSend:function(){
                        $("#growthProgram").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        $("#growthProgram").empty().html(result);
                        $(".sticky-header").floatThead({scrollingTop:50});
                    },
                    error:function(){
                        $("#growthProgram").empty().html("<div class='alert alert-danger'>Data Failed to Load</div>");
                    }
                })
            }

            $(document).on("change","#searchgroup",function(){
                var group=$("#searchgroup option:selected").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/list-unit')}}",
                    type:"GET",
                    data:"group="+group,
                    beforeSend:function(){
                        $("#divsearchunit").empty().html("<div class='alert alert-info'>Please Wait . . .</div>");
                    },
                    success:function(result){
                        var el="";
                        if(result.length>0){
                            el+="<div class='form-group'>"+
                                "<label class='control-label'>Unit</label>"+
                                '<select name="searchunit" id="searchunit" class="form-control">'+
                                '<option value="" selected>--Select Unit--</option>';
                                $.each(result,function(a,b){
                                    el+="<option value='"+b.id+"' data-group='"+b.group_unit_id+"'>"+b.unit_name+"</option>";
                                })
                            el+="</select>"+
                            '</div>';
                        }else{
                            var unit=@json($unit);

                            el+="<div class='form-group'>"+
                                "<label class='control-label'>Unit</label>"+
                                '<select name="searchunit" id="searchunit" class="form-control">'+
                                '<option value="" selected>--Select Unit--</option>';
                                $.each(unit,function(a,b){
                                    el+="<option value='"+b.id+"' data-group='"+b.group_unit_id+"'>"+b.unit_name+"</option>";
                                })
                            el+="</select>"+
                            '</div>';
                        }

                        $("#divsearchunit").empty().html(el);
                    },
                    error:function(){
                        
                    }
                })
            })

            $(document).on("change","#searchunit",function(){
                var unit=$("#searchunit option:selected").val();
                var selected=$(this).find('option:selected');
                var group=selected.data("group");

                $("#searchgroup").val(group);
            })

            $(document).on("submit","#formSearch",function(){
                growthProgram();
            })

            $(document).on("submit","#form",function(){
                var tanggal=$("#tanggal").val();

                if($('#pilih').is(':checked')){
                    var k=$("#kemarin").val();
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
                tvAchievementabove50();
            })
            
        })
    </script>
@endpush
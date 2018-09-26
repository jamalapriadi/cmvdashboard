@extends('layouts.coreui.main')

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
    <div class="card card-primary">
        <div class="card-header">Highlight</div>
        <div class="card-body">
            <div class="default-tab">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#highlight-tab1" role="tab" aria-controls="nav-home" aria-selected="true">HIGHLIGHT</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#highlight-tab2" role="tab" aria-controls="nav-profile" aria-selected="false">ALL PROGRAM GROWTH</a>
                    </div>
                </nav>
                <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="highlight-tab1" role="tabpanel" aria-labelledby="nav-home-tab">
                        <form class="form-horizontal" target="new target" id="form" onsubmit="return false;">
                            <div class="form-group row">
                                <label class="col-lg-2">Type Unit</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="icon-archive"></i></span>
                                        <select name="typeunit" id="typeunit" class="form-control" required>
                                            <option value="TV">TV</option>
                                            <option value="Publisher">Hardnews Portal</option>
                                            <option value="Radio">Radio</option>
                                            <option value="KOL">KOL</option>
                                            <option value="Animation Production">Animation Production</option>
                                            <option value="Production House">Production House</option>
                                            <option value="PAYTV,IPTV,OTT">PAYTV,IPTV,OTT</option>
                                            <option value="Newspaper">Newspaper</option>
                                            <option value="Magazine">Magazine</option>
                                            <option value="SMN Channel">SMN Channel</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2">Social Media</label>
                                <div class="col-lg-4">
                                    @foreach($sosmed as $row)
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="sosmed[]" value="{{$row->id}}" checked="checked">{{$row->sosmed_name}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2">Date</label>
                                <div class="col-lg-4">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                                        </div>
                                        <input class="form-control daterange-single-sekarang" data-value="{{date('Y/m/d')}}" name="tanggal" id="tanggal">
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
                            <div class="form-group row well">
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
                                <div id="showListData"></div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="highlight-tab2" role="tabpanel" aria-labelledby="nav-home-tab">
                        <fieldset>
                            <legend>Filter</legend>
                            
                            <form id="formSearch" onsubmit="return false;">
                                <div class="row" style="padding-left:10px;">
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
                                        <label class="control-label">Date</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                                            </div>
                                            <input class="form-control daterange-single-sekarang" data-value="{{date('Y/m/d')}}" name="tanggal2" id="tanggal2">
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
                                </div>
                            </form>
                        </fieldset>
                        <br>
                        <div id="growthProgram"></div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/floatthead/2.1.1/jquery.floatThead.js"></script>
    <script>
        $(function(){
            var sekarang = new Date();
            var kemarin = new Date(sekarang);
            kemarin.setDate(sekarang.getDate() - 1);

            $('.daterange-single-sekarang').pickadate({ 
                format: 'yyyy/mm/dd',
                formatSubmit: 'yyyy/mm/dd',
                max:true,
            });
            
            $(document).on("click","#pilih",function(){
                if($(this).is(':checked')){
                    var el="";
                    el+='<div class="form-group row">'+
                        '<label class="col-lg-2 control-label">Compare With</label>'+
                        '<div class="col-lg-4">'+
                            '<div class="input-group mb-3">'+
                                '<div class="input-group-prepend">'+
                                    '<span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>'+
                                '</div>'+
                                '<input class="form-control daterange-single-kemarin" data-value="'+kemarin+'" name="kemarin" id="kemarin">'+
                            '</div>'+
                        '</div>'+
                    '</div>';

                    $("#anotherDate").empty().html(el);

                    $('.daterange-single-kemarin').pickadate({ 
                        format: 'yyyy/mm/dd',
                        formatSubmit: 'yyyy/mm/dd',
                        max:true,
                    });
                }else{
                    $("#anotherDate").empty();
                }
            })

            $(document).on("click","#pilih2",function(){
                if($(this).is(':checked')){
                    var el="<div class='col-lg-8'>";
                    el+='<div class="form-group row">'+
                        '<label class="control-label">Compare With</label>'+
                        '<div class="input-group mb-3">'+
                            '<div class="input-group-prepend">'+
                                '<span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>'+
                            '</div>'+
                            '<input class="form-control daterange-single-kemarin2" data-value="'+kemarin+'" name="kemarin2" id="kemarin2">'+
                        '</div>'+
                    '</div></div>';

                    $("#anotherDate2").empty().html(el);

                    $('.daterange-single-kemarin2').pickadate({ 
                        format: 'yyyy/mm/dd',
                        formatSubmit: 'yyyy/mm/dd',
                        max:true,
                    });
                }else{
                    $("#anotherDate2").empty();
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
                    var k=num.toString();

                    return k.substring(0,5)+" Million";
                    // return num.toFixed(2)+" Million";
                }else if(number>=juta && number<milyar){
                    num=number/juta;
                    var tes=num.toString();
                    return tes.substring(0, 5)+" Mio";
                }else{
                    num=number/ribuan*100;
                    var k=num.toString();

                    return k.substring(0,5)+" K";

                    // return num.toFixed(0)+" K";
                }
            }
            
            function officialAccountAllTvByTotalFollowers(){
                var tanggal=$("#tanggal").val();
                var typeunit=$("#typeunit").val();

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
                    data:"tanggal="+tanggal+"&kemarin="+k+"&pilih="+pilih+"&typeunit="+typeunit,
                    beforeSend:function(){
                        $("#officalAccountAllTvByTotalFollowers").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<ul style='list-style-type:none'>";
                        $.each(sosmed,function(p,s){
                            if(s==1){
                                el+="<li>*Twitter*"+
                                    "<ul style='list-style-type:none'>";
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
                                "</li>";
                            }

                            if(s==2){
                                el+="<li>*Facebook*"+
                                    "<ul style='list-style-type:none'>";
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
                                "</li>";
                            }

                            if(s==3){
                                el+="<li>*Instagram*"+
                                    "<ul style='list-style-type:none'>";
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
                                "</li>";
                            }
                            
                            if(typeunit!="Publisher" || typeunit!="Radio"){
                                if(s==4){
                                    el+="<li>*Youtube*"+
                                        "<ul style='list-style-type:none'>";
                                        for(a=0;a<result.length;a++){
                                            if(result[a].follower.yt==4 && result[a].follower.rank_yt==1){
                                                el+="<li>1. "+result[a].unit_name+" "+convertMio(result[a].follower.yt_sekarang)+" ( "+result[a].follower.growth_yt+" / "+addKoma(result[a].follower.num_of_growth_yt)+")</li>";
                                            }
                                        }
                                        for(a=0;a<result.length;a++){
                                            if(result[a].follower.yt==4 && result[a].follower.rank_yt==2){
                                                el+="<li>2. "+result[a].unit_name+" "+convertMio(result[a].follower.yt_sekarang)+" ( "+result[a].follower.growth_yt+" / "+addKoma(result[a].follower.num_of_growth_yt)+")</li>";
                                            }
                                        }
                                        for(a=0;a<result.length;a++){
                                            if(result[a].follower.yt==4 && result[a].follower.rank_yt==3){
                                                el+="<li>3. "+result[a].unit_name+" "+convertMio(result[a].follower.yt_sekarang)+" ( "+result[a].follower.growth_yt+" / "+addKoma(result[a].follower.num_of_growth_yt)+")</li>";
                                            }
                                        }
                                        el+="</ul>"+
                                    "</li>";
                                }
                            }
                        })
                        el+="</ul>";
                        $("#officalAccountAllTvByTotalFollowers").empty().html(el);
                    },
                    error:function(){

                    }
                })
            }

            function groupOfficialAccountByTotalFollowers(){
                var tanggal=$("#tanggal").val();
                var typeunit=$("#typeunit").val();

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
                    data:"tanggal="+tanggal+"&kemarin="+k+"&pilih="+pilih+"&typeunit="+typeunit,
                    beforeSend:function(){
                        $("#groupOfficialAccountByTotalFollowers").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<ul style='list-style-type:none'>";
                        $.each(sosmed,function(p,s){
                            if(s==1){
                                el+="<li>*Twitter*"+
                                    "<ul style='list-style-type:none'>";
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
                                "</li>";
                            }

                            if(s==2){
                                el+="<li>*Facebook*"+
                                    "<ul style='list-style-type:none'>";
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
                                "</li>";
                            }

                            if(s==3){
                                el+="<li>*Instagram*"+
                                    "<ul style='list-style-type:none'>";
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
                                "</li>";
                            }
                            
                            if(typeunit!="Publisher" || typeunit!="Radio"){
                                if(s==4){
                                    el+="<li>*Youtube*"+
                                        "<ul style='list-style-type:none'>";
                                        for(a=0;a<result.length;a++){
                                            if(result[a].follower.yt==4 && result[a].follower.rank_yt==1){
                                                el+="<li>1. "+result[a].group_name+" "+convertMio(result[a].follower.yt_sekarang)+" ( "+result[a].follower.growth_yt+" % / "+addKoma(result[a].follower.num_of_growth_yt)+")</li>";
                                            }
                                        }
                                        for(a=0;a<result.length;a++){
                                            if(result[a].follower.yt==4 && result[a].follower.rank_yt==2){
                                                el+="<li>2. "+result[a].group_name+" "+convertMio(result[a].follower.yt_sekarang)+" ( "+result[a].follower.growth_yt+" % / "+addKoma(result[a].follower.num_of_growth_yt)+")</li>";
                                            }
                                        }
                                        for(a=0;a<result.length;a++){
                                            if(result[a].follower.yt==4 && result[a].follower.rank_yt==3){
                                                el+="<li>3. "+result[a].group_name+" "+convertMio(result[a].follower.yt_sekarang)+" ( "+result[a].follower.growth_yt+" % / "+addKoma(result[a].follower.num_of_growth_yt)+")</li>";
                                            }
                                        }
                                        el+="</ul>"+
                                    "</li>";
                                }
                            }
                        })
                            
                        el+="</ul>";
                        $("#groupOfficialAccountByTotalFollowers").empty().html(el);
                    },
                    error:function(){
                        $("#groupOfficialAccountByTotalFollowers").empty().html("<div class='alert alert-danger'>Load Data error</div>");
                    }
                })
            }

            function groupOverallAccount(){
                var tanggal=$("#tanggal").val();
                var typeunit=$("#typeunit").val();
                
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
                    data:"tanggal="+tanggal+"&kemarin="+k+"&pilih="+pilih+"&typeunit="+typeunit,
                    beforeSend:function(){
                        $("#groupOverallAccount").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<ul style='list-style-type:none'>";
                        var ep="<ul style='list-style-type:none'>";
                        $.each(sosmed,function(p,s){
                            if(s==1){
                                el+="<li>*Twitter*"+
                                    "<ul style='list-style-type:none'>";
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
                                "</li>";
                            }

                            if(s==2){
                                el+="<li>*Facebook*"+
                                    "<ul style='list-style-type:none'>";
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
                                "</li>";
                            }

                            if(s==3){
                                el+="<li>*Instagram*"+
                                    "<ul style='list-style-type:none'>";
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
                                "</li>";
                            }
                            
                            if(s==4){
                                el+="<li>*Youtube*"+
                                    "<ul style='list-style-type:none'>";
                                    for(a=0;a<result.length;a++){
                                        if(result[a].follower.yt==4 && result[a].follower.rank_yt==1){
                                            el+="<li>1. "+result[a].group_name+" "+convertMio(result[a].follower.yt_sekarang)+" ( "+result[a].follower.growth_yt+" % / "+addKoma(result[a].follower.num_of_growth_yt)+")</li>";
                                        }
                                    }
                                    for(a=0;a<result.length;a++){
                                        if(result[a].follower.yt==4 && result[a].follower.rank_yt==2){
                                            el+="<li>2. "+result[a].group_name+" "+convertMio(result[a].follower.yt_sekarang)+" ( "+result[a].follower.growth_yt+" % / "+addKoma(result[a].follower.num_of_growth_yt)+")</li>";
                                        }
                                    }
                                    for(a=0;a<result.length;a++){
                                        if(result[a].follower.yt==4 && result[a].follower.rank_yt==3){
                                            el+="<li>3. "+result[a].group_name+" "+convertMio(result[a].follower.yt_sekarang)+" ( "+result[a].follower.growth_yt+" % / "+addKoma(result[a].follower.num_of_growth_yt)+")</li>";
                                        }
                                    }
                                    el+="</ul>"+
                                "</li>";

                                ep+="<li>*Youtube*"+
                                    "<ul style='list-style-type:none'>";
                                    for(a=0;a<result.length;a++){
                                        if(result[a].follower.yt==4 && result[a].follower.rank_yt==1){
                                            ep+="<li>1. "+result[a].group_name+" "+convertMio(result[a].follower.yt_sekarang)+" ( "+result[a].follower.growth_yt+" % / "+addKoma(result[a].follower.num_of_growth_yt)+")</li>";
                                        }
                                    }
                                    for(a=0;a<result.length;a++){
                                        if(result[a].follower.yt==4 && result[a].follower.rank_yt==2){
                                            ep+="<li>2. "+result[a].group_name+" "+convertMio(result[a].follower.yt_sekarang)+" ( "+result[a].follower.growth_yt+" % / "+addKoma(result[a].follower.num_of_growth_yt)+")</li>";
                                        }
                                    }
                                    for(a=0;a<result.length;a++){
                                        if(result[a].follower.yt==4 && result[a].follower.rank_yt==3){
                                            ep+="<li>3. "+result[a].group_name+" "+convertMio(result[a].follower.yt_sekarang)+" ( "+result[a].follower.growth_yt+" % / "+addKoma(result[a].follower.num_of_growth_yt)+")</li>";
                                        }
                                    }
                                    ep+="</ul>"+
                                "</li>";
                            }
                        })
                        el+="</ul>";
                        $("#groupOverallAccount").empty().html(el);
                        $("#overallAccountYoutube").empty().html(ep);
                    },
                    error:function(){
                        $("#groupOverallAccount").empty().html("<div class='alert alert-danger'>Data failed to load</div>");
                    }
                })
            }

            function programAccountAllTv(){
                var tanggal=$("#tanggal").val();
                var typeunit=$("#typeunit").val();
                
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
                    data:"tanggal="+tanggal+"&kemarin="+k+"&pilih="+pilih+"&typeunit="+typeunit,
                    beforeSend:function(){
                        $("#programAccountAllTv").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<ul style='list-style-type:none'>";
                        $.each(sosmed,function(p,s){
                            if(s==1){
                                el+="<li>*Twitter*"+
                                    "<ul style='list-style-type:none'>";
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
                                "</li>";
                            }

                            if(s==2){
                                el+="<li>*Facebook*"+
                                    "<ul style='list-style-type:none'>";
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
                                "</li>";
                            }

                            if(s==3){
                                el+="<li>*Instagram*"+
                                    "<ul style='list-style-type:none'>";
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
                                "</li>";
                            }
                            
                            if(typeunit!="Publisher" || typeunit!="Radio"){
                                if(s==4){
                                    el+="<li>*Youtube*"+
                                        "<ul style='list-style-type:none'>";
                                        for(a=0;a<result.length;a++){
                                            if(result[a].follower.yt==4 && result[a].follower.rank_yt==1){
                                                el+="<li>1. "+result[a].unit_name+" "+convertMio(result[a].follower.yt_sekarang)+" ( "+result[a].follower.growth_yt+" % / "+addKoma(result[a].follower.num_of_growth_yt)+")</li>";
                                            }
                                        }
                                        for(a=0;a<result.length;a++){
                                            if(result[a].follower.yt==4 && result[a].follower.rank_yt==2){
                                                el+="<li>2. "+result[a].unit_name+" "+convertMio(result[a].follower.yt_sekarang)+" ( "+result[a].follower.growth_yt+" % / "+addKoma(result[a].follower.num_of_growth_yt)+")</li>";
                                            }
                                        }
                                        for(a=0;a<result.length;a++){
                                            if(result[a].follower.yt==4 && result[a].follower.rank_yt==3){
                                                el+="<li>3. "+result[a].unit_name+" "+convertMio(result[a].follower.yt_sekarang)+" ( "+result[a].follower.growth_yt+" % / "+addKoma(result[a].follower.num_of_growth_yt)+")</li>";
                                            }
                                        }
                                        el+="</ul>"+
                                    "</li>";
                                }
                            }
                        })
                            
                        el+="</ul>";
                        $("#programAccountAllTv").empty().html(el);
                    },
                    error:function(){
                        $("#programAccountAllTv").empty().html("<div class='alert alert-danger'>Data failed to load</div>");
                    }
                })
            }

            function tvAchievementbelow50(){
                var tanggal=$("#tanggal").val();
                var typeunit=$("#typeunit").val();
                
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
                    data:"tanggal="+tanggal+"&kemarin="+k+"&pilih="+pilih+"&typeunit="+typeunit,
                    beforeSend:function(){
                        $("#tvAchievementbelow50").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<ul style='list-style-type:none'>";
                        $.each(sosmed,function(p,s){
                            if(s==1){
                                el+="<li>*Twitter*"+
                                    "<ul style='list-style-type:none'>";
                                    for(a=0;a<result.length;a++){
                                        if(result[a].follower.tw==1 && result[a].follower.acv_tw < 50){
                                            el+="<li>1. "+result[a].unit_name+" "+result[a].follower.acv_tw+" %</li>";
                                        }
                                    }
                                    el+="</ul>"+
                                "</li>";
                            }

                            if(s==2){
                                el+="<li>*Facebook*"+
                                    "<ul style='list-style-type:none'>";
                                    for(a=0;a<result.length;a++){
                                        if(result[a].follower.fb==2 && result[a].follower.acv_fb < 50){
                                            el+="<li>1. "+result[a].unit_name+" "+result[a].follower.acv_fb+" %</li>";
                                        }
                                    }
                                    el+="</ul>"+
                                "</li>";
                            }

                            if(s==3){
                                el+="<li>*Instagram*"+
                                    "<ul style='list-style-type:none'>";
                                    for(a=0;a<result.length;a++){
                                        if(result[a].follower.ig==3 && result[a].follower.acv_ig < 50){
                                            el+="<li>1. "+result[a].unit_name+" "+result[a].follower.acv_ig+" %</li>";
                                        }
                                    }
                                    el+="</ul>"+
                                "</li>";
                            }
                            
                            if(typeunit!="Publisher" || typeunit!="Radio"){
                                if(s==4){
                                    el+="<li>*Youtube*"+
                                        "<ul style='list-style-type:none'>";
                                        for(a=0;a<result.length;a++){
                                            if(result[a].follower.yt==4 && result[a].follower.acv_yt < 50){
                                                el+="<li>1. "+result[a].unit_name+" "+result[a].follower.acv_yt+" %</li>";
                                            }
                                        }
                                        el+="</ul>"+
                                    "</li>";
                                }
                            }
                        })
                        el+="</ul>";
                        $("#tvAchievementbelow50").empty().html(el);
                    },
                    error:function(){
                        $("#tvAchievementbelow50").empty().html("<div class='alert alert-danger'>Failed to load data, internal server error</div>");
                    }
                })
            }

            function tvAchievementabove50(){
                var tanggal=$("#tanggal").val();
                var typeunit=$("#typeunit").val();
                
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
                    data:"tanggal="+tanggal+"&kemarin="+k+"&pilih="+pilih+"&typeunit="+typeunit,
                    beforeSend:function(){
                        $("#tvAchievementabove50").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<ul style='list-style-type:none'>";
                        $.each(sosmed,function(p,s){
                            if(s==1){
                                el+="<li>*Twitter*"+
                                    "<ul style='list-style-type:none'>";
                                    var no=0;
                                    var twitter=[];
                                    var cleantwitter=[];
                                    for(a=0;a<result.length;a++){
                                        if(result[a].follower.tw==1 && result[a].follower.acv_tw > 50){
                                            twitter.push({name:result[a].unit_name, acv_tw:result[a].follower.acv_tw, rank_tw:result[a].follower.rank_tw});
                                            // no++;
                                            // el+="<li>"+no+". "+result[a].unit_name+" "+result[a].follower.acv_tw+" % #"+result[a].follower.rank_tw+"</li>";
                                        }
                                    }
                                    cleantwitter = twitter.sort(function(a,b) {
                                        return a['rank_tw'] - b['rank_tw'];
                                    });

                                    $.each(cleantwitter,function(a,b){
                                        no++;
                                        el+="<li>"+no+". "+b.name+" "+b.acv_tw+" % #"+b.rank_tw+"</li>";
                                    })

                                    el+="</ul>"+
                                "</li>";
                            }

                            if(s==2){
                                el+="<li>*Facebook*"+
                                    "<ul style='list-style-type:none'>";
                                    var nos=0;
                                    var facebook=[];
                                    var cleanfacebook=[];
                                    for(a=0;a<result.length;a++){
                                        if(result[a].follower.fb==2 && result[a].follower.acv_fb > 50){
                                            facebook.push({name:result[a].unit_name, acv_fb:result[a].follower.acv_fb, rank_fb:result[a].follower.rank_fb});
                                        }
                                    }
                                    cleanfacebook = facebook.sort(function(a,b) {
                                        return a['rank_fb'] - b['rank_fb'];
                                    });

                                    $.each(cleanfacebook,function(a,b){
                                        nos++;
                                        el+="<li>"+nos+". "+b.name+" "+b.acv_fb+" % #"+b.rank_fb+"</li>";
                                    })

                                    el+="</ul>"+
                                "</li>";
                            }

                            if(s==3){
                                el+="<li>*Instagram*"+
                                    "<ul style='list-style-type:none'>";
                                    var nol=0;
                                    var instagram=[];
                                    var cleaninstagram=[];
                                    for(a=0;a<result.length;a++){
                                        if(result[a].follower.ig==3 && result[a].follower.acv_ig > 50){
                                            // nol++;
                                            // el+="<li>"+nol+". "+result[a].unit_name+" "+result[a].follower.acv_ig+" % #"+result[a].follower.rank_ig+"</li>";
                                            instagram.push({name:result[a].unit_name, acv_ig:result[a].follower.acv_ig, rank_ig:result[a].follower.rank_ig});
                                        }
                                    }

                                    cleaninstagram = instagram.sort(function(a,b) {
                                        return a['rank_ig'] - b['rank_ig'];
                                    });

                                    $.each(cleaninstagram,function(a,b){
                                        nol++;
                                        el+="<li>"+nol+". "+b.name+" "+b.acv_ig+" % #"+b.rank_ig+"</li>";
                                    })

                                    el+="</ul>"+
                                "</li>";
                            }

                            // if(s==4){
                            //     el+="<li>*Youtube*"+
                            //         "<ul style='list-style-type:none'>";
                            //         var not=0;
                            //         var youtube=[];
                            //         var cleanyoutube=[];
                            //         for(a=0;a<result.length;a++){
                            //             if(result[a].follower.yt==4 && result[a].follower.acv_yt > 50){
                            //                 // not++;
                            //                 // el+="<li>"+not+". "+result[a].unit_name+" "+result[a].follower.acv_yt+" % #"+result[a].follower.rank_yt+"</li>";
                            //                 youtube.push({name:result[a].unit_name, acv_yt:result[a].follower.acv_yt, rank_yt:result[a].follower.rank_yt});
                            //             }
                            //         }

                            //         cleanyoutube = youtube.sort(function(a,b) {
                            //             return a['rank_yt'] - b['rank_yt'];
                            //         });

                            //         $.each(cleanyoutube,function(a,b){
                            //             not++;
                            //             el+="<li>"+not+". "+b.name+" "+b.acv_yt+" % #"+b.rank_yt+"</li>";
                            //         })

                            //         el+="</ul>"+
                            //     "</li>";    
                            // }
                        })
                            
                        el+="</ul>";

                        el+="_note : the ranks are compared to 13 TVs in the industry_";
                        $("#tvAchievementabove50").empty().html(el);
                    },
                    error:function(){
                        $("#tvAchievementabove50").empty().html("<div class='alert alert-danger'>Failed to load data, internal server error</div>");
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

            function showAllGrowthProgram(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/all-program-growth')}}",
                    type:"GET",
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
            
            var sosmed=[];
            var typeunit="";

            $(document).on("submit","#form",function(e){
                var tanggal=$("#tanggal").val();
                var el="";

                typeunit=$("#typeunit").val();

                if($('#pilih').is(':checked')){
                    var k=$("#kemarin").val();
                    $("#panelTitle").empty().html("Report Highlights as of 2PM today ("+tanggal+") compared to ("+k+")");
                }else{
                    $("#panelTitle").empty().html("Report Highlights as of 2PM today ("+tanggal+")");
                }

                sosmed = $("input:checkbox:checked").map(function(){
                    return $(this).val();
                }).get();

                $("#panelShow").show();
                
                var nama="";
                var program="";
                switch(typeunit){
                    case "TV":
                            nama="TV";
                            program="Program";
                        break;
                    case "Publisher":
                            nama="HARDNEWS PUBLISHER";
                            program="Canal";
                        break;
                    case "Radio":
                            nama="Radio";
                            program="Program";
                        break;
                    case "KOL":
                            nama="KOL";
                            program="Artists";
                        break;
                    default:
                            nama="TV";
                            program="Program";
                        break;
                }

                el+='<ul style="list-style-type:none">'+
                    '<li>*1. Official* Account *Socmed All '+nama+'* By *Total Followers*'+
                        '<div id="officalAccountAllTvByTotalFollowers"></div>'+
                    '</li>'+
                    '<li>*2. Group Official* Account *Socmed* by *Total Followers*'+
                        '<div id="groupOfficialAccountByTotalFollowers"></div>'+
                    '</li>';

                    if(typeunit!="Radio"){
                        el+='<li>*3. Group Overall* Accounts ( Official + '+program+' ) *Socmed* by *Total Followers*'+
                            '<div id="groupOverallAccount"></div>'+
                        '</li>'+
                        '<li>*4. '+program+'* Accounts *Socmed ALL '+nama+'* by *Additional Followers* from yesterday'+
                            '<div id="programAccountAllTv"></div>'+
                        '</li>';
                    }
                    
                    if(typeunit=="TV"){
                        // el+="<li>*5. 4TV's* Followers *Achievement below 50%*"+
                        //     '<div id="tvAchievementbelow50"></div>'+
                        // '</li>';
                    }

                    if(typeunit=="TV"){
                        el+="<li>*5. Our 4TV's* Followers *Socmed Official Accounts* for those *Achievement above 50%*"+
                            '<div id="tvAchievementabove50"></div>'+
                            '<br>'+
                        '</li>';
                    }

                    if(typeunit=="TV" || typeunit=="Publisher" || typeunit=="Radio"){
                        var label6="";
                        var label7="";
                        if(typeunit=="TV"){
                            label6="*6. Overall* Accounts *Youtube All TV* by *Total Followers*";
                            label7="*7. Group Overall* Accounts ( Official + Program ) *Youtube* by *Total Followers*";
                        }else if(typeunit=="Publisher"){
                            label6="*5. Group Overall* Accounts ( Official + Canal ) *Youtube* by *Total Followers*";
                            label7="*6. Our Publisher's Youtube Overall Accounts* Followers";
                        }else if(typeunit=="Radio"){
                            label6="*6. Our Radio's Youtube Overall Accounts* Followers";
                        }else{

                        }

                        el+="<li>"+label6+"<div id='groupOverallYoutube'></div><br><li>";
                        
                        if(typeunit!="Radio"){
                            el+="<li>"+label7+"<div id='overallAccountYoutube'></div><br></li>";
                        }
                    }
                    
                el+='</ul>';

                $("#showListData").empty().html(el);
                officialAccountAllTvByTotalFollowers();
                groupOfficialAccountByTotalFollowers();
                groupOverallAccount();
                programAccountAllTv();
                groupOverallYoutube();
                
                if(typeunit=="TV"){
                    // tvAchievementbelow50();
                    tvAchievementabove50();
                }
            })

            function groupOverallYoutube(){
                var tanggal=$("#tanggal").val();
                var typeunit=$("#typeunit").val();
                
                if($("#pilih").is(':checked')){
                    var pilih=$("#pilih").val();
                    var k=$("#kemarin").val();
                }else{
                    var pilih="";
                    var k="";
                }

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/highlight-unit-overall-account')}}",
                    type:"GET",
                    data:"tanggal="+tanggal+"&kemarin="+k+"&pilih="+pilih+"&typeunit="+typeunit,
                    beforeSend:function(){
                        $("#groupOverallYoutube").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<ul style='list-style-type:none'>";
                        $.each(sosmed,function(p,s){
                            if(s==4){
                                el+="<li>*Youtube*"+
                                    "<ul style='list-style-type:none'>";
                                    for(a=0;a<result.length;a++){
                                        if(result[a].follower.yt==4 && result[a].follower.rank_yt==1){
                                            el+="<li>1. "+result[a].unit_name+" "+convertMio(result[a].follower.yt_sekarang)+" ( "+result[a].follower.growth_yt+" % / "+addKoma(result[a].follower.num_of_growth_yt)+")</li>";
                                        }
                                    }
                                    for(a=0;a<result.length;a++){
                                        if(result[a].follower.yt==4 && result[a].follower.rank_yt==2){
                                            el+="<li>2. "+result[a].unit_name+" "+convertMio(result[a].follower.yt_sekarang)+" ( "+result[a].follower.growth_yt+" % / "+addKoma(result[a].follower.num_of_growth_yt)+")</li>";
                                        }
                                    }
                                    for(a=0;a<result.length;a++){
                                        if(result[a].follower.yt==4 && result[a].follower.rank_yt==3){
                                            el+="<li>3. "+result[a].unit_name+" "+convertMio(result[a].follower.yt_sekarang)+" ( "+result[a].follower.growth_yt+" % / "+addKoma(result[a].follower.num_of_growth_yt)+")</li>";
                                        }
                                    }
                                    el+="</ul>"+
                                "</li>";
                            }
                        })
                        el+="</ul>";

                        $("#groupOverallYoutube").empty().html(el);
                    },
                    errors:function(){
                        
                    }
                })
            }

            showAllGrowthProgram();
            
        })
    </script>
@stop
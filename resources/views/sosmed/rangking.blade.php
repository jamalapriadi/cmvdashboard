@extends('layouts.sosmed')

@section('title')
    Dashboard
@endsection

@section('extra-style')

@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">1. RANK OF OFFICIAL ACCOUNT ALL GROUP <span style="color:red">BY TOTAL FOLLOWERS</span></h6>
        </div>

        <div class="panel-body">
            <div id="rangAllAccountGroup"></div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">2. RANK OF OFFICIAL ACCOUNT ALL TV <span style="color:red">BY TOTAL FOLLOWERS</span></h6>
        </div>

        <div class="panel-body">
            <div id="rangAllAccountTv"></div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">3. RANK OF GROWTH FROM YESTERDAY OFFICIAL ACCOUNT <span style="color:red">ALL TV BY % GROWTH</span></h6>
        </div>

        <div class="panel-body">
            <div id="growthAllAccountTv"></div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">4. RANK OF GROWTH FROM YESTERDAY OFFICIAL ACCOUNT <span style="color:red"> ALL GROUP BY % GROWTH</span></h6>
        </div>

        <div class="panel-body">
            <div id="growthAllGrowthTv"></div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">5. RANK OF OVERALL ACCOUNT <span style="color:red"> ALL BY TV % FOLLOWERS</span></h6>
        </div>

        <div class="panel-body">
            <div id="rankOfOverallAccountAllTv"></div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">6. RANK OF OVERALL ACCOUNT <span style="color:red"> ALL GROUP TOTAL FOLLOWERS</span></h6>
        </div>

        <div class="panel-body">
            <div id="rankOfOverallGroup"></div>
        </div>
    </div>
    
@endsection

@push('extra-script')
    <script>
        $(function(){
            function rangAllAccountGroup(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/rank-of-official-account-all-group')}}",
                    type:"GET",
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
                            "<tbody>";
                                $.each(result,function(a,b){
                                    el+="<tr>"+
                                        "<td>"+b.group_name+"</td>"+
                                        "<td>"+b.follower.growth_twitter+"</td>"+
                                        "<td>"+b.follower.tw_sekarang+"</td>"+
                                        "<td>"+b.follower.rank_tw+"</td>"+
                                        "<td>"+b.follower.growth_fb+"</td>"+
                                        "<td>"+b.follower.fb_sekarang+"</td>"+
                                        "<td>"+b.follower.rank_fb+"</td>"+
                                        "<td>"+b.follower.growth_ig+"</td>"+
                                        "<td>"+b.follower.ig_sekarang+"</td>"+
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
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/rank-of-official-account-all-tv')}}",
                    type:"GET",
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
                            "<tbody>";
                                $.each(result,function(a,b){
                                    el+="<tr>"+
                                        "<td>"+b.unit_name+"</td>"+
                                        "<td>"+b.follower.growth_twitter+"</td>"+
                                        "<td>"+b.follower.tw_sekarang+"</td>"+
                                        "<td>"+b.follower.rank_tw+"</td>"+
                                        "<td>"+b.follower.growth_fb+"</td>"+
                                        "<td>"+b.follower.fb_sekarang+"</td>"+
                                        "<td>"+b.follower.rank_fb+"</td>"+
                                        "<td>"+b.follower.growth_ig+"</td>"+
                                        "<td>"+b.follower.ig_sekarang+"</td>"+
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
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/rank-growth-from-yesterday-official-account-all-tv')}}",
                    type:"GET",
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
                            "<tbody>";
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
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/rank-growth-from-yesterday-official-group')}}",
                    type:"GET",
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
                            "<tbody>";
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
                var el="";

                $.ajax({
                    url:"{{URL::to('sosmed/data/report/rank-overall-account-all-tv-by-total-followers')}}",
                    type:"GET",
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
                            "<tbody>";
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
                                        "<td>"+b.followers.tw.total+"</td>"+
                                        "<td>"+b.followers.tw.rank+"</td>"+
                                        "<td>";
                                            if(b.followers.fb.growth!=null){
                                                el+=b.followers.fb.growth;
                                            }else{
                                                el+=0;
                                            }
                                        el+="</td>"+
                                        "<td>"+b.followers.fb.total+"</td>"+
                                        "<td>"+b.followers.fb.rank+"</td>"+
                                        "<td>";
                                            if(b.followers.ig.growth!=null){
                                                el+=b.followers.ig.growth;
                                            }else{
                                                el+=0;
                                            }
                                        el+="</td>"+
                                        "<td>"+b.followers.ig.total+"</td>"+
                                        "<td>"+b.followers.ig.rank+"</td>"+
                                    "</tr>";
                                })
                            el+="</tbody>"+
                        "</table>";
                        $("#rankOfOverallAccountAllTv").empty().html(el);
                    },
                    error:function(){

                    }
                })
            }

            rangAllAccountGroup();
            rangAllAccountTv();
            growthAllAccountTv();
            growthAllGroupTv();
            rankOfOverallAccountAllTv();
        })
    </script>
@endpush
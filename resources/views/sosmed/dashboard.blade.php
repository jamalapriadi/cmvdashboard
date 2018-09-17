@extends('layouts.coreui.main')

@section('extra-style')
    <style>
        #zingchart-1 {
            height: 400px;
            width: 960px;
        }

        #zingchart-2 {
            height: 400px;
            width: 960px;
        }

        .zingchart-tooltip {
            padding: 7px 5px;
            border-radius: 1px;
            line-height: 20px;
            background-color: #fff;
            border: 1px solid #dcdcdc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            -webkit-font-smoothing: antialiased;
        }
        .zingchart-tooltip .scalex-value {
            font-size: 14px !important;
            font-weight: normal !important;
            line-height: 24px;
            color: #838383;
        }
        .zingchart-tooltip .scaley-value {
            color: #4184f3;
            font-size: 24px !important;
            font-weight: normal !important;
        }

        .zc-ref {
            display: none;
        }
    </style>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">CROSS CHANNEL</h4>
                    <div class="small text-muted">{{date('d F Y')}}</div>
                </div>
                
                <div class="col-sm-7 d-none d-md-block">
                    <div class="btn-group btn-group-toggle float-right mr-3" data-toggle="buttons">
                        
                    </div>

                    <div class="btn-group btn-group-toggle float-right mr-3" data-toggle="buttons">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="" class="control-label">Tanggal</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                            </div>
                            <input type="text" id="tanggal" data-value="{{date('Y/m/d')}}" name="tanggal" class="form-control daterange-single">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="" class="control-label">Filter</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="icon-filter3"></i></span>
                            </div>
                            <select name="filter" id="filter" class="form-control bg-primary">
                                <option value="all">All</option>
                                <option value="official">Official</option>
                                <option value="program">Program</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="" class="control-label">Type Unit</label>
                        <select name="typeunit" id="typeunit" class="form-control">
                            <option value="TV">TV</option>
                            <option value="Publisher">Publisher</option>
                            <option value="Radio">Radio</option>
                            <option value="KOL">KOL</option>
                            <option value="Animation Production">Animation Production</option>
                            <option value="Production House">Production House</option>
                            <option value="PAYTV,IPTV,OOT">PAYTV,IPTV,OOT</option>
                            <option value="Newspaper">Newspaper</option>
                            <option value="Magazine">Magazine</option>
                            <option value="SMN Channel">SMN Channel</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="" class="control-label"></label>
                        <button class="btn btn-primary" id="filterOfficial" style="margin-top:25px;"><i class="icon-filter3"></i> Filter</button>
                    </div>
                </div>
            </div>
            
            <hr>
            <div id="zingchart-1"><a class="zc-ref" href="https://www.zingchart.com/">Charts by ZingChart</a></div>

            <div id="showUnit"></div>
        </div>

        <div class="card-footer">
            <div class="row text-center">
                <div class="col-sm-12 col-md mb-sm-3 mb-0">
                    <div class="text-muted">TOTAL TWITTER</div>
                    <strong id="total_twitter_tier">0</strong>
                </div>

                <div class="col-sm-12 col-md mb-sm-3 mb-0">
                    <div class="text-muted">TOTAL FACEBOOK</div>
                    <strong id="total_facebook_tier">0</strong>
                </div>

                <div class="col-sm-12 col-md mb-sm-3 mb-0">
                    <div class="text-muted">TOTAL INSTAGRAM</div>
                    <strong id="total_instagram_tier">0</strong>
                </div>

                <div class="col-sm-12 col-md mb-sm-3 mb-0">
                    <div class="text-muted">TOTAL YOUTUBE</div>
                    <strong id="total_youtube_tier">0</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0" id="namagroup">MNC GROUP</h4>
                    <div class="small text-muted" id="grouptanggal">{{date('d F Y')}}</div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="control-label">Group</label>
                        <select name="group" id="group" class="form-control">
                            @foreach($group as $row)
                                <option value="{{$row->id}}">{{$row->group_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="" class="control-label">Type</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="icon-filter3"></i></span>
                            </div>
                            <select name="type" id="typegroup" class="form-control bg-primary">
                                <option value="all">All</option>
                                <option value="official">Official</option>
                                <option value="program">Program</option>
                                <option value="artist">Artist</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="" class="control-label">Tanggal</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                            </div>
                            <input type="text" id="tanggalgroup" data-value="{{date('Y/m/d')}}" name="tanggalgroup" class="form-control daterange-single">
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="" class="control-label"></label>
                        <button class="btn btn-primary" id="filtergroup" style="margin-top:25px;"><i class="icon-filter3"></i> Filter</button>
                    </div>
                </div>
            </div>

            <hr>

            <div id="zingchart-2"></div>
            <div id="showGroup"></div>
        </div>

        <div class="card-footer">
            <div class="row text-center">
                <div class="col-sm-12 col-md mb-sm-3 mb-0">
                    <div class="text-muted">TOTAL TWITTER</div>
                    <strong id="total_twitter_group">0</strong>
                </div>

                <div class="col-sm-12 col-md mb-sm-3 mb-0">
                    <div class="text-muted">TOTAL FACEBOOK</div>
                    <strong id="total_facebook_group">0</strong>
                </div>

                <div class="col-sm-12 col-md mb-sm-3 mb-0">
                    <div class="text-muted">TOTAL INSTAGRAM</div>
                    <strong id="total_instagram_group">0</strong>
                </div>

                <div class="col-sm-12 col-md mb-sm-3 mb-0">
                    <div class="text-muted">TOTAL YOUTUBE</div>
                    <strong id="total_youtube_group">0</strong>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card card-primary">
        <div class="card-header">SOCMED LIVE</div>
        <div class="card-body">
            <form action="#">
                <div class="form-group">
                    <label for="" class="col-lg-2 control-label">Unit</label>
                    <div class="col-lg-3">
                        <select name="unit" id="unit" class="form-control">
                            @foreach($user->unit as $row)
                                <option value="{{$row->id}}">{{$row->unit_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            <div id="divLiveSocmed"></div>
        </div>
    </div>
@stop

@section('js')
    <script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
    <script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9","ee6b7db5b51705a13dc2339db3edaf6d"];</script>
    <script>
        $(function(){
            var group=$("#group").val();
            var namagroup=$("#group option:selected").text();

            $("#namagroup").html(namagroup);

            $('.daterange-single').pickadate({
                format: 'yyyy/mm/dd',
                formatSubmit: 'yyyy/mm/dd',
                max:true,
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

            function showTear1(){
                var tanggal=$("#tanggal").val();
                var filter=$("#filter").val();
                var typeunit=$("#typeunit").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/chart/chart-by-tier')}}",
                    type:"GET",
                    data:"tanggal="+tanggal+"&filter="+filter+"&typeunit="+typeunit,
                    beforeSend:function(){
                        $("#zingchart-1").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        $("#zingchart-1").empty();
                        var primaryColor = "#4184F3";
                        var primaryColorHover = "#3a53c5";
                        var secondaryColor = '#DCDCDC'
                        var scaleTextColor = '#999';

                        var labels1=[];
                        var facebook1=[];
                        var twitter1=[];
                        var instagram1=[];
                        var youtube1=[];

                        var labels2=[];
                        var facebook2=[];
                        var twitter2=[];
                        var instagram2=[];

                        var labels3=[];
                        var facebook3=[];
                        var twitter3=[];
                        var instagram3=[];

                        var labels4=[];
                        var facebook4=[];
                        var twitter4=[];
                        var instagram4=[];
                        console.log(result);
                        $.each(result.chart,function(a,b){
                            // if(b.tier==1){
                                
                            // }

                            // if(b.tier==2){
                            //     if(b.id!='tidak'){
                            //         labels2.push(b.unit_name);

                            //         facebook2.push(parseFloat(b.total_facebook));
                            //         twitter2.push(parseFloat(b.total_twitter));
                            //         instagram2.push(parseFloat(b.total_instagram));
                            //     }
                            // }

                            // if(b.tier==3){
                            //     labels3.push(b.unit_name);

                            //     facebook3.push(parseFloat(b.total_facebook));
                            //     twitter3.push(parseFloat(b.total_twitter));
                            //     instagram3.push(parseFloat(b.total_instagram));
                            // }

                            // if(b.tier==4){
                            //     labels4.push(b.unit_name);

                            //     facebook4.push(parseFloat(b.total_facebook));
                            //     twitter4.push(parseFloat(b.total_twitter));
                            //     instagram4.push(parseFloat(b.total_instagram));
                            // }
                            if(b.id!=null){
                                if(b.id!='tidak'){
                                    if(b.id!=4){
                                        labels1.push(b.unit_name);

                                        facebook1.push(parseFloat(b.total_facebook));
                                        twitter1.push(parseFloat(b.total_twitter));
                                        instagram1.push(parseFloat(b.total_instagram));
                                        youtube1.push(parseFloat(b.total_youtube));
                                    }else{
                                        $.each(result.inews,function(c,d){
                                            labels1.push("INEWS 4TV");

                                            facebook1.push(parseFloat(d.total_facebook));
                                            twitter1.push(parseFloat(d.total_twitter));
                                            instagram1.push(parseFloat(d.total_instagram));
                                            youtube1.push(parseFloat(d.total_youtube));
                                        })
                                    }
                                    
                                }
                            }
                        })
                        
                        /* tear 1 */
                        var chartConfig1 = {
                            "type": "hbar",
                            "plot": {
                                "stacked": true,
                                "thousands-separator":",",
                                "valueBox":{
                                    "text":"%total",
                                    "rules": [
                                        {
                                            "rule": '%stack-top == 0',
                                            "visible": 0
                                        }
                                    ]
                                }
                            },
                            "plotarea": {
                                // "margin": "2% 2% 15% 20%"
                                margin: 'dynamic dynamic dynamic dynamic',
                            },
                            "backgroundColor": "#fff",
                            "scaleX": {
                                "values": labels1,
                                "lineWidth": 0,
                                "lineColor":"none",
                                "tick": {
                                    "visible": false
                                },
                                "guide": {
                                    "visible": false
                                },
                                "item": {
                                    "font-size": "9px",
                                    "font-color": "#222222"
                                }
                            },
                            "scale-y":{
                                "line-color":"#333",
                                "thousands-separator":",",
                                "guide":{
                                    "line-style":"solid",
                                    "line-color":"#c4c4c4",
                                    visible:false
                                },
                                "tick":{
                                    "line-color":"#333",
                                }
                            },
                            "legend": {
                                "layout": "float",
                                "toggle-action":"remove",
                                "shadow": 0,
                                "adjust-layout": true,
                                "align": "center",
                                "vertical-align": "bottom",
                                "marker": {
                                    "type": "match",
                                    "show-line": true,
                                    "line-width": 4,
                                    "shadow": "none"
                                }
                            },
                            "tooltip": {
                                "htmlMode": true,
                                "backgroundColor": "none",
                                "padding": 0,
                                "placement": "node:center",
                                "text": "<div  class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v <\/div><\/div>"
                            },
                            "series": [
                                {
                                    "values": twitter1,
                                    "text": "Twitter",
                                    "background-color": "#008ef6"
                                },
                                {
                                    "values": facebook1,
                                    "text": "Facebook",
                                    "background-color": "#5054ab"
                                },
                                {
                                    "values": instagram1,
                                    "text": "Instagram",
                                    "background-color": "#a200b2"
                                },
                                {
                                    "values": youtube1,
                                    "text": "Youtube",
                                    "background-color": "#222222"
                                }
                            ]
                        };

                        chartConfig1.plot.animation = {
                            'method': 'LINEAR',
                            'delay': 0,
                            'effect': 'ANIMATION_EXPAND_VERTICAL',
                            'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                            'speed': 10
                        }

                        zingchart.render({
                            id: 'zingchart-1',
                            data: chartConfig1,
                            output: 'canvas',
                            height:'100%',
                            width:'100%'
                        });
                        /* end tear 1 */
                        
                        el+='<div class="table-responsive">'+
                            '<table id="tableunit" class="table table-responsive-sm table-hover table-outline mb-0">'+
                                '<thead class="thead-light">'+
                                    '<tr class="text-center">'+
                                        '<th>No.</th>'+
                                        '<th>Unit Name</th>'+
                                        '<th>Twitter</th>'+
                                        '<th>Facebook</th>'+
                                        '<th>Instagram</th>'+
                                        '<th>Youtube</th>'+
                                    '</tr>'+
                                '</thead>'+
                                '<tbody>';
                                    var no=0;
                                    result.chart.sort(function(a, b) {
                                        return a['group_unit_id'] - b['group_unit_id'];
                                    });
                                    $.each(result.chart,function(a,b){
                                        no++;
                                        if(b.id!=null){
                                            if(b.id!='tidak'){
                                                if(b.id!=4){
                                                    el+="<tr>"+
                                                        "<td>"+no+"</td>"+
                                                        "<td>"+b.unit_name+"</td>"+
                                                        "<td>"+addKoma(b.total_twitter)+"</td>"+
                                                        "<td>"+addKoma(b.total_facebook)+"</td>"+
                                                        "<td>"+addKoma(b.total_instagram)+"</td>"+
                                                        "<td>"+addKoma(b.total_youtube)+"</td>"+
                                                    "</tr>";
                                                }else{
                                                    $.each(result.inews,function(c,d){
                                                            el+="<tr>"+
                                                                "<td>"+no+"</td>"+
                                                                "<td>INEWS 4TV</td>"+
                                                                "<td>"+addKoma(d.total_twitter)+"</td>"+
                                                                "<td>"+addKoma(d.total_facebook)+"</td>"+
                                                                "<td>"+addKoma(d.total_instagram)+"</td>"+
                                                                "<td>"+addKoma(d.total_youtube)+"</td>"+
                                                            "</tr>";
                                                    })
                                                }
                                                
                                            }
                                        }else{
                                            
                                            $("#total_twitter_tier").html(addKoma(b.total_twitter));
                                            $("#total_facebook_tier").html(addKoma(b.total_facebook));
                                            $("#total_instagram_tier").html(addKoma(b.total_instagram));
                                            $("#total_youtube_tier").html(addKoma(b.total_youtube));
                                        }
                                    })
                                el+='</tbody>'+
                            '</table>'+
                        '</div>';

                        $("#showUnit").empty().html(el);

                        $("#tableunit").DataTable();

                    }
                })
            }

            function liveSocmed(){
                var unit=$("#unit").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/live-socmed-by-id')}}/"+unit,
                    type:"GET",
                    data:"type=corporate",
                    beforeSend:function(){
                        $("#divLiveSocmed").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        $("#divLiveSocmed").empty().html(result);
                    },
                    errors:function(){

                    }
                })
            }

            function showgroup(){
                var tanggal=$("#tanggalgroup").val();
                var filter=$("#typegroup").val();
                var group=$("#group").val();
                $("#grouptanggal").empty().html(tanggal);

                $.ajax({
                    url:"{{URL::to('sosmed/data/list-official-program-by-group')}}/"+group,
                    data:"tanggal="+tanggal+"&filter="+filter,
                    type:"GET",
                    beforeSend:function(){
                        $("#zingchart-2").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>");
                        $("#showGroup").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>");
                    },
                    success:function(result){
                        $("#zingchart-2").empty();
                        var primaryColor = "#4184F3";
                        var primaryColorHover = "#3a53c5";
                        var secondaryColor = '#DCDCDC'
                        var scaleTextColor = '#999';

                        var labels1=[];
                        var facebook1=[];
                        var twitter1=[];
                        var instagram1=[];
                        var youtube1=[];

                        var labels2=[];
                        var facebook2=[];
                        var twitter2=[];
                        var instagram2=[];

                        var labels3=[];
                        var facebook3=[];
                        var twitter3=[];
                        var instagram3=[];

                        var labels4=[];
                        var facebook4=[];
                        var twitter4=[];
                        var instagram4=[];
                        
                        $.each(result.chart,function(a,b){
                            /* id null adalah totalnya */
                            if(b.id!=null){
                                if(b.id!=4){
                                    labels1.push(b.unit_name);

                                    facebook1.push(parseFloat(b.total_facebook));
                                    twitter1.push(parseFloat(b.total_twitter));
                                    instagram1.push(parseFloat(b.total_instagram));
                                    youtube1.push(parseFloat(b.total_youtube));
                                }else{
                                    $.each(result.inews,function(c,d){
                                        labels1.push("INEWS 4TV");

                                        facebook1.push(parseFloat(d.total_facebook));
                                        twitter1.push(parseFloat(d.total_twitter));
                                        instagram1.push(parseFloat(d.total_instagram));
                                        youtube1.push(parseFloat(d.total_youtube));
                                    })
                                }
                            }
                            
                        })
                        
                        /* tear 1 */
                        var chartConfig1 = {
                            "type": "hbar",
                            "plot": {
                                "stacked": true,
                                "thousands-separator":",",
                                "valueBox":{
                                    "text":"%total",
                                    "rules": [
                                        {
                                            "rule": '%stack-top == 0',
                                            "visible": 0
                                        }
                                    ]
                                }
                            },
                            "plotarea": {
                                // "margin": "2% 2% 15% 20%"
                                margin: 'dynamic dynamic dynamic dynamic',
                            },
                            "backgroundColor": "#fff",
                            "scaleX": {
                                "values": labels1,
                                "lineWidth": 0,
                                "lineColor":"none",
                                "tick": {
                                    "visible": false
                                },
                                "guide": {
                                    "visible": false
                                },
                                "item": {
                                    "font-size": "9px",
                                    "font-color": "#222222"
                                }
                            },
                            "scale-y":{
                                "line-color":"#333",
                                "thousands-separator":",",
                                "guide":{
                                    "line-style":"solid",
                                    "line-color":"#c4c4c4",
                                    visible:false
                                },
                                "tick":{
                                    "line-color":"#333",
                                }
                            },
                            "legend": {
                                "layout": "float",
                                "toggle-action":"remove",
                                "shadow": 0,
                                "adjust-layout": true,
                                "align": "center",
                                "vertical-align": "bottom",
                                "marker": {
                                    "type": "match",
                                    "show-line": true,
                                    "line-width": 4,
                                    "shadow": "none"
                                }
                            },
                            "tooltip": {
                                "htmlMode": true,
                                "backgroundColor": "none",
                                "padding": 0,
                                "placement": "node:center",
                                "text": "<div  class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v <\/div><\/div>"
                            },
                            "series": [
                                {
                                    "values": twitter1,
                                    "text": "Twitter",
                                    "background-color": "#008ef6"
                                },
                                {
                                    "values": facebook1,
                                    "text": "Facebook",
                                    "background-color": "#5054ab"
                                },
                                {
                                    "values": instagram1,
                                    "text": "Instagram",
                                    "background-color": "#a200b2"
                                },
                                {
                                    "values": youtube1,
                                    "text": "Youtube",
                                    "background-color": "#222222"
                                }
                            ]
                        };

                        chartConfig1.plot.animation = {
                            'method': 'LINEAR',
                            'delay': 0,
                            'effect': 'ANIMATION_EXPAND_VERTICAL',
                            'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                            'speed': 10
                        }

                        zingchart.render({
                            id: 'zingchart-2',
                            data: chartConfig1,
                            output: 'canvas',
                            height:'100%',
                            width:'100%'
                        });

                        var el="";
                        el+='<div class="table-responsive">'+
                            '<table id="tablegroup" class="table table-responsive-sm table-hover table-outline mb-0">'+
                                '<thead class="thead-light">'+
                                    '<tr class="text-center">'+
                                        '<th>No.</th>'+
                                        '<th>Unit Name</th>'+
                                        '<th>Twitter</th>'+
                                        '<th>Facebook</th>'+
                                        '<th>Instagram</th>'+
                                        '<th>Youtube</th>'+
                                    '</tr>'+
                                '</thead>'+
                                '<tbody>';
                                    var no=0;

                                    if(filter=="program"){
                                        result.chart.sort(function(a, b) {
                                            return b['businesss_unit_id'] - a['businesss_unit_id'];
                                        });
                                    }else{
                                        result.chart.sort(function(a, b) {
                                            return a['id'] - b['id'];
                                        });
                                    }

                                    $.each(result.chart,function(a,b){
                                        no++;
                                        if(b.id!=null){
                                            if(b.id!=4){
                                                el+="<tr>"+
                                                    "<td>"+no+"</td>"+
                                                    "<td>"+b.unit_name+"</td>"+
                                                    "<td>"+addKoma(b.total_twitter)+"</td>"+
                                                    "<td>"+addKoma(b.total_facebook)+"</td>"+
                                                    "<td>"+addKoma(b.total_instagram)+"</td>"+
                                                    "<td>"+addKoma(b.total_youtube)+"</td>"+
                                                "</tr>";
                                            }else{
                                                $.each(result.inews,function(c,d){
                                                        el+="<tr>"+
                                                            "<td>"+no+"</td>"+
                                                            "<td>INEWS 4TV</td>"+
                                                            "<td>"+addKoma(d.total_twitter)+"</td>"+
                                                            "<td>"+addKoma(d.total_facebook)+"</td>"+
                                                            "<td>"+addKoma(d.total_instagram)+"</td>"+
                                                            "<td>"+addKoma(d.total_youtube)+"</td>"+
                                                        "</tr>";
                                                })
                                            }    
                                        }else{
                                            
                                            $("#total_twitter_group").html(addKoma(b.total_twitter));
                                            $("#total_facebook_group").html(addKoma(b.total_facebook));
                                            $("#total_instagram_group").html(addKoma(b.total_instagram));
                                            $("#total_youtube_group").html(addKoma(b.total_youtube));
                                        }
                                        
                                    })
                                el+='</tbody>'+
                            '</table>'+
                        '</div>';

                        $("#showGroup").empty().html(el);

                        $("#tablegroup").DataTable();
                    },
                    errors:function(){

                    }
                })
            }

            $(document).on("click","#filterOfficial",function(){
                showTear1();
            })

            $(document).on("change","#unit",function(){
                liveSocmed();
            })

            $(document).on("click","#filtergroup",function(){
                var nm=$("#group option:selected").text();
                $("#namagroup").empty().html(nm);

                showgroup();
            })

            showTear1();
            showgroup();
            liveSocmed();
        })
    </script>
@stop
@extends('layouts.coreui.main')

@section('extra-style')
    <style>
        #zingchart-1 {
            height: 200px;
            width: 480px;
        }

        #zingchart-2 {
            height: 200px;
            width: 480px;
        }

        #zingchart-3 {
            height: 200px;
            width: 480px;
        }

        #zingchart-4 {
            height: 200px;
            width: 480px;
        }

        #chartOfficial{
            height: 400px;
            width: 960px;
        }

        #growthProgram{
            height: 400px;
            width: 960px;
        }

        #officialTwitter{
            height: 400px;
            width: 480px;
        }

        #top10{
            height: 400px;
            width: 480px;
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
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                            </div>
                            <input type="text" id="tanggal" data-value="{{date('Y/m/d')}}" name="tanggal" class="form-control daterange-single">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-default">
                        <div class="card-header">Tear 1</div>
                        <div class="card-body">
                            <div id="zingchart-1"><a class="zc-ref" href="https://www.zingchart.com/">Charts by ZingChart</a></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card card-default">
                        <div class="card-header">Tear 2</div>
                        <div class="card-body">
                            <div id="zingchart-2"><a class="zc-ref" href="https://www.zingchart.com/">Charts by ZingChart</a></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card card-default">
                        <div class="card-header">Tear 3</div>
                        <div class="card-body">
                            <div id="zingchart-3"><a class="zc-ref" href="https://www.zingchart.com/">Charts by ZingChart</a></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card card-default">
                        <div class="card-header">Tear 4</div>
                        <div class="card-body">
                            <div id="zingchart-4"><a class="zc-ref" href="https://www.zingchart.com/">Charts by ZingChart</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-default">
        <div class="card-header">Official</div>
        <div class="card-body">
            <div id="chartOfficial"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card card-default">
                <div class="card-header">Official Twitter All TV</div>
                <div id="officialTwitter"></div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-default">
                <div class="card-header">TOP 10 Twitter Program</div>
                <div id="top10"></div>
            </div>
        </div>
    </div>

    <div class="card card-default">
        <div class="card-header">Growth Twitter Program</div>
        <div id="growthProgram"></div>
    </div>
@stop

@section('js')
    <script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
    <script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9","ee6b7db5b51705a13dc2339db3edaf6d"];</script>

    <script>
        $(function(){
            $('.daterange-single').pickadate({
                format: 'yyyy/mm/dd',
                formatSubmit: 'yyyy/mm/dd',
                max:true,
            });

            function showTear1(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/chart/chart-by-tier/1')}}",
                    type:"GET",
                    beforeSend:function(){

                    },
                    success:function(result){
                        var primaryColor = "#4184F3";
                        var primaryColorHover = "#3a53c5";
                        var secondaryColor = '#DCDCDC'
                        var scaleTextColor = '#999';

                        var labels1=[];
                        var facebook1=[];
                        var twitter1=[];
                        var instagram1=[];

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
                        $.each(result,function(a,b){
                            if(b.tier==1){
                                labels1.push(b.unit_name);

                                facebook1.push(parseFloat(b.total_facebook));
                                twitter1.push(parseFloat(b.total_twitter));
                                instagram1.push(parseFloat(b.total_instagram));
                            }

                            if(b.tier==2){
                                if(b.id!='tidak'){
                                    labels2.push(b.unit_name);

                                    facebook2.push(parseFloat(b.total_facebook));
                                    twitter2.push(parseFloat(b.total_twitter));
                                    instagram2.push(parseFloat(b.total_instagram));
                                }
                            }

                            if(b.tier==3){
                                labels3.push(b.unit_name);

                                facebook3.push(parseFloat(b.total_facebook));
                                twitter3.push(parseFloat(b.total_twitter));
                                instagram3.push(parseFloat(b.total_instagram));
                            }

                            if(b.tier==4){
                                labels4.push(b.unit_name);

                                facebook4.push(parseFloat(b.total_facebook));
                                twitter4.push(parseFloat(b.total_twitter));
                                instagram4.push(parseFloat(b.total_instagram));
                            }
                        })
                        
                        /* tear 1 */
                        var chartConfig1 = {
                            "type": "hbar",
                            "plot": {
                                "stacked": true,
                                "valueBox":{
                                    "text":"%total%",
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
                        
                        /* tear 2 */
                        var chartConfig2 = {
                            "type": "hbar",
                            "plot": {
                                "stacked": true,
                                "valueBox":{
                                    "text":"%total%",
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
                                "values": labels2,
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
                                    "values": twitter2,
                                    "text": "Twitter",
                                    "background-color": "#008ef6"
                                },
                                {
                                    "values": facebook2,
                                    "text": "Facebook",
                                    "background-color": "#5054ab"
                                },
                                {
                                    "values": instagram2,
                                    "text": "Instagram",
                                    "background-color": "#a200b2"
                                }
                            ]
                        };

                        chartConfig2.plot.animation = {
                            'method': 'LINEAR',
                            'delay': 0,
                            'effect': 'ANIMATION_EXPAND_VERTICAL',
                            'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                            'speed': 10
                        }

                        zingchart.render({
                            id: 'zingchart-2',
                            data: chartConfig2,
                            output: 'canvas',
                            height:'100%',
                            width:'100%'
                        });
                        /* end tear 2 */ 

                        /*tear 3 */
                        var chartConfig3 = {
                            "type": "hbar",
                            "plot": {
                                "stacked": true,
                                "valueBox":{
                                    "text":"%total%",
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
                                "values": labels3,
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
                                    "values": twitter3,
                                    "text": "Twitter",
                                    "background-color": "#008ef6"
                                },
                                {
                                    "values": facebook3,
                                    "text": "Facebook",
                                    "background-color": "#5054ab"
                                },
                                {
                                    "values": instagram3,
                                    "text": "Instagram",
                                    "background-color": "#a200b2"
                                }
                            ]
                        };

                        chartConfig3.plot.animation = {
                            'method': 'LINEAR',
                            'delay': 0,
                            'effect': 'ANIMATION_EXPAND_VERTICAL',
                            'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                            'speed': 10
                        }

                        zingchart.render({
                            id: 'zingchart-3',
                            data: chartConfig3,
                            output: 'canvas',
                            height:'100%',
                            width:'100%'
                        });    
                        /* end tear 3 */

                        /* tear 4 */ 
                        var chartConfig4 = {
                            "type": "hbar",
                            "plot": {
                                "stacked": true,
                                "valueBox":{
                                    "text":"%total%",
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
                                "values": labels4,
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
                                    "values": twitter4,
                                    "text": "Twitter",
                                    "background-color": "#008ef6"
                                },
                                {
                                    "values": facebook4,
                                    "text": "Facebook",
                                    "background-color": "#5054ab"
                                },
                                {
                                    "values": instagram4,
                                    "text": "Instagram",
                                    "background-color": "#a200b2"
                                }
                            ]
                        };

                        chartConfig4.plot.animation = {
                            'method': 'LINEAR',
                            'delay': 0,
                            'effect': 'ANIMATION_EXPAND_VERTICAL',
                            'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                            'speed': 10
                        }

                        zingchart.render({
                            id: 'zingchart-4',
                            data: chartConfig4,
                            output: 'canvas',
                            height:'100%',
                            width:'100%'
                        });    
                        /* end tear 4 */

                    }
                })
            }

            function showOfficial(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/chart/official-by-tier')}}",
                    type:"GET",
                    beforeSend:function(){

                    },
                    success:function(result){
                        zingchart.THEME="classic";
                        var myConfig = {
                            "background-color":"white",
                            "type":"line",
                            "legend":{
                                "layout":"x1",
                                "margin-top":"5%",
                                "border-width":"0",
                                "shadow":false,
                                "marker":{
                                    "cursor":"hand",
                                    "border-width":"0"
                                },
                                "background-color":"white",
                                "item":{
                                    "cursor":"hand"
                                },
                                "toggle-action":"remove"
                            },
                            "scaleX":{
                                "values":"1998:2012:1",
                                "max-items":8
                            },
                            "scaleY":{
                                "line-color":"#333"
                            },
                            "tooltip":{
                                "text":"%t: %v outbreaks in %k"
                            },
                            "plot":{
                                "line-width":3,
                                "marker":{
                                    "size":2
                                },
                                "selection-mode":"multiple",
                                "background-mode":"graph",
                                "selected-state":{
                                    "line-width":4
                                },
                                "background-state":{
                                    "line-color":"#eee",
                                    "marker":{
                                        "background-color":"none"
                                    }
                                }
                            },
                            "plotarea":{
                                "margin":"15% 25% 10% 7%"
                            },
                            "series":[
                                {
                                    "values":[783,672,621,466,427,315,382,299,363,363,350,213,261,287,243],
                                    "text":"Undeclared",
                                    "line-color":"#a6cee3",
                                    "marker":{
                                        "background-color":"#a6cee3",
                                        "border-color":"#a6cee3"
                                    }
                                },
                                {
                                    "values":[148,137,149,134,132,136,141,115,120,146,117,118,132,114,116],
                                    "text":"Salmonella",
                                    "line-color":"#1f78b4",
                                    "marker":{
                                        "background-color":"#1f78b4",
                                        "border-color":"#1f78b4"
                                    }
                                }
                            ]
                        };
                        
                        
                        zingchart.render({ 
                            id : 'chartOfficial', 
                            data : myConfig, 
                            height: '100%', 
                            width: '100%' 
                        });
                    }
                })
            }

            function officialTwitter(){
                zingchart.THEME="classic";
                var initState = null; // Used later to store the chart state before changing the data
                var bgColors = ["#1976d2","#424242","#388e3c","#ffa000","#7b1fa2","#c2185b"]; // ie, chrome, ff, safari, opera, unknown
                var myConfig = {
                    "globals": {
                        "font-family": "Helvetica"
                    },
                    "type": "hbar",
                    "background-color": "white",
                    "title": {
                        "color": "#606060",
                        "background-color": "white",
                        "text": "Browser market shares. January, 2015 to May, 2015"
                    },
                    "subtitle": {
                        "color": "#606060",
                        "text": "Click the columns to view versions. Source: netmarketshare.com."
                    },
                    "scale-y": {
                        "line-color": "none",
                        "tick": {
                            "line-color": "none"
                        },
                        "guide": {
                            "line-style": "solid"
                        },
                        "item": {
                            "color": "#606060"
                        }
                    },
                    "scale-x": {
                        "values": [
                            "Internet Explorer",
                            "Chrome",
                            "Firefox",
                            "Safari",
                            "Opera",
                            "Unknown"
                        ],
                        "line-color": "#C0D0E0",
                        "line-width": 1,
                        "tick": {
                            "line-width": 1,
                            "line-color": "#C0D0E0"
                        },
                        "guide": {
                            "visible": false
                        },
                        "item": {
                            "color": "#606060"
                        }
                    },
                    "crosshair-x": {
                        "marker": {
                            "visible": false
                        },
                        "line-color": "none",
                        "line-width": "0px",
                        "scale-label": {
                            "visible": false
                        },
                        "plot-label": {
                            "text": "%data-browser: %v% of total",
                            "multiple": true,
                            "font-size": "12px",
                            "color": "#606060",
                            "background-color": "white",
                            "border-width": 3,
                            "alpha": 0.9,
                            "callout": true,
                            "callout-position": "bottom",
                            "shadow": 0,
                            "placement": "node-top",
                            "border-radius": 4,
                            "offsetY":-10,
                            "padding":1,
                            "rules": [
                                {
                                    "rule": "%i==0",
                                    "border-color": "#1976d2"
                                },
                                {
                                    "rule": "%i==1",
                                    "border-color": "#424242"
                                },
                                {
                                    "rule": "%i==2",
                                    "border-color": "#388e3c"
                                },
                                {
                                    "rule": "%i==3",
                                    "border-color": "#ffa000"
                                },
                                {
                                    "rule": "%i==4",
                                    "border-color": "#7b1fa2"
                                },
                                {
                                    "rule": "%i==5",
                                    "border-color": "#c2185b"
                                }
                            ]
                        }
                    },
                    "plot": {
                        "data-browser": [
                            "<span style='font-weight:bold;color:#1976d2;'>Internet Explorer</span>",
                            "<span style='font-weight:bold;color:#424242;'>Chrome</span>",
                            "<span style='font-weight:bold;color:#388e3c;'>Firefox</span>",
                            "<span style='font-weight:bold;color:#ffa000;'>Safari</span>",
                            "<span style='font-weight:bold;color:#7b1fa2;'>Opera</span>",
                            "<span style='font-weight:bold;color:#c2185b;'>Unknown</span>"
                        ],
                        "cursor": "hand",
                        "value-box": {
                            "text": "%v%",
                            "text-decoration": "underline",
                            "color": "#606060"
                        },
                        "tooltip": {
                            "visible": false
                        },
                        "animation": {
                            "effect": "7"
                        },
                        "rules": [
                                {
                                    "rule": "%i==0",
                                    "background-color": "#1976d2"
                                },
                                {
                                    "rule": "%i==1",
                                    "background-color": "#424242"
                                },
                                {
                                    "rule": "%i==2",
                                    "background-color": "#388e3c"
                                },
                                {
                                    "rule": "%i==3",
                                    "background-color": "#ffa000"
                                },
                                {
                                    "rule": "%i==4",
                                    "background-color": "#7b1fa2"
                                },
                                {
                                    "rule": "%i==5",
                                    "background-color": "#c2185b"
                                }
                            ]
                    },
                    "series": [
                        {
                            "values": [
                                56.33,
                                24,
                                10.4,
                                4.8,
                                0.9,
                                0.2
                            ]
                        }
                    ]
                };
                
                zingchart.render({
                    id : 'officialTwitter', 
                    data : myConfig,
                });
            }

            function top10(){
                zingchart.THEME="classic";
                var initState = null; // Used later to store the chart state before changing the data
                var bgColors = ["#1976d2","#424242","#388e3c","#ffa000","#7b1fa2","#c2185b"]; // ie, chrome, ff, safari, opera, unknown
                var myConfig = {
                    "globals": {
                        "font-family": "Helvetica"
                    },
                    "type": "hbar",
                    "background-color": "white",
                    "title": {
                        "color": "#606060",
                        "background-color": "white",
                        "text": "Browser market shares. January, 2015 to May, 2015"
                    },
                    "subtitle": {
                        "color": "#606060",
                        "text": "Click the columns to view versions. Source: netmarketshare.com."
                    },
                    "scale-y": {
                        "line-color": "none",
                        "tick": {
                            "line-color": "none"
                        },
                        "guide": {
                            "line-style": "solid"
                        },
                        "item": {
                            "color": "#606060"
                        }
                    },
                    "scale-x": {
                        "values": [
                            "Internet Explorer",
                            "Chrome",
                            "Firefox",
                            "Safari",
                            "Opera",
                            "Unknown"
                        ],
                        "line-color": "#C0D0E0",
                        "line-width": 1,
                        "tick": {
                            "line-width": 1,
                            "line-color": "#C0D0E0"
                        },
                        "guide": {
                            "visible": false
                        },
                        "item": {
                            "color": "#606060"
                        }
                    },
                    "crosshair-x": {
                        "marker": {
                            "visible": false
                        },
                        "line-color": "none",
                        "line-width": "0px",
                        "scale-label": {
                            "visible": false
                        },
                        "plot-label": {
                            "text": "%data-browser: %v% of total",
                            "multiple": true,
                            "font-size": "12px",
                            "color": "#606060",
                            "background-color": "white",
                            "border-width": 3,
                            "alpha": 0.9,
                            "callout": true,
                            "callout-position": "bottom",
                            "shadow": 0,
                            "placement": "node-top",
                            "border-radius": 4,
                            "offsetY":-10,
                            "padding":1,
                            "rules": [
                                {
                                    "rule": "%i==0",
                                    "border-color": "#1976d2"
                                },
                                {
                                    "rule": "%i==1",
                                    "border-color": "#424242"
                                },
                                {
                                    "rule": "%i==2",
                                    "border-color": "#388e3c"
                                },
                                {
                                    "rule": "%i==3",
                                    "border-color": "#ffa000"
                                },
                                {
                                    "rule": "%i==4",
                                    "border-color": "#7b1fa2"
                                },
                                {
                                    "rule": "%i==5",
                                    "border-color": "#c2185b"
                                }
                            ]
                        }
                    },
                    "plot": {
                        "data-browser": [
                            "<span style='font-weight:bold;color:#1976d2;'>Internet Explorer</span>",
                            "<span style='font-weight:bold;color:#424242;'>Chrome</span>",
                            "<span style='font-weight:bold;color:#388e3c;'>Firefox</span>",
                            "<span style='font-weight:bold;color:#ffa000;'>Safari</span>",
                            "<span style='font-weight:bold;color:#7b1fa2;'>Opera</span>",
                            "<span style='font-weight:bold;color:#c2185b;'>Unknown</span>"
                        ],
                        "cursor": "hand",
                        "value-box": {
                            "text": "%v%",
                            "text-decoration": "underline",
                            "color": "#606060"
                        },
                        "tooltip": {
                            "visible": false
                        },
                        "animation": {
                            "effect": "7"
                        },
                        "rules": [
                                {
                                    "rule": "%i==0",
                                    "background-color": "#1976d2"
                                },
                                {
                                    "rule": "%i==1",
                                    "background-color": "#424242"
                                },
                                {
                                    "rule": "%i==2",
                                    "background-color": "#388e3c"
                                },
                                {
                                    "rule": "%i==3",
                                    "background-color": "#ffa000"
                                },
                                {
                                    "rule": "%i==4",
                                    "background-color": "#7b1fa2"
                                },
                                {
                                    "rule": "%i==5",
                                    "background-color": "#c2185b"
                                }
                            ]
                    },
                    "series": [
                        {
                            "values": [
                                56.33,
                                24,
                                10.4,
                                4.8,
                                0.9,
                                0.2
                            ]
                        }
                    ]
                };
                
                zingchart.render({
                    id : 'top10', 
                    data : myConfig,
                });
            }

            function growthProgram(){
                zingchart.THEME="classic";
                var myConfig = {
                    "background-color":"white",
                    "type":"line",
                    "title":{
                        "text":"Yearly Outbreaks by Genus",
                        "color":"#333",
                        "background-color":"white",
                        "width":"60%",
                        "text-align":"left",
                    },
                    "subtitle":{
                        "text":"Toggle a legend item to remove the series and adjust the scale.",
                        "text-align":"left",
                        "width":"60%"
                    },
                    "legend":{
                        "layout":"x1",
                        "margin-top":"5%",
                        "border-width":"0",
                        "shadow":false,
                        "marker":{
                            "cursor":"hand",
                            "border-width":"0"
                        },
                        "background-color":"white",
                        "item":{
                            "cursor":"hand"
                        },
                        "toggle-action":"remove"
                    },
                    "scaleX":{
                        "values":"1998:2012:1",
                        "max-items":8
                    },
                    "scaleY":{
                        "line-color":"#333"
                    },
                    "tooltip":{
                        "text":"%t: %v outbreaks in %k"
                    },
                    "plot":{
                        "line-width":3,
                        "marker":{
                            "size":2
                        },
                        "selection-mode":"multiple",
                        "background-mode":"graph",
                        "selected-state":{
                            "line-width":4
                        },
                        "background-state":{
                            "line-color":"#eee",
                            "marker":{
                                "background-color":"none"
                            }
                        }
                    },
                    "plotarea":{
                        "margin":"15% 25% 10% 7%"
                    },
                    "series":[
                        {
                            "values":[783,672,621,466,427,315,382,299,363,363,350,213,261,287,243],
                            "text":"Undeclared",
                            "line-color":"#a6cee3",
                            "marker":{
                                "background-color":"#a6cee3",
                                "border-color":"#a6cee3"
                            }
                        },
                        {
                            "values":[148,137,149,134,132,136,141,115,120,146,117,118,132,114,116],
                            "text":"Salmonella",
                            "line-color":"#1f78b4",
                            "marker":{
                                "background-color":"#1f78b4",
                                "border-color":"#1f78b4"
                            }
                        },
                        {
                            "values":[73,199,276,305,367,285,496,283,503,321,358,198,303,224,288],
                            "text":"Norovirus",
                            "line-color":"#b2df8a",
                            "marker":{
                                "background-color":"#b2df8a",
                                "border-color":"#b2df8a"
                            }
                        },
                        {
                            "values":[19,12,6,6,8,9,9,6,8,1,2,2,6,8,12],
                            "text":"Vibrio",
                            "line-color":"#33a02c",
                            "marker":{
                                "background-color":"#33a02c",
                                "border-color":"#33a02c"
                            }
                        },
                        {
                            "values":[32,31,35,24,33,26,21,23,30,44,36,36,30,28,30],
                            "text":"E.coli",
                            "line-color":"#fb9a99",
                            "marker":{
                                "background-color":"#fb9a99",
                                "border-color":"#fb9a99"
                            }
                        },
                        {
                            "values":[12,12,12,6,7,6,2,6,5,4,1,2,3,1,0],
                            "text":"Hepatitis",
                            "line-color":"#e31a1c",
                            "marker":{
                                "background-color":"#e31a1c",
                                "border-color":"#e31a1c"
                            }
                        },
                        {
                            "values":[39,58,63,59,64,50,39,34,29,21,14,13,10,12,8],
                            "text":"Staphylococcus",
                            "line-color":"#fdbf6f",
                            "marker":{
                                "background-color":"#fdbf6f",
                                "border-color":"#fdbf6f"
                            }
                        },
                        {
                            "values":[56,53,60,61,65,52,58,42,39,50,44,30,34,23,32],
                            "text":"Clostridium",
                            "line-color":"#ff7f00",
                            "marker":{
                                "background-color":"#ff7f00",
                                "border-color":"#ff7f00"
                            }
                        },
                        {
                            "values":[15,6,15,20,22,22,15,25,27,30,26,16,28,33,38],
                            "text":"Campylobacter",
                            "line-color":"#cab2d6",
                            "marker":{
                                "background-color":"#cab2d6",
                                "border-color":"#cab2d6"
                            }
                        },
                        {
                            "values":[19,15,13,16,12,14,11,8,10,11,6,4,5,4,2],
                            "text":"Shigella",
                            "line-color":"#ffff99",
                            "marker":{
                                "background-color":"#ffff99",
                                "border-color":"#ffff99"
                            }
                        },
                        {
                            "values":[33,30,35,26,27,38,29,25,30,18,9,5,10,10,15],
                            "text":"Scombroid",
                            "line-color":"#6a3d9a",
                            "marker":{
                                "background-color":"#6a3d9a",
                                "border-color":"#6a3d9a"
                            }
                        },
                        {
                            "values":[1,1,0,3,3,1,2,0,0,0,0,0,0,1,2],
                            "text":"Yersinia",
                            "line-color":"#b15928",
                            "marker":{
                                "background-color":"#b15928",
                                "border-color":"#b15928"
                            }
                        },
                        {
                            "values":[32,32,56,62,82,65,57,40,33,41,26,12,15,10,3],
                            "text":"Bacillus"
                        },
                        {
                            "values":[2,5,2,2,1,2,0,4,4,1,3,2,5,5,5],
                            "text":"Listeria"
                        },
                        {
                            "values":[1,0,1,0,0,0,0,0,0,0,0,1,1,0,0],
                            "text":"Pesticides"
                        },
                        {
                            "values":[1,2,2,2,3,0,3,5,3,0,3,1,0,2,0],
                            "text":"Cyclospora"
                        },
                        {
                            "values":[18,15,19,26,23,18,10,10,10,14,15,10,5,15,8],
                            "text":"Ciguatoxin"
                        },
                        {
                            "values":[1,0,1,0,2,2,1,0,4,4,2,0,0,4,0],
                            "text":"Cryptosporidium"
                        },
                        {
                            "values":[1,0,0,0,0,0,0,0,0,0,0,0,0,0,1],
                            "text":"Streptococcus"
                        },
                        {
                            "values":[27,53,28,11,32,38,35,33,33,13,6,4,2,17,13],
                            "text":"Other"
                        }
                    ]
                };
                
                
                zingchart.render({ 
                    id : 'growthProgram', 
                    data : myConfig, 
                    height: '100%', 
                    width: '100%' 
                });
            }

            showTear1();
            showOfficial();
            officialTwitter();
            top10();
            growthProgram();
        })
    </script>
@stop
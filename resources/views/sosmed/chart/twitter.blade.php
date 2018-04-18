@extends('layouts.sosmed')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title text-center">Official {{strtoupper($param)}} All TV</h5>
                </div>
                <div class="panel-body">
                    <div id="tear1"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title text-center">TOP 10 {{strtoupper($param)}} Program</h5>
                </div>
                <div class="panel-body">
                    <div id="tear2"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title text-center">Growth Program {{strtoupper($param)}}</h5>
                </div>
                <div class="panel-body">
                    <form action="#" class="well">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="" class="control-label">Program</label>
                                    <select name="program" id="program" class="form-control">
                                        <option value="">Program</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="" class="control-label">Social Media</label>
                                    <select name="sosmed" id="sosmed" class="form-control">
                                        <option value="">Sosmed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" style="margin-top:25px;">
                                        <i class="icon-filter4"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="official"></div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('extra-script')
<script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
	<script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
	ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9","ee6b7db5b51705a13dc2339db3edaf6d"];</script>
	<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script src="https://www.amcharts.com/lib/3/pie.js"></script>

    <style>
        #tear1 {
            height: 450px;
            width: 450px;
        }

        #tear2 {
            height: 450px;
            width: 450px;
        }

        #tear3 {
            height: 450px;
            width: 450px;
        }

        #tear4 {
            height: 450px;
            width: 450px;
        }

        #official {
            height: 450px;
            width: 100%;
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

    <script>
        $(function(){
            function tear1(){
                var primaryColor = "#4184F3";
                var primaryColorHover = "#3a53c5";
                var secondaryColor = '#DCDCDC'
                var scaleTextColor = '#999';

                var chartConfig = {
                    "type": "hbar",
                    "plot": {
                        "stacked": true,
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
                        "margin": "5% 5% 15% 20%"
                    },
                    "legend":{
                        "align": 'center',
                        "verticalAlign": 'bottom',
                        "layout": 'x3',
                        "toggleAction": 'remove'
                    },
                    "backgroundColor": "#fff",
                    "scaleX": {
                        "values": [
                            "ANTV",
                            "TRANS TV",
                            "iNEWS(4TV)",
                            "TRANS 7",
                            "TV ONE",
                            "MNCTV",
                            "RCTI",
                            "GTV",
                            "INDOSIAR",
                            "KOMPAS TV",
                            "METRO TV",
                            "NET TV",
                            "SCTV"
                        ],
                        "lineWidth": 0,
                        "lineColor":"none",
                        "tick": {
                            "visible": false
                        },
                        "guide": {
                            "visible": false
                        },
                        "item": {
                            "font-color": "#999"
                        }
                    },
                    "scaleY": {
                        "lineWidth":0,
                        "lineColor":"none",
                        "min-value": 0,
                        "max-value": 495,
                        "step": 123.75,
                        "tick": {
                            "visible": false
                        },
                        "guide": {
                            "lineStyle": "solid"
                        },
                        "item": {
                            "font-color": "#999"
                        }
                    },
                    "tooltip": {
                        "htmlMode": true,
                        "backgroundColor": "none",
                        "padding": 0,
                        "placement": "node:center",
                        "text": "<div class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": [
                                100,
                                124
                            ],
                            "alpha": 1,
                            "background-color": "#008ef6",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
                            },
                            "text":"Twitter"
                        }
                    ]
                };

                chartConfig.plot.animation = {
                    'method': 'LINEAR',
                    'delay': 0,
                    'effect': 'ANIMATION_EXPAND_VERTICAL',
                    'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                    'speed': 10
                }
                
                zingchart.render({
                    id: 'tear1',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });

            }

            function tear2(){
                var primaryColor = "#4184F3";
                var primaryColorHover = "#3a53c5";
                var secondaryColor = '#DCDCDC'
                var scaleTextColor = '#999';

                var chartConfig = {
                    "type": "hbar",
                    "plot": {
                        "stacked": true,
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
                        "margin": "5% 5% 15% 30%"
                    },
                    "legend":{
                        "align": 'center',
                        "verticalAlign": 'bottom',
                        "layout": 'x3',
                        "toggleAction": 'remove'
                    },
                    "backgroundColor": "#fff",
                    "scaleX": {
                        "values": [
                            "KISS",
                            "BROWNIES",
                            "PAGI-PAGI",
                            "MATA NAJWA",
                            "SEKUTER",
                            "ORANG PINGGIRAN",
                            "SELEBRITA 7",
                            "DAHSYAT",
                            "INSERT",
                            "STAND UP COMEDY"
                        ],
                        "lineWidth": 0,
                        "lineColor":"none",
                        "tick": {
                            "visible": false
                        },
                        "guide": {
                            "visible": false
                        },
                        "item": {
                            "font-color": "#999"
                        }
                    },
                    "scaleY": {
                        "lineWidth":0,
                        "lineColor":"none",
                        "min-value": 0,
                        "max-value": 495,
                        "step": 123.75,
                        "tick": {
                            "visible": false
                        },
                        "guide": {
                            "lineStyle": "solid"
                        },
                        "item": {
                            "font-color": "#999"
                        }
                    },
                    "tooltip": {
                        "htmlMode": true,
                        "backgroundColor": "none",
                        "padding": 0,
                        "placement": "node:center",
                        "text": "<div class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": [
                                100,
                                124
                            ],
                            "alpha": 1,
                            "background-color": "#008ef6",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
                            },
                            "text":"Twitter"
                        }
                    ]
                };

                chartConfig.plot.animation = {
                    'method': 'LINEAR',
                    'delay': 0,
                    'effect': 'ANIMATION_EXPAND_VERTICAL',
                    'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                    'speed': 10
                }
                
                zingchart.render({
                    id: 'tear2',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });

            }

            function official(){
                zingchart.THEME="classic";
                var myConfig = {
                    "background-color":"white",
                    "type":"line",
                    "title":{
                        "text":"",
                        "color":"#333",
                        "background-color":"white",
                        "width":"60%",
                        "text-align":"center",
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
                        "margin":"15% 15% 10% 7%"
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
                        }
                    ]
                };
                
                zingchart.render({ 
                    id : 'official', 
                    data : myConfig, 
                    height: 400, 
                    width: 925 
                });
            }

            tear1();
            tear2();
            official();
        })
    </script>
@endpush
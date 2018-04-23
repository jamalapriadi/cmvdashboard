@extends('layouts.sosmed')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="text-center">Cross Channel Tear 1</h5>
                </div>
                <div class="panel-body">
                    <div id="tear1"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="text-center">Cross Channel Tear 3</h5>
                </div>
                <div class="panel-body">
                    <div id="tear3"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="text-center">Cross Channel Tear 2</h5>
                </div>
                <div class="panel-body">
                    <div id="tear2"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="text-center">Cross Channel Tear 4</h5>
                </div>
                <div class="panel-body">
                    <div id="tear4"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="text-center">Official</h5>
                </div>
                <div class="panel-body">
                    <form action="#" class="well">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="" class="control-label">Tear</label>
                                    <select name="tear" id="tear" class="form-control">
                                        <option value="">Tear</option>
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
            function alltier(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/chart/all-tier')}}",
                    type:"GET",
                    beforeSend:function(){
                        $("#tear1").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                        $("#tear2").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                    },
                    success:function(result){
                        var data=result;

                        tear1(data);
                        tear2(data);
                        tear3(data);
                        tear4(data);
                        official();
                    },
                    error:function(){

                    }
                })
            }

            function tear1(data){
                var primaryColor = "#4184F3";
                var primaryColorHover = "#3a53c5";
                var secondaryColor = '#DCDCDC'
                var scaleTextColor = '#999';
                var tw=[];
                var fb=[];
                var ig=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.id=="1" || b.id=="6"){
                        tw.push(parseInt(b.tw));
                        fb.push(parseInt(b.fb));
                        ig.push(parseInt(b.ig));
                        nama.push(b.unit_name);
                    }
                })
                
                $("#tear1").empty();

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
                        "margin": "2% 2% 15% 15%"
                    },
                    "legend":{
                        "align": 'center',
                        "verticalAlign": 'bottom',
                        "layout": 'x3',
                        "toggleAction": 'remove'
                    },
                    "backgroundColor": "#fff",
                    "scaleX": {
                        "values": nama,
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
                    "tooltip": {
                        "htmlMode": true,
                        "backgroundColor": "none",
                        "padding": 0,
                        "placement": "node:center",
                        "text": "<div class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": tw,
                            "alpha": 1,
                            "background-color": "#008ef6",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
                            },
                            "text":"Twitter"
                        },
                        {
                            "values": fb,
                            "alpha": 1,
                            "background-color": "#5054ab",
                            "hover-state" : {
                                backgroundColor: '#901E15'
                            },
                            "text":"Facebook"
                        },
                        {
                            "values": ig,
                            "alpha": 1,
                            "background-color": "#a200b2",
                            "border-radius-top-left": "3px",
                            "border-radius-top-right": "3px",
                            "hover-state" : {
                                backgroundColor: '#8C6A0B'
                            },
                            "text":"Instagram"
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

            function tear2(data){
                var primaryColor = "#4184F3";
                var primaryColorHover = "#3a53c5";
                var secondaryColor = '#DCDCDC'
                var scaleTextColor = '#999';
                var tw=[];
                var fb=[];
                var ig=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.id=="5" || b.id=="10" || b.id=="2"){
                        tw.push(parseInt(b.tw));
                        fb.push(parseInt(b.fb));
                        ig.push(parseInt(b.ig));
                        nama.push(b.unit_name);
                    }
                })
                
                $("#tear2").empty();

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
                        "margin": "5% 5% 15% 15%"
                    },
                    "legend":{
                        "align": 'center',
                        "verticalAlign": 'bottom',
                        "layout": 'x3',
                        "toggleAction": 'remove'
                    },
                    "backgroundColor": "#fff",
                    "scaleX": {
                        "values": nama,
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
                    "tooltip": {
                        "htmlMode": true,
                        "backgroundColor": "none",
                        "padding": 0,
                        "placement": "node:center",
                        "text": "<div class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": tw,
                            "alpha": 1,
                            "background-color": "#008ef6",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
                            },
                            "text":"Twitter"
                        },
                        {
                            "values": fb,
                            "alpha": 1,
                            "background-color": "#5054ab",
                            "hover-state" : {
                                backgroundColor: '#901E15'
                            },
                            "text":"Facebook"
                        },
                        {
                            "values": ig,
                            "alpha": 1,
                            "background-color": "#a200b2",
                            "border-radius-top-left": "3px",
                            "border-radius-top-right": "3px",
                            "hover-state" : {
                                backgroundColor: '#8C6A0B'
                            },
                            "text":"Instagram"
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

            function tear3(data){
                var primaryColor = "#4184F3";
                var primaryColorHover = "#3a53c5";
                var secondaryColor = '#DCDCDC';
                var scaleTextColor = '#999';
                var tw=[];
                var fb=[];
                var ig=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.id=="3" || b.id=="7" || b.id=="8" || b.id=="13"){
                        tw.push(parseInt(b.tw));
                        fb.push(parseInt(b.fb));
                        ig.push(parseInt(b.ig));
                        nama.push(b.unit_name);
                    }
                })

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
                        "margin": "5% 5% 15% 15%"
                    },
                    "legend":{
                        "align": 'center',
                        "verticalAlign": 'bottom',
                        "layout": 'x3',
                        "toggleAction": 'remove'
                    },
                    "backgroundColor": "#fff",
                    "scaleX": {
                        "values": nama,
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
                    "tooltip": {
                        "htmlMode": true,
                        "backgroundColor": "none",
                        "padding": 0,
                        "placement": "node:center",
                        "text": "<div class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": tw,
                            "alpha": 1,
                            "background-color": "#008ef6",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
                            },
                            "text":"Twitter"
                        },
                        {
                            "values": fb,
                            "alpha": 1,
                            "background-color": "#5054ab",
                            "hover-state" : {
                                backgroundColor: '#901E15'
                            },
                            "text":"Facebook"
                        },
                        {
                            "values": ig,
                            "alpha": 1,
                            "background-color": "#a200b2",
                            "border-radius-top-left": "3px",
                            "border-radius-top-right": "3px",
                            "hover-state" : {
                                backgroundColor: '#8C6A0B'
                            },
                            "text":"Instagram"
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
                    id: 'tear3',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });

            }

            function tear4(data){
                var primaryColor = "#4184F3";
                var primaryColorHover = "#3a53c5";
                var secondaryColor = '#DCDCDC'
                var scaleTextColor = '#999';

                var tw=[];
                var fb=[];
                var ig=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.id=="12" || b.id=="11" || b.id=="9" || b.id=="4"){
                        tw.push(parseInt(b.tw));
                        fb.push(parseInt(b.fb));
                        ig.push(parseInt(b.ig));
                        nama.push(b.unit_name);
                    }
                })

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
                        "margin": "5% 5% 15% 18%"
                    },
                    "legend":{
                        "align": 'center',
                        "verticalAlign": 'bottom',
                        "layout": 'x3',
                        "toggleAction": 'remove'
                    },
                    "backgroundColor": "#fff",
                    "scaleX": {
                        "values": nama,
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
                    "tooltip": {
                        "htmlMode": true,
                        "backgroundColor": "none",
                        "padding": 0,
                        "placement": "node:center",
                        "text": "<div class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": tw,
                            "alpha": 1,
                            "background-color": "#008ef6",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
                            },
                            "text":"Twitter"
                        },
                        {
                            "values": fb,
                            "alpha": 1,
                            "background-color": "#5054ab",
                            "hover-state" : {
                                backgroundColor: '#901E15'
                            },
                            "text":"Facebook"
                        },
                        {
                            "values": ig,
                            "alpha": 1,
                            "background-color": "#a200b2",
                            "border-radius-top-left": "3px",
                            "border-radius-top-right": "3px",
                            "hover-state" : {
                                backgroundColor: '#8C6A0B'
                            },
                            "text":"Instagram"
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
                    id: 'tear4',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });

            }

            function official(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/chart/official-tv')}}",
                    type:"GET",
                    beforeSend:function(){

                    },
                    success:function(result){
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
                            "scaleX": {
                                "markers": [],
                                "offsetEnd":75,
                                "labels": result.labels
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
                            "series":result.series
                        };
                        
                        zingchart.render({ 
                            id : 'official', 
                            data : myConfig, 
                            height: 400, 
                            width: 925 
                        });
                    },
                    error:function(){

                    }
                })
            }
            
            alltier();
        })
    </script>
@endpush
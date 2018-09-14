@extends('layouts.coreui.main')

@section('extra-style')
    <style>
        #zingchart-1 {
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
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                            </div>
                            <input type="text" id="tanggal" data-value="{{date('Y/m/d')}}" name="tanggal" class="form-control daterange-single">
                        </div>
                    </div>

                    <div class="btn-group btn-group-toggle float-right mr-3" data-toggle="buttons">
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
            </div>
        </div>
        <div class="card-body">
            <div id="zingchart-1"><a class="zc-ref" href="https://www.zingchart.com/">Charts by ZingChart</a></div>
        </div>
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
                var tanggal=$("#tanggal").val();
                var filter=$("#filter").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/chart/chart-by-tier')}}",
                    type:"GET",
                    data:"tanggal="+tanggal+"&filter="+filter+"&typeunit=TV",
                    beforeSend:function(){
                        $("#zingchart-1").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>");
                    },
                    success:function(result){
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
                            if(b.id!='tidak'){
                                if(b.id!=4){
                                    labels1.push(b.unit_name);

                                    facebook1.push(parseFloat(b.total_facebook));
                                    twitter1.push(parseFloat(b.total_twitter));
                                    instagram1.push(parseFloat(b.total_instagram));
                                    youtube1.push(parseFloat(b.total_youtube));
                                }else{
                                    $.each(result.inews,function(a,b){
                                        labels1.push("INEWS 4TV");

                                        facebook1.push(parseFloat(b.total_facebook));
                                        twitter1.push(parseFloat(b.total_twitter));
                                        instagram1.push(parseFloat(b.total_instagram));
                                        youtube1.push(parseFloat(b.total_youtube));
                                    })
                                }
                                
                            }
                        })
                        
                        /* tear 1 */
                        var chartConfig1 = {
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
                        
                        /* tear 2 */
                        // var chartConfig2 = {
                        //     "type": "hbar",
                        //     "plot": {
                        //         "stacked": true,
                        //         "valueBox":{
                        //             "text":"%total%",
                        //             "rules": [
                        //                 {
                        //                     "rule": '%stack-top == 0',
                        //                     "visible": 0
                        //                 }
                        //             ]
                        //         }
                        //     },
                        //     "plotarea": {
                        //         // "margin": "2% 2% 15% 20%"
                        //         margin: 'dynamic dynamic dynamic dynamic',
                        //     },
                        //     "backgroundColor": "#fff",
                        //     "scaleX": {
                        //         "values": labels2,
                        //         "lineWidth": 0,
                        //         "lineColor":"none",
                        //         "tick": {
                        //             "visible": false
                        //         },
                        //         "guide": {
                        //             "visible": false
                        //         },
                        //         "item": {
                        //             "font-size": "9px",
                        //             "font-color": "#222222"
                        //         }
                        //     },
                        //     "scale-y":{
                        //         "line-color":"#333",
                        //         "guide":{
                        //             "line-style":"solid",
                        //             "line-color":"#c4c4c4",
                        //             visible:false
                        //         },
                        //         "tick":{
                        //             "line-color":"#333",
                        //         }
                        //     },
                        //     "legend": {
                        //         "layout": "float",
                        //         "toggle-action":"remove",
                        //         "shadow": 0,
                        //         "adjust-layout": true,
                        //         "align": "center",
                        //         "vertical-align": "bottom",
                        //         "marker": {
                        //             "type": "match",
                        //             "show-line": true,
                        //             "line-width": 4,
                        //             "shadow": "none"
                        //         }
                        //     },
                        //     "tooltip": {
                        //         "htmlMode": true,
                        //         "backgroundColor": "none",
                        //         "padding": 0,
                        //         "placement": "node:center",
                        //         "text": "<div  class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v <\/div><\/div>"
                        //     },
                        //     "series": [
                        //         {
                        //             "values": twitter2,
                        //             "text": "Twitter",
                        //             "background-color": "#008ef6"
                        //         },
                        //         {
                        //             "values": facebook2,
                        //             "text": "Facebook",
                        //             "background-color": "#5054ab"
                        //         },
                        //         {
                        //             "values": instagram2,
                        //             "text": "Instagram",
                        //             "background-color": "#a200b2"
                        //         }
                        //     ]
                        // };

                        // chartConfig2.plot.animation = {
                        //     'method': 'LINEAR',
                        //     'delay': 0,
                        //     'effect': 'ANIMATION_EXPAND_VERTICAL',
                        //     'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                        //     'speed': 10
                        // }

                        // zingchart.render({
                        //     id: 'zingchart-2',
                        //     data: chartConfig2,
                        //     output: 'canvas',
                        //     height:'100%',
                        //     width:'100%'
                        // });
                        // /* end tear 2 */ 

                        // /*tear 3 */
                        // var chartConfig3 = {
                        //     "type": "hbar",
                        //     "plot": {
                        //         "stacked": true,
                        //         "valueBox":{
                        //             "text":"%total%",
                        //             "rules": [
                        //                 {
                        //                     "rule": '%stack-top == 0',
                        //                     "visible": 0
                        //                 }
                        //             ]
                        //         }
                        //     },
                        //     "plotarea": {
                        //         // "margin": "2% 2% 15% 20%"
                        //         margin: 'dynamic dynamic dynamic dynamic',
                        //     },
                        //     "backgroundColor": "#fff",
                        //     "scaleX": {
                        //         "values": labels3,
                        //         "lineWidth": 0,
                        //         "lineColor":"none",
                        //         "tick": {
                        //             "visible": false
                        //         },
                        //         "guide": {
                        //             "visible": false
                        //         },
                        //         "item": {
                        //             "font-size": "9px",
                        //             "font-color": "#222222"
                        //         }
                        //     },
                        //     "scale-y":{
                        //         "line-color":"#333",
                        //         "guide":{
                        //             "line-style":"solid",
                        //             "line-color":"#c4c4c4",
                        //             visible:false
                        //         },
                        //         "tick":{
                        //             "line-color":"#333",
                        //         }
                        //     },
                        //     "legend": {
                        //         "layout": "float",
                        //         "toggle-action":"remove",
                        //         "shadow": 0,
                        //         "adjust-layout": true,
                        //         "align": "center",
                        //         "vertical-align": "bottom",
                        //         "marker": {
                        //             "type": "match",
                        //             "show-line": true,
                        //             "line-width": 4,
                        //             "shadow": "none"
                        //         }
                        //     },
                        //     "tooltip": {
                        //         "htmlMode": true,
                        //         "backgroundColor": "none",
                        //         "padding": 0,
                        //         "placement": "node:center",
                        //         "text": "<div  class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v <\/div><\/div>"
                        //     },
                        //     "series": [
                        //         {
                        //             "values": twitter3,
                        //             "text": "Twitter",
                        //             "background-color": "#008ef6"
                        //         },
                        //         {
                        //             "values": facebook3,
                        //             "text": "Facebook",
                        //             "background-color": "#5054ab"
                        //         },
                        //         {
                        //             "values": instagram3,
                        //             "text": "Instagram",
                        //             "background-color": "#a200b2"
                        //         }
                        //     ]
                        // };

                        // chartConfig3.plot.animation = {
                        //     'method': 'LINEAR',
                        //     'delay': 0,
                        //     'effect': 'ANIMATION_EXPAND_VERTICAL',
                        //     'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                        //     'speed': 10
                        // }

                        // zingchart.render({
                        //     id: 'zingchart-3',
                        //     data: chartConfig3,
                        //     output: 'canvas',
                        //     height:'100%',
                        //     width:'100%'
                        // });    
                        // /* end tear 3 */

                        // /* tear 4 */ 
                        // var chartConfig4 = {
                        //     "type": "hbar",
                        //     "plot": {
                        //         "stacked": true,
                        //         "valueBox":{
                        //             "text":"%total%",
                        //             "rules": [
                        //                 {
                        //                     "rule": '%stack-top == 0',
                        //                     "visible": 0
                        //                 }
                        //             ]
                        //         }
                        //     },
                        //     "plotarea": {
                        //         // "margin": "2% 2% 15% 20%"
                        //         margin: 'dynamic dynamic dynamic dynamic',
                        //     },
                        //     "backgroundColor": "#fff",
                        //     "scaleX": {
                        //         "values": labels4,
                        //         "lineWidth": 0,
                        //         "lineColor":"none",
                        //         "tick": {
                        //             "visible": false
                        //         },
                        //         "guide": {
                        //             "visible": false
                        //         },
                        //         "item": {
                        //             "font-size": "9px",
                        //             "font-color": "#222222"
                        //         }
                        //     },
                        //     "scale-y":{
                        //         "line-color":"#333",
                        //         "guide":{
                        //             "line-style":"solid",
                        //             "line-color":"#c4c4c4",
                        //             visible:false
                        //         },
                        //         "tick":{
                        //             "line-color":"#333",
                        //         }
                        //     },
                        //     "legend": {
                        //         "layout": "float",
                        //         "toggle-action":"remove",
                        //         "shadow": 0,
                        //         "adjust-layout": true,
                        //         "align": "center",
                        //         "vertical-align": "bottom",
                        //         "marker": {
                        //             "type": "match",
                        //             "show-line": true,
                        //             "line-width": 4,
                        //             "shadow": "none"
                        //         }
                        //     },
                        //     "tooltip": {
                        //         "htmlMode": true,
                        //         "backgroundColor": "none",
                        //         "padding": 0,
                        //         "placement": "node:center",
                        //         "text": "<div  class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v <\/div><\/div>"
                        //     },
                        //     "series": [
                        //         {
                        //             "values": twitter4,
                        //             "text": "Twitter",
                        //             "background-color": "#008ef6"
                        //         },
                        //         {
                        //             "values": facebook4,
                        //             "text": "Facebook",
                        //             "background-color": "#5054ab"
                        //         },
                        //         {
                        //             "values": instagram4,
                        //             "text": "Instagram",
                        //             "background-color": "#a200b2"
                        //         }
                        //     ]
                        // };

                        // chartConfig4.plot.animation = {
                        //     'method': 'LINEAR',
                        //     'delay': 0,
                        //     'effect': 'ANIMATION_EXPAND_VERTICAL',
                        //     'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                        //     'speed': 10
                        // }

                        // zingchart.render({
                        //     id: 'zingchart-4',
                        //     data: chartConfig4,
                        //     output: 'canvas',
                        //     height:'100%',
                        //     width:'100%'
                        // });    
                        /* end tear 4 */

                    }
                })
            }

            $(document).on("change","#filter",function(){
                showTear1();
            })

            showTear1();
        })
    </script>
@stop
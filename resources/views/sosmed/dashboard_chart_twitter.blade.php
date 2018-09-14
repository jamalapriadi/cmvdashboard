@extends('layouts.coreui.main')

@section('extra-style')
    <style>
        #zingchart-1 {
            height: 400px;
            width: 960px;
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

        #top10TwitterProgram{
            height: 400px;
            width: 480px;
        }

        #top10TwitterOfficial{
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
    <div class="card card-default">
        <div class="card-header">Official</div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="" class="control-label">Periode</label>
                        <div id="divPeriode"></div>
                    </div>
                </div>
            </div>
            
            <hr>
            <div id="chartOfficial"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card card-default">
                <div class="card-header">
                    Official Twitter All TV

                    <div class="btn-group btn-group-toggle float-right mr-3" data-toggle="buttons">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                            </div>
                            <input type="text" id="tanggal" data-value="{{date('Y/m/d')}}" name="tanggal" class="form-control daterange-single">
                        </div>
                    </div>
                </div>
                <div id="top10TwitterOfficial"></div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-default">
                <div class="card-header">
                    TOP 10 Twitter Program

                    <div class="btn-group btn-group-toggle float-right mr-3" data-toggle="buttons">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                            </div>
                            <input type="text" id="tanggal2" data-value="{{date('Y/m/d')}}" name="tanggal2" class="form-control daterange-single">
                        </div>
                    </div>
                </div>
                <div id="top10TwitterProgram"></div>
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
            var idsosmed="{{$idsosmed}}";

            $('.daterange-single').pickadate({
                format: 'yyyy/mm/dd',
                formatSubmit: 'yyyy/mm/dd',
                max:true,
            });

            function showOfficial(){
                var periode=$("#periode").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/chart/official-by-tier')}}",
                    type:"GET",
                    data:"idsosmed="+idsosmed,
                    beforeSend:function(){
                        $("#chartOfficial").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>");
                    },
                    success:function(result){
                        $("#chartOfficial").empty();
                        var series=[];
                        var tanggal=[];
                        $.each(result,function(a,b){
                            var values=[];
                            $.each(b.follower,function(c,d){
                                values.push(d.num_of_growth);
                                // tanggal.push(d.tanggal);
                                if ($.inArray(d.tanggal, tanggal) == -1) tanggal.push(d.tanggal);
                            })
                            series.push({
                                    "values":values,
                                    "text":b.unit_name,
                                    "line-color":b.warna,
                                    "marker":{
                                        "background-color":b.warna,
                                        "border-color":b.warna
                                    }
                                });
                        })
                        tanggal.sort(function(a,b){
                            return new Date(a) - new Date(b);
                        });
                        console.log(tanggal);

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
                                "values":tanggal
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
                            "series":series
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

            function growthProgram(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/chart/program-by-tier')}}",
                    type:"GET",
                    data:"idsosmed="+idsosmed,
                    beforeSend:function(){
                        $("#growthProgram").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>");
                    },
                    success:function(result){
                        $("#growthProgram").empty();
                        var series=[];
                        $.each(result,function(a,b){
                            var values=[];
                            $.each(b.follower,function(c,d){
                                values.push(d.num_of_growth);
                            })
                            series.push({
                                    "values":values,
                                    "text":b.program_name,
                                    "line-color":"#a6cee3",
                                    "marker":{
                                        "background-color":"#a6cee3",
                                        "border-color":"#a6cee3"
                                    }
                                });
                        })

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
                            "series":series
                        };
                        
                        
                        zingchart.render({ 
                            id : 'growthProgram', 
                            data : myConfig, 
                            height: '100%', 
                            width: '100%' 
                        });
                    }
                })
            }

            function top10TwitterProgram(){
                $.ajax({
                    url:"{{URL::to('sosmed/data/chart/top-program-twitter-today')}}",
                    type:"GET",
                    data:"idsosmed="+idsosmed,
                    beforeSend:function(){
                        $("#top10TwitterProgram").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>");
                    },
                    success:function(result){
                        $("#top10TwitterProgram").empty();
                        var primaryColor = "#4184F3";
                        var primaryColorHover = "#3a53c5";
                        var secondaryColor = '#DCDCDC';
                        var scaleTextColor = '#999';

                        var labels=[];
                        var values=[];
                        
                        var filterbrand=result.slice(0,10);
                        filterbrand.reverse();
                        $.each(filterbrand,function(a,b){
                            labels.push(b.program_name);
                            values.push(b.follower);
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
                                "margin": "2% 2% 15% 20%"
                            },
                            source:{
                                // text: "* Dalam Ribu",
                                fontColor:"#222222",
                                // align: "center",
                            },
                            "backgroundColor": "#fff",
                            "scaleX": {
                                "values": labels,
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
                            "tooltip": {
                                "htmlMode": true,
                                "backgroundColor": "none",
                                "padding": 0,
                                "placement": "node:center",
                                "text": "<div class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v<\/div><\/div>"
                            },
                            "series": [
                                {
                                    "values": values,
                                    "alpha": 1,
                                    "background-color": "#fb8072",
                                    "hover-state": {
                                        "backgroundColor": "#2956A0"
                                    }
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
                            id: 'top10TwitterProgram',
                            data: chartConfig,
                            output: 'canvas',
                            height:'100%',
                            width:'100%'
                        });
                    },
                    errors:function(){

                    }
                })
            }

            function top10TwitterOfficial(){
                var tanggal=$("#tanggal").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/chart/top-official-twitter-today')}}",
                    type:"GET",
                    data:"idsosmed="+idsosmed+"&tanggal="+tanggal,
                    beforeSend:function(){
                        $("#top10TwitterOfficial").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>");
                    },
                    success:function(result){
                        $("#top10TwitterOfficial").empty();
                        var primaryColor = "#4184F3";
                        var primaryColorHover = "#3a53c5";
                        var secondaryColor = '#DCDCDC';
                        var scaleTextColor = '#999';

                        var labels=[];
                        var values=[];
                        
                        var filterbrand=result.slice(0,10);
                        filterbrand.reverse();
                        $.each(filterbrand,function(a,b){
                            labels.push(b.unit_name);
                            values.push(b.follower);
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
                                "margin": "2% 2% 15% 20%"
                            },
                            source:{
                                // text: "* Dalam Ribu",
                                fontColor:"#222222",
                                // align: "center",
                            },
                            "backgroundColor": "#fff",
                            "scaleX": {
                                "values": labels,
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
                            "tooltip": {
                                "htmlMode": true,
                                "backgroundColor": "none",
                                "padding": 0,
                                "placement": "node:center",
                                "text": "<div class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v<\/div><\/div>"
                            },
                            "series": [
                                {
                                    "values": values,
                                    "alpha": 1,
                                    "background-color": "#fb8072",
                                    "hover-state": {
                                        "backgroundColor": "#2956A0"
                                    }
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
                            id: 'top10TwitterOfficial',
                            data: chartConfig,
                            output: 'canvas',
                            height:'100%',
                            width:'100%'
                        });
                    },
                    errors:function(){

                    }
                })
            }

            $(document).on("change","#periode",function(){
                showOfficial();
            })

            function periode(){
				var pilih=""
				$.ajax({
					url:"{{URL::to('sosmed/data/periode')}}",
					type:"GET",
					success:function(result){
						console.log(result);

						var p="<select name='periode' id='periode' class='form-control'>"+
							"<option value='' selected='selected'>--Periode--</option>";
							$.each(result,function(a,b){

								p+="<option value='"+b.key+"'>"+b.value+"</option>";
							})
						p+="</select>";


						$("#divPeriode").empty().html(p);
					}
				})
			}

            $(document).on("change","#tanggal",function(){
                top10TwitterOfficial();
            })
            
            $(document).on("change","#tanggal2",function(){

            })

            $(document).on("change","#periode",function(){
                var periode=$("#periode").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/chart/official-by-tier')}}",
                    type:"GET",
                    data:"idsosmed="+idsosmed+"&periode="+periode,
                    beforeSend:function(){
                        $("#chartOfficial").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>");
                    },
                    success:function(result){
                        $("#chartOfficial").empty();
                        var series=[];
                        var tanggal=[];
                        $.each(result,function(a,b){
                            var values=[];
                            $.each(b.follower,function(c,d){
                                values.push(d.num_of_growth);
                                // tanggal.push(d.tanggal);
                                if ($.inArray(d.tanggal, tanggal) == -1) tanggal.push(d.tanggal);
                            })
                            series.push({
                                    "values":values,
                                    "text":b.unit_name,
                                    "line-color":b.warna,
                                    "marker":{
                                        "background-color":b.warna,
                                        "border-color":b.warna
                                    }
                                });
                        })
                        tanggal.sort(function(a,b){
                            return new Date(a) - new Date(b);
                        });
                        console.log(tanggal);

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
                                "values":tanggal
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
                            "series":series
                        };
                        
                        
                        zingchart.render({ 
                            id : 'chartOfficial', 
                            data : myConfig, 
                            height: '100%', 
                            width: '100%' 
                        });
                    }
                })
            })

            
            showOfficial();
            top10TwitterProgram();
            top10TwitterOfficial();
            growthProgram();
            periode();
        })
    </script>
@stop
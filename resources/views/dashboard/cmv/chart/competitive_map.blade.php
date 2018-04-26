@extends('layouts.dashboard')

@section('js')
    <script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js"></script>
    {{Html::script('limitless1/assets/js/plugins/tables/datatables/extensions/fixed_columns.min.js')}}

    <script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
	<script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
	ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9","ee6b7db5b51705a13dc2339db3edaf6d"];</script>
	<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script src="https://www.amcharts.com/lib/3/pie.js"></script>

    <script>
        $(function(){
            var alldata={};

            $(".remote-data-brand").select2({
                ajax: {
                    url: "{{URL::to('cmv/data/list-brand')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params, // search term
                            page_limit: 30
                        };
                    },
                    results: function (data, page){
                        return {
                            results: data.data
                        };
                    },
                    cache: true,
                    pagination: {
                        more: true
                    }
                },
                formatResult: function(m){
                    var markup="<option value='"+m.id+"'>"+m.text+"</option>";
    
                    return markup;                
                },
                formatSelection: function(m){
                    return m.text;
                },
                escapeMarkup: function (m) { return m; }
            })

            $(".remote-data-category").select2({
                ajax: {
                    url: "{{URL::to('cmv/data/list-category')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params, // search term
                            page_limit: 30
                        };
                    },
                    results: function (data, page){
                        return {
                            results: data.data
                        };
                    },
                    cache: true,
                    pagination: {
                        more: true
                    }
                },
                formatResult: function(m){
                    var markup="<option value='"+m.id+"'>"+m.text+"</option>";
    
                    return markup;                
                },
                formatSelection: function(m){
                    return m.text;
                },
                escapeMarkup: function (m) { return m; }
            })

            $(".remote-data-brand-competitive").select2({
                multiple:true,
                ajax: {
                    url: "{{URL::to('cmv/data/list-brand')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params, // search term
                            category:$("#category").val(),
                            page_limit: 30
                        };
                    },
                    results: function (data, page){
                        return {
                            results: data.data
                        };
                    },
                    cache: true,
                    pagination: {
                        more: true
                    }
                },
                formatResult: function(m){
                    var markup="<option value='"+m.id+"'>"+m.text+"</option>";
    
                    return markup;                
                },
                formatSelection: function(m){
                    return m.text;
                },
                escapeMarkup: function (m) { return m; }
            })

            $(".remote-data-brand-compare").select2({
                ajax: {
                    url: "{{URL::to('cmv/data/list-brand')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params, // search term
                            category:$("#category").val(),
                            page_limit: 30
                        };
                    },
                    results: function (data, page){
                        return {
                            results: data.data
                        };
                    },
                    cache: true,
                    pagination: {
                        more: true
                    }
                },
                formatResult: function(m){
                    var markup="<option value='"+m.id+"'>"+m.text+"</option>";
    
                    return markup;                
                },
                formatSelection: function(m){
                    return m.text;
                },
                escapeMarkup: function (m) { return m; }
            })

            
            $(document).on("submit","#formCompetitive",function(e){
                var data = new FormData(this);
                data.append("_token","{{ csrf_token() }}");
                if($("#formCompetitive")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('cmv/data/list-competitive-map')}}",
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $('#competitiveMap').empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {
                            var el="<div class='row'>"+
                                '<div class="col-lg-5">'+
                                    '<div class="panel panel-primary">'+
                                        '<div class="panel-heading">'+data.brand.brand_name+'</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">GENDER</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="competitiveGender" style="width:100%;height:130px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">SEC</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="competitiveSec" style="width:100%;height:130px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">AGE</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="competitiveAge" style="width:100%;height:130px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">EDUCATION</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="competitiveEducation" style="width:100%;height:130px;"></div>'+
                                        '</div>'+
                                    '</div>'+
                                    
                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">OCCUPATION</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="competitiveOccupation" style="width:100%;height:200px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">HOBBY</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="competitiveHobby" style="width:100%;height:300px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">MEDIA</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="competitiveMedia" style="width:100%;height:220px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">CITIES</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="competitiveCities" style="width:100%;height:300px;"></div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+

                                '<div class="col-lg-7">'+
                                    '<div class="row">'+
                                        '<div id="comparewith"></div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';

                            $("#competitiveMap").empty().html(el);
                            competitiveGender(data.list);
                            competitiveSec(data.list);
                            competitiveAge(data.list);
                            competitiveEducation(data.list);
                            competitiveOccupation(data.list);
                            competitiveHobby(data.list);
                            competitiveMedia(data.list);
                            competitiveCities(data.list);
                            comparewith();
                        },
                        error   :function() {  
                            $('#competitiveMap').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            })

            function competitiveGender(data){
                var value=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D1"){
                        nama.push(b.subdemo_name);
                        value.push(parseInt(b.totals_ver));
                    }
                })
                
                $("#competitiveGender").empty();

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
                            "values": value,
                            "alpha": 1,
                            "background-color": "#3a76bf",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
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
                    id: 'competitiveGender',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });
            }

            function competitiveSec(data){
                var value=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D3"){
                        nama.push(b.subdemo_name);
                        value.push(parseInt(b.totals_ver));
                    }
                })
                
                $("#competitiveSec").empty();

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
                            "values": value,
                            "alpha": 1,
                            "background-color": "#92d050",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
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
                    id: 'competitiveSec',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });
            }

            function competitiveAge(data){
                var value=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D2"){
                        nama.push(b.subdemo_name);
                        value.push(parseInt(b.totals_ver));
                    }
                })
                
                $("#competitiveAge").empty();

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
                        "margin": "2% 2% 15% 25%"
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
                            "values": value,
                            "alpha": 1,
                            "background-color": "#31859c",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
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
                    id: 'competitiveAge',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });
            }

            function competitiveEducation(data){
                var value=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D4"){
                        nama.push(b.subdemo_name);
                        value.push(parseInt(b.totals_ver));
                    }
                })
                
                $("#competitiveEducation").empty();

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
                        "margin": "2% 2% 15% 25%"
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
                            "values": value,
                            "alpha": 1,
                            "background-color": "#e46c0a",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
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
                    id: 'competitiveEducation',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });
            }

            function competitiveOccupation(data){
                var value=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D5"){
                        nama.push(b.subdemo_name);
                        value.push(parseInt(b.totals_ver));
                    }
                })
                
                $("#competitiveOccupation").empty();

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
                        "margin": "2% 2% 15% 30%"
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
                            "font-color": "#999",
                            "font-size":"10px"
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
                            "values": value,
                            "alpha": 1,
                            "background-color": "#948a54",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
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
                    id: 'competitiveOccupation',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });
            }

            function competitiveHobby(data){
                var value=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D6"){
                        nama.push(b.subdemo_name);
                        value.push(parseInt(b.totals_ver));
                    }
                })
                
                $("#competitiveHobby").empty();

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
                        "margin": "2% 2% 15% 30%"
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
                            "font-color": "#999",
                            "font-size":"10px"
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
                            "values": value,
                            "alpha": 1,
                            "background-color": "#604a7b",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
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
                    id: 'competitiveHobby',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });
            }

            function competitiveMedia(data){
                var value=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D7"){
                        nama.push(b.subdemo_name);
                        value.push(parseInt(b.totals_ver));
                    }
                })
                
                $("#competitiveMedia").empty();

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
                        "margin": "2% 2% 15% 30%"
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
                            "font-color": "#999",
                            "font-size":"10px"
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
                            "values": value,
                            "alpha": 1,
                            "background-color": "#c0504d",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
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
                    id: 'competitiveMedia',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });
            }

            function competitiveCities(data){
                var value=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D8"){
                        nama.push(b.subdemo_name);
                        value.push(parseInt(b.totals_ver));
                    }
                })
                
                $("#competitiveCities").empty();

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
                        "margin": "2% 2% 15% 25%"
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
                            "font-color": "#999",
                            "font-size":"10px"
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
                            "values": value,
                            "alpha": 1,
                            "background-color": "#632523",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
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
                    id: 'competitiveCities',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });
            }

            function comparewith(){
                var brand=$("#brand2").val();
                var compare=$("#compare2").val();
                $.ajax({
                    url:"{{URL::to('cmv/data/compare-with')}}",
                    type:"GET",
                    data:"brand="+brand+"&compare="+compare,
                    beforeSend:function(){
                        $("#comparewith").empty().html('<div class="alert alert-success"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Comparing Data. . . </div>');
                    },
                    success:function(result){
                        var el="";
                        $.each(result.compare,function(a,b){
                            el+="<div class='col-lg-4'>"+
                                    '<div class="panel panel-info">'+
                                        '<div class="panel-heading">'+
                                            b.brand_name+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">GENDER</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="compareGender'+b.brand_id+'" style="width:100%;height:130px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">SEC</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="compareSec'+b.brand_id+'" style="width:100%;height:130px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">AGE</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="compareAge'+b.brand_id+'" style="width:100%;height:130px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">EDUCATION</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="compareEducation'+b.brand_id+'" style="width:100%;height:130px;"></div>'+
                                        '</div>'+
                                    '</div>'+
                                    
                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">OCCUPATION</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="compareOccupation'+b.brand_id+'" style="width:100%;height:200px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">HOBBY</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="compareHobby'+b.brand_id+'" style="width:100%;height:300px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">MEDIA</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="compareMedia'+b.brand_id+'" style="width:100%;height:220px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">CITIES</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="compareCities'+b.brand_id+'" style="width:100%;height:300px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                '</div>';
                        })

                        $("#comparewith").empty().html(el);

                        compareGender(result.compare,result.list);
                        compareSec(result.compare,result.list);
                        compareAge(result.compare,result.list);
                        compareEducation(result.compare,result.list);
                        compareOccupation(result.compare,result.list);
                        compareHobby(result.compare,result.list);
                        compareMedia(result.compare,result.list);
                        compareCities(result.compare,result.list);
                    },
                    error:function(){
                        $("#comparewith").empty().html("<div class='alert alert-danger'>Opss.. failed data to load</div>");
                    }
                })
            }

            function compareGender(compare,list){
                $.each(compare,function(a,b){
                    var val=[];

                    $.each(list,function(c,d){
                        if(d.demo_id=="D1" && d.brand_id==b.brand_id){
                            if(d.total>0){
                                var bg="#68d7c6";
                                var text=d.subdemo_name;
                            }else{
                                var bg="#fd625e";
                                var text=d.subdemo_name
                            }
                            val.push(
                                {
                                    values: [parseInt(d.total)],
                                    stack: c,
                                    'data-custom-token': [parseInt(d.total)],
                                    text:text,
                                    valueBox:{  
                                        "text":'%data-custom-token',
                                        "placement":'bottom'
                                    },
                                    backgroundColor:bg
                                }
                            )
                        }
                    })

                    var myConfig = {
                        type: 'hbar',
                        stacked: true,
                        plotarea:{
                            margin: 'dynamic'
                        },
                        tooltip:{
                            text:"%t %negation%v",
                            decimals: 2,
                            align: 'left',
                            borderRadius: 3,
                            fontColor:"#ffffff",
                            negation: 'currency'
                        },
                        plot:{
                            valueBox:{
                                text:"%total",
                                rules: [
                                    {
                                        rule: '%stack-top == 0',
                                        visible: 0
                                    }
                                ]
                            }
                        },
                        series: val
                    };
                    
                    zingchart.render({ 
                        id : 'compareGender'+b.brand_id, 
                        data: myConfig, 
                        height: '100%', 
                        width: '100%' 
                    });
                })
            }

            function compareSec(compare,list){
                $.each(compare,function(a,b){
                    var val=[];

                    $.each(list,function(c,d){
                        if(d.demo_id=="D3" && d.brand_id==b.brand_id){
                            if(d.total>0){
                                var bg="#68d7c6";
                                var text=d.subdemo_name;
                            }else{
                                var bg="#fd625e";
                                var text=d.subdemo_name
                            }
                            val.push(
                                {
                                    values: [parseInt(d.total)],
                                    stack: c,
                                    'data-custom-token': [parseInt(d.total)],
                                    text:text,
                                    valueBox:{  
                                        "text":'%data-custom-token',
                                        "placement":'bottom'
                                    },
                                    backgroundColor:bg
                                }
                            )
                        }
                    })

                    var myConfig = {
                        type: 'hbar',
                        stacked: true,
                        plotarea:{
                            margin: 'dynamic'
                        },
                        tooltip:{
                            text:"%t %negation%v",
                            decimals: 2,
                            align: 'left',
                            borderRadius: 3,
                            fontColor:"#ffffff",
                            negation: 'currency'
                        },
                        plot:{
                            valueBox:{
                                text:"%total",
                                rules: [
                                    {
                                        rule: '%stack-top == 0',
                                        visible: 0
                                    }
                                ]
                            }
                        },
                        series: val
                    };
                    
                    zingchart.render({ 
                        id : 'compareSec'+b.brand_id, 
                        data: myConfig, 
                        height: '100%', 
                        width: '100%' 
                    });
                })
            }

            function compareAge(compare,list){
                $.each(compare,function(a,b){
                    var val=[];

                    $.each(list,function(c,d){
                        if(d.demo_id=="D2" && d.brand_id==b.brand_id){
                            if(d.total>0){
                                var bg="#68d7c6";
                                var text=d.subdemo_name;
                            }else{
                                var bg="#fd625e";
                                var text=d.subdemo_name
                            }
                            val.push(
                                {
                                    values: [parseInt(d.total)],
                                    stack: c,
                                    'data-custom-token': [parseInt(d.total)],
                                    text:text,
                                    valueBox:{  
                                        "text":'%data-custom-token',
                                        "placement":'bottom'
                                    },
                                    backgroundColor:bg
                                }
                            )
                        }
                    })

                    var myConfig = {
                        type: 'hbar',
                        stacked: true,
                        plotarea:{
                            margin: 'dynamic'
                        },
                        tooltip:{
                            text:"%t %negation%v",
                            decimals: 2,
                            align: 'left',
                            borderRadius: 3,
                            fontColor:"#ffffff",
                            negation: 'currency'
                        },
                        plot:{
                            valueBox:{
                                text:"%total",
                                rules: [
                                    {
                                        rule: '%stack-top == 0',
                                        visible: 0
                                    }
                                ]
                            }
                        },
                        series: val
                    };
                    
                    zingchart.render({ 
                        id : 'compareAge'+b.brand_id, 
                        data: myConfig, 
                        height: '100%', 
                        width: '100%' 
                    });
                })
            }

            function compareEducation(compare,list){
                $.each(compare,function(a,b){
                    var val=[];

                    $.each(list,function(c,d){
                        if(d.demo_id=="D4" && d.brand_id==b.brand_id){
                            if(d.total>0){
                                var bg="#68d7c6";
                                var text=d.subdemo_name;
                            }else{
                                var bg="#fd625e";
                                var text=d.subdemo_name
                            }
                            val.push(
                                {
                                    values: [parseInt(d.total)],
                                    stack: c,
                                    'data-custom-token': [parseInt(d.total)],
                                    text:text,
                                    valueBox:{  
                                        "text":'%data-custom-token',
                                        "placement":'bottom'
                                    },
                                    backgroundColor:bg
                                }
                            )
                        }
                    })

                    var myConfig = {
                        type: 'hbar',
                        stacked: true,
                        plotarea:{
                            margin: 'dynamic'
                        },
                        tooltip:{
                            text:"%t %negation%v",
                            decimals: 2,
                            align: 'left',
                            borderRadius: 3,
                            fontColor:"#ffffff",
                            negation: 'currency'
                        },
                        plot:{
                            valueBox:{
                                text:"%total",
                                rules: [
                                    {
                                        rule: '%stack-top == 0',
                                        visible: 0
                                    }
                                ]
                            }
                        },
                        series: val
                    };
                    
                    zingchart.render({ 
                        id : 'compareEducation'+b.brand_id, 
                        data: myConfig, 
                        height: '100%', 
                        width: '100%' 
                    });
                })
            }

            function compareOccupation(compare,list){
                $.each(compare,function(a,b){
                    var val=[];

                    $.each(list,function(c,d){
                        if(d.demo_id=="D5" && d.brand_id==b.brand_id){
                            if(d.total>0){
                                var bg="#68d7c6";
                                var text=d.subdemo_name;
                            }else{
                                var bg="#fd625e";
                                var text=d.subdemo_name
                            }
                            val.push(
                                {
                                    values: [parseInt(d.total)],
                                    stack: c,
                                    'data-custom-token': [parseInt(d.total)],
                                    text:text,
                                    valueBox:{  
                                        "text":'%data-custom-token',
                                        "placement":'bottom'
                                    },
                                    backgroundColor:bg
                                }
                            )
                        }
                    })

                    var myConfig = {
                        type: 'hbar',
                        stacked: true,
                        plotarea:{
                            margin: 'dynamic'
                        },
                        tooltip:{
                            text:"%t %negation%v",
                            decimals: 2,
                            align: 'left',
                            borderRadius: 3,
                            fontColor:"#ffffff",
                            negation: 'currency'
                        },
                        plot:{
                            valueBox:{
                                text:"%total",
                                rules: [
                                    {
                                        rule: '%stack-top == 0',
                                        visible: 0
                                    }
                                ]
                            }
                        },
                        series: val
                    };
                    
                    zingchart.render({ 
                        id : 'compareOccupation'+b.brand_id, 
                        data: myConfig, 
                        height: '100%', 
                        width: '100%' 
                    });
                })
            }

            function compareHobby(compare,list){
                $.each(compare,function(a,b){
                    var val=[];

                    $.each(list,function(c,d){
                        if(d.demo_id=="D6" && d.brand_id==b.brand_id){
                            if(d.total>0){
                                var bg="#68d7c6";
                                var text=d.subdemo_name;
                            }else{
                                var bg="#fd625e";
                                var text=d.subdemo_name
                            }
                            val.push(
                                {
                                    values: [parseInt(d.total)],
                                    stack: c,
                                    'data-custom-token': [parseInt(d.total)],
                                    text:text,
                                    valueBox:{  
                                        "text":'%data-custom-token',
                                        "placement":'bottom'
                                    },
                                    backgroundColor:bg
                                }
                            )
                        }
                    })

                    var myConfig = {
                        type: 'hbar',
                        stacked: true,
                        plotarea:{
                            margin: 'dynamic'
                        },
                        tooltip:{
                            text:"%t %negation%v",
                            decimals: 2,
                            align: 'left',
                            borderRadius: 3,
                            fontColor:"#ffffff",
                            negation: 'currency'
                        },
                        plot:{
                            valueBox:{
                                text:"%total",
                                rules: [
                                    {
                                        rule: '%stack-top == 0',
                                        visible: 0
                                    }
                                ]
                            }
                        },
                        series: val
                    };
                    
                    zingchart.render({ 
                        id : 'compareHobby'+b.brand_id, 
                        data: myConfig, 
                        height: '100%', 
                        width: '100%' 
                    });
                })
            }

            function compareMedia(compare,list){
                $.each(compare,function(a,b){
                    var val=[];

                    $.each(list,function(c,d){
                        if(d.demo_id=="D7" && d.brand_id==b.brand_id){
                            if(d.total>0){
                                var bg="#68d7c6";
                                var text=d.subdemo_name;
                            }else{
                                var bg="#fd625e";
                                var text=d.subdemo_name
                            }
                            val.push(
                                {
                                    values: [parseInt(d.total)],
                                    stack: c,
                                    'data-custom-token': [parseInt(d.total)],
                                    text:text,
                                    valueBox:{  
                                        "text":'%data-custom-token',
                                        "placement":'bottom'
                                    },
                                    backgroundColor:bg
                                }
                            )
                        }
                    })

                    var myConfig = {
                        type: 'hbar',
                        stacked: true,
                        plotarea:{
                            margin: 'dynamic'
                        },
                        tooltip:{
                            text:"%t %negation%v",
                            decimals: 2,
                            align: 'left',
                            borderRadius: 3,
                            fontColor:"#ffffff",
                            negation: 'currency'
                        },
                        plot:{
                            valueBox:{
                                text:"%total",
                                rules: [
                                    {
                                        rule: '%stack-top == 0',
                                        visible: 0
                                    }
                                ]
                            }
                        },
                        series: val
                    };
                    
                    zingchart.render({ 
                        id : 'compareMedia'+b.brand_id, 
                        data: myConfig, 
                        height: '100%', 
                        width: '100%' 
                    });
                })
            }

            function compareCities(compare,list){
                $.each(compare,function(a,b){
                    var val=[];

                    $.each(list,function(c,d){
                        if(d.demo_id=="D8" && d.brand_id==b.brand_id){
                            if(d.total>0){
                                var bg="#68d7c6";
                                var text=d.subdemo_name;
                            }else{
                                var bg="#fd625e";
                                var text=d.subdemo_name
                            }
                            val.push(
                                {
                                    values: [parseInt(d.total)],
                                    stack: c,
                                    'data-custom-token': [parseInt(d.total)],
                                    text:text,
                                    valueBox:{  
                                        "text":'%data-custom-token',
                                        "placement":'bottom'
                                    },
                                    backgroundColor:bg
                                }
                            )
                        }
                    })

                    var myConfig = {
                        type: 'hbar',
                        stacked: true,
                        plotarea:{
                            margin: 'dynamic'
                        },
                        tooltip:{
                            text:"%t %negation%v",
                            decimals: 2,
                            align: 'left',
                            borderRadius: 3,
                            fontColor:"#ffffff",
                            negation: 'currency'
                        },
                        plot:{
                            valueBox:{
                                text:"%total",
                                rules: [
                                    {
                                        rule: '%stack-top == 0',
                                        visible: 0
                                    }
                                ]
                            }
                        },
                        series: val
                    };
                    
                    zingchart.render({ 
                        id : 'compareCities'+b.brand_id, 
                        data: myConfig, 
                        height: '100%', 
                        width: '100%' 
                    });
                })
            }
        })
    </script>
@stop

@section('css')
    <style>
        #topBrand {
            height: 450px;
            width: 750px;
        }

        #divGender {
            height: 100%;
            width: 100%;
        }

        #divAge {
            height: 100%;
            width: 100%;
        }

        #divSec {
            height: 100%;
            width: 100%;
        }

        #divEducation {
            height: 100%;
            width: 100%;
        }

        #divOccupation {
            height: 100%;
            width: 100%;
        }

        #divHobby {
            height: 100%;
            width: 100%;
        }

        #divPsiko {
            height: 100%;
            width: 100%;
        }

        #divMedia {
            height: 100%;
            width: 100%;
        }

        #divCity {
            height: 100%;
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
@stop

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title"><span class="text-semibold">Competitive</span> Map</h6>
        </div>
        <div class="panel-body">
            <form id="formCompetitive" onsubmit="return false">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="control-label">Category</label>
                            <input type="text" name="category" id="category" class="remote-data-category">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="control-label">Brand</label>
                            <input type="text" name="brand" id="brand2" class="remote-data-brand-compare">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">Compare With</label>
                            <input type="text" name="compare" id="compare2" class="remote-data-brand-competitive">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="control-label">Quartal</label>
                            <select name="quartal" class="form-control">
                                <option value="42017">42017</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <button class="btn btn-primary" style="margin-top:25px;">
                                <i class="icon-filter4"></i>
                                Filter 
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="competitiveMap"></div>

    
@stop
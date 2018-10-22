@extends('layouts.coreui.main')

@section('extra-style')
    <style>
        #zingchart-dailyByCategory{
            width: 960px;
            height: 300px;
        }
        #zingchart-dailyBySector{
            width: 960px;
            height: 300px;
        }
    </style>
@stop

@section('content')
    <div class="card">
        <div class="card-header">SUMMARY</div>
        <div class="card-body">
            <form id="formTop" onsubmit="return false;">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="" class="control-label">Advertiser</label>
                            <select name="advertiser" id="advertiser" class="form-control">
                                <option value="" disabled>--Pilih Advertiser--</option>
                                @foreach($adv as $row)
                                    <option value="{{$row->advertiser_id}}">{{$row->advertiser->nama_adv}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <label for="" class="control-label">Tanggal</label>
                        <input type="text" name="tanggal" id="tanggal" data-value="{{date('Y/m/d')}}" class="form-control daterange-single">
                    </div>

                    <div class="col-lg-3">
                        <button class='btn btn-primary' style="margin-top:25px;">
                            <i class="icon-filter4"></i> &nbsp;
                            Filter 
                        </button>
                    </div>

                </div>
            </form>

            <hr>
            <div id="zingchart-1"></div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Category</div>
        <div class="card-body">
            <form id="formCategory" onsubmit="return false;">
                <div class="row">
                    <div class="col-lg-4">
                        <label for="" class="control-label">Category</label>
                        <div id="showListCategory"></div>
                    </div>

                    <div class="col-lg-3">
                        <label for="" class="control-label">Tanggal</label>
                        <input type="text" name="tanggal" id="tanggal2" data-value="{{date('Y/m/d')}}" class="form-control daterange-single">
                    </div>

                    <div class="col-lg-3">
                        <button class='btn btn-primary' style="margin-top:25px;">
                            <i class="icon-filter4"></i> &nbsp;
                            Filter 
                        </button>
                    </div>
                </div>
            </form>
            <hr>
            <div id="zingchart-dailyByCategory"></div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Sector</div>
        <div class="card-body">
            <form id="formSector" onsubmit="return false;">
                <div class="row">
                    <div class="col-lg-4">
                        <label for="" class="control-label">Sector</label>
                        <div id="showListSector"></div>
                    </div>

                    <div class="col-lg-3">
                        <label for="" class="control-label">Tanggal</label>
                        <input type="text" name="tanggal" id="tanggal3" data-value="{{date('Y/m/d')}}" class="form-control daterange-single">
                    </div>

                    <div class="col-lg-3">
                        <button class='btn btn-primary' style="margin-top:25px;">
                            <i class="icon-filter4"></i> &nbsp;
                            Filter 
                        </button>
                    </div>

                </div>
            </form>
            <hr>
            <div id="zingchart-dailyBySector"></div>
        </div>
    </div>
@stop

@section('js')
    <script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
    <script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9","ee6b7db5b51705a13dc2339db3edaf6d"];</script>
    <script>
        $(function(){
            var category=241;
            var sector=103;

            $("#advertiser").val(1837);

            $('.daterange-single').pickadate({
                format: 'yyyy/mm/dd',
                formatSubmit: 'yyyy/mm/dd',
                max:true,
            });

            function dailyByAdvertiser(){
                var advertiser=$("#advertiser option:selected").val();
                var tanggal=$("#tanggal").val();

                var param={
                    advertiser:advertiser,
                    tanggal:tanggal
                };

                $.ajax({
                    url:"{{URL::to('brand/data/chart/daily-by-advertiser')}}",
                    type:"GET",
                    data:param,
                    beforeSend:function(){
                        $("#zingchart-1").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
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

                        $.each(result,function(a,b){
                            labels1.push(b.brand_name_alias);

                            facebook1.push(parseFloat(b.fb));
                            twitter1.push(parseFloat(b.tw));
                            instagram1.push(parseFloat(b.ig));
                            youtube1.push(parseFloat(b.yt));
                        })
                        
                        /* tear 1 */
                        var chartConfig1 = {
                            "type": "hbar",
                            "plot": {
                                "stacked": true,
                                "thousands-separator":",",
                                "valueBox":{
                                    "text":"%total",
                                    "color":"#222222",
                                    "rules": [
                                        {
                                            "rule": '%stack-top == 0',
                                            "visible": 0
                                        }
                                    ]
                                }
                            },
                            "plotarea": {
                                "margin": "2% 15% 15% 10%"
                                // margin: 'dynamic dynamic dynamic dynamic',
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
                                    "font-size": "9px"
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
                                "text": "<div  class='zingchart-tooltip'><div class='scalex-value'>%kt - %t<\/div><div class='scaley-value'>%v <\/div><\/div>"
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
                                    "background-color": "#a958a5"
                                },
                                {
                                    "values": youtube1,
                                    "text": "Youtube",
                                    "background-color": "#f06261"
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
                    },
                    errors:function(){
                        
                    }
                })
            }

            function dailyByCategory(){
                var category=$("#category option:selected").val();
                var tanggal=$("#tanggal2").val();

                var param={
                    category:category,
                    tanggal:tanggal
                };

                $.ajax({
                    url:"{{URL::to('brand/data/chart/daily-by-category')}}",
                    type:"GET",
                    data:param,
                    beforeSend:function(){
                        $("#zingchart-dailyByCategory").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        $("#zingchart-dailyByCategory").empty();
                        var primaryColor = "#4184F3";
                        var primaryColorHover = "#3a53c5";
                        var secondaryColor = '#DCDCDC'
                        var scaleTextColor = '#999';

                        var labels1=[];
                        var facebook1=[];
                        var twitter1=[];
                        var instagram1=[];
                        var youtube1=[];

                        $.each(result,function(a,b){
                            labels1.push(b.brand_name_alias);

                            facebook1.push(parseFloat(b.fb));
                            twitter1.push(parseFloat(b.tw));
                            instagram1.push(parseFloat(b.ig));
                            youtube1.push(parseFloat(b.yt));
                        })
                        
                        /* tear 1 */
                        var chartConfig1 = {
                            "type": "hbar",
                            "plot": {
                                "stacked": true,
                                "thousands-separator":",",
                                "valueBox":{
                                    "text":"%total",
                                    "color":"#222222",
                                    "rules": [
                                        {
                                            "rule": '%stack-top == 0',
                                            "visible": 0
                                        }
                                    ]
                                }
                            },
                            "plotarea": {
                                "margin": "2% 15% 15% 10%"
                                // margin: 'dynamic dynamic dynamic dynamic',
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
                                    "font-size": "9px"
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
                                "text": "<div  class='zingchart-tooltip'><div class='scalex-value'>%kt - %t<\/div><div class='scaley-value'>%v <\/div><\/div>"
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
                                    "background-color": "#a958a5"
                                },
                                {
                                    "values": youtube1,
                                    "text": "Youtube",
                                    "background-color": "#f06261"
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
                            id: 'zingchart-dailyByCategory',
                            data: chartConfig1,
                            output: 'canvas',
                            height:'100%',
                            width:'100%'
                        });
                        /* end tear 1 */
                    },
                    errors:function(){
                        
                    }
                })
            }

            function dailyBySector(){
                var sector=$("#sector option:selected").val();
                var tanggal=$("#tanggal2").val();

                var param={
                    sector:sector,
                    tanggal:tanggal
                };

                $.ajax({
                    url:"{{URL::to('brand/data/chart/daily-by-sector')}}",
                    type:"GET",
                    data:param,
                    beforeSend:function(){
                        $("#zingchart-dailyBySector").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        $("#zingchart-dailyBySector").empty();
                        var primaryColor = "#4184F3";
                        var primaryColorHover = "#3a53c5";
                        var secondaryColor = '#DCDCDC'
                        var scaleTextColor = '#999';

                        var labels1=[];
                        var facebook1=[];
                        var twitter1=[];
                        var instagram1=[];
                        var youtube1=[];

                        $.each(result,function(a,b){
                            labels1.push(b.brand_name_alias);

                            facebook1.push(parseFloat(b.fb));
                            twitter1.push(parseFloat(b.tw));
                            instagram1.push(parseFloat(b.ig));
                            youtube1.push(parseFloat(b.yt));
                        })
                        
                        /* tear 1 */
                        var chartConfig1 = {
                            "type": "hbar",
                            "plot": {
                                "stacked": true,
                                "thousands-separator":",",
                                "valueBox":{
                                    "text":"%total",
                                    "color":"#222222",
                                    "rules": [
                                        {
                                            "rule": '%stack-top == 0',
                                            "visible": 0
                                        }
                                    ]
                                }
                            },
                            "plotarea": {
                                "margin": "2% 15% 15% 10%"
                                // margin: 'dynamic dynamic dynamic dynamic',
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
                                    "font-size": "9px"
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
                                "text": "<div  class='zingchart-tooltip'><div class='scalex-value'>%kt - %t<\/div><div class='scaley-value'>%v <\/div><\/div>"
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
                                    "background-color": "#a958a5"
                                },
                                {
                                    "values": youtube1,
                                    "text": "Youtube",
                                    "background-color": "#f06261"
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
                            id: 'zingchart-dailyBySector',
                            data: chartConfig1,
                            output: 'canvas',
                            height:'100%',
                            width:'100%'
                        });
                        /* end tear 1 */
                    },
                    errors:function(){
                        
                    }
                })
            }

            function listAvailableCategory(){
                $.ajax({
                    url:"{{URL::to('brand/data/list-available-category')}}",
                    type:"GET",
                    beforeSend:function(){
                        $("#showListCategory").empty().html("<div class='alert alert-info'>Please Wait. . </div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<select name='category' id='category' class='form-control'>"+
                            "<option value='' disabled >--Pilih Category--</option>";
                            $.each(result,function(a,b){
                                el+="<option value='"+b.id_category+"'>"+b.name_category+"</option>";
                            })
                        el+="</select>";

                        $("#showListCategory").empty().html(el);
                        $("#category").select2();
                        $("#category").val(category);

                        dailyByCategory();
                    },
                    errors:function(){

                    }
                })
            }

            function listAvailableSector(){
                $.ajax({
                    url:"{{URL::to('brand/data/list-available-sector')}}",
                    type:"GET",
                    beforeSend:function(){
                        $("#showListSector").empty().html("<div class='alert alert-info'>Please Wait. . </div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<select name='sector' id='sector' class='form-control'>"+
                            "<option value='' disabled>--Pilih Sector--</option>";
                            $.each(result,function(a,b){
                                el+="<option value='"+b.id_sector+"'>"+b.name_sector+"</option>";
                            })
                        el+="</select>";

                        $("#showListSector").empty().html(el);
                        $("#sector").select2();
                        $("#sector").val(sector);

                        dailyBySector();
                    },
                    errors:function(){

                    }
                })
            }

            $(document).on("submit","#formTop",function(e){
                dailyByAdvertiser();
            })
            
            $(document).on("submit","#formCategory",function(e){
                dailyByCategory();
            })

            $(document).on("submit","#formSector",function(e){
                dailyBySector();
            })

            listAvailableCategory();
            listAvailableSector();
            dailyByAdvertiser();
            
            
        })
    </script>
@stop
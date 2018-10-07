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
    <div class="card">
        <div class="card-header">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">{{$group->group_name}}</h4>
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
                                    <option value="artist">Artist</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="card-body">
            <div id="zingchart-1"></div>
            <div id="showUnit"></div>
        </div>

        <div class="card-footer">
            <div class="row text-center">
                <div class="col-sm-12 col-md mb-sm-3 mb-0">
                    <div class="text-muted">TOTAL TWITTER</div>
                    <strong id="total_twitter_group">29.703</strong>
                </div>

                <div class="col-sm-12 col-md mb-sm-3 mb-0">
                    <div class="text-muted">TOTAL FACEBOOK</div>
                    <strong id="total_facebook_group">24.093</strong>
                </div>

                <div class="col-sm-12 col-md mb-sm-3 mb-0">
                    <div class="text-muted">TOTAL INSTAGRAM</div>
                    <strong id="total_instagram_group">78.706</strong>
                </div>

                <div class="col-sm-12 col-md mb-sm-3 mb-0">
                    <div class="text-muted">TOTAL YOUTUBE</div>
                    <strong id="total_youtube_group">22.123</strong>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
    <script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9","ee6b7db5b51705a13dc2339db3edaf6d"];</script>
    <script>
        $(function(){
            var id="{{$group->id}}";

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


            function showUnit(){
                var tanggal=$("#tanggal").val();
                var filter=$("#filter").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/list-official-program-by-group')}}/"+id,
                    data:"tanggal="+tanggal+"&filter="+filter,
                    type:"GET",
                    beforeSend:function(){
                        $("#zingchart-1").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                        $("#showUnit").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
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
                        
                        $.each(result.chart,function(a,b){
                            if(b.id!=null){
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

                        var el="";
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
                                                            "<td>"+d.total_twitter+"</td>"+
                                                            "<td>"+d.total_facebook+"</td>"+
                                                            "<td>"+d.total_instagram+"</td>"+
                                                            "<td>"+d.total_youtube+"</td>"+
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

                        $("#showUnit").empty().html(el);

                        $("#tableunit").DataTable();
                    },
                    errors:function(){

                    }
                })
            }

            $(document).on("change","#filter",function(){
                showUnit();
            })

            $(document).on("change","#tanggal",function(){
                showUnit();
            })

            showUnit();
        })
    </script>
@stop
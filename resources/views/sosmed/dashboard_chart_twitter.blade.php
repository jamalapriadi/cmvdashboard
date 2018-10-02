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
    <div class="card card-primary">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @if($idsosmed==1)
                            TWITTER 
                        @elseif($idsosmed==2)
                            FACEBOOK 
                        @elseif($idsosmed==3)
                            INSTAGRAM 
                        @elseif($idsosmed==4)
                            YOUTUBE 
                        @else 

                        @endif
                    </h4>
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
            <div class="card card-accent-primary">
                <div class="card-header text-center">BY MEDIA PLATFORM</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="" class="control-label">Date</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                                    </div>
                                    <input type="text" id="tanggalMediaPlatform" data-value="{{date('Y/m/d')}}" name="tanggalMediaPlatform" class="form-control daterange-single">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="" class="control-label">Socmed Type</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="icon-filter3"></i></span>
                                    </div>
                                    <select name="filterMediaPlatform" id="filterMediaPlatform" class="form-control bg-primary">
                                        <option value="all">All</option>
                                        <option value="official">Official</option>
                                        <option value="program">Program</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="" class="control-label"></label>
                                <button class="btn btn-primary" id="filterMediaFlatformSearch" style="margin-top:25px;"><i class="icon-filter3"></i> Filter</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div id="zingchart-typeunit"></div>
                    <hr>
                    <div id="showTypeUnit"></div>
                </div>
            </div>

            <div class="card card-accent-primary">
                <div class="card-header text-center">BY UNIT MEDIA TYPE</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="" class="control-label">Date</label>
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
                                <label for="" class="control-label">Socmed Type</label>
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
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="" class="control-label">Unit Type</label>
                                <select name="typeunit" id="typeunit" class="form-control">
                                    <option value="TV">TV</option>
                                    <option value="Publisher">Hardnews Portal & Print</option>
                                    <option value="Radio">Radio</option>
                                    <option value="KOL">Artist</option>
                                    <option value="Animation Production">Animation Production</option>
                                    <option value="Production House">Production House</option>
                                    <option value="PAYTV,IPTV,OTT">PAYTV,IPTV,OTT</option>
                                    {{-- <option value="Newspaper">Newspaper</option> --}}
                                    <option value="Magazine">Magazine</option>
                                    <option value="SMN Channel">SMN Channel</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="" class="control-label">Sort By</label>
                                <select name="sortby" id="sortby" class="form-control">
                                    <option value="hight">High</option>
                                    <option value="low">Low</option>
                                    <option value="group">Group</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="" class="control-label"></label>
                                <button class="btn btn-primary" id="filterOfficial2" style="margin-top:25px;"><i class="icon-filter3"></i> Filter</button>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div id="zingchart-1"><a class="zc-ref" href="https://www.zingchart.com/">Charts by ZingChart</a></div>

                    <div id="showUnit"></div>
                </div>
            </div>

            <div class="card card-accent-primary">
                <div class="card-header text-center">GROUP BY MEDIA TYPE</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="" class="control-label">Date</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                                    </div>
                                    <input type="text" id="tanggalType" data-value="{{date('Y/m/d')}}" name="tanggal" class="form-control daterange-single">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="" class="control-label">Socmed Type</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="icon-filter3"></i></span>
                                    </div>
                                    <select name="type" id="type2" class="form-control bg-primary">
                                        <option value="all">All</option>
                                        <option value="official">Official</option>
                                        <option value="program">Program</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="" class="control-label">Unit Type</label>
                                <select name="typeunit" id="typeunit2" class="form-control">
                                    <option value="TV">TV</option>
                                    <option value="Publisher">Hardnews Portal & Print</option>
                                    <option value="Radio">Radio</option>
                                    <option value="KOL">Artist</option>
                                    <option value="Animation Production">Animation Production</option>
                                    <option value="Production House">Production House</option>
                                    <option value="PAYTV,IPTV,OTT">PAYTV,IPTV,OTT</option>
                                    {{-- <option value="Newspaper">Newspaper</option> --}}
                                    <option value="Magazine">Magazine</option>
                                    <option value="SMN Channel">SMN Channel</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="" class="control-label"></label>
                                <button class="btn btn-primary" id="filterType" style="margin-top:25px;"><i class="icon-filter3"></i> Filter</button>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div id="zingchart-groupMediaType"></div>

                    <div id="groupMediaType"></div>
                </div>

                {{-- <div class="card-footer">
                    <div class="row text-center">
                        <div class="col-sm-12 col-md mb-sm-3 mb-0">
                            <div class="text-muted">TOTAL TWITTER</div>
                            <strong id="total_twitter_group_type">0</strong>
                        </div>
        
                        <div class="col-sm-12 col-md mb-sm-3 mb-0">
                            <div class="text-muted">TOTAL FACEBOOK</div>
                            <strong id="total_facebook_group_type">0</strong>
                        </div>
        
                        <div class="col-sm-12 col-md mb-sm-3 mb-0">
                            <div class="text-muted">TOTAL INSTAGRAM</div>
                            <strong id="total_instagram_group_type">0</strong>
                        </div>
        
                        <div class="col-sm-12 col-md mb-sm-3 mb-0">
                            <div class="text-muted">TOTAL YOUTUBE</div>
                            <strong id="total_youtube_group_type">0</strong>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

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
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="" class="control-label">Type Unit</label>
                        <select name="typeunit" id="typeunit" class="form-control">
                            {{-- <option value="" disabled selected>--Select Type Unit--</option> --}}
                            <option value="TV">TV</option>
                            <option value="Publisher">Hardnews Portal</option>
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
            <div id="chartOfficial"></div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-lg-6">
            <div class="card card-default">
                <div class="card-header">
                    Official {{strtoupper($id)}} All TV

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
                    TOP 10 {{strtoupper($id)}} Program

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
    </div> --}}

    <div class="card card-default">
        <div class="card-header">Growth {{strtoupper($id)}} Program</div>
        <div class="card-body">
            <div id="pesan"></div>
            
            <form onsubmit="return false" id="twitterProgram">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="" class="control-label">Periode</label>
                            <div id="divPeriode2"></div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="" class="control-label">Type Unit</label>
                            <select name="typeunit" id="typeunit2" class="form-control">
                                {{-- <option value="" disabled selected>--Select Type Unit--</option> --}}
                                <option value="TV">TV</option>
                                <option value="Publisher">Hardnews Portal</option>
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
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="" class="control-label">Group</label>
                            <select name="group" id="group" class="form-control">
                                <option value="" disabled selected>--Select Group--</option>
                                @foreach($group as $row)
                                    <option value="{{$row->id}}">{{$row->group_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="divUnit"></div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="" class="control-label"></label>
                            <button class="btn btn-primary" id="filterProgram" style="margin-top:25px;"><i class="icon-filter3"></i> Filter</button>
                        </div>
                    </div>
                </div>
            </form>
            
            <hr>
        </div>
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
            var bulan="{{date('Y-m')}}";

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

            function showChartByTypeUnit(){
                var tanggal=$("#tanggalMediaPlatform").val();
                var filter=$("#filterMediaPlatform option:selected").val();

                var param={
                    tanggal:tanggal,
                    filter:filter
                };

                $.ajax({
                    url:"{{URL::to('sosmed/data/chart/chart-by-type-unit')}}",
                    type:"GET",
                    data:param,
                    beforeSend:function(){
                        $("#showTypeUnit").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                        $("#zingchart-typeunit").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        $("#zingchart-typeunit").empty();
                        var primaryColor = "#4184F3";
                        var primaryColorHover = "#3a53c5";
                        var secondaryColor = '#DCDCDC'
                        var scaleTextColor = '#999';

                        var labels1=[];
                        var facebook1=[];
                        var twitter1=[];
                        var instagram1=[];
                        var youtube1=[];
                        var isinya=[];
                        var tulisan="";
                        var warna="";

                        $.each(result,function(a,b){
                            if(b.type_unit!='tidak'){
                                var na="";
                                if(b.type_unit=="Publisher"){
                                    na="Hardnews Portal & Print";
                                }else if(b.type_unit=="KOL"){
                                    na="Artist";
                                }else{
                                    na=b.type_unit;
                                }

                                labels1.push(na);

                                if(idsosmed==1){
                                    isinya.push(parseFloat(b.twitter));
                                    tulisan="Twitter";
                                    warna="#008ef6";
                                }else if(idsosmed==2){
                                    isinya.push(parseFloat(b.facebook));
                                    tulisan="Facebook";
                                    warna="#5054ab";
                                }else if(idsosmed==3){
                                    isinya.push(parseFloat(b.instagram));
                                    tulisan="Instagram";
                                    warna="#a958a5";
                                }else if(idsosmed==4){
                                    isinya.push(parseFloat(b.youtube));
                                    tulisan="Youtube";
                                    warna="#f06261";
                                }else{
                                    isinya.push(parseFloat(b.twitter));
                                    tulisan="Twitter";
                                    warna="#008ef6";
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
                                "margin": "2% 15% 15% 15%"
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
                                    "values": isinya,
                                    "text": tulisan,
                                    "background-color": warna
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
                            id: 'zingchart-typeunit',
                            data: chartConfig1,
                            output: 'canvas',
                            height:'100%',
                            width:'100%'
                        });
                        /* end tear 1 */

                        el+='<div class="table-responsive">'+
                            '<table id="tabletypeunit" class="table table-responsive-sm table-hover table-outline mb-0">'+
                                '<thead class="thead-light">'+
                                    '<tr class="text-center">'+
                                        '<th>No.</th>'+
                                        '<th>Unit Type</th>';
                                        if(idsosmed==1){
                                            el+='<th>Twitter</th>';
                                        }else if(idsosmed==2){
                                            el+='<th>Facebook</th>';
                                        }else if(idsosmed==3){
                                            el+='<th>Instagram</th>';
                                        }else if(idsosmed==4){
                                            el+='<th>Youtube</th>';
                                        }
                                    el+='</tr>'+
                                '</thead>'+
                                '<tbody>';
                                    var no=0;
                                    
                                    result.sort(function(a, b) {
                                        return b['total'] - a['total'];
                                    });
                                    $.each(result,function(a,b){
                                        if(b.type_unit!='tidak'){
                                            var na="";
                                            if(b.type_unit=="Publisher"){
                                                na="Hardnews Portal & Print";
                                            }else if(b.type_unit=="KOL"){
                                                na="Artist";
                                            }else{
                                                na=b.type_unit;
                                            }

                                            no++;
                                            el+="<tr>"+
                                                "<td>"+no+"</td>"+
                                                "<td>"+na+"</td>";
                                                if(idsosmed==1){
                                                    el+="<td>"+addKoma(b.twitter)+"</td>";
                                                }else if(idsosmed==2){
                                                    el+="<td>"+addKoma(b.facebook)+"</td>";
                                                }else if(idsosmed==3){
                                                    el+="<td>"+addKoma(b.instagram)+"</td>";
                                                }else if(idsosmed==4){
                                                    el+="<td>"+addKoma(b.youtube)+"</td>";
                                                }
                                            el+="</tr>";
                                        }
                                    })
                                el+='</tbody>'+
                            '</table>'+
                        '</div>';

                        $("#showTypeUnit").empty().html(el);

                        $("#tabletypeunit").DataTable();

                    }
                })
            }

            $(document).on("click","#filterMediaFlatformSearch",function(){
                showChartByTypeUnit();
            });

            $(document).on("click","#filterOfficial2",function(){
                showTear1();
            })

            function showOfficial(){
                var periode=$("#periode2 option:selected").val();
                var typeunit=$("#typeunit").val();

                var param={
                    idsosmed:idsosmed,
                    typeunit:typeunit,
                    periode:periode
                };

                $.ajax({
                    url:"{{URL::to('sosmed/data/chart/official-by-tier')}}",
                    type:"GET",
                    data:param,
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
                        if(result.success==true){
                            $("#growthProgram").empty();
                            var series=[];
                            var tanggal=[];
                            $.each(result.data,function(a,b){
                                var values=[];
                                $.each(b.follower,function(c,d){
                                    values.push(d.num_of_growth);

                                    if ($.inArray(d.tanggal, tanggal) == -1) tanggal.push(d.tanggal);
                                })
                                series.push({
                                        "values":values,
                                        "text":b.program_name,
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
                                id : 'growthProgram', 
                                data : myConfig, 
                                height: '100%', 
                                width: '100%' 
                            });
                        }
                    }
                })
            }

            function top10TwitterProgram(){
                var tanggal=$("#tanggal2").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/chart/top-program-twitter-today')}}",
                    type:"GET",
                    data:"idsosmed="+idsosmed+"&tanggal="+tanggal,
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
                                "margin": "2% 15% 15% 30%"
                            },
                            source:{
                                // text: "* Dalam Ribu",
                                fontColor:"#222222",
                                // align: "center",
                            },
                            "backgroundColor": "#fff",
                            "scaleX": {
                                "values": labels,
                                "thousands-separator":",",
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
                                "margin": "2% 15% 15% 20%"
                            },
                            source:{
                                // text: "* Dalam Ribu",
                                fontColor:"#222222",
                                // align: "center",
                            },
                            "backgroundColor": "#fff",
                            "scaleX": {
                                "values": labels,
                                "thousands-separator":",",
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
                    beforeSend:function(){
                        $("#divPeriode").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
					success:function(result){
						console.log(result);

						var p="<select name='periode' id='periode' class='form-control'>"+
							"<option value='' selected='selected'>--Periode--</option>";
							$.each(result,function(a,b){

								p+="<option value='"+b.key+"'>"+b.value+"</option>";
							})
						p+="</select>";

                        var p="<select name='periode' id='periode2' class='form-control'>"+
							"<option value='' selected='selected'>--Periode--</option>";
							$.each(result,function(a,b){

								p+="<option value='"+b.key+"'>"+b.value+"</option>";
							})
						p+="</select>";


						$("#divPeriode").empty().html(p);
                        $("#divPeriode2").empty().html(p);
                        $("#periode").val(bulan);
                        $("#periode2").val(bulan);
					}
				})
			}

            function filterGroup(){
                var group=$("#group").val();
                var typeunit=$("#typeunit2").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/list-unit')}}",
                    type:"GET",
                    data:"group="+group+"&typeunit="+typeunit,
                    beforeSend:function(){
                        $("#divUnit").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+='<div class="col-lg-12">'+
                            '<div class="form-group">'+
                                '<label for="" class="control-label">Unit</label>'+
                                '<select name="unit" id="unit" class="form-control">'+
                                    '<option disabled selected>--Select Unit--</option>';
                                    $.each(result,function(a,b){
                                        el+="<option value='"+b.id+"'>"+b.unit_name+"</option>";
                                    })
                                el+='</select>'+
                            '</div>'+
                        '</div>';

                        $("#divUnit").empty().html(el);
                    },
                    errors:function(){
                        $("#divUnit").empty().html("<div class='alert alert-danger'>Failed to load</div>");
                    }
                })
            }

            function showTear1(){
                var tanggal=$("#tanggal").val();
                var filter=$("#filter").val();
                var typeunit=$("#typeunit").val();
                var sortby=$("#sortby option:selected").val();

                var param={
                    tanggal:tanggal,
                    filter:filter,
                    typeunit:typeunit,
                    sortby:sortby
                };

                $.ajax({
                    url:"{{URL::to('sosmed/data/chart/chart-by-tier')}}",
                    type:"GET",
                    data:param,
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

                        var isinya=[];
                        var tulisan="";
                        var warna="";
                        
                        if(sortby=="hight"){
                            listchart=result.chart.sort(function(a, b) {
                                return a['total_all'] - b['total_all'];
                            });
                        }else if(sortby=="low"){
                            listchart=result.chart.sort(function(a, b) {
                                return b['total_all'] - a['total_all'];
                            });
                        }else if(sortby=="group"){
                            listchart=result.chart.sort(function(a, b) {
                                return b['group_unit_id'] - a['group_unit_id'];
                            });
                        }else{
                            listchart=result.chart.sort(function(a, b) {
                                return a['total_all'] - b['total_all'];
                            });
                        }

                        $.each(listchart,function(a,b){
                            if(b.id!=null){
                                if(b.id!=4){
                                    labels1.push(b.unit_name);

                                    if(idsosmed==1){
                                        isinya.push(parseFloat(b.total_twitter));
                                        tulisan="Twitter";
                                        warna="#008ef6";
                                    }else if(idsosmed==2){
                                        isinya.push(parseFloat(b.total_facebook));
                                        tulisan="Facebook";
                                        warna="#5054ab";
                                    }else if(idsosmed==3){
                                        isinya.push(parseFloat(b.total_instagram));
                                        tulisan="Instagram";
                                        warna="#a958a5";
                                    }else if(idsosmed==4){
                                        isinya.push(parseFloat(b.total_youtube));
                                        tulisan="Youtube";
                                        warna="#f06261";
                                    }else{
                                        isinya.push(parseFloat(b.total_twitter));
                                        tulisan="Twitter";
                                        warna="#008ef6";
                                    }
                                }else{
                                    $.each(result.inews,function(a,b){
                                        labels1.push("INEWS 4TV");

                                        if(idsosmed==1){
                                            isinya.push(parseFloat(b.total_twitter));
                                            tulisan="Twitter";
                                            warna="#008ef6";
                                        }else if(idsosmed==2){
                                            isinya.push(parseFloat(b.total_facebook));
                                            tulisan="Facebook";
                                            warna="#5054ab";
                                        }else if(idsosmed==3){
                                            isinya.push(parseFloat(b.total_instagram));
                                            tulisan="Instagram";
                                            warna="#a958a5";
                                        }else if(idsosmed==4){
                                            isinya.push(parseFloat(b.total_youtube));
                                            tulisan="Youtube";
                                            warna="#f06261";
                                        }else{
                                            isinya.push(parseFloat(b.total_twitter));
                                            tulisan="Twitter";
                                            warna="#008ef6";
                                        }

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
                                    "values": isinya,
                                    "text": tulisan,
                                    "background-color": warna
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
                                        '<th widht="5%">No.</th>'+
                                        '<th>Unit Type</th>';
                                        if(idsosmed==1){
                                            el+='<th>Twitter</th>';
                                        }else if(idsosmed==2){
                                            el+='<th>Facebook</th>';
                                        }else if(idsosmed==3){
                                            el+='<th>Instagram</th>';
                                        }else if(idsosmed==4){
                                            el+='<th>Youtube</th>';
                                        }
                                    el+='</tr>'+
                                '</thead>'+
                                '<tbody>';
                                    var no=0;
                                    
                                    if(sortby=="hight"){
                                        listtable=result.chart.sort(function(a, b) {
                                            return b['total_all'] - a['total_all'];
                                        });
                                    }else if(sortby=="low"){
                                        listtable=result.chart.sort(function(a, b) {
                                            return a['total_all'] - b['total_all'];
                                        });
                                    }else if(sortby=="group"){
                                        listtable=result.chart.sort(function(a, b) {
                                            return a['group_unit_id'] - b['group_unit_id'];
                                        });
                                    }else{
                                        listtable=result.chart.sort(function(a, b) {
                                            return b['total_all'] - a['total_all'];
                                        });
                                    }

                                    $.each(listtable,function(a,b){
                                        if(b.id!=null){
                                            no++;
                                            if(b.id!='tidak'){
                                                if(b.id!=4){
                                                    el+="<tr>"+
                                                        "<td>"+no+"</td>"+
                                                        "<td>"+b.unit_name+"</td>";
                                                        if(idsosmed==1){
                                                            el+="<td>"+addKoma(b.total_twitter)+"</td>";
                                                        }else if(idsosmed==2){
                                                            el+="<td>"+addKoma(b.total_facebook)+"</td>";
                                                        }else if(idsosmed==3){
                                                            el+="<td>"+addKoma(b.total_instagram)+"</td>";
                                                        }else if(idsosmed==4){
                                                            el+="<td>"+addKoma(b.total_youtube)+"</td>";
                                                        }
                                                    el+="</tr>";
                                                }else{
                                                    $.each(result.inews,function(c,d){
                                                            el+="<tr>"+
                                                                "<td>"+no+"</td>"+
                                                                "<td>INEWS 4TV</td>";
                                                                if(idsosmed==1){
                                                                    el+="<td>"+addKoma(b.total_twitter)+"</td>";
                                                                }else if(idsosmed==2){
                                                                    el+="<td>"+addKoma(b.total_facebook)+"</td>";
                                                                }else if(idsosmed==3){
                                                                    el+="<td>"+addKoma(b.total_instagram)+"</td>";
                                                                }else if(idsosmed==4){
                                                                    el+="<td>"+addKoma(b.total_youtube)+"</td>";
                                                                }
                                                            el+="</tr>";
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

            function groupMediaType(){
                var tanggal=$("#tanggalType").val();
                var type=$("#type2 option:selected").val();
                var typeunit=$("#typeunit2 option:selected").val();
                
                var param={
                    tanggal:tanggal,
                    type:type,
                    typeunit:typeunit
                };

                $.ajax({
                    url:"{{URL::to('sosmed/data/chart/type-unit-by-group')}}",
                    type:"GET",
                    data:param,
                    beforeSend:function(){
                        $("#groupMediaType").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                        $("#zingchart-groupMediaType").empty().html("<div class='alert alert-info'>Please wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        $("#zingchart-groupMediaType").empty();
                        var primaryColor = "#4184F3";
                        var primaryColorHover = "#3a53c5";
                        var secondaryColor = '#DCDCDC'
                        var scaleTextColor = '#999';

                        var labels1=[];
                        var facebook1=[];
                        var twitter1=[];
                        var instagram1=[];
                        var youtube1=[];

                        var isinya=[];
                        var tulisan="";
                        var warna="";

                        var chartTypeGroup=[];

                        chartTypeGroup=result.sort(function(a, b) {
                            return a['total'] - b['total'];
                        });

                        $.each(chartTypeGroup,function(a,b){
                            if(b.group_unit_id!=null){
                                labels1.push(b.group_name);

                                if(idsosmed==1){
                                    isinya.push(parseFloat(b.twitter));
                                    tulisan="Twitter";
                                    warna="#008ef6";
                                }else if(idsosmed==2){
                                    isinya.push(parseFloat(b.facebook));
                                    tulisan="Facebook";
                                    warna="#5054ab";
                                }else if(idsosmed==3){
                                    isinya.push(parseFloat(b.instagram));
                                    tulisan="Instagram";
                                    warna="#a958a5";
                                }else if(idsosmed==4){
                                    isinya.push(parseFloat(b.youtube));
                                    tulisan="Youtube";
                                    warna="#f06261";
                                }else{
                                    isinya.push(parseFloat(b.twitter));
                                    tulisan="Twitter";
                                    warna="#008ef6";
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
                                    "values": isinya,
                                    "text": tulisan,
                                    "background-color": warna
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
                            id: 'zingchart-groupMediaType',
                            data: chartConfig1,
                            output: 'canvas',
                            height:'100%',
                            width:'100%'
                        });
                        /* end tear 1 */

                        el+='<div class="table-responsive">'+
                            '<table id="tablegrouptype" class="table table-responsive-sm table-hover table-outline mb-0">'+
                                '<thead class="thead-light">'+
                                    '<tr class="text-center">'+
                                        '<th>No.</th>'+
                                        '<th>Unit Name</th>';
                                        if(idsosmed==1){
                                            el+='<th>Twitter</th>';
                                        }else if(idsosmed==2){
                                            el+='<th>Facebook</th>';
                                        }else if(idsosmed==3){
                                            el+='<th>Instagram</th>';
                                        }else if(idsosmed==4){
                                            el+='<th>Youtube</th>';
                                        }
                                    el+='</tr>'+
                                '</thead>'+
                                '<tbody>';
                                    var no=0;
                                    var tabelTypeGroup=[];

                                    tabelTypeGroup=result.sort(function(a, b) {
                                        return b['total'] - a['total'];
                                    });

                                    $.each(tabelTypeGroup,function(a,b){
                                        if(b.group_unit_id!=null){
                                            no++;
                                            el+="<tr>"+
                                                "<td>"+no+"</td>"+
                                                "<td>"+b.group_name+"</td>";
                                                if(idsosmed==1){
                                                    el+="<td>"+addKoma(b.twitter)+"</td>";
                                                }else if(idsosmed==2){
                                                    el+="<td>"+addKoma(b.facebook)+"</td>";
                                                }else if(idsosmed==3){
                                                    el+="<td>"+addKoma(b.instagram)+"</td>";
                                                }else if(idsosmed==4){
                                                    el+="<td>"+addKoma(b.youtube)+"</td>";
                                                }
                                            el+="</tr>";
                                        }else{
                                            $("#total_twitter_group_type").html(addKoma(b.twitter));
                                            $("#total_facebook_group_type").html(addKoma(b.facebook));
                                            $("#total_instagram_group_type").html(addKoma(b.instagram));
                                            $("#total_youtube_group_type").html(addKoma(b.youtube));
                                        }
                                    })
                                el+='</tbody>'+
                            '</table>'+
                        '</div>';

                        $("#groupMediaType").empty().html(el);
                        $("#tablegrouptype").DataTable();
                    },
                    errors:function(){

                    }
                })
            }

            $(document).on("change","#tanggal",function(){
                top10TwitterOfficial();
            })
            
            $(document).on("change","#tanggal2",function(){
                top10TwitterProgram();
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
            });

            $(document).on("click","#filterOfficial",function(){
                showOfficial();
            })

            $(document).on("change","#group",function(){
                filterGroup();
            })

            $(document).on("change","#typeunit2",function(){
                filterGroup();
            })

            $(document).on("submit","#twitterProgram",function(e){
                var data = new FormData(this);
                data.append("idsosmed",idsosmed);

                data.append("_token","{{ csrf_token() }}");
                if($("#twitterProgram")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url:"{{URL::to('sosmed/data/chart/program-by-tier')}}",
                        type:"POST",
                        data:data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend:function(){
                            $("#pesan").empty();
                            $("#growthProgram").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>");
                        },
                        success:function(result){
                            if(result.success==true){
                                $("#growthProgram").empty();
                                var series=[];
                                var tanggal=[];
                                $.each(result.data,function(a,b){
                                    var values=[];
                                    $.each(b.follower,function(c,d){
                                        values.push(d.num_of_growth);

                                        if ($.inArray(d.tanggal, tanggal) == -1) tanggal.push(d.tanggal);
                                    })
                                    series.push({
                                            "values":values,
                                            "text":b.program_name,
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
                                    id : 'growthProgram', 
                                    data : myConfig, 
                                    height: '100%', 
                                    width: '100%' 
                                });
                            }else{
                                $("#pesan").empty().html("<div class='alert alert-danger'>Validasi Error</div>");
                            }
                        }
                    })
                }else console.log("invalid form");
            })

            $(document).on("click","#filterType",function(){
                groupMediaType();
            })

            periode();
            showChartByTypeUnit();
            showOfficial();
            // top10TwitterProgram();
            // top10TwitterOfficial();
            growthProgram();
            showTear1();
            groupMediaType();
        })
    </script>
@stop
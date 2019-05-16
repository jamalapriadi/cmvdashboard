@extends('layouts.coreui.main')

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
                <div class="card-footer">
                    <div class="row text-center">
                        <div class="col-sm-12 col-md mb-sm-3 mb-0">
                            <div class="text-muted">TOTAL TWITTER</div>
                            <strong id="total_twitter_media_platform">0</strong>
                        </div>
        
                        <div class="col-sm-12 col-md mb-sm-3 mb-0">
                            <div class="text-muted">TOTAL FACEBOOK</div>
                            <strong id="total_facebook_media_platform">0</strong>
                        </div>
        
                        <div class="col-sm-12 col-md mb-sm-3 mb-0">
                            <div class="text-muted">TOTAL INSTAGRAM</div>
                            <strong id="total_instagram_media_platform">0</strong>
                        </div>
        
                        <div class="col-sm-12 col-md mb-sm-3 mb-0">
                            <div class="text-muted">TOTAL YOUTUBE</div>
                            <strong id="total_youtube_media_platform">0</strong>
                        </div>
                    </div>
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
                                    @foreach($typeunit as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
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
                                <button class="btn btn-primary" id="filterOfficial" style="margin-top:25px;"><i class="icon-filter3"></i> Filter</button>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div id="zingchart-1">
                        <div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>
                    </div>

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
                                    @foreach($typeunit as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
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

                    <div id="zingchart-groupMediaType">
                        <div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>
                    </div>

                    <div id="groupMediaType">
                        <div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>
                    </div>
                </div>

                <div class="card-footer">
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
                </div>
            </div>
        </div>
    </div>

    <div class="card card-accent-success">
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
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="" class="control-label">Date</label>
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

                {{-- <div class="col-lg-2">
                    <div class="form-group">
                        <label for="" class="control-label">Sort By</label>
                        <select name="sortby2" id="sortby2" class="form-control">
                            <option value="hight">High</option>
                            <option value="low">Low</option>
                            <option value="group">Group</option>
                        </select>
                    </div>
                </div> --}}

                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="" class="control-label"></label>
                        <button class="btn btn-primary" id="filtergroup" style="margin-top:25px;"><i class="icon-filter3"></i> Filter</button>
                    </div>
                </div>
            </div>

            <hr>

            <div id="zingchart-2">
                <div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>
            </div>
            <div id="showGroup">
                <div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>
            </div>
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
@stop

@section('js')
    <script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
    <script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9","ee6b7db5b51705a13dc2339db3edaf6d"];</script>
    <script>
        $(function(){
            var group=$("#group").val();
            var namagroup=$("#group option:selected").text();
            var listchart=[];
            var listtable=[];

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

            function showTear1(number){
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
                        var total1=[];

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
                                labels1.push(b.unit_name);

                                facebook1.push(parseFloat(b.total_facebook));
                                twitter1.push(parseFloat(b.total_twitter));
                                instagram1.push(parseFloat(b.total_instagram));
                                youtube1.push(parseFloat(b.total_youtube));
                                total1.push(parseFloat(b.total_all));
                                // if(b.id!=4){
                                //     labels1.push(b.unit_name);

                                //     facebook1.push(parseFloat(b.total_facebook));
                                //     twitter1.push(parseFloat(b.total_twitter));
                                //     instagram1.push(parseFloat(b.total_instagram));
                                //     youtube1.push(parseFloat(b.total_youtube));
                                //     total1.push(parseFloat(b.total_all));
                                // }else{
                                //     $.each(result.inews,function(e,f){
                                //         labels1.push("INEWS 4TV");

                                //         facebook1.push(parseFloat(f.total_facebook));
                                //         twitter1.push(parseFloat(f.total_twitter));
                                //         instagram1.push(parseFloat(f.total_instagram));
                                //         youtube1.push(parseFloat(f.total_youtube));
                                //         total1.push(parseFloat(f.total_all));
                                //     })
                                // }
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

                        // if(number==0){
                        //     groupMediaType(0);
                        // }
                    }
                })
            }

            function showChartByTypeUnit(number){
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
                        $("#showTypeUnit").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>");
                        $("#zingchart-typeunit").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        $("#showTypeUnit").empty();
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

                        $.each(result,function(a,b){
                            if(b.type_unit!='tidak'){
                                var na=b.type_unit_name;

                                labels1.push(na);

                                facebook1.push(parseFloat(b.facebook));
                                twitter1.push(parseFloat(b.twitter));
                                instagram1.push(parseFloat(b.instagram));
                                youtube1.push(parseFloat(b.youtube));
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
                                        '<th>Unit Type</th>'+
                                        '<th>Twitter</th>'+
                                        '<th>Facebook</th>'+
                                        '<th>Instagram</th>'+
                                        '<th>Youtube</th>'+
                                    '</tr>'+
                                '</thead>'+
                                '<tbody>';
                                    var no=0;
                                    
                                    result.sort(function(a, b) {
                                        return b['total'] - a['total'];
                                    });
                                    $.each(result,function(a,b){
                                        if(b.type_unit!='tidak'){
                                            var na=b.type_unit_name;

                                            no++;
                                            el+="<tr>"+
                                                "<td>"+no+"</td>"+
                                                "<td>"+na+"</td>"+
                                                "<td>"+addKoma(b.twitter)+"</td>"+
                                                "<td>"+addKoma(b.facebook)+"</td>"+
                                                "<td>"+addKoma(b.instagram)+"</td>"+
                                                "<td>"+addKoma(b.youtube)+"</td>"+
                                            "</tr>";
                                        }else{
                                            if(b.type_unit_name != null){
                                                $("#total_twitter_media_platform").empty().html(addKoma(b.twitter));
                                                $("#total_facebook_media_platform").empty().html(addKoma(b.facebook));
                                                $("#total_instagram_media_platform").empty().html(addKoma(b.instagram));
                                                $("#total_youtube_media_platform").empty().html(addKoma(b.youtube));
                                            }
                                        }
                                    })
                                el+='</tbody>'+
                            '</table>'+
                        '</div>';

                        $("#showTypeUnit").empty().html(el);

                        $("#tabletypeunit").DataTable();

                        // if(number==0){
                        //     showTear1(0);
                        // }
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
                        $("#divLiveSocmed").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>");
                    },
                    success:function(result){
                        $("#divLiveSocmed").empty().html(result);
                    },
                    errors:function(){

                    }
                })
            }

            function showgroup(number){
                var tanggal=$("#tanggalgroup").val();
                var filter=$("#typegroup").val();
                var group=$("#group").val();
                $("#grouptanggal").empty().html(tanggal);

                var param={
                    tanggal:tanggal,
                    filter:filter
                };

                $.ajax({
                    url:"{{URL::to('sosmed/data/list-official-program-by-group')}}/"+group,
                    data:param,
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
                            if(filter!="program"){
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
                            }else{
                                if(b.idnya!=null){
                                    if(b.idnya!=4){
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
                                            // return b['businesss_unit_id'] - a['businesss_unit_id'];
                                            return b['total_all'] - a['total_all'];
                                        });
                                    }else{
                                        result.chart.sort(function(a, b) {
                                            // return a['id'] - b['id'];
                                            return b['total_all'] - a['total_all'];
                                        });
                                    }

                                    $.each(result.chart,function(a,b){
                                        if(filter!="program"){
                                            if(b.id!=null){
                                                no++;
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
                                        }else{
                                            if(b.idnya!=null){
                                                no++;
                                                if(b.idnya!=4){
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

            function groupMediaType(number){
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
                        $("#groupMediaType").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>");
                        $("#zingchart-groupMediaType").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please wait. . .</div>");
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

                        var chartTypeGroup=[];

                        chartTypeGroup=result.sort(function(a, b) {
                            return a['total'] - b['total'];
                        });

                        $.each(chartTypeGroup,function(a,b){
                            if(b.group_unit_id!=null){
                                labels1.push(b.group_name);

                                facebook1.push(parseFloat(b.facebook));
                                twitter1.push(parseFloat(b.twitter));
                                instagram1.push(parseFloat(b.instagram));
                                youtube1.push(parseFloat(b.youtube));
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
                                        '<th>Unit Name</th>'+
                                        '<th>Twitter</th>'+
                                        '<th>Facebook</th>'+
                                        '<th>Instagram</th>'+
                                        '<th>Youtube</th>'+
                                    '</tr>'+
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
                                                "<td>"+b.group_name+"</td>"+
                                                "<td>"+addKoma(b.twitter)+"</td>"+
                                                "<td>"+addKoma(b.facebook)+"</td>"+
                                                "<td>"+addKoma(b.instagram)+"</td>"+
                                                "<td>"+addKoma(b.youtube)+"</td>"+
                                            "</tr>";
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

                        // if(number==0){
                        //     showgroup(0);
                        // }
                    },
                    errors:function(){

                    }
                })
            }

            $(document).on("click","#filterOfficial",function(){
                showTear1(1);
            })

            $(document).on("click","#filterMediaFlatformSearch",function(){
                showChartByTypeUnit(1);
            });

            $(document).on("change","#unit",function(){
                var accounttype=$("#accounttype option:selected").val();

                if(accounttype=="official"){
                    $("#accountprogram").empty();
                    liveSocmed();
                }else if(accounttype=="program"){
                    showProgram();
                }
            })

            $(document).on("click","#filtergroup",function(){
                var nm=$("#group option:selected").text();
                $("#namagroup").empty().html(nm);

                showgroup(1);
            })

            $(document).on("click","#filterType",function(){
                groupMediaType(1);
            })

            $(document).on("change","#accounttype",function(){
                var accounttype=$("#accounttype option:selected").val();

                if(accounttype=="official"){
                    /* langsung tampilkan */
                    $("#accountprogram").empty();
                    liveSocmed();
                }else if(accounttype=="program"){
                    /* tampilkan program berdasarkan unit ini*/
                    showProgram();
                }
            })

            function showProgram(){
                var accounttype=$("#accounttype option:selected").val();
                var unit=$("#unit option:selected").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/list-program-by-unit')}}/"+unit,
                    type:"GET",
                    beforeSend:function(){
                        $("#divLiveSocmed").empty();
                        $("#accountprogram").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait...</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<div class='form-group'>"+
                            '<label class="control-label">Program</label>'+
                            "<select name='program' id='program' class='form-control'>"+
                                '<option value="" disabled selected>--Select Program--</option>';
                                $.each(result,function(a,b){
                                    el+="<option value='"+b.id+"'>"+b.program_name+"</option>";
                                })
                            el+="</select>"+
                        "</div>";

                        $("#accountprogram").empty().html(el);
                    },
                    errors:function(){
                        $("#accountprogram").empty().html("<div class='alert alert-danger'>Failed to load data...</div>");
                    }
                })
            }

            $(document).on("change","#program",function(){
                var program=$("#program option:selected").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/live-socmed-by-id')}}/"+program,
                    type:"GET",
                    data:"type=program",
                    beforeSend:function(){
                        $("#divLiveSocmed").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>&nbsp;Please Wait. . .</div>");
                    },
                    success:function(result){
                        $("#divLiveSocmed").empty().html(result);
                    },
                    errors:function(){

                    }
                })
            })
            
            showChartByTypeUnit(0);
            showTear1(0);
            groupMediaType(0);
            showgroup(0);
            
            // liveSocmed();
        })
    </script>
@stop
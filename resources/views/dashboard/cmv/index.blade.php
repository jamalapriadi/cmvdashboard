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

            function tabelData(){
                var brand=$("#brand").val();
                var quartal=$("#quartal").val();

                $.ajax({
                    url:"{{URL::to('cmv/data/filter-demography-by-brand')}}",
                    type:"GET",
                    data:"brand="+brand+"&quartal="+quartal,
                    beforeSend:function(){
                        $("#showData").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        $("#showData").empty().html(result);

                        $("#tabelBrand").DataTable({
                            colVis: {
                                buttonText: "<i class='icon-three-bars'></i> <span class='caret'></span>",
                                align: "right",
                                overlayFade: 200,
                                showAll: "Show all",
                                showNone: "Hide all"
                            },
                            scrollX: true,
                            scrollY: '450px',
                            scrollCollapse: true,
                            fixedColumns: true,
                            fixedColumns: {
                                leftColumns: 2,
                                rightColumns: 0
                            },
                            fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                                if ( aData[2] == "5" )
                                {
                                    $('td', nRow).css('background-color', 'Red');
                                }
                                else if ( aData[2] == "4" )
                                {
                                    $('td', nRow).css('background-color', 'Orange');
                                }
                            },
                            bDestroy: true
                        })

                        // Launch Uniform styling for checkboxes
                        $('.ColVis_Button').addClass('btn btn-primary btn-icon').on('click mouseover', function() {
                            $('.ColVis_collection input').uniform();
                        });


                        // Add placeholder to the datatable filter option
                        $('.dataTables_filter input[type=search]').attr('placeholder', 'Type and Enter...');


                        // Enable Select2 select for the length option
                        $('.dataTables_length select').select2({
                            minimumResultsForSearch: "-1"
                        }); 

                    },
                    error:function(){
                        $("#showData").empty().html("<div class='alert alert-danger'>Data failed to load</div>");
                    }
                })
            }

            function showGender(data){
                var gender=[];
                $.each(data,function(a,b){
                    if(b.demo_id=="D1"){
                        gender.push({
                            values:[b.totals_thousand],
                            backgroundColor:"#5d9edb",
                            text:b.subdemo_name,
                            "detached":true
                        })
                    }
                })
                console.log(gender);

                // var gender={};
                // $.each(data,function(a,b){
                //     if(b.demo_id=="D1"){
                //         gender[]={
                //             values:[b.totals_thousand],
                //             backgroundColor:"#5d9edb",
                //             text:b.subdemo_name,
                //             "de"
                //         }
                //         [
                //             {
                //                 values : [53.54],
                //                 backgroundColor: "#5d9edb",
                //                 text:"MALE",
                //                 "detached":true
                //             },
                //             {
                //                 values : [46.46],
                //                 backgroundColor: "#f38542",
                //                 text:"FEMALE"
                //             }
                //         ]
                //     }
                // })
                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: "BABY POWDER - [ ZWITSAL ]",
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 16
                    },
                    "legend":{
                        "x":"75%",
                        "y":"10%",
                        "border-width":1,
                        "border-color":"gray",
                        "border-radius":"5px",
                        "header":{
                            "text":"Legend",
                            "font-family":"Georgia",
                            "font-size":12,
                            "font-color":"white",
                            "font-weight":"normal"
                        },
                        "marker":{
                            "type":"circle"
                        },
                        "toggle-action":"remove",
                        "minimize":true,
                        "icon":{
                            "line-color":"#9999ff"
                        },
                        "max-items":8,
                        "overflow":"scroll"
                    },
                    "plotarea":{
                        "margin-right":"20%",
                        "margin-top":"10%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%npv%",
                            fontColor: "#1A1B26",
                            fontSize: 16
                        }],
                        "tooltip":{
                            "text":"%t: %v (%npv%)",
                            "font-color":"black",
                            "font-family":"Georgia",
                            "text-alpha":1,
                            "background-color":"white",
                            "alpha":0.7,
                            "border-width":1,
                            "border-color":"#cccccc",
                            "line-style":"dotted",
                            "border-radius":"10px",
                            "padding":"10%",
                            "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
                    },
                    series : gender
               };
                
               zingchart.render({ 
                   id : 'divGender', 
                   data : myConfig
               });
            }

            function allData(){
                var brand=$("#brand").val();
                var quartal=$("#quartal").val();

                $.ajax({
                    url:"{{URL::to('cmv/data/chart/all-data')}}",
                    type:"GET",
                    data:"brand="+brand+"&quartal="+quartal,
                    beforeSend:function(){

                    },
                    success:function(result){
                        alldata=result;

                        showGender(alldata);
                    },
                    error:function(){

                    }
                })
            }

            $(document).on("submit","#formSearch",function(e){
                allData();
                tabelData();  
            })
        })
    </script>

    <script>
        $(function(){
            function topBrand(){
                zingchart.THEME="classic";
                var myConfig = {
                    "graphset": [
                        {
                            "type": "hbar3d",
                            "background-color": "#fff",
                            "stacked": true,
                            "3d-aspect": {
                                "true3d": false,
                                "y-angle": 10,
                                "depth": 5
                            },
                            "title": {
                                "text": "TOP 10 BRAND",
                                "background-color": "#fff",
                                "font-color": "#222",
                                "font-weight": "bold"
                            },
                            "tooltip": {
                                "text": "%t / %k = %v<br>%k Total = %total",
                                "font-color": "#000000",
                                "border-width": "1px",
                                "border-color": "#ffffff"
                            },
                            "plot": {
                                "bar-width": 15,
                                "alpha": 0.9
                            },
                            "plotarea": {
                                "background-color": "#fff",
                                "margin": "25% 5% 20% 25%"
                            },
                            "scale-x": {
                                "values": ['BABY POWDER - [ CUSSONS ]','BABY POWDER - [ MY BABY ]', 'BABY POWDER - [ JOHNSONS ]', 'BABY POWDER - [ ZWITSAL ]','BABY POWDER - [ HAPPY ]', 'BABY POWDER - [ KODOMO ]','BABY POWDER - [ SALICYL ]','BABY POWDER - [ PIGEON ]','BABY POWDER - [ OTHERS ]','BABY POWDER - [ CUDDLE ]'],
                                "background-color": "#fff",
                                "guide": {
                                    "line-color": "#fff"
                                },
                                "tick": {
                                    "line-color": "#6e82a1"
                                },
                                "item": {
                                    "font-color": "#222",
                                    "offset-x": "-5%"
                                }
                            },
                            "scale-y": {
                                "background-color": "#43577c #4F678E",
                                "label": {
                                    "text": "",
                                    "font-color": "#acbad0",
                                    "font-weight": "normal",
                                    "offset-y": "5%"
                                },
                                "guide": {
                                    "line-color": "#4f678e"
                                },
                                "tick": {
                                    "line-color": "#6e82a1"
                                },
                                "item": {
                                    "font-color": "#acbad0"
                                }
                            },
                            "series": [
                                {
                                    "values": [
                                        0.15,
                                        0.17,
                                        0.22,
                                        0.31,
                                        0.56,
                                        0.82,
                                        1.42,
                                        5.43,
                                        6.65,
                                        15.03
                                    ],
                                    "background-color": "#4f678e",
                                    "text": "Type 3D"
                                }
                            ]
                        }
                    ]
                };

                zingchart.render({ 
                    id : 'topBrand', 
                    data : myConfig
                });
            }

            function showAge(){
                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: "BABY POWDER - [ ZWITSAL ]",
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 16
                    },
                    "legend":{
                        "x":"63%",
                        "y":"10%",
                        "border-width":1,
                        "border-color":"gray",
                        "border-radius":"5px",
                        "header":{
                            "text":"Legend",
                            "font-family":"Georgia",
                            "font-size":12,
                            "font-color":"white",
                            "font-weight":"normal"
                        },
                        "marker":{
                            "type":"circle"
                        },
                        "toggle-action":"remove",
                        "minimize":true,
                        "icon":{
                            "line-color":"#9999ff"
                        },
                        "max-items":8,
                        "overflow":"scroll"
                    },
                    "plotarea":{
                        "margin-right":"20%",
                        "margin-top":"10%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%npv%",
                            fontColor: "#1A1B26",
                            fontSize: 16
                        }],
                        "tooltip":{
                            "text":"%t: %v (%npv%)",
                            "font-color":"black",
                            "font-family":"Georgia",
                            "text-alpha":1,
                            "background-color":"white",
                            "alpha":0.7,
                            "border-width":1,
                            "border-color":"#cccccc",
                            "line-style":"dotted",
                            "border-radius":"10px",
                            "padding":"10%",
                            "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
                    },
                    series : [
                        {
                            values : [7.98],
                            backgroundColor: "#5b9ddb",
                            text:"AGE 10 - 14 YEARS"
                        },
                        {
                            values : [62.29],
                            backgroundColor: "#f67c2a",
                            text:"AGE 15-34 YEARS"
                        },
                        {
                            values : [19.56],
                            backgroundColor: "#a0a0a0",
                            text:"AGE 35 - 49 YEARS"
                        },
                        {
                            values : [8.11],
                            backgroundColor: "#ffc720",
                            text:"AGE 50 - 64 YEARS"
                        },
                        {
                            values : [1.93],
                            backgroundColor: "#557dcb",
                            text:"AGE 65 +YEARS"
                        }
                   ]
               };
            
                zingchart.render({ 
                    id : 'divAge', 
                    data : myConfig
                });
                
                
            }

            function showSec(){
                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: "BABY POWDER - [ ZWITSAL ]",
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 16
                    },
                    "legend":{
                        "x":"75%",
                        "y":"10%",
                        "border-width":1,
                        "border-color":"gray",
                        "border-radius":"5px",
                        "header":{
                            "text":"Legend",
                            "font-family":"Georgia",
                            "font-size":12,
                            "font-color":"white",
                            "font-weight":"normal"
                        },
                        "marker":{
                            "type":"circle"
                        },
                        "toggle-action":"remove",
                        "minimize":true,
                        "icon":{
                            "line-color":"#9999ff"
                        },
                        "max-items":8,
                        "overflow":"scroll"
                    },
                    "plotarea":{
                        "margin-right":"20%",
                        "margin-top":"10%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%npv%",
                            fontColor: "#1A1B26",
                            fontSize: 16
                        }],
                        "tooltip":{
                            "text":"%t: %v (%npv%)",
                            "font-color":"black",
                            "font-family":"Georgia",
                            "text-alpha":1,
                            "background-color":"white",
                            "alpha":0.7,
                            "border-width":1,
                            "border-color":"#cccccc",
                            "line-style":"dotted",
                            "border-radius":"10px",
                            "padding":"10%",
                            "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
                    },
                    series : [
                        {
                            values : [26.51],
                            backgroundColor: "#599cdb",
                            text:"UPPER"
                        },
                        {
                            values : [64.61],
                            backgroundColor: "#f67b28",
                            text:"MIDDLE"
                        },
                        {
                            values : [8.88],
                            backgroundColor: "#a9a9a9",
                            text:"LOWER"
                        }
                   ]
               };
            
                zingchart.render({ 
                    id : 'divSec', 
                    data : myConfig
                });
                
                
            }

            function showEducation(){
                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: "BABY POWDER - [ ZWITSAL ]",
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 16
                    },
                    "legend":{
                        "x":"75%",
                        "y":"10%",
                        "border-width":1,
                        "border-color":"gray",
                        "border-radius":"5px",
                        "header":{
                            "text":"Legend",
                            "font-family":"Georgia",
                            "font-size":12,
                            "font-color":"white",
                            "font-weight":"normal"
                        },
                        "marker":{
                            "type":"circle"
                        },
                        "toggle-action":"remove",
                        "minimize":true,
                        "icon":{
                            "line-color":"#9999ff"
                        },
                        "max-items":8,
                        "overflow":"scroll"
                    },
                    "plotarea":{
                        "margin-right":"20%",
                        "margin-top":"10%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%npv%",
                            fontColor: "#1A1B26",
                            fontSize: 16
                        }],
                        "tooltip":{
                            "text":"%t: %v (%npv%)",
                            "font-color":"black",
                            "font-family":"Georgia",
                            "text-alpha":1,
                            "background-color":"white",
                            "alpha":0.7,
                            "border-width":1,
                            "border-color":"#cccccc",
                            "line-style":"dotted",
                            "border-radius":"10px",
                            "padding":"10%",
                            "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
                    },
                    series : [
                        {
                            values : [23.04],
                            backgroundColor: "#5197d7",
                            text:"LOW"
                        },
                        {
                            values : [57.14],
                            backgroundColor: "#ef7421",
                            text:"MEDIUM"
                        },
                        {
                            values : [7.46],
                            backgroundColor: "#aaaaaa",
                            text:"HEIGHT"
                        }
                   ]
               };
            
                zingchart.render({ 
                    id : 'divEducation', 
                    data : myConfig
                });
                
                
            }

            function showOccupation(){
                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: "BABY POWDER - [ ZWITSAL ]",
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 16
                    },
                    "legend":{
                        "x":"65%",
                        "y":"10%",
                        "border-width":1,
                        "border-color":"gray",
                        "border-radius":"5px",
                        "header":{
                            "text":"Legend",
                            "font-family":"Georgia",
                            "font-size":12,
                            "font-color":"white",
                            "font-weight":"normal"
                        },
                        "marker":{
                            "type":"circle"
                        },
                        "toggle-action":"remove",
                        "minimize":true,
                        "icon":{
                            "line-color":"#9999ff"
                        },
                        "max-items":8,
                        "overflow":"scroll"
                    },
                    "plotarea":{
                        "margin-right":"20%",
                        "margin-top":"10%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%npv%",
                            fontColor: "#1A1B26",
                            fontSize: 16
                        }],
                        "tooltip":{
                            "text":"%t: %v (%npv%)",
                            "font-color":"black",
                            "font-family":"Georgia",
                            "text-alpha":1,
                            "background-color":"white",
                            "alpha":0.7,
                            "border-width":1,
                            "border-color":"#cccccc",
                            "line-style":"dotted",
                            "border-radius":"10px",
                            "padding":"10%",
                            "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
                    },
                    series : [
                        {
                            values : [32.05],
                            backgroundColor: "#3260af",
                            text:"HOUSEWIVES"
                        },
                        {
                            values : [11.33],
                            backgroundColor: "#6aa047",
                            text:"OTHERS"
                        },
                        {
                            values : [12.74],
                            backgroundColor: "#4b8ac2",
                            text:"WHITE COLLAR"
                        },
                        {
                            values : [17.5],
                            backgroundColor: "#da712d",
                            text:"BLUE COLLAR"
                        },
                        {
                            values : [14.41],
                            backgroundColor: "#949494",
                            text:"ENTREPRENEUR"
                        },
                        {
                            values : [12.1],
                            backgroundColor: "#edaf02",
                            text:"STUDENT"
                        }
                   ]
               };
            
                zingchart.render({ 
                    id : 'divOccupation', 
                    data : myConfig
                });
                
                
            }

            function showHobby(){
                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: "BABY POWDER - [ ZWITSAL ]",
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 16
                    },
                    "legend":{
                        "x":"58%",
                        "y":"10%",
                        "border-width":1,
                        "border-color":"gray",
                        "border-radius":"5px",
                        "header":{
                            "text":"Legend",
                            "font-family":"Georgia",
                            "font-size":12,
                            "font-color":"white",
                            "font-weight":"normal"
                        },
                        "marker":{
                            "type":"circle"
                        },
                        "toggle-action":"remove",
                        "minimize":true,
                        "icon":{
                            "line-color":"#9999ff"
                        },
                        "max-items":8,
                        "overflow":"scroll"
                    },
                    "plotarea":{
                        "margin-right":"20%",
                        "margin-top":"10%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%npv%",
                            fontColor: "#1A1B26",
                            fontSize: 16
                        }],
                        "tooltip":{
                            "text":"%t: %v (%npv%)",
                            "font-color":"black",
                            "font-family":"Georgia",
                            "text-alpha":1,
                            "background-color":"white",
                            "alpha":0.7,
                            "border-width":1,
                            "border-color":"#cccccc",
                            "line-style":"dotted",
                            "border-radius":"10px",
                            "padding":"10%",
                            "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
                    },
                    series : [
                        {
                            values : [31.66],
                            backgroundColor: "#4887c0",
                            text:"SPORT"
                        },
                        {
                            values : [24.32],
                            backgroundColor: "#da6f2a",
                            text:"LISTENING TO MUSIC"
                        },
                        {
                            values : [15.57],
                            backgroundColor: "#979797",
                            text:"COOKING"
                        },
                        {
                            values : [14.03],
                            backgroundColor: "#edb111",
                            text:"NONE"
                        },
                        {
                            values : [10.17],
                            backgroundColor: "#3260af",
                            text:"SURFING INTERNET"
                        },
                        {
                            values : [6.56],
                            backgroundColor: "#649e3d",
                            text:"READING QURAN"
                        },
                        {
                            values : [4.89],
                            backgroundColor: "#99bae3",
                            text:"READING BOOKS"
                        },
                        {
                            values : [5.15],
                            backgroundColor: "#f5ac8f",
                            text:"WINDOW SHOPPING"
                        },
                        {
                            values : [5.79],
                            backgroundColor: "#c2c2c2",
                            text:"SHOPPING TRAVELLING"
                        },
                        {
                            values : [2.06],
                            backgroundColor: "#ffd68e",
                            text:"SINGING"
                        }
                   ]
               };
            
                zingchart.render({ 
                    id : 'divHobby', 
                    data : myConfig
                });
                
                
            }

            function showPsiko(){
                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: "BABY POWDER - [ ZWITSAL ]",
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 16
                    },
                    "legend":{
                        "x":"65%",
                        "y":"10%",
                        "border-width":1,
                        "border-color":"gray",
                        "border-radius":"5px",
                        "header":{
                            "text":"Legend",
                            "font-family":"Georgia",
                            "font-size":12,
                            "font-color":"white",
                            "font-weight":"normal"
                        },
                        "marker":{
                            "type":"circle"
                        },
                        "toggle-action":"remove",
                        "minimize":true,
                        "icon":{
                            "line-color":"#9999ff"
                        },
                        "max-items":8,
                        "overflow":"scroll"
                    },
                    "plotarea":{
                        "margin-right":"20%",
                        "margin-top":"10%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%npv%",
                            fontColor: "#1A1B26",
                            fontSize: 16
                        }],
                        "tooltip":{
                            "text":"%t: %v (%npv%)",
                            "font-color":"black",
                            "font-family":"Georgia",
                            "text-alpha":1,
                            "background-color":"white",
                            "alpha":0.7,
                            "border-width":1,
                            "border-color":"#cccccc",
                            "line-style":"dotted",
                            "border-radius":"10px",
                            "padding":"10%",
                            "placement":"node:out" //"node:out" or "node:center"
                        },
                    },
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
                    },
                    series : [
                        {
                            values : [16.09],
                            backgroundColor: "#6ba148",
                            text:"SETTLED"
                        },
                        {
                            values : [5.79],
                            backgroundColor: "#96b9e3",
                            text:"SKEPTICAL"
                        },
                        {
                            values : [14.29],
                            backgroundColor: "#f3a282",
                            text:"OPTIMIST"
                        },
                        {
                            values : [8.24],
                            backgroundColor: "#c1c1c1",
                            text:"YOUNG LOYALIST"
                        },
                        {
                            values : [10.17],
                            backgroundColor: "#4a89c2",
                            text:"WESTERN MINDED"
                        },
                        {
                            values : [9.56],
                            backgroundColor: "#d86a20",
                            text:"RESTLESS"
                        },
                        {
                            values : [5.92],
                            backgroundColor: "#959595",
                            text:"APATHETIC"
                        },
                        {
                            values : [10.94],
                            backgroundColor: "#edb10e",
                            text:"TRADISIONALIST"
                        },
                        {
                            values : [11.07],
                            backgroundColor: "#3a66b4",
                            text:"MATERIAL CONFORT"
                        }
                   ]
               };
            
                zingchart.render({ 
                    id : 'divPsiko', 
                    data : myConfig
                });
                
                
            }

            function showMedia(){
                var myConfig = {
                    type: "bar",
                    utc:true,
                    plotarea: {
                      adjustLayout:true
                    },
                    scaleX:{
                      label:{
                        text:"BABY POWDER - [ SWITSAL ]"
                      },
                      "labels":["TELEVISION","PAY TV","RADIO","CINEMA","INTERNET","OOH","PUBLIC TRANS AD","NEWSPAPER","TABLOID","MAGAZINE"],
                      minValue:1420070400000,
                      step:"day",
                      transform:{
                        type:"date",
                        all:"%M %d"
                      }
                    },
                    series: [
                      {
                        values:[99.75, 7.59, 25.1, 7.21, 44.79, 36.16, 19.18, 5.02, 1.29, 0.64],
                        "background-color": "#599cdb"
                      }
                    ]
                };
                   
                zingchart.render({ 
                    id : 'divMedia', 
                    data : myConfig
                });
            }

            function showCity(){
                var myConfig = {
                    type: "bar",
                    utc:true,
                    plotarea: {
                      adjustLayout:true
                    },
                    scaleX:{
                      label:{
                        text:"BABY POWDER - [ SWITSAL ]"
                      },
                      "labels":["JAKARTA","BANDUNG","SURABAYA","SEMARANG","MEDAN","MAKASSAR","YOGYAKARTA","DENPASAR","PALEMBANG","BANJARMASIN","SURAKARTA"],
                      minValue:1420070400000,
                      step:"day",
                      transform:{
                        type:"date",
                        all:"%M %d"
                      }
                    },
                    series: [
                      {
                        values:[46.59, 14.54, 15.57, 9.91, 2.7, 2.32, 3.22, 1.03, 0.26, 2.32, 1.42],
                        "background-color": "#599cdb"
                      }
                    ]
                };
                   
                zingchart.render({ 
                    id : 'divCity', 
                    data : myConfig
                });
            }
        })
    </script>
@stop

@section('css')
    <style>
        #topBrand {
            height: 100%;
            width: 100%;
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

        .zc-ref {
            display: none;
        }
    </style>
@stop

@section('content')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form id="formSearch" onsubmit="return false" name="formSearch">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">Brand</label>
                            <input type="text" name="brand" id="brand" class="remote-data-brand">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">Quartal</label>
                            <select name="quartal" id="quartal" class="form-control">
                                <option value="42017">42017</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
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


    <div class="panel panel-primary">
        <div class="panel-heading">
            <h6 class="panel-title">DEMOGRAPHY</h6>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h6 class="panel-title"><strong>GENDER</strong></h6>
                        </div>
                        <div id="divGender"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h6 class="panel-title"><strong>SEC</strong></h6>
                        </div>
                        <div id="divSec"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h6 class="panel-title"><strong>AGE</strong></h6>
                        </div>
                        <div id="divAge"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h6 class="panel-title"><strong>EDUCATION</strong></h6>
                        </div>
                        <div id="divEducation"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h6 class="panel-title"><strong>OCCUPATION</strong></h6>
                        </div>
                        <div id="divOccupation"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h6 class="panel-title"><strong>HOBBY</strong></h6>
                        </div>
                        <div id="divHobby"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h6 class="panel-title">PENETRATION</h6>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h6 class="panel-title">MEDIA</h6>
                        </div>
                        <div id="divMedia"></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h6 class="panel-title">CITIES</h6>
                        </div>
                        <div id="divCity"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h6 class="panel-title">PSYCHOGRAPHICS</h6>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-7">
                    <div id="divPsiko"></div>
                </div>

                <div class="col-lg-5">
                    <div class="panel-group panel-group-control content-group-lg" id="accordion-control">
        
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group2">TRADITIONALIST</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group2" class="panel-collapse collapse">
                                <div class="panel-body">
                                        “Hold traditional value, dreaming of wealth, Non Brand Minded, Less Health Conscious, Non Ad Believer” 
                                </div>
                            </div>
                        </div>
        
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group3">SETTLED</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group3" class="panel-collapse collapse">
                                <div class="panel-body">
                                        “Nested. Practical (Prefer buying new than fixing), TV is entertainment, Enjoying Ad, Enjoying Shopping” 
                                </div>
                            </div>
                        </div>
                        
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group4">YOUNG LOYALIST</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group4" class="panel-collapse collapse">
                                <div class="panel-body">
                                        “Value friendship, Self sacrificing for greater result, Less environment concern” 
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group5">WESTERN MINDED</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group5" class="panel-collapse collapse">
                                <div class="panel-body">
                                        “Brand Minded, Career oriented, Enjoying life, Lonely and Challenge” 
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group6">SKEPTICAL</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group6" class="panel-collapse collapse">
                                <div class="panel-body">
                                    “Worried, Critical on life, Cynical on money, Information seekers (on labels), Non career Minded” 
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group7">RESTLESS</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group7" class="panel-collapse collapse">
                                <div class="panel-body">
                                    “Restless (tend to dislike a regular pattern of life), No confidence” 
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group8">APATHETIC</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group8" class="panel-collapse collapse">
                                <div class="panel-body">
                                    “Non Opinioned (goes with the flow), Career is important, Believe in gender equal opportunities” 
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group9">MATERIAL COMFORT</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group9" class="panel-collapse collapse">
                                <div class="panel-body">
                                    “Makin good money and financially secured, Not price conscious, Appearance concerns” 
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group10">OPTIMIST</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group10" class="panel-collapse collapse">
                                <div class="panel-body">
                                    “Trusting, Do not fear failure, Outspoken, Health Conscious” 
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-flat">
        <div class="panel-body">
            <div id="showData"></div>   
        </div>
    </div>

    
@stop
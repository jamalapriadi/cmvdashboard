@extends('layouts.tabler')

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

            $("#brand").on("change",function(e){
                var data = $('#brand').select2('data');
                // alert(data.text);
                $.ajax({
                    url:"{{URL::to('cmv/data/list-category-by-id')}}/"+data.id,
                    type:"GET",
                    beforeSend:function(){

                    },
                    success:function(result){
                        $(".remote-data-category").select2({
                            initSelection: function(element, callback) {
                                callback({id: result.category.category_id, text: result.category.category_name });
                            },
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
                    },
                    error:function(){

                    }
                })
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
                var age=[];
                var color=["#50ADF5","#FF7965","#a0a0a0","#ffc720","#557dcb"];
                var br="";
                var allnilai=[];

                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D1"){

                        br=b.brand_name;
                        age.push({
                            values:[parseFloat(b.totals_ver)],
                            backgroundColor:color[n],
                            ver:b.totals_ver,
                            thousand:b.totals_thousand,
                            text:b.subdemo_name
                        })

                        allnilai.push(b.totals_thousand);
                        n++;
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<age.length;l++){
                    if(age[l].thousand==tertinggi){
                        // $("#genderValue").empty().html(parseFloat(age[l].ver)+" %");
                        // $("#genderName").empty().html(age[l].text);
                        $("#newGender").empty().html(parseFloat(age[l].ver)+" % "+age[l].text);
                    }
                }

                var myConfig = {
                    type: "pie3d",
                    "plotarea": {
                        "margin": "0 0"
                    }, 
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        "font-color":"#222222",
                        bold:false,
                        fontSize: 14
                    },
                    backgroundColor: "#fff",
                    "scale":{
                        "layout":"1x1", //specify the layout by rows and columns
                        "size-factor":0.6 //provide a decimal or percentage value
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "out",
                            text: "%t:%v%",
                            fontSize: 12,
                            bold:false
                        }],
                        "tooltip":{
                            "text":"%t: %v%",
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
                            // "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    series : age
                };
            
                zingchart.render({ 
                    id : 'divGender', 
                    data : myConfig
                });
                
                
            }

            function showSec(data){
                var sec=[];
                var color=["#50ADF5","#FF7965","#a0a0a0","#ffc720","#557dcb"];
                var br="";
                var allnilai=[];
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D3"){
                        br=b.brand_name;
                        sec.push({
                            values:[parseFloat(b.totals_ver)],
                            backgroundColor:color[n],
                            ver:b.totals_ver,
                            thousand:b.totals_thousand,
                            text:b.subdemo_name
                        });

                        allnilai.push(b.totals_thousand);
                        n++;
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<sec.length;l++){
                    if(sec[l].thousand==tertinggi){
                        // $("#secValue").empty().html(parseFloat(sec[l].ver)+" %");
                        // $("#secName").empty().html("SEC "+sec[l].text);
                        $("#newSec").empty().html(parseFloat(sec[l].ver)+" % SEC "+sec[l].text);
                    }
                }

                var myConfig = {
                    type: "pie3d",
                    "plotarea": {
                        "margin": "0 0"
                    }, 
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        "font-color":"#222222",
                        bold:false,
                        fontSize: 14
                    },
                    backgroundColor: "#fff",
                    "scale":{
                        "layout":"1x1", //specify the layout by rows and columns
                        "size-factor":0.6 //provide a decimal or percentage value
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "out",
                            text: "%t:%v%",
                            fontSize: 12,
                            bold:false
                        }],
                        "tooltip":{
                            "text":"%t: %v%",
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
                            // "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    series : sec
                };
            
                zingchart.render({ 
                    id : 'divSec', 
                    data : myConfig
                });
                
                
            }

            function showAge(data){
                var age=[];
                var color=["#50ADF5","#FF7965","#a0a0a0","#ffc720","#557dcb"];
                var br="";
                var allnilai=[];
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D2"){
                        br=b.brand_name;
                        age.push({
                            values:[parseFloat(b.totals_ver)],
                            backgroundColor:color[n],
                            ver:b.totals_ver,
                            thousand:b.totals_thousand,
                            text:b.subdemo_name
                        })

                        allnilai.push(b.totals_thousand);
                        n++;
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<age.length;l++){
                    if(age[l].thousand==tertinggi){
                        // $("#ageValue").empty().html(parseFloat(age[l].ver)+" %");
                        // $("#ageName").empty().html(age[l].text+" OLD");
                        $("#newAge").empty().html(parseFloat(age[l].ver)+" % "+age[l].text+" OLD");
                    }
                }

                var myConfig = {
                    type: "pie3d",
                    "plotarea": {
                        "margin": "0 0"
                    }, 
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        "font-color":"#222222",
                        bold:false,
                        fontSize: 14
                    },
                    backgroundColor: "#fff",
                    "scale":{
                        "layout":"1x1", //specify the layout by rows and columns
                        "size-factor":0.6 //provide a decimal or percentage value
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "out",
                            text: "%t:%v%",
                            fontSize: 12,
                            bold:false
                        }],
                        "tooltip":{
                            "text":"%t: %v%",
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
                            // "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    series : age
                };
            
                zingchart.render({ 
                    id : 'divAge', 
                    data : myConfig
                });
                
                
            }

            function showEducation(data){
                var education=[];
                var color=["#50ADF5","#FF7965","#a0a0a0","#ffc720","#557dcb"];
                var br="";
                var allnilai=[];
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D4"){
                        br=b.brand_name;
                        education.push({
                            values:[parseFloat(b.totals_ver)],
                            backgroundColor:color[n],
                            ver:b.totals_ver,
                            thousand:b.totals_thousand,
                            text:b.subdemo_name
                        })

                        allnilai.push(b.totals_thousand);
                        n++;
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<education.length;l++){
                    if(education[l].thousand==tertinggi){
                        // $("#educationValue").empty().html(parseFloat(education[l].ver)+" %");
                        // $("#educationName").empty().html(education[l].text);
                        $("#newEducation").empty().html(parseFloat(education[l].ver)+" % "+education[l].text);
                    }
                }

                var myConfig = {
                    type: "pie3d",
                    "plotarea": {
                        "margin": "0 0"
                    }, 
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        "font-color":"#222222",
                        bold:false,
                        fontSize: 14
                    },
                    backgroundColor: "#fff",
                    "scale":{
                        "layout":"1x1", //specify the layout by rows and columns
                        "size-factor":0.6 //provide a decimal or percentage value
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "out",
                            text: "%t:%v%",
                            fontSize: 12,
                            bold:false
                        }],
                        "tooltip":{
                            "text":"%t: %v%",
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
                            // "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    series : education
                };
            
                zingchart.render({ 
                    id : 'divEducation', 
                    data : myConfig
                });
            }

            function showOccupation(data){
                var labels=[];
                var values=[];
                var br="";
                var no=0;
                var alldata=[];
                var allnilai=[];
                var listdata=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D5"){
                        no++;
                        br=b.brand_name;
                        
                        listdata.push({
                            values:parseFloat(b.totals_ver),
                            labels:b.subdemo_name
                        })

                        alldata.push({
                            label:b.subdemo_name,
                            value:b.totals_ver,
                            thousand:b.totals_thousand
                        });

                        allnilai.push(b.totals_thousand);
                    }
                })

                listdata.sort(function(a,b){return a.values - b.values });
                
                $.each(listdata,function(a,b){
                    labels.push(b.labels);
                    values.push(b.values);
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<alldata.length;l++){
                    if(alldata[l].thousand==tertinggi){
                        // $("#occupationValue").empty().html(parseFloat(alldata[l].value)+" %");
                        // $("#occupationName").empty().html(alldata[l].label);
                        $("#newOccupation").empty().html(parseFloat(alldata[l].value)+" % "+alldata[l].label);
                    }
                }

                var chartConfig = {
                    "type": "hbar",
                    "plot": {
                        "stacked": true,
                        "valueBox":{
                            "text":"%total%",
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
                        "text": "<div  class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v %<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": values,
                            "rules":[
                                {
                                    "rule":"%i==0",
                                    "background-color":"#ob2347"
                                },
                                {
                                    "rule":"%i==1",
                                    "background-color":"#103061"
                                },
                                {
                                    "rule":"%i==2",
                                    "background-color":"#123770"
                                },
                                {
                                    "rule":"%i==3",
                                    "background-color":"#184995"
                                },
                                {
                                    "rule":"%i==4",
                                    "background-color":"#1f5cb9"
                                },
                                {
                                    "rule":"%i==5",
                                    "background-color":"#2067d5"
                                },
                                {
                                    "rule":"%i==6",
                                    "background-color":"#2572e9"
                                },
                                {
                                    "rule":"%i==7",
                                    "background-color":"#287bfd"
                                },
                                {
                                    "rule":"%i==8",
                                    "background-color":"#5a9bff"
                                },
                                {
                                    "rule":"%i==9",
                                    "background-color":"#86b3f9"
                                },
                                {
                                    "rule":"%i==10",
                                    "background-color":"#b5d2fe"
                                },
                                {
                                    "rule":"%i==11",
                                    "background-color":"#e057e0"
                                }
                            ]
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
                    id: 'divOccupation',
                    data: chartConfig
                });
                
            }

            function showHobby(data){
                var labels=[];
                var values=[];
                var br="";
                var no=0;
                var alldata=[];
                var allnilai=[];
                var listdata=[];


                $.each(data,function(a,b){
                    if(b.demo_id=="D6"){
                        no++;
                        br=b.brand_name;
                        
                        listdata.push({
                            values:parseFloat(b.totals_ver),
                            labels:b.subdemo_name
                        })

                        alldata.push({
                            label:b.subdemo_name,
                            value:b.totals_ver,
                            thousand:b.totals_thousand
                        });

                        allnilai.push(b.totals_thousand);
                    }
                })

                listdata.sort(function(a,b){return a.values - b.values });
                
                $.each(listdata,function(a,b){
                    labels.push(b.labels);
                    values.push(b.values);
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<alldata.length;l++){
                    if(alldata[l].thousand==tertinggi){
                        // $("#hobbyValue").empty().html(parseFloat(alldata[l].value)+" %");
                        // $("#hobbyName").empty().html(alldata[l].label);
                        $("#newHobby").empty().html(parseFloat(alldata[l].value)+" % "+alldata[l].label+"  as their hobby");
                    }
                }

                var chartConfig = {
                    "type": "hbar",
                    "plot": {
                        "stacked": true,
                        "valueBox":{
                            "text":"%total%",
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
                        "text": "<div  class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v %<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": values,
                            "rules":[
                                {
                                    "rule":"%i==0",
                                    "background-color":"#ob2347"
                                },
                                {
                                    "rule":"%i==1",
                                    "background-color":"#103061"
                                },
                                {
                                    "rule":"%i==2",
                                    "background-color":"#123770"
                                },
                                {
                                    "rule":"%i==3",
                                    "background-color":"#184995"
                                },
                                {
                                    "rule":"%i==4",
                                    "background-color":"#1f5cb9"
                                },
                                {
                                    "rule":"%i==5",
                                    "background-color":"#2067d5"
                                },
                                {
                                    "rule":"%i==6",
                                    "background-color":"#2572e9"
                                },
                                {
                                    "rule":"%i==7",
                                    "background-color":"#287bfd"
                                },
                                {
                                    "rule":"%i==8",
                                    "background-color":"#5a9bff"
                                },
                                {
                                    "rule":"%i==9",
                                    "background-color":"#86b3f9"
                                },
                                {
                                    "rule":"%i==10",
                                    "background-color":"#b5d2fe"
                                },
                                {
                                    "rule":"%i==11",
                                    "background-color":"#e057e0"
                                }
                            ]
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
                    id: 'divHobby',
                    data: chartConfig
                });
                
            }

            function showPsiko(data){
                var occupation=[];
                var color=["#6ba148","#96b9e3","#f3a282","#c1c1c1","#4a89c2","#d86a20","#959595","#edb10e","#3a66b4"];
                var br="";
                var no=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D9"){
                        no++;
                        br=b.brand_name;
                        if(no==2 || no==4 || no==5){
                            occupation.push({
                                values:[parseInt(b.totals_thousand)],
                                backgroundColor:color[a],
                                text:b.subdemo_name
                                // "detached":true
                            })
                        }else{
                            occupation.push({
                                values:[parseInt(b.totals_thousand)],
                                backgroundColor:color[a],
                                text:b.subdemo_name
                            })
                        }
                    }
                })

                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        "font-color":"#222222",
                        bold:false,
                        fontSize: 14
                    },
                    "legend":{
                        "x":"65%",
                        "y":"10%",
                        "toggle-action":"remove",
                        "highlight-plot":true
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
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
                    },
                    series : occupation
               };
            
                zingchart.render({ 
                    id : 'divPsiko', 
                    data : myConfig
                });
                
                
            }

            function showMedia(data){
                var labels=[];
                var values=[];
                var br="";
                var no=0;
                var alldata=[];
                var allnilai=[];
                var listdata=[];


                $.each(data,function(a,b){
                    if(b.demo_id=="D7"){
                        no++;
                        br=b.brand_name;
                        
                        listdata.push({
                            values:parseFloat(b.totals_ver),
                            labels:b.subdemo_name
                        })

                        alldata.push({
                            label:b.subdemo_name,
                            value:b.totals_ver,
                            thousand:b.totals_thousand
                        });

                        allnilai.push(b.totals_thousand);
                    }
                })

                listdata.sort(function(a,b){return a.values - b.values });
                
                $.each(listdata,function(a,b){
                    labels.push(b.labels);
                    values.push(b.values);
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<alldata.length;l++){
                    if(alldata[l].thousand==tertinggi){
                        // $("#mediaValue").empty().html(parseFloat(alldata[l].value)+" %");
                        // $("#mediaName").empty().html(alldata[l].label);
                        $("#newMedia").empty().html(parseFloat(alldata[l].value)+" % "+alldata[l].label);
                    }
                }

                var chartConfig = {
                    "type": "hbar",
                    "plot": {
                        "stacked": true,
                        "valueBox":{
                            "text":"%total%",
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
                        "text": "<div  class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v %<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": values,
                            "rules":[
                                {
                                    "rule":"%i==0",
                                    "background-color":"#ob2347"
                                },
                                {
                                    "rule":"%i==1",
                                    "background-color":"#103061"
                                },
                                {
                                    "rule":"%i==2",
                                    "background-color":"#123770"
                                },
                                {
                                    "rule":"%i==3",
                                    "background-color":"#184995"
                                },
                                {
                                    "rule":"%i==4",
                                    "background-color":"#1f5cb9"
                                },
                                {
                                    "rule":"%i==5",
                                    "background-color":"#2067d5"
                                },
                                {
                                    "rule":"%i==6",
                                    "background-color":"#2572e9"
                                },
                                {
                                    "rule":"%i==7",
                                    "background-color":"#287bfd"
                                },
                                {
                                    "rule":"%i==8",
                                    "background-color":"#5a9bff"
                                },
                                {
                                    "rule":"%i==9",
                                    "background-color":"#86b3f9"
                                },
                                {
                                    "rule":"%i==10",
                                    "background-color":"#b5d2fe"
                                },
                                {
                                    "rule":"%i==11",
                                    "background-color":"#e057e0"
                                }
                            ]
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
                    id: 'divMedia',
                    data: chartConfig
                });
            }

            function showCity(data){
                var labels=[];
                var values=[];
                var br="";
                var no=0;
                var alldata=[];
                var allnilai=[];
                var listdata=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D8"){
                        no++;
                        br=b.brand_name;
                        
                        listdata.push({
                            values:parseFloat(b.totals_ver),
                            labels:b.subdemo_name
                        })

                        alldata.push({
                            label:b.subdemo_name,
                            value:b.totals_ver,
                            thousand:b.totals_thousand
                        });

                        allnilai.push(b.totals_thousand);
                    }
                })

                listdata.sort(function(a,b){return a.values - b.values });
                
                $.each(listdata,function(a,b){
                    labels.push(b.labels);
                    values.push(b.values);
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<alldata.length;l++){
                    if(alldata[l].thousand==tertinggi){
                        // $("#kotaValue").empty().html(parseFloat(alldata[l].value)+" %");
                        // $("#kotaName").empty().html(alldata[l].label);
                        $("#newKota").empty().html(parseFloat(alldata[l].value)+" % Live in "+alldata[l].label);
                    }
                }

                var chartConfig = {
                    "type": "hbar",
                    "plot": {
                        "stacked": true,
                        "valueBox":{
                            "text":"%total%",
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
                        "text": "<div  class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v %<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": values,
                            "rules":[
                                {
                                    "rule":"%i==0",
                                    "background-color":"#ob2347"
                                },
                                {
                                    "rule":"%i==1",
                                    "background-color":"#103061"
                                },
                                {
                                    "rule":"%i==2",
                                    "background-color":"#123770"
                                },
                                {
                                    "rule":"%i==3",
                                    "background-color":"#184995"
                                },
                                {
                                    "rule":"%i==4",
                                    "background-color":"#1f5cb9"
                                },
                                {
                                    "rule":"%i==5",
                                    "background-color":"#2067d5"
                                },
                                {
                                    "rule":"%i==6",
                                    "background-color":"#2572e9"
                                },
                                {
                                    "rule":"%i==7",
                                    "background-color":"#287bfd"
                                },
                                {
                                    "rule":"%i==8",
                                    "background-color":"#5a9bff"
                                },
                                {
                                    "rule":"%i==9",
                                    "background-color":"#86b3f9"
                                },
                                {
                                    "rule":"%i==10",
                                    "background-color":"#b5d2fe"
                                },
                                {
                                    "rule":"%i==11",
                                    "background-color":"#e057e0"
                                }
                            ]
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
                    id: 'divCity',
                    data: chartConfig
                });
            }

            function showTimeSpent(data){
                var education=[];
                var color=["#50ADF5","#FF7965","#a0a0a0","#ffc720","#557dcb"];
                var br="";
                var allnilai=[];
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D10"){
                        br=b.brand_name;
                        education.push({
                            values:[parseFloat(b.totals_ver)],
                            backgroundColor:color[n],
                            ver:b.totals_ver,
                            thousand:b.totals_thousand,
                            text:b.subdemo_name
                        })

                        allnilai.push(b.totals_thousand);
                        n++;
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<education.length;l++){
                    if(education[l].thousand==tertinggi){
                        // $("#timespentValue").empty().html(parseFloat(education[l].ver)+" %");
                        // $("#timespentName").empty().html(education[l].text);
                        $("#newTimeSpent").empty().html(parseFloat(education[l].ver)+" % spend "+education[l].text+" to access internet");
                    }
                }

                var myConfig = {
                    type: "pie3d",
                    "plotarea": {
                        "margin": "0 0"
                    }, 
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        "font-color":"#222222",
                        bold:false,
                        fontSize: 14
                    },
                    backgroundColor: "#fff",
                    "scale":{
                        "layout":"1x1", //specify the layout by rows and columns
                        "size-factor":0.6 //provide a decimal or percentage value
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "out",
                            text: "%t:%v%",
                            fontSize: 12,
                            bold:false
                        }],
                        "tooltip":{
                            "text":"%t: %v%",
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
                            // "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    series : education
                };
            
                zingchart.render({ 
                    id : 'divTimeSpent', 
                    data : myConfig
                });
            }

            function showFrequency(data){
                var education=[];
                var color=["#50ADF5","#FF7965","#a0a0a0","#ffc720","#557dcb"];
                var br="";
                var allnilai=[];

                data.sort(function(a, b){return b.totals_ver - a.totals_ver});
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D11"){
                        n++;

                        if(n<=5){
                            br=b.brand_name;
                            education.push({
                                values:[parseFloat(b.totals_ver)],
                                backgroundColor:color[n],
                                ver:b.totals_ver,
                                thousand:b.totals_thousand,
                                text:b.subdemo_name
                            })

                            allnilai.push(b.totals_thousand);
                        }
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<education.length;l++){
                    if(education[l].thousand==tertinggi){
                        // $("#frequencyValue").empty().html(parseFloat(education[l].ver)+" %");
                        // $("#frequencyName").empty().html(education[l].text);
                        $("#newFrequencyName").empty().html(parseFloat(education[l].ver)+" % Use Internet "+education[l].text);
                    }
                }

                var myConfig = {
                    type: "pie3d",
                    "plotarea": {
                        "margin": "0 0"
                    }, 
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        "font-color":"#222222",
                        bold:false,
                        fontSize: 14
                    },
                    backgroundColor: "#fff",
                    "scale":{
                        "layout":"1x1", //specify the layout by rows and columns
                        "size-factor":0.6 //provide a decimal or percentage value
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "out",
                            text: "%t:%v%",
                            fontSize: 12,
                            bold:false
                        }],
                        "tooltip":{
                            "text":"%t: %v%",
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
                            // "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    series : education
                };
            
                zingchart.render({ 
                    id : 'divFrequency', 
                    data : myConfig
                });
            }

            function showGeneral(data){
                var labels=[];
                var values=[];
                var br="";
                var no=0;
                var alldata=[];
                var allnilai=[];
                var listdata=[];

                data.sort(function(a, b){return b.totals_ver - a.totals_ver});
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D12"){
                        n++;

                        if(n<=5){
                            br=b.brand_name;

                            listdata.push({
                                values:parseFloat(b.totals_ver),
                                labels:b.subdemo_name
                            })

                            alldata.push({
                                label:b.subdemo_name,
                                value:b.totals_ver,
                                thousand:b.totals_thousand
                            });

                            allnilai.push(b.totals_thousand);
                        }
                    }
                })

                listdata.sort(function(a,b){return a.values - b.values });
                
                $.each(listdata,function(a,b){
                    labels.push(b.labels);
                    values.push(b.values);
                })
                

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<alldata.length;l++){
                    if(alldata[l].thousand==tertinggi){
                        // $("#generalValue").empty().html(parseFloat(alldata[l].value)+" %");
                        // $("#generalName").empty().html(alldata[l].label);
                        $("#newGeneral").empty().html(parseFloat(alldata[l].value)+" % use internet for "+alldata[l].label);
                    }
                }

                var chartConfig = {
                    "type": "hbar",
                    "plot": {
                        "stacked": true,
                        "valueBox":{
                            "text":"%total%",
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
                        "text": "<div  class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v %<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": values,
                            "rules":[
                                {
                                    "rule":"%i==0",
                                    "background-color":"#ob2347"
                                },
                                {
                                    "rule":"%i==1",
                                    "background-color":"#103061"
                                },
                                {
                                    "rule":"%i==2",
                                    "background-color":"#123770"
                                },
                                {
                                    "rule":"%i==3",
                                    "background-color":"#184995"
                                },
                                {
                                    "rule":"%i==4",
                                    "background-color":"#1f5cb9"
                                },
                                {
                                    "rule":"%i==5",
                                    "background-color":"#2067d5"
                                },
                                {
                                    "rule":"%i==6",
                                    "background-color":"#2572e9"
                                },
                                {
                                    "rule":"%i==7",
                                    "background-color":"#287bfd"
                                },
                                {
                                    "rule":"%i==8",
                                    "background-color":"#5a9bff"
                                },
                                {
                                    "rule":"%i==9",
                                    "background-color":"#86b3f9"
                                },
                                {
                                    "rule":"%i==10",
                                    "background-color":"#b5d2fe"
                                },
                                {
                                    "rule":"%i==11",
                                    "background-color":"#e057e0"
                                }
                            ]
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
                    id: 'divGeneral',
                    height:350,
                    data: chartConfig
                });
            }

            function showFinance(data){
                var labels=[];
                var values=[];
                var br="";
                var no=0;
                var alldata=[];
                var allnilai=[];
                var listdata=[];

                data.sort(function(a, b){return b.totals_ver - a.totals_ver});
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D13" && b.subdemo_id!="DD108"){
                        n++;

                        if(n<=5){
                            br=b.brand_name;
                            
                            listdata.push({
                                values:parseFloat(b.totals_ver),
                                labels:b.subdemo_name
                            })

                            alldata.push({
                                label:b.subdemo_name,
                                value:b.totals_ver,
                                thousand:b.totals_thousand
                            });

                            allnilai.push(b.totals_thousand);
                        }
                    }
                })

                listdata.sort(function(a,b){return a.values - b.values });
                
                $.each(listdata,function(a,b){
                    labels.push(b.labels);
                    values.push(b.values);
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<alldata.length;l++){
                    if(alldata[l].thousand==tertinggi){
                        // $("#financeValue").empty().html(parseFloat(alldata[l].value)+" %");
                        // $("#financeName").empty().html(alldata[l].label);
                        $("#newFinance").empty().html(parseFloat(alldata[l].value)+" % use e-finance to "+alldata[l].label);
                    }
                }

                var chartConfig = {
                    "type": "hbar",
                    "plot": {
                        "stacked": true,
                        "valueBox":{
                            "text":"%total%",
                            "rules": [
                                {
                                    "rule": '%stack-top == 0',
                                    "visible": 0
                                }
                            ]
                        }
                    },
                    "plotarea": {
                        margin: 'dynamic dynamic dynamic dynamic',
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
                        "text": "<div  class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v %<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": values,
                            "rules":[
                                {
                                    "rule":"%i==0",
                                    "background-color":"#ob2347"
                                },
                                {
                                    "rule":"%i==1",
                                    "background-color":"#103061"
                                },
                                {
                                    "rule":"%i==2",
                                    "background-color":"#123770"
                                },
                                {
                                    "rule":"%i==3",
                                    "background-color":"#184995"
                                },
                                {
                                    "rule":"%i==4",
                                    "background-color":"#1f5cb9"
                                },
                                {
                                    "rule":"%i==5",
                                    "background-color":"#2067d5"
                                },
                                {
                                    "rule":"%i==6",
                                    "background-color":"#2572e9"
                                },
                                {
                                    "rule":"%i==7",
                                    "background-color":"#287bfd"
                                },
                                {
                                    "rule":"%i==8",
                                    "background-color":"#5a9bff"
                                },
                                {
                                    "rule":"%i==9",
                                    "background-color":"#86b3f9"
                                },
                                {
                                    "rule":"%i==10",
                                    "background-color":"#b5d2fe"
                                },
                                {
                                    "rule":"%i==11",
                                    "background-color":"#e057e0"
                                }
                            ]
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
                    id: 'divFinance',
                    height:350,
                    data: chartConfig
                });
            }

            function showCommerce(data){
                var labels=[];
                var values=[];
                var br="";
                var no=0;
                var alldata=[];
                var allnilai=[];
                var listdata=[];

                data.sort(function(a, b){return b.totals_ver - a.totals_ver});
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D14" && b.subdemo_id!="DD122"){
                        n++;

                        if(n<=5){
                            br=b.brand_name;
                            
                            listdata.push({
                                values:parseFloat(b.totals_ver),
                                labels:b.subdemo_name
                            })

                            alldata.push({
                                label:b.subdemo_name,
                                value:b.totals_ver,
                                thousand:b.totals_thousand
                            });

                            allnilai.push(b.totals_thousand);
                        }
                    }
                })

                listdata.sort(function(a,b){return a.values - b.values });
                
                $.each(listdata,function(a,b){
                    labels.push(b.labels);
                    values.push(b.values);
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<alldata.length;l++){
                    if(alldata[l].thousand==tertinggi){
                        // $("#commerceValue").empty().html(parseFloat(alldata[l].value)+" %");
                        // $("#commerceName").empty().html(alldata[l].label);
                        $("#newCommerce").empty().html(parseFloat(alldata[l].value)+" % use e-commerce to look for "+alldata[l].label);
                    }
                }

                var chartConfig = {
                    "type": "hbar",
                    "plot": {
                        "stacked": true,
                        "valueBox":{
                            "text":"%total%",
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
                        "text": "<div  class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v %<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": values,
                            "rules":[
                                {
                                    "rule":"%i==0",
                                    "background-color":"#ob2347"
                                },
                                {
                                    "rule":"%i==1",
                                    "background-color":"#103061"
                                },
                                {
                                    "rule":"%i==2",
                                    "background-color":"#123770"
                                },
                                {
                                    "rule":"%i==3",
                                    "background-color":"#184995"
                                },
                                {
                                    "rule":"%i==4",
                                    "background-color":"#1f5cb9"
                                },
                                {
                                    "rule":"%i==5",
                                    "background-color":"#2067d5"
                                },
                                {
                                    "rule":"%i==6",
                                    "background-color":"#2572e9"
                                },
                                {
                                    "rule":"%i==7",
                                    "background-color":"#287bfd"
                                },
                                {
                                    "rule":"%i==8",
                                    "background-color":"#5a9bff"
                                },
                                {
                                    "rule":"%i==9",
                                    "background-color":"#86b3f9"
                                },
                                {
                                    "rule":"%i==10",
                                    "background-color":"#b5d2fe"
                                },
                                {
                                    "rule":"%i==11",
                                    "background-color":"#e057e0"
                                }
                            ]
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
                    id: 'divCommerce',
                    height:350,
                    data: chartConfig
                });
            }

            function showTools(data){
                var education=[];
                var color=["#50ADF5","#FF7965","#a0a0a0","#ffc720","#557dcb"];
                var br="";
                var allnilai=[];
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D15"){
                        br=b.brand_name;
                        education.push({
                            values:[parseFloat(b.totals_ver)],
                            backgroundColor:color[n],
                            ver:b.totals_ver,
                            thousand:b.totals_thousand,
                            text:b.subdemo_name
                        })

                        allnilai.push(b.totals_thousand);
                        n++;
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<education.length;l++){
                    if(education[l].thousand==tertinggi){
                        // $("#toolsValue").empty().html(parseFloat(education[l].ver)+" %");
                        // $("#toolsName").empty().html(education[l].text);
                        $("#newTools").empty().html(parseFloat(education[l].ver)+" % use "+education[l].text+" to access internet");
                    }
                }

                var myConfig = {
                    type: "pie3d",
                    "plotarea": {
                        "margin": "0 0"
                    }, 
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        "font-color":"#222222",
                        bold:false,
                        fontSize: 14
                    },
                    backgroundColor: "#fff",
                    "scale":{
                        "layout":"1x1", //specify the layout by rows and columns
                        "size-factor":0.6 //provide a decimal or percentage value
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "out",
                            text: "%t:%v%",
                            fontSize: 12,
                            bold:false
                        }],
                        "tooltip":{
                            "text":"%t: %v%",
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
                            // "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    series : education
                };
            
                zingchart.render({ 
                    id : 'divTools', 
                    data : myConfig
                });
            }

            function showAllWebsite(data){
                var labels=[];
                var values=[];
                var br="";
                var no=0;
                var alldata=[];
                var allnilai=[];
                var listdata=[];

                data.sort(function(a, b){return b.totals_ver - a.totals_ver});
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D16"){
                        n++;

                        if(n<=5){
                            br=b.brand_name;

                            listdata.push({
                                values:parseFloat(b.totals_ver),
                                labels:b.subdemo_name
                            })

                            alldata.push({
                                label:b.subdemo_name,
                                value:b.totals_ver,
                                thousand:b.totals_thousand
                            });

                            allnilai.push(b.totals_thousand);
                        }
                    }
                })

                listdata.sort(function(a,b){return a.values - b.values });
                
                $.each(listdata,function(a,b){
                    labels.push(b.labels);
                    values.push(b.values);
                })
                

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<alldata.length;l++){
                    if(alldata[l].thousand==tertinggi){
                        // $("#allWebsiteValue").empty().html(parseFloat(alldata[l].value)+" %");
                        // $("#allWebsiteName").empty().html(alldata[l].label);
                        $("#newAllWebsite").empty().html(alldata[l].label+" is the most often site visited by "+parseFloat(alldata[l].value)+" % of consumer");
                    }
                }

                var chartConfig = {
                    "type": "hbar",
                    "plot": {
                        "stacked": true,
                        "valueBox":{
                            "text":"%total%",
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
                        "text": "<div  class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v %<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": values,
                            "rules":[
                                {
                                    "rule":"%i==0",
                                    "background-color":"#ob2347"
                                },
                                {
                                    "rule":"%i==1",
                                    "background-color":"#103061"
                                },
                                {
                                    "rule":"%i==2",
                                    "background-color":"#123770"
                                },
                                {
                                    "rule":"%i==3",
                                    "background-color":"#184995"
                                },
                                {
                                    "rule":"%i==4",
                                    "background-color":"#1f5cb9"
                                },
                                {
                                    "rule":"%i==5",
                                    "background-color":"#2067d5"
                                },
                                {
                                    "rule":"%i==6",
                                    "background-color":"#2572e9"
                                },
                                {
                                    "rule":"%i==7",
                                    "background-color":"#287bfd"
                                },
                                {
                                    "rule":"%i==8",
                                    "background-color":"#5a9bff"
                                },
                                {
                                    "rule":"%i==9",
                                    "background-color":"#86b3f9"
                                },
                                {
                                    "rule":"%i==10",
                                    "background-color":"#b5d2fe"
                                },
                                {
                                    "rule":"%i==11",
                                    "background-color":"#e057e0"
                                }
                            ]
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
                    id : 'divAllWebsite', 
                    data : chartConfig
                });
            }

            function showFrequencyRadio(data){
                var education=[];
                var color=["#50ADF5","#FF7965","#a0a0a0","#ffc720","#557dcb"];
                var br="";
                var allnilai=[];
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D17"){
                        br=b.brand_name;
                        education.push({
                            values:[parseFloat(b.totals_ver)],
                            backgroundColor:color[n],
                            ver:b.totals_ver,
                            thousand:b.totals_thousand,
                            text:b.subdemo_name
                        })

                        allnilai.push(b.totals_thousand);
                        n++;
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<education.length;l++){
                    if(education[l].thousand==tertinggi){
                        // $("#frequensiRadioValue").empty().html(parseFloat(education[l].ver)+" %");
                        // $("#frequensiRadioName").empty().html(education[l].text);
                        $("#newFrequensiRadio").empty().html(parseFloat(education[l].ver)+" % consumer are listening to the radio "+education[l].text);
                    }
                }

                var myConfig = {
                    type: "pie3d",
                    "plotarea": {
                        "margin": "0 0"
                    }, 
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        "font-color":"#222222",
                        bold:false,
                        fontSize: 14
                    },
                    backgroundColor: "#fff",
                    "scale":{
                        "layout":"1x1", //specify the layout by rows and columns
                        "size-factor":0.6 //provide a decimal or percentage value
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "out",
                            text: "%t:%v%",
                            fontSize: 9
                        }],
                        "tooltip":{
                            "text":"%t: %v%",
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
                            // "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    series : education
                };
            
                zingchart.render({ 
                    id : 'divFrequencyRadio', 
                    data : myConfig
                });
            }

            function showPlace(data){
                var education=[];
                var color=["#50ADF5","#FF7965","#a0a0a0","#ffc720","#557dcb"];
                var br="";
                var allnilai=[];
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D18"){
                        br=b.brand_name;
                        education.push({
                            values:[parseFloat(b.totals_ver)],
                            backgroundColor:color[n],
                            ver:b.totals_ver,
                            thousand:b.totals_thousand,
                            text:b.subdemo_name
                        })

                        allnilai.push(b.totals_thousand);
                        n++;
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<education.length;l++){
                    if(education[l].thousand==tertinggi){
                        // $("#placeValue").empty().html(parseFloat(education[l].ver)+" %");
                        // $("#placeName").empty().html(education[l].text);
                        $("#newPlace").empty().html(parseFloat(education[l].ver)+" % consumer are listening to the radio in their "+education[l].text);
                    }
                }

                var myConfig = {
                    type: "pie3d",
                    "plotarea": {
                        "margin": "0 0"
                    }, 
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        "font-color":"#222222",
                        bold:false,
                        fontSize: 14
                    },
                    backgroundColor: "#fff",
                    "scale":{
                        "layout":"1x1", //specify the layout by rows and columns
                        "size-factor":0.6 //provide a decimal or percentage value
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "out",
                            text: "%t:%v%",
                            fontSize: 9
                        }],
                        "tooltip":{
                            "text":"%t: %v%",
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
                            // "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    series : education
                };
            
                zingchart.render({ 
                    id : 'divPlace', 
                    data : myConfig
                });
            }

            function showToolsListeningRadio(data){
                var education=[];
                var color=["#50ADF5","#FF7965","#a0a0a0","#ffc720","#557dcb"];
                var br="";
                var allnilai=[];
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D19"){
                        br=b.brand_name;
                        education.push({
                            values:[parseFloat(b.totals_ver)],
                            backgroundColor:color[n],
                            ver:b.totals_ver,
                            thousand:b.totals_thousand,
                            text:b.subdemo_name
                        })

                        allnilai.push(b.totals_thousand);
                        n++;
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<education.length;l++){
                    if(education[l].thousand==tertinggi){
                        // $("#toolsListeningValue").empty().html(parseFloat(education[l].ver)+" %");
                        // $("#toolsListeningName").empty().html(education[l].text);
                        $("#newToolsListening").empty().html(parseFloat(education[l].ver)+" % consumer are listening to the radio with his "+education[l].text);
                    }
                }

                var myConfig = {
                    type: "pie3d",
                    "plotarea": {
                        "margin": "0 0"
                    }, 
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        "font-color":"#222222",
                        bold:false,
                        fontSize: 14
                    },
                    backgroundColor: "#fff",
                    "scale":{
                        "layout":"1x1", //specify the layout by rows and columns
                        "size-factor":0.6 //provide a decimal or percentage value
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "out",
                            text: "%t:%v%",
                            fontSize: 9
                        }],
                        "tooltip":{
                            "text":"%t: %v%",
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
                            // "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    series : education
                };
            
                zingchart.render({ 
                    id : 'divToolsListeningRadio', 
                    data : myConfig
                });
            }

            function showAllTime(data){
                var education=[];
                var color=["#5197d7","#ef7421","#aaaaaa"];
                var br="";
                var allnilai=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D20"){
                        br=b.brand_name;
                        education.push({
                            values:[parseFloat(b.totals_ver)],
                            backgroundColor:color[a],
                            ver:b.totals_ver,
                            thousand:b.totals_thousand,
                            text:b.subdemo_name
                        })

                        allnilai.push(b.totals_thousand);
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<education.length;l++){
                    if(education[l].thousand==tertinggi){
                        $("#allTimeValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#allTimeName").empty().html(education[l].text);
                    }
                }

                var myConfig = {
                    type: "pie",
                    "plotarea": {
                        "margin": "0 0"
                    }, 
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 14
                    },
                    backgroundColor: "#fff",
                    "scale":{
                        "layout":"1x1", //specify the layout by rows and columns
                        "size-factor":0.6 //provide a decimal or percentage value
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "out",
                            text: "%t:%v%",
                            fontColor: "#1A1B26",
                            fontSize: 7
                        }],
                        "tooltip":{
                            "text":"%t: %v%",
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
                    series : education
                };
            
                zingchart.render({ 
                    id : 'divAllTime', 
                    data : myConfig
                });
            }

            function showPrimeTime(data){
                var education=[];
                var color=["#5197d7","#ef7421","#aaaaaa"];
                var br="";
                var allnilai=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D21"){
                        br=b.brand_name;
                        education.push({
                            values:[parseFloat(b.totals_ver)],
                            backgroundColor:color[a],
                            ver:b.totals_ver,
                            thousand:b.totals_thousand,
                            text:b.subdemo_name
                        })

                        allnilai.push(b.totals_thousand);
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<education.length;l++){
                    if(education[l].thousand==tertinggi){
                        $("#primeTimeValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#primeTimeName").empty().html(education[l].text);
                    }
                }

                var myConfig = {
                    type: "pie",
                    "plotarea": {
                        "margin": "0 0"
                    }, 
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        "font-color":"#222222",
                        bold:false,
                        fontSize: 14
                    },
                    backgroundColor: "#fff",
                    "scale":{
                        "layout":"1x1", //specify the layout by rows and columns
                        "size-factor":0.6 //provide a decimal or percentage value
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "out",
                            text: "%t:%v%",
                            fontSize: 7
                        }],
                        "tooltip":{
                            "text":"%t: %v%",
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
                    series : education
                };
            
                zingchart.render({ 
                    id : 'divPrimeTime', 
                    data : myConfig
                });
            }

            function showNonPrimeTime(data){
                var education=[];
                var color=["#5197d7","#ef7421","#aaaaaa"];
                var br="";
                var allnilai=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D22"){
                        br=b.brand_name;
                        education.push({
                            values:[parseFloat(b.totals_ver)],
                            backgroundColor:color[a],
                            ver:b.totals_ver,
                            thousand:b.totals_thousand,
                            text:b.subdemo_name
                        })

                        allnilai.push(b.totals_thousand);
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<education.length;l++){
                    if(education[l].thousand==tertinggi){
                        $("#nonprimetimeValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#nonprimetimeName").empty().html(education[l].text);
                    }
                }

                var myConfig = {
                    type: "pie",
                    "plotarea": {
                        "margin": "0 0"
                    }, 
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 14
                    },
                    backgroundColor: "#fff",
                    "scale":{
                        "layout":"1x1", //specify the layout by rows and columns
                        "size-factor":0.6 //provide a decimal or percentage value
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "out",
                            text: "%t:%v%",
                            fontColor: "#1A1B26",
                            fontSize: 7
                        }],
                        "tooltip":{
                            "text":"%t: %v%",
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
                    series : education
                };
            
                zingchart.render({ 
                    id : 'divNonPrimeTime', 
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
                        result.reverse();
                        alldata=result;

                        showGender(alldata);
                        showSec(alldata);
                        showAge(alldata);
                        showEducation(alldata);
                        showOccupation(alldata);
                        showHobby(alldata);
                        showPsiko(alldata);
                        showMedia(alldata);
                        showCity(alldata);
                        showTimeSpent(alldata);
                        showFrequency(alldata);
                        showGeneral(alldata);
                        showFinance(alldata);
                        showCommerce(alldata);
                        showTools(alldata);
                        showAllWebsite(alldata);
                        showFrequencyRadio(alldata);
                        showPlace(alldata);
                        showToolsListeningRadio(alldata);
                        // showAllTime(alldata);
                        // showPrimeTime(alldata);
                        // showNonPrimeTime(alldata);

                        showDayPart();
                    },
                    error:function(){

                    }
                })
            }

            function showDayPart(){
                var brand=$("#brand").val();
                var quartal=$("#quartal").val();

                $.ajax({
                    url:"{{URL::to('cmv/data/chart/day-part')}}",
                    type:"GET",
                    data:"brand="+brand+"&quartal="+quartal,
                    beforeSend:function(){
                        $("#divTableDaypart").empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        $("#divGrafikDaypart").empty();
                    },
                    success:function(result){
                        if(result.success==true){
                            var el="";
                            var rcti=[];
                            var mnctv=[];
                            var gtv=[];
                            var label="";

                            el+='<table class="table table-striped">'+
                                '<thead>'+
                                    '<tr>'+
                                        '<th colspan="10" class="text-center"><p id="labelDayPart"></p></th>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<th></th>'+
                                        '<th>02:00 TO 06:59</th>'+
                                        '<th>07:00 TO 08:59</th>'+
                                        '<th>09:00 TO 11:59</th>'+
                                        '<th>12:00 TO 13:59</th>'+
                                        '<th>14:00 TO 17:59</th>'+
                                        '<th>18:00 TO 19:59</th>'+
                                        '<th>20:00 TO 21:59</th>'+
                                        '<th>22:00 TO 23:59</th>'+
                                        '<th>24:00 TO 25:59</th>'+
                                    '</tr>'+
                                '</thead>'+
                                '<tbody>';
                                $.each(result.data,function(a,b){
                                    label=b.brand_name;
                                    if(b.subdemo_name=="RCTI"){
                                        rcti=[
                                                b.pertama,
                                                b.kedua,
                                                b.ketiga,
                                                b.keempat,
                                                b.kelima,
                                                b.keenam,
                                                b.ketujuh,
                                                b.kedelapan,
                                                b.kesembilan
                                            ];
                                    }

                                    if(b.subdemo_name=="MNCTV"){
                                        mnctv=[
                                                b.pertama,
                                                b.kedua,
                                                b.ketiga,
                                                b.keempat,
                                                b.kelima,
                                                b.keenam,
                                                b.ketujuh,
                                                b.kedelapan,
                                                b.kesembilan
                                            ];
                                    }

                                    if(b.subdemo_name=="GTV"){
                                        gtv=[
                                                b.pertama,
                                                b.kedua,
                                                b.ketiga,
                                                b.keempat,
                                                b.kelima,
                                                b.keenam,
                                                b.ketujuh,
                                                b.kedelapan,
                                                b.kesembilan
                                            ];
                                    }

                                    el+="<tr>"+
                                        '<td>'+b.subdemo_name+'</td>'+
                                        '<td>'+b.pertama+'</td>'+
                                        '<td>'+b.kedua+'</td>'+
                                        '<td>'+b.ketiga+'</td>'+
                                        '<td>'+b.keempat+'</td>'+
                                        '<td>'+b.kelima+'</td>'+
                                        '<td>'+b.keenam+'</td>'+
                                        '<td>'+b.ketujuh+'</td>'+
                                        '<td>'+b.kedelapan+'</td>'+
                                        '<td>'+b.kesembilan+'</td>'+
                                    '</tr>';
                                })
                                el+='</tbody>'+
                            '</table>';

                            $("#divTableDaypart").empty().html(el);
                            $("#labelDayPart").empty().html(label);

                            console.log(rcti);

                            var myConfig = {
                                "background-color":"white",
                                "type":"line",
                                "title":{
                                    "text":label,
                                    "font-color":"#222222",
                                    bold:false,
                                    "font-size":14,
                                    "font-weight":40,
                                    "background-color":"white",
                                    "text-align":"center",
                                },
                                legend:{
                                    adjustLayout: true,
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                },
                                "scaleX":{
                                    "values": [
                                        "02:00 - 06:59",
                                        "07:00 - 08:59",
                                        "09:00 - 11:59",
                                        "12:00 - 13:59",
                                        "14:00 - 17:59",
                                        "18:00 - 19:59",
                                        "20:00 - 21:59",
                                        "22:00 - 23:59",
                                        "24:00 - 25:59"
                                    ],
                                    "max-items":9
                                },
                                "scaleY":{
                                    "line-color":"#333",
                                    "max-labels":9,
                                    "margin":"15% 25% 10% 7%"
                                },
                                "tooltip":{
                                    "text":"%t: %v outbreaks in %k"
                                },
                                "plot":{
                                    "line-width":3,
                                    "marker":{
                                        "size":3,
                                        "type":"square",
                                        "angle":45
                                    },
                                    "selection-mode":"multiple",
                                    "background-mode":"graph",
                                    "selected-state":{
                                        "line-width":4
                                    },
                                    "background-state":{
                                        "line-color":"#eee",
                                        "marker":{
                                            "background-color":"none",
                                            size: 4
                                        }
                                    }
                                },
                                "plotarea":{
                                    // "margin":"15% 25% 10% 7%"
                                },
                                crosshairX:{
                                    exact: true,
                                    lineColor:'#000',
                                    scaleLabel:{
                                        borderRadius: 2
                                    },
                                    marker:{
                                        size: 7,
                                        alpha: 0.5,
                                        backgroundColor:'white',
                                        borderWidth: 2,
                                        borderColor:'#000'
                                    }
                                },
                                "series":[
                                    {
                                        // "values":[1033,988,1283,1128,1472,1380,1392,1186,836],
                                        "values":rcti,
                                        "text":"RCTI",
                                        "line-color":"#3542ab",
                                        "marker":{
                                            "background-color":"#a6cee3",
                                            "border-color":"#a6cee3"
                                        }
                                    },
                                    {
                                        "values":mnctv,
                                        "text":"MNCTV",
                                        "line-color":"#009ce4",
                                        "marker":{
                                            "background-color":"#1f78b4",
                                            "border-color":"#1f78b4"
                                        }
                                    },
                                    {
                                        "values":gtv,
                                        "text":"GTV",
                                        "line-color":"#c00000",
                                        "marker":{
                                            "background-color":"#b2df8a",
                                            "border-color":"#b2df8a"
                                        }
                                    }
                                ]
                            };


                            
                            zingchart.render({ 
                                id: 'divGrafikDaypart', 
                                data: myConfig,
                            });
                        }else{
                            $("#divTableDaypart").empty().html('<div class="alert alert-danger">&nbsp;Failed to load data</div>');
                        }
                    },
                    errors:function(){
                        $("#divTableDaypart").empty().html('<div class="alert alert-danger">&nbsp;Link not found</div>');
                    }
                })
            }

            function topbrand(){
                var brand=$("#brand").val();
                var quartal=$("#quartal").val();

                $.ajax({
                    url:"{{URL::to('cmv/data/top-brand-by-category')}}",
                    type:"GET",
                    data:"brand="+brand+"&quartal="+quartal,
                    beforeSend:function(){
                        $("#topBrand").empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        $("#rankTopBrand").empty();
                    },
                    success:function(result){
                        var primaryColor = "#4184F3";
                        var primaryColorHover = "#3a53c5";
                        var secondaryColor = '#DCDCDC'
                        var scaleTextColor = '#999';

                        var labels=[];
                        var values=[];

                        var filterbrand=result.allbrand.slice(0,10);
                        filterbrand.reverse();
                        $.each(filterbrand,function(a,b){
                            labels.push(b.brand_name);
                            values.push(b.totals_thousand);
                        })
                        
                        var brandrank="";
                        var brandcategory="";
                        for (var i=0; i<result.allbrand.length; i++){
                            if (result.allbrand[i].brand_id === result.brand.brand_id){
                                brandrank=i+1;
                                brandcategory= result.brand.category.category_name;
                            }
                        }
                        
                        var el="";
                        el+="<table class='table table-striped' style='color:#22222'>"+
                            '<thead>'+
                                '<tr>'+
                                    '<th style="color:#000">Rank</th>'+
                                    '<th style="color:#000"> : </th>'+
                                    '<th style="color:#000">'+brandrank+'</th>'+
                                '</tr>'+
                                '<tr>'+
                                    '<th style="color:#000">Category</th>'+
                                    '<th style="color:#000"> : </th>'+
                                    '<th style="color:#000">'+brandcategory+'</th>'+
                                '</tr>'+
                            '</thead>'+
                        '</table>';

                        $("#rankTopBrand").empty().html(el);
                        
                        $("#topBrand").empty();

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
                                text: "* Dalam Ribu",
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
                            id: 'topBrand',
                            data: chartConfig,
                            output: 'canvas',
                            height:'100%',
                            width:'100%'
                        });
                    },
                    error:function(){

                    }
                })
            }

            $(document).on("submit","#formSearch",function(e){
                var el="";
                var namabrand=$("#brand").select2('data').text;

                /* summary */
                el+='<div class="card card-primary">'+
                    '<div class="card-status bg-green"></div>'+
                    '<div class="card-header">'+
                        '<p class="card-title no-italics"><strong>SUMMARY</strong></p>'+
                        '<div class="card-options">'+
                            '<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>'+
                            '<a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>'+
                        '</div>'+
                    '</div>'+
                    '<div class="card-body">'+
                        '<h3><b>'+namabrand+'</b> <small>consumer is dominated by:</small></h3>'+
                        '<hr>'+
                        '<h6>DEMOGRAPHY</h6>'+
                        '<div class="highlight" style="padding-top:10px;">'+
                        '<ul class="summary">'+
                            '<li><p id="newGender"></p></li>'+
                            '<li><p id="newAge"></p></li>'+
                            '<li><p id="newSec"></p></li>'+
                            '<li><p id="newEducation"></p></li>'+
                            '<li><p id="newOccupation"></p></li>'+
                            '<li><p id="newHobby"></p></li>'+
                        '</ul>'+ 
                        '</div>'+
                        '<h6>PENETRATION</h6>'+
                        '<div class="highlight" style="padding-top:10px;">'+
                        '<ul class="summary">'+
                            '<li><p id="newMedia"></p></li>'+
                            '<li><p id="newKota"></p></li>'+
                        '</ul>'+ 
                        '</div>'+
                        '<h6>INTERNET</h6>'+
                        '<div class="highlight" style="padding-top:10px;">'+
                        '<ul class="summary">'+
                            '<li><p id="newFrequencyName"></p></li>'+
                            '<li><p id="newTimeSpent"></p></li>'+
                            '<li><p id="newGeneral"></p></li>'+
                            '<li><p id="newFinance"></p></li>'+
                            '<li><p id="newCommerce"></p></li>'+
                            '<li><p id="newTools"></p></li>'+
                            '<li><p id="newAllWebsite"></p></li>'+
                        '</ul>'+ 
                        '</div>'+
                        '<h6>RADIO</h6>'+
                        '<div class="highlight" style="padding-top:10px;">'+
                        '<ul class="summary">'+
                            '<li><p id="newFrequensiRadio"></p></li>'+
                            '<li><p id="newPlace"></p></li>'+
                            '<li><p id="newToolsListening"></p></li>'+
                        '</ul>'+ 
                        '</div>'+
                        // '<table width="60%">'+
                        //     '<thead>'+
                        //         '<tr>'+
                        //             '<th colspan="3"><h6>DEMOGRAPHY</h6></th>'+
                        //         '</tr>'+
                        //     '</thead>'+
                        //     '<tbody>'+
                        //         '<tr>'+
                        //             '<td width="2%">-</td>'+
                        //             '<td width="8%"><strong><div id="genderValue"></div></strong></td>'+
                        //             '<td width="45%"><strong><div id="genderName"></div></strong></td>'+
                        //         '</tr>'+
                        //         '<tr>'+
                        //             '<td>-</td>'+
                        //             '<td><strong><div id="ageValue"></div></strong></td>'+
                        //             '<td><strong><div id="ageName"></div></strong></td>'+
                        //         '</tr>'+
                        //         '<tr>'+
                        //             '<td>-</td>'+
                        //             '<td><strong><div id="secValue"></div></strong></td>'+
                        //             '<td><strong><div id="secName"></div></strong></td>'+
                        //         '</tr>'+
                        //         '<tr>'+
                        //             '<td>-</td>'+
                        //             '<td><strong><div id="educationValue"></div></strong></td>'+
                        //             '<td><strong><div id="educationName"></div></strong></td>'+
                        //         '</tr>'+
                        //         '<tr>'+
                        //             '<td>-</td>'+
                        //             '<td><strong><div id="occupationValue"></div></strong></td>'+
                        //             '<td><strong><div id="occupationName"></div></strong></td>'+
                        //         '</tr>'+
                        //         '<tr>'+
                        //             '<td>-</td>'+
                        //             '<td><strong><div id="hobbyValue"></div></strong></td>'+
                        //             '<td><strong><div id="hobbyName"></div></strong></td>'+
                        //         '</tr>'+
                        //     '</tbody>'+
                        // '</table>'+
                        // '<hr>'+
                        // '<table width="60%">'+
                        //     '<thead>'+
                        //         '<tr>'+
                        //             '<th colspan="3"><h6>PENETRATION</h6></th>'+
                        //         '</tr>'+
                        //     '</thead>'+
                        //     '<tbody>'+
                        //         '<tr>'+
                        //             '<td width="2%">-</td>'+
                        //             '<td width="5%"><strong><div id="mediaValue"></div></strong></td>'+
                        //             '<td width="45%"><strong><div id="mediaName"></div></strong></td>'+
                        //         '</tr>'+
                        //         '<tr>'+
                        //             '<td>-</td>'+
                        //             '<td><strong><div id="kotaValue"></div></strong></td>'+
                        //             '<td><strong><div id="kotaName"></div></strong></td>'+
                        //         '</tr>'+
                        //     '</tbody>'+
                        // '</table>'+
                    '</div>'+
                '</div>';
                /* end summary */

                /* top 10 brand */
                el+='<div class="card card-primary">'+
                    '<div class="card-status bg-green"></div>'+
                    '<div class="card-header">'+
                        '<p class="card-title"><strong>TOP 10 BRAND</strong></p>'+
                        '<div class="card-options">'+
                            '<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>'+
                            '<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>'+
                            '<a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>'+
                        '</div>'+
                    '</div>'+
                    '<div class="card-body">'+
                        '<div class="row">'+
                            '<div class="col-lg-8">'+
                                '<div id="topBrand"></div>'+
                            '</div>'+
                            '<div class="col-lg-4">'+
                                "<div class='card card-info'>"+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title">Brand Position</p>'+
                                    '</div>'+
                                    '<div class="card-body">'+
                                        '<div id="rankTopBrand"></div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';
                /* end top 10 brand */

                /*demography */
                el+='<div class="card card-primary">'+
                    '<div class="card-status bg-green"></div>'+
                    '<div class="card-header">'+
                        '<p class="card-title"><strong>DEMOGRAPHY</strong></p>'+
                        '<div class="card-options">'+
                            '<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>'+
                            '<a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>'+
                        '</div>'+
                    '</div>'+
                    '<div class="card-body">'+
                    '<div class="row">'+
                        '<div class="col-lg-6">'+
                            '<div class="card card-default">'+
                                '<div class="card-status card-status-left bg-blue"></div>'+
                                '<div class="card-header">'+
                                    '<p class="card-title"><strong>GENDER</strong></p>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divGender"></div>'+
                        '</div>'+
                        '<div class="col-lg-6">'+
                            '<div class="card card-default">'+
                                '<div class="card-status card-status-left bg-blue"></div>'+
                                '<div class="card-header">'+
                                    '<p class="card-title"><strong>AGE</strong></p>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divAge"></div>'+
                        '</div>'+
                        '<div class="col-lg-6">'+
                            '<div class="card card-default">'+
                                '<div class="card-status card-status-left bg-blue"></div>'+
                                '<div class="card-header">'+
                                    '<p class="card-title"><strong>SEC</strong></p>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divSec"></div>'+
                        '</div>'+
                        '<div class="col-lg-6">'+
                            '<div class="card card-default">'+
                                '<div class="card-status card-status-left bg-blue"></div>'+
                                '<div class="card-header">'+
                                    '<p class="card-title"><strong>EDUCATION</strong></p>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divEducation"></div>'+
                        '</div>'+
                    '</div>'+

                    '<div class="row">'+
                        '<div class="col-lg-6">'+
                            '<div class="card card-default">'+
                                '<div class="card-status card-status-left bg-blue"></div>'+
                                '<div class="card-header">'+
                                    '<p class="card-title"><strong>OCCUPATION</strong></p>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divOccupation"></div>'+
                        '</div>'+
                        '<div class="col-lg-6">'+
                            '<div class="card card-default">'+
                                '<div class="card-status card-status-left bg-blue"></div>'+
                                '<div class="card-header">'+
                                    '<p class="card-title"><strong>HOBBY</strong></p>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divHobby"></div>'+
                        '</div>'+
                    '</div>'+
                '</div></div>';
                /* end demography */

                /* penetration */
                el+='<div class="card card-primary">'+
                    '<div class="card-status bg-green"></div>'+
                        '<div class="card-header">'+
                            '<p class="card-title"><strong>PENETRATION</strong></p>'+
                            '<div class="card-options">'+
                                '<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>'+
                                '<a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>'+
                            '</div>'+
                        '</div>'+
                    '<div class="card-body">'+

                    '<div class="row">'+
                        '<div class="col-lg-6">'+
                            '<div class="card card-default">'+
                                '<div class="card-status card-status-left bg-blue"></div>'+
                                '<div class="card-header">'+
                                    '<p class="card-title"><strong>MEDIA</strong></p>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divMedia"></div>'+
                        '</div>'+
                        '<div class="col-lg-6">'+
                            '<div class="card card-default">'+
                                '<div class="card-status card-status-left bg-blue"></div>'+
                                '<div class="card-header">'+
                                    '<p class="card-title"><strong>CITIES</strong></p>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divCity"></div>'+
                        '</div>'+
                    '</div>'+

                '</div></div>';
                /*end penetration */

                /* internet */
                el+='<div class="card card-primary">'+
                    '<div class="card-status bg-green"></div>'+
                    '<div class="card-header">'+
                        '<p class="card-title"><strong>INTERNET</strong></p>'+
                        '<div class="card-options">'+
                            '<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>'+
                            '<a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>'+
                        '</div>'+
                    '</div>'+
                    '<div class="card-body">'+
                        '<div class="row">'+
                            '<div class="col-lg-6">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title" style="font-size:16px;"><strong>TIME SPENT OF USING INTERNET</strong></p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divTimeSpent"></div>'+
                            '</div>'+
                            '<div class="col-lg-6">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title" style="font-size:16px;"><strong>FREQUENCY OF USING INTERNET</strong></p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divFrequency"></div>'+
                            '</div>'+
                            '<div class="col-lg-6">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title"><strong>TOOLS OF INTERNET ACCESS</strong></p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divTools"></div>'+
                            '</div>'+
                            '<div class="col-lg-6">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title"><strong>ALL WEBSITE</strong></p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divAllWebsite"></div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="row">'+
                            '<div class="col-lg-4">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title"><strong>FUNCTION USED GENERAL</strong></p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divGeneral"></div>'+
                            '</div>'+
                            '<div class="col-lg-4">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title"><strong>FUNCTION USED E-FINANCE</strong></p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divFinance"></div>'+
                            '</div>'+
                            '<div class="col-lg-4">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title"><strong>FUNCTION USED E-COMMERCE</strong></p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divCommerce"></div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="row">'+
                            
                        '</div>'+
                    '</div>'+
                '</div>';
                /* end internet */

                /* radio */
                el+='<div class="card card-primary">'+
                    '<div class="card-status bg-green"></div>'+
                    '<div class="card-header">'+
                        '<p class="card-title"><strong>RADIO</strong></p>'+
                        '<div class="card-options">'+
                            '<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>'+
                            '<a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>'+
                        '</div>'+
                    '</div>'+
                    '<div class="card-body">'+
                        '<div class="row">'+
                            '<div class="col-lg-4">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title"><strong>FREQUENCY OF LISTENING</strong></p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divFrequencyRadio"></div>'+
                            '</div>'+
                            '<div class="col-lg-4">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title"><strong>PLACE OF LISTENING RADIO</strong></p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divPlace"></div>'+
                            '</div>'+
                            '<div class="col-lg-4">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title"><strong>TOOLS OF LISTENING RADIO</strong></p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divToolsListeningRadio"></div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';
                /* end radio */

                el+='<div class="card card-primary">'+
                    '<div class="card-status bg-green"></div>'+
                    '<div class="card-header">'+
                        '<p class="card-title"><strong>DAY PART</strong></p>'+
                        '<div class="card-options">'+
                            '<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>'+
                            '<a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>'+
                        '</div>'+
                    '</div>'+
                    '<div class="card-body">'+
                        // '<div class="row">'+
                        //     '<div class="col-lg-4">'+
                        //         '<div class="card card-default">'+
                        //             '<div class="card-status card-status-left bg-blue"></div>'+
                        //             '<div class="card-header">'+
                        //                 '<p class="card-title">DAY PART - ALL TIME</p>'+
                        //             '</div>'+
                        //         '</div>'+
                        //         '<div id="divAllTime"></div>'+
                        //     '</div>'+
                        //     '<div class="col-lg-4">'+
                        //         '<div class="card card-default">'+
                        //             '<div class="card-status card-status-left bg-blue"></div>'+
                        //             '<div class="card-header">'+
                        //                 '<p class="card-title">DAY PART - PRIME TIME</p>'+
                        //             '</div>'+
                        //         '</div>'+
                        //         '<div id="divPrimeTime"></div>'+
                        //     '</div>'+
                        //     '<div class="col-lg-4">'+
                        //         '<div class="card card-default">'+
                        //             '<div class="card-status card-status-left bg-blue"></div>'+
                        //             '<div class="card-header">'+
                        //                 '<p class="card-title">DAY PART - NON PRIME TIME</p>'+
                        //             '</div>'+
                        //         '</div>'+
                        //         '<div id="divNonPrimeTime"></div>'+
                        //     '</div>'+
                        // '</div>'+
                        // '<div id="divTableDaypart"></div>'+
                        // '<hr>'+
                        '<div id="divGrafikDaypart"></div>'+
                    '</div>'+
                '</div>';

                /*tabel nya*/
                // el+='<div class="card card-flat">'+
                //     '<div class="card-body">'+
                //         '<div id="showData"></div>'+
                //     '</div>'+
                // '</div>';
                /* end tabel nya*/

                $("#divData").empty().html(el);
                topbrand();
                allData();
                // tabelData();  
            })
        })
    </script>
@stop

@section('css')
    <style>
        #topBrand {
            height: 450px;
            width: 100%;
        }

        #topBrand-license-text{
            display:none;
        } 

        #divGrafikDaypart{
            height: 100%;
            width: 100%;
        }

        #divGender {
            height: 100%;
            width: 100%;
        }

        #divGender-license-text{
            display:none;
        } 

        #divAge {
            height: 100%;
            width: 100%;
        }

        #divAge-license-text{
            display:none;
        }

        #divSec {
            height: 100%;
            width: 100%;
        }

        #divSec-license-text{
            display:none;
        }

        #divEducation {
            height: 100%;
            width: 100%;
        }

        #divEducation-license-text{
            display:none;
        }

        #divOccupation {
            height: 100%;
            width: 100%;
        }

        #divOccupation-license-text{
            display:none;
        }

        #divHobby {
            height: 100%;
            width: 100%;
        }

        #divHobby-license-text{
            display:none;
        }

        #divPsiko {
            height: 100%;
            width: 100%;
        }

        #divPsiko-license-text{
            display:none;
        }

        #divMedia {
            height: 100%;
            width: 100%;
        }

        #divMedia-license-text{
            display:none;
        }

        #divCity {
            height: 100%;
            width: 100%;
        }

        #divCity-license-text{
            display:none;
        }

        #divTimeSpent{
            height: 100%;
            width: 100%;
        }

        #divTimeSpent-license-text{
            display:none;
        }

        #divFrequency{
            height: 100%;
            width: 100%;
        }

        #divFrequency-license-text{
            display:none;
        }

        /* #divGeneral{
            height: 100%;
            width: 100%;
        } */

        #divGeneral-license-text{
            display:none;
        }
        

        /* #divFinance{
            height: 100%;
            width: 100%;
        }

        #divCommerce{
            height: 100%;
            width: 100%;
        } */

        #divFinance-license-text{
            display:none;
        }

        #divCommerce-license-text{
            display:none;
        }

        #divTools{
            height: 100%;
            width: 100%;
        }

        #divTools-license-text{
            display:none;
        }

        #divAllWebsite{
            height: 100%;
            width: 100%;
        }

        #divAllWebsite-license-text{
            display:none;
        }

        #divFrequencyRadio{
            height: 100%;
            width: 100%;
        }

        #divFrequencyRadio-license-text{
            display:none;
        }

        #divPlace{
            height: 100%;
            width: 100%;
        }

        #divPlace-license-text{
            display:none;
        }

        #divToolsListeningRadio{
            height: 100%;
            width: 100%;
        }

        #divToolsListeningRadio-license-text{
            display:none;
        }

        #divAllTime{
            height: 100%;
            width: 100%;
        }

        #divAllTime-license-text{
            display:none;
        }

        #divPrimeTime{
            height: 100%;
            width: 100%;
        }

        #divPrimeTime-license-text{
            display:none;
        }

        #divNonPrimeTime{
            height: 100%;
            width: 100%;
        }

        #divNonPrimeTime-license-text{
            display:none;
        }

        #divGrafikDaypart-license-text{
            display:none;
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
        <div class="card-header">
            <h3 class="card-title"><span class="text-semibold">Brand</span> Chart</h3>
        </div>
        <div class="card-body">
            <form id="formSearch" onsubmit="return false" name="formSearch">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">Brand</label>
                            <input type="text" name="brand" id="brand" class="remote-data-brand">
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="control-label">Category</label>
                            <input type="text" name="category" id="category" class="remote-data-category">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">Quartal</label>
                            <select name="quartal" id="quartal" class="form-control">
                                <option value="42017">Q4 - 2017</option>
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

    <div id="divData"></div>
@stop
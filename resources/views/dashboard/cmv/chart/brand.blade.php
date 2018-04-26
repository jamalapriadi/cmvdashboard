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
                var color=["#5d9edb","#f38542"];
                var br="";
                var allnilai=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D1"){
                        br=b.brand_name;
                        if(a==1){
                            gender.push({
                                values:[parseFloat(b.totals_ver)],
                                ver:b.totals_ver,
                                thousand:b.totals_thousand,
                                backgroundColor:color[a],
                                text:b.subdemo_name
                            })
                        }else{
                            gender.push({
                                values:[parseFloat(b.totals_ver)],
                                backgroundColor:color[a],
                                ver:b.totals_ver,
                                thousand:b.totals_thousand,
                                text:b.subdemo_name
                            })
                        }

                        allnilai.push(b.totals_thousand);
                    }
                })
                
                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<gender.length;l++){
                    if(gender[l].thousand==tertinggi){
                        $("#genderValue").empty().html(parseFloat(gender[l].ver)+" %");
                        $("#genderName").empty().html(gender[l].text);
                    }
                }

                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 16
                    },
                    "legend":{
                        "x":"55%",
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
                        "max-items":2,
                        "overflow":"scroll"
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"5%",
                        "margin-bottom":"5%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%v%",
                            fontColor: "#1A1B26",
                            fontSize: 16
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

            function showSec(data){
                var sec=[];
                var color=["#599cdb","#f67b28","#a9a9a9"];
                var br="";
                var allnilai=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D3"){
                        br=b.brand_name;
                        sec.push({
                            values:[parseFloat(b.totals_ver)],
                            backgroundColor:color[a],
                            ver:b.totals_ver,
                            thousand:b.totals_thousand,
                            text:b.subdemo_name
                        });

                        allnilai.push(b.totals_thousand);
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<sec.length;l++){
                    if(sec[l].thousand==tertinggi){
                        $("#secValue").empty().html(parseFloat(sec[l].ver)+" %");
                        $("#secName").empty().html(sec[l].text);
                    }
                }

                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: br,
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
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"5%",
                        "margin-bottom":"5%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%v%",
                            fontColor: "#1A1B26",
                            fontSize: 16
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
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
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
                var color=["#5b9ddb","#f67c2a","#a0a0a0","#ffc720","#557dcb"];
                var br="";
                var allnilai=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D2"){
                        br=b.brand_name;
                        age.push({
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
                for(l=0;l<age.length;l++){
                    if(age[l].thousand==tertinggi){
                        $("#ageValue").empty().html(parseFloat(age[l].ver)+" %");
                        $("#ageName").empty().html(age[l].text);
                    }
                }

                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: br,
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
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"5%",
                        "margin-bottom":"5%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%v%",
                            fontColor: "#1A1B26",
                            fontSize: 16
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
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
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
                var color=["#5197d7","#ef7421","#aaaaaa"];
                var br="";
                var allnilai=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D4"){
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
                        $("#educationValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#educationName").empty().html(education[l].text);
                    }
                }

                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 16
                    },
                    "legend":{
                        "x":"23%",
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
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"25%",
                        "margin-bottom":"5%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%v%",
                            fontColor: "#1A1B26",
                            fontSize: 16
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
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
                    },
                    series : education
               };
            
                zingchart.render({ 
                    id : 'divEducation', 
                    data : myConfig
                });
                
                
            }

            function showOccupation(data){
                var occupation=[];
                var color=["#3260af","#6aa047","#4b8ac2","#da712d","#949494","#edaf02"];
                var br="";
                var no=0;
                var allnilai=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D5"){
                        no++;
                        br=b.brand_name;
                        if(no==2 || no==4 || no==5){
                            occupation.push({
                                values:[parseFloat(b.totals_ver)],
                                backgroundColor:color[a],
                                ver:b.totals_ver,
                                thousand:b.totals_thousand,
                                text:b.subdemo_name
                            })
                        }else{
                            occupation.push({
                                values:[parseFloat(b.totals_ver)],
                                backgroundColor:color[a],
                                ver:b.totals_ver,
                                thousand:b.totals_thousand,
                                text:b.subdemo_name
                            })
                        }

                        allnilai.push(b.totals_thousand);
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<occupation.length;l++){
                    if(occupation[l].thousand==tertinggi){
                        $("#occupationValue").empty().html(parseFloat(occupation[l].ver)+" %");
                        $("#occupationName").empty().html(occupation[l].text);
                    }
                }

                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 16
                    },
                    "legend":{
                        "x":"35%",
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
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"30%",
                        "margin-bottom":"5%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%v%",
                            fontColor: "#1A1B26",
                            fontSize: 16
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
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
                    },
                    series : occupation
               };
            
                zingchart.render({ 
                    id : 'divOccupation', 
                    data : myConfig
                });
                
                
            }

            function showHobby(data){
                var hobby=[];
                var color=["#4887c0","#da6f2a","#979797","#edb111","#3260af","#649e3d","#99bae3","#f5ac8f","#c2c2c2","#ffd68e"];
                var br="";
                var no=0;
                var allnilai=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D6"){
                        no++;
                        br=b.brand_name;
                        hobby.push({
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
                for(l=0;l<hobby.length;l++){
                    if(hobby[l].thousand==tertinggi){
                        $("#hobbyValue").empty().html(parseFloat(hobby[l].ver)+" %");
                        $("#hobbyName").empty().html(hobby[l].text);
                    }
                }

                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 16
                    },
                    "legend":{
                        "x":"50%",
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
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"30%",
                        "margin-bottom":"5%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%v%",
                            fontColor: "#1A1B26",
                            fontSize: 16
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
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
                    },
                    series : hobby
               };
            
                zingchart.render({ 
                    id : 'divHobby', 
                    data : myConfig
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
                $.each(data,function(a,b){
                    if(b.demo_id=="D7"){
                        no++;
                        br=b.brand_name;
                        labels.push(b.subdemo_name);
                        values.push(parseFloat(b.totals_ver));
                        // occupation.push({
                        //         values:[parseInt(b.totals_thousand)],
                        //         backgroundColor:color[a],
                        //         text:b.subdemo_name
                        //     })
                        alldata.push({
                            label:b.subdemo_name,
                            value:b.totals_ver,
                            thousand:b.totals_thousand
                        });

                        allnilai.push(b.totals_thousand);
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<alldata.length;l++){
                    if(alldata[l].thousand==tertinggi){
                        $("#mediaValue").empty().html(parseFloat(alldata[l].value)+" %");
                        $("#mediaName").empty().html(alldata[l].label);
                    }
                }

                var myConfig = {
                    type: "bar",
                    utc:true,
                    plotarea: {
                      adjustLayout:true
                    },
                    scaleX:{
                      label:{
                        text:br
                      },
                      "labels": labels,
                      minValue:1420070400000,
                      step:"day",
                      transform:{
                        type:"date",
                        all:"%M %d"
                      }
                    },
                    plot:{
                        valueBox: [
                        {
                            placement: "in",
                            text: "%v%",
                            fontColor: "#1A1B26",
                            fontSize: 16
                        }],
                    },
                    series: [
                      {
                        values:values,
                        "background-color": "#599cdb"
                      }
                    ]
                };
                   
                zingchart.render({ 
                    id : 'divMedia', 
                    data : myConfig
                });
            }

            function showCity(data){
                var labels=[];
                var values=[];
                var br="";
                var no=0;
                var alldata=[];
                var allnilai=[];
                $.each(data,function(a,b){
                    if(b.demo_id=="D8"){
                        no++;
                        br=b.brand_name;
                        labels.push(b.subdemo_name);
                        values.push(parseFloat(b.totals_ver));

                        alldata.push({
                            label:b.subdemo_name,
                            value:b.totals_ver,
                            thousand:b.totals_thousand
                        });

                        allnilai.push(b.totals_thousand);
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<alldata.length;l++){
                    if(alldata[l].thousand==tertinggi){
                        $("#kotaValue").empty().html(parseFloat(alldata[l].value)+" %");
                        $("#kotaName").empty().html(alldata[l].label);
                    }
                }

                var myConfig = {
                    type: "bar",
                    utc:true,
                    plotarea: {
                      adjustLayout:true
                    },
                    scaleX:{
                      label:{
                        text:br
                      },
                      "labels":labels,
                      minValue:1420070400000,
                      step:"day",
                      transform:{
                        type:"date",
                        all:"%M %d"
                      }
                    },
                    plot:{
                        valueBox: [
                        {
                            placement: "in",
                            text: "%v%",
                            fontColor: "#1A1B26",
                            fontSize: 16
                        }],
                    },
                    series: [
                      {
                        values:values,
                        "background-color": "#599cdb"
                      }
                    ]
                };
                   
                zingchart.render({ 
                    id : 'divCity', 
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
                        showSec(alldata);
                        showAge(alldata);
                        showEducation(alldata);
                        showOccupation(alldata);
                        showHobby(alldata);
                        showPsiko(alldata);
                        showMedia(alldata);
                        showCity(alldata);
                    },
                    error:function(){

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
                        $("#topBrand").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var primaryColor = "#4184F3";
                        var primaryColorHover = "#3a53c5";
                        var secondaryColor = '#DCDCDC'
                        var scaleTextColor = '#999';
                        
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
                                "values": result.label,
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
                                    "values": result.data,
                                    "alpha": 1,
                                    "background-color": "#008ef6",
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

                /* top 10 brand */
                el+='<div class="panel panel-primary">'+
                    '<div class="panel-heading">'+
                        'TOP 10 BRAND'+
                    '</div>'+
                    '<div class="panel-body">'+
                        '<div class="row">'+
                            '<div class="col-lg-9">'+
                                '<div id="topBrand"></div>'+
                            '</div>'+
                            '<div class="col-lg-3">'+
                                "<div class='panel panel-info'>"+
                                    '<div class="panel-heading">'+
                                        '<h6 class="panel-title">Summary</h6>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';
                /* end top 10 brand */

                /*demography */
                el+='<div class="panel panel-primary">'+
                        '<div class="panel-heading">'+
                            '<h6 class="panel-title">DEMOGRAPHY</h6>'+
                        '</div>'+
                    '<div class="panel-body">'+
                    '<div class="row">'+
                        '<div class="col-lg-4">'+
                            '<div class="panel panel-default">'+
                                '<div class="panel-heading">'+
                                    '<h6 class="panel-title"><strong>GENDER</strong></h6>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divGender"></div>'+
                        '</div>'+
                        '<div class="col-lg-4">'+
                            '<div class="panel panel-default">'+
                                '<div class="panel-heading">'+
                                    '<h6 class="panel-title"><strong>SEC</strong></h6>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divSec"></div>'+
                        '</div>'+
                        '<div class="col-lg-4">'+
                            '<div class="panel panel-default">'+
                                '<div class="panel-heading">'+
                                    '<h6 class="panel-title"><strong>AGE</strong></h6>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divAge"></div>'+
                        '</div>'+
                    '</div>'+

                    '<div class="row">'+
                        '<div class="col-lg-4">'+
                            '<div class="panel panel-default">'+
                                '<div class="panel-heading">'+
                                    '<h6 class="panel-title"><strong>EDUCATION</strong></h6>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divEducation"></div>'+
                        '</div>'+
                        '<div class="col-lg-4">'+
                            '<div class="panel panel-default">'+
                                '<div class="panel-heading">'+
                                    '<h6 class="panel-title"><strong>OCCUPATION</strong></h6>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divOccupation"></div>'+
                        '</div>'+
                        '<div class="col-lg-4">'+
                            '<div class="panel panel-default">'+
                                '<div class="panel-heading">'+
                                    '<h6 class="panel-title"><strong>HOBBY</strong></h6>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divHobby"></div>'+
                        '</div>'+
                    '</div>'+

                    '<div class="panel panel-info">'+
                        '<div class="panel-heading">'+
                            '<h6 class="panel-title">Summary Demography</h6>'+
                        '</div>'+
                        '<div class="panel-body">'+
                            '<h5>Pengguna Brand :  <b>'+namabrand+'</b></h5>'+
                            '<h6>Di dominasi oleh:</h6>'+
                            '<table class="">'+
                                '<tbody>'+
                                    '<tr>'+
                                        '<td width="35%"><b>Gender</b></td>'+
                                        '<td width="45%"><b><div id="genderName"></div></b></td>'+
                                        '<td><div id="genderValue"></div></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<td><b>SEC</b></td>'+
                                        '<td><b><div id="secName"></div></b></td>'+
                                        '<td><div id="secValue"></div></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<td><b>Age</b></td>'+
                                        '<td><b><div id="ageName"></div></b></td>'+
                                        '<td><div id="ageValue"></div></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<td><b>Education</b></td>'+
                                        '<td><b><div id="educationName"></div></b></td>'+
                                        '<td><div id="educationValue"></div></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<td><b>Occupation</b></td>'+
                                        '<td><b><div id="occupationName"></div></b></td>'+
                                        '<td><div id="occupationValue"></div></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<td><b>Hobby</b></td>'+
                                        '<td><b><div id="hobbyName"></div></b></td>'+
                                        '<td><div id="hobbyValue"></div></td>'+
                                    '</tr>'+
                            '</table>'+
                        '</div>'+
                    '</div>'+
                '</div></div>';
                /* end demography */

                /* penetration */
                el+='<div class="panel panel-primary">'+
                        '<div class="panel-heading">'+
                            '<h6 class="panel-title">PENETRATION</h6>'+
                        '</div>'+
                    '<div class="panel-body">'+
                    '<div class="row">'+
                        '<div class="col-lg-6">'+
                            '<div class="panel panel-default">'+
                                '<div class="panel-heading">'+
                                    '<h6 class="panel-title">MEDIA</h6>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divMedia"></div>'+
                        '</div>'+
                        '<div class="col-lg-6">'+
                            '<div class="panel panel-default">'+
                                '<div class="panel-heading">'+
                                    '<h6 class="panel-title">CITIES</h6>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divCity"></div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="panel panel-info">'+
                        '<div class="panel-heading">'+
                            '<h6 class="panel-title">Summary Penetration</h6>'+
                        '</div>'+
                        '<div class="panel-body">'+
                            '<h5>Pengguna Brand :  <b>'+namabrand+'</b></h5>'+
                            '<h6>Di dominasi oleh:</h6>'+
                            '<table class="">'+
                                '<tbody>'+
                                    '<tr>'+
                                        '<td width="35%"><b>Media</b></td>'+
                                        '<td width="45%"><b><div id="mediaName"></div></b></td>'+
                                        '<td><div id="mediaValue"></div></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<td><b>Kota</b></td>'+
                                        '<td><b><div id="kotaName"></div></b></td>'+
                                        '<td><div id="kotaValue"></div></td>'+
                                    '</tr>'+
                            '</table>'+
                        '</div>'+
                    '</div>'+

                '</div></div>';
                /*end penetration */

                /*tabel nya*/
                el+='<div class="panel panel-flat">'+
                    '<div class="panel-body">'+
                        '<div id="showData"></div>'+
                    '</div>'+
                '</div>';
                /* end tabel nya*/

                $("#divData").empty().html(el);
                topbrand();
                allData();
                tabelData();  
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
            <h6 class="panel-title"><span class="text-semibold">Brand</span> Chart</h6>
        </div>
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

    <div id="divData"></div>

    
    <!-- <div class="panel panel-primary">
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
    </div> -->

    
@stop
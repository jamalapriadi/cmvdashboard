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
                var gender=[];
                var color=["#FF7965","#FFCB45"];
                var br="";
                var allnilai=[];
                
                var a=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D1"){
                        a++;
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

                var myTheme = {
                    palette:{
                        line:[
                            ['#FBFCFE', '#00BAF2', '#00BAF2', '#00a7d9'], /* light blue */
                            ['#FBFCFE', '#E80C60', '#E80C60', '#d00a56'], /* light pink */
                            ['#FBFCFE', '#9B26AF', '#9B26AF', '#8b229d'], /* light purple */
                            ['#FBFCFE', '#E2D51A', '#E2D51A', '#E2D51A'], /* med yellow */
                            ['#FBFCFE', '#FB301E', '#FB301E', '#e12b1b'], /* med red */
                            ['#FBFCFE', '#00AE4D', '#00AE4D', '#00AE4D'], /* med green */
                        ]
                    },
                    graph: { 
                        title: {
                        fontFamily: 'Lato',
                        fontSize: 14,
                        padding: 15,
                        fontColor: '#1E5D9E',
                        adjustLayout: true
                        }
                    } 
                };

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
                        "toggle-action":"remove",
                        "highlight-plot":true
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"20%",
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
                   data : myConfig,
                   defaults: myTheme // Theme object
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
                        "toggle-action":"remove",
                        "highlight-plot":true
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"20%",
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
                        "toggle-action":"remove",
                        "highlight-plot":true
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"20%",
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
                        "toggle-action":"remove",
                        "highlight-plot":true
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"20%",
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
                var labels=[];
                var values=[];
                var br="";
                var no=0;
                var alldata=[];
                var allnilai=[];
                $.each(data,function(a,b){
                    if(b.demo_id=="D5"){
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
                        $("#occupationValue").empty().html(parseFloat(alldata[l].value)+" %");
                        $("#occupationName").empty().html(alldata[l].label);
                    }
                }

                var myConfig = {
                    type: "hbar",
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
                    // plot:{
                    //     valueBox: [
                    //     {
                    //         placement: "in",
                    //         text: "%v%",
                    //         fontColor: "#1A1B26",
                    //         fontSize: 16
                    //     }],
                    // },
                    series: [
                      {
                        values:values,
                        "rules":[
                            {
                                "rule":"%i==0",
                                "background-color":"#FA8452"
                            },
                            {
                                "rule":"%i==1",
                                "background-color":"#FCAE48"
                            },
                            {
                                "rule":"%i==2",
                                "background-color":"#FCCC65"
                            },
                            {
                                "rule":"%i==3",
                                "background-color":"#A0BE4A"
                            },
                            {
                                "rule":"%i==4",
                                "background-color":"#6FA6DF"
                            },
                            {
                                "rule":"%i==5",
                                "background-color":"#a200b2"
                            },
                            {
                                "rule":"%i==6",
                                "background-color":"#47f79f"
                            },
                            {
                                "rule":"%i==7",
                                "background-color":"#fc0aec"
                            },
                            {
                                "rule":"%i==8",
                                "background-color":"#ea8c7c"
                            },
                            {
                                "rule":"%i==9",
                                "background-color":"#f9e154"
                            },
                            {
                                "rule":"%i==10",
                                "background-color":"#f4ef58"
                            },
                            {
                                "rule":"%i==11",
                                "background-color":"#e057e0"
                            }
                        ]
                      }
                    ]
                };
                   
                zingchart.render({ 
                    id : 'divOccupation', 
                    data : myConfig
                });
                
            }

            function showHobby(data){
                var labels=[];
                var values=[];
                var br="";
                var no=0;
                var alldata=[];
                var allnilai=[];
                $.each(data,function(a,b){
                    if(b.demo_id=="D6"){
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
                        $("#hobbyValue").empty().html(parseFloat(alldata[l].value)+" %");
                        $("#hobbyName").empty().html(alldata[l].label);
                    }
                }

                var myConfig = {
                    type: "hbar",
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
                    // plot:{
                    //     valueBox: [
                    //     {
                    //         placement: "in",
                    //         text: "%v%",
                    //         fontColor: "#1A1B26",
                    //         fontSize: 16
                    //     }],
                    // },
                    series: [
                      {
                        values:values,
                        "rules":[
                            {
                                "rule":"%i==0",
                                "background-color":"#FA8452"
                            },
                            {
                                "rule":"%i==1",
                                "background-color":"#FCAE48"
                            },
                            {
                                "rule":"%i==2",
                                "background-color":"#FCCC65"
                            },
                            {
                                "rule":"%i==3",
                                "background-color":"#A0BE4A"
                            },
                            {
                                "rule":"%i==4",
                                "background-color":"#6FA6DF"
                            },
                            {
                                "rule":"%i==5",
                                "background-color":"#a200b2"
                            },
                            {
                                "rule":"%i==6",
                                "background-color":"#47f79f"
                            },
                            {
                                "rule":"%i==7",
                                "background-color":"#fc0aec"
                            },
                            {
                                "rule":"%i==8",
                                "background-color":"#ea8c7c"
                            },
                            {
                                "rule":"%i==9",
                                "background-color":"#f9e154"
                            },
                            {
                                "rule":"%i==10",
                                "background-color":"#f4ef58"
                            },
                            {
                                "rule":"%i==11",
                                "background-color":"#e057e0"
                            }
                        ]
                      }
                    ]
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
                    type: "hbar",
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
                    // plot:{
                    //     valueBox: [
                    //     {
                    //         placement: "in",
                    //         text: "%v%",
                    //         fontColor: "#1A1B26",
                    //         fontSize: 16
                    //     }],
                    // },
                    series: [
                      {
                        values:values,
                        "rules":[
                            {
                                "rule":"%i==0",
                                "background-color":"#FA8452"
                            },
                            {
                                "rule":"%i==1",
                                "background-color":"#FCAE48"
                            },
                            {
                                "rule":"%i==2",
                                "background-color":"#FCCC65"
                            },
                            {
                                "rule":"%i==3",
                                "background-color":"#A0BE4A"
                            },
                            {
                                "rule":"%i==4",
                                "background-color":"#6FA6DF"
                            },
                            {
                                "rule":"%i==5",
                                "background-color":"#a200b2"
                            },
                            {
                                "rule":"%i==6",
                                "background-color":"#47f79f"
                            },
                            {
                                "rule":"%i==7",
                                "background-color":"#fc0aec"
                            },
                            {
                                "rule":"%i==8",
                                "background-color":"#ea8c7c"
                            },
                            {
                                "rule":"%i==9",
                                "background-color":"#f9e154"
                            },
                            {
                                "rule":"%i==10",
                                "background-color":"#f4ef58"
                            },
                            {
                                "rule":"%i==11",
                                "background-color":"#e057e0"
                            }
                        ]
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
                    type: "hbar",
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
                    // plot:{
                    //     valueBox: [
                    //     {
                    //         placement: "in",
                    //         text: "%v%",
                    //         fontColor: "#1A1B26",
                    //         fontSize: 16
                    //     }],
                    // },
                    series: [
                      {
                        values:values,
                        "rules":[
                            {
                                "rule":"%i==0",
                                "background-color":"#FA8452"
                            },
                            {
                                "rule":"%i==1",
                                "background-color":"#FCAE48"
                            },
                            {
                                "rule":"%i==2",
                                "background-color":"#FCCC65"
                            },
                            {
                                "rule":"%i==3",
                                "background-color":"#A0BE4A"
                            },
                            {
                                "rule":"%i==4",
                                "background-color":"#6FA6DF"
                            },
                            {
                                "rule":"%i==5",
                                "background-color":"#a200b2"
                            },
                            {
                                "rule":"%i==6",
                                "background-color":"#47f79f"
                            },
                            {
                                "rule":"%i==7",
                                "background-color":"#fc0aec"
                            },
                            {
                                "rule":"%i==8",
                                "background-color":"#ea8c7c"
                            },
                            {
                                "rule":"%i==9",
                                "background-color":"#f9e154"
                            },
                            {
                                "rule":"%i==10",
                                "background-color":"#f4ef58"
                            },
                            {
                                "rule":"%i==11",
                                "background-color":"#e057e0"
                            }
                        ]
                      }
                    ]
                };
                   
                zingchart.render({ 
                    id : 'divCity', 
                    data : myConfig
                });
            }

            function showTimeSpent(data){
                var education=[];
                var color=["#5197d7","#ef7421","#aaaaaa"];
                var br="";
                var allnilai=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D10"){
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
                        $("#timespentValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#timespentName").empty().html(education[l].text);
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
                        "toggle-action":"remove",
                        "highlight-plot":true
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"20%",
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
                    id : 'divTimeSpent', 
                    data : myConfig
                });
            }

            function showFrequency(data){
                var education=[];
                var color=["#5197d7","#ef7421","#aaaaaa"];
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
                                backgroundColor:color[a],
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
                        $("#frequencyValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#frequencyName").empty().html(education[l].text);
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
                        "toggle-action":"remove",
                        "highlight-plot":true
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"20%",
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

                data.sort(function(a, b){return b.totals_ver - a.totals_ver});
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D12"){
                        n++;

                        if(n<=5){
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
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<alldata.length;l++){
                    if(alldata[l].thousand==tertinggi){
                        $("#generalValue").empty().html(parseFloat(alldata[l].value)+" %");
                        $("#generalName").empty().html(alldata[l].label);
                    }
                }

                var myConfig = {
                    type: "hbar",
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
                    // plot:{
                    //     valueBox: [
                    //     {
                    //         placement: "in",
                    //         text: "%v%",
                    //         fontColor: "#1A1B26",
                    //         fontSize: 16
                    //     }],
                    // },
                    series: [
                      {
                        values:values,
                        "rules":[
                            {
                                "rule":"%i==0",
                                "background-color":"#FA8452"
                            },
                            {
                                "rule":"%i==1",
                                "background-color":"#FCAE48"
                            },
                            {
                                "rule":"%i==2",
                                "background-color":"#FCCC65"
                            },
                            {
                                "rule":"%i==3",
                                "background-color":"#A0BE4A"
                            },
                            {
                                "rule":"%i==4",
                                "background-color":"#6FA6DF"
                            }
                        ]
                      }
                    ]
                };
                   
                zingchart.render({ 
                    id : 'divGeneral', 
                    data : myConfig
                });
            }

            function showFinance(data){
                var labels=[];
                var values=[];
                var br="";
                var no=0;
                var alldata=[];
                var allnilai=[];

                data.sort(function(a, b){return b.totals_ver - a.totals_ver});
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D13" && b.subdemo_id!="DD108"){
                        n++;

                        if(n<=5){
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
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<alldata.length;l++){
                    if(alldata[l].thousand==tertinggi){
                        $("#financeValue").empty().html(parseFloat(alldata[l].value)+" %");
                        $("#financeName").empty().html(alldata[l].label);
                    }
                }

                var myConfig = {
                    type: "hbar",
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
                    // plot:{
                    //     valueBox: [
                    //     {
                    //         placement: "in",
                    //         text: "%v%",
                    //         fontColor: "#1A1B26",
                    //         fontSize: 16
                    //     }],
                    // },
                    series: [
                      {
                        values:values,
                        "rules":[
                            {
                                "rule":"%i==0",
                                "background-color":"#FA8452"
                            },
                            {
                                "rule":"%i==1",
                                "background-color":"#FCAE48"
                            },
                            {
                                "rule":"%i==2",
                                "background-color":"#FCCC65"
                            },
                            {
                                "rule":"%i==3",
                                "background-color":"#A0BE4A"
                            },
                            {
                                "rule":"%i==4",
                                "background-color":"#6FA6DF"
                            }
                        ]
                      }
                    ]
                };
                   
                zingchart.render({ 
                    id : 'divFinance', 
                    data : myConfig
                });
            }

            function showCommerce(data){
                var labels=[];
                var values=[];
                var br="";
                var no=0;
                var alldata=[];
                var allnilai=[];

                data.sort(function(a, b){return b.totals_ver - a.totals_ver});
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D14" && b.subdemo_id!="DD122"){
                        n++;

                        if(n<=5){
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
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<alldata.length;l++){
                    if(alldata[l].thousand==tertinggi){
                        $("#commerceValue").empty().html(parseFloat(alldata[l].value)+" %");
                        $("#commerceName").empty().html(alldata[l].label);
                    }
                }

                var myConfig = {
                    type: "hbar",
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
                    // plot:{
                    //     valueBox: [
                    //     {
                    //         placement: "in",
                    //         text: "%v%",
                    //         fontColor: "#1A1B26",
                    //         fontSize: 16
                    //     }],
                    // },
                    series: [
                      {
                        values:values,
                        "rules":[
                            {
                                "rule":"%i==0",
                                "background-color":"#FA8452"
                            },
                            {
                                "rule":"%i==1",
                                "background-color":"#FCAE48"
                            },
                            {
                                "rule":"%i==2",
                                "background-color":"#FCCC65"
                            },
                            {
                                "rule":"%i==3",
                                "background-color":"#A0BE4A"
                            },
                            {
                                "rule":"%i==4",
                                "background-color":"#6FA6DF"
                            }
                        ]
                      }
                    ]
                };
                   
                zingchart.render({ 
                    id : 'divCommerce', 
                    data : myConfig
                });
            }

            function showTools(data){
                var education=[];
                var color=["#5197d7","#ef7421","#aaaaaa"];
                var br="";
                var allnilai=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D15"){
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
                        $("#toolsValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#toolsName").empty().html(education[l].text);
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
                        "toggle-action":"remove",
                        "highlight-plot":true
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"20%",
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
                    id : 'divTools', 
                    data : myConfig
                });
            }

            function showAllWebsite(data){
                var education=[];
                var color=["#5197d7","#ef7421","#aaaaaa"];
                var br="";
                var allnilai=[];

                data.sort(function(a, b){return b.totals_ver - a.totals_ver});
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D16"){
                        n++;

                        if(n<=5){
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
                    }
                })

                var tertinggi=Math.max.apply(Math,allnilai);
                for(l=0;l<education.length;l++){
                    if(education[l].thousand==tertinggi){
                        $("#allWebsiteValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#allWebsiteName").empty().html(education[l].text);
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
                        "toggle-action":"remove",
                        "highlight-plot":true
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"20%",
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
                    id : 'divAllWebsite', 
                    data : myConfig
                });
            }

            function showFrequencyRadio(data){
                var education=[];
                var color=["#5197d7","#ef7421","#aaaaaa"];
                var br="";
                var allnilai=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D17"){
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
                        $("#frequensiRadioValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#frequensiRadioName").empty().html(education[l].text);
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
                        "toggle-action":"remove",
                        "highlight-plot":true
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"20%",
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
                    id : 'divFrequencyRadio', 
                    data : myConfig
                });
            }

            function showPlace(data){
                var education=[];
                var color=["#5197d7","#ef7421","#aaaaaa"];
                var br="";
                var allnilai=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D18"){
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
                        $("#placeValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#placeName").empty().html(education[l].text);
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
                        "toggle-action":"remove",
                        "highlight-plot":true
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"20%",
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
                    id : 'divPlace', 
                    data : myConfig
                });
            }

            function showToolsListeningRadio(data){
                var education=[];
                var color=["#5197d7","#ef7421","#aaaaaa"];
                var br="";
                var allnilai=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D19"){
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
                        $("#toolsListeningValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#toolsListeningName").empty().html(education[l].text);
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
                        "toggle-action":"remove",
                        "highlight-plot":true
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"20%",
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
                        "toggle-action":"remove",
                        "highlight-plot":true
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"20%",
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
                        "toggle-action":"remove",
                        "highlight-plot":true
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"20%",
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
                        "toggle-action":"remove",
                        "highlight-plot":true
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"20%",
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
                        showAllTime(alldata);
                        showPrimeTime(alldata);
                        showNonPrimeTime(alldata);
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
                        $("#rankTopBrand").empty();
                    },
                    success:function(result){
                        var primaryColor = "#4184F3";
                        var primaryColorHover = "#3a53c5";
                        var secondaryColor = '#DCDCDC'
                        var scaleTextColor = '#999';

                        var labels=[];
                        var values=[];

                        result.label.reverse();

                        $.each(result.label,function(a,b){
                            labels.push(b.brand);
                            values.push(b.total);
                        })
                        
                        var el="";
                        el+="<table class='table table-striped'>"+
                            '<thead>'+
                                '<tr>'+
                                    '<th>Rank</th>'+
                                    '<th> : </th>'+
                                    '<th>'+result.rank.number+'</th>'+
                                '</tr>'+
                                '<tr>'+
                                    '<th>Category</th>'+
                                    '<th> : </th>'+
                                    '<th>'+result.rank.category+'</th>'+
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
                                    "font-size": "11px",
                                    "font-color": "#7E7E7E"
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
                el+='<div class="panel panel-primary">'+
                    '<div class="panel-heading">'+
                        'SUMMARY'+
                    '</div>'+
                    '<div class="panel-body">'+
                        '<h5>Pengguna Brand :  <b>'+namabrand+'</b></h5>'+
                        '<p>Di dominasi oleh:</p>'+
                        '<table width="60%">'+
                            '<tbody>'+
                                '<tr>'+
                                    '<td width="35%"><b>GENDER</b></td>'+
                                    '<td width="45%"><b><div id="genderName"></div></b></td>'+
                                    '<td><div id="genderValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>SEC</b></td>'+
                                    '<td><b><div id="secName"></div></b></td>'+
                                    '<td><div id="secValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>AGE</b></td>'+
                                    '<td><b><div id="ageName"></div></b></td>'+
                                    '<td><div id="ageValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>EDUCATION</b></td>'+
                                    '<td><b><div id="educationName"></div></b></td>'+
                                    '<td><div id="educationValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>OCCUPATION</b></td>'+
                                    '<td><b><div id="occupationName"></div></b></td>'+
                                    '<td><div id="occupationValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>HOBBY</b></td>'+
                                    '<td><b><div id="hobbyName"></div></b></td>'+
                                    '<td><div id="hobbyValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td width="35%"><b>MEDIA</b></td>'+
                                    '<td width="45%"><b><div id="mediaName"></div></b></td>'+
                                    '<td><div id="mediaValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>KOTA</b></td>'+
                                    '<td><b><div id="kotaName"></div></b></td>'+
                                    '<td><div id="kotaValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>TIME SPENT OF USING INTERNET</b></td>'+
                                    '<td><b><div id="timespentName"></div></b></td>'+
                                    '<td><div id="timespentValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>FREQUENCY OF USING INTERNET</b></td>'+
                                    '<td><b><div id="frequencyName"></div></b></td>'+
                                    '<td><div id="frequencyValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>GENERAL</b></td>'+
                                    '<td><b><div id="generalName"></div></b></td>'+
                                    '<td><div id="generalValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>E-FINANCE</b></td>'+
                                    '<td><b><div id="financeName"></div></b></td>'+
                                    '<td><div id="financeValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>E-COMMERCE</b></td>'+
                                    '<td><b><div id="commerceName"></div></b></td>'+
                                    '<td><div id="commerceValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>TOOLS OF INTERNET ACCESS</b></td>'+
                                    '<td><b><div id="toolsName"></div></b></td>'+
                                    '<td><div id="toolsValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>ALL WEBSITE</b></td>'+
                                    '<td><b><div id="allWebsiteName"></div></b></td>'+
                                    '<td><div id="allWebsiteValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>FREQUENCY OF LISTENING</b></td>'+
                                    '<td><b><div id="frequensiRadioName"></div></b></td>'+
                                    '<td><div id="frequensiRadioValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>PLACE OF LISTENING RADIO</b></td>'+
                                    '<td><b><div id="placeName"></div></b></td>'+
                                    '<td><div id="placeValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>TOOLS OF LISTENING RADIO</b></td>'+
                                    '<td><b><div id="toolsListeningName"></div></b></td>'+
                                    '<td><div id="toolsListeningValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>DAY PART - ALL TIME</b></td>'+
                                    '<td><b><div id="allTimeName"></div></b></td>'+
                                    '<td><div id="allTimeValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>DAY PART - PRIME TIME</b></td>'+
                                    '<td><b><div id="primeTimeName"></div></b></td>'+
                                    '<td><div id="primeTimeValue"></div></td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td><b>DAY PART - NON PRIME TIME</b></td>'+
                                    '<td><b><div id="nonprimetimeName"></div></b></td>'+
                                    '<td><div id="nonprimetimeValue"></div></td>'+
                                '</tr>'+
                        '</table>'+
                    '</div>'+
                '</div>';
                /* end summary */

                /* top 10 brand */
                el+='<div class="panel panel-primary">'+
                    '<div class="panel-heading">'+
                        'TOP 10 BRAND'+
                    '</div>'+
                    '<div class="panel-body">'+
                        '<div class="row">'+
                            '<div class="col-lg-8">'+
                                '<div id="topBrand"></div>'+
                            '</div>'+
                            '<div class="col-lg-4">'+
                                "<div class='panel panel-info'>"+
                                    '<div class="panel-heading">'+
                                        '<p class="panel-title">Brand Position</p>'+
                                    '</div>'+
                                    '<div class="panel-body">'+
                                        '<div id="rankTopBrand"></div>'+
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
                            '<p class="panel-title">DEMOGRAPHY</p>'+
                        '</div>'+
                    '<div class="panel-body">'+
                    '<div class="row">'+
                        '<div class="col-lg-3">'+
                            '<div class="panel panel-default">'+
                                '<div class="panel-heading">'+
                                    '<p class="panel-title"><strong>GENDER</strong></p>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divGender"></div>'+
                        '</div>'+
                        '<div class="col-lg-3">'+
                            '<div class="panel panel-default">'+
                                '<div class="panel-heading">'+
                                    '<p class="panel-title"><strong>AGE</strong></p>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divAge"></div>'+
                        '</div>'+
                        '<div class="col-lg-3">'+
                            '<div class="panel panel-default">'+
                                '<div class="panel-heading">'+
                                    '<p class="panel-title"><strong>SEC</strong></p>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divSec"></div>'+
                        '</div>'+
                        '<div class="col-lg-3">'+
                            '<div class="panel panel-default">'+
                                '<div class="panel-heading">'+
                                    '<p class="panel-title"><strong>EDUCATION</strong></p>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divEducation"></div>'+
                        '</div>'+
                    '</div>'+

                    '<div class="row">'+
                        '<div class="col-lg-6">'+
                            '<div class="panel panel-default">'+
                                '<div class="panel-heading">'+
                                    '<p class="panel-title"><strong>OCCUPATION</strong></p>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divOccupation"></div>'+
                        '</div>'+
                        '<div class="col-lg-6">'+
                            '<div class="panel panel-default">'+
                                '<div class="panel-heading">'+
                                    '<p class="panel-title"><strong>HOBBY</strong></p>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divHobby"></div>'+
                        '</div>'+
                    '</div>'+
                '</div></div>';
                /* end demography */

                /* penetration */
                el+='<div class="panel panel-primary">'+
                        '<div class="panel-heading">'+
                            '<p class="panel-title">PENETRATION</p>'+
                        '</div>'+
                    '<div class="panel-body">'+

                    '<div class="row">'+
                        '<div class="col-lg-6">'+
                            '<div class="panel panel-default">'+
                                '<div class="panel-heading">'+
                                    '<p class="panel-title">MEDIA</p>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divMedia"></div>'+
                        '</div>'+
                        '<div class="col-lg-6">'+
                            '<div class="panel panel-default">'+
                                '<div class="panel-heading">'+
                                    '<p class="panel-title">CITIES</p>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divCity"></div>'+
                        '</div>'+
                    '</div>'+

                '</div></div>';
                /*end penetration */

                /* internet */
                el+='<div class="panel panel-primary">'+
                    '<div class="panel-heading">'+
                        '<p class="panel-title">INTERNET</p>'+
                    '</div>'+
                    '<div class="panel-body">'+
                        '<div class="row">'+
                            '<div class="col-lg-3">'+
                                '<div class="panel panel-default">'+
                                    '<div class="panel-heading">'+
                                        '<p class="panel-title">TIME SPENT OF USING INTERNET</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divTimeSpent"></div>'+
                            '</div>'+
                            '<div class="col-lg-3">'+
                                '<div class="panel panel-default">'+
                                    '<div class="panel-heading">'+
                                        '<p class="panel-title">FREQUENCY OF USING INTERNET</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divFrequency"></div>'+
                            '</div>'+
                            '<div class="col-lg-6">'+
                                '<div class="panel panel-default">'+
                                    '<div class="panel-heading">'+
                                        '<p class="panel-title">GENERAL</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divGeneral"></div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="row">'+
                            '<div class="col-lg-6">'+
                                '<div class="panel panel-default">'+
                                    '<div class="panel-heading">'+
                                        '<p class="panel-title">E-FINANCE</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divFinance"></div>'+
                            '</div>'+
                            '<div class="col-lg-6">'+
                                '<div class="panel panel-default">'+
                                    '<div class="panel-heading">'+
                                        '<p class="panel-title">E-COMMERCE</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divCommerce"></div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="row">'+
                            '<div class="col-lg-3">'+
                                '<div class="panel panel-default">'+
                                    '<div class="panel-heading">'+
                                        '<p class="panel-title">TOOLS OF INTERNET ACCESS</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divTools"></div>'+
                            '</div>'+
                            '<div class="col-lg-3">'+
                                '<div class="panel panel-default">'+
                                    '<div class="panel-heading">'+
                                        '<p class="panel-title">ALL WEBSITE</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divAllWebsite"></div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';
                /* end internet */

                /* radio */
                el+='<div class="panel panel-primary">'+
                    '<div class="panel-heading">'+
                        '<p class="panel-title">RADIO</p>'+
                    '</div>'+
                    '<div class="panel-body">'+
                        '<div class="row">'+
                            '<div class="col-lg-4">'+
                                '<div class="panel panel-default">'+
                                    '<div class="panel-heading">'+
                                        '<p class="panel-title">FREQUENCY OF LISTENING</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divFrequencyRadio"></div>'+
                            '</div>'+
                            '<div class="col-lg-4">'+
                                '<div class="panel panel-default">'+
                                    '<div class="panel-heading">'+
                                        '<p class="panel-title">PLACE OF LISTENING RADIO</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divPlace"></div>'+
                            '</div>'+
                            '<div class="col-lg-4">'+
                                '<div class="panel panel-default">'+
                                    '<div class="panel-heading">'+
                                        '<p class="panel-title">TOOLS OF LISTENING RADIO</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divToolsListeningRadio"></div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';
                /* end radio */

                el+='<div class="panel panel-primary">'+
                    '<div class="panel-heading">'+
                        '<p class="panel-title">TV</p>'+
                    '</div>'+
                    '<div class="panel-body">'+
                        '<div class="row">'+
                            '<div class="col-lg-4">'+
                                '<div class="panel panel-default">'+
                                    '<div class="panel-heading">'+
                                        '<p class="panel-title">DAY PART - ALL TIME</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divAllTime"></div>'+
                            '</div>'+
                            '<div class="col-lg-4">'+
                                '<div class="panel panel-default">'+
                                    '<div class="panel-heading">'+
                                        '<p class="panel-title">DAY PART - PRIME TIME</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divPrimeTime"></div>'+
                            '</div>'+
                            '<div class="col-lg-4">'+
                                '<div class="panel panel-default">'+
                                    '<div class="panel-heading">'+
                                        '<p class="panel-title">DAY PART - NON PRIME TIME</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divNonPrimeTime"></div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';

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

        #divTimeSpent{
            height: 100%;
            width: 100%;
        }

        #divFrequency{
            height: 100%;
            width: 100%;
        }

        #divGeneral{
            height: 100%;
            width: 100%;
        }

        #divFinance{
            height: 100%;
            width: 100%;
        }

        #divCommerce{
            height: 100%;
            width: 100%;
        }

        #divTools{
            height: 100%;
            width: 100%;
        }

        #divAllWebsite{
            height: 100%;
            width: 100%;
        }

        #divFrequencyRadio{
            height: 100%;
            width: 100%;
        }

        #divPlace{
            height: 100%;
            width: 100%;
        }

        #divToolsListeningRadio{
            height: 100%;
            width: 100%;
        }

        #divAllTime{
            height: 100%;
            width: 100%;
        }

        #divPrimeTime{
            height: 100%;
            width: 100%;
        }

        #divNonPrimeTime{
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
            <p class="panel-title"><span class="text-semibold">Brand</span> Chart</p>
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

    
    <!-- <div class="panel panel-primary">
        <div class="panel-heading">
            <p class="panel-title">PSYCHOGRAPHICS</p>
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
                                <p class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group2">TRADITIONALIST</a>
                                </p>
                            </div>
                            <div id="accordion-control-group2" class="panel-collapse collapse">
                                <div class="panel-body">
                                        “Hold traditional value, dreaming of wealth, Non Brand Minded, Less Health Conscious, Non Ad Believer” 
                                </div>
                            </div>
                        </div>
        
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <p class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group3">SETTLED</a>
                                </p>
                            </div>
                            <div id="accordion-control-group3" class="panel-collapse collapse">
                                <div class="panel-body">
                                        “Nested. Practical (Prefer buying new than fixing), TV is entertainment, Enjoying Ad, Enjoying Shopping” 
                                </div>
                            </div>
                        </div>
                        
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <p class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group4">YOUNG LOYALIST</a>
                                </p>
                            </div>
                            <div id="accordion-control-group4" class="panel-collapse collapse">
                                <div class="panel-body">
                                        “Value friendship, Self sacrificing for greater result, Less environment concern” 
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <p class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group5">WESTERN MINDED</a>
                                </p>
                            </div>
                            <div id="accordion-control-group5" class="panel-collapse collapse">
                                <div class="panel-body">
                                        “Brand Minded, Career oriented, Enjoying life, Lonely and Challenge” 
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <p class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group6">SKEPTICAL</a>
                                </p>
                            </div>
                            <div id="accordion-control-group6" class="panel-collapse collapse">
                                <div class="panel-body">
                                    “Worried, Critical on life, Cynical on money, Information seekers (on labels), Non career Minded” 
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <p class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group7">RESTLESS</a>
                                </p>
                            </div>
                            <div id="accordion-control-group7" class="panel-collapse collapse">
                                <div class="panel-body">
                                    “Restless (tend to dislike a regular pattern of life), No confidence” 
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <p class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group8">APATHETIC</a>
                                </p>
                            </div>
                            <div id="accordion-control-group8" class="panel-collapse collapse">
                                <div class="panel-body">
                                    “Non Opinioned (goes with the flow), Career is important, Believe in gender equal opportunities” 
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <p class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group9">MATERIAL COMFORT</a>
                                </p>
                            </div>
                            <div id="accordion-control-group9" class="panel-collapse collapse">
                                <div class="panel-body">
                                    “Makin good money and financially secured, Not price conscious, Appearance concerns” 
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <p class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group10">OPTIMIST</a>
                                </p>
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
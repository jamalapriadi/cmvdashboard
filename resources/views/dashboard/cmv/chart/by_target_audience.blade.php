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
                    url: "{{URL::to('cmv/data/list-ta')}}",
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
                var brand=$("#ta").val();
                var quartal=$("#quartal").val();

                $.ajax({
                    url:"{{URL::to('cmv/data/filter-demography-by-ta')}}",
                    type:"GET",
                    data:"ta="+brand+"&quartal="+quartal,
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
                        $("#genderValue").empty().html(parseFloat(age[l].ver)+" %");
                        $("#genderName").empty().html(age[l].text);
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
                        fontColor: "#1A1B26",
                        fontSize: 16
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
                            fontSize: 12
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
                        $("#secValue").empty().html(parseFloat(sec[l].ver)+" %");
                        $("#secName").empty().html(sec[l].text);
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
                        fontColor: "#1A1B26",
                        fontSize: 16
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
                            fontSize: 12
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
                        $("#ageValue").empty().html(parseFloat(age[l].ver)+" %");
                        $("#ageName").empty().html(age[l].text);
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
                        fontColor: "#1A1B26",
                        fontSize: 16
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
                            fontSize: 12
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
                        $("#educationValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#educationName").empty().html(education[l].text);
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
                        fontColor: "#1A1B26",
                        fontSize: 16
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
                            fontSize: 12
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
                        $("#timespentValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#timespentName").empty().html(education[l].text);
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
                        fontColor: "#1A1B26",
                        fontSize: 16
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
                            fontSize: 12
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
                        $("#frequencyValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#frequencyName").empty().html(education[l].text);
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
                        fontColor: "#1A1B26",
                        fontSize: 16
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
                            fontSize: 12
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
                        $("#toolsValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#toolsName").empty().html(education[l].text);
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
                        fontColor: "#1A1B26",
                        fontSize: 16
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
                            fontSize: 12
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
                var education=[];
                var color=["#50ADF5","#FF7965","#a0a0a0","#ffc720","#557dcb"];
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
                        $("#allWebsiteValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#allWebsiteName").empty().html(education[l].text);
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
                        fontColor: "#1A1B26",
                        fontSize: 16
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
                            fontSize: 12
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
                    id : 'divAllWebsite', 
                    data : myConfig
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
                        $("#frequensiRadioValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#frequensiRadioName").empty().html(education[l].text);
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
                        fontColor: "#1A1B26",
                        fontSize: 16
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
                        $("#placeValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#placeName").empty().html(education[l].text);
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
                        fontColor: "#1A1B26",
                        fontSize: 16
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
                        $("#toolsListeningValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#toolsListeningName").empty().html(education[l].text);
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
                        fontColor: "#1A1B26",
                        fontSize: 16
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
                var color=["#50ADF5","#FF7965","#a0a0a0","#ffc720","#557dcb"];
                var br="";
                var allnilai=[];
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D20"){
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
                        $("#allTimeValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#allTimeName").empty().html(education[l].text);
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
                        fontColor: "#1A1B26",
                        fontSize: 16
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
                    id : 'divAllTime', 
                    data : myConfig
                });
            }

            function showPrimeTime(data){
                var education=[];
                var color=["#50ADF5","#FF7965","#a0a0a0","#ffc720","#557dcb"];
                var br="";
                var allnilai=[];
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D21"){
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
                        $("#primeTimeValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#primeTimeName").empty().html(education[l].text);
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
                        fontColor: "#1A1B26",
                        fontSize: 16
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
                    id : 'divPrimeTime', 
                    data : myConfig
                });
            }

            function showNonPrimeTime(data){
                var education=[];
                var color=["#50ADF5","#FF7965","#a0a0a0","#ffc720","#557dcb"];
                var br="";
                var allnilai=[];
                
                var n=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D22"){
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
                        $("#nonprimetimeValue").empty().html(parseFloat(education[l].ver)+" %");
                        $("#nonprimetimeName").empty().html(education[l].text);
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
                        fontColor: "#1A1B26",
                        fontSize: 16
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
                    id : 'divNonPrimeTime', 
                    data : myConfig
                });
            }

            function allData(){
                var brand=$("#ta").val();
                var quartal=$("#quartal").val();

                $.ajax({
                    url:"{{URL::to('cmv/data/chart/all-data-ta')}}",
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
                                    "values": values,
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
                var namabrand=$("#ta").select2('data').text;

                /*demography */
                el+='<div class="card card-primary">'+
                        '<div class="card-status bg-green"></div>'+
                        '<div class="card-header">'+
                            '<p class="card-title">DEMOGRAPHY</p>'+
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
                            '<p class="card-title">PENETRATION</p>'+
                        '</div>'+
                    '<div class="card-body">'+

                    '<div class="row">'+
                        '<div class="col-lg-6">'+
                            '<div class="card card-default">'+
                                '<div class="card-status card-status-left bg-blue"></div>'+
                                '<div class="card-header">'+
                                    '<p class="card-title">MEDIA</p>'+
                                '</div>'+
                            '</div>'+
                            '<div id="divMedia"></div>'+
                        '</div>'+
                        '<div class="col-lg-6">'+
                            '<div class="card card-default">'+
                                '<div class="card-status card-status-left bg-blue"></div>'+
                                '<div class="card-header">'+
                                    '<p class="card-title">CITIES</p>'+
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
                        '<p class="card-title">INTERNET</p>'+
                    '</div>'+
                    '<div class="card-body">'+
                        '<div class="row">'+
                            '<div class="col-lg-6">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title">TIME SPENT OF USING INTERNET</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divTimeSpent"></div>'+
                            '</div>'+
                            '<div class="col-lg-6">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title">FREQUENCY OF USING INTERNET</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divFrequency"></div>'+
                            '</div>'+
                            '<div class="col-lg-6">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title">TOOLS OF INTERNET ACCESS</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divTools"></div>'+
                            '</div>'+
                            '<div class="col-lg-6">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title">ALL WEBSITE</p>'+
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
                                        '<p class="card-title">GENERAL</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divGeneral"></div>'+
                            '</div>'+

                            '<div class="col-lg-4">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title">E-FINANCE</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divFinance"></div>'+
                            '</div>'+

                            '<div class="col-lg-4">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title">E-COMMERCE</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divCommerce"></div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';
                /* end internet */

                /* radio */
                el+='<div class="card card-primary">'+
                    '<div class="card-status bg-green"></div>'+
                    '<div class="card-header">'+
                        '<p class="card-title">RADIO</p>'+
                    '</div>'+
                    '<div class="card-body">'+
                        '<div class="row">'+
                            '<div class="col-lg-4">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title">FREQUENCY OF LISTENING</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divFrequencyRadio"></div>'+
                            '</div>'+
                            '<div class="col-lg-4">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title">PLACE OF LISTENING RADIO</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divPlace"></div>'+
                            '</div>'+
                            '<div class="col-lg-4">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title">TOOLS OF LISTENING RADIO</p>'+
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
                        '<p class="card-title">TV</p>'+
                    '</div>'+
                    '<div class="card-body">'+
                        '<div class="row">'+
                            '<div class="col-lg-4">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title">DAY PART - ALL TIME</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divAllTime"></div>'+
                            '</div>'+
                            '<div class="col-lg-4">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title">DAY PART - PRIME TIME</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divPrimeTime"></div>'+
                            '</div>'+
                            '<div class="col-lg-4">'+
                                '<div class="card card-default">'+
                                    '<div class="card-status card-status-left bg-blue"></div>'+
                                    '<div class="card-header">'+
                                        '<p class="card-title">DAY PART - NON PRIME TIME</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="divNonPrimeTime"></div>'+
                            '</div>'+
                        '</div>'+
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
    <div class="card card-default">
        <div class="card-header">
            <p class="card-title"><span class="text-semibold">Chart</span> By Target Audience</p>
        </div>
        <div class="card-body">
            <form id="formSearch" onsubmit="return false" name="formSearch">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">Target Audience</label>
                            <input type="text" name="ta" id="ta" class="remote-data-brand">
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
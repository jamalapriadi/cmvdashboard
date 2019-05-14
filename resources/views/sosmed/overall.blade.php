@extends('layouts.coreui.main')

@section('content')
    <div class="card card-default">
        <div class="card-header">OVERALL</div>
        <div class="card-body">
            <form id="formofficialAccountAllTv" onsubmit="return false">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">Periode</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                                </div>
                                <input type="text" name="tanggal" id="tanggal2" data-value="{{date('Y/m/d')}}" class="form-control daterange-single">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="pilih" id="pilih"> <small>check to compare data with another date?</small>
                                </label>
                            </div>  
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group row">
                            <label class="control-label">Unit Type</label>
                            <div class="input-group mb3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-archive"></i></span>
                                </div>
                                <select name="typeunit" id="typeunit1" class="form-control" required>
                                    @foreach($typeunit as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="anotherDate"></div>

                    <div class="col-lg-3">
                        <button class='btn btn-primary' style="margin-top:25px;">
                            <i class="icon-filter4"></i> &nbsp;
                            Filter 
                        </button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <div id="divofficialAccountAllTv"></div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/floatthead/2.1.1/jquery.floatThead.js"></script>
    <script>
        $(function(){
            var kode="";

            var sekarang = new Date();
            var kemarin = new Date(sekarang);
            kemarin.setDate(sekarang.getDate() - 1);    

            $('.pickadate-accessibility').pickadate({
                labelMonthNext: 'Go to the next month',
                labelMonthPrev: 'Go to the previous month',
                labelMonthSelect: 'Pick a month from the dropdown',
                labelYearSelect: 'Pick a year from the dropdown',
                selectMonths: true,
                selectYears: true
            });

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

            $(document).on("click","#pilih",function(){
                if($(this).is(':checked')){
                    var el="";
                    el+='<div class="form-group">'+
                        '<label class="control-label">Compare With</label>'+
                        '<div class="input-group mb-3">'+
                            '<div class="input-group-prepend">'+
                                '<span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>'+
                            '</div>'+
                            '<input class="form-control daterange-single-kemarin" data-value="'+kemarin+'" name="kemarin" id="kemarin">'+
                        '</div>'+
                    '</div>';

                    $("#anotherDate").empty().html(el);

                    $('.daterange-single-kemarin').pickadate({
                        format: 'yyyy/mm/dd',
                        formatSubmit: 'yyyy/mm/dd',
                        max:true,
                    });
                }else{
                    $("#anotherDate").empty();
                }
            })

            $(document).on("click","#pilih2",function(){
                if($(this).is(':checked')){
                    var el="";
                    el+='<div class="form-group">'+
                        '<label class="control-label">Compare With</label>'+
                        '<div class="input-group mb-3">'+
                            '<div class="input-group-prepend">'+
                                '<span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>'+
                            '</div>'+
                            '<input class="form-control daterange-single-kemarin" data-value="'+kemarin+'" name="kemarin" id="kemarin2">'+
                        '</div>'+
                    '</div>';

                    $("#anotherDate2").empty().html(el);

                    $('.daterange-single-kemarin').pickadate({
                        format: 'yyyy/mm/dd',
                        formatSubmit: 'yyyy/mm/dd',
                        max:true,
                    });
                }else{
                    $("#anotherDate2").empty();
                }
            })

            function officialAccountAllTv(){
                var el="";
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/overall-tv')}}",
                    type:"GET",
                    beforeSend:function(){
                        $("#divofficialAccountAllTv").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>Please Wait...</div>");
                    },
                    success:function(result){
                        $("#divofficialAccountAllTv").empty().append(result);
                        // $(".sticky-header").floatThead({scrollingTop:50});
                    },
                    error:function(){

                    }
                })
            }

            $(document).on("submit","#formofficialAccountAllTv",function(e){
                var group=$("#group2 option:selected").val();
                var tanggal=$("#tanggal2").val();
                var typeunit=$("#typeunit1").val();
                
                if($("#pilih").is(':checked')){
                    var pilih=$("#pilih").val();
                    var kemarin=$("#kemarin").val();
                }else{
                    var pilih="";
                    var kemarin="";
                }

                var el="";
                if($("#formofficialAccountAllTv")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url:"{{URL::to('sosmed/data/report/overall-tv')}}",
                        type:"GET",
                        data:"group="+group+"&tanggal="+tanggal+"&pilih="+pilih+"&kemarin="+kemarin+"&typeunit="+typeunit,
                        beforeSend:function(){
                            $("#divofficialAccountAllTv").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>Please Wait...</div>");
                        },
                        success:function(result){
                            $("#divofficialAccountAllTv").empty().append(result);
                            // $(".sticky-header").floatThead({scrollingTop:50});
                        },
                        error:function(){

                        }
                    })
                }else console.log("invalid form");
            })

            officialAccountAllTv();
        });
    </script>
@stop
@extends('layouts.coreui.main')

@section('title')
    Dashboard
@endsection

@section('extra-style')
    <style>
        table.floatThead-table {
            border-top: none;
            border-bottom: none;
            background-color: #fff;
        }
        .daterangepicker{z-index:1151 !important;}
        #ui-datepicker-div{z-index:1151 !important;}
    </style>
@endsection

@section('content')
    <div class="card card-default">
        <div class="card-header">TARGET VS ACHIEVEMENT</div>
        <div class="card-body">
            <form id="formTargetAchievement" onsubmit="return false">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">Group</label>
                            <select name="form-control" name="group" id="group" class="form-control">
                                @foreach($group as $row)
                                    <option value="{{$row->id}}">{{$row->group_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">Periode</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                                </div>
                                <input type="text" id="tanggal" data-value="{{date('Y/m/d')}}" name="tanggal" class="form-control daterange-single">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <button class='btn btn-primary' style="margin-top:25px;">
                            <i class="icon-filter4"></i> &nbsp;
                            Filter 
                        </button>
                    </div>
                </div>
            </form>

            <div style="margin-top:10px;"></div>

            <div class="table-responsive">
                <div id="divTargetVsAchievement"></div>
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

            function targetVsAchievement(){
                var group=$("#group option:selected").val();
                var tanggal=$("#tanggal").val();

                var el="";
                $.ajax({
                    url:"{{URL::to('sosmed/data/report/target-vs-achievement')}}",
                    type:"GET",
                    data:"group="+group+"&tanggal="+tanggal,
                    beforeSend:function(){
                        $("#divTargetVsAchievement").empty().html("<div class='alert alert-info'><i class='fa fa-spinner fa-2x fa-spin'></i>Please Wait...</div>");
                    },
                    success:function(result){
                        $("#divTargetVsAchievement").empty().append(result);

                        officialAccountAllTv();
                        sosmedOfficialAndProgram();
                        officialAndProgram();
                    },
                    error:function(){

                    }
                })
            }

            $(document).on("submit","#formTargetAchievement",function(e){
                targetVsAchievement();
            });

            targetVsAchievement();
        });
    </script>
@stop
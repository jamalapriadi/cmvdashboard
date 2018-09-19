@extends('layouts.coreui.main')

@section('content')
    <div class="card card-primary">
        <div class="card-header">SOCMED LIVE</div>
        <div class="card-body">
            <form action="#">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="" class="control-label">Unit</label>
                            <select name="unit" id="unit" class="form-control">
                                @foreach($user->unit as $row)
                                    <option value="{{$row->id}}">{{$row->unit_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="" class="control-label">Account Type</label>
                            <select name="accounttype" id="accounttype" class="form-control">
                                <option value="official">Official</option>
                                <option value="program">Program</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div id="accountprogram"></div>
                    </div>
                </div>
            </form>

            <div id="divLiveSocmed"></div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function(){
            function liveSocmed(){
                var unit=$("#unit").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/live-socmed-by-id')}}/"+unit,
                    type:"GET",
                    data:"type=corporate",
                    beforeSend:function(){
                        $("#divLiveSocmed").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        $("#divLiveSocmed").empty().html(result);
                    },
                    errors:function(){

                    }
                })
            }

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

                showgroup();
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
                        $("#accountprogram").empty().html("<div class='alert alert-info'>Please Wait...</div>");
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
                        $("#divLiveSocmed").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        $("#divLiveSocmed").empty().html(result);
                    },
                    errors:function(){

                    }
                })
            })

            liveSocmed();
        })
    </script>
@stop
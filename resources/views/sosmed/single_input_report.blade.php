@extends('layouts.coreui.main')

@section('content')
    <div class="card">
        <div class="card-header">Manual Report</div>
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active show" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Single Report</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Broken Link</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="false">Messages</a>
                </li> --}}
            </ul>
            
            <div class="tab-content">
                <div class="tab-pane active show" id="home" role="tabpanel">
                    <form class="form-horizontal" onsubmit="return false" id="form">
                        <div class="form-group">
                            <label for="" class="control-label">Tanggal</label>
                            <input type="text" class="form-control daterange-single-sekarang" data-value="{{date('Y/m/d')}}" name="tanggal" id="tanggal">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Social Media</label>
                            <select name="socmed" id="socmed" class="form-control" required>
                                <option value="" disabled selected>--Select Socmed--</option>
                                <option value="1">Twitter</option>
                                <option value="2">Facebook</option>
                                <option value="3">Instagram</option>
                                <option value="4">Youtube</option>
                            </select>
                        </div>
        
                        <div class="form-group">
                            <label for="" class="control-label">Unit</label>
                            <select name="unit" id="unit" class="form-control" required>
                                <option value="" disabled selected>--Select Unit--</option>
                                @foreach($user->unit as $row)
                                    <option value="{{$row->id}}">{{$row->unit_name}}</option>
                                @endforeach
                            </select>
                        </div>
        
                        <div class="form-group">
                            <label for="" class="control-label">Account Type</label>
                            <select name="accounttype" id="accounttype" class="form-control" required>
                                <option value="corporate">Official</option>
                                <option value="program">Program</option>
                            </select>
                        </div>
                        
                        <div id="accountprogram"></div>
        
                        <div class="form-group">
                            <label for="" class="control-label">Follower</label>
                            <input type="text" class="form-control" name="follower" id="follower" required>
                        </div>
        
                        <div id="pesan"></div>
        
                        <div class="form-group">
                            <button class="btn btn-primary">
                                <i class="icon-floppy-disk"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="profile" role="tabpanel">
                    <form id="formBroken" onsubmit="return false;">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label">Tanggal</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="icon-calendar5"></i>
                                        </span>
                                        <input type="text" data-value="{{date('Y/m/d')}}" id="tanggal2" name="tanggal" class="form-control daterange-single">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label">Type Unit</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="icon-archive"></i></span>
                                        <select name="typeunit" id="typeunit" class="form-control" required>
                                            <option value="" disabled selected>--All Unit--</option>
                                            @foreach($typeunit as $row)
                                                <option value="{{$row->id}}">{{$row->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <button class="btn btn-primary" style="margin-top:25px;">
                                    <i class="icon-loop3"></i> Tampilkan
                                </button>
                            </div>
                        </div> 
                    </form>
                    <hr>
                    <form id="formSubmitBroken" onsubmit="return false;">
                        <div id="tampilBroken"></div>
                    </form>
                    
                </div>
                <div class="tab-pane" id="messages" role="tabpanel">
                    
                </div>
            </div>    
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function(){
            $('.daterange-single-sekarang').pickadate({ 
                format: 'yyyy/mm/dd',
                formatSubmit: 'yyyy/mm/dd',
                max:true,
            });

            $('.daterange-single').pickadate({
                format: 'yyyy/mm/dd',
                formatSubmit: 'yyyy/mm/dd',
                max:true,
            });

            $(document).on("change","#unit",function(){
                var accounttype=$("#accounttype option:selected").val();

                if(accounttype=="official"){
                    $("#accountprogram").empty();
                    
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

            $(document).on("submit","#form",function(e){
                var data = new FormData(this);
                data.append("_token","{{ csrf_token() }}");
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('sosmed/data/save-single-report')}}",
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $('#pesan').html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {
                            if(data.success==true){
                                $('#pesan').html('<div class="alert alert-success">&nbsp;'+data.pesan+"</div>");
                            }else{
                                $("#pesan").empty().html("<div class='alert alert-danger'>"+data.pesan+"</div>");
                            }
                        },
                        error   :function() {  
                            $('#pesan').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            })

            $(document).on("submit","#formBroken",function(e){
                var tanggal=$("#tanggal2").val();
                var unit=$("#typeunit option:selected").val();

                var param={
                    tanggal:tanggal,
                    unit:unit,
                    _token:"{{ csrf_token() }}"
                }

                $.ajax({
                    url         : "{{URL::to('sosmed/data/link-broken')}}",
                    type        : 'get',
                    data        : param,
                    beforeSend  : function (){
                        $('#tampilBroken').html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                    },
                    success : function (data) {
                        $("#tampilBroken").empty().html('');

                        $("#tampilBroken").empty().append(data);
                    },
                    errors  :function() {  
                        $('#tampilBroken').html('<div class="alert alert-danger">Your request not Sent...</div>');
                    }
                });
            })

            $(document).on("submit","#formSubmitBroken",function(e){
                var data = new FormData(this);
                data.append("_token","{{ csrf_token() }}");
                if($("#formSubmitBroken")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('sosmed/data/save-link-broken')}}",
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $('#pesan2').html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {
                            if(data.success==true){
                                $('#pesan2').html('<div class="alert alert-success">&nbsp;'+data.pesan+"</div>");
                            }else{
                                $("#pesan2").empty().html("<div class='alert alert-danger'>"+data.pesan+"</div>");
                            }
                        },
                        error   :function() {  
                            $('#pesan2').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            })
        })
    </script>
@stop
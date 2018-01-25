@extends('layouts.app')

@section('content')
<div class="container">
    <form class="form-horizontal" id="import" onsubmit="return false;" enctype="multipart/form-data">
        <div id="pesan"></div>
        <div class="form-group">
            <label class="control-label">Pilih File</label>
            <input type="file" name="file" class="form-control">
        </div>

        <div class="form-group">
            <button class="btn btn-primary">Upload</button>
        </div>
    </form>
</div>
@endsection

@section('js')
    <script>
        $(function(){
            $(document).on("submit","#import",function(e){
                var data = new FormData(this);
                if($("#import")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('import-data')}}",
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $('#pesan').empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {
                            console.log(data);

                            if(data.success==true){
                                $('#pesan').empty().html('<div class="alert alert-info">'+data.pesan+'</div>');
                            }else{
                                $('#pesan').empty().html('<div class="alert alert-danger"><h5>'+data.pesan+'</h5></div><pre>'+data.error+'</pre>');
                            }
                        },
                        error   :function() {  
                            $('#pesan').empty().html('<div class="alert alert-danger">Data Failed to Load...</div>');
                        }
                    });
                }else console.log("invalid form");
            })
        })
    </script>
@stop

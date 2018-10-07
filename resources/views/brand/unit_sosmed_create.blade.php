@extends('layouts.coreui.main')

@section('content')
    <div class="card">
        <div class="card-header">Brand Sosmed</div>
        <div class="card-body">
            <form action="#" id="formUnitSosmed" class="form-horizontal" onsubmit="return false;">
                <div id="pesan"></div>

                <div class="form-group">
                    <div class="label control-label">Sosmed ID</div>
                    <select name="sosmed" id="sosmed" class="form-control" required>
                        <option disabled selected>--Pilih Sosmed--</option>
                        @foreach($sosmed as $row)
                            <option value="{{$row->id}}">{{$row->sosmed_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <div class="label control-label">Brand Name Alias</div>
                    <input type="text" class="form-control" name="brand_name_alias" id="brand_name_alias" placeholder="Brand Name Alias">
                </div>

                <div class="form-group">
                    <div class="label control-label">Brand</div>
                    <select name="brand[]" id="brand" class="select2-multiple" multiple>
                        <option value="">--Pilih Brand--</option>
                        @foreach($brand as $row)
                            <option value="{{$row->id}}">{{$row->text}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <div class="label control-label">Account Name</div>
                    <input type="text" class="form-control" name="account_name" id="account_name" placeholder="Account Name">
                </div>

                <div class="form-group">
                    <div class="label control-label">Account ID</div>
                    <input type="text" class="form-control" name="account_id" id="account_id" placeholder="Account ID">
                </div>
                <hr>
                <div class="form-group">
                    <button class="btn btn-primary">
                        <i class="icon-floppy-disk"></i>
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function(){
            $.fn.select2.defaults.set( "theme", "bootstrap" );

			var placeholder = "Select a State";

			$( ".select2-multiple" ).select2( {
				placeholder: placeholder,
				width: null,
				containerCssClass: ':all:'
			} );

            $(document).on("submit","#formUnitSosmed",function(e){
                var data = new FormData(this);
                data.append("_token","{{ csrf_token() }}");
                if($("#formUnitSosmed")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url			: "{{URL::to('brand/data/brand-sosmed')}}",
                        type		: 'post',
                        data		: data,
                        dataType	: 'JSON',
                        contentType	: false,
                        cache		: false,
                        processData	: false,
                        beforeSend	: function (){
                            $('#pesan').empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success	: function (result) {
                            if(result.success==true){
                                $('#pesan').empty().html('<div class="alert alert-success">&nbsp;'+result.pesan+"</div>");
                                showData();
                            }else{
                                $('#pesan').empty().html("<pre>"+result.error+"</pre><br>");
                            }
                        },
                        error	:function() {  
                            $('#pesan').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            })
        })
    </script>
@stop
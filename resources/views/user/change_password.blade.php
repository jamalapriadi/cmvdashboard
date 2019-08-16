@extends('layouts.coreui.main')

@section('content')
	<div class="card card-default">
		<div class="card-header">
			<h6 class="card-title">Change Password</h6>
		</div>
		<div class="card-body">
			<form  id="form" onsubmit="return false;" class="form-horizontal">
				<div id="pesan"></div>
				<div class="form-group">
					<label for="" class="control-label text-semibold">Password Lama</label>
					<input type="password" name="current" class="form-control">
				</div>
				<div class="form-group">
					<label for="" class="control-label text-semibold">Password Baru</label>
					<input type="password" name="password" class="form-control">
				</div>
				<div class="form-group">
					<label for="" class="control-label text-semibold">Konfirmasi Password</label>
					<input type="password" name="password_confirmation" class="form-control">
				</div>
				<div class="form-group">
					<button class="btn btn-primary">
						<i class="icon-floppy-disk"></i> Change Password
					</button>
				</div>
			</form>
		</div>
	</div>
@stop

@push('extra-script')
	<script>
		$(function(){
			$(document).on("submit","#form",function(e){
                var data = new FormData(this);
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('sosmed/data/change-password')}}",
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
                                $('#pesan').empty().html('<div class="alert alert-info">'+data.pesan+'</div>');
                            }else{
                                $('#pesan').empty().html('<div class="alert alert-info">'+data.pesan+'</div><pre>'+data.error+'</pre>');
                            }
                        },
                        error   :function() {  
                            $('#pesan').empty().html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            });
		})
	</script>
@endpush
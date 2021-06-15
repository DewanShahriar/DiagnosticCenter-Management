<p class="login-box-msg">Your Valid Email</p>
<div id="blank_msg"></div>
<div class="form-group has-feedback">
	<input type="text" class="form-control" name="email_phone" id="email_phone" placeholder="Valid email"  required >
	<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
</div>
<div class="row">
	<center>
		<button onclick="send_emial_phone()" class="btn btn-primary btn-sm btn-flat">Submit</button>
	</center>
	<!-- /.col -->
</div>

<script>
	function send_emial_phone() {

		var email_phone = $('#email_phone').val();

		if (email_phone == '') {

			var data = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Field Can Not Be Empty!</strong></div>';

			$('#blank_msg').html(data);

		} else {


			$.post("<?php echo base_url() . "login/send_mail/"; ?>",
                {email_phone: email_phone},
                function (data) {
                    $('#return_msg').html(data);
                });

		}
	}
</script>
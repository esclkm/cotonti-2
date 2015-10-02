<!-- BEGIN: MAIN -->

<div class="container container-fluid">
		
<!-- BEGIN: USERS_AUTH_MAINTENANCE -->

	<div class="bg-danger">
		<h4>{PHP.L.users_maintenance1}</h4>
		<p>{PHP.L.users_maintenance2}</p>
	</div>
<!-- END: USERS_AUTH_MAINTENANCE -->

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="page-header">
				
				<h1>{USERS_AUTH_TITLE}</h1>
			</div>

			<!-- IF {PHP.usr.id} -->
			<p>{PHP.L.users_loggedinas} <strong>{PHP.usr.name}</strong>.<br/>{PHP.L.users_logoutfirst}</p>
			<p><a class="button" href="{PHP.sys.xk|cot_url('login','out=1&x=$this', '', 0, 1)}">{PHP.L.Logout}</a></p>
			<!-- ELSE -->
			<form name="login" action="{USERS_AUTH_SEND}" method="post" class="form-horizontal">
				<div class="form-group row">
					<label class="col-sm-3 control-label">{PHP.L.users_nameormail}:</label>
					<div class="col-sm-9">{USERS_AUTH_USER}</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 control-label">{PHP.L.Password}:</label>
					<div class="col-sm-9">{USERS_AUTH_PASSWORD}</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-9 col-sm-offset-3"><label>{USERS_AUTH_REMEMBER}&nbsp; {PHP.L.users_rememberme}</label></div>
				</div>
				<div>
					<hr/>
					<div class="pull-right"><button type="submit"  class="btn btn-success" name="rlogin" value="0">{PHP.L.Login}</button></div>
					<div class="clearfix"</div>
				</div>
			</form>
			<!-- ENDIF -->
		</div>
	</div>



</div>
<!-- END: MAIN -->
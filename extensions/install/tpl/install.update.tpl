
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta name="generator" content="Feliz http://www.cotonti.com" />
		<meta http-equiv="expires" content="Fri, Apr 01 1974 00:00:00 GMT" />
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="last-modified" content="{$PHP.meta_lastmod} GMT" />
		<meta name="robots" content="noindex" />
		<link rel="shortcut icon" href="favicon.ico" />
		<title>{$PHP.L.install_update}</title>
		<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css" />
		<script src="assets/bootstrap/js/bootstrap.js"></script>
		<link rel="stylesheet" type="text/css" href="extensions/install/tpl/style.css" />
	</head>


	<body>
		<div class="container container-fluid">
			<div class="page-header">
				<h1>{$PHP.L.install_update} <small> {$UPDATE_FROM} &mdash; {$UPDATE_TO}</small></h1>
			</div>

			<h3>{$UPDATE_TITLE}</h3>
			{include $PHP.cfg.extensions_dir~"/install/tpl/warnings.tpl"}

			{if $UPDATE_COMPLETED_NOTE}
			<p class="complete">
				<span>{$UPDATE_COMPLETED_NOTE}</span>
			</p>
			
			<hr/>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10 text-right">
					<a href="{$PHP.cfg.mainurl}" class="btn btn-success">{$PHP.L.install_view_site}</a>
				</div>
			</div>

			{/if}
		</div>
	</body>
</html>

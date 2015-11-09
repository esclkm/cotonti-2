<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta name="generator" content="Cotonti http://www.cotonti.com" />
		<meta http-equiv="expires" content="Fri, Apr 01 1974 00:00:00 GMT" />
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="last-modified" content="{$PHP.meta_lastmod} GMT" />
		<meta name="robots" content="noindex" />
		<link rel="shortcut icon" href="favicon.ico" />
		<title>{$PHP.L.install_title}</title>
		<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css" />
		<script src="assets/bootstrap/js/bootstrap.js"></script>
		<link rel="stylesheet" type="text/css" href="extensions/install/tpl/style.css" />
	</head>


	<body>
		<div class="container container-fluid">
			<div class="page-header">
				
				<h1>{$PHP.L.install_body_title} <small> ver. {$PHP.cfg.version}</small>
				<span class="small pull-right">{$INSTALL_STEP}</span>	
				</h1>
			</div>
			{include $PHP.cfg.extensions_dir~"/install/tpl/warnings.tpl"}

			<form action="install.php" class="form-horizontal" method="post">

				{if $INSTALL_STEP_1}
				<input type="hidden" name="step" value="1" />


				<div class="form-group row">
					<label class="col-sm-3 control-label">{$PHP.L.Language}</label>
					<div class="col-sm-9">{$INSTALL_LANG}</div>
				</div>
				{if $INSTALL_SCRIPT}
				<div class="form-group row">
					<label class="col-sm-3 control-label">Install script</label>
					<div class="col-sm-9">{$INSTALL_SCRIPT}</div>
				</div>
				{/if}
				<div class="clearfix"></div>
				<hr/>

				<div class="form-group row">
					<div class="col-sm-offset-3 col-sm-9 text-right">
						<p><button type="submit" class="btn btn-success">{$PHP.L.Next} <span class="glyphicon glyphicon-chevron-right"></span></button></p>
					</div>
				</div>

				{/if}

				{if $INSTALL_STEP_2}
				<input type="hidden" name="step" value="2" />

				<p>{$PHP.L.install_body_message1}</p>
				<h3>{$PHP.L.install_ver}</h3>
				<div class="row">
					<div class="col-sm-6"><span class="glyphicon glyphicon glyphicon-cog"></span> PHP</div>
					<div class="col-sm-6 text-right">{$INSTALL_PHP_VER}</div>
				</div>
				<div class="row">
					<div class="col-sm-6"><span class="glyphicon glyphicon glyphicon-cog"></span> mbstring</div>
					<div class="col-sm-6 text-right">{$INSTALL_MBSTRING}</div>
				</div>
				<div class="row">
					<div class="col-sm-6"><span class="glyphicon glyphicon glyphicon-cog"></span> hash</div>
					<div class="col-sm-6 text-right">{$INSTALL_HASH}</div>
				</div>
				<div class="row">
					<div class="col-sm-6"><span class="glyphicon glyphicon glyphicon-cog"></span> MySQL</div>
					<div class="col-sm-6 text-right">{$INSTALL_MYSQL}</div>
				</div>
				<div class="clearfix"></div>

				<h3>{$PHP.L.install_permissions}</h3>

				<div class="row">
					<div class="col-sm-6"><span class="glyphicon glyphicon glyphicon-file"></span> {$PHP.file.config}</div>
					<div class="col-sm-6 text-right">{$INSTALL_CONFIG}</div>
				</div>
				<div class="row">
					<div class="col-sm-6"><span class="glyphicon glyphicon glyphicon-file"></span> {$PHP.file.config_sample}</div>
					<div class="col-sm-6 text-right">{$INSTALL_CONFIG_SAMPLE}</div>
				</div>
				<div class="row">
					<div class="col-sm-6"><span class="glyphicon glyphicon glyphicon-file"></span> {$PHP.file.sql}</div>
					<div class="col-sm-6 text-right">{$INSTALL_SQL_FILE}</div>
				</div>
				<div class="row">
					<div class="col-sm-6"><span class="glyphicon glyphicon glyphicon-folder-open"></span> {$PHP.cfg.avatars_dir}</div>
					<div class="col-sm-6 text-right">{$INSTALL_AV_DIR}</div>
				</div>
				<div class="row">
					<div class="col-sm-6"><span class="glyphicon glyphicon glyphicon-folder-open"></span> {$PHP.cfg.cache_dir}</div>
					<div class="col-sm-6 text-right">{$INSTALL_CACHE_DIR}</div>
				</div>
				<div class="row">
					<div class="col-sm-6"><span class="glyphicon glyphicon glyphicon-folder-open"></span> {$PHP.cfg.extrafield_files_dir}</div>
					<div class="col-sm-6 text-right">{$INSTALL_EXFLDS_DIR}</div>
				</div>
				<div class="row">
					<div class="col-sm-6"><span class="glyphicon glyphicon glyphicon-folder-open"></span> {$PHP.cfg.pfs_dir}</div>
					<div class="col-sm-6 text-right">{$INSTALL_PFS_DIR}</div>
				</div>
				<div class="row">
					<div class="col-sm-6"><span class="glyphicon glyphicon glyphicon-folder-open"></span> {$PHP.cfg.photos_dir}</div>
					<div class="col-sm-6 text-right">{$INSTALL_PHOTOS_DIR}
					</div></div>
				<div class="row">
					<div class="col-sm-6"><span class="glyphicon glyphicon glyphicon-folder-open"></span> {$PHP.cfg.thumbs_dir}</div>
					<div class="col-sm-6 text-right">{$INSTALL_THUMBS_DIR}</div>
				</div>


				<div class="clearfix"></div>
				<hr/>

				<div class="form-group row">
					<div class="col-sm-offset-2 col-sm-10 text-right">
						<p><button type="submit" class="btn btn-success">{$PHP.L.Next} <span class="glyphicon glyphicon-chevron-right"></span></button></p>
					</div>
				</div>
				{/if}

				{if $INSTALL_STEP_3}
				<input type="hidden" name="step" value="3" />
				<h2>{$PHP.L.install_db}</h2>
				
				<div class="form-group row">
					<label class="col-sm-3 control-label">{$PHP.L.install_db_host}</label>
					<div class="col-sm-9">{$INSTALL_DB_HOST_INPUT}</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 control-label">{$PHP.L.install_db_port}</label>
					<div class="col-sm-9">
						{$INSTALL_DB_PORT_INPUT}
						<p class="small text-center">{$PHP.L.install_db_port_hint}</p>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 control-label">{$PHP.L.install_db_user}</label>
					<div class="col-sm-9">{$INSTALL_DB_USER_INPUT}</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 control-label">{$PHP.L.install_db_pass}</label>
					<div class="col-sm-9">{$INSTALL_DB_PASS_INPUT}</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 control-label">{$PHP.L.install_db_name}</label>
					<div class="col-sm-9">{$INSTALL_DB_NAME_INPUT}</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 control-label">{$PHP.L.install_db_x}</label>
					<div class="col-sm-9">{$INSTALL_DB_X_INPUT}</div>
				</div>

				<div class="alert alert-warning">{$PHP.L.install_body_message3}</div>

				<div class="clearfix"></div>
				<hr/>

				<div class="form-group row">
					<div class="col-sm-offset-2 col-sm-10 text-right">
						<p><button type="submit" class="btn btn-success">{$PHP.L.Next} <span class="glyphicon glyphicon-chevron-right"></span></button></p>
					</div>
				</div>

				{/if}

				{if $INSTALL_STEP_4}
				<input type="hidden" name="step" value="4" />
				<h2>{$PHP.L.install_misc}</h2>
				<div class="form-group row">
					<label class="col-sm-5 control-label">{$PHP.L.install_misc_theme}</label>
					<div class="col-sm-7">{$INSTALL_THEME_SELECT}</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-5 control-label">{$PHP.L.install_misc_lng}</label>
					<div class="col-sm-7">{$INSTALL_LANG_SELECT}</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-5 control-label">{$PHP.L.install_misc_url}</label>
					<div class="col-sm-7">{$INSTALL_MAINURL}</div>
				</div>
				
				<h2>{$PHP.L.install_adminacc}</h2>
				<div class="form-group row">
					<label class="col-sm-5 control-label">{$PHP.L.Username}</label>
					<div class="col-sm-7">{$INSTALL_USERNAME}</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-5 control-label">{$PHP.L.Password}</label>
					<div class="col-sm-7">{$INSTALL_PASS1}</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-5 control-label">{$PHP.L.install_retype_password}</label>
					<div class="col-sm-7">{$INSTALL_PASS2}</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-5 control-label">{$PHP.L.Email}</label>
					<div class="col-sm-7">{$INSTALL_EMAIL}</div>
				</div>

				<div class="clearfix"></div>
				<hr/>

				<div class="form-group row">
					<div class="col-sm-offset-2 col-sm-10 text-right">
						<p><button type="submit" class="btn btn-success">{$PHP.L.Install} <span class="glyphicon glyphicon-chevron-right"></span></button></p>
					</div>
				</div>

				{/if}

				{if $INSTALL_STEP_5}
				<input type="hidden" name="step" value="5" />
				<div class="pull-right">
					{$PHP.L.Order}: 
					<a href="{$INSTALL_ORDER_ALPHA}">{$PHP.L.adm_sort_alphabet}</a> 
					<a href="{$INSTALL_ORDER_CAT}">{$PHP.L.adm_sort_category}</a>
				</div>				
				<h2>{$PHP.L.install_extensions}</h2>
		
					{foreach $INSTALL_CATEGORIES as $code => $title}
					{if $code!='all'}<h3>{$title}</h3>{/if}
					{foreach $INSTALL_EXTENSIONS.$code as $EXT}
					<div class="row marginbottom10">
						<div class="col-sm-1">{$EXT.CHECKBOX}</div>
						<div class="col-sm-1 text-center">{if $EXT.ICO}<img src="{$EXT.ICO}" />{/if}</div>
						<div class="col-sm-10">
							<strong>{$EXT.TITLE}</strong>
							<div class="small pull-right">
							{if $EXT.REQUIRES|length}
								<small class="text-danger">{$PHP.L.install_requires}:</small>
									{foreach $EXT.REQUIRES as $REQUIRE}
									<span class="label label-warning">{$REQUIRE}</span>
									{/foreach}
								
							{/if}
							{if $EXT.REQUIRES|length && $EXT.RECOMMENDS|length} | {/if}
							{if $EXT.RECOMMENDS|length}
								<small>{$PHP.L.install_recommends}:</small> 
									{foreach $EXT.RECOMMENDS as $RECOMMEND}
									<span class="label label-info">{$RECOMMEND}</span>
									{/foreach}
								
							{/if}
							</div>							
							<p>{$EXT.DESCRIPTION}</p>

						</div>
					</div>
					{/foreach}
					<hr />
					{/foreach}

				<div class="form-group row">
					<div class="col-sm-offset-2 col-sm-10 text-right">
						<p><button type="submit" class="btn btn-success">{$PHP.L.Finish} <span class="glyphicon glyphicon-chevron-right"></span></button></p>
					</div>
				</div>


				{/if}

				{if $INSTALL_STEP_6}
				<h2>{$PHP.L.install_complete}</h2>
				<p>{$PHP.L.install_complete_note}</p>
				<div class="clearfix"></div>
				<hr/>

				<div class="form-group row">
					<div class="col-sm-offset-2 col-sm-10 text-right">
						<a href="{$PHP.cfg.mainurl}" class="btn btn-success">{$PHP.L.install_view_site}</a>
					</div>
				</div>


				{/if}
			</form>
		</div>
	</body>
</html>
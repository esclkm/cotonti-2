<!-- BEGIN: HEADER -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<meta http-equiv="content-type" content="{$HEADER_META_CONTENTTYPE}; charset=UTF-8" />
	<meta name="description" content="{$HEADER_META_DESCRIPTION}" />
	<meta name="keywords" content="{$HEADER_META_KEYWORDS}" />
	
	<meta name="generator" content="Cotonti http://www.cotonti.com" />
	<meta http-equiv="expires" content="Fri, Apr 01 1974 00:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="last-modified" content="{$HEADER_META_LASTMODIFIED} GMT" />
	{$HEADER_BASEHREF}
	{$HEADER_HEAD}
	<link rel="shortcut icon" href="favicon.ico" />
	<link href="{$PHP.cfg.themes_dir}/admin/{$PHP.cfg.admintheme}/css/admin.css" type="text/css" rel="stylesheet" />
	<link href="{$PHP.cfg.themes_dir}/admin/{$PHP.cfg.admintheme}/css/sidebar.css" type="text/css" rel="stylesheet" />
	{$HEADER_COMPOPUP}
	<title>{$HEADER_TITLE}</title>
	
</head>
<body>
		<div id="navbar">
			<span id="logo">
				<a href="{$PHP.cfg.mainurl}" title="{$PHP.L.hea_viewsite}">{if $PHP.cfg.maintitle && $.php.mb_strlen($PHP.cfg.maintitle) < 20}
				{$PHP.cfg.maintitle}
				{else}
				{$PHP.L.hea_viewsite}
				{/if}</a>
			</span>
			<ul class="nav">
				<li class="{if !$PHP.t }active{/if}">
					<a href="{$.php.cot_url('admin')}" title="{$PHP.L.Administration}">
						<i class="fa fa-home"></i> 
						{$PHP.L.Home}
					</a>
				</li>
				{if $PHP.usr.admin_config }
				<li class="{if $PHP.t == 'config'}active{/if}">
					<a href="{$.php.cot_url('admin', 't=config')}" title="{$PHP.L.Configuration}">
						<i class="fa fa-cogs"></i> 
						{$PHP.L.Configuration}
					</a>
				</li>
				{/if}
				{if $PHP.usr.admin_structure }
				<li class="{if $PHP.t == 'structure' }active{/if}">
					<a href="{$.php.cot_url('admin', 't=structure')}" title="{$PHP.L.Structure}">
						<i class="fa fa-sitemap"></i> 
						{$PHP.L.Structure}
					</a>
				</li>
				{/if}
				{if $PHP.usr.admin_config }
				<li class="{if $PHP.t == 'extensions'}active{/if}">
					<a href="{$.php.cot_url('admin', 't=extensions')}" title="{$PHP.L.Extensions}">
						<i class="fa fa-archive"></i> 
						{$PHP.L.Extensions}
					</a>
				</li>
				{/if}
				{if $PHP.usr.admin_users }
				<li class="{if $PHP.t == 'users' }active{/if}">
					<a href="{$.php.cot_url('admin', 't=users')}" title="{$PHP.L.Users}">
						<i class="fa fa-group"></i> 
						{$PHP.L.Users}
					</a>
				</li>
				{/if}
				<li class="{if $PHP.t == 'extrafields' }active{/if}">
					<a href="{$.php.cot_url('admin', 't=extrafields')}" title="{$PHP.L.adm_extrafields}">
						<i class="fa fa-database"></i> 
						{$PHP.L.adm_extrafields}
					</a>
				</li>

			</ul>
			<div class="clear"></div>
			<ul class="nav userinfo">
				<li>
					<a href="{$.php.cot_url('users','m=profile')}" target="_blank">
						<i class="fa fa-user"></i>{$PHP.usr.name}</a>
				</li>
				{if $PHP.out.notices }
				{foreach $PHP.out.notices_array as $KEY => $VALUE}
				<li>
					{if $.php.is_array($VALUE) }					
					<a href="{$VALUE.0}"  class="fancybox" rel="gallery1"  target="_blank">	
						<i class="fa fa-exclamation-triangle"></i>
						{$VALUE.1}
					</a>
					{else}
					{$VALUE}
					{/if}
				</li>
				{/foreach}
				{/if}
				{if $PHP.usr.messages > 0  }
				<li>
					<a href="{$.php.cot_url('pm')}" target="_blank">
						<i class="fa fa-envelope"></i>
						{$.php.cot_declension($PHP.usr.messages, 'Privatemessages')}
					</a>
				</li>
				{/if}
				{if $PHP.cot_extensions.pfs }
				<li><a href="{$.php.cot_url('pfs')}">{$PHP.L.PFS}</a></li>
				{/if}
				<li>
					<a href="{$HEADER_USER_LOGINOUT_URL}"><i class="fa fa-sign-out"></i>{$PHP.L.Logout}</a>
				</li>
			</ul>
			<div class="clear"></div>			
			<div id="footer">
				<a href="http://cotonti.com" target="_blank" title="Cotonti {$PHP.cfg.version}">Feliz {$PHP.cfg.version}</a>
			</div>
		</div>
		<div id="navshade"></div>
		<a href="#" id="showmenu"><i class="glyphicon glyphicon-chevron-right"></i></a>
		<div id="wrapper" class="">			
			<div id="header">{$HEADER_BREADCRUMBS}</div>
			<div id="ajaxBlock">
					<div id="main" class="container-fluid{if $PHP.m } mode_{$PHP.m}{/if}">
<!-- END: HEADER -->
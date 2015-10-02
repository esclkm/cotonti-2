<!-- BEGIN: HEADER -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<meta http-equiv="content-type" content="{HEADER_META_CONTENTTYPE}; charset=UTF-8" />
	<meta name="description" content="{HEADER_META_DESCRIPTION}" />
	<meta name="keywords" content="{HEADER_META_KEYWORDS}" />
	
	<meta name="generator" content="Cotonti http://www.cotonti.com" />
	<meta http-equiv="expires" content="Fri, Apr 01 1974 00:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="last-modified" content="{HEADER_META_LASTMODIFIED} GMT" />
	{HEADER_BASEHREF}
	{HEADER_HEAD}
	<link rel="shortcut icon" href="favicon.ico" />
	<link href="{PHP.cfg.themes_dir}/admin/default/css/admin.css" type="text/css" rel="stylesheet" />
	<link href="{PHP.cfg.themes_dir}/admin/default/css/sidebar.css" type="text/css" rel="stylesheet" />
	{HEADER_COMPOPUP}
	<title>{HEADER_TITLE}</title>
	
	<!-- Menu Toggle Script -->
    <script>
	$(document).ready(function() {
		$("#menu-toggle").click(function(e) {
			$("#sidebar-wrapper").toggleClass("toggled");
			return false;
		});
	});	

    </script>
</head>
<body>
		<header>
			<nav class="navbar navbar-default navbar-static-top" role="navigation">
				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" id="menu-toggle">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>

						<a class="navbar-brand" href="{PHP.cfg.mainurl}" title="{PHP.cfg.maintitle} {PHP.cfg.separator} {PHP.cfg.subtitle}">{PHP.cfg.maintitle}</a>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
						<ul class="nav navbar-nav navbar-right">
							<!-- BEGIN: USER -->
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-user"></span> {HEADER_USER_NAME}<span class="caret"></span>
								</a>
								<ul class="dropdown-menu" role="menu">
									<!-- IF HEADER_USER_ADMINPANEL -->
									<li><a href="{HEADER_USER_ADMINPANEL_URL}">{PHP.L.Administration}</a></li>
									<!-- ENDIF -->
									
									<!-- IF {PHP.out.notices} -->
									<li>{PHP.out.notices}</li>
									<!-- ENDIF -->
									<li><a href="{HEADER_USER_PROFILE_URL}">{PHP.L.Profile}</a></li>
									<!-- IF {PHP.cot_modules.pm} -->
									<li><a href="{PHP|cot_url('pm')}">{PHP.L.Private_Messages}</a></li>
									<!-- ENDIF -->
									<!-- IF {PHP.cot_modules.pfs} -->
									<li><a href="{PHP|cot_url('pfs')}">{PHP.L.PFS}</a></li>
									<!-- ENDIF -->
									<li class="divider"></li>
									<li><a href="{HEADER_USER_LOGINOUT_URL}">{PHP.L.Logout}</a></li>
								</ul>							
							</li>
							<!-- END: USER -->						
						</ul>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>
		</header>
		
        <!-- Sidebar -->
		
        <div id="sidebar-wrapper">		
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
					<a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a>
                </li>
				<!-- IF {PHP.usr.admin_config} -->
				<li<!-- IF {PHP.m} == 'extensions' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('admin', 't=extensions')}">
					{PHP.L.Extensions}
				</a></li>
				<li<!-- IF {PHP.m} == 'config' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('admin', 't=config')}">
					{PHP.L.Configuration}
				</a></li>
				<!-- ENDIF -->
				<!-- IF {PHP.usr.admin_structure} -->
				<li<!-- IF {PHP.m} == 'structure' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('admin', 't=structure')}">
					{PHP.L.Structure}
				</a></li>
				<!-- ENDIF -->
				<li<!-- IF {PHP.m} == 'extrafields' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('admin', 't=extrafields')}">{PHP.L.adm_extrafields}</a></li>
				<!-- IF {PHP.usr.admin_users} -->
				<li<!-- IF {PHP.m} == 'users' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('admin', 't=users')}">
					{PHP.L.Users}
				</a></li>
				<!-- ENDIF -->
            </ul>
        </div>

        <!-- /#sidebar-wrapper -->		

		<div id="page-content-wrapper">
			
		<div class="container-fluid" id="ajaxBlock">	
			

<!-- END: HEADER -->
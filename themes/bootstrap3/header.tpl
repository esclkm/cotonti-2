<!-- BEGIN: HEADER -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
	<head>
		<title>{HEADER_TITLE}</title> 
		<!-- IF {HEADER_META_DESCRIPTION} --><meta name="description" content="{HEADER_META_DESCRIPTION}" /><!-- ENDIF -->
		<!-- IF {HEADER_META_KEYWORDS} --><meta name="keywords" content="{HEADER_META_KEYWORDS}" /><!-- ENDIF -->
		<meta http-equiv="content-type" content="{HEADER_META_CONTENTTYPE}; charset=UTF-8" />
		<meta name="generator" content="Cotonti http://www.cotonti.com" />
		<link rel="canonical" href="{HEADER_CANONICAL_URL}" />
		{HEADER_BASEHREF}
		{HEADER_HEAD}
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="apple-touch-icon.png" />
		{PHP.cfg.freetext1}

	</head>

	<body>
		{PHP.cfg.freetext2}

		<header>


			<nav class="navbar navbar-default navbar-static-top" role="navigation">
				<div class="container container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="{PHP.cfg.mainurl}" title="{PHP.cfg.maintitle} {PHP.cfg.separator} {PHP.cfg.subtitle}">{PHP.cfg.maintitle}</a>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<!-- IF {PHP.cot_modules.forums} -->
							<li><a href="{PHP|cot_url('forums')}">{PHP.L.Forums}</a></li>
							<!-- ENDIF -->
							<li><a href="{PHP|cot_url('page','c=news')}">{PHP.structure.page.news.title}</a></li>
							<li><a href="{PHP|cot_url('users')}">{PHP.L.Users}</a></li>
							<!-- IF {PHP.cot_extensions_active.whosonline} -->
							<li><a href="{PHP|cot_url('plug','e=whosonline')}">{PHP.L.WhosOnline}</a>
							<!-- ENDIF -->
							<li><a href="{PHP|cot_url('plug','e=contact')}">{PHP.L.Contact}</a></li>
						</ul>

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
							<!-- BEGIN: GUEST -->
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-log-in"></span> {PHP.L.hea_youarenotlogged}<span class="caret"></span>
								</a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="{PHP|cot_url('login')}">{PHP.L.Login}</a></li>
									<li><a href="{PHP|cot_url('users','m=register')}">{PHP.L.Register}</a></li>
									<li><a href="{PHP|cot_url('users','m=passrecover')}">{PHP.L.users_lostpass}</a></li>
								</ul>							
							</li>
							<!-- END: GUEST -->							
						</ul>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>
		</header>		
<!-- END: HEADER -->
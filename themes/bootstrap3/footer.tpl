<!-- BEGIN: FOOTER -->
<footer class="">
	<div class="container container-fluid">
		<hr/>
		<div class="row">
			<div class="col-md-6">
				<!-- IF {PHP.cot_modules.rss} -->
				{PHP.R.icon_rss} <a href="{PHP|cot_url('rss')}" title="{PHP.L.RSS_Feeds}">RSS</a>
				<!-- ENDIF -->
				<!-- IF {PHP.cfg.forums} -->
				{PHP.R.icon_rss} <a href="{PHP|cot_url('rss','m=forums')}" title="{PHP.L.RSS_Feeds} {PHP.cfg.separator} {PHP.L.Forums}"> RSS (<span class="lower">{PHP.L.Forums}</span>)</a>
				<!-- ENDIF -->
			</div>
			<div class="col-md-6 text-right">
				<div id="powered">{FOOTER_COPYRIGHT}</div>
			</div>
		</div>
	</div>
</footer>





{FOOTER_RC}
</body>
</html>
<!-- END: FOOTER -->
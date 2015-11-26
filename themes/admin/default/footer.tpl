		</div>
	</div>
</div>
<footer class="container-fluid">
	<hr/>
	<div class="row">
		<div class="col-md-10 hidden-sm hidden-xs">
			<div>{$FOOTER_CREATIONTIME} {$FOOTER_SQLSTATISTICS}</div>
		</div>
		<div class="col-md-2 text-right" id="powered">{$PHP.out.copyright} {$PHP.cfg.version}</div>
	</div>

</footer>
{if $FOOTER_DEVMODE}
<div class="container-fluid devmode">			
	<div class="alert alert-warning" role="alert">{$FOOTER_DEVMODE}</div>
</div>
{/if}

{$FOOTER_RC}
</body>
</html>
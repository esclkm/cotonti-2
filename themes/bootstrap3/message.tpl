<div class="container container-fluid">
	{if $MESSAGE_ERROR_CODE}
	<div class="page-header">
		<h1>{$PHP.L.Message} #{$MESSAGE_ERROR_CODE}</h1>
	</div>
	
	<h2>{$MESSAGE_TITLE}</h2>
	{else}
	<div class="page-header">
		<h1>{$MESSAGE_TITLE}</h1>
	</div>
	{/if}
	<div class="margintop10">
		{$MESSAGE_BODY}
	</div>
	
	{if $MESSAGE_CONFIRM_YES}
	<div class="text-center">
		<a id="confirmYes" href="{$MESSAGE_CONFIRM_YES}" class="confirmButton btn btn-primary">{$PHP.L.Yes}</a>
		<a id="confirmNo" href="{$MESSAGE_CONFIRM_NO}" class="confirmButton btn btn-default">{$PHP.L.No}</a>
	</div>
	{/if}
</div>


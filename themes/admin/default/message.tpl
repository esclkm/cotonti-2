
{if !$AJAX_MODE }
<h1 class="body">{$MESSAGE_TITLE}</h1>

<div id="main" class="body clear">
{/if}		
	<div class="warning">
					{$MESSAGE_BODY}
		{foreach \$1 as $row}
		<table class="inline" style="width:80%">
			<tr>
				<td>
					<a id="confirmYes" href="{$MESSAGE_CONFIRM_YES}" class="confirmButton">{$PHP.L.Yes}</a>
				</td>
				<td>
					<a id="confirmNo" href="{$MESSAGE_CONFIRM_NO}" class="confirmButton">{$PHP.L.No}</a>
				</td>
			</tr>
		</table>
		{/foreach}
	</div>
{if !$AJAX_MODE }				
</div>
{/if}	

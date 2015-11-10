{if $ERROR_MSG}
<div class="alert alert-danger" role="alert">
	<strong>{$PHP.L.Error}</strong>
	<ul>
		{foreach $ERROR_MSG as $MSG}
		<li>{$MSG}</li>
		{/foreach}
	</ul>
</div>
{/if}

{if $WARNING_MSG}
<div class="alert alert-warning" role="alert">
	<strong>{$PHP.L.Warning}</strong>
	<ul>
		{foreach $WARNING_MSG as $MSG}
		<li>{$MSG}</li>
		{/foreach}
	</ul>
</div>
{/if}

{if $INFO_MSG}
<div class="alert alert-success" role="alert">
	<strong>{$PHP.L.Done}</strong>
	<ul>
		{foreach $INFO_MSG as $MSG}
		<li>{$MSG}</li>
		{/foreach}
	</ul>
</div>
{/if}
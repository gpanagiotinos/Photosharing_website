{if $message.text }
<div class="message {$message.type|default:'error'}">
	{$message.text}
</div>
{/if}
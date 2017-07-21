<form action="" method="post">
	<p>111
		[[%sendex_subscribe_intro?name=`[[+name]]`]]
		<small>[[+description]]</small>
	</p>

	<input type="hidden" name="sx_action" value="subscribe">
	<button type="submit">[[%sendex_btn_subscribe]]</button>

	[[+message]]
</form>
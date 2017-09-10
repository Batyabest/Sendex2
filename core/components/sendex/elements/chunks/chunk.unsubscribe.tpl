<form action="[[~4]]" method="post">
	<h2>
		Хотите отписаться от рассылки?
	</h2>

	<ul>
		<li><input type="radio" name="quest">[[+0]]</li>
		<li><input type="radio" name="quest">[[+1]]</li>
		<li><input type="radio" name="quest">[[+2]]</li>
	</ul>

	<input type="hidden" name="id" value="[[+id]]">
	<input type="hidden" name="email" value="[[+email]]">
	<input type="hidden" name="sx_action" value="unsubscribe">
	<button type="submit" id="btn">[[%sendex_btn_unsubscribe]]</button>

	[[+message]]
</form>
<div id="result_form"><div>
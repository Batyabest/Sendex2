<form action="" method="post">
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
<!--
<div id="result_form"><div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
	$( document ).ready(function() {
		$("#btn").click(
				function(){
					sendAjaxForm('result_form', 'ajax_form', '/form.php');
					return false;
				}
		);
	});

	function sendAjaxForm(result_form, ajax_form, url) {
		jQuery.ajax({
			url:     url, //url страницы (/form.php)
			type:     "POST", //метод отправки
			dataType: "html", //формат данных
			data: jQuery("#"+ajax_form).serialize(),  // Сеарилизуем объект
			success: function(response) { //Данные отправлены успешно
				result = jQuery.parseJSON(response);
				document.getElementById(result_form).innerHTML = "Ваш email: "+result.email+" успешно отписан"
			},
			error: function(response) { // Данные не отправлены
				document.getElementById(result_form).innerHTML = "Ошибка. Данные не отправленны.";
			}
		});
	}
</script>-->
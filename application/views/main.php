<?php
	$this->load->helper('url');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Prueba</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="<?= base_url(); ?>css/pure-min.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>css/main.css" />
</head>
<body>
	<div id="header">
		<img height="150px" src="<?= base_url(); ?>css/logo.png">
	</div>
	<div class="hr"></div>
	<form class="pure-form" method="post">
		<fieldset>
			<label>Tipo de Persona</label>
			<select name="interface">
				<option value="0">Persona</option>
				<option value="1">Empresa</option>
			</select>
		</fieldset>
		<fieldset>
			<label>Banco</label>
			<select name="banco">
				<?php foreach ($bancos as $banco): ?>
					<option value="<?= $banco['bankCode'] ?>">
						<?= $banco['bankName'] ?>
					</option>
				<?php endforeach; ?>
			</select>
		</fieldset>
		<button type="submit" class="pure-button pure-button-primary">Enviar</button>
	</form>
</body>
</html>
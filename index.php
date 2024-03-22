<html>
	<!-- <?php print_r($_GET); ?> -->
	<head>
		<meta charset="utf-8" />
    	<title>App Mail Send</title>

    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	</head>

	<body>

		<div class="container">  

			<div class="py-3 text-center">
				<img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
				<h2>Send Mail</h2>
				<p class="lead"><b>Seu</b> app de envio de e-mails particular!</p>
			</div>

      		<div class="row">
      			<div class="col-md-12">
  				
					<div class="card-body font-weight-bold">
						<form action="processa_envio.php" method="post" onsubmit="return confirmarEnvio()">
							<div class="form-group">
								<label for="destinatario">Destinatário</label>
								<input name="destinatario" type="email" class="form-control" id="destinatario" placeholder="joao@dominio.com.br">
							</div>

							<div class="form-group">
								<label for="assunto">Assunto</label>
								<input name="assunto" type="text" class="form-control" id="assunto" placeholder="Assundo do e-mail">
							</div>

							<div class="form-group">
								<label for="mensagem">Mensagem</label>
								<textarea name="mensagem" class="form-control" id="mensagem"></textarea>
							</div>

							<?php if(isset($_GET['msg']) &&  $_GET['msg'] == 'erro'){ ?>

								<div class="text-danger mb-3">
									Erro! Destinatário e Mensagem precisam ser preechidos.
								</div>

							<?php } ?>

							<?php if(isset($_GET['msg']) && $_GET['msg'] == 'enviado'){ ?>

								<div class="text-success mb-3">
									Mensagem encaminhada!
								</div>
								
							<?php } ?>
							<button type="submit" class="btn btn-primary btn-lg">Enviar Mensagem</button>
						</form>


					</div>
				</div>
      		</div>
      	</div>

		<script>
			function confirmarEnvio() {
				var assunto = document.getElementById("assunto").value;
				var destinatario = document.getElementById("destinatario").value				
				var mensagem = document.getElementById("mensagem").value

				if (assunto === '' && destinatario !== '' && mensagem !== '' ) {
					return confirm("Você está prestes a enviar um email sem assunto. Deseja continuar?");
				}
			}
		</script>
	</body>
</html>
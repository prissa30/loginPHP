
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link href="../css/estiloLogin.css" rel="stylesheet" type="text/css" >
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
		<div class="login">
			<h1>Login</h1>

			<?php 
				if(isset($_GET['error'])) {
					?>
					<div class="alert alert-danger" role="alert">
						E-mail ou senha inválida!
					</div>
					<?php
				}
			?>
			<form action="logar.php" method="post">
				<label for="email">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="email" placeholder="E-mail" id="email" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Senha" id="password" required>
				<input type="submit" value="Login">
				<p>Não tem uma conta? <a href="../html/register.html" >Cadastre-se agora</a>.</p>
			</form>
		</div>
	</body>
</html>
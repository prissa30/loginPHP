<?php
// Altere isso para suas informações de conexão.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';
// Tente conectar usando as informações acima.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// Se houver um erro com a conexão, interrompa o script e exiba o erro.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Primeiro verificamos se o email e o código existem...
if (isset($_GET['email'], $_GET['code'])) {
	if ($stmt = $con->prepare('SELECT * FROM accounts WHERE email = ? AND activation_code = ?')) {
		$stmt->bind_param('ss', $_GET['email'], $_GET['code']);
		$stmt->execute();
		// Armazene o resultado para que possamos verificar se a conta existe no banco de dados.
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			// A conta existe com o e-mail e código solicitados.
			if ($stmt = $con->prepare('UPDATE accounts SET activation_code = ? WHERE email = ? AND activation_code = ?')) {
				// Defina o novo código de ativação para 'ativado', é assim que podemos verificar se o usuário ativou sua conta.
				$newcode = 'activated';
				$stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['code']);
				$stmt->execute();
				echo 'Sua conta já está ativada! Agora você pode<a href="../php/login.php">login</a>!';
			}
		} else {
			echo 'A conta já está ativada ou não existe!';
		}
	}
}
?>
<?php
// Altere isso para suas informações de conexão.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';
// Tente conectar usando as informações acima.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// Se houver um erro com a conexão, pare o script e exiba o erro.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Agora verificamos se os dados foram enviados, a função isset() verificará se os dados existem.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	// Não foi possível obter os dados que deveriam ter sido enviados.
	exit('Por favor, preencha o formulário de inscrição!!');
}
// Certifique-se de que os valores de registro carregados não estejam vazios.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	// Um ou mais valores estão vazios..
	exit('Por favor, preencha o formulário de inscrição');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('Email não é valido');
}

if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    exit('Username mão é valido!');
}

if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
	exit('A senha deve ter entre 5 e 20 caracteres!');
}

// Precisamos verificar se a conta com esse nome de usuário existe.
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	// // Parâmetros de ligação (s = string, i = int, b = blob, etc), hash a senha usando a função PHP password_hash.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Armazene o resultado para que possamos verificar se a conta existe no banco de dados.
	if ($stmt->num_rows > 0) {
		// O nome de usuário já existe
		echo  "<script>alert('Nome de usuario já existe, pfv escolha outro!'); location= '../html/register.html'
		</script>";

	} else {
		// O nome de usuário não existe, insira uma nova conta
if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activation_code) VALUES (?, ?, ?, ?)')) {

	// // Não queremos expor senhas em nosso banco de dados, então faça um hash da senha e use password_verify quando um usuário fizer login.
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$uniqid = uniqid();
	$stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $uniqid);
	$stmt->execute();
	$from    = 'noreply@yourdomain.com';
	$subject = 'Account Activation Required';
	$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
	// Atualiza a variável de ativação abaixo
	$activate_link = 'http://yourdomain.com/phplogin/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
	$message = '<p>Clique no link a seguir para ativar sua conta: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
	mail($_POST['email'], $subject, $message, $headers);
	echo  "<script>alert('Usuario cadastrado com sucesso! Pode logar a seguir!'); location= '../php/login.php'
		</script>";
} else {
	// Algo está errado com a instrução sql, verifique se existe uma tabela de contas com todos os 3 campos.
	echo 'Não foi possível preparar a declaração!';
}
	}
	$stmt->close();
} else {
	// // Algo está errado com a instrução sql, verifique se existe uma tabela de contas com todos os 3 campos.
	echo 'Não foi possível preparar a declaração!';
}
$con->close();
?>

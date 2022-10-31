<?php
session_start();
// Altere isso para suas informações de conexão.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';


// Tente conectar usando as informações acima.
$con = mysqli_connect($DATABASE_HOST , $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
    // Se houver um erro com a conexão, pare o script e exiba o erro.
	exit('Falha ao conectar ao MySQL: ' . mysqli_connect_error());
}

// Agora verificamos se os dados do formulário de login foram enviados, isset() verificará se os dados existem.
if ( !isset($_POST['email'], $_POST['password']) ) {
    // Não foi possível obter os dados que deveriam ter sido enviados.
	exit('Por favor, preencha os campos de nome de usuário e senha!');
}

// Prepare nosso SQL, preparando a instrução SQL evitará a injeção de SQL.
if ($stmt = $con->prepare('SELECT id, password, username FROM accounts WHERE email = ?')) {
    // Parâmetros de ligação (s = string, i = int, b = blob, etc), no nosso caso o nome de usuário é uma string, então usamos "s"
	$stmt->bind_param('s', $_POST['email']);
	$stmt->execute();
    // Armazena o resultado para que possamos verificar se a conta existe no banco de dados.
	$stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password, $username);
        $stmt->fetch();
        // A conta existe, agora verificamos a senha.
        // Nota: lembre-se de usar password_hash em seu arquivo de registro para armazenar as senhas com hash.
        if (password_verify($_POST['password'], $password)) {
            // Verificação bem-sucedida! O usuário fez login!
            // Cria sessões, para sabermos que o usuário está logado, elas basicamente agem como cookies, mas lembram dos dados no servidor.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $username;
            $_SESSION['id'] = $id;
            header('Location: home.php');
        } else {
            // Senha incorreta
            header('Location: login.php?error');
        }
    } else {
        // username incorreto
        echo "<script>alert('Usuário e/ou senha inválido(s), Tente novamente!');</script>";
    }


	$stmt->close();
}
?>
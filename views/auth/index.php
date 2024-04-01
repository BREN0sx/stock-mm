<?php
require '../../src/includes/_db.php';
include_once '../../src/includes/jwt/JWT.php';
include_once('../../src/includes/jwt/Key.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = 'ayNf@QY7sF4Lp@83s0pX6xRqEoPkCj2gT2pKtAqVb8lZkVn@q3fAs4hG9oQvWmX';
$error = '';

if(isset($_COOKIE['token'])){
	$decoded = JWT::decode($_COOKIE['token'], new Key($key, 'HS256'));
    header('location: ../map');
} else {
    if (isset($_POST["login"])) {
        if (empty($_POST["user_name"])) {
            $error = 'Por favor insira o nome de usuário';
        } else if (empty($_POST["user_pass"])) {
            $error = 'Por favor insira sua senha';
        } else {

            $user_name = $_POST["user_name"];
            $user_pass = $_POST["user_pass"];

            $query = "SELECT * FROM users WHERE name_user = '$user_name'";
            $result = mysqli_query($db, $query);

            $error = null;

            if ($result) {
                $data = mysqli_fetch_assoc($result);

                if ($data) {
                    if ($data['pass_user'] === $user_pass) {

                        $token = JWT::encode(
                            array(
                                'iat'   =>  time(),
                                'nbf'   =>  time(),
                                'exp'   =>  time() + 3600,
                                'data'  => array(
                                    'id_user'   =>  $data['id_user'],
                                    'name_user' =>  $data['name_user'],
                                    'profile_user' =>  $data['profile_user'],
                                    'admin_user' =>  $data['admin_user']
                                )
                            ),
                            $key,
                            'HS256'
                        );

                        setcookie("token", $token, time() + 3600, "/", "", false, true);
                        header('location: ../map');
                    } else {
                        $error = 'Usuário ou senha incorretos';
                    }
                } else {
                    $error = 'Usuário ou senha incorretos';
                }
            } else {
                $error = 'Falha ao iniciar sessão. Tente novamente';
            }
        }
    }
}
?>

<!doctype html>
<html lang="pt-BR">
  	<head>
    	<meta charset="utf-8">
    	<title>Stock - EEEP Manoel Mano</title>
        <link rel="icon" type="image/x-icon" href="../../src/assets/stock.ico">
        <link rel="stylesheet" href="../../src/css/styles.css">
  	</head>
  	<body>

    <!-- LOADER -->

    <div class="loader"><div class="spin"></div></div>
    <script>
        window.addEventListener("load", () => {
            const loader = document.querySelector(".loader");
            loader.classList.add("loader-hidden");

            loader.addEventListener("transitionend", () => {
                if (document.body.contains(loader)) {
                    document.body.removeChild(loader);
                }
            });
        });
    </script>
        
    	<div class="login-container">
            <div class="login-section">
                <img src="../../src/assets/LogoMM_Stock_White.svg" alt="">
            </div>
            <div class="login-section">
                <h1>Área Restrita</h1>
                <span>Login de acesso
                </span>
                    <form class="login-form" method="post">
                    <div class="danger-input">
                        <?php echo $error;?>
                    </div>
		    					<div class="login-input-box">
			    					<input type="text" name="user_name" class="login-input" placeholder="Usuário" value="admin" required/>
			    				</div>
			    				<div class="login-input-box">
			    					<input type="password" name="user_pass" class="login-input" placeholder="Senha" value="123456" required/>
			    				</div>
			    				<input type="submit" name="login" class="login-btn" value="Acessar" />
		    				</form>
                            </div>
            </div>
    	</div>
  	</body>
</html>
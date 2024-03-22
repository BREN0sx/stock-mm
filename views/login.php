<?php

//index.php
require '../src/includes/_db.php';
include_once '../src/includes/jwt/JWT.php';

use Firebase\JWT\JWT;

$error = '';

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

        if ($result) {
            $data = mysqli_fetch_assoc($result);

            if ($data) {
                if ($data['pass_user'] === $user_pass) {
                    $key = 'ayNf@QY7sF4Lp@83s0pX6xRqEoPkCj2gT2pKtAqVb8lZkVn@q3fAs4hG9oQvWmX';
                    $token = JWT::encode(
                        array(
                            'iat'   =>  time(),
                            'nbf'   =>  time(),
                            'exp'   =>  time() + 20,
                            'data'  => array(
                                'user_id'   =>  $data['user_id'],
                                'user_name' =>  $data['user_name']
                            )
                        ),
                        $key,
                        'HS256'
                    );

                    setcookie("token", $token, time() + 20, "/", "", true, true);
                    header('location:index.php');
                } else {
                    $error = 'Usuário ou senha incorretos';
                }
            } else {
                $error = 'Usuário ou senha incorretos';
            }
        } else {
            $error = 'Erro ao executar a consulta';
        }
    }
}

?>


<!doctype html>
<html lang="en">
  	<head>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

    	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    	<title>Login</title>
  	</head>
  	<body>
    	<div class="container">
    		<div class="row">
    			<div class="col-md-4">&nbsp;</div>
    			<div class="col-md-4">
    				<?php

    				if($error !== '')
    				{
    					echo '<div class="alert alert-danger">'.$error.'</div>';
    				}

    				?>
		    		<div class="card">
		    			<div class="card-header">Login Provisório</div>
		    			<div class="card-body">
		    				<form method="post">
		    					<div class="mb-3">
			    					<label>Usuário</label>
			    					<input type="text" name="user_name" class="form-control" value="admin" />
			    				</div>
			    				<div class="mb-3">
			    					<label>Senha</label>
			    					<input type="password" name="user_pass" class="form-control" value="123456"/>
			    				</div>
			    				<div class="text-center">
			    					<input type="submit" name="login" class="btn btn-primary" value="Login" />
			    				</div>
		    				</form>
		    			</div>
		    		</div>
		    	</div>
	    	</div>
    	</div>
  	</body>
</html>
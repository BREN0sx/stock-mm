<?php
error_reporting(0);
session_start();
?>

<?php 
include_once('../src/includes/jwt/JWT.php');
include_once('../src/includes/jwt/Key.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = 'ayNf@QY7sF4Lp@83s0pX6xRqEoPkCj2gT2pKtAqVb8lZkVn@q3fAs4hG9oQvWmX';

if(isset($_COOKIE['token'])){
	$decoded = JWT::decode($_COOKIE['token'], new Key($key, 'HS256'));
    /* setcookie("token", "", time() - 3600,  "/", "", true, true); */
} else {
	header('location:login.php');
}
?>

<head>
    <title>Lab Stock</title>
    <link rel="icon" type="image/x-icon" href="../src/assets/favicon.ico">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="../src/css/styles.css">
</head>
<body>
<?php 
    $categoria = $_GET['room'];
?>

<style>
    body.locked {
            overflow: hidden;
        }
        .blackScreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: black;
            color: white;
            display: none;
            justify-content: center;
            align-items: center;
            font-size: 24px;
        }
        .centeredGif {
            filter: brightness(3);
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
</style>

<div class="blackScreen" id="blackScreen">
    Orientação Bloqueada. Gire o dispositivo para modo paisagem.
    <img class="centeredGif" src="https://gifs.eco.br/wp-content/uploads/2021/09/imagens-e-gifs-de-vire-o-celular-0.gif" alt="Vire o celular">
</div>

    <script>
        window.addEventListener("load", function() {
            if (window.matchMedia("(orientation: portrait)").matches) {
                document.getElementById("blackScreen").style.display = "flex";
                document.body.classList.add("locked");
            }

            window.addEventListener("orientationchange", function() {
                if (window.orientation === 0) {
                    document.getElementById("blackScreen").style.display = "flex";
                    document.body.classList.add("locked");
                } else {
                    document.getElementById("blackScreen").style.display = "none";
                    document.body.classList.remove("locked");
                }
            });
        });
    </script>


        <nav class="navbar">
            <div class="nav-logo"><img src="../src/assets/Logo/LabStock-Main.png" alt="LabStock"></div>
            <div class="nav-itens">
                <a class="nav-btn <?php echo empty($categoria) ? "nav-active" : ""?>" href="index.php"> Dashboard</a>
                
            </div>
            <div class="nav-user1"> 

            </div>
        </nav>
        <script src="../src/js/changeDisplayUser.js"></script>
        </div>
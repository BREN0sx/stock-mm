<?php
error_reporting(0);
session_start();

include_once('../../src/includes/jwt/JWT.php');
include_once('../../src/includes/jwt/Key.php');
require '../../src/includes/_db.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = 'ayNf@QY7sF4Lp@83s0pX6xRqEoPkCj2gT2pKtAqVb8lZkVn@q3fAs4hG9oQvWmX';

if(isset($_COOKIE['token'])){
	$decoded = JWT::decode($_COOKIE['token'], new Key($key, 'HS256'));
    
    $id_user = $decoded->data->id_user;
    $name_user = $decoded->data->name_user;
    $profile_user = $decoded->data->profile_user;
    $admin_user = $decoded->data->admin_user;
    $loged_user = $decoded->data->loged_user;
    $role_name = $admin_user == 1 ? "Admin" : "Viewer";
} else {
	header('location: ../auth');
}
?>

<!doctype html>
<html lang="pt-BR">
<head>
    <title>Stock Manager - EEEP Manoel Mano</title>
    <link rel="icon" type="image/x-icon" href="../../src/assets/stock.ico">
    
    <meta name="theme-color" content="#00853B">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://stock.eeepmanoelmano.com.br/">
    <meta property="og:site_name" content="Stock Manager">
    <meta property="og:title" content="Stock Manager - EEEP Manoel Mano">
    <meta property="og:image" content="https://i.imgur.com/nNLnE7P.jpeg">

    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://unpkg.com/popper.js@1"></script>
    <script src="https://unpkg.com/tippy.js@5"></script>
    <script src="https://hammerjs.github.io/dist/hammer.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/svg-pan-zoom@3.5.0/dist/svg-pan-zoom.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
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

    <nav class="navbar">
        <div class="nav-logo"><a href="../map"><img src="../../src/assets/LogoMM_Stock_White.svg" alt="LabStock"></a></div>

        <div style="display: flex;align-items: center;">

        <a class="nav-btn toolt" href="../history" title="Histórico"><span class="material-symbols-outlined">timeline</span></a>
        <div class="user-profile" onclick="toggleProfile()">
            <img src="<?php echo $profile_user?>" alt="">
            <div class="user-info">
                <p class="user-name">
                    <?php echo $name_user?>
                </p>
                <p class="user-role">
                    <?php echo $role_name?>
                </p>
            </div>
            <div class="logout-user toolt" title="Sair"> 
                <span class="material-symbols-outlined">logout</span>
                <p>Sair</p>
            </div>
        </div>
        </div>
    </nav>

    <script>
        let profileLogout = document.querySelector(".logout-user");

        let classListProfile = profileLogout.classList;

        const toggleProfile = () => {
            classListProfile.toggle("active");
        }
    </script>

<script>
  $(document).ready(function() {
    $(document).on('mouseenter', '.toolt', function() {
        var tooltipInstance = tippy(this, { 
            followCursor: false,
            arrow: false,
            placement: 'bottom',
            delay: 5,
            distance: 5,
            allowHTML: true,
            theme: 'custom',
            ignoreAttributes: true,
            content(reference) {
                const title = reference.getAttribute('title');
                reference.removeAttribute('title');
                return title;
            }
        });
    });
});
</script>
    <script src="../../src/js/disconnectUser.js"></script>
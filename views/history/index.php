<?php require '../../src/includes/_header.php'?>
<?php require '../../src/includes/_db.php'?>
<body>
<?php
    $user_tab = $_GET['user'];
    if (!isset($_GET['user'])) $user_tab = $id_user;

    $user_query = "SELECT * FROM users WHERE id_user = $user_tab";
    $user_result = mysqli_query($db, $user_query);
    $user = mysqli_fetch_assoc($user_result);

    $userLog_query = "SELECT * FROM history_log WHERE id_user = '$user_tab'";
    $userLog_result = mysqli_query($db, $userLog_query);
    $userLog = mysqli_fetch_assoc($userLog_result);

    $timeLogin = $user['loged_user'];
    
    $role_name = $user['admin_user'] == 1 ? "Admin" : "Viewer";
?>
    <div class="log-container">
        <div class="log-section">
            <div class="main-container">
                <a href="./"><h1>Histórico <span id="item-counter">(<?php echo mysqli_num_rows($userLog_result)?>)</span></h1></a>
            </div>
            <div class="products-interaction">
                <input type="text" id="search_item" name="search_item" placeholder="Pesquisar por código, nome, ação, autor e data" autocomplet="off">
            </div>
            <div class="history-container">
                <div class="history-section"></div>
            </div>
        </div>
            <div class="user-history-section">
                <img src="<?php echo $user['profile_user']?>" alt="user-profile">
                <div class="name-user"><?php echo $user['name_user']?></div>
                <div class="badge-user"><?php echo $role_name?></div>
                <div class="hr-line"></div>
                <div>
                <div class="info-user">
                    <div class="title-info">Atividade</div>
                    <div class="content-info"><?php echo mysqli_num_rows($userLog_result)?> ações realizadas</div>
                </div>
                <div class="info-user">
                    <div class="title-info">Último login</div>
                    <div id="last-login" class="content-info"><?php echo $user['loged_user']?></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
        let user = new URLSearchParams(window.location.search).get('user');
        if (!user) user = undefined;
        load_data();

        function load_data(query) {
            $.ajax({
            url:"../../src/structures/loaders/log_searcher.php",
            method:"POST",
            data:{
            query: query,
            user: user
            },
            success:function(data)
            {
                $('.history-section').html(data);

                let existingScript = document.querySelector('script[src="../../src/js/expandLog.js"]');
                let newScript = document.createElement('script');
                newScript.src = '../../src/js/expandLog.js';

                if (existingScript) {
                    existingScript.parentNode.insertBefore(newScript, existingScript);
                    existingScript.remove();
                }

                document.head.appendChild(newScript); 
            }
            });
        }

        $('#search_item').keyup(function(){
            var search = $(this).val();
            if (search != '') load_data(search);
            else load_data();
        });
        });
    </script>

    <script>
        function momentTime(timestamp, id) {
            moment.locale('pt-br');
            const data = moment(timestamp, "YYYY-MM-DD HH:mm:ss");
            const agora = moment();
            const diferenca = agora.diff(data, 'seconds');
            let lastLogin = "A pouco tempo";
            if (diferenca >= 60) lastLogin = data.fromNow();

            document.getElementById(id).innerText = lastLogin;
            return;
        }
    </script>

    <?php echo "<script>momentTime('".$timeLogin."', 'last-login')</script>"; ?>
</html>
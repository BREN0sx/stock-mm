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

    $activity_query = "SELECT DATE(time_log) AS data, COUNT(*) AS alteracoes FROM history_log WHERE id_user = $user_tab GROUP BY DATE(time_log)";
    $activity_result = mysqli_query($db, $activity_query);

    $data = array();

    $data['0000-00-00'] = '0';
    while($row = $activity_result->fetch_assoc()) {
        $data[$row['data']] = $row['alteracoes'];
    }

    $json_data = json_encode($data);
?>
    <div class="log-container">
        <div class="log-section">
            <div class="main-container">
                <h1>Histórico <span id="item-counter">(<?php echo mysqli_num_rows($userLog_result)?>)</span></h1>
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
                <canvas id="activity-user"></canvas>
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
        var dados_php = <?php echo $json_data; ?>;

        var labels = Object.keys(dados_php);
        var data = Object.values(dados_php);

        if (labels.length === 0) {
            labels.push('Data Inicial');
            data.push(0);
            labels.push('Data Final');
            data.push(0);
        }

        var ctx = document.getElementById('activity-user').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Atividade',
                    data: data,
                    fill: false,
                    borderColor: 'rgb(194 194 194)',
                    tension: .4
                }]
            },
            options: {
                layout: {
                    padding: {
                        top: 20,
                        right: 20,
                        bottom: 20,
                        left: 20
                    }
                },
                responsive: false,
                maintainAspectRatio: false,
                animation: false,
                scales: {
                    x: {
                        display: false
                    },
                    y: {
                        display: false
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
                elements: {
                    point: {
                        radius: 0 
                    }
                },
                interaction: {
                    mode: 'none',
                    intersect: false
                }
            }
        });
    </script>

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
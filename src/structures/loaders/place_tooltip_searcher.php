<?php 
    $sql = "SELECT * FROM places";
    $result = mysqli_query($db, $sql);

    $places = array();
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $places[$row['id_place']] = $row['name_place'];
        }

        echo "<script>";
        echo "var places = " . json_encode($places) . ";";
        echo "</script>";
    }
?>
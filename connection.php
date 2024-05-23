<?php
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'u339836906_syirazman0701');
    define('DB_PASSWORD', 'NurSyahirah_07');
    define('DB_DATABASE', 'u339836906_unischedusm');
    $conn = mysqli_connect (DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>
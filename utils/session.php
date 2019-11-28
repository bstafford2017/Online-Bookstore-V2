<?php
    session_start();
    $data = json_decode(file_get_contents("php://input"));
    $_SESSION['username'] = $data->username;
?>
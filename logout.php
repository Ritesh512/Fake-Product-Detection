<?php
    include 'redirection.php';
    session_start();
    unset( $_SESSION['role'] );
    unset( $_SESSION['username'] );
    unset( $_SESSION['email'] );
    redirect('index.php');
?>
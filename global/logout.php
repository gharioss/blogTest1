<?php
session_start();
session_destroy();
header('location: ../connexion/login.php');
exit;

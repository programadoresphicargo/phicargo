<?php

session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: https://www.phicargo-sistemas.online/");
    exit();
}

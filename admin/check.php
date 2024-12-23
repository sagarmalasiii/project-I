<?php
session_start();
if ($_SESSION['username'] == true) {
} else {
    header("Location: login.php");
}

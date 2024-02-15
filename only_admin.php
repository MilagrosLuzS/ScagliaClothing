<?php
session_start();

if (empty($_SESSION["user"]) || $_SESSION["id_user_role"] != 1) {
  header('Location:index.php');
}

?>
<?php
session_start();

if (empty($_SESSION["user"]) || $_SESSION["id_user_role"] != 2) {
  header('Location: index.php');
}

?>
<?
  session_start();
  unset($_SESSION['usuario']); 
  unset($_SESSION['password']);
  unset($_SESSION['verificado']);
  session_destroy();
  header("Location: login.php");
  exit;
?>
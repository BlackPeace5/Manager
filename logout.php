<?php
	session_start(); // обязательно стартуем сессию, чтобы с ней далее работать
	$_SESSION['auth'] = null;
  header('Location: /');
?>

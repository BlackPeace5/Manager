<?php
session_start();
require_once("config/connection.php"); //Подключение файла с бд
if($_POST['submit']){
  if(!empty($_POST['password']) and !empty($_POST['login'])) {

  $login = mysqli_real_escape_string($conn, $_POST['login']);
  $pass = mysqli_real_escape_string($conn, $_POST['password']);

	$query = "SELECT * FROM `users` WHERE Login='$login'"; // получаем юзера по логину
	$result = mysqli_query($conn, $query);
	$user = mysqli_fetch_assoc($result);

  if (!empty($user)) {
		$hash = $user['password']; // соленый пароль из БД
		// Проверяем соответствие хеша из базы введенному паролю
		if (password_verify($pass, $hash)) {
      $_SESSION['auth'] = true;
      header('Location: /manager.php');
		} else {
			echo "Неверный логин или пароль!";
		}
	} else {
		echo "Такого пользователя нет!";
	}
} else {
  echo "Внесены не все данные!";
}}
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="/Css/style.css" type="text/css"/>
  </head>
  <header>
    <h1>Авторизация</h1>
  </header>
  <body>
    <form id="Authorization" title="Authorization" action="login.php" method="post">
      <label class="label">Логин</label><br>
      <input id="login" type="text" name="login" size="20" maxlength= "50"><br>
      <lebel class="label">Пароль</lebel><br>
      <input id="password" name="password" type="password" size="20" maxlength= "50"><br>
      <input type="submit" name="submit" id="submit" value="Войти">
    </form>
  </body>
  <footer>
    Copyright (c) 2020 Copyright Holder All Rights Reserved.
  </footer>
</html>

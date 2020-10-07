<?php
require_once("config/connection.php"); //Подключение файла с бд

if($_POST['submit']){
  if(!empty($_POST['password']) and !empty($_POST['login'])) {

    $login = mysqli_real_escape_string($conn, $_POST['login']);
    $temp_pass = mysqli_real_escape_string($conn, $_POST['password']);
    $query = "SELECT * FROM users WHERE login='$login'"; // получаем юзера по логину
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

	   if (!empty($user)) {
       echo "Пользователь с таким логином существует!";
     } else {
       $password = password_hash($temp_pass, PASSWORD_DEFAULT);
       $result = mysqli_query($conn, "INSERT INTO `users` (login, password) VALUES ('$login', '$password')") or die("Connection failed: " . mysqli_connect_error()); //Запрос добавления данных

      echo "Вы успешно зарегистрировались!";

     }
  } else {
    echo "Упс, что-то пошло не так";
  }
}
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="/Css/style.css" type="text/css"/>
  </head>
  <header>
    <h1>Регистрация</h1>
  </header>
  <body>
    <form id="register" title="register" action="register.php" method="post">
      <label class="label">Логин</label><br>
      <input id="login" type="text" name="login" size="20" maxlength= "50"><br>
      <lebel class="label">Пароль</lebel><br>
      <input id="password" name="password" type="password" size="20" maxlength= "50"><br>
      <input type="submit" name="submit" id="submit" value="Зарегистрироваться">
    </form>
  </body>
  <footer>
    Copyright (c) 2020 Copyright Holder All Rights Reserved.
  </footer>
</html>

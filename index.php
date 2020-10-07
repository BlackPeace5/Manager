<?php
require_once("config/connection.php"); //Подключение файла с бд

//$select_db = mysqli_select_db($conn, $db);
if ($_POST['submit']){ //Нажатие на кнопку отправки данных
  if (!empty($_POST["theme"]) && !empty($_POST["fullname"]) && !empty($_POST["phone"]) && !empty($_POST["adress"]) && !empty($_POST["email"]) && !empty($_POST["description"])) {
  //Эканирование данных
  $theme = mysqli_real_escape_string($conn, $_POST["theme"]);
  $fullname = mysqli_real_escape_string($conn, $_POST["fullname"]);
  $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
  $adress = mysqli_real_escape_string($conn, $_POST["adress"]);
  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $desc = mysqli_real_escape_string($conn, $_POST["description"]);
  $date = mysqli_real_escape_string($conn, $_POST["date"]);

  $result = mysqli_query($conn, "INSERT INTO `requests` (FullName, Address, Email, Phone, Date_, Theme, Description) VALUES ('$fullname', '$adress', '$email', '$phone', '$date', '$theme', '$desc')") or die("Connection failed: " . mysqli_connect_error()); //Запрос добавления данных

  echo "<h5 style=color:green>Заявка отправлена!</h5>";

  } else {
  echo "<h5 style=color:red>Проверьте правильность заполненных полей!</h5>";
  }
}
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>Заявка</title>
    <link rel="stylesheet" href="/Css/style.css" type="text/css"/>
  </head>
  <header>
    <h1>Прием ваших заявок</h1>
  </header>
  <body>
    <form id="newrequest" title="newrequest" action="index.php" method="post">
      <label class="label">Тема</label><br>
      <input type="text" name="theme" id="theme" size="20" maxlength="100"/><br>
      <lebel class="label">ФИО</lebel><br>
      <input type="text" name="fullname" id="fullname" size="20" maxlength="255"/><br>
      <lebel class="label">Адрес</lebel><br>
      <input type="text" name="adress" id="adress" size="20" maxlength="255"/><br>
      <lebel class="label">Телефон</lebel><br>
      <input type="text" name="phone" id="phone" size="20" maxlength="25"/><br>
      <lebel class="label">Почта</lebel><br>
      <input type="text" name="email" id="email" size="20" maxlength="50"/><br>
      <lebel class="label">Описние</lebel><br>
      <textarea name="description" id="description" cols="25" rows="5"></textarea><br>
      <input type="hidden" name="date" id="date" value="<?php echo date("Y-m-d"); ?>"/><br>
      <input type="submit" name="submit" id="submit" value ="Отпраить"/>
    </form>
  </body>
  <footer>
    Copyright (c) 2020 Copyright Holder All Rights Reserved.
  </footer>
</html>

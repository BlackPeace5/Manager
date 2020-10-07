<?php
session_start();
require_once("config/connection.php");
if (!empty($_SESSION['auth'])) {
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>Заявки</title>
    <link rel="stylesheet" href="/Css/style.css" type="text/css"/>
  </head>
  <header>
    <h1>Управление</h1>
  </header>
  <body>
    <div class="wrapper">
      <aside class="left">
        <form id="filter" title="filter" action="manager.php" method="get">
          <fieldset>
            <legend>Фильтр</legend>
            <label>Содержит слово</label><br>
            <input type="search" name="searchtext" id="searchtext" size="30" maxlength="255" /><br>
            <button type="submit" name="search" id="search" value="search">Поиск</button>
          </fieldset>
        </form>
      </aside>
      <?php
      if($_GET['search'])
      {
        $search = mysqli_real_escape_string($conn, $_GET['searchtext']);
        $select_request = mysqli_query($conn, "SELECT *  FROM `requests` WHERE FullName LIKE '%$search%' OR Theme LIKE '%$search%'") or die("Connection failed: " . mysqli_connect_error());
        echo "<table><tr><th>Id</th><th>ФИО</th><th>Тема</th><th>Дата</th></tr>";
        while ($row = mysqli_fetch_row($select_request)) {
            echo "<tr><td>$row[0]</td>";
            echo "<td><a href=?request=$row[0]>$row[1]</td></a>";
            echo "<td>$row[6]</td>";
            echo "<td>$row[5]</td></tr>";
        }
        echo "</table>";
      } else {
        $select_request = mysqli_query($conn, "SELECT * FROM `requests`");
        echo "<table><tr><th>Id</th><th>ФИО</th><th>Тема</th><th>Дата</th></tr>";
        while ($row = mysqli_fetch_row($select_request)) {
            echo "<tr><td>$row[0]</td>";
            echo "<td><a href=?request=$row[0]>$row[1]</td></a>";
            echo "<td>$row[6]</td>";
            echo "<td>$row[5]</td></tr>";
        }
        echo "</table>";
      }
      ?>
      <aside class="right">
        <?php
        if(is_numeric($_GET['request'])){
          $id = mysqli_real_escape_string($conn, $_GET['request']);
          $select_request = mysqli_query($conn, "SELECT * FROM requests WHERE id = '$id'");
          $row = mysqli_fetch_array($select_request);
        }

        //Обработка кнопки редактирования
        if($_POST['edit']) {
          if (!empty($_POST["theme"]) && !empty($_POST["fullname"]) && !empty($_POST["phone"]) && !empty($_POST["adress"]) && !empty($_POST["email"]) && !empty($_POST["description"]) && !empty($_POST["date"])) {
          //Эканирование данных
          $theme = mysqli_real_escape_string($conn, $_POST["theme"]);
          $fullname = mysqli_real_escape_string($conn, $_POST["fullname"]);
          $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
          $adress = mysqli_real_escape_string($conn, $_POST["adress"]);
          $email = mysqli_real_escape_string($conn, $_POST["email"]);
          $desc = mysqli_real_escape_string($conn, $_POST["description"]);
          $date = mysqli_real_escape_string($conn, $_POST["date"]);

          $update_result = mysqli_query($conn, "UPDATE `requests` SET FullName = '$fullname', Address = '$adress', Email = '$email', Phone = '$phone', Date_ = '$date', Theme = '$theme', Description = '$desc' WHERE id = '$id'") or die("Connection failed: " . mysqli_connect_error());

          echo "<meta http-equiv='refresh' content='0'>";
          echo "Данные успешно обнавлены!";
        }else {
          echo "Данные не были изменены";
        }}

        //Обработка кнопки удаления
        if($_POST['delete'])
        {
          $result = mysqli_query($conn, "DELETE FROM `requests` WHERE id = '$id'") or die("Connection failed: " . mysqli_connect_error());;
          echo "<meta http-equiv='refresh' content='0'>";
          echo "Данные успешно удалены!";
        }
        ?>

        <form id="editrequest" title="editrequest" action="manager.php?request=<?php echo $row['id'] ?>" method="post">
          <fieldset>
            <legend>Данные</legend>
            <label>ФИО</label><br>
            <input type="text" name="fullname" id="fullname" size="30" maxlength="255" value="<? echo $row['FullName'] ?>"/><br>
            <label>Адрес</label><br>
            <input type="text" name="adress" id="adress" size="30" maxlength="255" value="<? echo $row['Address'] ?>"/><br>
            <label>Почта</label><br>
            <input type="text" name="email" id="email" size="30" maxlength="50" value="<? echo $row['Email'] ?>"/><br>
            <label>Телефон</label><br>
            <input type="text" name="phone" id="phone" size="30" maxlength="25" value="<? echo $row['Phone'] ?>"/><br>
            <label>Дата</label><br>
            <input type="text" name="date" id="date" size="30" value="<? echo $row['Date_'] ?> "/><br>
            <label>Тема</label><br>
            <input type="text" name="theme" id="theme" size="30" maxlength="100" value="<? echo $row['Theme'] ?>"/><br>
            <label>Описание</label>
            <br><textarea name="description" id="description" cols="30" rows="5"><?php echo $row['Description']?></textarea><br><br>
            <button type="submit" name="edit" id="edit" value="edit">Изменить</button>
            <button type="submit" name="delete" id="delete" value="delete">Удалить</button>
        </fieldset>
      </form>
      </aside>
    </div>

  <?php } else {
    header('Location: /');
  }
  ?>
  </body>
  <footer>
    <h3>Copyright (c) 2020 Copyright Holder All Rights Reserved.</h3>
    <h3><a href="/logout.php">Выйти!</a></h3>
  </footer>
  </html>

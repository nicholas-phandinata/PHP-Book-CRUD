<?php session_start(); include "Book.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Home</title>

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
      <div class="container" style="margin-top: 40px;">
      <a href="add.php" class="btn btn-sm btn-success">Add book</a>
      <form action="index.php" method="POST" style="display: inline;">
            <input type="submit" name="reset" value="Reset" class="btn btn-sm btn-warning">
      </form>
      <br>
      <?php
            if (!isset($_SESSION['numBook'])) {
                  $_SESSION['numBook'] = 3;
                  $_SESSION['bookArray'] = array('book1', 'book2', 'book3');
                  $_SESSION['title'] = array('Harry Potter', 'Hunger Games', 'Maze Runner');
                  $_SESSION['author'] = array('JK Rowling', 'Collins', 'Steve');
                  $_SESSION['pages'] = array(400, 450, 500);
            } 

            if (isset($_POST['booktitle'])){
                  $_SESSION['numBook']++;
                  $bookNum = 'book'.$_SESSION['numBook'];
                  array_push($_SESSION['bookArray'],$bookNum);
                  array_push($_SESSION['title'],$_POST['booktitle']);
                  array_push($_SESSION['author'],$_POST['bookauthor']);
                  array_push($_SESSION['pages'],$_POST['bookpages']);
                  // print_r($_SESSION['bookArray']);
                  // echo "<br>";
                  // print_r($_SESSION['title']);
                  // echo "<br>";
                  // print_r($_SESSION['author']);
                  // echo "<br>";
                  // print_r($_SESSION['pages']);
                  // echo "<br>";
            }

            if (isset($_POST['reset'])) {
                  session_destroy();
                  echo("<meta http-equiv='refresh' content='0'>");
            }

            $bookSubject = array("title", "author", "pages");
            
            echo "<br>";
      ?>

            <div class='container mt-5'>
            <table class='table table-sm table-condensed table-striped'>
                  <thead>
                        <th>ID</th>
                        <th>Book Title</th>
                        <th>Book Author</th>
                        <th>Book Pages</th>
                        <th>Edit</th>
                        <th>Delete</th>
                  </thead>

      <?php
            for ($y = 1; $y <= $_SESSION['numBook']; $y++) {
                  $getBookNum = $_SESSION['bookArray'][$y-1];
                  if ($getBookNum) {
                        $$getBookNum = new Book;
                        // echo "Book $y: ";
                        echo 
                        "
                              <tbody>
                                    <tr>
                                          <td>$y</td>
                        ";
                        for ($x = 0; $x < count($bookSubject); $x++) {
                              $subject = $bookSubject[$x];
                              // $whichBook = 'book'.$y; //concatenate string with int
                              $$getBookNum->$subject = $_SESSION[$subject][$y-1];
                              $bookInfo = $$getBookNum->$subject;
                              if ($x < count($bookSubject)-1) {
                                    echo "<td>$bookInfo</td>";
                              } else {
                                    echo 
                                    "
                                          <td>$bookInfo</td>
                                          <td><a href='update.php?bookId=$y' class='btn btn-sm btn-info'>Edit</a></td>
                                          <td><form method='post'>
                                                <input type='hidden' name='delete' value='$y'>
                                                <input type='submit' value='delete' class='btn btn-sm btn-danger'>
                                              </form>
                                          </td>
                                    ";
                              }
                        }
                        echo 
                        "
                                    </tr>
                              </tbody>
                        ";
                  }
            };

            if (isset($_POST['delete'])) {
                  $id = $_POST['delete'];
                  // echo "Delete order $id";
                  unset($_SESSION['bookArray'][$id-1]);
                  unset($_SESSION['title'][$id-1]);
                  unset($_SESSION['author'][$id-1]);
                  unset($_SESSION['pages'][$id-1]);
                  echo "<meta http-equiv='refresh' content='0'>";
            }

            if (isset($_POST['updatebookid'])) {
                  $id = $_POST['updatebookid'];
                  // echo "Update order $id";
                  $_SESSION['title'][$id] = $_POST['updatebooktitle'];
                  $_SESSION['author'][$id] = $_POST['updatebookauthor'];
                  $_SESSION['pages'][$id] = $_POST['updatebookpages'];
                  echo "<meta http-equiv='refresh' content='0'>";
            }
      ?>
      </div>
</body>
</html>
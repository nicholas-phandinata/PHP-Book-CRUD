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
      <style>
            tr.spaceUnder>td {
                  padding-bottom: 1em;
            }
      </style>
</head>
<body>
      <div class="container" style="margin-top: 40px;">

      <div style="float: right;">
      <!-- <a href="add.php" class="btn btn-sm btn-success">Add book</a> -->
      <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalAddBook">
      Add book
      </button>
      <form action="index.php" method="POST" style="display: inline;">
            <input type="submit" name="deleteAll" value="Delete All" class="btn btn-sm btn-danger">
      </form>
      <form action="index.php" method="POST" style="display: inline;">
            <input type="submit" name="reset" value="Reset" class="btn btn-sm btn-warning">
      </form>
      </div>
      
      <div style="margin-left: 20px;">
      <form action="index.php" method="POST">
            <input type="text" name="keyword" placeholder="Search here" size="45">
            <input type="submit" name="Submit" value="Search" class="btn btn-sm btn-info">
      </form>
      </div>

      <!-- Modal -->
		<div class="modal fade" id="modalAddBook" tabindex="-1"
			role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document" style="max-width: 28%;">
				<div class="modal-content" style="height: 250px;">
					<div class="modal-header">
						<h4 class="modal-title" id="exampleModalLabel">Add a new book</h4>
					</div>
					<div class="modal-body">
                              <div class="container-sm">
                              <form action="index.php" method="POST">
                                    <table>
                                    <tr class="spaceUnder">
                                          <td style="padding-right: 25px;">Book Title: </td>
                                          <td><input type="text" name="booktitle" size="45"></td>
                                    </tr>
                                    <tr class="spaceUnder">
                                          <td>Book Author: </td>
                                          <td><input type="text" name="bookauthor" size="30"></td>
                                    </tr>
                                    <tr class="spaceUnder">
                                          <td>Book Pages: </td>
                                          <td><input type="number" name="bookpages" style="width: 5em"></td>
                                    </tr>
                                    </table>
                                    <table style="float: right; margin-top: 12px;">
                                    <tr>
                                          <td style="padding-right: 5px;"><button type="button" class="btn btn-warning btn-sm" 
                                          data-dismiss="modal" style="width: 100px;">Cancel</button></td>
                                          <td><button type="submit" class="btn btn-info btn-sm"
							style="width: 100px;">Create</button></td>
                                    </tr>
                                    </table>
                              </form>
                              </div>
					</div>
				</div>
			</div>
		</div>

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
                  <tbody>

      <?php
            for ($y = 1; $y <= $_SESSION['numBook']; $y++) {
                  if (!isset($_SESSION['matches'])) {
                        $getBookNum = $_SESSION['bookArray'][$y-1];
                        if ($getBookNum) {
                              $$getBookNum = new Book;
                              // echo "Book $y: ";
                              echo 
                              "
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
                                          $subjectAuthor = $bookSubject[$x-1];
                                          $subjectTitle = $bookSubject[$x-2];
                                          $bookInfoTitle = $$getBookNum->$subjectTitle;
                                          $bookInfoAuthor = $$getBookNum->$subjectAuthor;
                                          $bookInfoPages = $bookInfo;
                                          $id = $y - 1;
                                          echo 
                                          "
                                                <td>$bookInfoPages</td>
                                                <td>
                                                <button type='button' class='btn btn-sm btn-info' data-toggle='modal' data-target='#modalEditBook$id'>
                                                Edit
                                                </button>
                                                <div class='modal fade' id='modalEditBook$id' tabindex='-1'
                                                role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                <div class='modal-dialog' role='document' style='max-width: 28%;'>
                                                      <div class='modal-content' style='height: 250px;'>
                                                            <div class='modal-header'>
                                                                  <h4 class='modal-title' id='exampleModalLabel'>Edit Book</h4>
                                                            </div>
                                                            <div class='modal-body'>
                                                            <div class='container-sm'>
                                                            <form action='index.php' method='POST'>
                                                                  <input type='hidden' name='updatebookid' value='$id'>
                                                                  <table>
                                                                  <tr class='spaceUnder'>
                                                                        <td style='padding-right: 25px;'>Book Title: </td>
                                                                        <td><input type='text' name='updatebooktitle' size='45' value='$bookInfoTitle'></td>
                                                                  </tr>
                                                                  <tr class='spaceUnder'>
                                                                        <td>Book Author: </td>
                                                                        <td><input type='text' name='updatebookauthor' size='30' value='$bookInfoAuthor'></td>
                                                                  </tr>
                                                                  <tr class='spaceUnder'>
                                                                        <td>Book Pages: </td>
                                                                        <td><input type='number' name='updatebookpages' style='width: 5em' value='$bookInfoPages'></td>
                                                                  </tr>
                                                                  </table>
                                                                  <table style='float: right; margin-top: 12px;'>
                                                                  <tr>
                                                                        <td style='padding-right: 5px;'><button type='button' class='btn btn-warning btn-sm' 
                                                                        data-dismiss='modal' style='width: 100px;'>Cancel</button></td>
                                                                        <td><button type='submit' class='btn btn-info btn-sm'
                                                                        style='width: 100px;'>Update</button></td>
                                                                  </tr>
                                                                  </table>
                                                            </form>
                                                            </div>
                                                            </div>
                                                      </div>
                                                </div>
                                                </div>
                                                </td>
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
                              ";
                        }
                  } else {
                        foreach($_SESSION['matches'] as $k=>$v) {
                              if($k == $y-1) {
                                    $getBookNum = $_SESSION['bookArray'][$k];
                                    $$getBookNum = new Book;
                                    // $searchData = $_SESSION['matches'][$k];
                                    // echo "$y, $searchData, $getBookNum  <br>";
                                    echo 
                                    "
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
                                                $subjectAuthor = $bookSubject[$x-1];
                                                $subjectTitle = $bookSubject[$x-2];
                                                $bookInfoTitle = $$getBookNum->$subjectTitle;
                                                $bookInfoAuthor = $$getBookNum->$subjectAuthor;
                                                $bookInfoPages = $bookInfo;
                                                $id = $y - 1;
                                                echo 
                                                "
                                                      <td>$bookInfoPages</td>
                                                      <td>
                                                      <button type='button' class='btn btn-sm btn-info' data-toggle='modal' data-target='#modalEditBook$id'>
                                                      Edit
                                                      </button>
                                                      <div class='modal fade' id='modalEditBook$id' tabindex='-1'
                                                      role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                      <div class='modal-dialog' role='document' style='max-width: 28%;'>
                                                            <div class='modal-content' style='height: 250px;'>
                                                                  <div class='modal-header'>
                                                                        <h4 class='modal-title' id='exampleModalLabel'>Edit Book</h4>
                                                                  </div>
                                                                  <div class='modal-body'>
                                                                  <div class='container-sm'>
                                                                  <form action='index.php' method='POST'>
                                                                        <input type='hidden' name='updatebookid' value='$id'>
                                                                        <table>
                                                                        <tr class='spaceUnder'>
                                                                              <td style='padding-right: 25px;'>Book Title: </td>
                                                                              <td><input type='text' name='updatebooktitle' size='45' value='$bookInfoTitle'></td>
                                                                        </tr>
                                                                        <tr class='spaceUnder'>
                                                                              <td>Book Author: </td>
                                                                              <td><input type='text' name='updatebookauthor' size='30' value='$bookInfoAuthor'></td>
                                                                        </tr>
                                                                        <tr class='spaceUnder'>
                                                                              <td>Book Pages: </td>
                                                                              <td><input type='number' name='updatebookpages' style='width: 5em' value='$bookInfoPages'></td>
                                                                        </tr>
                                                                        </table>
                                                                        <table style='float: right; margin-top: 12px;'>
                                                                        <tr>
                                                                              <td style='padding-right: 5px;'><button type='button' class='btn btn-warning btn-sm' 
                                                                              data-dismiss='modal' style='width: 100px;'>Cancel</button></td>
                                                                              <td><button type='submit' class='btn btn-info btn-sm'
                                                                              style='width: 100px;'>Update</button></td>
                                                                        </tr>
                                                                        </table>
                                                                  </form>
                                                                  </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      </div>
                                                      </td>
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
                                    ";
                              }
                        }
                  }
            };
      ?>

      <?php

            if (isset($_POST['delete'])) {
                  $id = $_POST['delete'];
                  // echo "Delete order $id";
                  unset($_SESSION['bookArray'][$id-1]);
                  unset($_SESSION['title'][$id-1]);
                  unset($_SESSION['author'][$id-1]);
                  unset($_SESSION['pages'][$id-1]);
                  echo "<meta http-equiv='refresh' content='0'>";
            }

            if (isset($_POST['deleteAll'])) {
                  $_SESSION['bookArray'] = array();
                  $_SESSION['title'] = array();
                  $_SESSION['author'] = array();
                  $_SESSION['pages'] = array();
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

            if (isset($_POST['keyword'])) {
                  $searchword = $_POST['keyword'];
                  if ($searchword) {
                        $_SESSION['matches'] = array();
                        foreach($_SESSION['title'] as $k=>$v) {
                              if(preg_match("/$searchword/i", $v)) {
                                    $_SESSION['matches'][$k] = $v;
                              }
                        }
                        echo "<meta http-equiv='refresh' content='0'>";
                  } else {
                        unset($_SESSION['matches']);
                        echo "<meta http-equiv='refresh' content='0'>";
                  }
            }
      ?>
      </div>
      </div>
</body>
</html>
<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Update Book</title>
</head>
<body>
      <?php 
            $id = $_GET['bookId'] - 1;
            $bookTitle = $_SESSION['title'][$id];
            $bookAuthor = $_SESSION['author'][$id];
            $bookPages = $_SESSION['pages'][$id];
      ?>
      <form action="index.php" method="POST">
            <input type='hidden' name='updatebookid' value="<?php echo $id;?>">
            Book Title: <input type="text" name="updatebooktitle" value="<?php echo $bookTitle; ?>"><br>
            Book Author: <input type="text" name="updatebookauthor" value="<?php echo $bookAuthor; ?>"><br>
            Book Pages: <input type="number" name="updatebookpages" value="<?php echo $bookPages; ?>"><br>
            <input type="submit">
      </form>
</body>
</html>
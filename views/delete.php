<?php
include 'dbconn.php';


$id = $_GET['Id'];


$sql = "DELETE FROM product WHERE Id='$id'";


if ($conn->query($sql) === True) {
  header("Location: addproductlist.php");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();

<!DOCTYPE html>
<?php
session_start();
include("config.php");

$sql = "UPDATE tourist_spot SET name='".$_POST['tname']."', address='".$_POST['address']." ".$_POST['address2']."', number='".$_POST['number']."', homepage='".$_POST['homepage']."', introduction='".$_POST['introduction']."' WHERE tid='".$_GET['tid']."'";
$result = mysqli_query($conn, $sql);
if(!$result) {
  echo '<script>alert("오류가 발생했습니다.'.$sql.'");</script>';
  echo '<script>location.replace("./list-surrounding.php")</script>';
}
else {
  $target_file = "";
  for($i=0; $i < count($_FILES["files"]["name"]); $i++) {
    if(basename($_FILES["files"]["name"][$i]) != '') {
      $target_dir = "../uploads/";
      $target_file = $target_dir.microtime()._.basename($_FILES["files"]["name"][$i]);
      $uploadOk = 1;
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
      // Check if image file is a actual image or fake image
      if(isset($_POST["submit"])) {
          $check = getimagesize($_FILES["files"]["tmp_name"][$i]);
          if($check !== false) {
              $uploadOk = 1;
          } else {
              echo "File is not an image.";
              $uploadOk = 0;
          }
      }
      while (file_exists($target_file)) {
          $target_file = md5(microtime()).$target_file;
      }
      $target_file = preg_replace("/\s+/","",$target_file); //공백 제거

      // Check file size
      if ($_FILES["files"]["size"][$i] > 1000000) {
          echo "Sorry, your file is too large.";
          $uploadOk = 0;
      }
      if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
      } else {
          if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_file)) {

          } else {
              echo "Sorry, there was an error uploading your file.";
          }
      }
    }
    $array = explode("../", $target_file);
    if($array[1] != '') {
      $sql = "INSERT INTO tourist_spot_image (tid, image) VALUES('".$_GET['tid']."', '".$array[1]."')";
      $result = mysqli_query($conn, $sql);
    }

  }

  echo '<script>alert("수정이 완료되었습니다.");</script>';
  echo '<script>location.replace("./modify-surrounding.php?tid='.$_GET['tid'].'")</script>';
}

?>

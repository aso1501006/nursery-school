<?php
  require_once(dirname(__FILE__)."/include/session.php");
  require_once(dirname(__FILE__)."/class/DBManager.php");
  $nursery_school_id = $_SESSION['nursery_school_id'];
  $DBManager = new DBManager();
  $Data = $DBManager->tag_select_all($nursery_school_id);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
<link rel="stylesheet" href="./css/Upload.css">
<title>画像をアップロードする</title>
<script type="text/javascript" src="./js/PhotoUpload.js"></script>

</head>
<body background="./img/back.jpg">
  <div id="wrapper">
    <!--画像をアップロードするフォームを作る-->
    <form action="" id="form1" method="post" enctype="multipart/form-data"> 
      <div class="center">
        <p><font size="10">がぞ～あっぷろ～ど</font></p>
          <img alt="" src="./img/UploadPhotoImg.jpeg"><br>
          <font class="tag">たぐ:</font>
          <select class="tagselect" id="tagselect" name="tagselect">
            <option value=0 selected>みにゅうりょく</option>
            <?php
              for($i = 0; $i < count($Data); $i++){
                echo '<option value="' . $Data[$i]->tag_id . '">' . $Data[$i]->tag_name . '</option>';
              }
            ?>
          </select>
          <input id="upload" type="button" value="あっぷろ～ど">
          <br>
      </div>
      <div class="center2">
        <div id="dropAria" draggable="false">
          <input type="file" id="file" name="files[]" multiple>
          <br class="text"><font class="text" size="5">ここにどらっぐあんどどろっぷ！</font>
          <div id="fileView">
          </div>
        </div> 
      </div>
    </form>
  </div>
  <div id="loading">
      <span id="status"></span>
      <div><img src="./img/loading.gif" alt=""></div>
      <span id="result"></span>
  </div>
</body>
</html>

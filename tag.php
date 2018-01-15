<?php
session_start();
if($_SESSION['kubun'] == 'nursery_school'){

  require_once dirname(__FILE__)."/class/TagManager.php";
  $TM = new TagManager();

  if(!empty($_POST['text-add'])){
    $TM->tag_insert(htmlspecialchars($_POST['text-add']));
    echo '<script type="text/javascript">alert("ついかしました");</script>';
  } else if(!empty($_POST['text-edit'])){
    if($_POST['seledi'] != 0){
      $TM->tag_edit(htmlspecialchars($_POST['seledi']),htmlspecialchars($_POST['text-edit']));
      echo '<script type="text/javascript">alert("こうしんしました");</script>';
    }
  } else if(!empty($_POST['seldel'])){
    if($_POST['seldel'] != 0){
      $TM->tag_delete(htmlspecialchars($_POST['seldel']));
      echo '<script type="text/javascript">alert("さくじょしました");</script>';
    }
  }

  $select = $TM->tag_select_all();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>タグ編集</title>
<link rel="stylesheet" type="text/css" href="./css/tag.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
<script type="application/javascript">
$(document).ready(function(){
  $(document).on('click','#top',function(){
    window.location.href = "./top.php";
  });
});
</script>
</head>
<body>
<div class="body">
<section>
<div id="top" class="home"></div>
<div class="title">タグへんしゅう</div>
</section>

<!--タグ追加-->
<section class="section">
  <div class="wd">
    <div class="head-add">タグついか</div>
    <div class="ex">ついかしたいタグをにゅうりょくしてください</div>
    <form method="post">
      <span><input type="text" class="text" name="text-add" maxlength="30"></span>
      <span><button type="submit" value="タグついか" class="tag-add">タグついか</span>
    </form>
  </div>
</section>

<!--タグ編集-->
<section class="section">
  <div class="wd">
    <div class="head-edit">タグこうしん</div>
    <div class="ex">こうしんしたいタグをせんたくしてください</div>
    <div class="tag-center">
      <form method="post">
        <select class="event" name="seledi">
          <option value="0" selected="true">⇩せんたくしてください</option>
          <?php
          foreach($select as $sel){
            $tag_id = $sel->tag_id;
            $tag_name = $sel->tag_name;
            echo '<option value="' . $tag_id . '">' . $tag_name . '</option>';
          }
          ?>
        </select>
        <div class="ex">あたらしいタグをにゅうりょくしてください</div>
        <span><input type="text" class="text" name="text-edit" maxlength="30"></span>
        <span><button type="submit" value="タグこうしん" class="tag-edit">タグこうしん</span>
      </form>
    </div>
  </div>
</section>

<!--タグ削除-->
<section class="section">
  <div class="wd">
    <div class="head-delete">タグさくじょ</div>
    <div class="ex">さくじょしたいタグをせんたくしてください</div>
    <div class="tag-center">
      <form method="post">
        <select class="event" name="seldel">
          <option value="0" selected="true">⇩せんたくしてください</option>
          <?php
            foreach($select as $sel){
              $tag_id = $sel->tag_id;
              $tag_name = $sel->tag_name;
              echo '<option value="' . $tag_id . '">' . $tag_name . '</option>';
            }
          ?>
        </select>
      <span><button type="submit" value="タグさくじょ" class="tag-delete">タグさくじょ</span>
      </from>
    </div>
  </div>
</section>
</div>
</body>

</head>
</html>

<?php
} else {
echo "アクセス権がありません";
}
?>
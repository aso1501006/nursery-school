<?php
require_once dirname(__FILE__)."/class/UserManager.php";
require_once dirname(__FILE__)."/class/FileManager.php";
require_once dirname(__FILE__)."/class/MoviePhotoTblDT.php";
session_start();
if((!empty($_POST['user'])) && (!empty($_POST['password']))){
    $reg = new UserManager;
    $user = htmlspecialchars($_POST['user'], ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
    $reg->user_parents_login($user,$password);
} else {

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>保護者ログインページ</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/jquery-3.2.1.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./css/original.css">
</head>
<body>
    <div class="container">
	<div class="login-container">
    <img width="50%"; src="./img/W86G9.png" title="caption1" style="margin-bottom:30px;"/>
            <div class="form-box">
                <form method="POST">
                    <input name="user" type="text" placeholder="parent_id">
                    <input type="password" name="password" placeholder="password">
                    <button class="btn btn-info btn-block login" type="submit" >Login</button>
                </form>
            </div>
        </div>

        
        
</div>
</body>
</html>
<?php }
        /*function nursery_phot(){
            $flm = new FileManager();
            $nst = new MoviePhotoTblDT();
            $nursery_school_id = $_SESSION['nursery_school_id'];
            $list = $flm->get_nursery_photo_select($nursery_school_id);
            $count = 0;
            foreach($list as $a ){
                $b = $a->path;
                $count++;
                echo "<img id='wall-img".$count."' src=".$b." alt='a'>";
            }
            <img id="wall-img1" src="./img/a.jpg" alt='a'>
        }*/
?>
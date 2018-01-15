<?php
    require_once(dirname(__FILE__)."/include/session.php");
    require_once dirname(__FILE__)."/class/DBManager.php";
    $dbm = new DBManager();
    $nursery_school_id = $_SESSION['nursery_school_id'];
    //タグ全件取得
    $tag_all = $dbm->tag_select_all($nursery_school_id);
    $limit_num = 2;
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>動画・写真一覧画面</title>
        <link rel="stylesheet" type="text/css" href="./css/style.css">
        <link rel="stylesheet" type="text/css" href="./css/image.css">
        <link rel="stylesheet" type="text/css" href="./css/tagedit.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" src="./js/jquery.jrumble.1.3.js"></script>
        <script src="./js/photoclick.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <form action="./tag.php">
                <input type="submit" value="たぐへんしゅう" class="tagedit">
            </form>
            <div class="header">
                <p>あるばむ</p>
            </div>
            <span class="label-movie label">どうが</span>
            <div class="inline" id="movie">
                <ul class="movie_list">
                </ul>
                <div id="movie-page" class="page">
                </div>
            </div>
            <span class="label-photo label">しゃしん</span> 
            <div class="inline" id="photo">
                <ul class="photo_list">
                </ul>
                <div id="photo-page" class="page">
                </div>
            </div>
            <div id="photo_page">

            </div>
            <div class="bottom-container">
                <div class="bottom-select-tag-container">
                    <span class="label-fovorite-tag label">人気のタグ</span>
                    <div class="favorite_tag">
                    </div>
                    <span class="label-refine-tag label">絞り込み中のタグ</span>
                    <div class="select_tag">
                    </div>
                </div>
                <div class="btn-container">
                    <div class="btn-main-container">
                        <div>
                            <?=delDownBtnWrite();?>
                        </div>
                    </div>
                </div>     
            </div>
        </div>
        
        <form aciton="Album.php", method="POST" onsubmit="return false;" id="modal_form_img">
            <div class="modal-content" id="modal-img" >
                <a class="modal-close">×</a>
                <div>
                    <img src=" " class="img" photo-id=" ">
                </div>
                <?=modalTagWrite();?>
            </div>
        </form> 
        <form aciton="Album.php" method="POST" onsubmit="return false;" id="modal_form_mv">
            <div class="modal-content" id="modal-mve" >
                <a class="modal-close">×</a>
                <div>
                    <iframe src=" " class="mve" width="500" height="300" movie-id=" " allowfullscreen></iframe>
                </div>
                <?=modalTagWrite();?>
            </div>
        </form>
        <div id="tag-modal">
            <div class="modal-tag-container">
            <a class="modal-close">×</a>
            <div class="modal-tag-header">タグしぼりこみ</div>
            <form action="" method="POST">
                <div class="modal-tag-main-container">
                </div>
            </form>
            <div class="refine">
                <span>しぼりこみ</span>
            </div>
            </div>
        </div>
    </body>
</html>

<?php
    function delDownBtnWrite(){
        if($_SESSION['kubun'] === 'nursery_school'){
            echo '<input type="submit" value="さくじょ" class="delete">';
        }
        echo '<input type="submit" value="だうんろーど" class="download">';
    }
    function modalTagWrite(){
        if($_SESSION['kubun'] === 'nursery_school'){
            echo '<div class="modal-tag">
                    <div class="hoge2">
                        <select class="event2" name="regist">
                            <option value="0" selected="true">⇩せんたく</option>           
            ';
            foreach($tag_all as $list){
                $id = $list->tag_id;
                $name = $list->tag_name;
                echo "<option value='$id'>" . $name ."</option>";                                      
            }
            echo '
                        </select>
                    </div>
                </div>
                <div class="modal-menu">
                    <form onsubmit="return false;">
                        <input type="button" value="たぐついか" class="tagregist" id="tag_regist1">
                    </form>
                </div>        
                ';
        }
    }
?>
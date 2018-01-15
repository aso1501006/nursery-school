<?php
require_once dirname(__FILE__)."/class/FileManager.php";
require_once dirname(__FILE__)."/class/MoviePhotoTblDT.php";
require_once dirname(__FILE__)."/class/ScheduleManager.php";

session_start();
//$b = date("Y-m-d 00:00:00");
$kinou = date("Y-m-d", strtotime('-1 day'));
$kyou = date("Y-m-d", strtotime('+0 day'));
$asita = date("Y-m-d", strtotime('+1 day'));
if(!empty($_SESSION["kubun"])){
    $kubun = $_SESSION["kubun"];
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>なんとか保育園</title>
    <!-- BootstrapのCSS読み込み -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jquery.bxslider.css" rel="stylesheet">
    <link href="css/sample.css" rel="stylesheet">
    <!-- jQuery読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="css/jquery.bxslider.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="./js/jquery.fitvids.js"></script>
    <script src="./js/jquery.easing.1.3.js"></script>
    <script src="./js/jquery.bxslider.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $('#sample05').bxSlider({
                minSlides: 4,
                maxSlides: 4,
                slideWidth: 230,
                slideMargin: 10,
                ticker: true,
                tickerHover: true,
                speed: 40000,
                useCSS: false,
                pager:false,
                preloadImages: 'all',
                onSliderLoad: function() {

                }
            });
            $('#sample06').bxSlider({
                minSlides: 4,
                maxSlides: 4,
                slideWidth: 230,
                slideMargin: 10,
                ticker: true,
                tickerHover: true,
                speed: 40000,
                useCSS: false,
                autoDelay: 5000,
                pager:false,
                preloadImages: 'all',
                onSliderLoad: function() {
                    
                }
            });
        });
        $(document).ready(function(){
            $('#sample05').css('z-index','0');
            $('#sample05').css('z-index','0');
        });
    </script>
    <!-- BootstrapのJS読み込み -->
    <script src="./js/bootstrap.min.js"></script>
    <link href="./css/top.css" rel="stylesheet">
  </head>
  <body>
  <div class="btn-top">    
    <img width="50%" src="./img/W86G9.png" title="caption1" />
    <?php 
    if($kubun === "nursery_school"){
        btn_print();
    }
    ?>
  </div>  
<div id="page">
    <div>
        <img src="./img/main2.jpg" title='caption' style='width:100%;'/>
    </div>
    <div>
        <div class="lsample">
            <a href="./calendar.php">
                <div>
                    <img src="./img/btn042/btn042_01-2.png" />
                    <span>かれんだーぺーじへ</span>
                </div>
            </a>
            <ul class="karenda">
                <li><div class="bun">
                        <div class="ribbon">イベント</div>
                        <div class = "date">昨日<?php echo $kinou ?></div>
                        <img src="./img/head011/head011_01.png" />
                        
                            <div class = "mozi"><?php schedule($kinou) ?></div>
                        
                    </div>
                </li>
                <li><div class="bun">
                        <div class = "date">今日<?php echo $kyou ?></div>
                        <img src="./img/head011/head011_01.png" />
                        <div class = "mozi"><?php schedule($kyou) ?></div>
                    </div>
                </li>
                <li><div class="bun">
                        <div class="ribbon">イベント</div>
                        <div class = "date">明日<?php echo $asita ?></div>
                        <img src="./img/head011/head011_01.png" />
                        <div class = "mozi"><?php schedule($asita) ?></div>
                    </div>
                </li>
            </ul>　
        </div>
        
    </div>
    <div>
            <a href="./test.html">
                <div class="rsample">
                    <img src="./img/btn042/btn042_01-2.png" />
                    <span>あるばむぺーじへ</span>
                </div>
            </a>
            <img src="./img/head011/head011_01.png" style="width: 100%;"/>
            <ul id="sample05">
            <?php newphoto() ?>
            </ul>
            <img src="./img/head011/head011_01.png" style="width: 100%;"/>
    </div>
    <div class="douga">
        <img src="./img/head011/head011_02.png" style="width: 100%;"/>
        <ul id="sample06">
            <?php newmove() ?>
        </ul>
        <img src="./img/head011/head011_02.png" style="width: 100%;"/>
    </div>
</div>
  </body>
</html>
<?php
        function newphoto(){
            $flm = new FileManager();
            $nst = new MoviePhotoTblDT();
            $nursery_school_id = $_SESSION['nursery_school_id'];
            $list = $flm->get_photo_new($nursery_school_id,10);
            foreach($list as $a ){
                $b = $a->path;
                echo "<li><img src=./".$b." /></li>";
            }
        }
        function newmove(){
            $flm = new FileManager();
            $nst = new MoviesTblDT();
            $nursery_school_id = $_SESSION['nursery_school_id'];
            $list = $flm->get_movie_new($nursery_school_id,10);
            foreach($list as $a ){
                $b = $a->movie_URL;
                echo "<li><iframe width='200' height='150' src=".$b." frameborder='0' allowfullscreen ></iframe></li>";
            }
        }
        function nursery_phot(){
            $flm = new FileManager();
            $nst = new MoviePhotoTblDT();
            $nursery_school_id = $_SESSION['nursery_school_id'];
            $list = $flm->get_nursery_photo_select($nursery_school_id);
            $count = 0;
            foreach($list as $a ){
                $b = $a->path;
                $count++;
                echo "<li><img src=./".$b." title='caption'".$count." style='width:100%;'/></li>";
            }
        }
        function schedule($day){
            $sdm = new ScheduleManager();
            $nursery_school_id = $_SESSION['nursery_school_id'];
            $list = $sdm->get_schedule($nursery_school_id,$day);
            foreach($list as $name){
                echo "<div>・".$name."</div>";
            }
        }
        function btn_print(){
            echo "<a href='./test.html'><button type='button' class='btn btn-default'style='width: 100px; height: 50px'>保護者登録</button></a>";
            echo "<a href='./test.html'><button type='button' class='btn btn-warning'style='width: 100px; height: 50px'>アップロード</button></a>";
            echo "<a href='./tag.php'><button type='button' class='btn btn-success'style='width: 100px; height: 50px'>タグ管理</button></a>";
        }
                
?>

    



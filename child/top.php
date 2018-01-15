<?php
require_once(dirname(__FILE__)."/include/session.php");
require_once dirname(__FILE__)."/class/FileManager.php";
require_once dirname(__FILE__)."/class/MoviePhotoTblDT.php";
require_once dirname(__FILE__)."/class/ScheduleManager.php";

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
            $('#sample02').bxSlider({
                mode: 'horizontal',
                startSlide: 3,
                captions: false,
                auto: true,
                pause: 2500,
                autoHover: true,
                autoDelay: 2000,
                autoControls: false,
                controls: true,
            });
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
        $(document).on('click','.down-btn',function(){ 
                $('.hbtn').slideToggle();
        });
        
        
    </script>
    <!-- BootstrapのJS読み込み -->
    <script src="./js/bootstrap.min.js"></script>
    <link href="./css/top.css" rel="stylesheet">
  </head>
  <body>

<div class="conteinar">
  <div class="btn-top">    
    <img src="./img/W86G9.png" title="caption1" />
    <?php 
    if($kubun === "nursery_school"){
        btn_print();
    }
    ?>
  </div>  
<div id="page">

    <div class="kare-conteinar">
        <div class="lsample">
                <div class="rsample">
                    <a href="./calendar.php">
                    <img src="./img/btn042/btn042_01-2.png" />
                    <span>かれんだーぺーじへ</span>
                    </a>
                </div>
            <ul class="karenda">
                <li><div class="bun">
                        <div class = "date">昨日<?php echo $kinou ?></div>
                        <img src="./img/head011/head011_01.png" />
                        <div class = "mozi"><?php $chek = schedule($kinou); ?></div>
                        <?php
                            if($chek){
                                event();
                            }
                        ?>
                    </div>
                </li>
                <li><div class="bun">
                        <div class = "date">今日<?php echo $kyou ?></div>
                        <img src="./img/head011/head011_01.png" />
                        <div class = "mozi"><?php $chek = schedule($kyou); ?></div>
                        <?php
                            if($chek){
                                event();
                            }
                        ?>
                    </div>
                </li>
                <li><div class="bun">
                        <div class = "date">明日<?php echo $asita ?></div>
                        <img src="./img/head011/head011_01.png" />
                        <div class = "mozi"><?php $chek = schedule($asita); ?></div>
                        <?php
                            if($chek){
                                event();
                            }
                        ?>
                    </div>
                </li>
            </ul>　
        </div>
        
        
    </div>
        <div class="al-conteinar">
                <div class="lsample">
                    <div class="rsample">
                        <a href="./Album.php">
                        <img src="./img/btn042/btn042_01-2.png" />
                        <span>あるばむぺーじへ</span>
                        </a>
                    </div>
                    <div class="koara">
                        <ul id="sample05">
                            <?php newphoto() ?>
                        </ul>
                        <img class="ko" src="./img/koara.png" />
                    </div>
                </div>
        </div>
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
                //echo "<li><img src='http://i.ytimg.com/vi/"+$b+"/default.jpg' title='caption'".$count." style='width:auto; height:80px;'/></li>";
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
                echo "<li class='photo'><img src=./".$b." title='caption'".$count." style='width:100px; height:auto;'/></li>";
            }
        }
        function schedule($day){
            $sdm = new ScheduleManager();
            $chek = false;
            $nursery_school_id = $_SESSION['nursery_school_id'];
            $list = $sdm->get_schedule($nursery_school_id,$day);
            //$list[] = "aaaaaa";
            foreach($list as $name){
                echo "<div>・".$name."</div>";
                $chek = true;
            }
            return $chek;
        }
        function btn_print(){
            echo "
                
                    <div class='b'>
                            <ul>
                            <a href='./'><li><div class='cloud'><img src='./img/kumo.png' title='caption' ><span>保護者登録</span></div></li></a>
                            <a href='./tag.php'><li><div class='cloud'><img src='./img/kumo.png' title='caption' ><span>タグ管理</span></div></li></a>
                            <div class='down-btn cloud'><img src='./img/kumo.png' title='caption' ><span>アップロード</span></div>
                            <li>
                                <div class='o'>
                                    
                                    <a href='./PhotoUpload.php'><div class='w'><img class='hbtn' src='./img/kumo.png' title='caption' ><span class='hbtn'>写 真</span></div></a>
                                    <a href='./MovieUpload.php'><div class='w'><img class='hbtn' src='./img/kumo.png' title='caption' ><span class='hbtn'>動 画</span></div></a>
                                    <a href='./360Upload.php'><div class='w'><img class='hbtn' src='./img/kumo.png' title='caption' ><span class='hbtn'>３６０</span></div></a>
                                </div>
                            </li>
                        </ul>
                    </div>";
        }
        function event(){
            echo "<div class='ribbon'>イベント</div>";
        }
                
?>

    



<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset='utf-8'>
<title>スケジュール追加</title>
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="./css/zabuto_calendar.css">
 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
<script src="./js/zabuto_calendar.js"></script>
<script type="application/javascript">
$(window).ready(function () {
  $("#my-calendar").zabuto_calendar({
    cell_border: true,
    today: true,
    weekstartson: 0,
  });

  $(document).on('click','#top',function(){
    window.location.href = "./top.php";
  });

  $('input').on('keydown',function(e){
    if((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)){
      return false;
    } else {
      return true;
    }
  });
});


$(window).resize(centeringModalSyncer);
function centeringModalSyncer(){
  var w = $(window).width();
  var h = $(window).height();

  var cw = $("#modal-content").outerWidth({margin:true});
  var ch = $("#modal-content").outerHeight({margin:true});
  var cw = $("#modal-content").outerWidth();
  var ch = $("#modal-content").outerHeight();

  $("#modal-content").css({"left":((w - cw)/2) + "px","top":((h - ch)/2) + "px"});
}

$(window).resize(centeringModalSyncerr);
function centeringModalSyncerr(){
  var w = $( window ).width();
  var h = $( window ).height();

  var cw = $("#modal-edit").outerWidth({margin:true});
  var ch = $("#modal-edit").outerHeight({margin:true});
  var cw = $("#modal-edit").outerWidth();
  var ch = $("#modal-edit").outerHeight();

  $("#modal-edit").css({"left": ((w - cw)/2) + "px","top":((h - ch)/2) + "px"});
}

$(window).resize(centeringModalSyncerrr);
function centeringModalSyncerrr(){
  var w = $( window ).width();
  var h = $( window ).height();

  var cw = $("#modal-parent").outerWidth({margin:true});
  var ch = $("#modal-parent").outerHeight({margin:true});
  var cw = $("#modal-parent").outerWidth();
  var ch = $("#modal-parent").outerHeight();

  $("#modal-parent").css({"left": ((w - cw)/2) + "px","top":((h - ch)/2) + "px"});
}

$(window).resize(centeringModalSyncerrrr);
function centeringModalSyncerrrr(){
  var w = $( window ).width();
  var h = $( window ).height();

  var cw = $("#modal-insert").outerWidth({margin:true});
  var ch = $("#modal-insert").outerHeight({margin:true});
  var cw = $("#modal-insert").outerWidth();
  var ch = $("#modal-insert").outerHeight();

  $("#modal-insert").css({"left": ((w - cw)/2) + "px","top":((h - ch)/2) + "px"});
}

var day;
var name;
var scrollday;
var kubun = <?php
echo '"'.$_SESSION['kubun'].'"';
?>; 
var dateAttr = new Date();
var page = dateAttr.getMonth()+1;
var pageY = dateAttr.getFullYear();

$(window).load(function(){

  $('.modalLabel').html(countMax);
  
  scheduleBetween();
  
  $(document).on('click','#zabuto_calendar__nav-prev',function(){
    scheduleBetween();

  });

  $(document).on('click','#zabuto_calendar__nav-next',function(){
    scheduleBetween();

  });
});

function scheduleBetween(){
  $('.sche').append('<div class="scroll" />');
  var index = $('.sche').index(this);
  var dayid = $('.sche').eq(index).attr("id");
  var mon = dayid.slice(-10,-3);

  $.ajax({
    type: 'POST',
    url: './schedule_between.php',
    data: {
      month : mon
    },
    success: function(data){
      var schedule = JSON.parse(data);
      var before = "/";

      Object.keys(schedule).forEach(function(key){
        var regExp = new RegExp(before,"g");
        var day = schedule[key]['schedule_date'].replace(regExp,"-");
        var day = day.slice(0,-9);

        var date = "zabuto_calendar_" + schedule[key]['schedule_date'].replace(regExp,"-");
        var date = date.slice(0,-9);
        scheduleWrite(day,date,schedule[key]['schedule_name']);
      });
    },
    error: function(){
      alert('error');
    }
  });

  var scheduleWrite = function(day,date,name){
    scrollday = day;

    $('#'+date).children('.scroll').append('<div class="gg'+day+'">' + name + '</div>');
    $('#'+date).addClass('event');
  };
}

  if(kubun == "nursery_school"){
    //日付押したとき
    $(document).on('click','.sche',function(){
      $('#m-text').val('');
      var index = $('.sche').index(this);
      var dayid = $('.sche').eq(index).attr("id");
      day = dayid.slice(-10);
      $('.modalLabel').html(countMax);
      $('.modalLabel').css({color:'#000000',fontWeight:'normal'});

      //modalの日付
      $('.modal-event').empty();
      $('#day').empty();
      $("#day").append(day);

      $(this).blur();
      if($("#modal-overlay")[0]) return false;


      $("body").append('<div id="modal-overlay"></div>');
      $("#modal-overlay").fadeIn("slow");

      centeringModalSyncer();

      $("#modal-content").fadeIn("slow");

      $("#modal-overlay,#modal-close,#delete").unbind().click(function(){
        $("#modal-content,#modal-overlay").fadeOut("slow", function(){
          $('.ff20').empty();
          $("#modal-overlay").remove();
        });
      });
    });

    $(document).on('click','.event',function(){
      $('.gg'+day).val('');
      name = '';
      name = $('.gg'+day).html();

      $('.modal-event').empty();
      var count = 0;
      $('.gg'+day).each(function(index, element){
        count++;
        name = '';
        name = $(element).html();
        $('.modal-event').append('<div class="ff20"><div id="ff" class="ff">' + name + '</div><span class="button-link"><span id="edit" class="button">編集</span></span><span class="button-link"><span id="delete" class="button">削除</span></span></div>');
        $("#modal-overlay,#modal-close,#delete").unbind().click(function(){
          $("#modal-content,#modal-overlay").fadeOut("slow", function(){
            $('.ff20').empty();
            $("#modal-overlay").remove();
          });
        });
      });
      if(count > 2){
        $('.modal-event').wrapInner('<div class="scrl" />');
      }
      centeringModalSyncer();
    });
  }
  
  if(kubun == "parent"){
    $(document).on('click','.event',function(){
      var index = $('.sche').index(this);
      var dayid = $('.sche').eq(index).attr("id");
      day = dayid.slice(-10);

      name ='';
      name = $('.gg'+day).html();

      var before = "-";
      var regExp = new RegExp(before,"g");
      var date = day.replace(regExp,"/");

      $('.pday').empty();
      $('.pevent').empty();

      $('.pday').append(date + "のイベントは");
      $('.gg'+day).each(function(index, element){
        name = '';
        name = $(element).html();
        $('.pevent').prepend('<div id="ff" class="ff">' + name + '</div>');
      });
      $('.pevent').append("です。");

      $("body").append('<div id="modal-overlay"></div>');
      $('#modal-overlay').fadeIn("slow");

      centeringModalSyncerrr();

      $("#modal-parent").fadeIn("slow");

      $("#modal-overlay,#modal-close").unbind().click(function(){
        $("#modal-parent,#modal-overlay").fadeOut("slow", function(){
          $("#modal-overlay").remove();
        });
      });
    });
  }

  var countMax = 20;
  $(document).bind('keydown','.modal-text',function(){
    var thisValueLength = $('.modal-text').val().length;
    var countDown = (countMax) - (thisValueLength);
    $('.modalLabel').html(countDown);

    if(countDown < 0){
      $('.modalLabel').css({color:'#ff0000',fontWeight:'bold'});
    } else {
      $('.modalLabel').css({color:'#000000',fontWeight:'normal'});
    }
  });

  
  var itext;
  $(document).on('click','#insert',function(){
    if(!(document.getElementById('m-text').value)){
      alert('もじをにゅうりょくしてください');
    } else {
      itext = $('#m-text').val().substr(0,21);
      
      $('#inserT').empty();
      $('#inserT').prepend(itext);

      $('#modal-content').fadeOut("slow");
      centeringModalSyncerrrr();

      $("#modal-insert").fadeIn("slow");

      $("#modal-overlay,#modal-close,#yes,#no").unbind().click(function(){
        $("#modal-insert,#modal-overlay").fadeOut("slow", function(){
          $("#modal-overlay").remove();
        });
      });
    }
  });

  $(document).on('click','#yes',function(){
    $.ajax({
      type: 'POST',
      url: './schedule_tag_update.php',
      data: {
        'schedule_date' : day,
        'schedule_name' : itext
            },
      success: function(){
        $('#zabuto_calendar_'+day+' .scroll').append('<div class="gg'+day+'">'+itext+'</div>');
        $('#zabuto_calendar_'+day).addClass('event');
      },
      error: function(){
        console.log("error");
      }
    });

    $.ajax({
      type: 'POST',
      url: './schedule_insert.php',
      data: {
        'schedule_date' : day,
        'schedule_name' : itext
            },
      success: function(){
      },
      error: function(){
        console.log("error");
      }
    });
  });

  $(document).on('click','#no',function(){
    $.ajax({
      type: 'POST',
      url: './schedule_insert.php',
      data: {
        'schedule_date' : day,
        'schedule_name' : itext
            },
      success: function(){
        $('#zabuto_calendar_'+day+' .scroll').append('<div class="gg'+day+'">'+itext+'</div>');
        console.log('gg'+day);
        $('#zabuto_calendar_'+day).addClass('event');
      },
      error: function(){
        console.log("error");
      }
    });
  });

  $(document).on('click','#edit',function(){
    var index = $('span#edit').index(this);
    var eve = $('span#edit').eq(index).parent().parent().children('#ff').text();

    $('#b-text').val('');
    $('#before').empty();
    $('#before').prepend(eve);
    $('#modal-content').fadeOut("slow");
    
    centeringModalSyncerr();

    $("#modal-edit").fadeIn("slow");

    $("#modal-overlay,#modal-close,#ediT").unbind().click(function(){
      $("#modal-edit,#modal-overlay").fadeOut("slow", function(){
        $("#modal-overlay").remove();
      });
    });

  $(document).on('click','#ediT',function(){
    if(!(document.getElementById('b-text').value)){
      alert('もじをにゅうりょくしてください');
    } else {
      var aText = $('#b-text').val();
      var bText = $('#before').text();
      $.ajax({
        type: 'POST',
        dataType: 'text',
        url: './schedule_edit.php',
        data: {
          'schedule_date' : day,
          'schedule_aName' : aText,
          'schedule_name' : bText
              },
        success: function(data){
          $('.gg'+day).eq(index).html(aText);
        },
        error: function(){
          alert('error');
        }
      });
    }
  });
  });

  $(document).on('click','#delete',function(){
    var index = $('span#delete').index(this);
    var eve = $('span#delete').eq(index).parent().parent().children('#ff').text();
    var name = eve;
    var month = day.slice(-5,-3);

    $.ajax({
      type: 'POST',
      url: './schedule_delete.php',
      data: {
        'schedule_date' : day,
        'schedule_name' : name
            },
      success: function(data){
        $('.gg'+day).eq(index).remove();
        if($('#zabuto_calendar_'+day).children('.scroll').children('.gg'+day).length === 0){
          $('#zabuto_calendar_'+day).removeClass('event');
          
        }
      },
      error: function(){
        alert('error');
      }
    });
  });

</script>
       
</head>
<body>
<div class="container">
  <div id="top" class="home"></div>
  <div class="title">〇〇保育園スケジュール</div>
  <img border="0" src="./img/line.png" class="line" />
  <div class="row">
    <div id="my-calendar"></div>
  </div>
</div>

<form method="post" name="form" id="form">
  <div id="modal-content">
    <div id="modal-content-innar">
      <div class="modal-event"></div>
      <div >イベント名を入力してください</div>
      <div id='day'></div>
      <div id='test'><input type="text" id="m-text" class="modal-text"><span class="modalLabel"></span></div>
      <span class="button-link"><span id="insert" class="button">登録</span></span>
      <span id="modal-close" class="button-link"><span id="close" class="button">閉じる</span></span>
    </div>
  </div>
</form>

<div id="modal-edit">
  <div id="modal-edit-innar">
    <div class="ff">変更前<div id="before"></div></div>
    <div><input type="text" id="b-text" class="modal-text"><span class="modalLabel"></span></div>
    <span class="button-link"><span id="ediT" class="button">変更</span></span>
    <span id="modal-close" class="button-link"><span id="close" class="button">閉じる</span></span>
  </div>
</div>

<div id="modal-parent">
  <div id="modal-parent-innar">
    <div class="pday"></div>
    <div class="pevent"></div>
    <div id="modal-close" class="button-link"><div id="close" class="button">閉じる</div></div>
  </div>
</div>

<div id="modal-insert">
  <div id="modal-insert-innar">
    <div id="inserT" class="ff"></div>
    <div style="margin-bottom:10px;">を<span class="mojiTag">タグ</span>についかしますか？</div>
    <span class="button-link"><span id="yes" class="button">はい</span></span>
    <span class="button-link"><span id="no" class="button">いいえ</span></span>
  </div>
</div>

</body>
</html>
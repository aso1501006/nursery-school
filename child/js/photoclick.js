$(function(){

    var moviePages = 0;
    var photoPages = 0;
    var nowPageMovie = 1;
    var nowPagePhoto = 1;
    var addCnt;
    var count = 1;
    var array = [];
    var photoMovieList;

    var photoMovieGet = function(){
        $.ajax({
            type: 'POST',
            url: './albumReady.php',
            success: function(data){
                //console.log(data);     
                //動画と写真のテーブルを取得
                photoMovieList = JSON.parse(data);
                //console.log(photoMovieList);
                moviePhotoWrite();
            },
            error: function(XMLHttpRequest, textStatus, errorThtown){
                console.log(XMLHttpRequest + ":" + textStatus + ":" + errorThtown);
            }
        });
    };
    var moviePhotoWrite = function(){
        $('.movie_list').empty();
        $('.photo_list').empty();
        addCnt = 0;
        photoMovieList.forEach(function(album1,album2){
            //動画テーブルの表示を行う
            if(album2 == 0){
                //console.log(album1);
                //console.log(album1.length);
                moviePages = parseInt(album1.length/8);
                if(album1.length%8 !== 0)moviePages++;
                for(var i = (nowPageMovie-1)*8; i < nowPageMovie*8; i++){
                    if(i < album1.length){
                        var appendData = '<li>';
                        appendData += '<div class="media">';
                        appendData += '<img class="mvesize" src="http://i.ytimg.com/vi/'+ album1[i]['movie_URL'] +'/mqdefault.jpg" frameborder="0" data-video="'+ album1[i]['movie_URL']+'" data-id="' + album1[i]['id'] +'"></img>';
                        appendData += '<div class="name">';
                        appendData += '<img src="./img/edit.png" class="edit">';
                        appendData += '<span>'+album1[i]['name']+'</span>';
                        appendData += '</div>';
                        appendData += '<div class="taglist">';
                        appendData += '</div>';
                        appendData += '</div>';
                        appendData += '</li>';
                        $('.movie_list').append(appendData);
                        (function(i){
                            $.ajax({
                                type: 'POST',
                                url: './movietags.php',
                                data:{
                                    //動画
                                    'data':album1[i]['id']
                                },
                                success: function(data){
                                    //console.log(data);
                                    var tags = JSON.parse(data);
                                    // console.log(tags);
                                    var appendData = "";
                                    tags.forEach(function(tag){
                                        //console.log(tag['tag_name']);
                                        appendData += '<a class="tagname" data-id="' + tag['tag_id'] + '"><span>' + tag['tag_name'] + '</span></a>';
                                    });
                                    appendData += '</div>';
                                    appendData += '</div>';
                                    appendData += '</li>';
                                    //console.log(i-(nowPageMovie-1)*8);
                                    $('.taglist').eq(i-(nowPageMovie-1)*8).append(appendData);
                                },
                                error: function(XMLHttpRequest, textStatus, errorThtown){
                                    console.log(XMLHttpRequest + ":" + textStatus + ":" + errorThtown);
                                }
                            });
                        })(i);
                        if(parseInt(moviePages) === parseInt(nowPageMovie)){
                            if(album1.length === 0){
                                addCnt = 0;    
                            }else if(album1.length !== 8){
                                addCnt = album1.length%8;
                            }else{
                                addCnt = 8;
                            }
                        }else{
                            addCnt = 8;
                        }
                    }
                }
                pagerWriteMovie();
                pagerWritePhoto();                        
            //画像テーブルの表示を行う              
            }else{
                photoPages = parseInt(album1.length/8);
                if(album1.length%8 !== 0)photoPages++;
                //console.log(album1);
                //console.log(album1.length);
                //console.log(photoPages);
                for(var i = (nowPagePhoto-1)*8; i < nowPagePhoto*8; i++){
                    if(i < album1.length){
                        var appendData = '<li>';
                        appendData += '<div class="media">';
                        appendData += '<img class="imgsize" src="'+ album1[i]['path'] +'" frameborder="0" data-id="' + album1[i]['id'] + '">';
                        appendData += '<div class="name">';
                        appendData += '<img src="./img/edit.png" class="edit">';
                        appendData += '<span>'+album1[i]['name']+'</span>';
                        appendData += '</div>';
                        appendData += '<div class="taglist">';
                        appendData += '</div>';
                        appendData += '</div>';
                        appendData += '</li>';
                        $('.photo_list').append(appendData);
                        (function(i){
                            $.ajax({
                                type: 'POST',
                                url: './phototags.php',
                                data:{
                                    //動画
                                    'data':album1[i]['id']
                                },
                                success: function(data){
                                    //console.log(data);
                                    var tags = JSON.parse(data);
                                    //console.log(tags);
                                    var appendData = "";
                                    tags.forEach(function(tag){
                                        //console.log(tag['tag_name']);
                                        appendData += '<a class="tagname" data-id="' + tag['tag_id'] + '"><span>' + tag['tag_name'] + '</span></a>';
                                    });
                                    appendData += '</div>';
                                    appendData += '</div>';
                                    appendData += '</li>';
                                    //console.log(addCnt);
                                    //console.log(i-(nowPagePhoto-1)*8+addCnt);
                                    //console.log(appendData);
                                    $('.taglist').eq(i-(nowPagePhoto-1)*8+addCnt).append(appendData);
                                },
                                error: function(XMLHttpRequest, textStatus, errorThtown){
                                    console.log(XMLHttpRequest + ":" + textStatus + ":" + errorThtown);
                                }
                            });
                        })(i);
                    }
                }
                pagerWriteMovie();
                pagerWritePhoto();
            }
        });
    };
    var pagerWriteMovie = function(){
        $('#movie-page').empty();
        var appendData = '<div id="movie-prev"><img src="./img/child/kakko1.png" alt=""><div class="kakko">まえ</div></div>';
        appendData += '<div><img src="./img/child/c.png" alt=""></div>';
        appendData += '<div><img src="./img/child/h.png" alt=""></div>';
        var divideNum = parseInt(nowPageMovie/5);
        //console.log(divideNum);
        for(var i=divideNum*5; i<=divideNum*5+5;i++){
            if(i===0)continue;
            // console.log('m'+moviePages);
            // console.log('n'+nowPageMovie);
            // console.log('i'+i);
            if(i > moviePages){

            }else if(i === parseInt(nowPageMovie)){
                appendData += '<div class="movie-pager-content"><img src="./img/child/i2.png" alt=""><div style="color:#ff4b4b;">' + i +'</div></div>';
                // console.log("ii" +i);
                // console.log("nownow" +nowPageMovie);
            }else{
                appendData += '<div class="movie-pager-content"><img src="./img/child/i1.png" alt=""><div>' + i +'</div></div>';
                // console.log("i" +i);
                // console.log("now" +nowPageMovie);
            }
        }
        appendData += '<div><img src="./img/child/l.png" alt=""></div>';
        appendData += '<div><img src="./img/child/d.png" alt=""></div>';
        appendData += '<div id="movie-next"><img src="./img/child/kakko2.png" alt=""><div class="kakko">つぎ</div></div>';
        $('#movie-page').append(appendData);
    };
    var pagerWritePhoto = function(){
        $('#photo-page').empty();
        var appendData = '<div id="photo-prev"><img src="./img/child/kakko1.png" alt=""><div class="kakko">まえ</div></div>';
        appendData += '<div><img src="./img/child/c.png" alt=""></div>';
        appendData += '<div><img src="./img/child/h.png" alt=""></div>';
        var divideNum = parseInt(nowPagePhoto/5);
        for(var i=divideNum*5; i<=divideNum*5+5;i++){
            if(i===0)continue;
            if(i > photoPages){
                
            }else if(i === parseInt(nowPagePhoto)){
                appendData += '<div class="photo-pager-content"><img src="./img/child/i2.png" alt=""><div style="color:#ff5521;">' + i +'</div></div>';
            }else{
                appendData += '<div class="photo-pager-content"><img src="./img/child/i1.png" alt=""><div>' + i +'</div></div>';
            }
        }
        appendData += '<div><img src="./img/child/l.png" alt=""></div>';
        appendData += '<div><img src="./img/child/d.png" alt=""></div>';
        appendData += '<div id="photo-next"><img src="./img/child/kakko2.png" alt=""><div class="kakko">つぎ</div></div>';
        $('#photo-page').append(appendData);
    };
    $(document).on('change','.event1',function(){
        var name = "searchlist";
        //選択したvalue取得
        var selectNum = $(this).val();
        array.push(selectNum);
        var obj = $('#p_list').children();
        var select = '<select class="event1" name="' + name + count + '" id="p_list">';
        count++;
        Object.keys(obj).forEach(function(option){
            if(typeof obj.eq(option).val() !== 'undefined') {
                select += '<option value="' + obj.eq(option).val() + '">' + obj.eq(option).text() + '</option>';                   
            }
        });
        select += '</select>';
        //「⇩せんたく」の選択し以外を選んだ場合のみ実行
        if(array[array.length - 1] != 0){
            $('.pull_down').append("<div class='hoge'>" + select + "</div>");
        }
        
    });    
    var click_timer = new Array();
    var click_num = 0;
    $(document).on('click','.mvesize',function(){
        //
        //以下シングルクリック主処理
        //
        //クリックした要素のimgのsrc情報を保持する
        var src = $(this).attr('data-video');
        var id = $(this).attr('data-id');

        //タイマー処理の設定
        var timer = setTimeout(function(){
            //背景の黒い透明なやつの追加
            $('body').append('<div class="modal-overlay"></div>');
            //クリックしたimgのsrc情報をモーダルのiframeのsrc情報に代入する
            $('.mve').attr('src','https://www.youtube.com/embed/'+src);
            //クリックしたimgのdata-id情報をモーダルのiframeのmovie-idに代入する
            $('.mve').attr('movie-id',id);
            
            //モーダルの位置調整
            centeringModal('#modal-mve');
            //背景の黒い透明なやつとモーダルのメイン画面をフェードインさせる
            $('.modal-overlay,#modal-mve').fadeIn("slow");
            //モーダルのスクロール位置を最上部にする
            $('#modal-mve').scrollTop(0);
        //300ms間にリセットされなかったら実行
        }, 300);
        //タイマー配列のタイマー番号に、タイマー処理を登録
        click_timer[click_num] = timer;
        //タイマー番号加算
        click_num++;
        
    });
    $(document).on('click','.imgsize',function(){
        //
        //以下シングルクリック主処理
        //
        //クリックした要素のimgのsrc情報を保持する
        var src = $(this).attr('src');
        //クリックした要素の
        var id = $(this).attr('data-id')
        //タイマー処理の設定
        var timer = setTimeout(function(){
            //背景の黒い透明なやつの追加
            $('body').append('<div class="modal-overlay"></div>');
            //クリックしたimgのsrc情報をモーダルのimgのsrc情報に代入する
            $('.img').attr('src',src);
            $('.img').attr('photo-id',id);
            //モーダルの位置調整
            centeringModal('#modal-img');
            //背景の黒い透明なやつとモーダルのメイン画面をフェードインさせる
            $('.modal-overlay,#modal-img').fadeIn("slow");
            //モーダルのスクロール位置を最上部にする
            $('#modal-img').scrollTop(0);
        //300ms間にリセットされなかったら実行
        }, 300);
        //タイマー配列のタイマー番号に、タイマー処理を登録
        click_timer[click_num] = timer;
        //タイマー番号加算
        click_num++;
    });
    $(document).on('dblclick','.mvesize,.imgsize',function(){
        //タイマー情報を保存する配列を全件ループさせる
        click_timer.forEach (function(timer){
            //ダブルクリックされたので、シングルクリックのタイマーを全リセット
            clearTimeout(timer);
        });
        //
        //以下ダブルクリックの主処理
        //
        //toggleClass　classを持っていない場合は追加し、持っている場合は削除する
        $(this).toggleClass('clicked');   
    });
    $(document).on('click','.modal-overlay,.modal-close',function(){
        //フェードアウトさせる
        $('.modal-content,.modal-overlay').fadeOut('slow',function(){
            $('.modal-tag').data('hoge',$('.hoge2').html());
            //背景の黒い透明なやつ削除
            $('.modal-overlay').remove();
            //モーダル内のプルダウンメニューを全て削除
            $('.modal-tag').empty();
            //モーダル内にプルダウンメニューを一つ追加
            $('.modal-tag').append("<div class='hoge2'>" + $('.modal-tag').data('hoge') + "</div>");
        });
    });
    var array2 = [];
    $(document).on('change','.event2',function(){
        //選択したvalue取得
        var selectNum2 = $(this).val();
        array2.push(selectNum2)
        //「⇩せんたく」の選択し以外を選んだ場合のみ実行
        if(array2[array2.length - 1] != 0) {
            $('.modal-tag').append("<div class='hoge2'>" + $('.hoge2').html() + "</div>");
        }
        
    });
    $(document).on('click','#tag_regist1',function(){
        //プルダウンの項目を取得
        var tags =  $('#modal_form_img').serializeArray();
        //モーダルウインドウから写真ID取得
        var id = $('.img').attr('photo-id');
        console.log(id);
        console.log(tags);
        $.ajax({
            type:'POST',
            url:'./phototagregist.php',
            data:{
                'photo_id':id,
                'tag_id':tags
            },
            success:function(data){
                //console.log(data);
                location.reload();
            },
            error: function(){
                console.log("失敗");
            }
        })
    });
    $(document).on('click','#tag_regist2',function(){
        //プルダウンの項目を取得
        var tags = $('#modal_form_mv').serializeArray();
        //モーダルウインドウから動画ID取得
        var id = $('.mve').attr('movie-id');
        console.log(id);
        console.log(tags);
        $.ajax({
            type:'POST',
            url:'./movietagregist.php',
            data:{
                'movie_id':id,
                'tag_id':tags
            },
            success:function(data){
                //console.log(data);
                location.reload();
            },
            error:function(){
                console.log("失敗");
            }
        })
    });
    $(document).ready(function(){
        photoMovieGet();
        $.ajax({
            type: 'POST',
            url: './tag_favorite.php',
            success: function(data){
                //console.log(data);
                var tags = JSON.parse(data);
                var appendData = "";
                tags.forEach(function(tag){
                    appendData += '<a class="tagname" data-id="' + tag['tag_id'] + '"><span>' + tag['tag_name'] + '</span></a>';
                });
                appendData += '<span class="search">複数タグで絞り込み</span>';
                $('.favorite_tag').append(appendData);
            },
            error: function(XMLHttpRequest, textStatus, errorThtown){
                console.log(XMLHttpRequest + ":" + textStatus + ":" + errorThtown);
            }
        });
    });
    $(document).on('click','#movie-next',function(){
        if(nowPageMovie !== moviePages)nowPageMovie += 1;
        moviePhotoWrite();
        $(window).scrollTop(0);
        //console.log('n'+nowPageMovie);
        //console.log('m'+moviePages);
    });
    $(document).on('click','#movie-prev',function(){
        if(nowPageMovie !== 1)nowPageMovie -= 1;
        moviePhotoWrite();
        $(window).scrollTop(0);
        //console.log(nowPageMovie);
    });
    $(document).on('click','#photo-next',function(){
        if(nowPagePhoto !== photoPages)nowPagePhoto += 1;
        moviePhotoWrite();
        $(window).scrollTop(0);
        //console.log(nowPagePhoto);
    });
    $(document).on('click','#photo-prev',function(){
        if(nowPagePhoto !== 1)nowPagePhoto -= 1;
        moviePhotoWrite();
        $(window).scrollTop(0);
        //console.log(nowPagePhoto);
    });
    $(document).on('click','.movie-pager-content',function(){
        var index = $('#movie-page .movie-pager-content').index(this);
        //console.log($('#movie-page .movie-pager-content').eq(index).text());
        nowPageMovie = parseInt($('#movie-page .movie-pager-content').eq(index).text());
        moviePhotoWrite();
        $(window).scrollTop(0);
    });
    $(document).on('click','.photo-pager-content',function(){
        var index = $('#photo-page .photo-pager-content').index(this);
        nowPagePhoto = parseInt($('#photo-page .photo-pager-content').eq(index).text());
        moviePhotoWrite();
        $(window).scrollTop(0);
    });
    $(document).on('click','.delete',function(){
        var dataArray = [];
        var movieArray = [];
        var photoArray = [];
        $('.clicked').each(function(i,elem){
            if($(elem).hasClass('mvesize')){
                movieArray.push($(elem).attr('data-id'));
                //console.log("どうが"+$(elem).attr('data-id'));
            }else{
                photoArray.push($(elem).attr('data-id'));
                //console.log("がぞう"+$(elem).attr('data-id'));
            }
        });
        dataArray.push(movieArray);
        dataArray.push(photoArray);
        //console.log(dataArray);
        $.ajax({
            type: 'POST',
            url: './Delete.php',
            data:{
                'data':dataArray
            },
            success: function(data){
                window.location.reload();
            },
            error: function(XMLHttpRequest, textStatus, errorThtown){
                console.log(XMLHttpRequest + ":" + textStatus + ":" + errorThtown);
            }
        });
    });
    $(document).on('click','.download',function(){
        /*
        var dataArray = [];
        var movieArray = [];
        var photoArray = [];
        */
        var appendData = '<form id="zipForm" method="POST" action="./ziptest.php">';
        $('.clicked').each(function(i,elem){
            if($(elem).hasClass('mvesize')){
                appendData += ' <input type="text" name="movie[]" value="'+ $(elem).attr('data-id') +'">';
                //movieArray.push($(elem).attr('data-id'));
                //console.log("どうが"+$(elem).attr('data-id'));
            }else{
                appendData += ' <input type="text" name="photo[]" value="'+ $(elem).attr('data-id') +'">';
                //photoArray.push($(elem).attr('data-id'));
                //console.log("がぞう"+$(elem).attr('data-id'));
            }
        });
        /*
        dataArray.push(movieArray);
        dataArray.push(photoArray);
        */
        appendData += ' </form>';

        $(document.body).append(appendData);
        window.open("about:blank","zip");
        $('#zipForm').attr('target','zip');
        $('#zipForm').submit();
        $('#zipForm').remove();
        /*
        window.open("about:blank", "TEST") ;
        window.document.inform.action = "./ziptest.php" ;
        window.document.inform.method = "POST" ;
        window.document.inform.submit();
        */
        /*
        $.ajax({
            type: 'POST',
            url: './ziptest.php',
            data:{
                'data':dataArray
            },
            success: function(data){
                console.log(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThtown){
                console.log(XMLHttpRequest + ":" + textStatus + ":" + errorThtown);
            }
        });
        */
        /*
        var formData = new FormData();
        formData.append('data',dataArray);
        var request = new XMLHttpRequest();
        request.open("post","./ziptest.php");
        request.send(formData);
        */
    });
    $(document).on('click','.tagname',function(){
        //console.log($(this).attr('data-id'));
        $('.movie_list').empty();
        $('.photo_list').empty();
        var tags = [];
        var tag = {};
        tag['value'] = $(this).attr('data-id');
        //console.log($(this).children('span').text());
        var appendData = "";
        appendData += '<div class="select_tag_item_container">';
        appendData += '<a class="select-tag-name" data-id="'+ $(this).attr('data-id') +'">'+ $(this).children('span').text() +'</a>';
        appendData += '</div>';
        $('.select_tag').empty();
        $('.select_tag').append(appendData);
        tags.push(tag);
        $.ajax({
            type: 'POST',
            url: './moviephotostag.php',
            data:{
                'data':tags
            },
            success: function(data){
                //console.log(data);
                photoMovieList = JSON.parse(data);
                moviePhotoWrite();
            },
            error: function(XMLHttpRequest, textStatus, errorThtown){
                console.log(XMLHttpRequest + ":" + textStatus + ":" + errorThtown);
            }
        });
    });
    $(document).on('click','.edit',function(){
        //console.log($(this).parent().parent('.media').children('.mvesize').attr('data-id'));
        var parent = $(this).parent();
        if($(parent).children('span').size()){
            var text = $(parent).children('span').text();
            $(parent).children('span').remove();
            $(parent).children('img').attr('src','./img/check_edit.png');
            var appendData = '<input type="text" placeholder="' + text + '">';
            $(parent).append(appendData);
        }else{
            $(parent).children('img').attr('src','./img/edit.png');
            var name = $(parent).children('input').val();
            if(name === "")name = $(parent).children('input').attr('placeholder');
            $(parent).children('input').remove();
            var appendData = '<span>'+name+'</span>';
            $(parent).append(appendData);
            var id = {};
            if($(parent).parent('.media').children('.mvesize').size())id['movie'] = $(parent).parent('.media').children('.mvesize').attr('data-id');
            if($(parent).parent('.media').children('.imgsize').size())id['photo'] = $(parent).parent('.media').children('.imgsize').attr('data-id');
            $.ajax({
                type: 'POST',
                url: './moviePhotoNameUpdate.php',
                data:{
                    'data':id,
                    'name':name,
                },
                success: function(data){
                    console.log(data);
                },
                error: function(XMLHttpRequest, textStatus, errorThtown){
                    console.log(XMLHttpRequest + ":" + textStatus + ":" + errorThtown);
                }
            });
        }
    });
    $(document).on('click','.search',function(){ 
        $.ajax({
            type: 'POST',
            url: './tagAll.php',
            success: function(data){
                var appendData = '';
                var ids = [];
                if($('.select_tag').children().size()){
                    $('.select_tag').children('.select_tag_item_container').each(function(){
                        //console.log($(this));
                        //console.log($(this).children('.select-tag-name').attr('data-id'));
                        ids.push($(this).children('.select-tag-name').attr('data-id'));
                    });
                }
                tagAll = JSON.parse(data);
                tagAll.forEach(function(tag){
                    if($.inArray(tag['tag_id'],ids) !== -1){
                        appendData += '<div><input type="checkbox" name="tags" value="'+tag['tag_id']+'" checked="checked"><span>'+tag['tag_name']+'</span></div>';
                    }else{
                        appendData += '<div><input type="checkbox" name="tags" value="'+tag['tag_id']+'"><span>'+tag['tag_name']+'</span></div>';
                    }
                });
                $('.modal-tag-main-container').empty();
                $('.modal-tag-main-container').append(appendData);
                $('body').append('<div id="modal-backimage"></div>');
                centeringModal('#tag-modal');
                $('#modal-backimage,#tag-modal').fadeIn("slow");
            },
            error: function(XMLHttpRequest, textStatus, errorThtown){
                console.log(XMLHttpRequest + ":" + textStatus + ":" + errorThtown);
            }
        });
    });
    $(document).on('click','#modal-backimage,.modal-close,.refine',function(){
        //フェードアウトさせる
        $('#tag-modal,#modal-backimage').fadeOut('slow',function(){
            //背景の黒い透明なやつ削除
            $('#modal-backimage').remove();
        });
    });
    var centeringModal = function(target){
        //画面の横幅取得
        var w = $(window).width();
        //画面の縦幅取得
        var h = $(window).height();
        //jqueryで縦幅を取ると少し下にズレるらしい
        //ずらしたくない場合は、下記に記すjavascriptで取る
        //var h = window.innerHeight;
        //モーダルの横幅取得
        var mw = $(target).outerWidth();
        //モーダルの縦幅取得
        var mh = $(target).outerHeight();
        //モーダルの配置場所計算
        //左から何ピクセルか
        var pxleft = Math.round(((w - mw)/2));
        //右から何ピクセルか
        var pxtop = Math.round(((h - mh)/2));
        //モーダルのCSSに上記で出した値を追加
        $(target).css({'left': pxleft + 'px'});
        $(target).css({'top': pxtop + 'px'});
    };
    $(document).on('click','.refine',function(){
        var tags = [];
        var appendData = "";
        $('[name="tags"]:checked').each(function(){
            var tag = {};
            var tag_id_name = {};
            tag['value'] = $(this).val();
            //console.log($(this).parent().children('span').text());
            tags.push(tag);
            appendData += '<div class="select_tag_item_container">';
            appendData += '<a class="select-tag-name" data-id="'+ $(this).val() +'">'+ $(this).parent().children('span').text() +'</a>';
            appendData += '</div>';
        });
        $('.select_tag').empty();
        $('.select_tag').append(appendData);
        $.ajax({
            type: 'POST',
            url: './moviephotostag.php',
            data:{
                'data':tags
            },
            success: function(data){
                photoMovieList = JSON.parse(data);
                moviePhotoWrite();
            },
            error: function(XMLHttpRequest, textStatus, errorThtown){
                console.log(XMLHttpRequest + ":" + textStatus + ":" + errorThtown);
            }
        });
    });
    var mouseDownDate;
    var mouseUpDate;
    var flg = false;
    $(document).on('mousedown','.select_tag_item_container',function(){
        mouseDownDate = new Date();
        $('.select_tag_item_container').jrumble({
            'speed': 40
        });
    });
    $(document).on('mouseup','.select_tag_item_container',function(){
        mouseUpDate = new Date();
        if(mouseUpDate - mouseDownDate >= 1000) {
            if(flg){
                $('.select_tag_item_container').trigger('stopRumble');
                flg = false;
                $('.select_tag_item_container span').remove();
                var tags = [];
                if($('.select_tag').children().size()){
                    $('.select_tag').children('.select_tag_item_container').each(function(){
                        var tag = {};
                        tag['value'] = $(this).children('.select-tag-name').attr('data-id');
                        tags.push(tag);
                    });
                }
                $.ajax({
                    type: 'POST',
                    url: './moviephotostag.php',
                    data:{
                        'data':tags
                    },
                    success: function(data){
                        photoMovieList = JSON.parse(data);
                        moviePhotoWrite();
                        $(window).scrollTop(0);
                    },
                    error: function(XMLHttpRequest, textStatus, errorThtown){
                        console.log(XMLHttpRequest + ":" + textStatus + ":" + errorThtown);
                    }
                });
            }else{
                $('.select_tag_item_container').trigger('startRumble');
                flg = true;
                $('.select_tag_item_container').append('<span>×</span>');
            }
        } else {

        }
    });
    $(document).on('click','.select_tag_item_container span',function(){
        if($('.select_tag .select_tag_item_container').length !== 1){
            $(this).parent().remove();
        }else{
            $(this).parent().remove();
            flg = false;
            photoMovieGet();
            $(window).scrollTop(0);
        }
    });
});
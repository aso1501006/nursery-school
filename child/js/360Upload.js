$(function(){
    var cnt = 0;
    var resultCnt = 0;
    //フォームデータを一時保存する配列
    var formDataArray = [];
    //inputによってファイルが読み込まれた時に呼ばれる
    $('#file').on('change', function () {
        //入力されたファイル取得
        var files = this.files;
        //読み込み処理
        readFiles(files);
    });
    //ドロップされた時に呼ばれる
    $('#dropAria').on('drop', function (event) {
        //デフォルトの動きを無効化
        event.preventDefault();
        //ドラッグ&ドロップされたファイル取得
        var files = event.originalEvent.dataTransfer.files;
        //読み込み処理
        readFiles(files);
    })
    //ドロップ領域にはいった時に呼ばれる
    .on('dragenter', function (event) {
        //デフォルトの動きを無効化
        event.preventDefault();
    })
    //ドロップ領域上にある間呼ばれる
    .on('dragover', function (event) {
        //デフォルトの動きを無効化
        event.preventDefault();
    });
    //クリックした時にデータ送信
    $('#upload').on('click',function(){
        $('body').append('<div id="modal-backimage"></div>');
        centeringModal('#loading');
        $('#modal-backimage,#loading').fadeIn("slow");
        $('#status').html('アップロード中');
        $('#result').html('0 / '+cnt);
        formDataArray.forEach(function(formData){
            //console.log(document.forms.form1.tagselect.value);
            formData.append('360',true);
            if(document.forms.form1.tagselect.value != '0'){
                //フォームデータにkey:tagでファイルの関連付け
                formData.append('tag',document.forms.form1.tagselect.value);
                //console.log(formData.get('tag'));
            }else{
              formData.append('tag',null);
            }
            //console.log(formData.get("file"));
            if(formData.get("file")){
                uploadFiles(formData);
                formData.delete("file");
                formData.delete("tag");
                formData.delete("360");
            }
           
        });
        //画像を隠す
        $('#fileView').hide();
        //選択ボタンを表示
       　$('#file').show();
        //文字を表示
        $('.text').show();

    });
    $(document).on('click','#modal-backimage,#modal-close',function(){
        //フェードアウトさせる
        $('#loading,#modal-backimage').fadeOut('slow',function(){
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
    }
    var readFiles = function(files){
        //一度入っているファイルを空にする
        formDataArray = [];
        //選択ボタンを隠す
        $('#file').hide();
        //文字を隠す
        $('.text').hide();
        //表示されているサムネイルを削除
        $('.view-contaier').remove();
        //サムネイルを表示
        $('#fileView').show();
        //filesはObjectなので配列に変換
        //配列に対する処理が実行できるようにするため
        var filesArray = Array.prototype.slice.call(files, 0, files.length);
        //画像の数を数える
        cnt = 0;
        var promises = [];
        //送るファイル全てに対してのループ処理
        filesArray.forEach(function(file) {
            promises.push(thumbnailViewPromise(file));
        }, this);
        Promise.all(promises).then(function (results) {
            if(cnt == 0){
                //動画を隠す
                $('#fileView').hide();
                //window.alert('動画はありませんでした');
                //選択ボタンを表示
                $('#file').show();
                $('.text').show();
            }
        });
    }
    function thumbnailViewPromise(file) {
        return new Promise(function (resolve, reject) {
            thumbnailView(file, resolve, function (err, result) {
                if (err != null) {
                    reject(err);
                    return;
                }
                resolve(result);
            });
        });
    }
    var thumbnailView = function(file,resolver){
        var formData = new FormData();
        //フォームデータにkey:fileでファイルの関連付け
        formData.append('file',file);
        //フォームデータをフォームデータ一時保存配列に保持
        formDataArray.push(formData);
        var blobUrl = window.URL.createObjectURL(file);
        console.log(blobUrl);
        //MIMEタイプの最初から5文字取得　imageとvideoとその他を分けるため
        var type = file.type.slice(0,5);
        if(!(type == 'video')){
            /*
             window.alert('動画以外の形式です、動画をアップロードしましょう。');
             formData.delete('file');
             */
        }else{
            cnt++;//ここでカウントする
            console.log('通りましたよ');
            //fileViewに動画追加
            //サムネイル風になる
            $('#fileView').append('<div class="view-contaier"> <div> <video class="file" src="' + blobUrl + '"></video</div> <span> がぞ～ </span> </div>');
        }
        //アップロード処理
        //uploadFiles(formData);
        resolver(this);
    }
    var uploadFiles = function(formData){
        //ajaxで送信
        $.ajax({
            //POSTで送信
            type: 'POST',
            //ajaxが適切なcontentTypeに自動変換するのを防ぐ
            contentType: false,
            //データを文字列に自動変換するのを防ぐ
            processData: false,
            //送信先
            url: './php/resumable_upload.php',
            //送るデータ
            data: formData,
            //通信成功時に呼ばれる
            //data 接続先PHPファイルが出力したデータ
            success: function(data,dataType) {
                //console.log("成功" +data);
                resultCnt += 1;
                $('#result').html(resultCnt + ' / ' + cnt);
                if(cnt === resultCnt){
                    $('#status').html('アップロード完了');
                    $('#loading div img').attr('src','./img/check.jpg');
                }
            },
            //通信失敗時に呼ばれる
            //XMLHttpRequest.status HTTPステータス
            //textStatus            timeout、error、parsererror等の文字列
            //errorThrown           例外情報
            error: function(XMLHttpRequest, textStatus, errorThrown){
                console.log(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
            }
        });
    }
});

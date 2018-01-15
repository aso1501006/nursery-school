$(function(){
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
        formDataArray.forEach(function(formData){
            console.log(document.forms.form1.tagselect.value);
            if(document.forms.form1.tagselect.value != '0'){
                //フォームデータにkey:tagでファイルの関連付け
                formData.append('tag',document.forms.form1.tagselect.value);
                console.log(formData.get('tag'));
            }else{
              formData.append('tag',null);
            }
            console.log(formData.get("file"));
            if(formData.get("file")){
                uploadFiles(formData);
                formData.delete("file");
                formData.delete("tag");
            }
           
        });
        //画像を隠す
        $('#fileView').hide();
        //選択ボタンを表示
       　$('#file').show();
        //文字を表示
        $('.text').show();

    });
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
        var cnt = 0;
        //送るファイル全てに対してのループ処理
        filesArray.forEach(function(file) {
          　var formData = new FormData();
            //フォームデータにkey:fileでファイルの関連付け
            formData.append('file',file);
            //フォームデータをフォームデータ一時保存配列に保持
            formDataArray.push(formData);
            var blobUrl = window.URL.createObjectURL(file);
            //console.log(blobUrl);
            //MIMEタイプの最初から5文字取得　imageとvideoとその他を分けるため
            var type = file.type.slice(0,5);
            switch(type){
                //画像の場合
                case 'image':
                    //fileViewに画像追加
                    $('#fileView').append('<div class="view-contaier"> <div> <img src="' + blobUrl + '"></div> <span> 画像 </span> </div>');
                    break;
               　//動画の場合
                case 'video':
                    //fileViewに動画追加
                    //サムネイル風になる
                    $('#fileView').append('<div class="view-contaier"> <div> <video class="mvesize" src="' + blobUrl + '"></video></div> <span> 動画 </span> </div>');
                    break;
                    //画像でも動画でもない場合
                default:
                    //fileViewに文字追加
                    $('#fileView').append('<div class="view-contaier"> <div> <span>対応していない形式です。<span> </div> </div>');
                    break;
            }
            //アップロード処理
            //uploadFiles(formData);
        }, this);
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
            url: './upload.php',
            //送るデータ
            data: formData,
            //通信成功時に呼ばれる
            //data 接続先PHPファイルが出力したデータ
            success: function(data,dataType) {
                console.log("成功" +data);
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
    $(document).on('dblclick','.mvesize,.imgsize',function(){
        $(this).toggleClass('clicked');   
    });

});

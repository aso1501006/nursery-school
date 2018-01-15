$(function(){
    //フォームデータを一時保存する配列
    var formDataArray = []
    //クリックした時にデータ送信
    $('#delete').on('click',function(){
        //チェックボックス
        var im = document.forms.fm.Checkbox;
        var cnt = 0;
        // Array オブジェクトを作成する
        var img_id = new Array();
        //チェックボックスの数だけ繰り返す
        for(var i = 0; i < im.length; i++){
            //チェックボックスにチェックがついてるか
            console.log(im[i]);
            console.log(im[i].checked);
            if(im[i].checked){
                //チェックボックスのvalue（imgのidが入っている）をimg_idにプッシュ
                console.log(im[i].value);
                img_id.push(im[i].value);
                //チェックついてる数を数える
                cnt++;
            }
        }
        //チェックついてる数だけ繰り返す
        console.log(cnt);
        for(var i = 0; i < cnt; i++){
            var formData = new FormData();
            console.log(img_id[i]);
            var id = img_id[i];
            console.log(document.getElementById(img_id[i]));
            //チェックのついている画像のソースをformDataにappend
            formData.append('path',document.getElementById(img_id[i]).getAttribute("src"));
            //formDataをArrayにpush
            formDataArray.push(formData);
        }
        //入ってる配列を繰り返す
        var promises = [];
        formDataArray.forEach(function(formData){
            //画像のsrcが入っているか確認
            console.log(formData.get("path"));
            //ajaxで送る
        　   //deleteFiles(resolve,formData);
            promises.push(deleteFilesPromise(formData));
        });
        Promise.all(promises).then(function (results) {
            window.location.reload(true);
        });    
    });
    function deleteFilesPromise(formData) {
        return new Promise(function (resolve, reject) {
            deleteFiles(formData, resolve, function (err, result) {
                if (err != null) {
                    reject(err);
                    return;
                }
                resolve(result);
            });
        });
    }
    var deleteFiles = function(formData,resolver){
        //ajaxで送信
        $.ajax({
            //POSTで送信
            type: 'POST',
            //ajaxが適切なcontentTypeに自動変換するのを防ぐ
            contentType: false,
            //データを文字列に自動変換するのを防ぐ
            processData: false,
            //送信先
            url: './delete.php',
            //送るデータ
            data: formData,
            //通信成功時に呼ばれる
            //data 接続先PHPファイルが出力したデータ
            success: function(data,dataType) {
                console.log("成功" +data);
                resolver(this);
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
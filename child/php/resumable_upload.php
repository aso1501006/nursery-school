<?php

//require_once(dirname(__FILE__)."/class/FileManager.php");
require_once("../class/FileManager.php");    
session_start();
$nursery_school_id = $_SESSION['nursery_school_id'];
//$nursery_school_id = 1;
$newFileName;
$tag = intval($_POST['tag']);
$fileManager = new FileManager();
//POSTでファイルがアップロードされているか、tmpにアップロードされた一時情報があるか確認
if(!empty($_FILES['file']) && is_uploaded_file($_FILES['file']['tmp_name'])){
    //リネームネーム　年月日時分秒
    $date = date('YmdHis');
    $newName = $date;
    //ランダムな数字を作成し追加
    $newName .= mt_rand(1000,9999);
    //newFileNameに代入
    $newFileName = $newName;
    //拡張子取得
    $extension = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
    //リネームネームに拡張子追加
    $newName .= '.' . $extension;
    //MIMEタイプの最初から5文字取得　imageとvideoとその他を分けるため
    $type = substr($_FILES['file']['type'],0,5);
    if(strlen($type) === 0)$type=" ";
    //ディレクトリ情報を構成するための変数
    $dir = './';
    //データベースを呼び出す
    //$DBManager = new DBManager();
    switch($type){
        //画像の場合
        case 'image':
            //ディレクトリ情報にフォルダ,ファイル名,拡張子を追加
            $dir .= 'uploadImg/' . $newName;
            //データベースにphoto_idとtag_idを登録
            //$DBManager->photo_tag_insert($newFileName,$tag);
            $fileManager->insert_photo($newFileName,$nursery_school_id,$date,$dir,$tag);
            
            break;
        //動画の場合
        case 'video':
            //３６０°動画の場合
            if($_POST['360'] === "true"){
                //ディレクトリ情報にフォルダ,ファイル名,拡張子を追加
                $dir .= '360/' . $newName;
            }else{
                //ディレクトリ情報にフォルダ,ファイル名,拡張子を追加
                $dir .= 'video/' . $newName;
            }
            //データベースにmovie_idとtag_idを登録
            //$DBManager->movie_tag_insert($newFileName,$tag);
            $fileManager->insert_movie($newFileName,$nursery_school_id,$date,$dir,$tag);
            break;
        //画像でも動画でもない場合
        default:
            //ディレクトリ情報にフォルダ,ファイル名,拡張子を追加
            $dir .= 'other/' . $newName;
            break;
    }
    //tmp(一時保存データ保管場所)からファイルを指定ディレクトリに移動する
      $dir = '.' . $dir;
      move_uploaded_file($_FILES['file']['tmp_name'],$dir);
}




if($type === 'video'){

  /**
  * Library Requirements
  *
  * 1. Install composer (https://getcomposer.org)
  * 2. On the command line, change to this directory (api-samples/php)
  * 3. Require the google/apiclient library
  *    $ composer require google/apiclient:~2.0
  */
  if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
  }

  require_once __DIR__ . '/vendor/autoload.php';

  //session_start();

  /*
  * You can acquire an OAuth 2.0 client ID and client secret from the
  * {{ Google Cloud Console }} <{{ https://cloud.google.com/console }}>
  * For more information about using OAuth 2.0 to access Google APIs, please see:
  * <https://developers.google.com/youtube/v3/guides/authentication>
  * Please ensure that you have enabled the YouTube Data API for your project.
  */
  $OAUTH2_CLIENT_ID = '327239050888-930k5v6tej21fi9668o44mt433gkaptv.apps.googleusercontent.com';
  $OAUTH2_CLIENT_SECRET = 'WjTXKWVHXESdaCnBJ0XUnz_Q';

  $credentialsFile = "./client_secret.json";

  $client = new Google_Client();
  $client->setClientId($OAUTH2_CLIENT_ID);
  $client->setClientSecret($OAUTH2_CLIENT_SECRET);
  $client->setAuthConfig($credentialsFile);
  $client->setScopes('https://www.googleapis.com/auth/youtube');
  $redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
      FILTER_SANITIZE_URL);
  $client->setRedirectUri($redirect);

  // Define an object that will be used to make all API requests.
  $youtube = new Google_Service_YouTube($client);

  // Check if an auth token exists for the required scopes
  $tokenSessionKey = 'token-' . $client->prepareScopes();
  if (isset($_GET['code'])) {
    if (strval($_SESSION['state']) !== strval($_GET['state'])) {
      die('The session state did not match.');
    }

    $client->authenticate($_GET['code']);
    $_SESSION[$tokenSessionKey] = $client->getAccessToken();
    header('Location: ' . $redirect);
  }

  if (isset($_SESSION[$tokenSessionKey])) {
    $client->setAccessToken($_SESSION[$tokenSessionKey]);
  }
  /*
  echo '<pre>';
  var_dump($client);
  echo '<pre>';
  */
  // Check to ensure that the access token was successfully acquired.
  if ($client->getAccessToken()) {
    $htmlBody = '';
    try{
      // REPLACE this value with the path to the file you are uploading.
      //$videoPath = "./test01.mp4";
      $videoPath = $dir;
      $title = $newFileName;
      // Create a snippet with title, description, tags and category ID
      // Create an asset resource and set its snippet metadata and type.
      // This example sets the video's title, description, keyword tags, and
      // video category.
      $snippet = new Google_Service_YouTube_VideoSnippet();
      $snippet->setTitle($newFileName);
      $snippet->setDescription("Test description");
      $snippet->setTags(array("tag1", "tag2"));

      // Numeric video category. See
      // https://developers.google.com/youtube/v3/docs/videoCategories/list
      $snippet->setCategoryId("22");

      // Set the video's status to "public". Valid statuses are "public",
      // "private" and "unlisted".
      $status = new Google_Service_YouTube_VideoStatus();
      $status->privacyStatus = "unlisted";

      // Associate the snippet and status objects with a new video resource.
      $video = new Google_Service_YouTube_Video();
      $video->setSnippet($snippet);
      $video->setStatus($status);

      // Specify the size of each chunk of data, in bytes. Set a higher value for
      // reliable connection as fewer chunks lead to faster uploads. Set a lower
      // value for better recovery on less reliable connections.
      $chunkSizeBytes = 1 * 1024 * 1024;

      // Setting the defer flag to true tells the client to return a request which can be called
      // with ->execute(); instead of making the API call immediately.
      $client->setDefer(true);

      // Create a request for the API's videos.insert method to create and upload the video.
      $insertRequest = $youtube->videos->insert("status,snippet", $video);

      // Create a MediaFileUpload object for resumable uploads.
      $media = new Google_Http_MediaFileUpload(
          $client,
          $insertRequest,
          'video/*',
          null,
          true,
          $chunkSizeBytes
      );
      $media->setFileSize(filesize($videoPath));


      // Read the media file and upload it chunk by chunk.
      $status = false;
      $handle = fopen($videoPath, "rb");
      while (!$status && !feof($handle)) {
        $chunk = fread($handle, $chunkSizeBytes);
        $status = $media->nextChunk($chunk);
      }

      fclose($handle);

      // If you want to make other calls after the file upload, set setDefer back to false
      $client->setDefer(false);

      /*
      $htmlBody .= "<h3>Video Uploaded</h3><ul>";
      $htmlBody .= sprintf('<li>%s (%s)</li>',
          $status['snippet']['title'],
          $status['id']);

      $htmlBody .= '</ul>';
      */

      echo $status['id'];
      $fileManager->update_movie_URL($newFileName,$status['id']);
      
    } catch (Google_Service_Exception $e) {
      $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
          htmlspecialchars($e->getMessage()));
    } catch (Google_Exception $e) {
      $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
          htmlspecialchars($e->getMessage()));
    }

    $_SESSION[$tokenSessionKey] = $client->getAccessToken();
  /*} elseif ($OAUTH2_CLIENT_ID == '327239050888-930k5v6tej21fi9668o44mt433gkaptv.apps.googleusercontent.com') {
    $htmlBody = <<<END
    <h3>Client Credentials Required</h3>
    <p>
      You need to set <code>\$OAUTH2_CLIENT_ID</code> and
      <code>\$OAUTH2_CLIENT_ID</code> before proceeding.
    <p>
  END;
  */
  } else {
    // If the user hasn't authorized the app, initiate the OAuth flow
    $state = mt_rand();
    $client->setState($state);
    $_SESSION['state'] = $state;

    $authUrl = $client->createAuthUrl();
    $htmlBody = <<<END
    <h3>Authorization Required</h3>
    <p>You need to <a href="$authUrl">authorize access</a> before proceeding.<p>
END;
  }
}
?>

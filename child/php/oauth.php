<?php

    require_once 'vendor/autoload.php';

    // アプリケーション設定
    define('CONSUMER_KEY', '327239050888-930k5v6tej21fi9668o44mt433gkaptv.apps.googleusercontent.com');
    define('CALLBACK_URL', 'http://localhost/youtubeUpload/api-samples-master/php/resumable_upload.php');

    // URL
    define('AUTH_URL', 'https://accounts.google.com/o/oauth2/auth');

    $params = array(
        'client_id' => CONSUMER_KEY,
        'redirect_uri' => CALLBACK_URL,
        'scope' => 'client_id redirect_uri response_type scope approval_prompt access_type state',
        'response_type' => 'code',
    );

    // 認証ページにリダイレクト
    header("Location: " . AUTH_URL . '?' . http_build_query($params));
    
?>
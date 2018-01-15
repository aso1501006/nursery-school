<?php
require_once dirname(__FILE__)."/ScheduleManager.php";
require_once dirname(__FILE__)."/ParentsTblDT.php";
require_once dirname(__FILE__)."/MoviePhotoTblDT.php";
require_once dirname(__FILE__)."/MoviesTblDT.php";
require_once dirname(__FILE__)."/SchedulesTblDT.php";
require_once dirname(__FILE__)."/NurserySchoolsTblDT.php";
require_once dirname(__FILE__)."/TagsTblDT.php";
require_once dirname(__FILE__)."/PhotosTagsTblDT.php";
require_once dirname(__FILE__)."/MoviesTagsTblDT.php";

//テーブル用のクラスを読み込む
class DBManager{
  private $user = "testuser";
  private $password = "password";
  private $dbhost = "localhost";
  private $dbname = "childtimeDB";
  private $myPdo;



  //接続のメソッド
  public function dbConnect(){
    try{
      $this->myPdo = new PDO('mysql:host=' . $this->dbhost . ';dbname=' . $this->dbname  . ';charset=utf8', $this->user, $this->password, array(PDO::ATTR_EMULATE_PREPARES => false));

    }catch(PDOException $e) {
      print('データベース接続失敗。'.$e->getMessage());
      throw $e;
    }
  }

  //切断のメソッド
  public function dbDisconnect(){
    unset($myPdo);
  }

    public function nursery_school_select($nursery_school_id){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('SELECT nursery_school_id,nursery_school_name,password,address,update_date FROM nursery_schools WHERE nursery_school_id = :nursery_school_id');
            $stmt->bindValue(':nursery_school_id', $nursery_school_id, PDO::PARAM_STR);
          
            //SQLを実行
            $stmt->execute();

        
            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
              //データを入れるクラスをnew
              $rowData = new NurserySchoolsTblDT();

              //DBから取れた情報をカラム毎に、クラスに入れていく
              $rowData->set_nursery_school_id($row["nursery_school_id"]);
              $rowData->set_nursery_school_name($row["nursery_school_name"]);
              $rowData->set_password($row["password"]);
              $rowData->set_address($row["address"]);
              $rowData->set_update_date($row["update_date"]);

              //取得した一件を配列に追加する
              $retList[] = $rowData;
            }
      
          $this->dbDisconnect();
      
          //結果が格納された配列を返す
          return $retList;

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    //public function nursery_school_insert($nursery_school_name,$address){}
    //public function nursery_school_update_password($nursery_school_id,$password){}
    //public function nursery_school_update_address($nursery_school_id,$address){}
    //public function nursery_school_delete($nursery_school_id){}
    //public function nursery_school_select_all(){}

    public function parent_select($parent_id){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('SELECT * FROM parents WHERE parent_id = :parent_id');
            $stmt->bindValue(':parent_id', $parent_id, PDO::PARAM_STR);
          
            //SQLを実行
            $stmt->execute();

        
            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
              //データを入れるクラスをnew
              $rowData = new ParentsTblDT();

              //DBから取れた情報をカラム毎に、クラスに入れていく
              $rowData->set_parent_id($row["parent_id"]);
              $rowData->set_nursery_id($row["nursery_school_id"]);
              $rowData->set_parent_name($row["parent_name"]);
              $rowData->set_password($row["password"]);

              //取得した一件を配列に追加する
              $retList[] = $rowData;
            }
      
          $this->dbDisconnect();
      
          //結果が格納された配列を返す
          return $retList;

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    //public function parent_insert($nursery_school_id,$parent_name){}
    //public function parent_update($parent_id,$password){}
    //public function parent_delete($parent_id){}
    //public function parent_select_all($nursery_school_id){}
    public function schedule_select($nursery_school_id,$schedule_date){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('SELECT schedule_id,nursery_school_id,schedule_date,schedule_name,schedule_content,tag_id FROM schedules WHERE nursery_school_id = :nursery_school_id AND schedule_date = :schedule_date');
            $stmt->bindValue(':nursery_school_id', $nursery_school_id, PDO::PARAM_STR);
            $stmt->bindValue(':schedule_date', $schedule_date, PDO::PARAM_STR);
          
            //SQLを実行
            $stmt->execute();

        
            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
                //データを入れるクラスをnew
                $rowData = new SchedulesTblDT();

                //DBから取れた情報をカラム毎に、クラスに入れていく
                //$rowData->set_nursery_school_id($row["nursery_school_id"]);
                $rowData->schedule_id = $row["schedule_id"];
                $rowData->nursery_school_id = $row["nursery_school_id"];
                $rowData->schedule_date = $row["schedule_date"];
                $rowData->schedule_name = $row["schedule_name"];
                $rowData->schedule_content = $row["schedule_content"];
                $rowData->tag_id = $row["tag_id"];

                //取得した一件を配列に追加する
                $retList[] = $rowData;
            }
      
          $this->dbDisconnect();
      
          //結果が格納された配列を返す
          return $retList;

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function schedule_select_between($nursery_school_id,$start_date,$end_date){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('SELECT schedule_id,nursery_school_id,schedule_date,schedule_name,schedule_content,tag_id FROM schedules WHERE nursery_school_id = :nursery_school_id AND schedule_date BETWEEN :start_dat AND :end_date');
            $stmt->bindValue(':nursery_school_id', $nursery_school_id, PDO::PARAM_STR);
            $stmt->bindValue(':start_dat', $start_date, PDO::PARAM_STR);
            $stmt->bindValue(':end_date', $end_date, PDO::PARAM_STR);
          
            //SQLを実行
            $stmt->execute();

        
            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
                //データを入れるクラスをnew
                $rowData = new SchedulesTblDT();

                //DBから取れた情報をカラム毎に、クラスに入れていく
                //$rowData->set_nursery_school_id($row["nursery_school_id"]);
                $rowData->schedule_id = htmlspecialchars($row["schedule_id"]);
                $rowData->nursery_school_id = htmlspecialchars($row["nursery_school_id"]);
                $rowData->schedule_date = htmlspecialchars($row["schedule_date"]);
                $rowData->schedule_name = htmlspecialchars($row["schedule_name"]);
                $rowData->schedule_content = htmlspecialchars($row["schedule_content"]);
                $rowData->tag_id = htmlspecialchars($row["tag_id"]);

                //取得した一件を配列に追加する
                $retList[] = $rowData;
            }
      
          $this->dbDisconnect();
      
          //結果が格納された配列を返す
          return $retList;

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function schedule_insert($nursery_school_id,$schedule_name,$schedule_date){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('INSERT INTO schedules (nursery_school_id,schedule_date,schedule_name) VALUES (:nursery_school_id,:schedule_date,:schedule_name)');
            $stmt->bindValue(':nursery_school_id', $nursery_school_id, PDO::PARAM_STR);
            $stmt->bindValue(':schedule_date', $schedule_date, PDO::PARAM_STR);
            $stmt->bindValue(':schedule_name', $schedule_name, PDO::PARAM_STR);

          
            //SQLを実行
            $stmt->execute();

            $this->dbDisconnect();

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function schedule_update($nursery_school_id,$schedule_date,$schedule_name,$schedule_aName){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('UPDATE schedules SET schedule_name = :schedule_aName WHERE nursery_school_id = :nursery_school_id AND schedule_date = :schedule_date AND schedule_name = :schedule_name');
            $stmt->bindValue(':nursery_school_id', $nursery_school_id, PDO::PARAM_STR);
            $stmt->bindValue(':schedule_date', $schedule_date, PDO::PARAM_STR);
            $stmt->bindValue(':schedule_name', $schedule_name, PDO::PARAM_STR);
            $stmt->bindValue(':schedule_aName', $schedule_aName, PDO::PARAM_STR);

          
            //SQLを実行
            $stmt->execute();

            $this->dbDisconnect();

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    //public function schedule_update_tag($schedule_date,$nursery_school_id,$tag_name,$schedule_name){}
    public function schedule_delete($nursery_school_id,$schedule_date,$schedule_name){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('DELETE FROM schedules WHERE schedule_name = :schedule_name AND nursery_school_id = :nursery_school_id');
            $stmt->bindValue(':schedule_date', $schedule_date, PDO::PARAM_STR);
            $stmt->bindValue(':schedule_name', $schedule_name, PDO::PARAM_STR);
            $stmt->bindValue(':nursery_school_id', $nursery_school_id, PDO::PARAM_STR);

          
            //SQLを実行
            $stmt->execute();

            $this->dbDisconnect();

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function tag_select($tag_id){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('SELECT tag_id,nursery_school_id,tag_name FROM tags WHERE tag_id = :tag_id');
            $stmt->bindValue(':tag_id', $tag_id, PDO::PARAM_STR);
          
            //SQLを実行
            $stmt->execute();

        
            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
              //データを入れるクラスをnew
              $rowData = new TagsTblDT();

              //DBから取れた情報をカラム毎に、クラスに入れていく
              $rowData->tag_id = $row["tag_id"];
              $rowData->nursery_school_id = $row["nursery_school_id"];
              $rowData->tag_name = $row["tag_name"];

              //取得した一件を配列に追加する
              $retList[] = $rowData;
            }
      
          $this->dbDisconnect();
      
          //結果が格納された配列を返す
          return $retList;

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function tag_insert($nursery_school_id,$tag_name){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('INSERT INTO tags (nursery_school_id,tag_name) VALUES (:nursery_school_id,:tag_name)');
            $stmt->bindValue(':nursery_school_id', $nursery_school_id, PDO::PARAM_STR);
            $stmt->bindValue(':tag_name', $tag_name, PDO::PARAM_STR);


          
            //SQLを実行
            $stmt->execute();

            $this->dbDisconnect();

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function tag_update($tag_id,$tag_name){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('UPDATE tags SET tag_name = :tag_name WHERE tag_id = :tag_id');
            $stmt->bindValue(':tag_id', $tag_id, PDO::PARAM_STR);
            $stmt->bindValue(':tag_name', $tag_name, PDO::PARAM_STR);
          
            //SQLを実行
            $stmt->execute();

            $this->dbDisconnect();

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function tag_delete($tag_id){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('DELETE FROM tags WHERE tag_id = :tag_id');
            $stmt->bindValue(':tag_id', $tag_id, PDO::PARAM_STR);

          
            //SQLを実行
            $stmt->execute();

            $this->dbDisconnect();

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function tag_select_all($nursery_school_id){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('SELECT tag_id,nursery_school_id,tag_name FROM tags WHERE nursery_school_id = :nursery_school_id');
            $stmt->bindValue(':nursery_school_id', $nursery_school_id, PDO::PARAM_STR);
          
            //SQLを実行
            $stmt->execute();

        
            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
              //データを入れるクラスをnew
              $rowData = new TagsTblDT();

              //DBから取れた情報をカラム毎に、クラスに入れていく
              $rowData->tag_id = htmlspecialchars($row["tag_id"]);
              $rowData->nursery_school_id = htmlspecialchars($row["nursery_school_id"]);
              $rowData->tag_name = htmlspecialchars($row["tag_name"]);

              //取得した一件を配列に追加する
              $retList[] = $rowData;
            }
      
          $this->dbDisconnect();
      
          //結果が格納された配列を返す
          return $retList;

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function movie_select($movie_id){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('SELECT movie_id,nursery_school_id,movie_name,movie_date,movie_path,movie_URL FROM movies WHERE movie_id = :movie_id');
            $stmt->bindValue(':movie_id', $movie_id, PDO::PARAM_STR);
          
            //SQLを実行
            $stmt->execute();

        
            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
              //データを入れるクラスをnew
              $rowData = new MoviePhotoTblDT();

              //DBから取れた情報をカラム毎に、クラスに入れていく
              //$rowData->set_nursery_school_id($row["nursery_school_id"]);
              
                $rowData->id = $row["movie_id"];
                $rowData->nursery_school_id = $row["nursery_school_id"];
                $rowData->name = $row["movie_name"];
                $rowData->date = $row["movie_date"];
                $rowData->path = $row["movie_path"];
                $rowData->movie_URL = $row["movie_URL"];
            

              //取得した一件を配列に追加する
              $retList[] = $rowData;
            }
      
          $this->dbDisconnect();
      
          //結果が格納された配列を返す
          return $retList;

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function movie_select_new($nursery_school_id,$limit_num){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('SELECT movie_id,nursery_school_id,movie_name,movie_date,movie_path,movie_URL FROM movies WHERE nursery_school_id = :nursery_school_id ORDER BY movie_date DESC limit '.$limit_num);
            $stmt->bindValue(':nursery_school_id', $nursery_school_id, PDO::PARAM_STR);
          
            //SQLを実行
            $stmt->execute();

        
            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
              //データを入れるクラスをnew
              $rowData = new MoviePhotoTblDT();

              //DBから取れた情報をカラム毎に、クラスに入れていく
              //$rowData->set_nursery_school_id($row["nursery_school_id"]);
              
                $rowData->id = $row["movie_id"];
                $rowData->nursery_school_id = $row["nursery_school_id"];
                $rowData->name = $row["movie_name"];
                $rowData->date = $row["movie_date"];
                $rowData->path = $row["movie_path"];
                $rowData->movie_URL = $row["movie_URL"];

              //取得した一件を配列に追加する
              $retList[] = $rowData;
            }
      
          $this->dbDisconnect();
      
          //結果が格納された配列を返す
          return $retList;

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function movie_select_tag($tags){
      try{
            //DBに接続
            $this->dbConnect();
            $where = ' WHERE ';
            $cnt = 0;
            foreach($tags as $tag){
                if((int)$tag['value'] !== 0){
                  $where .= 'tag_id = ' . htmlspecialchars($tag['value']) . ' OR ';
                  $cnt += 1;
                }
            }
            $where = rtrim($where,'OR ');
            $sql = 'SELECT DISTINCT movie_id,nursery_school_id,movie_name,movie_date,movie_URL,movie_path FROM movies WHERE movie_id IN (SELECT movie_id FROM movies_tags' . $where . ' GROUP BY movie_id HAVING count(*)='.$cnt.')';
            //SQLを生成
            $stmt = $this->myPdo->prepare($sql);
            //$stmt->bindValue(':tag_id', $tag_id, PDO::PARAM_STR);
          
            //SQLを実行
            $stmt->execute();

            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
              //データを入れるクラスをnew
              $rowData = new MoviesTblDT();

              //DBから取れた情報をカラム毎に、クラスに入れていく
              //$rowData->set_nursery_school_id($row["nursery_school_id"]);
              
              $rowData->id = $row["movie_id"];
              $rowData->nursery_school_id = $row["nursery_school_id"];
              $rowData->name = $row["movie_name"];
              $rowData->date = $row["movie_date"];
              $rowData->movie_URL = $row["movie_URL"];
              $rowData->path = $row["movie_path"];
              //取得した一件を配列に追加する
              $retList[] = $rowData;
            }
            
            
          $this->dbDisconnect();
      
          //結果が格納された配列を返す
          //return $sql;
          return $retList;

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function movie_insert($movie_name,$nursery_school_id,$movie_date,$movie_path){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('INSERT INTO movies (nursery_school_id,movie_name,movie_date,movie_path) VALUES (:nursery_school_id,:movie_name,:movie_date,:movie_path)');
            $stmt->bindValue(':nursery_school_id', $nursery_school_id, PDO::PARAM_STR);
            $stmt->bindValue(':movie_name', $movie_name, PDO::PARAM_STR);
            $stmt->bindValue(':movie_date', $movie_date, PDO::PARAM_STR);
            $stmt->bindValue(':movie_path', $movie_path, PDO::PARAM_STR);

          
            //SQLを実行
            $stmt->execute();

            $this->dbDisconnect();

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function movie_update($movie_id,$movie_name){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('UPDATE movies SET movie_name = :movie_name WHERE movie_id = :movie_id');
            $stmt->bindValue(':movie_id', $movie_id, PDO::PARAM_STR);
            $stmt->bindValue(':movie_name', $movie_name, PDO::PARAM_STR);
          
            //SQLを実行
            $stmt->execute();

            $this->dbDisconnect();

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function movie_update_URL($movie_name,$movie_URL){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('UPDATE movies SET movie_URL = :movie_URL WHERE movie_name = :movie_name');
            $stmt->bindValue(':movie_name', $movie_name, PDO::PARAM_STR);
            $stmt->bindValue(':movie_URL', $movie_URL, PDO::PARAM_STR);

          
            //SQLを実行
            $stmt->execute();

            $this->dbDisconnect();

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function movie_delete($movie_id){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('DELETE FROM movies WHERE movie_id = :movie_id');
            $stmt->bindValue(':movie_id', $movie_id, PDO::PARAM_STR);

          
            //SQLを実行
            $stmt->execute();

            $this->dbDisconnect();

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function photo_select($photo_id){
            try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('SELECT photo_id,nursery_school_id,photo_name,photo_date,photo_path FROM photos WHERE photo_id = :photo_id');
            $stmt->bindValue(':photo_id', $photo_id, PDO::PARAM_STR);
          
            //SQLを実行
            $stmt->execute();

        
            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
              //データを入れるクラスをnew
              $rowData = new MoviePhotoTblDT();

              //DBから取れた情報をカラム毎に、クラスに入れていく
              //$rowData->set_nursery_school_id($row["nursery_school_id"]);
              
                $rowData->id = $row["photo_id"];
                $rowData->nursery_school_id = $row["nursery_school_id"];
                $rowData->name = $row["photo_name"];
                $rowData->date = $row["photo_date"];
                $rowData->path = $row["photo_path"];
            

              //取得した一件を配列に追加する
              $retList[] = $rowData;
            }
      
          $this->dbDisconnect();
      
          //結果が格納された配列を返す
          return $retList;

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function photo_select_new($nursery_school_id,$limit_num){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('SELECT photo_id,nursery_school_id,photo_name,photo_date,photo_path FROM photos WHERE nursery_school_id = :nursery_school_id ORDER BY photo_date DESC limit '.$limit_num);
            $stmt->bindValue(':nursery_school_id', $nursery_school_id, PDO::PARAM_STR);
          
            //SQLを実行
            $stmt->execute();

        
            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
              //データを入れるクラスをnew
              $rowData = new MoviePhotoTblDT();

              //DBから取れた情報をカラム毎に、クラスに入れていく
              //$rowData->set_nursery_school_id($row["nursery_school_id"]);
              
                $rowData->id = $row["photo_id"];
                $rowData->nursery_school_id = $row["nursery_school_id"];
                $rowData->name = $row["photo_name"];
                $rowData->date = $row["photo_date"];
                $rowData->path = $row["photo_path"];
            

              //取得した一件を配列に追加する
              $retList[] = $rowData;
            }
      
          $this->dbDisconnect();
      
          //結果が格納された配列を返す
          return $retList;

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function photo_select_tag($tags){
      try{
            //DBに接続
            $this->dbConnect();
            $where = ' WHERE ';
            $cnt = 0;
            foreach($tags as $tag){
                if((int)$tag['value'] !== 0){
                  $where .= 'tag_id = ' . htmlspecialchars($tag['value']) . ' OR ';
                  $cnt += 1;
                }
            }
            $where = rtrim($where,'OR ');
            $sql = 'SELECT DISTINCT photo_id,nursery_school_id,photo_name,photo_date,photo_path FROM photos WHERE photo_id IN (SELECT photo_id FROM photos_tags' . $where . ' GROUP BY photo_id HAVING count(*)='.$cnt.')';
            //SQLを生成
            $stmt = $this->myPdo->prepare($sql);
            //$stmt->bindValue(':tag_id', $tag_id, PDO::PARAM_STR);
          
            //SQLを実行
            $stmt->execute();

            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
              //データを入れるクラスをnew
              $rowData = new MoviePhotoTblDT();

              //DBから取れた情報をカラム毎に、クラスに入れていく
              //$rowData->set_nursery_school_id($row["nursery_school_id"]);
              
              $rowData->id = $row["photo_id"];
              $rowData->nursery_school_id = $row["nursery_school_id"];
              $rowData->name = $row["photo_name"];
              $rowData->date = $row["photo_date"];
              $rowData->path = $row["photo_path"];
              //取得した一件を配列に追加する
              $retList[] = $rowData;
            }
            
            
          $this->dbDisconnect();
      
          //結果が格納された配列を返す
          //return $sql;
          return $retList;

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function photo_insert($photo_name,$nursery_school_id,$photo_date,$photo_path){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('INSERT INTO photos (nursery_school_id,photo_name,photo_date,photo_path) VALUES (:nursery_school_id,:photo_name,:photo_date,:photo_path)');
            $stmt->bindValue(':nursery_school_id', $nursery_school_id, PDO::PARAM_STR);
            $stmt->bindValue(':photo_name', $photo_name, PDO::PARAM_STR);
            $stmt->bindValue(':photo_date', $photo_date, PDO::PARAM_STR);
            $stmt->bindValue(':photo_path', $photo_path, PDO::PARAM_STR);

          
            //SQLを実行
            $stmt->execute();

            $this->dbDisconnect();

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function photo_update($photo_id,$photo_name){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('UPDATE photos SET photo_name = :photo_name WHERE photo_id = :photo_id');
            $stmt->bindValue(':photo_id', $photo_id, PDO::PARAM_STR);
            $stmt->bindValue(':photo_name', $photo_name, PDO::PARAM_STR);

            //SQLを実行
            $stmt->execute();

            $this->dbDisconnect();

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function photo_delete($photo_id){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('DELETE FROM photos WHERE photo_id = :photo_id');
            $stmt->bindValue(':photo_id', $photo_id, PDO::PARAM_STR);

          
            //SQLを実行
            $stmt->execute();

            $this->dbDisconnect();

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function movie_tag_insert($movie_id,$tag_id){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('INSERT INTO movies_tags (movie_id,tag_id) VALUES (:movie_id,:tag_id)');
            $stmt->bindValue(':movie_id', $movie_id, PDO::PARAM_STR);
            $stmt->bindValue(':tag_id', $tag_id, PDO::PARAM_STR);

          
            //SQLを実行
            $stmt->execute();

            $this->dbDisconnect();

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function movie_tag_delete($movie_id){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('DELETE FROM movies_tags WHERE movie_id = :movie_id;');
            $stmt->bindValue(':movie_id', $movie_id, PDO::PARAM_STR);
          
            //SQLを実行
            $stmt->execute();

            $this->dbDisconnect();

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function movie_tag_check($tag_id){

    }
    public function photo_tag_insert($photo_id,$tag_id){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('INSERT INTO photos_tags (photo_id,tag_id) VALUES (:photo_id,:tag_id)');
            $stmt->bindValue(':photo_id', $photo_id, PDO::PARAM_STR);
            $stmt->bindValue(':tag_id', $tag_id, PDO::PARAM_STR);

          
            //SQLを実行
            $stmt->execute();

            $this->dbDisconnect();

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function photo_tag_delete($photo_id){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('DELETE FROM photos_tags WHERE photo_id = :photo_id');
            $stmt->bindValue(':photo_id', $photo_id, PDO::PARAM_STR);
          
            //SQLを実行
            $stmt->execute();

            $this->dbDisconnect();

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function photo_tag_check($tag_id){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('SELECT tag_id FROM tags WHERE EXISTS (SELECT * FROM photos_tags WHERE tag_id = :tag_id)');
            $stmt->bindValue(':tag_id', $tag_id, PDO::PARAM_STR);
        
            //SQLを実行
            $stmt->execute();

        
            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
              //データを入れるクラスをnew
              $rowData = new MoviesTagsTblDT();

              //DBから取れた情報をカラム毎に、クラスに入れていく
              $rowData->movie_id = $row["movie_id"];
              $rowData->tag_id = $row["tag_id"];

              //取得した一件を配列に追加する
              $retList[] = $rowData;
            }
      
          $this->dbDisconnect();
      
          //結果が格納された配列を返す
          return $retList;

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    //public function nursery_photo_select($nursery_school_id){}
    public function movie_get_tag($movie_id){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('SELECT tag_id, tag_name FROM tags WHERE tag_id IN(SELECT tag_id FROM movies_tags WHERE movie_id = :movie_id)');
            $stmt->bindValue(':movie_id', $movie_id, PDO::PARAM_STR);

            //SQLを実行
            $stmt->execute();

        
            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
              //データを入れるクラスをnew
              $rowData = new MoviesTagsTblDT();

              //DBから取れた情報をカラム毎に、クラスに入れていく
              $rowData->tag_id = $row["tag_id"];
              $rowData->tag_name = $row["tag_name"];

              //取得した一件を配列に追加する
              $retList[] = $rowData;
            }
      
          $this->dbDisconnect();
      
          //結果が格納された配列を返す
          return $retList;

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    public function photo_get_tag($photo_id){
      try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare('SELECT tag_id, tag_name FROM tags WHERE tag_id IN(SELECT tag_id FROM photos_tags WHERE photo_id = :photo_id)');
            $stmt->bindValue(':photo_id', $photo_id, PDO::PARAM_STR);

            //SQLを実行
            $stmt->execute();

        
            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
              //データを入れるクラスをnew
              $rowData = new PhotosTagsTblDT();

              //DBから取れた情報をカラム毎に、クラスに入れていく
              $rowData->tag_id = $row["tag_id"];
              $rowData->tag_name = $row["tag_name"];

              //取得した一件を配列に追加する
              $retList[] = $rowData;
            }
      
          $this->dbDisconnect();
      
          //結果が格納された配列を返す
          return $retList;

        }catch (PDOException $e) {
        print('検索に失敗。'.$e->getMessage());
      }
    }
    //動画のidを取得するメソッド
    function movie_id_get($m_path){
      try{
        //DBに接続
        $this->dbConnect();

        $stmt = $this->myPdo -> prepare("SELECT movie_id from movies where movie_path = :path");
        $stmt->bindValue(':path', $m_path, PDO::PARAM_STR);

        //SQL実行
        $stmt->execute();

        $rt = null;

        while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
          $rt = $row["movie_id"];
        }

        //DB切断
        $this->dbDisconnect();

        //結果が格納された変数を返す
        return $rt;
        //header('Location: registerOK.html');
      }catch (PDOException $e) {
        print('書き込み失敗。'.$e->getMessage());
        throw $e;
        //header('Location: registerNG.html');
      }
    }
    //画像のidを取得するメソッド
    function photo_id_get($ph_path){
      try{
        //DBに接続
        $this->dbConnect();

        $stmt = $this->myPdo -> prepare("SELECT photo_id from photos where photo_path = :path");
        $stmt->bindValue(':path', $ph_path, PDO::PARAM_STR);

        //SQL実行
        $stmt->execute();
        
        $rt = null;
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
          $rt = $row["photo_id"];
        }

        //DB切断
        $this->dbDisconnect();

        //結果が格納された変数を返す
        return $rt;
        //header('Location: registerOK.html');
      }catch (PDOException $e) {
        print('書き込み失敗。'.$e->getMessage());
        throw $e;
        //header('Location: registerNG.html');
      }
    }    

    function get_tag_favorite($limit){
      try{
        //DBに接続
        $this->dbConnect();

        $stmt = $this->myPdo -> prepare("SELECT tag.tag_id,tag.tag_name
                                         FROM (SELECT tag_id,COUNT(*) as cnt
                                               FROM(SELECT movie_id,tag_id FROM movies_tags
			                                                UNION
		                                                SELECT photo_id,tag_id FROM photos_tags) as tags
                                                    GROUP BY tag_id) as tag_cnt,tags as tag
                                         WHERE tag_cnt.tag_id = tag.tag_id
                                         ORDER BY cnt DESC
                                         LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_STR);

        //SQL実行
        $stmt->execute();
        
        $rt = array();
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
          $tag = new TagsTblDT();
          $tag->tag_id=$row["tag_id"];
          $tag->tag_name=$row["tag_name"];
          $rt[] = $tag;
        }
        //DB切断
        $this->dbDisconnect();

        //結果が格納された変数を返す
        return $rt;
        //header('Location: registerOK.html');
      }catch (PDOException $e) {
        print('書き込み失敗。'.$e->getMessage());
        throw $e;
        //header('Location: registerNG.html');
      }
    }
  /*//検索のメソッド
  public function getTestTblById(){
    try{
      //DBに接続
      $this->dbConnect();

      //SQLを生成
      $stmt = $this->myPdo->prepare('SELECT * FROM ItemTable');
     
      //SQLを実行
      $stmt->execute();

  
      //取得したデータを１件ずつループしながらクラスに入れていく
      $retList = array();
      while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
        //データを入れるクラスをnew
        $rowData = new TestTblDT();

        //DBから取れた情報をカラム毎に、クラスに入れていく
        $rowData->id = $row["ItemName"];
        $rowData->mail = $row["Price"];

        //取得した一件を配列に追加する
        array_push($retList, $rowData);
      }
  
      $this->dbDisconnect();
  
      //結果が格納された配列を返す
      return $retList;

    }catch (PDOException $e) {
      print('検索に失敗。'.$e->getMessage());
    }
  }

  //書き込みのメソッド
  public function insertTestTbl($inId, $inMail){
    try{
      //DBに接続
      $this->dbConnect();
  $ItemName = $_POST['ItemName'];
  $Price = $_POST['Price'];
      $stmt = $this->myPdo -> prepare("INSERT INTO ItemTable (ItemName,Price ) VALUES (:ItemName, :Price)");
      $stmt->bindValue(':ItemName', $ItemName, PDO::PARAM_STR);
      $stmt->bindValue(':Price', $Price, PDO::PARAM_STR);
      
      //SQL実行
      $stmt->execute();

      //DB切断
      $this->dbDisconnect();

    }catch (PDOException $e) {
      print('書き込み失敗。'.$e->getMessage());
      throw $e;
    }

  }*/

}
?>
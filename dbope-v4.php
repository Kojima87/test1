<?php

class DBOpe {
  public $conn;
  
  //　コンストラクタ
  public function __construct()
  {
    $this->connectDB();
  }
  
  public function connectDB() {
    try {
      // MySQLサーバへ接続
//      $this->conn = new PDO("mysql:host=localhost; dbname=guestbook", "root", "root");
     $this->conn = new PDO("mysql:dbname=guestbook;host=localhost", "root", "root");
   } catch(PDOException $e){
        exit('DB接続失敗'.$e->getMessage());}
// var_dump($this->conn);
  }
  
  // メッセージの取得
  public function getData()
  {
    $sql = "SELECT * FROM message ORDER BY m_id DESC";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    return $stmt;
  } // end getData

  // メッセージの書き込み
  public function writeData($m_name,$m_mail,$m_message)
  {
  // データの追加
    $sql = "INSERT INTO message(m_name, m_mail, m_message, m_dt)
          VALUES(:m_name, :m_mail, :m_message, NOW())";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":m_name", $m_name);
    $stmt->bindParam(":m_mail", $m_mail);
    $stmt->bindParam(":m_message", $m_message);
    $stmt->execute();

    // エラーチェック
    $error = $stmt->errorInfo();
    if ($error[0] != "00000") {
        $message = "データの追加に失敗しました。{$error[2]}";
    } else {
        $message = "データを追加しました。データ番号：" . $this->conn->lastInsertId();
    }
 // var_dump($message);
  } // end writeData

  // メッセージの削除
  public function deleteData($m_id)
  {
    $sql = "DELETE FROM message WHERE (m_id = :m_id);";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":m_id", $m_id);
    $stmt->execute();
    
  } // end deleteData

} // end class
?>


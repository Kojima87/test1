<?php

class DBAccess {
  public $conn;
  
  //　コンストラクタ
  public function __construct()
  {
    $this->connectDB();
  }
  
  public function connectDB() {
      // MySQLサーバへ接続
     $this->conn = new PDO("mysql:dbname=guestbook;host=localhost", "root", "root");
  }
  
  // 全メッセージの取得
  public function getData()
  {
    $sql = "SELECT * FROM message ORDER BY id DESC";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    return $stmt;
  } // end getData

// 親メッセージの取得
  public function getParents()
  {
    $sql = "SELECT * FROM message WHERE parentId = 0 ORDER BY id DESC";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt;
  } // end getData

// 子メッセージの取得
  public function getChildren($parent_no)
  {
    $sql = "SELECT * FROM message  WHERE parentId = :parent_no ORDER BY id DESC";
//    $sql = "SELECT * FROM message  WHERE parentId = $parent_no ORDER BY id DESC";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":parent_no", $parent_no);
    $stmt->execute();
    return $stmt;
  } // end getData

  // メッセージの書き込み
  public function writeData($parentId,$name,$mail,$message)
  {
//var_dump($parentId);

  // データの追加
    $sql = "INSERT INTO message(parentId,name, mail, message, created_at)
          VALUES(:parentId,:name, :mail, :message, NOW())";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":parentId", $parentId);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":mail", $mail);
    $stmt->bindParam(":message", $message);
    $stmt->execute();
    return $stmt;
  } // end writeData

  // メッセージの削除
  public function deleteData($id)
  {
    $sql = "DELETE FROM message WHERE (id = :id OR parentId = :id);";
//    $sql = "DELETE FROM message WHERE (id = $id OR parentId = $id);";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    return $stmt;
  } // end deleteData
} // end class
?>


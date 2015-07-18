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

  public function get1Data($id) {
    $sql = "SELECT * FROM message WHERE (id = :id)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    return $stmt;
  }

// 親メッセージの取得
  public function getParents()
  {
// commentsテーブルを作成したためParentIdは不要だが、今はこのまま・・・
//    $sql = "SELECT * FROM message WHERE parentId = 0 ORDER BY id DESC LIMIT 100";
    $sql = "SELECT * FROM message ORDER BY id DESC LIMIT 100";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt;
  } // end getData

// 子メッセージの取得
  public function getChildren($parent_no)
  {
    $sql = "SELECT * FROM comments INNER JOIN message on comments.parentId = message.id WHERE comments.parentId = :parent_no ORDER BY comments.id DESC";
//    $sql = "SELECT * FROM message  WHERE parentId = $parent_no ORDER BY id DESC";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":parent_no", $parent_no);
    $stmt->execute();
    return $stmt;
  } // end getData

  // メッセージの書き込み
  public function writeData($parentId,$name,$mail,$msg)
  {
//var_dump($parentId);

  // データの追加
    $sql = "INSERT INTO message(parentId,name, mail, msg, created_at)
          VALUES(:parentId,:name, :mail, :msg, NOW())";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":parentId", $parentId);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":mail", $mail);
    $stmt->bindParam(":msg", $msg);
    $stmt->execute();
var_dump($stmt);
    return $stmt;
  } // end writeData

  public function writeCommentData($parentId,$name,$mail,$comment)
  {
  // データの追加
    $sql = "INSERT INTO comments(parentId,name, mail, comment, created_at)
          VALUES(:parentId,:name, :mail, :comment, NOW())";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":parentId", $parentId);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":mail", $mail);
    $stmt->bindParam(":comment", $comment);
    $stmt->execute();
    return $stmt;
  } // end writeData


  // データの更新（変更）
  public function updateData($no,$parentId,$name,$mail,$msg)
  {
 //   $sql = "UPDATE message SET parentId=:parentId,name =:name, mail=:mail, message=:message WHERE id =:no";
    $sql = "UPDATE message SET parentId=:parentId, name=:name, mail=:mail,msg=:msg WHERE id =:id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":id", $no);
    $stmt->bindParam(":parentId", $parentId);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":mail", $mail);
    $stmt->bindParam(":msg", $msg);
    $stmt->execute();
    return $stmt;
  }

  // データの削除
  public function deleteData($id)
  {
    $sql = "DELETE FROM message WHERE (id = :id);";
//    $sql = "DELETE FROM message WHERE (id = :id OR parentId = :id);";
//    $sql = "DELETE FROM message WHERE (id = $id OR parentId = $id);";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    return $stmt;
  } // end deleteData

  public function deleteCommData($id)
  {
    $sql = "DELETE FROM comments WHERE (parentId = :id);";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    return $stmt;
  } // end deleteData

  public function searchData($word)
  {
    $sql = "SELECT * FROM message WHERE msg like '%$word%'";
    $stmt = $this->conn->prepare($sql);
//    $stmt->bindParam(":word", $word);
    $stmt->execute();
    return $stmt;
  }

} // end class

?>


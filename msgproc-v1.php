<?php
require_once 'dbope-v4.php';

class MsgProc
{
  // データアクセスクラスインスタンス
  protected $dbdb;
  
  // コンストラクタ
  public function __construct()
  {
    $this->dbdb = new DBOpe();
    
  } // end construct
  
  // ★メッセージ取得
  public function getMsgData()
  {
    $stmt = $this->dbdb->getData();
    return $stmt;
    
  } // end getMsgData

  // ★メッセージ書き込み
  public function writeMsgData()
  {
    // 入力内容の取得
    $m_name = htmlspecialchars($_POST["m_name"], ENT_QUOTES, "UTF-8");
    $m_mail = htmlspecialchars($_POST["m_mail"], ENT_QUOTES, "UTF-8");
    $m_message = htmlspecialchars($_POST["m_message"], ENT_QUOTES, "UTF-8");

    if ($m_name == "" or $m_message == "") {
//      echo "名前とメッセージは必須です";
    }
    else {
      $this->dbdb->writeData($m_name,$m_mail,$m_message);
    }
  
  } // end writeMsgData

  // ★メッセージ削除
  public function deleteMsgData($post,$idx)
  {

      $no = $post['idno'][$idx];
      
      $this->dbdb->deleteData($no);
  }
/*
<script type="text/javascript">
    function submitChk () {
        var $flag = confirm ( "よろしいですか？");
var_dump($flag);
        return $flag;
    }
</script>
*/


} // end class
?>


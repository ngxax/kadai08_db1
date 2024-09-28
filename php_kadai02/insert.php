<?php
//1. POSTデータ取得
$name      = $_POST["name"];
$email     = $_POST["email"];
$select_day= $_POST["select_day"];
$memo      = $_POST["memo"];


//2. DB接続します
try {
    //Password:MAMP='root',XAMPP=''
    $pdo = new PDO('mysql:dbname=gs_participants_db;charset=utf8;host=localhost','root','');
  } catch (PDOException $e) {
    exit('DB_CONECT:'.$e->getMessage());
  }
  
//３．データ登録SQL作成
$sql="INSERT INTO gs_participants_table(name,email,select_day,memo,indate)VALUES(:name,:email,:select_day,:memo,sysdate());";
$stmt = $pdo->prepare($sql);
//  データに危ないものがないかクリーニングする
$stmt->bindValue(':name',       $name,        PDO::PARAM_STR);
$stmt->bindValue(':email',      $email,       PDO::PARAM_STR);
$stmt->bindValue(':select_day', $select_day,  PDO::PARAM_STR);
$stmt->bindValue(':memo',       $memo,        PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

$status = $stmt->execute(); //SQL実行 true or false



//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}else{
  //５．index.phpへリダイレクト
      header("Location: index.php");
      exit();

}
?>
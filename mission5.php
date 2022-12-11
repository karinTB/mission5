<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5</title>
    <style>
</style>
</head>
<body>
<body style="background-color:#a6a5c4;">



<?php
error_reporting(E_ALL & ~E_NOTICE);
?>
<?php 
//Mission_4-1//
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
//Mission_4-2//
    $sql = "CREATE TABLE IF NOT EXISTS tbtest"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "pass TEXT,"
    . "date TEXT"
    .");";
    $stmt = $pdo->query($sql);

    $name = $_POST["name"];
    $comment = $_POST["comment"]; //好きな名前、好きな言葉は自分で決めること
    $pass=$_POST["pass"];
    $pass_A=$_POST["pass_A"];
    $pass_B=$_POST["pass_B"];
    $date=date("Y/m/d H:i:s");
    $delete = $_POST["delete"];intval($delete);
    $edit=$_POST["edit"];intval($edit);
//書き込み
    if((!empty($name))&&(!empty($comment))
    &&(!empty($pass))){
    if(empty($edit)){
    $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment, pass, date) VALUES (:name, :comment, :pass, :date)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
    $sql -> execute();}

 //編集   
    //Mission4-7//
    //bindParamの引数（:nameなど）は4-2でどんな名前のカラムを設定したかで変える必要がある。
    else{
    $id = $edit; //変更する投稿番号
    $name = $_POST["name"];
    $comment = $_POST["comment"]; //変更したい名前、変更したいコメントは自分で決めること
    $sql = 'UPDATE tbtest SET name=:name,comment=:comment,pass=:pass,date=:date WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
    $stmt -> bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();}}
    
    if((!empty($edit))&&(!empty($pass_B))){
    $id=$edit;
    $sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        if($row['id']==$edit){
        if($row['pass']==$pass_B){
    $newname=$row['name'];
    $newcomment=$row['comment'];
    $newpass=$row['pass'];
    }}}}



//削除
    if((!empty($delete))&&(!empty($pass_A)))
    {
    //Mission_4-8//
    $id = $delete;
        $sql = 'SELECT * FROM tbtest';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
        if($row['pass']==$pass_A){
    $sql = 'delete from tbtest where id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
   $stmt->execute();}}}

?>
<span style="color:#292933;font-size: 35px;
font-family:游明朝;">
<div style="text-align:center;">
    簡易掲示板</div></span>

    <form action="" method="post">
        <input type="text" name="name" placeholder="名前" value="<?php echo $newname ?? ''; ?>" class="textbox">
        <input type="text" name="comment" placeholder="コメント" value="<?php echo $newcomment ?? ''; ?>" class="textbox">
        <input type="text" name="pass" placeholder="パスワード" value="<?php echo $newpass ?? ''; ?>" class="textbox">
        <input type="submit" name="submit">
    <br>
        <input type="number" name="delete" placeholder="削除対象番号" class="textbox">
        <input type="text" name="pass_A" placeholder="パスワードを入力ください" class="textbox">
        <input type="submit" name="submit" value="削除">
    <br>
        <input type="number" name="edit" placeholder="編集対象番号"  value="<?php echo $edit ?? ''; ?>" class="textbox">
        <input type="text" name="pass_B" placeholder="パスワードを入力ください" class="textbox">
        <input type="submit" name="edit_b" value="編集">
    </form>

<br>
<span style="color:white;font-size:20px;
font-family:游明朝;">
<div style="background-color:#1f1f66;text-align:center;">
投稿一覧↓</div></span>

<div style="background-color:#e7e7eb;">
<?php    
//Mission_4-6//
    //$rowの添字（[ ]内）は、4-2で作成したカラムの名称に併せる必要があります。
    $sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo '・';
        echo $row['id'].' ';
        echo $row['name'].' ';
        echo $row['comment'].' ';
        echo $row['date'].'<br>';
    echo "<hr>";
    }
?>
</div>
</body>
</html>


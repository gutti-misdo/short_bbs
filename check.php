<?php
session_start();
?>
<?php
try {
    include 'db-connect.php';
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = $pdo->prepare('select * from user where username=?');
    $sql->execute([$_POST['user']]);
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    if ($_POST['password']===$result['password']) {
        $_SESSION['user'] = [
            'id' => $result['id'],
            'username' => $result['username'],
        ];
        header('Location: form.php');
        exit();
    } else {
        echo "ログイン認証に失敗しました。";
        echo "EmailかPasswordが違います。";
    }
} catch (PDOException $e) {
    echo '接続失敗: ' . $e->getMessage();
}
$pdo = null;
?>
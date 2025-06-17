<?php
session_start();
?>
<?php
$name = htmlspecialchars($_SESSION['user']['username'] ?? '名無し');
$comment = htmlspecialchars($_POST['comment'] ?? '');
$time = date('Y-m-d H:i:s');

include 'db-connect.php';
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = $pdo->prepare('INSERT INTO comment(user_id, content)VALUES(?,?)');
$sql ->execute([$_SESSION['user']['id'], $comment]);
$pdo = null;

if (trim($comment) === '') {
    header("Location: form.php");
    exit;
}

$entry = "$time\t$name\t$comment\n";
file_put_contents('comments.txt', $entry, FILE_APPEND);
header("Location: view.php");
exit;
?>

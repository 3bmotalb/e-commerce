<?php 
session_start();
$nonav='';
$title='Login';
if(isset($_SESSION['Username']))
{
    header('Location: homeadmin.php');
}
include 'init.php';
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $username=$_POST['user'];
    $password=$_POST['pass'];
    $hashedPass = sha1($password);

    $stmt=$con->prepare("SELECT userid, Username, Password FROM users WHERE Username= ? AND Password= ? AND groupid=1 LIMIT 1");
    $stmt->execute(array($username, $hashedPass));
    $row=$stmt->fetch();
    $count=$stmt->rowCount();
    
    if($count > 0)
    $_SESSION['Username']=$username; //session name with the same name of user
    $_SESSION['username']=$row['username'];
    $_SESSION['ID']=$row['userid'];
    header('Location: homeadmin.php'); // go to admin home
    exit();
}
?>

<form class="login_form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <h4 class="text-center">Admin Login</h4>
    <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off">
    <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="off">
    <input class="btn btn-primary btn-block" type="submit" value="login" />
</form>
<?php include $temp.'footer.php'; ?>
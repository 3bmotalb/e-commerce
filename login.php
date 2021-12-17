<?php 
session_start();
$title='Login';
if(isset($_SESSION['User']))
{

    header('Location: index.php');
}
include 'init.php';
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $username=$_POST['user_name'];
    $password=$_POST['user_password'];
    $hashedPass = sha1($password);


    $stmt=$con->prepare("SELECT  groupid, Username, Password FROM users WHERE Username= ? AND Password= ? ");
    $stmt->execute(array($username, $hashedPass));
    $row=$stmt->fetch();
    $count=$stmt->rowCount();

    
    
    if($count > 0 && $row['groupid'] == 0)
    {
    $_SESSION['User']=$username;

   header('Location: index.php'); // go to admin home
    exit();
    }
    elseif($row['groupid'==1])
    {   
        header('Location: admin/index.php'); // go to admin home
        exit();
    }
    else 
    {
        echo "No Data Found For this user";
    }


}
?>
<div class="container">

    <form class="well form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="contact_form">
        <fieldset>

            <!-- Form Name -->
            <h2 class="text-center">Login</h2>

            <!-- Text input-->

            <div class="form-group">



                <div class="form-group">
                    <label class="col-md-4 control-label">Username</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-user">

                                </i></span>
                            <input name="user_name"
                             placeholder="Username"
                              class="form-control" type="text">
                        </div>
                    </div>
                </div>

                <!-- Text input-->

                <div class="form-group">
                    <label class="col-md-4 control-label">Password</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input name="user_password" placeholder="Password" class="form-control" type="password">
                        </div>
                    </div>
                </div>


                <!-- Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-4"><br>
                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button type="submit"
                            class="btn btn-warning">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspLogin <span
                                class="glyphicon glyphicon-send"></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</button>
                    </div>
                </div>

        </fieldset>
    </form>
</div>
</div><!-- /.container -->
<?php include $temp.'footer.php'; 
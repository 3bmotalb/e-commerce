<?php
$title='Sign Up';
session_start();

if(isset($_SESSION['User']))
{
    header('Location: index.php');
}

include 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $errors = array();
  $user= $_POST['user_name'];
  $name= $_POST['full_name'];
  $email= $_POST['email'];
  $password   = $_POST['password'];
  $password2   = $_POST['password2'];
  $shpass1=sha1($password);
  $shpass2=sha1($password2);

  if (isset($password) && isset($password2)) {

    if (empty($password)) {

      $errors[] = 'Sorry Password Cant Be Empty';
    }

    if ($shpass1 !== $shpass2) {

      $errors[] = 'Sorry Password Is Not Match';
    }
  }

  if(empty($errors))
  {
    $checkuser = checkitemexist("Username", "users", $user);

    echo $checkuser;
    
    if( $checkuser == 1 )
    {
      $errors[] = 'Sorry Username Is Exist';
    }

    else{
      //IF USERNAME UNIQUE
				//START STATEMENT
				$stmt = $con->prepare("INSERT INTO users(Username, Password, email, fullname,date) VALUES(?, ?, ?, ?,now()) ");

				//EXECUTE SATEMENT BY SEND DATA TO DATABASE USE AN ARRAY
				$stmt->execute(array($user, $shpass1, $email, $name));

				//CAL NUMBER OF RECORDS HAS CHANGE
				$count = $stmt->rowCount();

          header('Location: index.php');
      
    }

    
  }
}

?>
<div class="container">

    <form class="well form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST"
        enctype="multipart/form-data" id="contact_form">
        <fieldset>

            <!-- Form Name -->
            <h2 class="text-center">Registration Form</h2>

            <!-- Text input-->

            <div class="form-group">

                <label class="col-md-4 control-label">Full Name</label>
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input name="full_name" placeholder="First Name" class="form-control" required="required"
                            type="text">
                    </div>
                </div>
            </div>

            <!-- Text input-->

            <!--<div class="form-group">
<label class="col-md-4 control-label" >Last Name</label> 
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<input name="last_name"
 placeholder="Last Name"
  class="form-control"
  required="required"

    type="text">
</div>
</div>
</div>-->



            <!-- Text input-->

            <div class="form-group">
                <label class="col-md-4 control-label">Username</label>
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input name="user_name" pattern=".{4,}" title="username must be more than 4 chars"
                            placeholder="Username" class="form-control" required="required" type="text">
                    </div>
                </div>
            </div>

            <!-- Text input-->

            <div class="form-group">
                <label class="col-md-4 control-label">Password</label>
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input name="password" minlenght="4" placeholder="Password" class="form-control"
                            required="required" type="password">
                    </div>
                </div>
            </div>

            <!-- Text input-->

            <div class="form-group">
                <label class="col-md-4 control-label">Confirm Password</label>
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input name="password2" placeholder="Confirm Password" class="form-control" required="required"
                            type="password">
                    </div>
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label">E-Mail</label>
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input name="email" placeholder="E-Mail Address" class="form-control" required="required"
                            type="text">
                    </div>
                </div>
            </div>


            <!-- Text input-->

            <div class="form-group">
                <label class="col-md-4 control-label">Contact No.</label>
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                        <input name="contact_no" placeholder="(01)" class="form-control" type="text">
                    </div>
                </div>
            </div>

            <!-- Select Basic -->



            <!-- Button -->
            <div class="form-group">
                <label class="col-md-4 control-label"></label>
                <div class="col-md-4"><br>
                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                    <button type="submit" class="btn btn-warning">
                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSUBMIT <span class="glyphicon glyphicon-send"></span>
                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                    </button>
                </div>
            </div>

        </fieldset>
    </form>

    <div class="messg text-center">
        <?php
    if (!empty($errors)) {

      foreach ($errors as $error) {

        echo '<div class="msg error">' . $error . '</div>';
      }
    }





    ?>
    </div>
</div>
</div><!-- /.container -->
<?php

include $temp . 'footer.php';
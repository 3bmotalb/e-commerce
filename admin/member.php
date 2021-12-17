<?php

//session get user name and id of the active session
session_start();
//title of the page and it will send as prameter to gettitle() function which in header.php
$title = 'Member';

//check if there was a seesion or ni
if (isset($_SESSION['Username'])) {
	//inclue all files from init.php
	include 'init.php';

	//check on the way which data method to direct you to the specific page if there is no method  the defult will be 'Mange'
	$do = isset($_GET['do']) ? $_GET['do'] : 'Mange';

	// mange users
	if ($do == 'Mange') {
		//start conection between database

		//statement 
		$stmt = $con->prepare("SELECT * FROM users WHERE groupid != 1");

		// execute the statement
		$stmt->execute();

		//fetch all data from data base and put it in array rows
		$rows = $stmt->fetchAll();

?>

<!-- design of Mange Page-->
<h1 class="text-center">Manage Members</h1>
<div class="container">
    <div class="table-responsive">

        <table class="main-table manage-members text-center table table-bordered">

            <thead>
                <td>ID</td>
                <td>Username</td>
                <td>Email</td>
                <td>Full Name</td>
                <td>Registered Since</td>
                <td>Control</td>
            </thead>

            <?php

					//loop will put all data in there places

					foreach ($rows as $row) {
						// design of put data in table
						echo "<tr>";
						echo "<td>" . $row['userid'] . "</td>";
						echo "<td>" . $row['Username'] . "</td>";
						echo "<td>" . $row['email'] . "</td>";
						echo "<td>" . $row['fullname'] . "</td>";
						echo "<td>" . $row['date'] . "</td>";
						// TWO BUTTON WILL DO TWO ACTINS (EDIT AND DELETE)
						echo "<td>
								<a href='member.php?do=Edit&userid=" . $row['userid'] . "' class='btn btn-success confirm'>Edit</a>
								<a href='member.php?do=Delete&userid=" . $row['userid'] . "' class='btn btn-danger confirm'>Remove</a>
								</td>";
						echo "</tr>";
					}
					?>
        </table>
    </div>
    <a href="member.php?do=Add" class="btn btn-primary">Add User</a>
</div>

<?php
		// END OF DESIGN MANGE PAGE

	} elseif ($do == 'Add') {
		// Add Page
		//START DESIGN
	?>

<h1 class="text-center">Add New Member</h1>
<div class="container">
    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">


        <!-- Start Username Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="username" class="form-control" autocomplete="off" required="required"
                    placeholder="Username To Login Into Shop" />
            </div>
        </div>
        <!-- End Username Field -->


        <!-- Start Password Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10 col-md-6">
                <input type="password" name="password" class="password form-control" required="required"
                    autocomplete="new-password" placeholder="Password Must Be Hard & Complex" />
            </div>
        </div>
        <!-- End Password Field -->


        <!-- Start Email Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-6">
                <input type="email" name="email" class="form-control" required="required"
                    placeholder="Email Must Be Valid" />
            </div>
        </div>
        <!-- End Email Field -->


        <!-- Start Full Name Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Full Name</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="full" class="form-control" required="required"
                    placeholder="Full Name Appear In Your Profile Page" />
            </div>
        </div>
        <!-- End Full Name Field -->


        <!-- Start Avatar Field 
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">User Avatar</label>
					<div class="col-sm-10 col-md-6">
						<input type="file" name="avatar" class="form-control" required="required" />
					</div>
				</div> -->


        <!-- Start Submit Field -->
        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
            </div>
        </div>
        <!-- End Submit Field -->


    </form>
</div>

<?php
		//END OF DESIGN
	} elseif ($do == "Insert") {

		//CHECK IF METHOD IS POST OR NOT    ALLOWED IN THIS PAGE TO POST ONLY 
		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			//STORE DATA FROM FORM TO VARIABLES
			$user 	= $_POST['username'];
			$pass 	= $_POST['password'];
			$email 	= $_POST['email'];
			$name 	= $_POST['full'];
			$hashPass = sha1($_POST['password']);


			//CHECK IF USERNAME IS USED OR NOT BY FUNCTION 
			$checkuser = checkitemexist("Username", "users", $user);

			if ($checkuser == 1) {
				$messg = '<div class="alert alert-danger">Username is Exist</div>';
				go2home($messg, 'back', 10);
			} else {
				//IF USERNAME UNIQUE
				//START STATEMENT
				$stmt = $con->prepare("INSERT INTO users(Username, Password, email, fullname,date) VALUES(?, ?, ?, ?,now()) ");

				//EXECUTE SATEMENT BY SEND DATA TO DATABASE USE AN ARRAY
				$stmt->execute(array($user, $hashPass, $email, $name));

				//CAL NUMBER OF RECORDS HAS CHANGE
				$count = $stmt->rowCount();

				$messg = "<div class='alert alert-info'>$count record inserted</div>";
				go2home($messg, 'back', 10);
			}
		}
		//IF USER COME TO PAGE USED A LINK OR GUESS OR ANY METHOD ISNOT POST 
		else {
			$messg = '<div class="alert alert-danger">Sorry you can not browse this page directly</div>';
			go2home($messg, 'back', 10);
		}
	} elseif ($do == 'Edit') {
		//عشاان ميلغبطش في الurl فوق و يحط اي كلام

		// بتأكد اني باخد قيمة عددية بس

		$userId = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

		//بروح ع الداتا بيز اجيب البيانات بتاعت الاي دي دا

		$stmt = $con->prepare(
			"SELECT * FROM users WHERE userid= ?"
		);

		//بنفذ الاستعلام بالمتغير اللي مخزن فيه القيمة
		$stmt->execute(array($userId));
		// بجيب الداتا اخزنها 
		$row = $stmt->fetch();
		// بشوف انا لقيت داتا ولاا لاء و اد اي عددها 
		$count = $stmt->rowCount();
		// لو لقيت انها اكبر من الصفر بروح اعمل الفورمو ظهر البيانات 
		if ($count > 0) {
			if ($row['groupid'] == 1)
				$type = 'Admin';
			else
				$type = 'User'
		?>

<h1 class="text-center">Edit <?php echo $type; ?> </h1>
<div class="container">
    <form class="form-horizontal" action="?do=Update" method="POST">
        <input type="hidden" name="userid" value="<?php echo $userId ?>" />


        <!-- Start Username Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>"
                    autocomplete="off" required="required" />
            </div>
        </div>
        <!-- End Username Field -->


        <!-- Start Password Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">New Password</label>
            <div class="col-sm-10 col-md-6">
                <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
                <input type="password" name="newpassword" class="form-control" autocomplete="new-password"
                    placeholder="Leave Blank If You Dont Want To Change" />
            </div>
        </div>
        <!-- End Password Field -->


        <!-- Start Email Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-6">
                <input type="email" name="email" value="<?php echo $row['email'] ?>" class="form-control"
                    required="required" />
            </div>
        </div>
        <!-- End Email Field -->


        <!-- Start Full Name Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Full Name</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="full" value="<?php echo $row['fullname'] ?>" class="form-control"
                    required="required" />
            </div>
        </div>
        <!-- End Full Name Field -->


        <!-- Start Submit Field -->
        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Save" class="btn btn-primary btn-lg" />
            </div>
        </div>
        <!-- End Submit Field -->


    </form>
</div>
<?php
		} else {	// لو مفيش بقا حد بالاي دي دا بقوله انه مفيش 
			$messg = '<div class="alert alert-danger">Sorry There is no this id</div>';
			go2home($messg, 'back', 10);
		}
	} elseif ($do == 'Update') {
		//CHHEK IS METHOD IS POST
		echo '<h1 class="text-center">Edit Member</h1>';
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $_POST['userid'];
			$username = $_POST['username'];
			$email = $_POST['email'];
			$fullname = $_POST['full'];

			//TO CHECK PASSWORD IS THE SAME OR NOT
			$pass = '';

			//CHECK IF USERNAME IS USED OR NOT BY FUNCTION 

			$pass = empty($_POST['newpassword']) ? $pass = $_POST['oldpassword'] : $pass = sha1($_POST['newpassword']);

			$stmt1 = $con->prepare("SELECT * FROM users WHERE Username=? And userid !=?");
			$stmt1->execute(array($username, $id));

			if ($stmt1->rowCount() == 1) {
				$messg = "<div class='alert alert-info'> Username Was Exist  </div>";
				go2home($messg, 'back', 10);
			} else {
				$stmt = $con->prepare("UPDATE users SET Username= ?,Password= ?,email= ?,fullname= ? WHERE userid= ?");
				$stmt->execute(array($username, $pass, $email, $fullname, $id));
				$count = $stmt->rowCount();
				$messg = "<div class='alert alert-info'> $count Record Updated  </div>";
				go2home($messg, 'back', 10);
			}
		}
	} elseif ($do == 'Delete') {
		$userId = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

		//بروح ع الداتا بيز اجيب البيانات بتاعت الاي دي دا

		$stmt = $con->prepare(
			"SELECT * FROM users WHERE userid= ?"
		);

		//بنفذ الاستعلام بالمتغير اللي مخزن فيه القيمة
		$stmt->execute(array($userId));

		// بشوف انا لقيت داتا ولاا لاء و اد اي عددها 
		$count = $stmt->rowCount();
		// لو لقيت انها اكبر من الصفر بروح اعمل الفورمو ظهر البيانات 
		if ($count > 0) {
			$stmt = $con->prepare("DELETE FROM users WHERE userid= ?");
			$stmt->execute(array($userId));
			$count = $stmt->rowCount();
			$messg = "<div class='alert alert-info'> $count Record Deleted </div>";
			go2home($messg, 'back', 10);
		} else {
			$messg = '<div class="alert alert-danger">Sorry There is no this id</div>';
			go2home($messg, 'back', 10);
		}
	}


	include $temp . 'footer.php';
} else {
	header('Location: index.php');
	exit();
}
<?php
session_start();
$title = 'ITems';
if (isset($_SESSION['Username'])) {
	include 'init.php';
	$do = isset($_GET['do']) ? $_GET['do'] : 'Mange';

	if ($do == 'Mange') {
		$stmt = $con->prepare("SELECT * FROM item ORDER BY itemid DESC");
		$stmt->execute();
		$rows = $stmt->fetchAll();
?>
<h1 class="text-center">Manage Items</h1>
<div class="container">
    <div class="table-responsive">
        <table class="main-table manage-item text-center table table-bordered">
            <thead>
                <td>ID</td>
                <td>Image</td>
                <td>Item Name</td>
                <td>Price</td>
                <td>Description</td>
                <td>Date</td>
                <td>Last Modify</td>
                <td>Status</td>
                <!-- <td>Category Name</td> -->
                <td>Control</td>
            </thead>
            <?php
					foreach ($rows as $row) {
						echo "<tr>";
						echo "<td>" . $row['itemid'] . "</td>";
						echo "<td>";
									if (empty($row['image'])) {
										echo 'No Image';
									} else {
										echo "<img src='uploads/" . $row['image'] . "' alt='' />";
									}
									echo "</td>";
						echo "<td>" . $row['itemname'] . "</td>";
						echo "<td>" . $row['price'] . "</td>";
						echo "<td>" . $row['description'] . "</td>";
						echo "<td>" . $row['date'] . "</td>";
						echo "<td>" . $row['last_mod'] . "</td>";
						echo "<td>";
						if ($row['status'] == 1) {
							echo '<a href="item.php?do=Change&status=' . 0 . '&itemid=' . $row['itemid'] .'">';
							echo '<span class="btn btn-success ">';
							echo '<i class="fa fa-enable"></i> Available';
							echo '</span>';
							echo '</a>';
						} else {
							echo '<a href="item.php?do=Change&status=' . 1 . '&itemid=' . $row['itemid'] .'">';
							echo '<span class="btn btn-danger ">';
							echo '<i class="fa fa-danger"></i> Unavailable';
							echo '</span>';
							echo '</a>';
						}
						echo "</td>";
						echo "<td>
								<a href='item.php?do=Edit&itemid=" . $row['itemid'] . "' class='btn btn-success'>Edit</a>
								<a href='item.php?do=Delete&itemid=" . $row['itemid'] . "' class='btn btn-danger confirm'>Remove</a>";
						if ($row['accept'] == 0) {
							echo "<a href='item.php?do=Accept&itemid=" . $row['itemid'] . "' class='btn btn-info '>Accept</a>";
						}
						echo "</td>";



						echo "</tr>";
					}
					?>
        </table>
    </div>
    <a href="item.php?do=Add" class="btn btn-primary">Add Category</a>
</div>
<?php
	} elseif ($do == 'Add') { ?>

<h1 class="text-center">Add New Item</h1>
<div class="container">
    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">

        <!-- Start Username Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Item Name</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="name" class="form-control" autocomplete="off" required="required"
                    placeholder="Item Name" />
            </div>
        </div>

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Desciption</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="description" class="form-control" autocomplete="off"
                    placeholder="Item Description">

            </div>
        </div>

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Price</label>
            <div class="col-sm-10 col-md-6">
                <input type="number" name="price" class="form-control" autocomplete="off" required="required"
                    placeholder="Item Price " />

            </div>
        </div>

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10 col-md-6">
                <div>
                    <input id="en-yes" type="radio" name="status" value="1" checked />
                    <label for="en-yes">Available</label>
                </div>

                <div>
                    <input id="en-no" type="radio" name="status" value="0" />
                    <label for="en-no">Unavailable</label>
                </div>

            </div>
        </div>

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Category</label>
            <div class="col-sm-10 col-md-6">
                <select class="form-control" name="category">
                    <?php
							$stmt = $con->prepare("SELECT * FROM category");
							$stmt->execute();
							$categories = $stmt->fetchAll();
							foreach ($categories as $category) {
								echo "<option value='" . $category['catid'] . "'>" . $category['catname'] . "</option>";
							}
							?>

                </select>

            </div>

        </div>

        <!-- Start Avatar Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">User Avatar</label>
            <div class="col-sm-10 col-md-6">
                <input type="file" name="avatar" class="form-control" required="required" />
            </div>
        </div>


        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Add Item" class="btn btn-primary btn-lg" />
            </div>
        </div>
        <!-- End Submit Field -->
    </form>
</div>

<?php
	} elseif ($do == 'Insert') {
		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			// Upload Variables

			$avatarName = $_FILES['avatar']['name'];
			$avatarSize = $_FILES['avatar']['size'];
			$avatarTmp	= $_FILES['avatar']['tmp_name'];
			$avatarType = $_FILES['avatar']['type'];

			// List Of Allowed File Typed To Upload

			$avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

			// Get Avatar Extension

			$avatarExtension = strtolower(end(explode('.', $avatarName)));

			$avatar = rand(0, 10000000000) . '_' . $avatarName;

			move_uploaded_file($avatarTmp, "uploads\\" . $avatar);


			$name 	= $_POST['name'];
			$price 	= $_POST['price'];
			$description = $_POST['description'];
			$status 	= $_POST['status'];
			$category 	= $_POST['category'];





			$stmt = $con->prepare("INSERT INTO item(itemname, price, description, date, last_mod, status, catid,image) VALUES(?, ?, ?, now(), now(),?, ?,?) ");
			$stmt->execute(array($name, $price, $description, $status, $category,$avatar));
			$count = $stmt->rowCount();
			$messg = "<div class='alert alert-info'>$count record inserted</div>";
			go2home($messg, 'back', 10);
		} else
			$messg = '<div class="alert alert-danger">Sorry you can not browse this page directly</div>';
		go2home($messg, 'back', 10);
	} elseif ($do == 'Edit') {
		//عشاان ميلغبطش في الurl فوق و يحط اي كلام

		// بتأكد اني باخد قيمة عددية بس

		$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

		//بروح ع الداتا بيز اجيب البيانات بتاعت الاي دي دا

		$stmt = $con->prepare("SELECT * FROM item WHERE itemid= ?");

		//بنفذ الاستعلام بالمتغير اللي مخزن فيه القيمة
		$stmt->execute(array($itemid));
		// بجيب الداتا اخزنها 
		$row = $stmt->fetch();
		// بشوف انا لقيت داتا ولاا لاء و اد اي عددها 
		$count = $stmt->rowCount();
		// لو لقيت انها اكبر من الصفر بروح اعمل الفورمو ظهر البيانات 
		echo $count;
		if ($count > 0) { ?>

<h1 class="text-center">Edit Item</h1>
<div class="container">
    <form class="form-horizontal" action="?do=Ubdate" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="itemid" value="<?php echo $row['itemid'] ?>" />
        <!-- Start Username Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Item Name</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="name" class="form-control" required="required" placeholder="Item Name"
                    value="<?php echo $row['itemname'] ?>" />
            </div>
        </div>

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Desciption</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="description" class="form-control" autocomplete="off" placeholder="Item Name"
                    value="<?php echo $row['description'] ?>">
                </input>
            </div>
        </div>

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Price</label>
            <div class="col-sm-10 col-md-6">
                <input type="number" name="price" class="form-control" autocomplete="off" required="required"
                    placeholder="Item Price " value="<?php echo $row['price'] ?>" />

            </div>
        </div>

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10 col-md-6">
                <div>
                    <input id="en-yes" type="radio" name="status" value="1"
                        <?php if ($row['status'] == 1) echo 'Checked'; ?> />
                    <label for="en-yes">Available</label>
                </div>

                <div>
                    <input id="en-no" type="radio" name="status" value="0"
                        <?php if ($row['status'] == 0) echo 'Checked'; ?> />
                    <label for="en-no">Unavailable</label>
                </div>

            </div>
        </div>

        <!--<div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Category</label>
                    <div class="col-sm-10 col-md-6">
                        <select class="form-control" name="category">
                            
                            <?php
							$stmt = $con->prepare("SELECT * FROM category");
							$stmt->execute();
							$categories = $stmt->fetchAll();

							foreach ($categories as $category) {
								echo "<option value='" . $category['catid'] . "'>" . $category['catname'] . "</option>";

								if ($row['catid'] == $category['catid']) {
									$category_name = $category['catname'];
								}
							}
							?>

                        </select>

                    </div>

                </div>-->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Current Category</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" disabled="disabled" name="name" class="form-control" required="required"
                    placeholder="Item Name" value="<?php echo $category_name ?>" />
            </div>
        </div>


        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Add Item" class="btn btn-primary btn-lg" />
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
	} elseif ($do == 'Ubdate') {
		echo '<h1 class="text-center">Edit Item</h1>';
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $_POST['itemid'];
			$name = $_POST['name'];
			//$category=$_POST['category'];
			$description = $_POST['description'];
			$price = $_POST['price'];
			$status = $_POST['status'];




			$stmt = $con->prepare("UPDATE item SET itemname= ?, description= ?, price= ?, status= ?, last_mod=now() WHERE itemid= ?");
			$stmt->execute(array($name, $description, $price, $status, $id));
			$count = $stmt->rowCount();

			if ($count > 0) {
				$messg = "<div class='alert alert-info'> $count Record Updated  </div>";
				go2home($messg, 'back', 10);
			} else {
				$messg = "<div class='alert alert-info'>No UBDATED  </div>";
				go2home($messg, 'back', 10);
			}
		}
	} elseif ($do == 'Delete') {
		$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

		//بروح ع الداتا بيز اجيب البيانات بتاعت الاي دي دا

		$stmt = $con->prepare(
			"SELECT * FROM item WHERE itemid= ?"
		);

		//بنفذ الاستعلام بالمتغير اللي مخزن فيه القيمة
		$stmt->execute(array($itemid));

		// بشوف انا لقيت داتا ولاا لاء و اد اي عددها 
		$count = $stmt->rowCount();
		// لو لقيت انها اكبر من الصفر بروح اعمل الفورمو ظهر البيانات 
		if ($count > 0) {
			$stmt = $con->prepare("DELETE FROM item WHERE itemid= ?");
			$stmt->execute(array($itemid));
			$count = $stmt->rowCount();
			$messg = "<div class='alert alert-info'> $count Record Deleted </div>";
			go2home($messg, 'back', 10);
		} else {
			$messg = '<div class="alert alert-danger">Sorry There is no this id</div>';
			go2home($messg, 'back', 10);
		}



	} elseif ($do == 'Accept') {
		echo "<h1 class='text-center'> Accept Item</h1>";
		echo "<div class='container'>";

		$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

		$check = checkitemexist('itemid', 'item', $itemid);

		if ($check > 0) {
			$stmt = $con->prepare("UPDATE item SET accept= 1 WHERE itemid= ?");
			$stmt->execute(array($itemid));
			$count = $stmt->rowCount();

			$messg = $count > 0 ? "<div class='alert alert-info'> $count Record Updated  </div>" : $messg = "<div class='alert alert-info'>No UBDATED  </div>";
			go2home($messg, 'back', 3);
		} else {
			$messg = $count > 0 ? "<div class='alert alert-info'> Id not Exist  </div>" : $messg = "<div class='alert alert-info'>No UBDATED  </div>";
			go2home($messg, 'back', 3);
		}

		echo "</div>";
	}

	elseif ($do == 'Change') {
		echo "<h1 class='text-center'> Accept Item</h1>";
		echo "<div class='container'>";

		$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
		$status = isset($_GET['status']) && is_numeric($_GET['status']) ? intval($_GET['status']) : 0;

		$check = checkitemexist('itemid', 'item', $itemid);

		if ($check > 0) {
			$stmt = $con->prepare("UPDATE item SET last_mod= now() ,status = ? WHERE itemid= ?");
			$stmt->execute(array($status,$itemid));
			$count = $stmt->rowCount();

			$messg = $count > 0 ? "<div class='alert alert-info'> $count Record Updated  </div>" : $messg = "<div class='alert alert-info'>No UBDATED  </div>";
			go2home($messg, 'back', 3);
		} else {
			$messg = $check > 0 ? "<div class='alert alert-info'> Id not Exist  </div>" : $messg = "<div class='alert alert-info'>No UBDATED  </div>";
			go2home($messg, 'back', 3);
		}

		echo "</div>";
	}



} else {
	header('Location: index.php');
	exit();
}
include $temp . 'footer.php';

?>
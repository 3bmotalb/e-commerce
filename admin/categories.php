<?php
session_start();
$title='Cateogries';
if(isset($_SESSION['Username']))
{
    include 'init.php';
    $do=isset($_GET['do']) ? $_GET['do'] : 'Mange';

    if($do == 'Mange')
    {
        $stmt =$con->prepare("SELECT * FROM category");
		$stmt->execute();
		$rows= $stmt->fetchAll();
		?>
			<h1 class="text-center">Manage Categories</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table manage-categories text-center table table-bordered">
						<thead>
							<td>ID</td>
							<td>Cateogry Name</td>
							<td>Descreption</td>
							<td>Enable State</td>
                            <td>Control</td>
						</thead>
						<?php
						foreach($rows as $row)
							{
								echo "<tr>";
								echo "<td>". $row['catid'] . "</td>";
								echo "<td>". $row['catname'] . "</td>";
								echo "<td>". $row['descriotion'] . "</td>";
								echo "<td>"; if( $row['enable'] == 1){
                                                    echo '<span class="btn btn-success ">';	
                                                    echo '<i class="fa fa-enable"></i> Enabled';	
													echo '</span>';
                                                }
                                                else
                                                {
                                                    echo '<span class="btn btn-danger ">';
														echo '<i class="fa fa-disable"></i> Disabled';	
													echo '</span>';
                                                }
                                     echo "</td>";
								echo "<td>
								<a href='categories.php?do=Edit&catid=". $row['catid'] ."' class='btn btn-success '>Edit</a>
								<a href='categories.php?do=Delete&catid=". $row['catid'] ."' class='btn btn-danger confirm'>Remove</a>
								</td>";
								
								echo "</tr>";

							}	
						?>
	</table>
	</div>
	<a href="categories.php?do=Add" class="btn btn-primary">Add Category</a>
	</div>
	<?php
    }

    elseif($do == 'Add')
    {
        // Add Page ?>

		<h1 class="text-center">Add New Category</h1>
		<div class="container">
			<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
				<!-- Start category name Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Category Name</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="catname" class="form-control" autocomplete="off" required="required" placeholder="Category Name" />
					</div>
				</div>
				<!-- End category Name Field -->
				<!-- Start des Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Description</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="decription" class="form-control"  placeholder="Desciption" >
					</div>
				</div>
				<!-- End des Field -->
				<!-- Start Enable Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label" >Enable</label>
					<div class="col-sm-10 col-md-6">
						<div>
                            <input id="en-yes" type="radio" name="enable" value="1" />
                            <label for="en-yes">Yes</label>
                        </div>

                        <div>
                            <input id="en-no" type="radio" name="enable" value="0" checked  />
                            <label for="en-no">No</label>
                        </div>

					</div>
				</div>
				<!-- End Enable Name Field -->


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
						<input type="submit" value="Add CATEGORY" class="btn btn-primary btn-lg" />
					</div>
				</div>
				<!-- End Submit Field -->
			</form>
		</div>

	<?php 
    }

    elseif($do == 'Insert')
    {
        if($_SERVER['REQUEST_METHOD']=="POST")
		{
				$category 	= $_POST['catname'];
				$description 	= $_POST['decription'];
				$enable 	= $_POST['enable'];
				
				
				
				$checkuser=checkitemexist("catname","category",$category);
				if($checkuser>=1){
					$messg= '<div class="alert alert-danger">Category Name is Exist</div>';
					go2home($messg,'back',10);
				}
				else{
				$stmt = $con->prepare("INSERT INTO category(catname, descriotion, enable) VALUES(?, ?, ?) ");
				$stmt->execute(array($category,$description,$enable));
				$count=$stmt->rowCount();
				$messg= "<div class='alert alert-info'>$count record inserted</div>";
				go2home($messg,'back',10);
                
				}
		}
		else
		$messg= '<div class="alert alert-danger">Sorry you can not browse this page directly</div>';
				go2home($messg,'back',10);

	
    }

    elseif($do == 'Edit')
    {
        //عشاان ميلغبطش في الurl فوق و يحط اي كلام
		
		// بتأكد اني باخد قيمة عددية بس

		$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

		//بروح ع الداتا بيز اجيب البيانات بتاعت الاي دي دا

		$stmt=$con->prepare("SELECT * FROM category WHERE catid= ?");

		//بنفذ الاستعلام بالمتغير اللي مخزن فيه القيمة
		$stmt->execute(array($catid));
		// بجيب الداتا اخزنها 
		$row=$stmt->fetch();
		// بشوف انا لقيت داتا ولاا لاء و اد اي عددها 
		$count=$stmt->rowCount();
		// لو لقيت انها اكبر من الصفر بروح اعمل الفورمو ظهر البيانات 
		echo $count;
        if($count > 0)
			{?>
			
		<h1 class="text-center">Edit Category</h1>
					<div class="container">
						<form class="form-horizontal" action="?do=Ubdate" method="POST">
							<input type="hidden" name="catid" value="<?php echo $catid ?>" />
							<!-- Start Username Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Category Name</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="category" class="form-control" value="<?php echo $row['catname'] ?>" autocomplete="off" required="required" />
								</div>
							</div>
							<!-- End Username Field -->
							<!-- Start Email Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Description</label>
								<div class="col-sm-10 col-md-6">
									<input type="text-area" name="description"  class="form-control" required="required" value="<?php echo $row['descriotion'] ?>"></textarea>
								</div>
							</div>
							<!-- End Email Field -->
							<!-- Start Full Name Field -->
                            <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label" >Enable</label>
                                    <div class="col-sm-10 col-md-6">
                                        <div>
                                            <input id="en-yes" type="radio" name="enable" value="1" <?php if($row['enable'] == 1) echo 'Checked'; ?> />
                                            <label for="en-yes">Yes</label>
                                        </div>

                                        <div>
                                            <input id="en-no" type="radio" name="enable" value="0" <?php if($row['enable'] == 0) echo 'Checked'; ?> />
                                            <label for="en-no">No</label>
                                        </div>

                                    </div>
				            </div>
                            <div class="form-group form-group-lg">
				            	<div class="col-sm-offset-2 col-sm-10">
					            	<input type="submit" value="Add Category" class="btn btn-primary btn-lg" />
				            	</div>
				            </div>
				            <!-- End Submit Field -->

							
						</form>
					</div>
					<?php
				} 
				else
				{	// لو مفيش بقا حد بالاي دي دا بقوله انه مفيش 
				$messg= '<div class="alert alert-danger">Sorry There is no this id</div>';
				go2home($messg,'back',10);}
    }

    elseif($do == 'Ubdate')
    {
        echo '<h1 class="text-center">Edit Category</h1>';
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$id=$_POST['catid'];
			$category=$_POST['category'];
			$description=$_POST['description'];
			$enable=$_POST['enable'];

			

			$stmt= $con->prepare("UPDATE category SET catname= ?, descriotion= ?, enable= ? WHERE catid= ?");
			$stmt->execute(array($category,$description,$enable,$id));
			$count=$stmt->rowCount();
           
            if($count>0)
            {
			$messg= "<div class='alert alert-info'> $count Record Updated  </div>";
				go2home($messg,'back',10);
            }
            else
            {
                $messg= "<div class='alert alert-info'>No UBDATED  </div>";
				go2home($messg,'back',10);
            }

			
		}
    }

    elseif($do == 'Delete')
    {
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

		//بروح ع الداتا بيز اجيب البيانات بتاعت الاي دي دا

		$stmt=$con->prepare(
			"SELECT * FROM category WHERE catid= ?");

		//بنفذ الاستعلام بالمتغير اللي مخزن فيه القيمة
		$stmt->execute(array($catid));

		// بشوف انا لقيت داتا ولاا لاء و اد اي عددها 
		$count=$stmt->rowCount();
		// لو لقيت انها اكبر من الصفر بروح اعمل الفورمو ظهر البيانات 
		if($count > 0)
		{
			$stmt=$con->prepare("DELETE FROM category WHERE catid= ?");
			$stmt->execute(array($catid));
			$count=$stmt->rowCount();
			$messg= "<div class='alert alert-info'> $count Record Deleted </div>";
				go2home($messg,'back',10);
		}
		else
		{
		$messg= '<div class="alert alert-danger">Sorry There is no this id</div>';
				go2home($messg,'back',10);}
    }

}

	

else
{
    header('Location: index.php');
    exit();
}

include $temp .'footer.php';
?>
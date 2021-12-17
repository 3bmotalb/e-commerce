<?php
$title = 'My Profile';
session_start();
include 'init.php';

if (isset($_SESSION['User'])) {

	$stmt = $con->prepare("SELECT * FROM users WHERE Username = ?");
	$stmt->execute(array($_SESSION['User']));
	$info = $stmt->fetch();
	$userid = $info['userid'];

	echo $info['email'];


	echo 'Welcome' . $_SESSION['User'];
?>



<!--<h1 class="text-center">My Profile</h1>
<div class="information block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Information</div>
			<div class="panel-body">
				
				<a href="#" class="btn btn-default">Edit Information</a>
			</div>
		</div>
	</div>
</div>
<div class="information block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Items</div>
			<div class="panel-body">
				
				<a href="#" class="btn btn-default">Edit item</a>
			</div>
		</div>
	</div>
</div>-->

<section class="container data">
    <div class="row">
        <div class="col-sm-9">
            <div class="box box-solid">
                <div class="box-body boxdata">
                    <div class="col-sm-3">
                        <img src="img.png" width="100%">
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-3">
                                <h4>Name: </h4>
                                <h4>Email:</h4>
                                <h4>Contact Info: </h4>
                                <h4>Address:</h4>
                                <h4>Member Since: </h4>
                            </div>
                            <div class="col-sm-9">
                                <h4><?php echo $info['fullname']; ?>
                                    <span class="pull-right">
                                        <a href="#" class="btn btn-success btn-flat btn-sm" data-toggle="modal"><i
                                                class="fa fa-edit"></i> Edit</a>
                                    </span>
                                </h4>
                                <h4><?php echo $info['email']; ?></h4>
                                <h4>Phone</h4>
                                <h4><?php echo $info['Username']; ?></h4>
                                <h4><?php echo $info['date']; ?></h4>
                            </div>
                        </div>

                    </div>


                </div>


            </div>


</section>

<div class="information block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">My Items</div>
            <div class="panel-body">
                <div class="row">
                    <?php
						$items = getitemtoprofile('userid', $info['userid']);
						if (!empty($items)) {
							foreach ($items as $item) {
						?>
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail item-box">
                            <img src='img.png'>
                            <h3><a
                                    href="item.php?itemid=<?php echo $item['itemid']?>"><?php echo $item['itemname'] ?></a>
                            </h3>
                            <span>&#36; <?php echo $item['price'] ?></span>


                        </div>
                        <?php
							}
						} else {
							echo "There is no Item to Show";
						}
							?>
                    </div>
                    <!--<a href=" #" class="btn btn-default">Edit item</a>-->
                </div>
            </div>
        </div>
    </div>





    <?php } else {
	header('Location: index.php');
	exit();
}
include $temp . 'footer.php';
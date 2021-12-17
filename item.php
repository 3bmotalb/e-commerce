<?php
session_start();
$title = 'item';
include 'init.php';

$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

//بروح ع الداتا بيز اجيب البيانات بتاعت الاي دي دا

$stmt = $con->prepare("SELECT item.*,category.catname AS catname FROM item INNER JOIN category ON category.catid= item.catid WHERE itemid= ?");

//بنفذ الاستعلام بالمتغير اللي مخزن فيه القيمة
$stmt->execute(array($itemid));
// بجيب الداتا اخزنها 
$row = $stmt->fetch();
// بشوف انا لقيت داتا ولاا لاء و اد اي عددها 
$count = $stmt->rowCount();
// لو لقيت انها اكبر من الصفر بروح اعمل الفورمو ظهر البيانات 


if ($count > 0) {
?>



<!--<div class="content-wrapper">
    <div class="container">
        <section class="content">
            <div class="row">
                <div class="col-sm-9">

                    <div class="row">
                        <div class="col-sm-6">
                            <img src="admin/uploads/<?php echo $row['image']?>" width="100%" class="zoom">
                            <br><br>
                            <form class="form-inline" id="productForm">
                                <div class="form-group">
                                    <div class="input-group col-sm-5">

                                        <span class="input-group-btn">
                                            <button type="button" id="minus" class="btn btn-default btn-flat btn-lg"><i
                                                    class="fa fa-minus"></i></button>
                                        </span>
                                        <input type="text" name="quantity" id="quantity" class="form-control input-lg"
                                            value="1">
                                        <span class="input-group-btn">
                                            <button type="button" id="add" class="btn btn-default btn-flat btn-lg"><i
                                                    class="fa fa-plus"></i>
                                            </button>
                                        </span>
                                        <input type="hidden" value="1" name="id">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg btn-flat"><i
                                            class="fa fa-shopping-cart"></i> Add to Cart</button>
                                </div>
                            </form>
                        </div>
                        <div class="container">
                            <div class="col-sm-6">
                                <ul>
                                    <li> <h1 class="page-header"><?php echo $row['itemname'] ?></h1></li>
                                     <li> <h3><b>&#36; <?php echo $row['price'] ?></b></h3></li>
                                    <li><p><b>Category:</b>
                                        <a
                                            href="category.php?catid=<?php echo $row['catid'] ?>&name=<?php echo str_replace(' ','-',$row['catname']) ?>"><?php echo $row['catname'] ?></a></li>
                                </ul>
                                            <p><b>Description:</b></p>
                                    <p>grgrgrgwgrgwrgrwgrw</p>
                            </div>
                        </div>
                    </div>
                    <br>

                </div>
            </div>
    </div>
    </section>-->

    <div class="container">

    <div class="card">
			<div class="container-fliud">
				<div class="wrapper row">
					<div class="preview col-md-6">
						
						<div class="preview-pic tab-content">
						  <div class="tab-pane active" id="pic-1"><img src="admin/uploads/<?php echo $row['image']?>" /></div>
						</div>
				
					</div>
                    <br>

					<div class="details col-md-6">
						<h3 class="product-title"><?php echo $row['itemname'] ?></h3>
                        <div class="rating">

                        <h4 class="price">Category: <a href="category.php?catid=<?php echo $row['catid']?>&name=<?php echo str_replace(' ','-',$row['catname']) ?>"><?php echo $row['catname'] ?></a></h4> 
                        <p class="product-description"><h4 class="price">Description: </h4><?php echo $row['description'] ?></p>
						</div>
						
                        
						<h4 class="price">current price: <span><?php echo $row['price'] ?> EGP </span></h4>
                            
						<div class="action">
							<button class="add-to-cart btn btn-default" type="button">add to cart</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


<?php
} else {
?>

<h1 class=" text-center">
    There is No This item
</h1>
<?php }
include $temp . 'footer.php';
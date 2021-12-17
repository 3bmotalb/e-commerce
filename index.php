<?php
$title = 'Home';
session_start();
include 'init.php';
?>

<?php
$stmt = $con->prepare("SELECT * FROM item ORDER BY itemid DESC ");
$stmt->execute();

$allItems = $stmt->fetchAll();


?>

<section class="section-products">
    <div class="container">
        <div class="row justify-content-center text-center">

            
        <div class="row">
            <!-- Single Product -->
            <?php
            foreach ($allItems as $item) {
                if($item['status']==1)
                {
                 ?>
                <div class="col-md-6 col-lg-4 col-xl-3 ">
                    <div id="product-1" class="single-product">
                   
                        <div class="part-1">
                        <img src="admin/uploads/<?php echo $item['image'] ?>" width="100%" class="zoom product-thumb" alt="">
                            <ul>
                                <li><a href="#"><i class="fas fa-shopping-cart"></i></a></li>
                                <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                <li><a href="#"><i class="fas fa-plus"></i></a></li>
                                <li><a href="#"><i class="fas fa-expand"></i></a></li>
                            </ul>
                        </div>
                        <div class="part-2">
                           <a href="item.php?itemid=<?php echo $item['itemid'] ?>"> <h3 class="product-title"><?php echo $item['itemname'] ?></h3></a>
                            <h4 class="product-price"><?php echo $item['price'] ?></h4>
                        </div>
                    </div>
                </div>
            <?php
            }
        }
            ?>

        </div>
    </div>
    </div>
</section>

<?php
include $temp . 'footer.php';

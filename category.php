<?php
$name = str_replace('-', ' ', $_GET['name']);
$catid = $_GET['catid'];
$title = $name;
session_start();
include 'init.php';

?>

<section class="section-products">
    <div class="container">
        <div class="row justify-content-center text-center">

            
        <div class="row">
            
            <?php

if ( empty(getitem($catid))) {
    echo "<div class='container'>";
    echo "<h2 class='text-center' >No Items Yet In $name Section</h2>";
    echo "</div>" ;   
} else {
    foreach (getitem($catid) as $item) {
        ?>
<!-- Single Product -->
        <div class="col-md-6 col-lg-4 col-xl-3">
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
                <h3 class="product-title"><?php echo $item['itemname'] ?></h3>
                <h4 class="product-price"><?php echo $item['price'] ?> EGP</h4>
            </div>
        </div>
    </div>
<?php }
}
include $temp . 'footer.php';
?>
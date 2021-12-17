<?php
session_start();
$title='DASHBOARD';
if(isset($_SESSION['Username']))
{
    include 'init.php';
   ?>
   <div class="home">
   <div class="container home-screen text-center">
       <h1  >Secret Person </h1>
       <div class="row">
             <div class="col-md-4 member">
                        <div class="screen screen-member">
                            ToTal MeMbers
                            <span><a href="member.php"><?php echo countitem('userid','users')?></a></span>
                        </div>
            </div>
            <div class="col-md-4 category">
                        <div class="screen screen-categorie">
                            Categories
                            <span><a href="categories.php"><?php echo countitem('catid','category')?></a></span>
                        </div>
            </div>
            <div class="col-md-4 item">
                        <div class="screen screen-item">
                            ToTal Items
                            <span><a href="item.php"><?php echo countitem('itemid','item')?></a></span>
            </div>
        </div>

   </div>
</div>

<div class="foter">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-defult">
                    <div class="panel-heading">
                        <i class="fa fa-users"></i>
                        <?php $how_many=4;?>
                        Last <?php echo $how_many;?> Member
                    </div>
                    <div class="panel-body">
                    <ul class="list-unstyled latest-users">
                                           <?php
                                            $last_users = getlast('*','users','userid',$how_many);
                                            
                                            foreach($last_users as $user)
                                            {
                                                echo '<li>';
												echo $user['Username'];
												echo '<a href="member.php?do=Edit&userid=' . $user['userid'] . '">';
													echo '<span class="btn btn-success pull-right">';
														echo '<i class="fa fa-edit"></i> Edit';	
													echo '</span>';
												echo '</a>';
											echo '</li>';

                                            }
                                            ?>
                    </ul>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-defult">
                    <div class="panel-heading">
                        <i class="fa fa-home"></i>
                        <?php $how_many=2;?>
                        Last <?php echo $how_many;?> items
                        
                    </div>
                    <div class="panel-body">
                    <ul class="list-unstyled latest-items">
                                 <?php
                                            $last_items = getlast('*','item','itemid',$how_many);
                                            
                                            foreach($last_items as $item)
                                            {
                                                echo '<li>';
												echo $item['itemname'];
												echo '<a href="item.php?do=Edit&itemid=' . $item['itemid'] . '">';
													echo '<span class="btn btn-success pull-right">';
														echo '<i class="fa fa-edit"></i> Edit';	
                                                        if($item['accept']==0)
                                                        {
                                                            echo "<a href='item.php?do=Accept&itemid=". $item['itemid'] ."' class='btn btn-info pull-right'>Accept</a>" ;
                                                        }
													echo '</span>';
												echo '</a>';
											echo '</li>';

                                            }
                                ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
   <?php
    include $temp .'footer.php';
}
else
{
    header('Location: index.php');
    exit();
}
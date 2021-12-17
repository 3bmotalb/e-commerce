<nav class="navbar navbar-inverse">
  <div class="container">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        
      </button>
      <a class="navbar-brand" href="index.php"><span>Lab</span>Shop </a>
    </div>


    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav ">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categories <span class="caret"></span></a>

          <ul class="dropdown-menu">
            <?PhP
            foreach (getcat() as $category) {
              echo '<li><a href="category.php?catid=' . $category['catid'] . '&name=' . str_replace(' ', '-', $category['catname']) . '">' . $category['catname'] . '</a></li>';
            }
            ?>
          </ul>
        </li>



        <?php /*

              //SHOW CATEGORIES IN NAV BAR 
          foreach(getcat() as $category)
          {
            echo '<li><a href="category.php?catid='. $category['catid'] .'&name='.str_replace(' ','-',$category['catname']) .'">' . $category['catname'] . '</a></li>';
          }*/
        ?>

      </ul>

      <?php
      if (isset($_SESSION['User'])) { ?>
        <ul class="nav navbar-nav navbar-right">
          <li><a class="" href="logout.php">Log Out </a></li>
          <li><a class="" href="profile.php"><?php echo $_SESSION['User']; ?> </a></li>

        </ul>

        <?php  } else { ?>
        <ul class="nav navbar-nav navbar-right">
          <li><a class="" href="signup.php">Sign Up </a></li>
          <li><a class="" href="login.php">Log In </a></li>

        </ul>

      <?php }
      ?>


    </div>
  </div>
</nav>
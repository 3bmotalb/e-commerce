<nav class="navbar navbar-inverse">
  <div class="container">
    
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="homeadmin.php"><span>S</span>Person </a>
    </div>

   
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="member.php?do=Mange">Members</a></li>
        <li><a href="categories.php?do=Mange">Catogries</a></li>
        <li><a href="item.php?do=Mange">Items</a></li>

      </ul>


      <ul class="nav navbar-nav navbar-right">
      <li> </li>
        <li><a   class ="admin" href="member.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>" ><?php echo $_SESSION['Username'] ?></a></li>
        <li><a href="logout.php">log out</a></li>
        

      </ul>
      

    </div>
  </div>
</nav>
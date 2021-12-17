<?php
function echotitle(){
    global $title;
    if(isset($title))
    echo $title;
    else
    echo 'defult';
}

function go2home($messg,$url=null,$sec=3)
{
    if($url===null)
    {
        $url='index.php';
        $direction='';
    }
    else{
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !=='')
        {
            $url=$_SERVER['HTTP_REFERER'];
            $direction='Previous Page';
        }
        else
        {
        $url='index.php';
        $direction='Home Page';
        }
    }
    echo $messg;
    echo "<div class='alert alert-info'>You will be Redirected to $direction After $sec Seconds</div>";
    header("refresh:$sec; url=$url");
    exit();
}

function checkitemexist($item,$table,$value)
{
    global $con;
     $statement=$con->prepare("SELECT $item FROM $table WHERE $item= ?");
     $statement->execute(array($value));

     $count = $statement->rowCount();

     return $count;
}

function countitem($item,$from)
{
    global $con;
    $statement=$con->prepare("SELECT COUNT($item) FROM $from");
    $statement->execute();
    return $statement->fetchColumn();

}
function getlast($item,$from,$order_by,$howmany){

    global $con;
    $stmt=$con->prepare("SELECT $item FROM $from ORDER BY $order_by DESC LIMIT $howmany");
    $stmt->execute();
    $rows =$stmt->fetchAll();
    return $rows;
}
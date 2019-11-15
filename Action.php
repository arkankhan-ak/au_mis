<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->


<?php
session_start();
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    $_SESSION["tabColCount"] = 0;
    $_SESSION["fieldName"] = [];
    $_SESSION["fieldType"] = [];
    $_SESSION["updateRow"] = [];
    $_SESSION["key"] = "";
    $_SESSION["tableName"] = "tbl_au_chair_speakers";
    $_SESSION["updateFlag"] = false;
    getTableDetails($_SESSION["tableName"]);

   
}

function getPrimaryKeys($tablename)
{
    $_SESSION["keyList"]= [];
    $conn=mysqli_connect("localhost","root","","db_au_mis");
    $que = "SHOW KEYS FROM ".$tableName." WHERE Key_name = 'PRIMARY'";
    echo "<br>".$que;
    $result = mysqli_query($conn,$que);
    while($row=mysqli_fetch_array($result)){
        $_SESSION["keyList"][]=$row['Column_name'];
    }
    
}
if(isset($_POST['selectTable']))
{
    // getTableDetails($_POST['optTables']);
    // getTableDetails('tbl_extension_program');
    
    $_SESSION["tableName"] = $_POST['optTables'];
    echo 'select Table',$_SESSION["tableName"];
    getTableDetails($_SESSION["tableName"]);

}

function getTableDetails($tbl_name) {

    $conn=mysqli_connect("localhost","root","","db_au_mis");
    $que = "desc " . $tbl_name;
    echo $que;
    $result = mysqli_query($conn,$que);
    $rows   = mysqli_num_rows($result);
    
    
    $i = 0; //tmpIndexValue
    $_SESSION["fieldName"] = [];
    $_SESSION["fieldType"] = [];
    while($row=mysqli_fetch_array($result)){
        
        $_SESSION["fieldName"][] = $row['Field'];
        $_SESSION["fieldType"][] = explode("(",$row['Type'])[0];

        echo "field : " , $_SESSION["fieldName"][$i] , "type : " , $_SESSION["fieldType"][$i];
        $i++;
    }
    $_SESSION["tabColCount"] = $i; 
}



if(isset($_POST['btnUpdate'])){
    
    $_SESSION['updateFlag'] = true;

    //to get primary key list
    getPrimaryKeys($_SESSION['tableName']);
    $proKey=$_POST['key'];
    $_SESSION["key"]=$_POST['key'];
    $c=mysqli_connect("localhost","root","","db_au_mis");
	if($c){
		$q1="select * from ".$_SESSION['tableName']." where ".$_SESSION['fieldName'][0]."='".$proKey."'";
		$res=mysqli_query($c,$q1);
		if(mysqli_num_rows($res) > 0 && $row = mysqli_fetch_array($res))
		{
            for($i=0;$i<$_SESSION['tabColCount'];$i++){
                $_SESSION["updateRow"][] = $row[$i]; 

                echo '*'.$_SESSION["updateRow"][$i];
            }
            
			// $row['activity_name']
			// $row['with_agency']
			// $row['from_date']
			// $row['to_date']
			// $row['no_of_participant']
			// $row['current_year']

		}
	}

}
if(isset($_POST['btnDelete'])){
	$proKey=$_POST['key'];
	$c=mysqli_connect("localhost","root","","db_au_mis");
	if($c){
		$q1="delete from ".$_SESSION['tableName']." where ".$_SESSION['fieldName'][0]."='".$proKey."'";
        $res=mysqli_query($c,$q1);
		if($res)
		{
			echo "<script>alert('Deleted')</script>";
		}
		else{
			echo "<script>alert('Problem while deleting try again later')</script>";
		}
	}
}
if(isset($_POST['submit']))
{
    if($_SESSION['updateFlag']==true){
        $_SESSION['updateFlag'] = false;

        $c=mysqli_connect("localhost","root","","db_au_mis");
        if($c){
            $q1="update ".$_SESSION['tableName']." set ";
            
            
            for($i=1;$i<$_SESSION['tabColCount'];$i++){

                $q1 .= $_SESSION['fieldName'][$i]."='".$_POST[$_SESSION['fieldName'][$i]]."',";

            }
            $q1 = mb_substr($q1, 0, -1);
            $q1 .= ' where '.$_SESSION['fieldName'][0]."='".$_SESSION["key"]."'";

            echo '<br>updateQ: '.$q1;
            $res=mysqli_query($c,$q1);
            if($res)
            {
                echo "<script>alert('Updated')</script>";
            }
            else{
                echo "<script>alert('Problem while Updating try again later')</script>";
            }
        }


    }else{
        /////////////logic to create insert query/////////////////////////////
        $conn=mysqli_connect("localhost","root","","db_au_mis");
        $result = mysqli_query($conn,"desc ".$_SESSION["tableName"]);
        var_dump($result);
        $filedNameString ="";
        $fieldValueString = "";
        $myQyery = "insert into ".$_SESSION["tableName"]."(";
        
        while($row=mysqli_fetch_array($result)){
            // echo "<br>".$row['Field']." ".$row['Type']."<br>";
            $filedNameString .= $row['Field'].",";
            $fieldDataType = explode("(",$row['Type'])[0];
            
            // switch($fieldDataType){
            //     case "varchar":
            //         $fieldValueString .= "'".$_POST[$row['Field']]."',";        
            //         break;
            //     case "date":
            //         $tempDate = date('Y-m-d',strtotime($_POST[$row['Field']]));
            //         $fieldValueString .= "'".$tempDate."',";
            //         break;
            //     case "int":
            //         echo "<br>came into int wala<br>";
            //         $fieldValueString .= "".$_POST[$row['Field']].",";
            //         break;
            // }
            $fieldValueString .= "'".$_POST[$row['Field']]."',";
        }
        $columnNameQuery =  $myQyery.mb_substr($filedNameString, 0, -1).")";
        $firingQuery = $columnNameQuery." values(".mb_substr($fieldValueString, 0, -1).");";
        echo "<br>".$firingQuery."<br>";
        /////////////logic to create insert query - final query will be in variable $firingQuery/////////////////////////////
        
        //////////////////////////////////////////////////////Insertion of custom query///////////////
        $conn=mysqli_connect("localhost","root","","db_au_mis");
        if($conn){
            $res=mysqli_query($conn,$firingQuery);
            if($res)
            {
                echo "inserted";
            }
            else{
                echo "Faild";
            }
        }
    }

    
    //////////////////////////////////////////////////////Insertion of custom query///////////////

    // if($conn)
	// {
    //     $query="insert into tbl_extension_program values('".$txtActivityName."','".$txtWithAgency."','".$fDate."','".$tDate."',".$txtNoOfParticipant.",'".$optCurrentYear."','".$docUrl."')";
    //     for( $i=0; $i<$tabColCount; $i++){

    //     }
    
    //     $txtActivityName=$_POST['txtActivityName'];
	// 	$txtWithAgency=$_POST['txtWithAgency'];
	// 	$txtNoOfParticipant=$_POST['txtNoOfParticipant'];
	// 	//$optCurrentYear=$_POST['optCurrentYear'];
	// 	$optCurrentYear=2015;
	// 	$docUrl="abc/abc";

	// 	$fDate = date('Y-m-d',strtotime($_POST['txtFromDate']));
	// 	$tDate = date('Y-m-d',strtotime($_POST['txtToDate']));
		
	// 	$q="insert into tbl_extension_program values('".$txtActivityName."','".$txtWithAgency."','".$fDate."','".$tDate."',".$txtNoOfParticipant.",'".$optCurrentYear."','".$docUrl."')";
	// 	$res=mysqli_query($conn,$q);
	// 	if($res)
	// 	{
	// 		echo "inserted";
	// 	}
	// 	else{
	// 		echo "Faild";
	// 	}
		
    // }

	// $conn=mysqli_connect("localhost","root","","db_au_mis");
	// if($conn)
	// {
	// 	$txtActivityName=$_POST['txtActivityName'];
	// 	$txtWithAgency=$_POST['txtWithAgency'];
	// 	$txtNoOfParticipant=$_POST['txtNoOfParticipant'];
	// 	//$optCurrentYear=$_POST['optCurrentYear'];
	// 	$optCurrentYear=2015;
	// 	$docUrl="abc/abc";

	// 	$fDate = date('Y-m-d',strtotime($_POST['txtFromDate']));
	// 	$tDate = date('Y-m-d',strtotime($_POST['txtToDate']));
		
	// 	$q="insert into tbl_extension_program values('".$txtActivityName."','".$txtWithAgency."','".$fDate."','".$tDate."',".$txtNoOfParticipant.",'".$optCurrentYear."','".$docUrl."')";
	// 	$res=mysqli_query($conn,$q);
	// 	if($res)
	// 	{
	// 		echo "inserted";
	// 	}
	// 	else{
	// 		echo "Faild";
	// 	}
		
    // }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Management Information System</title>
    <!-- Meta Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="keywords" content="Modernize Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>

    <!-- Style to set the size of checkbox -->
    <style> 
        input.largerCheckbox { 
            width: 40px; 
            height: 40px; 
        } 
    </style>

    <!-- //Meta Tags -->

    <!-- Style-sheets -->
    <!-- Bootstrap Css -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <!-- Bootstrap Css -->
    <!-- Common Css -->
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <!--// Common Css -->
    <!-- Nav Css -->
    <link rel="stylesheet" href="css/style4.css">
    <!--// Nav Css -->
    <!-- Fontawesome Css -->
    <link href="css/fontawesome-all.css" rel="stylesheet">
    <!--// Fontawesome Css -->
    <!--// Style-sheets -->
    <!--web-fonts-->
    <link href="//fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!--//web-fonts-->
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h1>
                    <a href="index.html">AU-MIS</a>
                </h1>
                <span>M</span>
            </div>
            <div class="profile-bg"></div>
            <ul class="list-unstyled components">
                <li>
                    <a href="index.html">
                        <i class="fas fa-th-large"></i>
                        Dashboard
                    </a>
                </li>
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-laptop"></i>
                        Components
                        <i class="fas fa-angle-down fa-pull-right"></i>
                    </a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="cards.html">Cards</a>
                        </li>
                        <li>
                            <a href="carousels.html">Carousels</a>
                        </li>
                        <li>
                            <a href="forms.html">Forms</a>
                        </li>
                        <li>
                            <a href="modals.html">Modals</a>
                        </li>
                        <li>
                            <a href="tables.html">Tables</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="charts.html">
                        <i class="fas fa-chart-pie"></i>
                        Charts
                    </a>
                </li>
                <li>
                    <a href="grids.html">
                        <i class="fas fa-th"></i>
                        Grid Layouts
                    </a>
                </li>
                <li>
                    <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false">
                        <i class="far fa-file"></i>
                        Pages
                        <i class="fas fa-angle-down fa-pull-right"></i>
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu1">
                        <li>
                            <a href="404.html">404</a>
                        </li>
                        <li>
                            <a href="500.html">500</a>
                        </li>
                        <li>
                            <a href="blank.html">Blank</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="mailbox.html">
                        <i class="far fa-envelope"></i>
                        Mailbox
                        <span class="badge badge-secondary float-md-right bg-danger">5 New</span>
                    </a>
                </li>
                <li>
                    <a href="widgets.html">
                        <i class="far fa-window-restore"></i>
                        Widgets
                    </a>
                </li>
                <li>
                    <a href="pricing.html">
                        <i class="fas fa-table"></i>
                        Pricing Tables
                    </a>
                </li>
                <li>
                    <a href="#pageSubmenu3" data-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-users"></i>
                        User
                        <i class="fas fa-angle-down fa-pull-right"></i>
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu3">
                        <li>
                            <a href="login.html">Login</a>
                        </li>
                        <li>
                            <a href="register.html">Register</a>
                        </li>
                        <li>
                            <a href="forgot.html">Forgot password</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="maps.html">
                        <i class="far fa-map"></i>
                        Maps
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content Holder -->
        <div id="content">
            <!-- top-bar -->
            <nav class="navbar navbar-default mb-xl-5 mb-4">
                <div class="container-fluid">

                    <div class="navbar-header">
                        <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                    <!-- Search-from -->
                    
                    <form action="#" method="post" class="form-inline mx-auto search-form">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" >
                        <button class="btn btn-style my-2 my-sm-0" type="submit">Search</button>
                    </form>
                    <!--// Search-from -->
                    <ul class="top-icons-agileits-w3layouts float-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="far fa-bell"></i>
                                <span class="badge">4</span>
                            </a>
                            <div class="dropdown-menu top-grid-scroll drop-1">
                                <h3 class="sub-title-w3-agileits">User notifications</h3>
                                <a href="#" class="dropdown-item mt-3">
                                    <div class="notif-img-agileinfo">
                                        <img src="images/clone.jpg" class="img-fluid" alt="Responsive image">
                                    </div>
                                    <div class="notif-content-wthree">
                                        <p class="paragraph-agileits-w3layouts py-2">
                                            <span class="text-diff">John Doe</span> Curabitur non nulla sit amet nisl tempus convallis quis ac lectus.</p>
                                        <h6>4 mins ago</h6>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item mt-3">
                                    <div class="notif-img-agileinfo">
                                        <img src="images/clone.jpg" class="img-fluid" alt="Responsive image">
                                    </div>
                                    <div class="notif-content-wthree">
                                        <p class="paragraph-agileits-w3layouts py-2">
                                            <span class="text-diff">Diana</span> Curabitur non nulla sit amet nisl tempus convallis quis ac lectus.</p>
                                        <h6>6 mins ago</h6>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item mt-3">
                                    <div class="notif-img-agileinfo">
                                        <img src="images/clone.jpg" class="img-fluid" alt="Responsive image">
                                    </div>
                                    <div class="notif-content-wthree">
                                        <p class="paragraph-agileits-w3layouts py-2">
                                            <span class="text-diff">Steffie</span> Curabitur non nulla sit amet nisl tempus convallis quis ac lectus.</p>
                                        <h6>12 mins ago</h6>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item mt-3">
                                    <div class="notif-img-agileinfo">
                                        <img src="images/clone.jpg" class="img-fluid" alt="Responsive image">
                                    </div>
                                    <div class="notif-content-wthree">
                                        <p class="paragraph-agileits-w3layouts py-2">
                                            <span class="text-diff">Jack</span> Curabitur non nulla sit amet nisl tempus convallis quis ac lectus.</p>
                                        <h6>1 days ago</h6>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">view all notifications</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown mx-3">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-spinner"></i>
                            </a>
                            <div class="dropdown-menu top-grid-scroll drop-2">
                                <h3 class="sub-title-w3-agileits">Shortcuts</h3>
                                <a href="#" class="dropdown-item mt-3">
                                    <h4>
                                        <i class="fas fa-chart-pie mr-3"></i>Sed feugiat</h4>
                                </a>
                                <a href="#" class="dropdown-item mt-3">
                                    <h4>
                                        <i class="fab fa-connectdevelop mr-3"></i>Aliquam sed</h4>
                                </a>
                                <a href="#" class="dropdown-item mt-3">
                                    <h4>
                                        <i class="fas fa-tasks mr-3"></i>Lorem ipsum</h4>
                                </a>
                                <a href="#" class="dropdown-item mt-3">
                                    <h4>
                                        <i class="fab fa-superpowers mr-3"></i>Cras rutrum</h4>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="far fa-user"></i>
                            </a>
                            <div class="dropdown-menu drop-3">
                                <div class="profile d-flex mr-o">
                                    <div class="profile-l align-self-center">
                                        <img src="images/profile.jpg" class="img-fluid mb-3" alt="Responsive image">
                                    </div>
                                    <div class="profile-r align-self-center">
                                        <h3 class="sub-title-w3-agileits">Will Smith</h3>
                                        <a href="mailto:info@example.com">info@example.com</a>
                                    </div>
                                </div>
                                <a href="#" class="dropdown-item mt-3">
                                    <h4>
                                        <i class="far fa-user mr-3"></i>My Profile</h4>
                                </a>
                                <a href="#" class="dropdown-item mt-3">
                                    <h4>
                                        <i class="fas fa-link mr-3"></i>Activity</h4>
                                </a>
                                <a href="#" class="dropdown-item mt-3">
                                    <h4>
                                        <i class="far fa-envelope mr-3"></i>Messages</h4>
                                </a>
                                <a href="#" class="dropdown-item mt-3">
                                    <h4>
                                        <i class="far fa-question-circle mr-3"></i>Faq</h4>
                                </a>
                                <a href="#" class="dropdown-item mt-3">
                                    <h4>
                                        <i class="far fa-thumbs-up mr-3"></i>Support</h4>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="login.html">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
             <!--// top-bar -->

<!-- ************************************************************************************** -->

        


		     <!-- Forms content -->
            <section class="forms-section">
                <div class="outer-w3-agile mt-3">
                    <h4 class="tittle-w3-agileits mb-4">Extension Program</h4>
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

                <select name="optTables" id="optTables" class="form-control">
                <?php
                    $conn=mysqli_connect("localhost","root","","db_au_mis");
                    $result = mysqli_query($conn,"Show tables");
                    while($row=mysqli_fetch_array($result)){
                        // echo $row[0] , "\n";
                        ?>
                        <option> <?php echo $row[0] ?> </option>        
                        <?php      
                    }
                ?>       
                <option selected="true"> <?php echo $_SESSION["tableName"] ?> </option>
                </select>
                <input type="submit" class="btn btn-primary" value="Get Table List" name="selectTable">

                <?php
                
                   
                    // $conn=mysqli_connect("localhost","root","","db_au_mis");
                    // $result = mysqli_query($conn,"desc tbl_course");
                    // var_dump($result);
                    // $rows   = mysqli_num_rows($result);
                    // echo 'fiiiieelldd',$rows;
                    // while($row=mysqli_fetch_array($result)){
                    //     echo "field : " , $row['Field'] , "type : " , explode("(",$row['Type'])[0];
                    // }

                    $tempForLoopConditionVariable = 0;
                    echo $_SESSION["tabColCount"]; 
                    if($_SESSION["tabColCount"]%2 == 0){
                        echo 'even';
                        
                        $tempForLoopConditionVariable = $_SESSION["tabColCount"]/2;
                    }else{
                        echo 'odd';

                        $tempForLoopConditionVariable = ($_SESSION["tabColCount"]-1)/2;
                    }    

                    $i=0;
                    for($j=0; $j < $tempForLoopConditionVariable; $j++){
                        $i = $j * 2;
                        // $row=mysqli_fetch_array($result);
                        // echo "field : " , $row['Field'] , "type : " , $row['Type'];

                ?>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><?php echo $_SESSION["fieldName"][$i] ?></label>
                                
                                <?php
                                switch ($_SESSION["fieldType"][$i]) {
                                    case "varchar":
                                        ?>
                                        
                                        <input type="text" class="form-control" name="<?php echo $_SESSION["fieldName"][$i] ?>" placeholder="<?php echo $_SESSION["fieldName"][$i] ?>"  <?php if($_SESSION['updateFlag']){ ?> value= "<?php echo $_SESSION["updateRow"][$i] ?>" <?php } ?> />
                                        
                                        <?php
                                        break;
                                    case "date":
                                        ?>
                                        
                                        <input type="date" class="form-control" name="<?php echo $_SESSION["fieldName"][$i] ?>" placeholder="<?php echo $_SESSION["fieldName"][$i] ?>"  <?php if($_SESSION['updateFlag']){ ?> value= "<?php echo $_SESSION["updateRow"][$i] ?>" <?php } ?> />
                                        
                                        <?php
                                        break;
                                    case "int":
                                        ?>
                                        
                                        <input type="number" class="form-control" name="<?php echo $_SESSION["fieldName"][$i] ?>" placeholder="<?php echo $_SESSION["fieldName"][$i] ?>"  <?php if($_SESSION['updateFlag']){ ?> value= "<?php echo $_SESSION["updateRow"][$i] ?>" <?php } ?> />
                                        
                                        <?php
                                        break;
                                    case "tinyint":
                                        ?>
                                        
                                        <input type="checkbox" class="form-control largerCheckbox" name="<?php echo $_SESSION["fieldName"][$i] ?>" value="<?php echo $_SESSION["fieldName"][$i] ?>"  <?php if($_SESSION['updateFlag']){ ?> value= "<?php echo $_SESSION["updateRow"][$i] ?>" <?php } ?> />
                                        
                                        <?php
                                        break;    
                                    case "year":
                                        ?>

                                        <select name="optCurrentYear" class="form-control">';
                                            <?php if($updateFlag){ ?> <option selected=""> <?php echo $_SESSION["fieldName"][$i] ?> </option> <?php } ?>
                                            ?>
                                            <option selected="">Choose...</option>
                                            <option>...</option>
                                        </select>

                                        <?php
                                        break;
                                    default:
                                    ?>
                                        
                                    <input type="text" class="form-control" name="<?php echo $_SESSION["fieldName"][$i] ?>" placeholder="<?php echo $_SESSION["fieldName"][$i] ?>"  <?php if($_SESSION['updateFlag']){ ?> value= "<?php echo $_SESSION["updateRow"][$i] ?>" <?php } ?> />
                                    
                                <?php
                                }
                                $i++;
                                ?>
                        </div>
                           
                            <div class="form-group col-md-6">
                                <label><?php echo $_SESSION["fieldName"][$i] ?> </label>
                                
                                <?php
                                switch ($_SESSION["fieldType"][$i]) {
                                    case "varchar":
                                        ?>
                                        
                                        <input type="text" class="form-control" name="<?php echo $_SESSION["fieldName"][$i] ?>" placeholder="<?php echo $_SESSION["fieldName"][$i] ?>"  <?php if($_SESSION['updateFlag']){ ?> value= "<?php echo $_SESSION["updateRow"][$i] ?>" <?php } ?> />
                                        
                                        <?php
                                        break;
                                    case "date":
                                        ?>
                                        
                                        <input type="date" class="form-control" name="<?php echo $_SESSION["fieldName"][$i] ?>" placeholder="<?php echo $_SESSION["fieldName"][$i] ?>"  <?php if($_SESSION['updateFlag']){ ?> value= "<?php echo $_SESSION["updateRow"][$i] ?>" <?php } ?> />
                                        
                                        <?php
                                        break;
                                    case "int":
                                        ?>
                                        
                                        <input type="number" class="form-control" name="<?php echo $_SESSION["fieldName"][$i] ?>" placeholder="<?php echo $_SESSION["fieldName"][$i] ?>"  <?php if($_SESSION['updateFlag']){ ?> value= "<?php echo $_SESSION["updateRow"][$i] ?>" <?php } ?> />
                                        
                                        <?php
                                        break;
                                    case "tinyint":
                                        ?>
                                        
                                        <input type="checkbox" class="form-control largerCheckbox" name="<?php echo $_SESSION["fieldName"][$i] ?>" value="<?php echo $_SESSION["fieldName"][$i] ?>"  <?php if($_SESSION['updateFlag']){ ?> value= "<?php echo $_SESSION["updateRow"][$i] ?>" <?php } ?> />
                                        
                                        <?php
                                        break;    
                                    case "year":
                                        ?>

                                        <select name="optCurrentYear" class="form-control">';
                                            <?php if($updateFlag){ ?> <option selected=""> <?php echo $_SESSION["fieldName"][$i] ?> </option> <?php } ?>
                                            ?>
                                            <option selected="">Choose...</option>
                                            <option>...</option>
                                        </select>

                                        <?php
                                        break;
                                    default:
                                    ?>
                                        
                                    <input type="text" class="form-control" name="<?php echo $_SESSION["fieldName"][$i] ?>" placeholder="<?php echo $_SESSION["fieldName"][$i] ?>"  <?php if($_SESSION['updateFlag']){ ?> value= "<?php echo $_SESSION["updateRow"][$i] ?>" <?php } ?> />
                                    
                                <?php
                                }
                                ?>
                                
                                
                            </div>
                        </div>

                    <?php }
                    
                    if($_SESSION["tabColCount"]%2 != 0){
                        $i++;
                    ?>

                        <div class="form-group">
                                
                                <label><?php echo $_SESSION["fieldName"][$i] ?> </label>
                                
                                <?php
                                switch ($_SESSION["fieldType"][$i]) {
                                    case "varchar":
                                        ?>
                                        
                                        <input type="text" class="form-control" name="<?php echo $_SESSION["fieldName"][$i] ?>" placeholder="<?php echo $_SESSION["fieldName"][$i] ?>"  <?php if($_SESSION['updateFlag']){ ?> value= "<?php echo $_SESSION["updateRow"][$i] ?>" <?php } ?> />
                                        
                                        <?php
                                        break;
                                    case "date":
                                        ?>
                                        
                                        <input type="date" class="form-control" name="<?php echo $_SESSION["fieldName"][$i] ?>" placeholder="<?php echo $_SESSION["fieldName"][$i] ?>"  <?php if($_SESSION['updateFlag']){ ?> value= "<?php echo $_SESSION["updateRow"][$i] ?>" <?php } ?> />
                                        
                                        <?php
                                        break;
                                    case "int":
                                        ?>
                                        
                                        <input type="number" class="form-control" name="<?php echo $_SESSION["fieldName"][$i] ?>" placeholder="<?php echo $_SESSION["fieldName"][$i] ?>"  <?php if($_SESSION['updateFlag']){ ?> value= "<?php echo $_SESSION["updateRow"][$i] ?>" <?php } ?> />
                                        
                                        <?php
                                        break;
                                    case "tinyint":
                                        ?>
                                        
                                        <input type="checkbox" class="form-control largerCheckbox" name="<?php echo $_SESSION["fieldName"][$i] ?>" value="<?php echo $_SESSION["fieldName"][$i] ?>"  <?php if($_SESSION['updateFlag']){ ?> value= "<?php echo $_SESSION["updateRow"][$i] ?>" <?php } ?> />
                                        
                                        <?php
                                        break;    
                                    case "year":
                                        ?>

                                        <select name="optCurrentYear" class="form-control">';
                                            <?php if($updateFlag){ ?> <option selected=""> <?php echo $_SESSION["fieldName"][$i] ?> </option> <?php } ?>
                                            ?>
                                            <option selected="">Choose...</option>
                                            <option>...</option>
                                        </select>

                                        <?php
                                        break;
                                    default:
                                    ?>
                                        
                                    <input type="text" class="form-control" name="<?php echo $_SESSION["fieldName"][$i] ?>" placeholder="<?php echo $_SESSION["fieldName"][$i] ?>"  <?php if($_SESSION['updateFlag']){ ?> value= "<?php echo $_SESSION["updateRow"][$i] ?>" <?php } ?> />
                                    
                                <?php
                                }
                                ?>
                        </div>
                    
                    <?php    
                    }
                    
                    ?>

                <!--
                        <div class="form-group">
                            <label>Activity name</label>
                            <input type="text" class="form-control" name="txtActivityName" placeholder="Activity Name"  <?php if($updateFlag){?> value=<?php echo $row['activity_name'] ?> <?php } ?> >
                        </div>
                        
                        <div class="form-group">
                            <label>With Agency</label>
                            <input type="text" class="form-control" name="txtWithAgency" placeholder="With Agency"  <?php if($updateFlag){?> value=<?php echo $row['with_agency'] ?> <?php } ?>>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>No of Participant</label>
                                <input type="number" class="form-control" name="txtNoOfParticipant" placeholder="no of participant"  <?php if($updateFlag){?> value=<?php echo $row['no_of_participant'] ?> <?php } ?>>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Current year</label>
                                <select name="optCurrentYear" class="form-control">
                                    <?php //if($updateFlag){?> <option selected=""> <?php //echo $row['current_year'] ?> </option> <?php //} ?>
                                    <option selected="">Choose...</option>
                                    <option>...</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>From date</label>
                                <input type="date" class="form-control" name="txtFromDate" placeholder="From date" <?php if($updateFlag){?> value=<?php echo $row['from_date'] ?> <?php } ?>>  
                            </div>
                            <div class="form-group col-md-6">
                                <label>To date</label>
                                <input type="date" class="form-control" name="txtToDate" placeholder="To date" <?php if($updateFlag){?> value=<?php echo $row['to_date'] ?> <?php } ?>>  
                            </div>
                        </div>
                -->
                        
                        <div class="form-group">
                            <label>Upload Document</label>
                            <button type="submit" class="btn btn-primary">Browse</button>                            
                        </div>

                        <input type="submit" class="btn btn-primary" value="submit" name="submit">
                    </form>

<!-- ****************************************************************************************** -->

                        
                        <?php 
                            //list of tables
                            // $conn=mysqli_connect("localhost","root","","db_au_mis");
                            // $result = mysqli_query($conn,"Show tables");
                            // while($row=mysqli_fetch_array($result)){
                            //     echo $row[0] , "\n";
                            // }

                            // $conn=mysqli_connect("localhost","root","","db_au_mis");
                            // $result = mysqli_query($conn,"SELECT * FROM tbl_extension_program");
                            // $fields = mysqli_num_fields($result);
                            // $rows   = mysqli_num_rows($result);
                            // //$table  = mysql_field_table($result,0);
                            // $table = 'tbl_extension_program';
                            // echo "Your '" . $table . "' table has " . $fields . " fields and " . $rows . " record(s)\n";
                            // echo "The table has the following fields:\n";
                            // for ($i=0; $i < $fields; $i++) {
                            //     $type  = mysqli_fetch_field_direct($result, $i);
                            //     // $name  = mysqli_field_name($result, $i);
                            //     // $len   = mysqli_field_len($result, $i);
                            //     // $flags = mysqli_field_flags($result, $i);
                            //     echo $type->name . " " . $type->max_length; //. " " . $type->table;
                            // }
                            // mysqli_free_result($result);
                            // // mysqli_close();

                            // $result = mysqli_query($conn,"desc tbl_extension_program");
                            // // var_dump($result);
                            // $rows   = mysqli_num_rows($result);
                            // echo 'fiiiieelldd',$rows;
                            // while($row=mysqli_fetch_array($result)){
                            //     echo "field : " , $fieldName[$i] , "type : " , $row['Type'];
                            // }
                            


                    	$conn=mysqli_connect("localhost","root","","db_au_mis");
						if($conn){

                            // $conn=mysqli_connect("localhost","root","","db_au_mis");
                            // $result = mysqli_query($conn,"desc ".$_SESSION["tableName"]);

                        ?>
                        <table border=2 class=table table-bordered table-striped >
                            <thead>
                                <tr>

                                <?php
                                for($i=0;$i<$_SESSION['tabColCount'];$i++){
                                ?>    

                                    <th class="text-center"><?php echo $_SESSION['fieldName'][$i] ?></th>
                                <?php
                                }
                                ?>
                                    <th class="text-center"> Update </th>
                                    <th class="text-center"> Delete </th>
                                </tr>
                                </thead>
                                <tbody>
                        
                        <?php    

                            $query="select * from ".$_SESSION["tableName"];
                            echo $query;
							$result=mysqli_query($conn,$query);
                            while($row=mysqli_fetch_array($result)){
                        ?>
                                <form acton=" <?php echo $_SERVER['PHP_SELF'] ?>" method=post>
                                    <tr>
                                        <input type="hidden" name="key" value='<?php echo $row[0] ?>'>
                                        <?php
                                        for($i=0;$i<$_SESSION['tabColCount'];$i++){
                                        ?>
                                            <td> <?php echo $row[$i] ?> </td>
                                        
                                        <?php
                                        }
                                        ?>
                                        <td><input type="submit" name="btnUpdate" value="Update"/></td>
                                        <td><input type="submit" name="btnDelete" value="Delete"/></td>
                                    </tr>
                                </form>
                                
                            <?php    
                            }
                            ?>

                            </tbody>
                        </table>
                        <?php								
						}
                        ?>
                </div>
                <!--// Forms-3 -->
                <!-- Forms-4 -->
                
                <!--// Forms-4 -->
            </section>

            <!--// Forms content -->

            <!-- Copyright -->
            <div class="copyright-w3layouts py-xl-3 py-2 mt-xl-5 mt-4 text-center">
            <p>© 2019 | All Rights Reserved | Design by 
                    <a href=#> Mayur Prajapati </a>
                </p>
                
                <!--<p>© 2018 Modernize . All Rights Reserved | Design by
                    <a href="http://w3layouts.com/"> W3layouts </a>
                </p>-->
            </div>
            <!--// Copyright -->
        </div>
    </div>


    <!-- Required common Js -->
    <script src='js/jquery-2.2.3.min.js'></script>
    <!-- //Required common Js -->

    <!-- Sidebar-nav Js -->
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
    <!--// Sidebar-nav Js -->

    <!-- Validation Script -->
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict';

            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');

                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
    <!--// Validation Script -->

    <!-- dropdown nav -->
    <script>
        $(document).ready(function () {
            $(".dropdown").hover(
                function () {
                    $('.dropdown-menu', this).stop(true, true).slideDown("fast");
                    $(this).toggleClass('open');
                },
                function () {
                    $('.dropdown-menu', this).stop(true, true).slideUp("fast");
                    $(this).toggleClass('open');
                }
            );
        });
    </script>
    <!-- //dropdown nav -->

    <!-- Js for bootstrap working-->
    <script src="js/bootstrap.min.js"></script>
    <!-- //Js for bootstrap working -->

</body>

</html>
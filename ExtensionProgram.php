<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->

<!--yooo chal nikad-->

<?php
$updateFlag=false;
if(isset($_POST['btnUpdate'])){
	
	$proKey=$_POST['program_key'];
	$c=mysqli_connect("localhost","root","","db_au_mis");
	if($c){
		$q1="select * from tbl_extension_program where activity_name='".$proKey."'";
		$res=mysqli_query($c,$q1);
		if(mysqli_num_rows($res) > 0 && $row = mysqli_fetch_array($res))
		{
			$updateFlag=true;		
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
	$proKey=$_POST['program_key'];
	$c=mysqli_connect("localhost","root","","db_au_mis");
	if($c){
		$q1="delete from tbl_extension_program where activity_name='".$proKey."'";
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
	$conn=mysqli_connect("localhost","root","","db_au_mis");
	if($conn)
	{
		$txtActivityName=$_POST['txtActivityName'];
		$txtWithAgency=$_POST['txtWithAgency'];
		$txtNoOfParticipant=$_POST['txtNoOfParticipant'];
		//$optCurrentYear=$_POST['optCurrentYear'];
		$optCurrentYear=2015;
		$docUrl="abc/abc";

		$fDate = date('Y-m-d',strtotime($_POST['txtFromDate']));
		$tDate = date('Y-m-d',strtotime($_POST['txtToDate']));
		
		$q="insert into tbl_extension_program values('".$txtActivityName."','".$txtWithAgency."','".$fDate."','".$tDate."',".$txtNoOfParticipant.",'".$optCurrentYear."','".$docUrl."')";
		$res=mysqli_query($conn,$q);
		if($res)
		{
			echo "inserted";
		}
		else{
			echo "Faild";
		}
		
		}
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
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" required="">
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
		     <!-- Forms content -->
            <section class="forms-section">
                <div class="outer-w3-agile mt-3">
                    <h4 class="tittle-w3-agileits mb-4">Extension Program</h4>
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                        <div class="form-group">
                            <label>Activity name</label>
                            <input type="text" class="form-control" name="txtActivityName" placeholder="Activity Name" required="" <?php if($updateFlag){?> value=<?php echo $row['activity_name'] ?> <?php } ?> >
                        </div>
                        
                        <div class="form-group">
                            <label>With Agency</label>
                            <input type="text" class="form-control" name="txtWithAgency" placeholder="With Agency" required="" <?php if($updateFlag){?> value=<?php echo $row['with_agency'] ?> <?php } ?>>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>No of Participant</label>
                                <input type="number" class="form-control" name="txtNoOfParticipant" placeholder="no of participant" required="" <?php if($updateFlag){?> value=<?php echo $row['no_of_participant'] ?> <?php } ?>>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Current year</label>
                                <select name="optCurrentYear" class="form-control">
                                    <?php if($updateFlag){?> <option selected=""> <?php echo $row['current_year'] ?> </option> <?php } ?>
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
                        <div class="form-group">
                            <label>Upload Document</label>
                            <button type="submit" class="btn btn-primary">Browse</button>                            
                        </div>

                        <input type="submit" class="btn btn-primary" value="submit" name="submit">
                    </form>
                    <?php 
                    	$conn=mysqli_connect("localhost","root","","db_au_mis");
						if($conn){
							$query="select * from tbl_extension_program";
							$execute=mysqli_query($conn,$query);
							
							if(mysqli_num_rows($execute) > 0){
								echo "<table border=2 class=table table-bordered table-striped >";
								echo '<thead>
										<tr>
											<th class="text-center">Activity name</th>
											<th class="text-center">With Agency</th>
											<th class="text-center">From Date</th>
											<th class="text-center">To Date</th>
											<th class="text-center">No Of Participant</th>
											<th class="text-center">Current Year</th>
											<th class="text-center">Doc Url</th>
											<th class="text-center">Delete Program</th>
											<th class="text-center">Update Program</th>
									  </tr>
								  	 </thead>
								  	 <tbody>
									  ';
								while($row=mysqli_fetch_array($execute)){
									echo '
										<form acton='.$_SERVER['PHP_SELF'].' method=post>
										  <tr>
											<input type="hidden" name="program_key" value='.$row['activity_name'].'>
											<td>'.$row['activity_name'].'</td>
											<td>'.$row['with_agency'].'</td>
											<td>'.$row['from_date'].'</td>
											<td>'.$row['to_date'].'</td>
											<td>'.$row['no_of_participant'].'</td>
											<td>'.$row['current_year'].'</td>
											<td>'.$row['doc_url'].'</td>
											<td><input type="submit" name="btnDelete" value="Delete"/></td>
											<td><input type="submit" name="btnUpdate" value="Update"/></td>
										  </tr>
										</form>
										  ';
								}
								echo "</tbody>
									  </table>";	
								
						}
					}?>
                </div>
                <!--// Forms-3 -->
                <!-- Forms-4 -->
                
                <!--// Forms-4 -->
            </section>

            <!--// Forms content -->

            <!-- Copyright -->
            <div class="copyright-w3layouts py-xl-3 py-2 mt-xl-5 mt-4 text-center">
                <p>© 2018 Modernize . All Rights Reserved | Design by
                    <a href="http://w3layouts.com/"> W3layouts </a>
                </p>
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
<!DOCTYPE html>
<html>
<head>
    <title> Memlaps </title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link href="css/bootstrap-arrows.css" rel="stylesheet" type="text/css" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/bootstrap-arrows.js"></script>


</head>
<body>
	<?php
		include('dbConnect.php');//connect to database
    ?>
	
    <div class="navbar navbar-inverse navbar-static-top"> <!--Navigation Bar -->
        <div class="container">

            <ul class="nav navbar-form navbar-left ">
                <li><a href="index.php?username=<?php echo $_GET['username']; ?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a></li>
            </ul> 
            <ul class=" nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        My Account
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="MyProfile.php?username=<?php echo $_GET['username']; ?>">My Profile</a></li>
                        <li><a href="#">My Files</a></li>
                        <li><a href="index.php">Logout</a></li>  <!--Returns you to initial blank index page-->
                    </ul>
            </ul>

        </div>
    </div>
    
    <div class = "container">
		<h1> Notes</h1>
		<?php
			//display all user's saved notes
			if($_GET!=NULL){
			
				$statement="select * from Notes where author='". $_GET["username"]."';";
				$notes=mysqli_query($DBconnection,$statement);
				
				if (!$notes) { 
					echo "You do not have any note files saved.";
				}
					
					echo "<table class = 'table table-hover'>";//Basic table
						echo "<thead>";
							echo "<th>File Name</th>";
						echo "</thead>";
						echo "<tbody>";
							while($dataRow=mysqli_fetch_array($notes,MYSQL_BOTH)){
									//temporary
									echo "<tr><td><a href='index.php?username=".$dataRow['author']."&title=".$dataRow['title']."&comments=".$dataRow['comments']."'>";
									echo $dataRow['title'];
									echo "<tr><td><a href='index.php?username=".$dataRow['author']."&title=".$dataRow['title']."&comments=".$dataRow['comments']."'>";
									echo $dataRow['author'];
									echo "<tr><td><a href='index.php?username=".$dataRow['author']."&title=".$dataRow['title']."&comments=".$dataRow['comments']."'>";
									echo $dataRow['last_mod'];
									echo "</a></td></tr>";
							}
						echo "</tbody>";
					echo "</table>";
				
				mysqli_free_result($notes);	
			}
			
		?>
		
	</div>

</body>


</html>

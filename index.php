<?php
	session_start();
	if(isset($_GET["signout"])){
		session_unset();
		session_destroy();
	}
	if(empty($_SESSION["UserCheck"]))
		header("Location: memlapsSignIn.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <title> Memlaps </title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">

    <!--nicedit-->
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
    
    <!--bootstrap-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
    <script src="js/bootstrap.js"></script>

    
  </head>
  <body>
	<?php
		include('dbConnect.php');
		if(isset($_POST['noteText'])){
			if(!isset($_GET['author']))$author=$_POST['username'];
			else $author=$_GET['author'];
			$statement="select * from Notes where author='".$author."' and title='". $_POST["title"]."';";
			
			$note=mysqli_query($DBconnection,$statement);
			$dataRow=mysqli_fetch_array($note,MYSQL_BOTH);
			 
			//check for uploaded file
			if(isset($_FILES['fileToUpload'])){
				include('OCRnoteAdd.php');			
			}
			else $savedNotes=$_POST['noteText'];
			if(!$dataRow){//check for existing note page
				mysqli_free_result($note);
				$statement="INSERT INTO Notes VALUES('".$_POST['title']."','".$author."','".$_POST['comments']."','".$savedNotes."','".date("r")."','meta stuff');";
				mysqli_query($DBconnection,$statement);
			}
			else{
				mysqli_free_result($note);
				$statement="UPDATE Notes SET notes='".$savedNotes."', title='".$_POST['title']."', comments='".$_POST['comments']."' WHERE author='".$author."' and title='". $_POST['title']."';";
				mysqli_query($DBconnection,$statement);
			}
		}
    ?>
    <!--Navigation Bar -->
	<div class ="navbar navbar-inverse navbar-static-top"> 
		<div class = "container" role = "tabpanel">
            
            <ul class=" nav navbar-nav" role = "tablist">
				 <!--Creates a Blank Page. If it's save it is sent to another tab--> 
			    <li role="presentation" <?php if(!isset($_POST["title"]) && !isset($_GET["title"])):?> class = "active" <?php endif; ?>  ><a href = "#BlankPage"  aria-controls="BlankPage" role="tab" data-toggle="tab">Blank Page</a></li> 
               
                <!--If a file is opened it creates a new tab-->
                <?php if(isset($_POST["title"]) || isset($_GET["title"]))  :?><li role="presentation" class = "active"><a href="#FileName"  aria-controls="FileName" role="tab" data-toggle="tab"><?php include('titleDis.php'); ?></a></li>
				<?php endif; ?> 
			</ul> 
	
			
            <ul class=" nav navbar-nav navbar-right">
              <?php if(isset($_POST["username"]) || isset($_GET["username"])) : ?>  <!--Checks to see if signed in-->
					<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        My Account
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="MyProfile.php?username=<?php include('displayUN.php');?>">My Profile</a></li>
                        <li><a href="index.php?signout=true">Logout</a></li>
                    </ul>
				 <?php else :?> 
					<li><a href = "memlapsSignIn.php" >Sign In</a></li>
					<li><a href ="memlapsSignUp.php">Sign Up</a></li>
				 <?php endif; ?> 
				
             </ul>
	
			</div>
		</div>
   
   <div class = "tab-content container" id="bodyDiv">
   
		<!--Saved Notes Tab-->
		<div role="tabpanel" class="tab-pane  <?php if(isset($_POST["title"]) || isset($_GET["title"])):?>active<?php endif; ?> " id="FileName">
			<?php if(!isset($_GET['author'])) :?>
				<form action="index.php?username=<?php include('displayUN.php');?>" method="POST" enctype="multipart/form-data"/>
			<?php else:?>
				<form action="index.php?username=<?php include('displayUN.php'); echo "&author=".$_GET['author'];?>" method="POST" enctype="multipart/form-data"/>
			<?php endif; ?>
					
					<div class="title">
					<h2>Title:</h2>
					</div>
					<input type="text" name="title" value="<?php include('titleDis.php'); ?>"/>
					<br/>
						<br/>
					<div class="THE_BOX">
						<textarea id="myTextArea" cols="186" rows="25" name="noteText"></textarea>
					</div>
					<div class="last">				
					</br><h4>Comments:<h4>
					<input type="text" name="comments" value="<?php include('commentDis.php'); ?>"/>
					<br/>
					<h4>Upload a picture of some text (must be a .png):<h4>
					<input type="file" name="fileToUpload" accept="image/png" id="fileToUpload"/>
					<br/>
					<input type="hidden" name="username" value="<?php include('displayUN.php');?>"/>
					<br/>	
					</div>
					<input type="submit" value="Save"/>
				</form>
		</div>
		
		<!--Blank Page Tab-->
		<div role="tabpanel" class="tab-pane  <?php if(!isset($_POST["title"]) && !isset($_GET["title"])):?> active <?php endif; ?>"id="BlankPage">
			<?php if(!isset($_GET['author'])) :?>
				<form action="index.php?username=<?php include('displayUN.php');?>" method="POST"  enctype="multipart/form-data" />
			<?php else:?>
				<form action="index.php?username=<?php include('displayUN.php'); echo "&author=".$_GET['author'];?>" method="POST" enctype="multipart/form-data"/>
			<?php endif; ?>
					
					<div class="title">
						<h2>Title:</h2>
					</div>
						<input type="text" name="title" />
						<br/>
						<br/>
					

					<div class="THE_BOX">
						<textarea id="myTextArea" cols="186" rows="25" name="noteText"></textarea>
					</div>
						
					<div class="last">				
					</br>
					<h4>Comments:<h4>
					<input type="text" name="comments"/>
					<br/>
					
					
					<h4>Upload a picture of text (must be a .png):<h4>
					<input type="file" name="fileToUpload" accept="image/png" id="fileToUpload"/>
					<br/>
					
					<input type="hidden" name="username" value="<?php include('displayUN.php');?>"/>
					<br/>	
					</div>
					<input type="submit" value="Save"/>
				</form>
		</div>
	
	
		
	</div>
	
  </body>

    
</html>

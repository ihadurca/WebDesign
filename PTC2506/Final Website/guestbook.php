<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Guestbook</title>
<link href="css/final.css" rel="stylesheet" type="text/css">

<script type="text/javascript">



</script>




</head>
<body id="backgroundguest">

<div class="wrapper">

<div class="header">
<h1>Guest Book</h1>
</div>
<br>
<!-- Menu Begin -->
<?php include "menu.php" ?>

<!-- Menu End -->

<div class='content'>
<div class='contenttop'>Guestbook</div>
<form action="guestbook.php" method="post">
<table>
<tr>
	<td>Name: </td><td><input type="text" name="name"></td>
</tr>
<tr>
	<td>Email: </td><td><input type="text" name="email"></td>
</tr>
<tr>
<td>Comment: </td><td><textarea name="comment"></textarea></td>
</tr>
<tr>
<td><input type="submit" value="Submit"></td>
</tr>
</table>
</form>
</div>

<?
$action = $_POST["action"];
$name = $_POST["name"];
$comment = $_POST["comment"];
$email = $_POST["email"];

$dbconn = sqlite_open('guestbook.dat');

$ipaddy = ip2long(getRealIpAddr());
$querytext = "";    
	if ($dbconn) {
      
		//input new data
		if($name!=""){
			
			$querytext = "INSERT INTO guests VALUES ('$name', '$comment', '$email', date('now'))";
			sqlite_query($dbconn, $querytext);
		}
		
		//query and show all data
		$query  = sqlite_query($dbconn, "SELECT Name, Comment, Date, Email FROM guests");
		$result = sqlite_fetch_all($query, SQLITE_ASSOC);
		
		foreach($result as $row){
			$date = $row['Date'];
			$cname = $row['Name'];
			$ccom = $row['Comment'];
			$recemail = $row['Email'];
			//get gravatar
			
$default = "http://www.eloquent-web-and-graphic-design.com/2012_summer/01/nicholas_lace/final_project/images/anonymous_avatar.png";				$size = 80;
			$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $recemail ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
			
			//Build containers for each row & format
			echo "<div class='content'>
			<div class='contenttop'>$date - $cname</div>
			<div class='leftinnercontent'><img src='$grav_url'></div>
			<div class='rightinnercontent'>$ccom</div>
			
			</div>";
		}
		
        echo $querytext;
       
    } else {
        print "Connection to database failed!\n";
    }
	
	
	function getRealIpAddr()
	{
    	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

?>





<?php include 'footer.php' ?>



</div>
</body>
</html>


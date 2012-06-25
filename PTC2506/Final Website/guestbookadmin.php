<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Guestbook</title>
<link href="css/final.css" rel="stylesheet" type="text/css">

<script type="text/javascript">



</script>




</head>
<body>

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
<form action="guestbookadmin.php" method="get">
<table>
<tr>
	<td>Action: </td><td><select name="action">
    <option value="create">Create Table</option>
    <option value="drop">Drop Table</option>
    </select>
</tr>

<tr>
<td><input type="submit" value="Submit"></td>
</tr>
</table>
</form>
</div>

<?
$action = $_GET["action"];
$name = $_GET["name"];
$comment = $_GET["comment"];

$dbconn = sqlite_open('guestbook.dat');

$ipaddy = ip2long(getRealIpAddr());
    if ($dbconn) {
        if($action =="create"){
			sqlite_query($dbconn, "CREATE TABLE guests (Name TEXT, Comment TEXT, Email TEXT, Date TEXT);");
		}
		if($action =="drop"){
			sqlite_query($dbconn, "DROP TABLE guests");
		}
		
		//input new data
		if($name!=""){
			sqlite_query($dbconn, "INSERT INTO guests VALUES ('$name', '$comment', date('now');");
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
			
			$default = "http://www.somewhere.com/homestar.jpg";
			$size = 40;
			$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $recemail ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
			
			//Build containers for each row & format
			echo "<div class='content'>
			<div class='contenttop'>$date - $cname</div>
			<div class='leftinnercontent'><img src='$grav_url'></div>
			<div class='rightinnercontent'>$ccom</div>
			
			</div>";
		}
		
        
       
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


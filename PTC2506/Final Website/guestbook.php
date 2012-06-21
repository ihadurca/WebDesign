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
<form action="guestbook.php" method="get">
<table>
<tr>
	<td>Name: </td><td><input type="text" name="name"></td>
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
$action = $_GET["action"];
$name = $_GET["name"];
$comment = $_GET["comment"];

$dbconn = sqlite_open('guestbook.dat');

$ipaddy = ip2long(getRealIpAddr());
    if ($dbconn) {
        if($action =="create"){
			sqlite_query($dbconn, "CREATE TABLE guests (Name TEXT, Comment TEXT, Date DATE);");
		}
		if($action =="drop"){
			sqlite_query($dbconn, "DROP TABLE guests");
		}
		
		//input new data
		if($name!=""){
			sqlite_query($dbconn, "INSERT INTO guests VALUES ('$name', '$comment', date('now');");
		}
		
		//query and show all data
		$query  = sqlite_query($dbconn, "SELECT Name, Comment, Date FROM guests");
		$result = sqlite_fetch_all($query, SQLITE_ASSOC);
		
		foreach($result as $row){
			$date = $row['Date'];
			$cname = $row['Name'];
			$ccom = $row['Comment'];
			
			//Build containers for each row & format
			echo "<div class='content'>
			<div class='contenttop'>$date - $cname</div>
			$ccom
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


<?php
$servername="localhost";
$username="root";
$password="";
error_reporting(0);
set_time_limit(0);
try{
$conn=new PDO("mysql:host=$servername;dbname=140dev",$username,$password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	echo "Connection failed: ".$e->getMessage();
}

	
	$sql="SELECT tweet_text,tweet_id,count(*) FROM tweets group by tweet_text having count(*) > 2 order by tweet_text";
	$i=0;
	foreach($conn->query($sql) as $rs)
	{
		$id=$rs['tweet_id'];	
		$tweet=$rs['tweet_text'];	
		$sql_sil=("DELETE FROM tweets WHERE tweet_id=$id");
		if ($conn->query($sql_sil) === TRUE) {
		} else {
			echo $i."Gereksiz Kayıt Silindi.:<br>";
		}
		$i++;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Başlıksız Belge</title>
</head>

<body>

<?php

$servername="localhost";
$username="root";
$password="";
error_reporting(0);
try{
$conn=new PDO("mysql:host=$servername;dbname=140dev",$username,$password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e)
{
echo "Connection failed: ".$e->getMessage();
}



	$sql=("SELECT * FROM `tweets`");

	foreach($conn->query($sql) as $rs) //veri tabanından her bir satır için veri alıyoruz.
	{
		
		$tweet=$rs['tweet_text']; //atılan tweetleri buradan çekiyoruz.
		$lat=$rs['geo_lat'];
		$long=$rs['geo_long'];
		$id=$rs['tweet_id'];
		$user_id=$rs['user_id'];
		
		if($lat == 0 and $long == 0)
		{
			$sql_user=("SELECT * FROM users WHERE user_id=$user_id");
			foreach($conn->query($sql_user) as $su)
			{	
				$tweet_sayac+=1;
				$sehir=$su['location'];
				
				if($sehir == NULL)
				{
					$sql_sil=("DELETE FROM users WHERE user_id=$user_id");
					$sql_sill=("DELETE FROM tweets WHERE user_id=$user_id");
					if ($conn->query($sql_sill) === TRUE) {
					} else {
						echo $tweet_sayac."Gereksiz Kayıt Silindi.:<br>";
					}
					
					if ($conn->query($sql_sil) === TRUE) {
					} else {
						echo $tweet_sayac."Gereksiz Kayıt Silindi:<br>";
					}
					
				}
			}
		}
	}
	?>
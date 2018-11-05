<?php 
	require "../../../../Resources/config.php";	
	$db_con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
	// mysqli_select_db($dbname);
	$customerNumber = $_POST["customerNumber"];

	$result = mysqli_query($db_con, "select orderNumber,orderDate, status from orders where customerNumber=$customerNumber");

	echo "<table border='1'>";
	echo "<tr><th>Order Number</th><th>Order Date</th><th>Status</th></tr>";

	while($row=mysqli_fetch_assoc($result))
	{
		echo "<tr>";
		echo "<td>".$row["orderNumber"]."</td>";
		echo "<td>".$row["orderDate"]."</td>";
		echo "<td>".$row["status"]."</td>";
		echo "</tr>";				
	}
	echo "</table>";
	mysqli_close($db_con);
?>
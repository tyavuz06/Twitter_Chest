<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.button {
  border-radius: 4px;
  background-color: #f4511e;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 28px;
  padding: 20px;
  width: 400px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}

h1{
    font-family: "Verdana";
	margin-top:100px;
	font-size: 50px;
}
table{
	margin-top:25px;
}


</style>
</head>
<body>

<h1 align="center">Twitter Sandığına Hoş Geldiniz.</h1>
<table align="center" valign="center">
<tr>
<td>
<a href="deneme.php"><button class="button"><span>Türkiye Geneli Oy Durumu</span></button></a>
</td>
</tr>
<tr>
<td>
<a href="linkdeneme.php?islem=kod&id=0&hafta=17"><button class="button"><span>İl Bazında Oy Oranları</span></button></a>
</td>
</tr>
<tr>
<td>
<a href="tweet_sayi.php?islem=kod&id=0&hafta=17"><button class="button"><span>İl Bazında Oy Sayısı</span></button></a>
</td>
</tr>
<tr>
<td>
<a href="indexx.php"><button class="button"><span>İllerin Haftalık Oy Durumları</span></button></a>
</td>
</tr>
</table>
</body>
</html>
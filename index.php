<!DOCTYPE>
<head>
<title>Spell numbers in Languages</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
<script>
function showHint() {
//  const value = document.getElementById("counts").value.replace(/,/g, '');
//  document.getElementById("counts").value = parseFloat(value).toLocaleString();
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("txtHint").innerHTML = this.responseText; 
    }
  };
  counts=document.getElementById("counts").value;
  Feminine=document.getElementById("Feminine").value;
  Format=document.getElementById("Format").value;
  Order=document.getElementById("Order").value;	 
  xhttp.open("GET", "?Feminine="+Feminine+"&Format="+Format+"&Order="+Order+"&counts="+counts, true);
  xhttp.send();  
} 
setInterval(showHint, 200);
</script>

<?php
error_reporting(E_STRICT);
if(!isset($_GET['counts'])){
	echo "<input type=\"text\" id=\"counts\" onChange=\"showHint()\" onKeyDown=\"showHint()\" onKeyPress=\"showHint()\">
	<select id=\"Feminine\" onChange=\"showHint()\">
	  <option value=\"1\">مذکر</option>
	  <option value=\"2\">مونث</option>
	</select>	
	<select id=\"Format\" onChange=\"showHint()\">
	  <option value=\"1\">مرفوع</option>
	  <option value=\"2\">منصوب أو مجرور</option>
	</select>	
	<select id=\"Order\" onChange=\"showHint()\">
	  <option value=\"1\">الأساسية</option>
	  <option value=\"2\">الترتيبية</option>
	</select>	
	<p id=\"txtHint\"></p>"; 
}else{
	$num = $_GET['counts'];
	echo $FormatNum=number_format($num, 2, ',', '.')."<br>";

	$replaces = range(0, 9);
    $persinaDigits1= array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $persinaDigits2= array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $replaces = array('0','1','2','3','4','5','6','7','8','9');
    echo "<br>".str_replace($replaces, $persinaDigits1 , $FormatNum);
    echo "<br>".str_replace($replaces, $persinaDigits2 , $FormatNum);

	require_once 'Persian.php';
	$str = new convert ;
	echo "<br>".$str->finalcalc($num);
	
	require 'Arabic.php';	
	$Arabic = new I18N_Arabic('Numbers');
	$Arabic->setFeminine($_GET['Feminine']);
    $Arabic->setFormat($_GET['Format']);
    //The cardinal numbers
	//The Ordinal Numbers
	$Arabic->setOrder($_GET['Order']);
    echo "<br>".$Arabic->int2str($num);
	
	require_once 'Numbers/Words.php';

	$fnum = explode('.', sprintf("%.".$fract."f", $num));

	$arr = array("tr_TR", "en_GB", "az", "ru");
	foreach ($arr as &$value) {
		echo "<br>$value: ".Numbers_Words::toWords($num,$value);

		$ret =  Numbers_Words::toWords($fnum[0],$value);
		if ($fnum[1]){
			$ret .=  ' koma '; // point in english
			$ret .= Numbers_Words::toWords($fnum[1],$value);
			echo $ret;
		}
	}
}
?>
</body>
</html>
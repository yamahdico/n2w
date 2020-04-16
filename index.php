<!DOCTYPE>
<head>
<title>Spell numbers in Languages</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
<?php
error_reporting(E_STRICT);
if(!isset($_GET['counts'])){
	?>
	<input type="text" id="counts" onfocusin="showHint()" onkeydown="showHint()">
		<select id="Feminine" onChange="showHint()">
		  <option value="1">مذکر</option>
		  <option value="2">مونث</option>
		</select>	
		<select id="Format" onChange="showHint()">
		  <option value="1">مرفوع</option>
		  <option value="2">منصوب أو مجرور</option>
		</select>	
		<select id="Order" onChange="showHint()">
		  <option value="1">الأساسية</option>
		  <option value="2">الترتيبية</option>
		</select>	
		<p id="txtHint"></p>
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
	</script>
	<?php
}else{
	$num = $_GET['counts'];
	
	//Convert to english
	$replaces = range(0, 9);
    $persinaDigits1= array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $persinaDigits2= array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $num = str_replace($persinaDigits1, $replaces , $num);
    $num = str_replace($persinaDigits2, $replaces , $num);
	
	echo $FormatNum=number_format($num, 2, ',', '.')."<br>";

	$replaces = range(0, 9);
    $persinaDigits1= array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $persinaDigits2= array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
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

	function num2word($num, $lang="en_GB",$fract = 0) {
			require_once('Numbers/Words.php');

			$num = sprintf("%.".$fract."f", $num);
			$fnum = explode('.', $num);

			$ret =  Numbers_Words::toWords($fnum[0],$lang);
			if(!$fract) return $ret;

			$ret .=  ' koma '; // point in english
			$ret .= Numbers_Words::toWords($fnum[1],$lang);

			return $ret;
	}
	$arr = array("tr_TR", "en_GB", "en_US", "az", "ru");
	foreach ($arr as &$value) {
		echo "<br>$value: ".num2word($num,$value,2);
	}
}
?>
</body>
</html>
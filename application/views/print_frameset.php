<html>

<frameset cols="33%,33%,33%">
	<?php
	for ($i=0;$i<$page;$i++) {	
  		echo "<frame src='".site_url()."/mOut/showPrintPage/".$patientId."/".$i."/".$showPrice."' >";
  	}
  	?>

</frameset>

</html>
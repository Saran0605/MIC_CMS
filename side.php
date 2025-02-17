  	<?php


		if ($s == "1152018") {
			include("adminside.php");
		} else {
			if ($frole == "HOD") {
				include("Hside.php");
			} else if ($frole == "Faculty") {
				include("fside.php");
			} else if($frole == "infra"){
				include("cms_iside.php");
			}
			else if ($frole == "DSA") {
				include("DAside.php");
			} else {
				include("fside.php");
			}
		}
		?>
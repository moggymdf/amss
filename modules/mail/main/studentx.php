<?php
//header("Content-type:text/xml; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
echo '<?xml version="1.0" encoding="utf-8"?>';
?>

<info>
	<office_code><?php echo base64_encode(xmlok);?></office_code>
</info>

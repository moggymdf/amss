<?php
// Define Variable
if(!isset($_GET["option"])) { $_GET["option"]=""; }
?>
<html>
<body>

<div class="container">
    <div class="row" align="center">
        <img src="./modules/<?php echo $_GET["option"]; ?>/images/logo.jpg" class="img-responsive" alt="Responsive image">
    </div>
</div>

</body>
</html>

<?php $menu = "A5"; ?>
<?php include('../../../includes/header.php'); ?>
<body>
    <?php session_start(); ?>
    <?php include('../../../includes/nav.php'); ?>
    <div id="content">
        <?php include('../../../includes/connect.php'); ?>
        <?php include('appcontent.php'); ?>
	</div>	
	<?php include('../../../includes/java.php'); ?>
</body>
</html>
<?php ob_end_flush (); ?>
<!-- Page title -->
<?php $Page_Title = 'Carré Magique'; ?>

<!-- Page Content -->
<?php ob_start(); ?>

<section id="Main_Content">
	<?php 
	if (isset($_GET['partie']) AND $_GET['partie'] == 'join') 
	{
		require 'Game_Magic_Square/Game_Magic_Square_Join.php'; 
	}
	elseif(isset($_GET['partie']) AND $_GET['partie'] == 'create')
	{
		require 'Game_Magic_Square/Game_Magic_Square_Setup.php'; 
	}
	?>
</section>

<!-- Specific Page scripts -->
<!-- <script src="../Public/js/Magic_Square_Script.js"></script> -->

<?php $Main_Content = ob_get_clean(); ?>

<!-- Upload template -->
<?php require 'Template_Games.php'; ?>

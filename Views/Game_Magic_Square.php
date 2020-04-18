<!-- Page title -->
<?php $Page_Title = 'Carré Magique'; ?>

<!-- Page Content -->
<?php ob_start(); ?>

<section id="Main_Content">
	<?php require 'Game_Magic_Square/Game_Magic_Square_Content.php'; ?>
</section>

<!-- Specific Page scripts -->
<script src="../Public/js/Magic_Square_Script.js"></script>
<script type="text/javascript">/*Ajouter script socket.io !!*/</script>

<?php $Main_Content = ob_get_clean(); ?>

<!-- Upload template -->
<?php require 'Template_Games.php'; ?>

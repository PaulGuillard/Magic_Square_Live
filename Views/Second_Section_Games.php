<?php
 	$Section_Title = 'S\'occuper avec des jeux';

	$Articles_Read_Handler = new GeneralDatabaseAccess();
	$Articles_List = $Articles_Read_Handler->getGames();
	
	require 'Article_Template.php';
?>

<article id="Magic_Square" style="display: none;">
	<section class="Filters_Options"></section>
	<div class="Article_Picture_Box">
		<figure>
			<img src="../Public/Images/Magic_Square.jpg" class="Article_Picture" />
			<figcaption>Carré magique</figcaption>
		</figure>
	</div>
	<div class="Article_Description">
		<div>
			<h3>
				Le Carré Magique - <span class="Red_Text">En construction</span>
			</h3>
			<p>
				Un jeu de réflexion, de 2 a 5 joueurs. <br/>Construisez votre grille de mots croisés en choisissant une lettre chacun son tour. Le gagnant est celui qui cumule le plus de lettres dans des mots réels dans la grille !
			</p>
		</div>
		<div class="Validate_Button" id="Validate_Button_Default">
			<button class="Button_1">Jouer au Carré Magique !</button>
		</div>
		<div class="Validate_Button" id="Validate_Button_Confirmation">
			<p>
				Voulez-vous démarrer une partie de Carré Magique ?
				<br/>
			</p>
			<p>
				<a class="Button_1 Link_No_Decoration" href="https://www.coronideas.com/?action=jeux&game=CarreMagique&partie=create">Créer une partie</a>
				<a class="Button_1 Link_No_Decoration" href="https://www.coronideas.com/?action=jeux&game=CarreMagique&partie=join">Rejoindre une partie</a>
				<a class="Button_1 Link_No_Decoration" href="https://www.coronideas.com/?action=jeux">Annuler</a>
			</p>	
		</div>
	</div>
</article>
<script src="../Public/js/Magic_Square_Launch_Script.js"></script>

<div id="Magic_Square_Join_Form_Block">
		<h1 class="Game_Set_Title">
	    	Carré Magique - Rejoindre une partie
	    </h1>
		<h3>
			Rejoignez une partie a laquelle vous avez été invité
		</h3>

		<form id="Magic_Square_Join_Email">
			<label for="Magic_Join_Email_Input">Entrez votre adresse e-mail pour rejoindre une partie : </label><br/>
			<input type="email" class="Input_1" name="Magic_Join_Email_Input" id="Magic_Join_Email_Input" required>
			<br/>
			<label for="Magic_Join_Name">Votre nom : </label><br/>
			<input type="text" class="Input_1" name="Magic_Join_Name" id="Magic_Join_Name" required>
			<br/>
			<input type="submit" class="Button_1" name="Magic_Join_Email_Submit" id="Magic_Join_Email_Submit" value="Trouver les parties">
			<br/>
			<p id="Magic_Square_Join_Warning" class="Red_Text"></p>
		</form>

		<div id="Magic_Square_Open_Games_List_Block">
			<table id="Magic_Square_Open_Games_List">
				<tr>
					<th>Identifiant Partie</th>
					<th>Invité par :</th>
					<th>Nombre de joueurs :</th>
					<th>Taille de la grille :</th>
					<th>Action :</th>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>
		</div>

		<aside id="Magic_Square_Rules">
			Les règles :
			<ul>
				<li>Le jeu se joue a deux ou plus</li>
				<li>Chaque joueur dispose d'une grille vierge, qu'il devra compléter avec des lettres et des cases noires.</li>
				<li>Objectif : remplir la grille avec un maximum de mots qui existent !</li>
				<li>Déroulement d'un tour : un joueur sélectionne une lettre de l'alphabet ou une case noire. Tous les joueurs (y compris celui qui a choisi la lettre) doivent alors placer cette lettre dans une des cases encore vierges de leur grille. Une fois que tous les joueurs ont placé leur lettre dans leur grille individuelle, c'est au joueur suivant de choisir une lettre ou une case noire. On répète alors ces opérations jusqu'a ce que la grille soit remplie.</li>
				<li>Décompte des points : a la fin de la partie, chaque joueur compte les points marqués en suivant la règle suivante : 1 lettre dans un mot réel = 1 point. Seuls comptent les mots a l'horizontale ou a la verticale, dans le sens de lecture conventionnel (pas de mots en diagonale). Les mots qui n'ont pas de sens et les cases noires ne rapportent aucun point.</li>
				<li>NB : les verbes conjugués sont autorisés. Il est impossible de déplacer une lettre déja posée sur la grille.</li>
			</ul>
		</aside>
	</div>

	<script type="text/javascript" src="https://www.coronideas.com/Public/js/Magic_Square_Join_Script.js"></script>
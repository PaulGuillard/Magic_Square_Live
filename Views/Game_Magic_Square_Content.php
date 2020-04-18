<div id="Magic_Square_Game">
	<h1 class="Red_Text">Jeu Multijoueur En construction - Pas encore opérationnel</h1>
		<h1 class="Game_Active_Title">
	    	Carré Magique - Game ON
	    </h1>
	    <div id="Magic_Grid_Block">
	    	<div id="Magic_Grid">
	    		<div class="Magic_Grid_Line">
	    			<div class="Magic_Grid_Element Droppable">
	    			
	    			</div>
	    		</div>
	    	</div>
	    	<div id="Magic_Game_Live_Info">
	    		<div id="Magic_Chosen_Letter_Box" class="Droppable">
	    			<p>
	    				Lettre choisie pour ce tour :
	    			</p>
	    			<div id="Magic_Chosen_Letter">
	    				
	    			</div>
	    		</div>

	    		<p>
	    			Liste des joueurs :
	    		</p>
	    		<div id="Magic_Players_List_Block">
		    		<p id="Magic_Other_Players_List">
		    			A completer...
		    		</p>
		    		<p id="Magic_Players_Live_Status">
		    			
		    		</p>
		    	</div>
	    		<div id="Magic_Letter_Confirm">
			    	<p>
			    		<strong>
				    		Confirmez-vous que vous souhaitez placer cette lettre ici ? 
				    		<br/>Aucun changement ne sera possible après cette confirmation.
			    		</strong>
			    	</p>
			    	<p>
			    		<button class="Button_1" id="Magic_Valid_Letter">C'est parti !</button>
			    		<button class="Button_2" id="Magic_Cancel_Letter">Je vais encore réfléchir...</button>
			    	</p>
			    </div>
	    	</div>
	    </div>
	    <div id="Magic_Live_Instructions">
	    	
	    </div>
	    <div id="Magic_Letters_List">
	    	<div id="Magic_Letters_Line_1">
	    		
	    	</div>
	    	<div id="Magic_Letters_Line_2">
	    		
	    	</div>
	    	<div id="Magic_Black_Box">
	    		<div class="Magic_Grid_Element Draggable">BB</div>
	    	</div>
	    </div>
	    <div id="Magic_End_Game">
	    		<div id="Magic_End_Game_Req_Block">
	    			<button class="Button_2" id="Magic_End_Game_Request">Quitter le jeu</button>
	    		</div>
	    		<div id="Magic_End_Game_Conf_Block">
	    			Souhaitez-vous vraiment terminer la partie en cours ? <br/><br/>
	    			<button class="Button_2" id="Magic_End_Game_Confirmation">Quitter</button>
	    			<button class="Button_1" id="Magic_End_Game_Cancel">Rester</button>
	    		</div>
	    </div>
	    <aside id="Magic_Square_Rules_Reminder">
			Rappel des règles :
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

	<script type="text/javascript">
		let playerName = <?= '"'.htmlspecialchars($_POST['Magic_Square_First_Name']).'"';?>;
		let playersEmails = [<?= '"'.htmlspecialchars($_POST['Magic_Square_Player1_Email']).'"';?>, <?= '"'.htmlspecialchars($_POST['Magic_Square_Player2_Email']).'"';?>, <?= '"'.htmlspecialchars($_POST['Magic_Square_Player3_Email']).'"';?>, <?= '"'.htmlspecialchars($_POST['Magic_Square_Player4_Email']).'"';?>, <?= '"'.htmlspecialchars($_POST['Magic_Square_Player5_Email']).'"';?>];
		let gridSize = <?= htmlspecialchars($_POST['Magic_Square_Size']);?>;
		let gameID = <?= htmlspecialchars($_POST['Magic_Square_Id']);?>;
	</script>
	<script src="/socket.io/socket.io.js"></script>
	<script type="text/javascript" src="https://www.coronideas.com/Public/js/Magic_Square_Script.js"></script>
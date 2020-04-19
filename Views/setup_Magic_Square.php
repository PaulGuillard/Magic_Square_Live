<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Création - Carré Magique</title>
        <link rel="stylesheet" type="text/css" href="http://51.178.87.117/magic_square/Public/CSS/Style_Coronideas_Fr.css">
    </head>
 
    <body>
        <div id="Magic_Square_Setup_Form_Block">
            <h1 class="Game_Set_Title">
                Carré Magique - Préparation du jeu
            </h1>
            <h3 id="Socket_io_Status" class="Green_Text">
                <?php echo 'Test de l\'affichage via php'; ?>
            </h3>
            <form id="Magic_Square_Setup_Form" method="post" action="/creer/setup">
                <p>
                    <label for="Magic_Square_First_Name">Votre prénom :</label>
                    <input type="text" name="Magic_Square_First_Name" id="Magic_Square_First_Name" class="Magic_Square_Email_Input" required>
                </p>
                <p>
                    <label for="Magic_Square_Player1_Email">Votre e-mail :</label>
                    <input type="email" name="Magic_Square_Player1_Email" id="Magic_Square_Player1_Email" class="Magic_Square_Email_Input" required>
                </p>

                <p>
                    <label for="Magic_Square_Size">Choisissez la taille de la grille :</label>
                    <select name="Magic_Square_Size" id="Magic_Square_Size">
                        <option value="4">4x4</option>
                        <option value="5">5x5</option>
                        <option value="6">6x6</option>
                        <option value="7">7x7</option>
                        <option value="8">8x8</option>
                    </select>
                </p>

                <p>
                    <label for="Magic_Square_Player2_Email">Ajoutez d'autres joueurs :</label>
                    <br/>
                    E-mail : <input type="email" name="Magic_Square_Player2_Email" id="Magic_Square_Player2_Email" class="Magic_Square_Email_Input" required>
                    <br/>
                    E-mail : <input type="email" name="Magic_Square_Player3_Email" id="Magic_Square_Player3_Email" class="Magic_Square_Email_Input">
                    <br/>
                    E-mail : <input type="email" name="Magic_Square_Player4_Email" id="Magic_Square_Player4_Email" class="Magic_Square_Email_Input">
                    <br/>
                    E-mail : <input type="email" name="Magic_Square_Player5_Email" id="Magic_Square_Player5_Email" class="Magic_Square_Email_Input">
                    <br/>
                    <br/>
                    <input type="text" name="Magic_Square_Id" id="Magic_Square_Id" style="display: none;">
                    <input type="submit" class="Button_1" name="Start_MagicSquare_Button" value="Créer une partie">
                </p>
            </form>
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

        <script src="/socket.io/socket.io.js"></script>
        <script>
            let setupForm = document.getElementById('Magic_Square_Setup_Form');
            let connectStatus = document.getElementById('Socket_io_Status');
            let creatorName = document.getElementById('Magic_Square_First_Name');
            let playerEmail_1 = document.getElementById('Magic_Square_Player1_Email');
            let playerEmail_2 = document.getElementById('Magic_Square_Player2_Email');
            let playerEmail_3 = document.getElementById('Magic_Square_Player3_Email');
            let playerEmail_4 = document.getElementById('Magic_Square_Player4_Email');
            let playerEmail_5 = document.getElementById('Magic_Square_Player5_Email');
            let gridSizeElt = document.getElementById('Magic_Square_Size');
            let gridSize = 5;
            var pseudo = '';
            let creatorEmail = '';
            var friendsList = [];
            var roomID = Math.floor(Math.random()*100000);
            const game_setup = io.connect('http://51.178.87.117:8087/magic_square');

            setupForm.addEventListener('submit', function(e){
                e.preventDefault();
                pseudo = creatorName.value;
                creatorEmail = playerEmail_1.value;
                friendsList = [playerEmail_1.value, playerEmail_2.value, playerEmail_3.value, playerEmail_4.value, playerEmail_5.value];
                gridSize = gridSizeElt.value;
                game_setup.emit('new_game', {newpseudo: pseudo, playerEmail: creatorEmail, friends: friendsList, gridSize: gridSize, roomid: roomID, type: 'creator'});
                //Verifier les entrees : texte, mail, etc
                console.log('The game creation was submitted');
                setupForm.submit();
            });
        </script>
    </body>
</html>

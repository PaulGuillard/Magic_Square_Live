<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Rejoindre un Carré Magique</title>
        <link rel="stylesheet" type="text/css" href="http://51.178.87.117/magic_square/Public/CSS/Style_MagicSquare_Fr.css">
    </head>
 
    <body>
        <div id="Magic_Square_Setup_Form_Block">
            <h1 class="Game_Set_Title">
                Carré Magique - Rejoindre une partie
            </h1>
            <h3 id="Socket_io_Status" class="Green_Text">

            </h3>
            <form id="Magic_Square_Join_Form" method="post" action="/rejoindre/join">
                <p>
                    <label for="Magic_Square_First_Name">Votre prénom :</label>
                    <input type="text" name="Magic_Square_First_Name" id="Magic_Square_First_Name" class="Magic_Square_Email_Input" required>
                </p>
                <p>
                    <label for="Magic_Square_Player_Email">Votre e-mail :</label>
                    <input type="email" name="Magic_Square_Player_Email" id="Magic_Square_Player_Email" class="Magic_Square_Email_Input" required>
                </p>
                <p>
                    <label for="Magic_Square_Room_Id">Numéro de la partie :</label>
                    <input type="text" name="Magic_Square_Room_Id" id="Magic_Square_Room_Id" class="Magic_Square_Email_Input" required>
                </p>
                <input type="text" name="Magic_Square_Grid_Size" id="Magic_Square_Grid_Size" style="display: none;">
                <input type="text" name="Magic_Square_Player_1" class="Magic_Square_Players_Emails" style="display: none;">
                <input type="text" name="Magic_Square_Player_2" class="Magic_Square_Players_Emails" style="display: none;">
                <input type="text" name="Magic_Square_Player_3" class="Magic_Square_Players_Emails" style="display: none;">
                <input type="text" name="Magic_Square_Player_4" class="Magic_Square_Players_Emails" style="display: none;">
                <input type="text" name="Magic_Square_Player_5" class="Magic_Square_Players_Emails" style="display: none;">
                <p>
                    <input type="submit" class="Button_1" name="Start_MagicSquare_Button" value="Rejoindre la partie">
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
            let joinForm = document.getElementById('Magic_Square_Join_Form');
            let connectStatus = document.getElementById('Socket_io_Status');
            let joinerNameElt = document.getElementById('Magic_Square_First_Name');
            let joinerEmailElt = document.getElementById('Magic_Square_Player_Email');
            let gridSizeElt = document.getElementById('Magic_Square_Grid_Size');
            let emailsElts = document.querySelectorAll('.Magic_Square_Players_Emails');
            var roomIDElt = document.getElementById('Magic_Square_Room_Id');
            const game_join = io.connect('http://51.178.87.117:8087/magic_square');
            let randomToken = Math.floor(Math.random() * 1235);

            game_join.on('new_joiner_valid', function(completeData){
                console.log('Demande acceptée pour rejoindre la partie !');
                if (completeData.token === randomToken) 
                {
                    console.log('Token reconnu ! Vous pouvez rejoindre la partie.');
                    let gridSize = completeData.gridSize;
                    let friends = completeData.friendsList;

                    gridSizeElt.value = gridSize;
                    for (var i = 0; i < friends.length; i++) {
                        emailsElts[i].value = friends[i];
                    }

                    pseudo = joinerNameElt.value;
                    joinerEmail = joinerEmailElt.value;
                    roomID = Number(roomIDElt.value);
                    game_join.emit('new_game', {newpseudo: pseudo, playerEmail: joinerEmail, friends: friends, gridSize: gridSize, roomid: roomID, firstIndex: '', type: 'joiner'});
                    joinForm.submit();
                }
            });

            joinForm.addEventListener('submit', function(e){
                e.preventDefault();
                pseudo = joinerNameElt.value;
                joinerEmail = joinerEmailElt.value;
                roomID = Number(roomIDElt.value);
                if (Number.isInteger(roomID) && roomID > 0 && roomID < 100001) 
                {
                    game_join.emit('new_joiner_check', {newpseudo: pseudo, playerEmail: joinerEmail, roomid: roomID, token: randomToken});
                    console.log('Join request sent by ' + joinerEmail);
                }                
            });
        </script>
    </body>
</html>

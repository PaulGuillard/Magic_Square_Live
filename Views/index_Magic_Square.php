<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Carré Magique</title>
    </head>
 
    <body>
        <h1>Carré Magique</h1>

<!--         <form>
            <input type="text" name="" id="Message_Input">
            <input type="button" value="Envoyer" id="Message_Send" />
        </form> -->
        <section id="Message_Panel">
            
        </section>

        <script src="/socket.io/socket.io.js"></script><!-- http://www.ws.coronideas.glrd.me -->
        <script>
            let messagePanel = document.getElementById('Message_Panel');
            let setupForm = document.getElementById('Magic_Square_Setup_Form');
            let connectStatus = document.getElementById('Socket_io_Status');
            let creatorName = document.getElementById('Magic_Square_First_Name');
            let playerEmail_1 = document.getElementById('Magic_Square_Player1_Email');
            let playerEmail_2 = document.getElementById('Magic_Square_Player2_Email');
            let playerEmail_3 = document.getElementById('Magic_Square_Player3_Email');
            let playerEmail_4 = document.getElementById('Magic_Square_Player4_Email');
            let playerEmail_5 = document.getElementById('Magic_Square_Player5_Email');
            const magic_square = io.connect('http://localhost:8080/magic_square');

            // On demande le pseudo au visiteur...
            magic_square.on('connect', function(){
                messagePanel.innerHTML = 'Vous etes connecté a la partie !';
                magic_square.emit('getPlayerDetails');
            })

            magic_square.on('playerDetails', function(detailsData){
                messagePanel.innerHTML += detailsData.pseudo;
                messagePanel.innerHTML += detailsData.email;
            })

            var pseudo = '';
            let creatorEmail = '';
            var friendsList = [];
            var roomID = 1;

            setupForm.addEventListener('submit', function(e){
                e.preventDefault();
                pseudo = creatorName.value;
                creatorEmail = playerEmail_1.value;
                friendsList = [playerEmail_1.value, playerEmail_2.value, playerEmail_3.value, playerEmail_4.value, playerEmail_5.value];
                game_setup.emit('new_game', {newpseudo: pseudo, playerEmail: creatorEmail, friends: friendsList, roomid: roomID});
                console.log('The game creation was submitted');
                window.location.href = '/rejoindre';
            });

            // On demande le pseudo au visiteur...
            game_setup.on('connect', function(){
                connectStatus.innerHTML = 'Connexion au socket.io initialisée';
            })
            
            // On affiche une boîte de dialogue quand le serveur nous envoie un "message"
            /*chat.on('newcomer_message', function(message) {
                messagePanel.innerHTML += '<em style="color: green;">' + message + '</em><br/><br/>';
            })

            chat.on('new_message', function(messageData) {
                messagePanel.innerHTML += '<strong>' + messageData.pseudo + ': </strong>' + messageData.message + '<br/><br/>';
            })

            chat.on('disconnect_message', function(messageData) {
                messagePanel.innerHTML += '<span style="color: red;">' + messageData.message + '</span><br/><br/>';
            })*/

            // Lorsqu'on clique sur le bouton, on envoie un "message" au serveur
            /*let chatForm = document.querySelector('form');
            let messageContent = document.getElementById('Message_Input');
            chatForm.addEventListener('submit', function (e) {
                e.preventDefault();
                chat.emit('message', messageContent.value);*/
                /*messagePanel.innerHTML += '<strong>' + pseudo + ': </strong>' + messageContent.value + '<br/><br/>';*///Not needed because sent to everyone in chat namespace
                /*messageContent.value = '';
            });*/
        </script>
    </body>
</html>

var http = require('http');
var fs = require('fs');
var ent = require('ent');//Module de securisation des donnees texte
var express = require('express');
const path = require('path');
var session = require("express-session")({
    secret: "magicsquarescrt",
    resave: true,
    saveUninitialized: true
  });
var sharedsession = require("express-socket.io-session");
var bodyParser = require('body-parser');
var urlencodedParser = bodyParser.urlencoded({ extended: false });

var app = express();

var httpServer = http.createServer(app);

// Chargement de socket.io
var io = require('socket.io').listen(httpServer);


app.use(session);

app.use(function(req, res, next){
    if (typeof(req.session.playerName) == 'undefined') {
        req.session.playerName = '';
    }
    if (typeof(req.session.playerEmail) == 'undefined') {
        req.session.playerEmail = '';
    }
    if (typeof(req.session.friendsList) == 'undefined') {
        req.session.friendsList = [];
    }
    if (typeof(req.session.gridSize) == 'undefined') {
        req.session.gridSize = 5;
    }
    if (typeof(req.session.roomID) == 'undefined') {
        req.session.roomID = 0;
    }
    next();
})

.get('/creer', function(req, res){
    res.header('Content-type', 'text/html');
    res.sendFile(path.join(__dirname+'/Views/setup_Magic_Square.php'));
})

.post('/creer/setup', urlencodedParser, function(req, res){
    if (req.body.Magic_Square_First_Name != '') {
        req.session.playerName = req.body.Magic_Square_First_Name;
    }
    if (req.body.Magic_Square_Player1_Email != '') {
        req.session.playerEmail = req.body.Magic_Square_Player1_Email;
        req.session.friendsList.push(req.body.Magic_Square_Player1_Email);
    }
    if (req.body.Magic_Square_Player2_Email != '') {
        req.session.friendsList.push(req.body.Magic_Square_Player2_Email);
        req.session.friendsList.push(req.body.Magic_Square_Player3_Email);
        req.session.friendsList.push(req.body.Magic_Square_Player4_Email);
        req.session.friendsList.push(req.body.Magic_Square_Player5_Email);
    }
    if (req.body.Magic_Square_Size != '') {
        req.session.gridSize = req.body.Magic_Square_Size;
    }
    res.redirect('/game_on');
})

.get('/rejoindre', function (req, res) {
    res.header('Content-type', 'text/html');
    res.sendFile(path.join(__dirname+'/Views/join_Magic_Square.php')); //path permet de definir un chemin absolu, indispensable avec Express
})

.post('/rejoindre/join', urlencodedParser, function(req, res) {
    if (req.body.Magic_Square_First_Name != '') {
        req.session.playerName = req.body.Magic_Square_First_Name;
    }
    if (req.body.Magic_Square_Player_Email != '') {
        req.session.playerEmail = req.body.Magic_Square_Player_Email;
    }
    if (req.body.Magic_Square_Room_Id != '') {
        req.session.roomID = req.body.Magic_Square_Room_Id;
    }
    if (req.body.Magic_Square_Grid_Size != '') {
        req.session.gridSize = req.body.Magic_Square_Grid_Size;
    }
    req.session.friendsList.push(req.body.Magic_Square_Player_1);
    req.session.friendsList.push(req.body.Magic_Square_Player_2);
    req.session.friendsList.push(req.body.Magic_Square_Player_3);
    req.session.friendsList.push(req.body.Magic_Square_Player_4);
    req.session.friendsList.push(req.body.Magic_Square_Player_5);
    res.redirect('/game_on');
})

.get('/game_on', function(req, res){
    res.header('Content-type', 'text/html');
    res.sendFile(path.join(__dirname+'/open_Magic_Square.html')); 
});

const magic_square = io.of('/magic_square');

io.of('/magic_square').use(sharedsession(session, {
    autoSave: true
}));

magic_square.on('connection', function (socket) {
    //Definition of game room

    socket.pseudo = '';
    socket.roomID = '';
    socket.friendsList = [];
    socket.gameStarted = 0;
    let checkToken;

    socket.on('new_game', function(joinData) {
        socket.handshake.session.userdata = joinData;
        socket.handshake.session.save();
        socket.pseudo = ent.encode(joinData.newpseudo);
        socket.playerEmail = joinData.playerEmail;
        socket.friendsList = joinData.friends;
        socket.gridSize = joinData.gridSize;
        socket.roomID = joinData.roomid;
        socket.type = joinData.type;
        if (Number.isInteger(socket.roomID) && socket.friendsList.indexOf(socket.playerEmail) > -1) 
        {
/*            socket.join('Room_'+socket.roomID);*/
            console.log(socket.pseudo + ' a rejoint la partie no'+socket.roomID+' ! Son email : ' + socket.playerEmail);
        }

    });

    socket.on('new_joiner_check', function(joinData) {
        checkRoomJoin(joinData.playerEmail, joinData.roomid, joinData.token);
    });

    socket.on('player_accepted', function(joinData) {
        console.log('Join request accepted on server side. Sending data to joiner page... Token : ' + joinData.token);
        magic_square.emit('new_joiner_valid', joinData);
    });

    socket.on('join_game_message', function(email) {
        if (Number.isInteger(socket.roomID)) 
        {
            magic_square.to('Room_'+socket.roomID).emit('newcomer_message', email + ' a rejoint la partie ! ');
            console.log(email + ' a rejoint la partie !');
        }  
        else
        {
            console.log(email + ' a tenté de se connecter a la partie...');
        }
    });

    socket.on('getPlayersDetails', function() {
        if (typeof(socket.handshake.session.userdata) == 'undefined') 
        {
            if(socket.type === 'creator')
            {
                socket.emit('redirect_create');
            }
            else if (socket.type === 'joiner') 
            {
                socket.emit('redirect_join');
            }
        }
        else
        {
            joinData = socket.handshake.session.userdata;
            socket.pseudo = ent.encode(joinData.newpseudo);
            socket.playerEmail = joinData.playerEmail;
            socket.friendsList = joinData.friends;
            socket.gridSize = joinData.gridSize;
            socket.roomID = joinData.roomid;
            socket.gameStarted = 1;
            console.log('Partie demarree pour ' + socket.pseudo);
/*            magic_square.to('Room_'+socket.roomID).emit('newcomer_message', socket.pseudo + ' a rejoint la partie ! ');*/
            socket.join('Room_'+socket.roomID);
            socket.emit('playerDetails', {room: socket.roomID, pseudo: socket.pseudo, email: socket.playerEmail, gridSize: socket.gridSize, friendsList: socket.friendsList});
        }
    });

    socket.on('update_connection', function(joinerData) {
        magic_square.to('Room_'+socket.roomID).emit('new_connection', joinerData);
    });

    socket.on('get_connections', function(){
        magic_square.to('Room_'+socket.roomID).emit('connection_check');
    });

    socket.on('chat_message', function (message) {
        // On récupère le pseudo de celui qui a cliqué dans les variables de session
        message = ent.encode(message);
        if (Number.isInteger(socket.roomID) && socket.friendsList.indexOf(socket.playerEmail) > -1) 
        {
            console.log('Message '+message+' broadcasted on chat of room no' + socket.roomID);
            magic_square.to('Room_'+socket.roomID).emit('new_chat_message', {pseudo: socket.pseudo, message: message});
        }
    }); 

    socket.on('new_live_message', function(message) {
        magic_square.to('Room_'+socket.roomID).emit('new_live_message_all', message);
    });

    socket.on('update_names_for_all', function(){
        magic_square.to('Room_'+socket.roomID).emit('update_names');
    });

    socket.on('choose_player', function(playerIndex){
        magic_square.to('Room_'+socket.roomID).emit('choose_player_all', playerIndex);
    });

    socket.on('play', function(letter) {
        magic_square.to('Room_'+socket.roomID).emit('play_all', letter);
    });

    socket.on('has_played', function(email){
        console.log(email + ' has played.');
        magic_square.to('Room_'+socket.roomID).emit('has_played_confirm', email);
    })

    socket.on('check_all_players_play', function() {
        magic_square.to('Room_'+socket.roomID).emit('play_check');
    });

    socket.on('disconnect', function () {
        if (typeof socket.playerEmail != 'undefined' && socket.gameStarted === 1) 
        {
            magic_square.to('Room_'+socket.roomID).emit('disconnected_player', socket.playerEmail);
            console.log(socket.playerEmail + ' est déconnecté...');
        }
    });


    function checkRoomJoin(e_mail, room_id, token) {
        room_id = Number(room_id);
        if (typeof e_mail != 'undefined' && Number.isInteger(room_id)) 
        {
            console.log('Demande envoyee a la partie ouverte pour : ' + e_mail);
            magic_square.to('Room_'+room_id).emit('check_correct_player', {email: e_mail, token: token});
        }
    }
});

app.use(function(req, res, next){
    res.setHeader('Content-Type', 'text/plain');
    res.status(404).send('Page introuvable !');
});

httpServer.listen(87);

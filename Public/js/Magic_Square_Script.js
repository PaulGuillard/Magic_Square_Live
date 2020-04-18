let gameBlock = document.getElementById('Magic_Square_Game');
let gameGrid = document.getElementById('Magic_Grid');
let lettersBlock = document.getElementById('Magic_Letters_List');
let lettersLine1 = document.getElementById('Magic_Letters_Line_1');
let lettersLine2 = document.getElementById('Magic_Letters_Line_2');
let gameOnTitle = gameBlock.querySelector('h1');
let gridLine = gameGrid.querySelector('.Magic_Grid_Line');
let gridLineWidth = parseFloat(getComputedStyle(gameGrid).width);
let gridLineHeight = parseFloat(getComputedStyle(gameGrid).height);
let gridEltHtml = gridLine.innerHTML;
let playersStatusList = document.getElementById('Magic_Players_Live_Status');
let quitButtonBlock = document.getElementById('Magic_End_Game_Req_Block');
let quitButton = document.getElementById('Magic_End_Game_Request');
let quitConfirm = document.getElementById('Magic_End_Game_Conf_Block');
let quitConfButton = document.getElementById('Magic_End_Game_Cancel');
let quitReconfirm = document.getElementById('Magic_End_Game_Confirmation');
let draggableElements = document.getElementsByClassName('Draggable');
let dropperAreas = document.getElementsByClassName('Droppable');
let chosenLetterBox = document.getElementById('Magic_Chosen_Letter_Box');
let chosenLetter = document.getElementById('Magic_Chosen_Letter');
let placeLetterConfirm = document.getElementById('Magic_Letter_Confirm');
let placeLetterValid = document.getElementById('Magic_Valid_Letter');
let placeLetterCancel = document.getElementById('Magic_Cancel_Letter');
let liveInstructions = document.getElementById('Magic_Live_Instructions');
let actionToPerform = 'select';
let gridLineHtml = '';
let alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

/*All functions in a namespace*/
let magicSquareHandler = { //Creation of a namespace for all methods necessary for Magic Square
	buildGrid: function(size) { //Build play grid to the requested size
		let newWidth = gridLineWidth;
		let newHeight = gridLineHeight;
		for (var i = 0; i < size-1; i++) 
		{
			gridLine.innerHTML += gridEltHtml;
			newWidth += (gridLineWidth - 2); //-2 due to border 1px
			newHeight += gridLineHeight; //border repeated by html, no need to account for
		}
		gameGrid.style.width = newWidth + 'px';
		gameGrid.style.height = newHeight + 'px';
		gridLineHtml = gameGrid.innerHTML;
		for (var i = 0; i < size - 1; i++) 
		{
			gameGrid.innerHTML += gridLineHtml;
		}
	},

	buildLetterList: function() { //Build list of letters to be played
		for (var i = 0; i < 13; i++) 
		{
			lettersLine1.innerHTML += '<div class="Magic_Grid_Element Draggable">' + alphabet[i] +'</div>';
		}
		for (var i = 13; i < 26; i++) 
		{
			lettersLine2.innerHTML += '<div class="Magic_Grid_Element Draggable">' + alphabet[i] +'</div>';
		}
	},

	draggedElement: null,

	applyDragEvents: function(element) {
    	element.draggable = true;

    	let dndHandler = this; 

/*		dragImg.src = 'Images/file_mini_test_full.jpg';*/

        element.addEventListener('dragstart', function(e) {
            dndHandler.draggedElement = e.target; // Defines which element is being moved
/*    		e.dataTransfer.setDragImage(dragImg, 40, 40);*/
            e.dataTransfer.setData('text/plain', ''); // Required for Firefox
        });
	},

	applyDropEvents: function(dropper) {

		dropper.addEventListener('dragenter', function() { //action to be performed when entering the drop zone
			if (this.id === 'Magic_Chosen_Letter_Box' && actionToPerform === 'select') 
			{
				this.className = 'Droppable drop_hover';
			}
			else if (this.parentNode.id === 'Magic_Chosen_Letter_Box' && actionToPerform === 'select') 
			{
				this.parentNode.className = 'Droppable drop_hover';
			}
			else if (this.id != 'Magic_Chosen_Letter_Box' && this.parentNode.id != 'Magic_Chosen_Letter_Box' && actionToPerform === 'play')
			{
				this.className = 'Magic_Grid_Element Droppable drop_hover';
			}
		});

        dropper.addEventListener('dragover', function(e) {
            e.preventDefault(); // Authorizes element drop
            if (this.id === 'Magic_Chosen_Letter_Box' && actionToPerform === 'select') 
			{
				this.className = 'Droppable drop_hover';
			}
			else if (this.parentNode.id === 'Magic_Chosen_Letter_Box' && actionToPerform === 'select') 
			{
				this.parentNode.className = 'Droppable drop_hover';
			}
			else if (this.id != 'Magic_Chosen_Letter_Box' && this.parentNode.id != 'Magic_Chosen_Letter_Box' && actionToPerform === 'play')
			{
				this.className = 'Magic_Grid_Element Droppable drop_hover';
			}
        });
        
        dropper.addEventListener('dragleave', function() {
        	if (this.id === 'Magic_Chosen_Letter_Box' && actionToPerform === 'select') 
			{
				this.className = 'Droppable';
			}
			else if (this.parentNode.id === 'Magic_Chosen_Letter_Box' && actionToPerform === 'select') 
			{
				this.parentNode.className = 'Droppable';
			}
			else if (this.id != 'Magic_Chosen_Letter_Box' && this.parentNode.id != 'Magic_Chosen_Letter_Box' && actionToPerform === 'play')
			{
            	this.className = 'Magic_Grid_Element Droppable'; // Reset to normal area
            }
        });

        dropper.addEventListener('drop', function(e) {
        	e.preventDefault();
		    let target = e.target,
		    currentLetter = target.textContent,
		    draggedLetter = magicSquareHandler.draggedElement.textContent;
		    if (target.id === 'Magic_Chosen_Letter_Box' && actionToPerform === 'select') 
		    {
		    	chosenLetter.innerHTML = '';
		    	chosenLetter.innerHTML = draggedLetter;
			    if (draggedLetter === 'BB') { //Case black case is dropped
			    	chosenLetter.style.backgroundColor = 'black';
			    }
			    else
			    {
			    	chosenLetter.style.backgroundColor = 'white';
			    }
			    target.className = '';//Droppable
			    magic_square.emit('play', draggedLetter);
			    magicSquareHandler.lockLetters(draggedLetter);
		    }
		    else if(target.parentNode.id === 'Magic_Chosen_Letter_Box' && actionToPerform === 'select')
		    {
		    	chosenLetter.innerHTML = '';
		    	chosenLetter.innerHTML = draggedLetter;
			    if (draggedLetter === 'BB') { //Case black case is dropped
			    	chosenLetter.style.backgroundColor = 'black';
			    }
			    else
			    {
			    	chosenLetter.style.backgroundColor = 'white';
			    }
			    target.parentNode.className = '';//Droppable
			    magic_square.emit('play', draggedLetter);
			    magicSquareHandler.lockLetters(draggedLetter);
		    }
		    else if (actionToPerform === 'play' && target.id != 'Magic_Chosen_Letter_Box' && target.parentNode.id != 'Magic_Chosen_Letter_Box')
		    {
		    	console.log(target.id);
		    	console.log(target.parentNode.id);
		    	if (alphabet.indexOf(target.innerHTML) === -1) {
		    		placeLetterConfirm.style.display = 'block';
		    		target.innerHTML = '';
			    	target.innerHTML = draggedLetter;

			    	placeLetterValid.addEventListener('click', confirmLetter);

				    placeLetterCancel.addEventListener('click', cancelLetter);

				    function confirmLetter() {
				    	target.className = 'Magic_Grid_Element'; // Deactivates dropability
			   			magicSquareHandler.resetDragDrop(target, currentLetter);
			   			placeLetterConfirm.style.display = 'none';
			   			magic_square.emit('has_played', playerEmail);
			   			placeLetterValid.removeEventListener('click', confirmLetter);
						placeLetterCancel.removeEventListener('click', cancelLetter);
				    }
				    function cancelLetter() {
				    	target.innerHTML = ' ';
					    target.className = 'Magic_Grid_Element Droppable';
				    	placeLetterConfirm.style.display = 'none';
				    	target.style.backgroundColor = '';
				    	placeLetterValid.removeEventListener('click', confirmLetter);
						placeLetterCancel.removeEventListener('click', cancelLetter);
				    }

				    if (draggedLetter === 'BB') {
				    	target.style.backgroundColor = 'black';
				    }
			    }
			    else
			    {
			    	target.className = 'Magic_Grid_Element';
			    }
		    }
		});      
    }, 

    resetDragDrop: function(target, letter) {
    	target.addEventListener('dragenter', function() { //action to be performed when entering the drop zone
		    this.className = 'Magic_Grid_Element drop_impossible';
		});

        target.addEventListener('dragover', function(e) {
            e.preventDefault(); // Authorizes element drop
		    this.className = 'Magic_Grid_Element drop_impossible';
        });
        
        target.addEventListener('dragleave', function() {
            this.className = 'Magic_Grid_Element'; // Reset to normal area
        });
    },

    buildDragDrop: function(selectLetter) {
    	if (!selectLetter) {
    		draggableElements = document.getElementsByClassName('Draggable');
    	}
		dropperAreas = document.getElementsByClassName('Droppable');

		let elementsLen = draggableElements.length;
		let droppersLen = dropperAreas.length;

		for (var i = 0 ; i < elementsLen ; i++) {
		    magicSquareHandler.applyDragEvents(draggableElements[i]); // Application des paramètres nécessaires aux éléments déplaçables
		}   

		for (var i = 0 ; i < droppersLen ; i++) {
		    magicSquareHandler.applyDropEvents(dropperAreas[i]); // Application des événements nécessaires aux zones de drop
		}
    },

    lockLetters: function(selectLetter) {
    	let elementsLen = draggableElements.length;
    	for (var i = 0 ; i < elementsLen ; i++) {
    		if (draggableElements[i].textContent != selectLetter) {
    			draggableElements[i].setAttribute('draggable', 'false');
    			draggableElements[i].style.opacity = 0.4;
    			draggableElements[i].style.cursor = 'default';
    		}
		}
    },

    releaseLetters: function() {
    	let elementsLen = draggableElements.length;
    	for (var i = 0 ; i < elementsLen ; i++) {
			draggableElements[i].draggable = 'true';
			draggableElements[i].style.opacity = 1;
			draggableElements[i].style.cursor = 'move';
		}
    }
};

//Creation of the game platform
function launchGame(grid_Size) {
	magicSquareHandler.buildGrid(grid_Size);
	magicSquareHandler.buildLetterList();
	magicSquareHandler.buildDragDrop();
	liveInstructions.innerHTML = 'Bienvenue dans cette partie ! En attente de la connexion de tous les joueurs...'
}

//Game exit
quitButton.addEventListener('click', function(){ //Confirmation request
	quitButtonBlock.style.display = 'none';
	quitConfirm.style.display = 'block';
});

quitConfButton.addEventListener('click', function() { //Confirmation Cancel
	quitButtonBlock.style.display = 'block';
	quitConfirm.style.display = 'none';
});

quitReconfirm.addEventListener('click', function() {
/*	let xhr_quit = new XMLHttpRequest();
    xhr_quit.open('POST', 'https://www.coronideas.com/View/Backend/Game_Magic_Square_Get_Open_Game_List.php');
*/
/*    xhr_quit.addEventListener('load', function(e) {*/
    	window.location.href = "http://51.178.87.117:87/creer";
/*    });*/
/*
    let form_quit = new FormData();

	form_quit.append('Update_Game_ID', gameID);
	form_quit.append('Update_Player_Position', playerPositionInDb);
	form_quit.append('Update_Player_Status', '0');

	xhr_quit.send(form_quit);*/
});

/*Execute actions based on namespace methods*/
/*if (setupForm != '') //Start game from setup
{
	setupForm.addEventListener('submit', function(e) { //Get form data and display grid - in this script because requires event listener to perform display and database update
		e.preventDefault();
		let playerPositionInDb = 1;
		playersList.innerHTML = '';
		playerName = setupInputs[0].value;
		gridSize = selectGridSize.options[selectGridSize.selectedIndex].value;

		playersList.innerHTML += setupInputs[0].value + '<br/>';
		playersList.innerHTML += nameInputs[0].value + '<br/>';
		let Player_Names = [playerName, nameInputs[0]];
		if (setupInputs[5].value != '') 
		{
			numberPlayers += 1;
			playersList.innerHTML += nameInputs[1].value + '<br/>';
			Player_Names.push(nameInputs[1]);
		}
		if (setupInputs[7].value != '') 
		{
			numberPlayers += 1;
			playersList.innerHTML += nameInputs[2].value + '<br/>';
			Player_Names.push(nameInputs[2]);
		}
		if (setupInputs[9].value != '') 
		{
			numberPlayers += 1;
			playersList.innerHTML += nameInputs[3].value + '<br/>';
			Player_Names.push(nameInputs[3]);
		}



*/
/* window.addEventListener('unload', function(event) {
    let xhr_quit = new XMLHttpRequest();
    xhr_quit.open('POST', 'https://www.coronideas.com/View/Backend/Game_Magic_Square_Get_Open_Game_List.php');

    let form_quit = new FormData();

	form_quit.append('Update_Game_ID', gameID);
	form_quit.append('Update_Player_Position', playerPositionInDb);
	form_quit.append('Update_Player_Status', '0');

	xhr_quit.send(form_quit);
});*/



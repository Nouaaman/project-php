//getting game id form url else redirect to home page
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
let idGame
if (urlParams.has('idGame')) {
    idGame = urlParams.get('idGame')
} else {
    window.location = '/';
}



//global variables
const usernameOfPlayer = document.getElementById('username').value;
const titleInfo = document.getElementById('titleInfo')
const gameContainer = document.getElementById('gameContainer')
const questionModal = document.getElementById('questionModal')
const playButton = document.getElementById('playButton')


/**functions** */
function generateLine(username, color) {

    let line = document.createElement("div")
    line.setAttribute('class', 'line');
    line.setAttribute('id', username);
    line.style.backgroundColor = color
    let ul = document.createElement("ul")
    ul.setAttribute('class', 'cases')
    ul.setAttribute('id', 'cases')
    for (let i = 0; i < 48; i++) {
        let li = document.createElement('li')
        ul.appendChild(li)
    }
    line.appendChild(ul)
    let p = document.createElement("p");
    p.setAttribute('id', 'usernameCase')
    p.innerText = username
    line.appendChild(p)
    gameContainer.appendChild(line)
}

function showQuestionModal() {
    questionModal.classList.remove('hidden')
}


/* connect to server */
const conn = new WebSocket('ws://localhost:8282');

//handle still connecting error to send msg
let wsSend = function (data) {
    if (!conn.readyState) {
        console.log(conn.readyState);
        setTimeout(function () {
            wsSend(data);
        }, 100);
    } else {
        conn.send(data);
    }
}

//join game
const payLoad = {
    "method": "join",
    "username": usernameOfPlayer,
    "idGame": idGame
}
wsSend(JSON.stringify(payLoad));




conn.onmessage = message => {

    //message.data
    const response = JSON.parse(message.data);
    console.log(response)
    /***************** joinging game ************ */
    let nbrOfTotalPlayers = 0;
    let nbrOfJoinedPlayers = 0;

    if (response.method == "join") {
        gameContainer.innerHTML = ''
        response.game.players.forEach(player => {
            nbrOfTotalPlayers++
            if (player.isJoined == true) {
                generateLine(player.username, player.color)
                nbrOfJoinedPlayers++
            }

        });

        if (nbrOfJoinedPlayers == nbrOfTotalPlayers) {
            //tell server to start game if all players joigned
            const payLoad = {
                "method": "play",
                "game": response.game
            }
            wsSend(JSON.stringify(payLoad));
        }
    }

    /***************** play ************ */
    if (response.method == "play") {
        response.game.players.forEach(player => {
            if (player.hisTurn == true) {
                titleInfo.innerText = "Le tour de : " + player.username
                if (player.username == usernameOfPlayer) {
                    playButton.disabled = false
                } else {
                    playButton.disabled = true

                }
            }


        });

        // wsSend(JSON.stringify(payLoad));
    }



}

function updateGameState(data) {

}
//global variables
let gameContainer = document.getElementById('gameContainer')
//getting game id form url else redirect to home page
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
let idGame
if (urlParams.has('idGame')) {
    idGame = urlParams.get('idGame')
} else {
    window.location = '/';
}

/**functions** */
function generateLine(username,color) {
   
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

function displayLevel(){
    let modalBtn = document.querySelector('.buttonPlay')
    let modalBg = document.querySelector('.questionModal')
console.log('marche ?')
    modalBtn.addEventListener('click', function(){
        modalBg.style.visibility = "visible"
        modalBg.style.visibility = 1
    });
}displayLevel()


/* connect to server */
const conn = new WebSocket('ws://localhost:8282');
const username = document.getElementById('username').value

//handle still connecting error to send msg
let wsSend = function (data) {
    if (!conn.readyState) {
        console.log(conn.readyState);
        setTimeout(function () {
            wsSend(data);
        }, 100);
    } else {
        conn.send(data);
        console.log('sent');
    }
}


//join game
const payLoad = {
    "method": "join",
    "username": username,
    "idGame": idGame
}

conn.onopen = function (event) {
    conn.send("Voici un texte que le serveur attend de recevoir dès que possible !");
};
wsSend(JSON.stringify(payLoad));


conn.onmessage = message => {
    //message.data
    const response = JSON.parse(message.data);

    /***************** joinging game ************ */
    if (response.method === "join") {
        console.log(response.game)
        gameContainer.innerHTML = ''
        response.game.players.forEach(player => {
            if (player.isJoined == true) {
                generateLine(player.username,player.color)
            }
           
        });
    }

}

function updateGameState(data) {

}
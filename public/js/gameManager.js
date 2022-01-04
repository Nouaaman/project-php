//getting game id form url else redirect to home page
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
let idGame
if (urlParams.has('idGame')) {
    idGame = urlParams.get('idGame')
} else {
    window.location = '/';
}

/* connect to server */
const conn = new WebSocket('ws://project-php:8282');
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
    if (response.method === "join") {
        console.log(response.msg)
    }

}
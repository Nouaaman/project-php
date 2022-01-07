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
const levelsButtons = document.querySelectorAll('.buttons .level')
const labelValidAnswer = document.getElementById('labelValidAnswer')
const nbrOfCases = 10
let selecteLevel = 0
let playerScore = 0
let isWinner = false
let labelValidAnswerMessage
//handle click event on levels buttons
levelsButtons.forEach(btn => {
    btn.addEventListener('click', (e) => {
        let level = e.target.getAttribute('data-level');
        selecteLevel = level
        getRandomQuestion(level)
    })
})





/***********functions*********/
//generate line for each player
function gameUi(username, color, score) {

    let line = document.createElement("div")
    line.setAttribute('class', 'line');
    line.setAttribute('id', username);
    line.style.backgroundColor = color
    let ul = document.createElement("ul")
    ul.setAttribute('class', 'cases')
    ul.setAttribute('id', 'cases')
    for (let i = nbrOfCases; i >= 1; i--) {
        let li = document.createElement('li')
        if (score == i) {
            li.classList.add('currentPosition')
        }
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

function hideQuestionModal() {
    questionModal.classList.add('hidden')
}

//disable buttons in the screen for a player when it's not his turn
function disableAllButtons() {
    let btns = document.querySelectorAll('button')
    btns.forEach(btn => {
        btn.disabled = true
    })
}

function enableAllButtons() {
    let btns = document.querySelectorAll('button')
    btns.forEach(btn => {
        btn.disabled = false
    })
}

function showQuestionAndAnswers(question) {
    let questionContainer = document.getElementById('questionContainer')
    questionContainer.classList.remove('hidden')
    document.getElementById('questionLabel').innerText = question.question;
    let answersContainer = document.getElementById('questionAnswers')
    question.answers.forEach(ans => {
        let btn = document.createElement("button")
        btn.setAttribute('data-isValid', ans.isValid);
        btn.setAttribute('class', 'button answer');
        btn.innerText = ans.label
        answersContainer.appendChild(btn)
    });

    document.querySelectorAll('#questionAnswers button').forEach(btn => {
        btn.addEventListener('click', (e) => {
            selectedAnswer(e)
        })
    })
}

//change score according to answer and check if winner
function selectedAnswer(e) {
    console.log('selected level :', selecteLevel);
    disableAllButtons()
    if (e.target.getAttribute('data-isValid') == 1) {
        playerScore += parseInt(selecteLevel)
        if (playerScore > nbrOfCases) {
            playerScore = parseInt(nbrOfCases);
            isWinner = true;
        }
        labelValidAnswer.innerText = 'Bonne reponse!'
        labelValidAnswerMessage = 'Bonne reponse!'
        console.log(playerScore)
    } else {
        playerScore -= parseInt(selecteLevel)
        if (playerScore < 0) {
            playerScore = 0;
        }
        labelValidAnswer.innerText = 'Mauvaise reponse.'
        labelValidAnswerMessage = 'Mauvaise reponse.'
        console.log(playerScore)
    }
    syncScreens('answered')
    setTimeout(function () {
        clearQuestion()
        hideQuestionModal()
    }, 2500);


    updateScore()


}

function clearQuestion() {
    document.getElementById('questionLabel').innerText = '';
    document.querySelector('.questionAnswers').innerHTML = '';
    labelValidAnswer.innerText = ''
}



/*********  connect to server ****** */
const conn = new WebSocket('ws://localhost:8282');

//handle still connecting error to send msg
let wsSend = function (data) {
    if (!conn.readyState) {
        console.log('sending...');
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
    "username": usernameOfPlayer,
    "idGame": idGame
}
wsSend(JSON.stringify(payLoad));

//sync screen between players, called when question modal is shown
function syncScreens(phase) {
    const payLoad = {
        "method": "sync",
        "idGame": idGame,
        "phase": phase.toString(),
        "validAnswerMessage": labelValidAnswerMessage
    }
    wsSend(JSON.stringify(payLoad));
}



//get Random Question by level
function getRandomQuestion(level) {
    const payLoad = {
        "method": "getQuestion",
        "idGame": idGame,
        "level": level
    }
    wsSend(JSON.stringify(payLoad));
}



function updateScore() {
    const payLoad = {
        "method": "updateScore",
        "idGame": idGame,
        "score": playerScore,
        "username": usernameOfPlayer
    }
    wsSend(JSON.stringify(payLoad));
}


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
                gameUi(player.username, player.color, player.score)
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
        gameContainer.innerHTML = ''
        response.game.players.forEach(player => {
            gameUi(player.username, player.color, player.score)

            console.log("scores :", player.username, " ", player.score)
            playerScore = parseInt(player.score)
            //enbale play button to show question level then label
            if (player.hisTurn == true) {
                titleInfo.innerText = "Le tour de : " + player.username
                if (player.username == usernameOfPlayer) {
                    enableAllButtons()
                } else {
                    disableAllButtons()
                }

                playButton.addEventListener("click", () => {
                    showQuestionModal()
                    syncScreens('questionLevel')
                });

            }
        });



    }


    /***************** Get Question ************ */
    if (response.method == "getQuestion") {
        showQuestionAndAnswers(response.question)
    }


    /***************** syncscreens ************ */
    if (response.method == "sync") {
        if (response.phase == 'questionLevel') {
            showQuestionModal()
        }
        if (response.phase == 'answered') {
            labelValidAnswer.innerText = response.validAnswerMessage
            setTimeout(function () {
                clearQuestion()
                hideQuestionModal()
            }, 2000);
        }

    }
}
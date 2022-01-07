// generate new field
let inputs = document.querySelectorAll('.field input')
addInputEvent()

let nbrField = 2
let addBtn = document.getElementById("add")
addBtn.addEventListener('click', (e) => {
  if (nbrField < 6) {

    let field = document.createElement('div')
    field.setAttribute('class', 'field')

    field.innerHTML = `
				<div class="autocomplete">
					<input class="username" type="text" name="username" placeholder="Username" autocomplete="off">
					<div class="autocomplete-items">

					</div>
				</div>
				<select class="color" name="color">
					<option value="#E2703A">Jaune</option>
					<option value="#141E61">Bleu</option>
					<option value="#950101">Rouge</option>
					<option value="#1E5128">Vert</option>
					<option value="#3E065F">Violet</option>
					<option value="#461111">Brun</option>

				</select>
  `
    let fields = document.querySelector('.fields')
    fields.appendChild(field)
    nbrField++
    checkTheDropdownsColor();
    addInputEvent()
  }
})




//auto complete

function addInputEvent() {
  inputs = document.querySelectorAll('.field input')
  inputs.forEach(input => {
    input.addEventListener('input', (e) => {
      inputValue = e.target.value
      let divItems = e.target.nextElementSibling
      if (inputValue.length > 0) {
        let usernamesResult = getUsernames(e.target.value).then(user => {
          return user
        })

        showSuggestion(divItems, usernamesResult)
      } else {
        divItems.innerHTML = ''
      }

    });
  })

}

async function getUsernames(searchUser) {
  let url = window.location.origin + "/game/searchplayer"
  const response = await fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: "playerUsername= " + searchUser
  });
  const results = await response.json();
  return results;
}

function showSuggestion(items, usernames) {

  items.innerHTML = ''
  usernames.then(username => {
    username.forEach(usr => {
      let item = document.createElement('div')
      item.setAttribute('class', 'item')

      item.innerText = usr.username

      items.appendChild(item)
      item.addEventListener('click', () => {
        items.previousElementSibling.value = item.innerText
        items.innerHTML = ''
      });

    })


  })
}



/*****************create game******************/

let btnCreate = document.getElementById('create')

/* connect to server */
const conn = new WebSocket('ws://localhost:8282');

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



// send data
btnCreate.addEventListener("click", e => {

  let usernames = document.querySelectorAll('.username')
  let colors = document.querySelectorAll('.color')

  let players = []
  let hisTurn = true
  for (let i = 0; i < usernames.length; i++) {
    if (i > 0) {
      hisTurn = false
    }
    const player = {
      idGame: '',
      username: usernames[i].value,
      color: colors[i].value,
      score: 0,
      isJoined: false,
      hisTurn: hisTurn,
      labelValidAnswerMessage: ''
    }
    players.push(player)
  }

  const payLoad = {
    "method": "create",
    "players": players,
    "currentPLayer": ''
  }

  // conn.send(JSON.stringify(payLoad));
  wsSend(JSON.stringify(payLoad))

})


conn.onmessage = message => {
  //message.data
  const response = JSON.parse(message.data);
  if (response.method === "create") {
    let idGame = response.idGame;
    // alert(window.location.hostname + '/game?idGame=' + idGame);
    console.log(window.location.hostname + '/game?idGame=' + idGame);
    // if (idGame) {
    //   window.location = '/game?idGame=' + idGame;
    // }
  }

}








// let wsSend = function (data) {
//   if (!ws.readyState) {
//     console.log(ws.readyState);
//     setTimeout(function () {
//       wsSend(data);
//     }, 100);
//   } else {
//     ws.send(data);
//     console.log('sent');
//   }
// };
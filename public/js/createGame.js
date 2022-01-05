//auto complete
let inputs = document.querySelectorAll('.field input')
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
const conn = new WebSocket('ws://project-php:8282');

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
  for (let i = 0; i < usernames.length; i++) {
    const player = {
      idConn: null,
      idGame: '',
      username: usernames[i].value,
      color: colors[i].value,
      position: 0,
      
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
    alert('URL de la partie : ' + window.location.hostname + '/game?idGame=' + idGame);
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
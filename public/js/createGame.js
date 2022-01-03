let nbrField = 2
let addBtn = document.getElementById("add")
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

addBtn.addEventListener('click', (e) => {
  if (nbrField < 6) {

    let field = document.createElement('div')
    field.setAttribute('class', 'field')
    
    field.innerHTML = `
				<div class="autocomplete">
					<input type="text" name="username" placeholder="Username" autocomplete="off">
					<div class="autocomplete-items">

					</div>
				</div>
				<select name="color${nbrField}" id="color${nbrField}">
					<option value="yellow">Jaune</option>
					<option value="blue">Bleu</option>
					<option value="red">Rouge</option>
					<option value="green">Vert</option>
					<option value="purple">Violet</option>
					<option value="brown">Brun</option>

				</select>
  `
    let fields = document.querySelector('.fields')
    fields.appendChild(field)
    nbrField++
  }
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
let inputs = document.querySelectorAll('.field input')
inputs.forEach(input => {
    input.addEventListener('input', (e) => {
        inputValue = e.target.value
        if (inputValue.length > 0) {
            autocomplete(e.target)
        }
    });
})

function autocomplete(input) {

    let parentElement = input.sib

    let items = document.createElement('div')
    items.setAttribute('class', 'autocomplete-items')

    let item = document.createElement('p')
    item.setAttribute('class', 'item')
    item.innerText = 'teeeest'

    items.appendChild(item)
    console.log(items)
    console.log(parentElement);
    parentElement.appendChild(items)
    console.log(parentElement);

}
//generate field

document.getElementById("addAnswer").addEventListener("click", function () {

    let fields = document.getElementById('field')
    let newInput = document.createElement('input')
    newInput.setAttribute('type', 'number')
    newInput.setAttribute('class', 'field')

    let field = document.createElement('div')
    field.classList.add('field')

    field.appendChild(label)
    field.appendChild(newInput)
    fields.appendChild(field)
    numElement++
})


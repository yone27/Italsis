import { Pagination } from './modules/Pagination.js';
import Modal from './modules/Modal.js';

document.addEventListener('DOMContentLoaded', function () {
    const tbody = document.querySelector('#tableEntitySubClass tbody')
    const updateForm = document.getElementById('edit-entitySubClass-form')
    const updateUserBtn = document.querySelector('#edit-entitySubClass-form #btn-edit-data')
    const formEntitySubClass = document.getElementById('entitySubClass')
    const entityclassInput = document.getElementById('entityclassInput')
    const entityclassSelect = document.getElementById('entityclassSelect')
    const entityclassInput1 = document.getElementById('entityclassInput1')
    const entityclassSelect1 = document.getElementById('entityclassSelect1')
    const pagination = new Pagination('#tableEntitySubClass', true)
    const modal = new Modal()
    const showAlert = document.getElementById('showAlert')
    const URI = 'actionEntitySubClass.php'

    // Search all data
    const fetchAllData = async () => {
        const data = await fetch(`${URI}?fetchAll=1`, {
            method: 'GET'
        })
        const res = await data.json()
        pagination.showPagination(res)
        // showPagination(res)
        modal.initModal()
    }

    // Add new record
    formEntitySubClass.addEventListener('submit', async e => {
        e.preventDefault()
        // Validar que todos los campos esten llenos

        const formData = new FormData(formEntitySubClass)
        formData.append('add', 1)

        const data = await fetch(URI, {
            method: 'POST',
            body: formData
        })

        const res = await data.text()
        showAlert.innerHTML = res
        fetchAllData()
        // Cerrando el modal
        document.querySelector(`#${formEntitySubClass.getAttribute('id')} [class="close-modal"]`).click()
    })

    // Filter input entityclass
    async function filterCompanyInput(src, dest, selected) {
        const srcValue = src.value
        // limpiando errores
        let errors = document.querySelector('.error-message')
        if (errors) {
            errors.remove()
        }

        if (srcValue.length > 3) {
            const data = await fetch(`${URI}?fetchEntityClass=${srcValue}`, {
                method: 'GET'
            })
            const res = await data.json()
            let output = ""
            if (selected) {
                let customObj

                // selecciona por defecto la compañia
                if (!res.error) {
                    customObj = res.map(element => (element.name.toUpperCase() == srcValue.toUpperCase() ? { name: element.name, id: element.id, selected: true } : element))

                    customObj.forEach(element => {
                        if (element.selected) {
                            output += `<option selected value="${element.id}">${element.name} </option>`
                        } else {
                            output += `<option value="${element.id}">${element.name} </option>`
                        }
                    })

                    dest.classList.remove('hide')
                    dest.innerHTML = output
                } else {
                    const nodeError = document.createElement("p");
                    const textnode = document.createTextNode(`* ${res.error}`);
                    nodeError.classList.add('error-message')
                    nodeError.appendChild(textnode)

                    dest.closest('.filter-company-container').appendChild(nodeError)
                    dest.classList.add('hide')

                }
            } else {
                if (!res.error) {
                    res.forEach(element => {
                        if (element.selected) {
                            output += `<option selected value="${element.id}">${element.name} </option>`
                        } else {
                            output += `<option value="${element.id}">${element.name} </option>`
                        }
                    })
                    dest.classList.remove('hide')
                    dest.innerHTML = output
                } else {
                    const nodeError = document.createElement("p");
                    const textnode = document.createTextNode(`* ${res.error}`);
                    nodeError.classList.add('error-message')
                    nodeError.appendChild(textnode)

                    dest.closest('.filter-company-container').appendChild(nodeError)
                    dest.classList.add('hide')
                }
            }

        } else {
            dest.classList.add('hide')
            dest.innerHTML = ""
        }

        // si da click en el select ponloo en el input
        dest.addEventListener('change', e => {
            const selectedOption = dest.options[dest.selectedIndex]
            src.value = selectedOption.textContent
        })
    }
    
    entityclassInput.addEventListener('input', async e => {
        e.preventDefault()
        // Buscar compañia
        filterCompanyInput(entityclassInput, entityclassSelect)
    })

    // delete data fetch request
    tbody.addEventListener('click', async e => {
        if (e.target && e.target.matches('button.deleteLink')) {
            e.preventDefault()
            // Comprobamos que realmente quiere eliminar el registro
            //probando la función, creando una alerta
            if (confirm("¿Seguro que quieres borrar?")) {
                // Eliminamos el registro
                let id = e.target.id
                const data = await fetch(`${URI}?delete=1&id=${id}`, {
                    method: 'GET'
                })
                const res = await data.text()
                // Mostramos alerta y nuevo fetch
                showAlert.innerHTML = res
                fetchAllData()
            }
        }
    })

    // edit data fetch
    tbody.addEventListener('click', e => {
        if (e.target && e.target.matches('button.editLink')) {
            e.preventDefault()
            let id = e.target.id
            editData(id)
        }
    })

    entityclassInput1.addEventListener('input', async e => {
        e.preventDefault()
        // Buscar compañia
        filterCompanyInput(entityclassInput1, entityclassSelect1)
    })

    const editData = async id => {
        const data = await fetch(`${URI}?edit=1&id=${id}`, {
            method: 'GET'
        })
        const res = await data.json()
        console.log(res);
        document.querySelector(`#${updateForm.getAttribute('id')} [name="id"]`).value = res[0].id
        document.querySelector(`#${updateForm.getAttribute('id')} [name="code"]`).value = res[0].code
        document.querySelector(`#${updateForm.getAttribute('id')} [name="name"]`).value = res[0].name
        document.querySelector(`#${updateForm.getAttribute('id')} [name="observation"]`).value = res[0].observation
        document.querySelector(`#${updateForm.getAttribute('id')} [name="entityclassInput1"]`).value = res[0].entityclass

        // para que aparezca seleccionado por defecto el buscador
        filterCompanyInput(entityclassInput1, entityclassSelect1, true)
    }

    // update data fetch request
    updateForm.addEventListener('submit', async e => {
        e.preventDefault()
        const formData = new FormData(updateForm)

        formData.append('update', 1)
        updateUserBtn.value = 'please wait...'
        const data = await fetch(`${URI}`, {
            method: 'POST',
            body: formData
        })
        const res = await data.text()

        // reset form, hide modal,
        showAlert.innerHTML = res
        updateUserBtn.value = 'Editar'
        fetchAllData()
        // Cerrando el modal
        document.querySelector(`#${updateForm.getAttribute('id')} [class="close-modal"]`).click()
        modal.initModal()
    })

    // Initializes
    modal.initModal()
    fetchAllData()
})


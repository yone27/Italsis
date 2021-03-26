import { Pagination } from './modules/Pagination.js';
import InputFilter from './modules/InputFilter.js';
import Modal from './modules/Modal.js';

document.addEventListener('DOMContentLoaded', function () {
    const tbody = document.querySelector('#tableEntitySubClass tbody')
    const updateForm = document.getElementById('edit-entitySubClass-form')
    const updateUserBtn = document.querySelector('#edit-entitySubClass-form #btn-edit-data')
    const formEntitySubClass = document.getElementById('entitySubClass')
    const showAlert = document.getElementById('showAlert')

    const URI = 'actionEntitySubClass.php'

    // Inputs filter
    new InputFilter('entityclassInput', 'entityclassSelect', `${URI}?fetchEntityClass`)
    const filter2 = new InputFilter('entityclassInputEdit', 'entityclassSelectEdit', `${URI}?fetchEntityClass`, true)
    const pagination = new Pagination('#tableEntitySubClass', true)
    const modal = new Modal()

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

    const editData = async id => {
        const data = await fetch(`${URI}?edit=1&id=${id}`, {
            method: 'GET'
        })
        const res = await data.json()
        document.querySelector(`#${updateForm.getAttribute('id')} [name="id"]`).value = res[0].id
        document.querySelector(`#${updateForm.getAttribute('id')} [name="code"]`).value = res[0].code
        document.querySelector(`#${updateForm.getAttribute('id')} [name="name"]`).value = res[0].name
        document.querySelector(`#${updateForm.getAttribute('id')} [name="observation"]`).value = res[0].observation
        document.querySelector(`#${updateForm.getAttribute('id')} [name="entityclassInput"]`).value = res[0].entityclass

        // para que aparezca seleccionado por defecto el buscador
        filter2.filterby(undefined, undefined, true)
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


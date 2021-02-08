import { Pagination } from './modules/Pagination.js';
import Modal from './modules/Modal.js';

document.addEventListener('DOMContentLoaded', function () {
    const formEntityClass = document.getElementById('entityClass')
    const showAlert = document.getElementById('showAlert')
    const tbody = document.querySelector('#tableEntityClass tbody')
    const updateForm = document.getElementById('edit-entityClass-form')
    const updateUserBtn = document.getElementById('btn-edit-data')
    const pagination = new Pagination('#tableEntityClass', true)
    const modal = new Modal()
    const URI = 'actionEntityClass.php'

    // Search all data
    const fetchAllData = async () => {
        const data = await fetch(`${URI}?fetchAll=1`, {
            method: 'GET'
        })

        const res = await data.json()
        pagination.showPagination(res)
        modal.initModal()
    }

    // Add new record
    formEntityClass.addEventListener('submit', async e => {
        e.preventDefault()

        // Validar que todos los campos esten llenos
        const formData = new FormData(formEntityClass)
        if (document.querySelector(`#${formEntityClass.getAttribute('id')} [name="generator"]`).checked) {
            formData.append('generator', 'Y')
        } else {
            formData.append('generator', 'N')
        }
        formData.append('add', 1)

        const data = await fetch(URI, {
            method: 'POST',
            body: formData
        })

        const res = await data.text()
        showAlert.innerHTML = res
        fetchAllData()
        // Cerrando el modal
        document.querySelector(`#${formEntityClass.getAttribute('id')} [class="close-modal"]`).click()
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

        if (res[0].generator === 'Y') {
            document.querySelector(`#${updateForm.getAttribute('id')} [name="generator"]`).setAttribute('checked', 'true')
        } else {
            document.querySelector(`#${updateForm.getAttribute('id')} [name="generator"]`).removeAttribute('checked')
        }

    }

    // update data fetch request
    updateForm.addEventListener('submit', async e => {
        e.preventDefault()
        const formData = new FormData(updateForm)

        if (document.querySelector(`#${updateForm.getAttribute('id')} [name="generator"]`).checked) {
            formData.append('generator', 'Y')
        } else {
            formData.append('generator', 'N')
        }

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

    // Inicializamos todos
    modal.initModal()
    fetchAllData()
})


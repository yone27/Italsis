import { initPagination, showPagination } from './modules/Pagination.js';
import initModal from './modules/Modal.js';

document.addEventListener('DOMContentLoaded', function () {
    const formEntityClass = document.getElementById('entityClass')
    const showAlert = document.getElementById('showAlert')
    const tbody = document.querySelector('#tableEntityClass tbody')
    const updateForm = document.getElementById('edit-entityClass-form')
    const updateUserBtn = document.getElementById('btn-edit-data')
    const URI = 'actionEntityClass.php'

    initPagination('#tableEntityClass')

    // Search all data
    const fetchAllData = async () => {
        const data = await fetch(`${URI}?fetchAll=1`, {
            method: 'GET'
        })

        const res = await data.json()
        showPagination(res)
        initModal()
    }
    fetchAllData()

    // Add new record
    formEntityClass.addEventListener('submit', async e => {
        e.preventDefault()

        // Validar que todos los campos esten llenos
        const formData = new FormData(formEntityClass)
        if (document.getElementById('generator').checked) {
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
        document.getElementById('modal2').click()
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

        document.getElementById('idEdit').value = res[0].id
        document.getElementById('editCode').value = res[0].code
        document.getElementById('editName').value = res[0].name
        document.getElementById('editObservation').value = res[0].observation
        
        if(res[0].generator === 'Y') {
            document.getElementById('editGenerator').setAttribute('checked', 'true')
        }else{
            document.getElementById('editGenerator').removeAttribute('checked')
        }
    }

    // update data fetch request
    updateForm.addEventListener('submit', async e => {
        e.preventDefault()
        const formData = new FormData(updateForm)
        if (document.getElementById('editGenerator').checked) {
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
        document.getElementById('modal3').click()
    })


    // Inicializamos todos los modales
    initModal()
})


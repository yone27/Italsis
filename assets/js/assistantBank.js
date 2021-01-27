import { Pagination } from './modules/Pagination.js';
import Modal from './modules/Modal.js';

document.addEventListener('DOMContentLoaded', function () {
    const selectDept = document.getElementById('identitysubclass')
    const idpartylocation1 = document.getElementById('idpartylocation1')
    const infocompany1 = document.getElementById('infocompany1')
    const idpartylocation2 = document.getElementById('idpartylocation2')
    const infocompany2 = document.getElementById('infocompany2')
    const formAssistantbankPL = document.getElementById('assistantbankPL')
    const filterByCompany = document.getElementById('idpartylocation')
    const tbody = document.querySelector('#tableAssistantBank tbody')
    const updateForm = document.getElementById('edit-assistantBank-form')
    const updateUserBtn = document.getElementById('btn-edit-data')
    const showAlert = document.getElementById('showAlert')
    const pagination = new Pagination('#tableAssistantBank')
    const modal = new Modal()
    const URI = 'actionAssistantBank.php'

    // Search all data
    const fetchAllData = async () => {
        const data = await fetch(`${URI}?fetchAll=1`, {
            method: 'GET'
        })
        const res = await data.json()
        pagination.showPagination(res)
        modal.initModal()
    }
    fetchAllData()

    // Search data by departaments
    selectDept.addEventListener('change', async (e) => {
        e.preventDefault()
        const selectedOption = selectDept.options[selectDept.selectedIndex]
        if (selectedOption.value) {
            const data = await fetch(`${URI}?fetchDept=${selectedOption.value}`, {
                method: 'GET'
            })
            const res = await data.json()
            pagination.showPagination(res)
        } else {
            fetchAllData()
        }
    })

    // Search data by company
    filterByCompany.addEventListener('input', async function (e) {
        e.preventDefault()
        const nameCompany = this.value
        if (nameCompany.length > 1) {
            const data = await fetch(`${URI}?fetchNameCompany=${nameCompany}`, {
                method: 'GET'
            })

            const res = await data.json()
            pagination.showPagination(res)
        } else {
            fetchAllData()
        }
    })

    // Add new record
    formAssistantbankPL.addEventListener('submit', async e => {
        e.preventDefault()
        // Validar que todos los campos esten llenos
        const formData = new FormData(formAssistantbankPL)
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

    async function filterCompanyInput(src, dest, selected) {
        const srcValue = src.value
        // limpiando errores
        let errors = document.querySelector('.error-message')
        if (errors) {
            errors.remove()
        }

        if (srcValue.length > 3) {
            const data = await fetch(`${URI}?fetchCompany=${srcValue}`, {
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

    idpartylocation1.addEventListener('input', async e => {
        e.preventDefault()
        // Buscar compañia
        filterCompanyInput(idpartylocation1, infocompany1)
    })

    idpartylocation2.addEventListener('input', async e => {
        e.preventDefault()
        // Buscar compañia
        filterCompanyInput(idpartylocation2, infocompany2, true)
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
        document.getElementById('idpartylocation2').value = res[0].companyname

        // para que aparezca seleccionado por defecto el buscador
        filterCompanyInput(idpartylocation2, infocompany2, true)

        const miarr = document.getElementById('editidentitysubclass').options
        for (const key in miarr) {
            if (Object.hasOwnProperty.call(miarr, key)) {
                const element = miarr[key]
                if (element.value == res[0].dept) {
                    element.setAttribute('selected', true)
                }
            }
        }
    }

    // update data fetch request
    updateForm.addEventListener('submit', async e => {
        e.preventDefault()
        const formData = new FormData(updateForm)
        updateUserBtn.value = 'please wait...'
        formData.append('update', 1)
        const data = await fetch(`${URI}`, {
            method: 'POST',
            body: formData
        })
        const res = await data.text()
        // reset form, hide modal,
        showAlert.innerHTML = res
        updateUserBtn.value = 'Editar'
        //updateForm.classList.remove('was-validated')
        fetchAllData()
        document.getElementById('modal3').click()
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

    // Inicializamos todos los modales
    modal.initModal()
})
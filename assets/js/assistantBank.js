import { Pagination } from './modules/Pagination.js';
import Modal from './modules/Modal.js';
import InputFilter from './modules/InputFilter.js';

document.addEventListener('DOMContentLoaded', function () {
    const selectDept = document.getElementById('identitysubclass')
    const formAssistantbankPL = document.getElementById('assistantbankPL')
    const formPartyBankInfo = document.getElementById('formPartyBankInfo')
    const updateForm = document.getElementById('edit-assistantBank-form')
    const filterByCompany = document.getElementById('idpartylocation')
    const tbody = document.querySelector('#tableAssistantBank tbody')
    const updateUserBtn = document.getElementById('btn-edit-data')
    const showAlert = document.getElementById('showAlert')

    const URI = 'actionAssistantBank.php'
    const pagination = new Pagination('#tableAssistantBank')
    const filter1 = new InputFilter('idpartylocation1', 'infocompany1')
    const filter2 = new InputFilter('idpartylocation2', 'infocompany2', undefined, true)

    const test = document.getElementById('infocompany1')

    const select3 = document.getElementById('select3')

    const infocompany1 = document.getElementById('infocompany1')

    document.getElementById('idpartylocation1').value = 'PEDRO JOSE NUÑEZ  ZABALA '
    // const filter3 = new InputFilter('idpartylocation1', 'select3', 'actionAssistantBank.php?test')
    const modal = new Modal()

    // asignar idparty para cuando quiera agregar una nueva cuenta
    test.addEventListener('change', async (e) => {
        e.preventDefault()
        const selectedOption = test.options[test.selectedIndex]
        if (selectedOption.value) {
            document.querySelector(`#${formPartyBankInfo.getAttribute('id')} [name="idparty"]`).value = selectedOption.value
        }
    })

    infocompany1.addEventListener('change', async (e) => {
        e.preventDefault()
        const selectedOption = infocompany1.options[infocompany1.selectedIndex]
        const data = await fetch(`${URI}?accountByIdparty=${selectedOption.value}`, {
            method: 'GET'
        })
        const res = await data.json()

        if (!res.error) {
            let output = ""
            res.forEach(element => {
                output += `<option data-bankName="${element.bankname}" data-bankaccount="${element.bankaccount}" value="${element.id}">${element.bankname} - ${element.bankaccount}</option>`
            })
            select3.innerHTML = output

            // actializar valores de campos ocultos
            select3.addEventListener('change', (e) => {
                e.preventDefault()
                const miselect = select3.options[select3.selectedIndex]
                if (miselect) {
                    document.querySelector(`#${formAssistantbankPL.getAttribute('id')} [name="scode"]`).value = select3.options[select3.selectedIndex].dataset.bankaccount
                    document.querySelector(`#${formAssistantbankPL.getAttribute('id')} [name="sname"]`).value = select3.options[select3.selectedIndex].dataset.bankname
                }
            })
        } else {
            select3.innerHTML = `<option value="-1000" aria-label="open modal" data-open="partyBankInfoModal">${res.error}</option>`
        }
        modal.initModal()
    })

    // Add new record formPartyBankInfo
    formPartyBankInfo.addEventListener('submit', async e => {
        e.preventDefault()
        // Validar que todos los campos esten llenos
        const formData = new FormData(formPartyBankInfo)
        formData.append('addAccount', 1)
        const data = await fetch(URI, {
            method: 'POST',
            body: formData
        })
        const res = await data.text()
        showAlert.innerHTML = res
        document.getElementById('modal4').click()
    })

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

        // Limpiando campos de formularios
        // formAssistantbankPL.reset()
        filter1.reset()
        while (select3.firstChild) {
            select3.removeChild(select3.firstChild);
        };

        fetchAllData()
        document.getElementById('modal2').click()
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
        filter2.filterby(undefined, undefined, true)

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
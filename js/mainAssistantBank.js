document.addEventListener('DOMContentLoaded', function () {
    const selectDept = document.getElementById('identitysubclass')
    const idpartylocation1 = document.getElementById('idpartylocation1')
    const infocompany1 = document.getElementById('infocompany1')
    const idpartylocation2 = document.getElementById('idpartylocation2')
    const infocompany2 = document.getElementById('infocompany2')
    const formAssistantbankPL = document.getElementById('assistantbankPL')
    const filterByCompany = document.getElementById('idpartylocation')
    const tbody = document.querySelector('#table-assistantBank tbody')
    const updateForm = document.getElementById('edit-assistantBank-form')
    const updateUserBtn = document.getElementById('btn-edit-data')
    const showAlert = document.getElementById('showAlert')
    const URI = 'actionAB.php'

    // Pagination
    let pageSize = 5
    let pageNumber = 1
    let globalData = []
    let noticias = []
    let noticiasHtml = ''

    function paginate(array, page_size, page_number) {
        return array.slice((page_number - 1) * page_size, page_number * page_size)
    }

    function nextPage() {
        pageNumber++
        showNoticias(noticias)
    }
    function previusPage() {
        pageNumber--
        showNoticias(noticias)
    }

    function showNoticias(_noticias) {
        if (_noticias.length >= 0) {
            let pagination = paginate(noticias, pageSize, pageNumber)
            noticiasHtml = ''
            pagination.forEach(element => {
                noticiasHtml += '<tr>'
                noticiasHtml += '<td>' + element.id + '</td>'
                noticiasHtml += '<td>' + element.code + '</td>'
                noticiasHtml += '<td>' + element.name + '</td>'
                noticiasHtml += '<td>' + element.dateregister + '</td>'
                noticiasHtml += '<td>' + element.companyname + '</td>'
                noticiasHtml += '<td>' + element.dept + '</td>'
                noticiasHtml += `<td><button id="${element.id}" class="btn btn-info btn-sm rounded-pill editLink" aria-label="open modal" type="button" data-open="assistantBankModalEdit">Edit</button> <button type="button" id="${element.id}" class="btn btn-danger btn-sm rounded-pill deleteLink">Delete<button></td>`
                noticiasHtml += '</tr>'
            })

            // Pagination footer construction
            const tableButtons = document.querySelector('#table-pagination-footer .buttons-pagination')
            const tableInfo = document.querySelector('#table-pagination-footer .info')
            let paginationButtons = ''
            let paginationInfo = ''
            let pageCont = Math.ceil(noticias.length / pageSize)
            // Posicion inicial de los registros con respecto a globalData
            let dataInitialPosition = globalData.findIndex((value) => value.id == pagination[0].id) + 1

            // Posicion Final de los registro con respecto a globalData
            let dataFinalPosition = globalData.findIndex((value) => value.id == pagination[pagination.length - 1].id) + 1

            paginationInfo = `Mostrando del ${dataInitialPosition} al ${dataFinalPosition} de ${globalData.length} registros`
            paginationButtons += pageNumber > 1 ? " <button type='button' class='btn btn-pagination' id='prevPage'>Anterior</button>" : ""
            paginationButtons += pageNumber < pageCont ? ("<button type='button' class='btn btn-pagination' id='nextPage'>Siguiente</button>") : ""
            tableButtons.innerHTML = paginationButtons
            tableInfo.innerHTML = paginationInfo

            let nextPageBtn = document.getElementById('nextPage')
            let prevPageBtn = document.getElementById('prevPage')

            if (nextPageBtn) {
                nextPageBtn.addEventListener('click', nextPage)
            }
            if (prevPageBtn) {
                prevPageBtn.addEventListener('click', previusPage)
            }

            tbody.innerHTML = ""
            tbody.innerHTML = noticiasHtml
        } else {
            tbody.innerHTML = _noticias.nodata
        }

    }

    // Search all data
    const fetchAllData = async () => {
        const data = await fetch(`${URI}?fetchAll=1`, {
            method: 'GET'
        })
        const res = await data.json()
        noticias = res
        globalData = res
        showNoticias(noticias)
        modal()
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
            noticias = res
            globalData = res
            showNoticias(noticias)
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
            noticias = res
            globalData = res
            showNoticias(noticias)
        } else {
            fetchAllData()
        }
    })

    // Add new record
    formAssistantbankPL.addEventListener('submit', async e => {
        e.preventDefault()
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

        if (srcValue.length > 3) {
            const data = await fetch(`${URI}?fetchCompany=${srcValue}`, {
                method: 'GET'
            })
            const res = await data.json()
            let customObj
            if (selected) {
                // selecciona por defecto la compañia
                customObj = res.map(element => (element.name.toUpperCase() == srcValue.toUpperCase() ? { name: element.name, id: element.id, selected: true } : element))
            }
            
            let output = ""
            customObj.forEach(element => {
                if (element.selected) {
                    output += '<option selected value=' + element.id + '>' + element.name + '</option>'
                } else {
                    output += '<option value=' + element.id + '>' + element.name + '</option>'
                }
            })

            dest.classList.remove('hide')
            dest.innerHTML = output
        } else {
            dest.classList.add('hide')
            dest.innerHTML = ""
        }
    }

    idpartylocation1.addEventListener('input', async e => {
        e.preventDefault()
        // Buscar compañia
        filterCompanyInput(idpartylocation1, infocompany1)
    })

    infocompany1.addEventListener('change', e => {
        const selectedOption = infocompany1.options[infocompany1.selectedIndex]
        idpartylocation1.value = selectedOption.textContent
    })

    idpartylocation2.addEventListener('input', async e => {
        e.preventDefault()
        // Buscar compañia
        filterCompanyInput(idpartylocation2, infocompany2, true)
    })

    infocompany2.addEventListener('change', e => {
        const selectedOption = infocompany2.options[infocompany2.selectedIndex]
        idpartylocation2.value = selectedOption.textContent
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
    tbody.addEventListener('click', e => {
        if (e.target && e.target.matches('button.deleteLink')) {
            e.preventDefault()
            let id = e.target.id
            deleteData(id)
            fetchAllData()
        }
    })

    const deleteData = async (id) => {
        const data = await fetch(`${URI}?delete=1&id=${id}`, {
            method: 'GET'
        })
        const res = await data.text()
        showAlert.innerHTML = res
    }

    modal()
    function modal() {
        // Codigo del Modal
        const openEls = document.querySelectorAll("[data-open]")
        const closeEls = document.querySelectorAll("[data-close]")
        const isVisible = "is-visible"
        // abrir modales
        for (const el of openEls) {
            el.addEventListener("click", function () {
                const modalId = this.dataset.open
                document.getElementById(modalId).classList.add(isVisible)
            })
        }
        // cerrando modal en el boton
        for (const el of closeEls) {
            el.addEventListener("click", function (e) {
                e.preventDefault()
                this.parentElement.parentElement.parentElement.parentElement.parentElement.classList.remove(isVisible)
            })
            // cerrando modal por fuera
            document.addEventListener("click", e => {
                if (e.target == document.querySelector(".modal.is-visible")) {
                    document.querySelector(".modal.is-visible").classList.remove(isVisible)
                }
                //presionando escape
                document.addEventListener("keyup", e => {
                    if (e.key == "Escape" && document.querySelector(".modal.is-visible")) {
                        document.querySelector(".modal.is-visible").classList.remove(isVisible)
                    }
                })
            })
        }
    }
})


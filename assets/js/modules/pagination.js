import initModal from './Modal.js';

// Pagination
const tableHeaderPag = document.querySelector('#table-pagination-header')
let tableName 
let tbody = ''
let pageSize = 5
let pageNumber = 1
let globalData = []
let records = []
let recordHtml = ''

function paginate(array, page_size, page_number) {
    return array.slice((page_number - 1) * page_size, page_number * page_size)
}

function nextPage() {
    pageNumber++
    showPagination(records)
    initModal()
}

function previusPage() {
    pageNumber--
    showPagination(records)
    initModal()
}

function incrementPageSize() {
    tableHeaderPag.innerHTML = `<div class="pageSize-container">
        <label for="pageSize">Mostrar</label>
        <select id="pageSize">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>`

    const elPageSize = document.getElementById('pageSize')
    elPageSize.addEventListener('change', function () {
        pageSize = elPageSize.value
        showPagination(records)
    })
}

function showPagination(_records) {
    // Inicializando variables
    records = _records
    globalData = _records

    if (_records.length >= 0) {
        let pagination = paginate(records, pageSize, pageNumber)
        recordHtml = ''

        let newPagination = pagination.map(element => {
            return {
                ...element,
                actions: `<button id="${element.id}" class="btn btn-info btn-sm rounded-pill editLink" aria-label="open modal" type="button" data-open="${tableName}EditModal">Edit</button> <button type="button" id="${element.id}" class="btn btn-danger btn-sm rounded-pill deleteLink">Delete<button>`
            }
        })
        
        newPagination.forEach((value) => {
            recordHtml += '<tr>'
            for (const key in value) {
                if (Object.hasOwnProperty.call(value, key)) {
                    const element = value[key];
                    recordHtml += `<td>${element}</td>`
                }
            }
            recordHtml += '</tr>'
        })

        // Pagination footer construction
        const tableButtons = document.querySelector('#table-pagination-footer .buttons-pagination')
        const tableInfo = document.querySelector('#table-pagination-footer .info')
        let paginationButtons = ''
        let paginationInfo = ''
        let pageCont = Math.ceil(records.length / pageSize)

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
        tbody.innerHTML = recordHtml
    } else {
        tbody.innerHTML = _records.nodata
    }
}

function initPagination(table, showPageSize) {
    tbody = document.querySelector(`${table} tbody`)
    tableName = document.querySelector(`${table}`).id

    if (showPageSize) {
        incrementPageSize()
    }
}
export {
    initPagination,
    showPagination
}
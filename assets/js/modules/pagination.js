// Pagination
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
}
function previusPage() {
    pageNumber--
    showPagination(records)
}
function showPagination(_records) {
    if (_records.length >= 0) {
        let pagination = paginate(records, pageSize, pageNumber)
        recordHtml = ''
        pagination.forEach(element => {
            recordHtml += '<tr>'
            recordHtml += '<td>' + element.id + '</td>'
            recordHtml += '<td>' + element.code + '</td>'
            recordHtml += '<td>' + element.name + '</td>'
            recordHtml += '<td>' + element.dateregister + '</td>'
            recordHtml += '<td>' + element.companyname + '</td>'
            recordHtml += '<td>' + element.dept + '</td>'
            recordHtml += `<td><button id="${element.id}" class="btn btn-info btn-sm rounded-pill editLink" aria-label="open modal" type="button" data-open="assistantBankModalEdit">Edit</button> <button type="button" id="${element.id}" class="btn btn-danger btn-sm rounded-pill deleteLink">Delete<button></td>`
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
function initPagination(res, table) {
    records = res
    globalData = res
    tbody = document.querySelector(`${table} tbody`)

    showPagination(records)
}
export {
    initPagination
}
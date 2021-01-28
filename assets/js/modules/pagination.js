import Modal from './Modal.js'

export class Pagination extends Modal {
    constructor(table, showPageSize) {
        super(Modal)
        this.tbody = document.querySelector(`${table} tbody`)
        this.tableName = document.querySelector(`${table}`).id

        if (showPageSize) {
            this.incrementPageSize()
        }

        // Por default
        this.tableHeaderPag = document.querySelector('#table-pagination-header')
        this.pageSize = 5
        this.pageNumber = 1
        this.globalData = []
        this.records = []
        this.recordHtml = ''
        this.buildHeader()
    }
    buildHeader = () => {
        let el = document.createElement('div')
        el.classList.add('table-pagination-header')
        let templateHTML = `
        <div class="pageSize-container">
            <label for="pageSize">Mostrar</label>
            <select name="pageSize">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="filter">
            <input class="form-control input-filter" name="filter" type="text" placeholder="Buscar...">
        </div>
        `
        // Agregando contenido al elemento y agregando al dom
        el.innerHTML = templateHTML
        console.log(this.tbody.closest('.table-custom'));
        this.tbody.closest('.table-custom').prepend(el)

        // Funcionalidad de pagesize    
        // console.log(this.tbody);
        const elPageSize = this.tbody.parentElement.previousElementSibling.children[0].children[1]
        elPageSize.addEventListener('change', () => {
            this.pageSize = elPageSize.value
            this.showPagination(this.records)
        })
    }

    paginate(array, page_size, page_number) {
        return array.slice((page_number - 1) * page_size, page_number * page_size)
    }

    nextPage = () => {
        this.pageNumber++
        this.showPagination(this.records)
        this.initModal()
    }

    previusPage = () => {
        this.pageNumber--
        this.showPagination(this.records)
        this.initModal()
    }

    showPagination(_records) {

        // Inicializando variables
        this.records = _records
        this.globalData = _records

        if (_records.length >= 0) {
            let pagination = this.paginate(this.records, this.pageSize, this.pageNumber)
            let recordHtml = ''
            let newPagination = pagination.map(element => {
                return {
                    ...element,
                    actions: `<button id="${element.id}" class="btn btn-info btn-sm rounded-pill editLink" aria-label="open modal" type="button" data-open="${this.tableName}EditModal"><i class="fas fa-edit"></i></button> <button type="button" id="${element.id}" class="btn btn-danger btn-sm rounded-pill deleteLink"><i class="fas fa-trash"></i><button>`
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
            const tableButtons = document.querySelector(`#${this.tableName} + .table-pagination-footer .buttons-pagination`)
            const tableInfo = document.querySelector(`#${this.tableName} + .table-pagination-footer .info`)
            let paginationButtons = ''
            let paginationInfo = ''
            let pageCont = Math.ceil(this.records.length / this.pageSize)

            // Posicion inicial de los registros con respecto a globalData
            let dataInitialPosition = this.globalData.findIndex((value) => value.id == pagination[0].id) + 1

            // Posicion Final de los registro con respecto a globalData
            let dataFinalPosition = this.globalData.findIndex((value) => value.id == pagination[pagination.length - 1].id) + 1
            paginationInfo = `Mostrando del ${dataInitialPosition} al ${dataFinalPosition} de ${this.globalData.length} registros`
            paginationButtons += this.pageNumber > 1 ? " <button type='button' class='btn btn-pagination prevPage'>Anterior</button>" : ""
            paginationButtons += this.pageNumber < pageCont ? ("<button type='button' class='btn btn-pagination nextPage'>Siguiente</button>") : ""
            tableButtons.innerHTML = paginationButtons
            tableInfo.innerHTML = paginationInfo

            let nextPageBtn = document.querySelector(`#${this.tableName} + .table-pagination-footer .nextPage`)
            let prevPageBtn = document.querySelector(`#${this.tableName} + .table-pagination-footer .prevPage`)
            if (nextPageBtn) {
                nextPageBtn.addEventListener('click', this.nextPage)
            }
            if (prevPageBtn) {
                prevPageBtn.addEventListener('click', this.previusPage)
            }

            this.tbody.innerHTML = ""
            this.tbody.innerHTML = recordHtml
        } else {
            this.tbody.innerHTML = _records.nodata
        }
    }
}

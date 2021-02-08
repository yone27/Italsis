import Modal from './Modal.js'

export class Pagination extends Modal {
    constructor(table, showPageSize, showFilter) {
        super(Modal)
        this.tbody = document.querySelector(`${table} tbody`)
        this.tableName = document.querySelector(`${table}`).id

        this.buildHeader()

        // Page size
        if (showPageSize) {
            this.showPageSize()
        }

        // Filter
        if (showFilter) {
            this.showFilter()
        }

        // Por default
        this.tableHeaderPag = document.querySelector('#table-pagination-header')
        this.pageSize = 15
        this.pageNumber = 1
        this.globalData = []
        this.records = []
        this.recordHtml = ''

    }
    showPageSize = () => {
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
        `
        // Agregando y scripting para buscar donde colocar el pagesize
        this.tbody.parentElement.previousElementSibling.innerHTML = templateHTML
        const elPageSize = this.tbody.parentElement.previousElementSibling.children

        // Funcionalidad de pagesize    
        for (const iterator of elPageSize) {
            if (iterator.classList.contains('pageSize-container')) {
                iterator.children[1].addEventListener('change', () => {
                    this.pageSize = iterator.children[1].value
                    this.showPagination(this.records)
                })
            }
        }
    }

    showFilter = () => {
        // creando node y agregango contenido
        let el = document.createElement('div')
        el.classList.add('filter')

        let templateHTML = `<input class="form-control input-filter" name="filter" type="text" placeholder="Buscar...">`
        el.innerHTML = templateHTML
        // Scripting para buscar ele y agregar nodo
        this.tbody.parentElement.previousElementSibling.appendChild(el)

        const elFilter = this.tbody.parentElement.previousElementSibling.children

        // Funcionalidad de filter
        for (const iterator of elFilter) {
            if (iterator.classList.contains('filter')) {
                iterator.children[0].addEventListener('input', () => {
                    if (iterator.children[0].value.length > 0) {
                        let nuevoArray = this.records.map(record => {
                            for (const key in record) {
                                if (Object.hasOwnProperty.call(record, key)) {
                                    const element = record[key];
                                    console.log(element);
                                    console.log(iterator.children[0].value);    
                                    if (element) {
                                        if (element.includes(iterator.children[0].value)) {
                                            record.key = element
                                            record.visible = true
                                        } else {
                                            record.visible = false
                                        }
                                    }
                                }
                            }
                            return record
                        })
                        this.showPagination(nuevoArray)
                    }
                })
            }
        }

    }

    buildHeader = () => {
        let el = document.createElement('div')
        el.classList.add('table-pagination-header')

        // Agregando contenido al elemento y agregando al dom
        this.tbody.closest('.table-custom').prepend(el)
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
        // Validando si tiene el filter activo
        // if(_records.length >= 0) {
        //     _records.forEach(value => {
        //         for (const key in value) {
        //             if (Object.hasOwnProperty.call(value, key)) {
        //                 const element = value[key];

        //             }
        //         }
        //     })
        // }
        // 

        // Inicializando variables
        this.records = _records
        this.globalData = _records

        if (_records.length >= 0) {

            let pagination = this.paginate(this.records, this.pageSize, this.pageNumber)
            let recordHtml = ''
            let newPagination = pagination.map(element => {
                return {
                    ...element,
                    actions: `<button id="${element.id}" class="btn btn-info btn-sm rounded-pill editLink" aria-label="open modal" type="button" data-open="${this.tableName}EditModal">Editar</button> <button type="button" id="${element.id}" class="btn btn-danger btn-sm rounded-pill deleteLink">Eliminar<button>`
                }
            })

            newPagination.forEach((value) => {
                recordHtml += '<tr>'
                // Si esta activo el filtro
                if (value.visible) {
                    if (value.visible == true) {
                        for (const key in value) {
                            if (Object.hasOwnProperty.call(value, key)) {
                                const element = value[key];

                                recordHtml += `<td>${element}</td>`
                            }
                        }
                    }else{
                    }
                } else {
                    for (const key in value) {
                        if (Object.hasOwnProperty.call(value, key)) {
                            const element = value[key];

                            recordHtml += `<td>${element}</td>`
                        }
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

import { initPagination, showPagination } from './modules/Pagination.js';
import initModal from './modules/Modal.js';

document.addEventListener('DOMContentLoaded', function () {
    const URI = 'actionEntitySubClass.php'

    initPagination('#tableEntitySubClass')

    // Search all data
    const fetchAllData = async () => {
        const data = await fetch(`${URI}?fetchAll=1`, {
            method: 'GET'
        })
        const res = await data.json()
        console.log(res);
        showPagination(res)
        initModal()
    }
    fetchAllData()

    // Inicializamos todos los modales
    initModal()
})


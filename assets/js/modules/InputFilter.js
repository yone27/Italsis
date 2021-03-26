export default class InputFilter {
    constructor(input, select, URI = 'actionAssistantBank.php?fetchCompany', selected = false) {
        this.input = document.getElementById(input)
        this.select = document.getElementById(select)
        this.selected = selected
        this.URI = URI

        // Inicializar funcionalidad
        this.init()
    }

    init = () => {
        // Input Initialize
        this.input.addEventListener('input', e => {
            e.preventDefault()
            // search data
            this.filterby(this.input, this.select, this.selected)
        })
        const papi = this.input.closest('.filter__containerInput')
        const newNode = document.createElement('div')
        newNode.classList.add('iconAppend')
        newNode.innerHTML = '<i class="fa fa-flip-horizontal filter__iconSelect rotate360 hidden">X</i>'
        
        papi.appendChild(newNode)
        this.loader = newNode
    }

    reset = () => {
        while (this.select.firstChild) {
            this.select.removeChild(this.select.firstChild);
        };
    }


    async filterby(src = this.input, dest = this.select, selected = false) {
        const srcValue = src.value
        // limpiando errores
        let errors = document.querySelector('.error-message')
        if (errors) {
            errors.remove()
        }
        
        // Seleccionando loader 
        const loader = this.loader.children[0]

        if (srcValue.length > 3) {
            // Colocando loader
            loader.classList.remove('hidden')

            const data = await fetch(`${this.URI}=${srcValue}`, {
                method: 'GET'
            })
            const res = await data.json()
            let output = ""
            if (selected) {
                let customObj
                // selecciona por defecto el registro
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

                    dest.closest('.filter').appendChild(nodeError)
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
                    // limpiando errores
                    let errors = document.querySelector('.error-message')
                    if (errors) {
                        errors.remove()
                    }

                    const nodeError = document.createElement("p");
                    const textnode = document.createTextNode(`* ${res.error}`);
                    nodeError.classList.add('error-message')
                    nodeError.appendChild(textnode)

                    dest.closest('.filter').appendChild(nodeError)
                    dest.classList.add('hide')
                }
            }
            // Quitando loader
            loader.classList.add('hidden')
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
}
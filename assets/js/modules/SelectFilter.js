export default class SelectFilter {
    constructor(input, select, URI = 'actionAssistantBank.php?fetchCompany', selected = false) {
        this.input = document.getElementById(input)
        this.select = document.getElementById(select)
        this.selected = selected
        this.URI = URI

        // Inicializar funcionalidad
        this.init()
    }

    init = () => {
    }

    reset = () => {
        while (this.select.firstChild) {
            this.select.removeChild(this.select.firstChild);
        };
    }


    async filterby(src = this.input, dest = this.select, selected = false) {
        
    }
}
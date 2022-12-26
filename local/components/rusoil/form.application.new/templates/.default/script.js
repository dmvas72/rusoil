class Elements {
    constructor() {
        this.elAddElement = '.-js-btn_add_element'
        this.elRemoveElement = '.-js-btn_remove_element'
        this.elContainerElement = '.application-elements__row'

        this.$containerElements = $('.application-elements__rows')
        this.$copiedElement = this.$containerElements.html()

        this.addEventAddElement($(this.elAddElement))
        this.addEventRemoveElement($(this.elRemoveElement))
    }

    addEventAddElement(element)
    {
        element.on('click', () => {
            let newEl = $(this.$copiedElement).appendTo(this.$containerElements)
            this.addEventAddElement(newEl.find(this.elAddElement))
            this.addEventRemoveElement(newEl.find(this.elRemoveElement))
        })
    }


    addEventRemoveElement(element)
    {
        let self = this

        element.on('click', function()
        {
            let cntEl = $(self.elContainerElement).length
            console.log(cntEl)

            if(cntEl === 1)
            {
                alert("Невозможно удалить последний элемент")
                return false
            }

            $(this).parents(self.elContainerElement).remove()
        })
    }
}

$(function(){
    let elements = new Elements()
})
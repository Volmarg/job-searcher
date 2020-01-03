var selectize = {
    attributes: {
        data: {
            isSelectize: "data-is-selectize"
        }
    },
    init: function(){
        let allSelectizeElements = $("[" + this.attributes.data.isSelectize + "]");

        $.each(allSelectizeElements, function(index, element) {
           let $element = $(element);
           $element.selectize({
               delimiter: ',',
               persist: false,
               create: function(input) {
                   return {
                       value: input,
                       text: input
                   }
               }
           });
        });
    },
    /**
     * This function will add item to the selectized input
     * @param $element  {object}
     * @param items     {array}
     */
    addItems: function($element, items){

        if("object" !== typeof $element){
            throw({
                "message": "Provided element is not an object",
                'element': $element
            })
        }

        if( !$.isArray(items)){
            throw({
                "message": "Items param is not an array",
                "items"  : items
            })
        }

        if( 1 !== $element.length ){
            throw({
                "message": "There are more than one element for this object",
                'element': $element
            })
        }

        let input = $element[0];

        if( !$(input).is("input") ){
            throw({
                "message": "Target element is not an input",
                'element': $element
            })
        }

        let selectize = input.selectize;

        if( "undefined" === typeof selectize){
            throw({
                "message": "Target element is not selecitzed",
                'element': $element
            })
        }

        // without clearing - onLoad items will be appended instead of inserted
        selectize.clear();
        selectize.clearOptions();

        $.each(items, (index, value) => {
            selectize.addOption({value: value, text: value});
            selectize.addItem(value);
        });

    }
};

$(document).ready( () => {
   selectize.init();
});
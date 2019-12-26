var tables = {
    datatables: {
        attributes: {
            data:{
                isDataTable: "data-is-datatable"
            }
        },
        selectors: {
            query: {
                  searchSettingsRemoveButton: "#searchSettingsDialogWrapper #searchSettingsRemoveButton"
            }
        },
        domElements: {
            searchSettingsRemoveButton: null,
            init: function(){
                this.searchSettingsRemoveButton = $(tables.datatables.selectors.query.searchSettingsRemoveButton);
            }
        },
        init: function(){
            let allTablesToTransform = $("[" + this.attributes.data.isDataTable + " = 'true']");

            $.each(allTablesToTransform, function (index, table) {
                let $table = $(table);

                $table.dataTable();
            })
        },
        markRowSelected: function($row){
            $row.addClass('selected-row');
        },
        unmarkRowSelected: function($row){
            $row.removeClass('selected-row');
        },
        deleteRowsFromDataTable: function($row){
            $row.remove();
        },
        enableRemoveButton: function(){
            this.domElements.searchSettingsRemoveButton.removeClass("disabled");
        },
        disableRemoveButton: function(){
            this.domElements.searchSettingsRemoveButton.addClass("disabled");
        }
    }
};
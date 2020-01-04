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

                // prevent reinit the same table
                if( $.fn.DataTable.isDataTable( table ) ){
                    return;
                }

                // need to attach events every time that page is changed as dom changes with that as well
                $table.dataTable({
                    "drawCallback": function() {
                        events.init();
                    }
                });
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
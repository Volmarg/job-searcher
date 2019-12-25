var tables = {
    datatables: {
        attributes: {
            data:{
                isDataTable: "data-is-datatable"
            }
        },
        init: function(){
            let allTablesToTransform = $("[" + this.attributes.data.isDataTable + " = 'true']");

            $.each(allTablesToTransform, function (index, table) {
                let $table = $(table);

                $table.dataTable();
            })
        }
    }
};
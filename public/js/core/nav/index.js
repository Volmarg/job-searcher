var nav = {
    /**
     * This function will hide menu elements with give ids
     * @param ids {array}
     */
    hideMenuElementsByIds: function(ids){
        $.each(ids, (index, id) => {
            let $element = $("#" + id);
            $element.closest("li").hide();
        })
    },
    /**
     * This function will show menu elements with give ids
     * @param ids {array}
     */
    showMenuElementsByIds: function(ids){
        $.each(ids, (index, id) => {
            let $element = $("#" + id);
            $element.closest("li").show();
        })
    },
};
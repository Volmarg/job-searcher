var infoBox = {

    /**
     * Show box with green background
     * @param message {string}
     */
    showSuccessBox: function(message){
        $.notify(
            {message: message},
            {
                type    : "success",
                z_index : 9999
            });
    },
    /**
     * Show box with orange background
     * @param message {string}
     */
    showWarningBox: function(message){
        $.notify(
            {message: message},
            {
                type    : "warning",
                z_index : 9999
            });
    },
    /**
     * Show box with red background
     * @param message {string}
     */
    showDangerBox: function(message){
        $.notify(
            {message: message},
            {
                type    : "danger",
                z_index : 9999
            });
    }
};

$(document).ready(function(){

});
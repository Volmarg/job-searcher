var infoBox = {

    /**
     * Show box with green background
     * @param message {string}
     */
    showSuccessBox: function(message){
        $.notify(
            {message: message},
            {type: "success"});
    },
    /**
     * Show box with orange background
     * @param message {string}
     */
    showWarningBox: function(message){
        $.notify(
            {message: message},
            {type: "warning"});
    },
    /**
     * Show box with red background
     * @param message {string}
     */
    showDangerBox: function(message){
        $.notify(
            {message: message},
            {type: "danger"});
    }
};

$(document).ready(function(){

});
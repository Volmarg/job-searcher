var dialogs = {

    data: {
      callDialog        : "data-call-dialog",
      dialogContentType : "data-dialog-content-type",
      dialogTemplate    : "data-dialog-template"
    },
    domElements: {
        dialogBody  : null,
    },
    api: {
        ajaxGetTemplateForTemplateType: {
            url: "/dialog-template/ajax/load",
            method: "GET"
        }
    },
    /**
     * This function will set the domElement of the dialog body
     */
    setDialogBody: function($element){
        this.domElements.dialogBody = $($element);
    },
    /**
     * This function will get the template for templateType
     * @param templateType {string}
     */
    getDialogTemplateForTemplateType: function(templateType){

    },
    /**
     * This function will make ajax call and returns the template body
     * @param templateType  {string}
     * @param callbackAfter {function}
     */
    makeAjaxCallForDialogTemplateType: function(templateType, callbackAfter){

        let _this = this;

        loaders.spinner.showSpinner();
        $.ajax({
           method: this.api.ajaxGetTemplateForTemplateType.method,
           url   : this.api.ajaxGetTemplateForTemplateType.url + '/' + templateType,
        }).always(function(data){

            let error    = data[KEY_JSON_RESPONSE_ERROR];
            let message  = data[KEY_JSON_RESPONSE_MESSAGE];
            let template = data[KEY_JSON_RESPONSE_TEMPLATE];

            if(
                    "undefined" !== typeof error
                &&  false       !== error
                &&  "false"     !== error
            ){
                infoBox.showDangerBox(message);
            }

            if( "undefined" !== typeof template ){
                _this.domElements.dialogBody.html(template);
            }

            if( "function" === typeof callbackAfter ){
                callbackAfter();
            }

            loaders.spinner.hideSpinner();
        });

    }

};
var dialogs = {

    data: {
      callDialog        : "data-call-dialog",
      dialogContentType : "data-dialog-content-type",
      dialogTemplate    : "data-dialog-template",
      jobOfferHeader    : "data-job-offer-header-for-mail-generate-dialog",
      jobOfferUrl       : "data-job-offer-url-for-mail-generate-dialog"
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
    selectors: {
        ids:{
            jobOfferHeaderForMail       : "#jobOfferHeaderForMail",
            jobOfferUrlForMail          : "#jobOfferUrlForMail",
            generatedEmailTitle         : "#generatedEmailTitle",
            generatedEmailDescription   : "#generatedEmailDescription",
        },
        classes: {
            dialogBody          : ".modal-body",
            dialogFooter        : ".modal-footer",
            dialogAcceptButton  : ".bootbox-accept"
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
     * @param params        {string}
     */
    makeAjaxCallForDialogTemplateType: function(templateType, callbackAfter, params){

        let _this = this;
        let data = {
            "params": params
        };

        loaders.spinner.showSpinner();
        $.ajax({
           method: this.api.ajaxGetTemplateForTemplateType.method,
           url   : this.api.ajaxGetTemplateForTemplateType.url + '/' + templateType,
           data  : data
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
                callbackAfter(template);
            }

            loaders.spinner.hideSpinner();
        });

    },
    /**
     * This function calls additional logic for called template - after it's rendering
     * @param templateType          {string}
     * @param $dialogCallingElement {object}
     */
    attachTemplateAfterLoadLogicForTemplateType: function(templateType, $dialogCallingElement){
        switch( templateType ){
            case TEMPLATE_TYPE_GENERATE_MAIL_FROM_TEMPLATE:
            {
                let jobOfferHeader = $dialogCallingElement.attr(this.data.jobOfferHeader);
                let jobOfferUrl    = $dialogCallingElement.attr(this.data.jobOfferUrl);

                let $jobOfferHeaderInput = $(this.selectors.ids.jobOfferHeaderForMail);
                let $jobOfferUrlInput    = $(this.selectors.ids.jobOfferUrlForMail);

                $jobOfferHeaderInput.val(jobOfferHeader);
                $jobOfferUrlInput.val(jobOfferUrl);
                events.buttons.attachGenerateMailFromTemplateEvent();
            }
                break;
            case TEMPLATE_TYPE_SAVE_SEARCH_SETTINGS:
            {
                let $dialogBody   = $(dialogs.selectors.classes.dialogBody);
                let $dialogFooter = $(dialogs.selectors.classes.dialogFooter);

                let $acceptButton = $dialogFooter.find(dialogs.selectors.classes.dialogAcceptButton);
                let $inputs       = $dialogBody.find('input');

                $.each($inputs, (index, input) => {
                   let $input = $(input);
                    $acceptButton.addClass("disabled");

                    $input.on('change', () => {

                       if(
                                "undefined" !== $input.attr("required")
                            &&  "" === $input.val()
                       ){
                            $acceptButton.addClass("disabled");
                       }else {
                            $acceptButton.removeClass("disabled");
                       }

                   });

                });
            }
                break;
            default:
            //do nothing
        }
    }
};
var events = {

    attributes: {
        data: {
            bootbox: {
                callBootboxDialog           : "data-call-bootbox-dialog",
                bootboxSize                 : "data-bootbox-size",
                bootboxType                 : "data-bootbox-type",
                bootboxMessage              : "data-bootbox-message",
                bootboxCallbackType         : "data-bootbox-callback-type",
                bootboxCallbackTemplateType : "data-bootbox-callback-type-template-name",
            },
            ajax: {
                callOnClick          : "data-ajax-call-on-click",
                callForSelectorClick : "data-call-ajax-for-selector-click",
                callMethod           : "data-ajax-call-method",
                callMethodParams     : "data-ajax-call-method-params"
            }
        },
    },
    eventsNames:{
        bootstrap:{
            showModal: 'shown.bs.modal'
        }
    },
    selectors: {
        classes: {
            bootboxBody: ".bootbox-body"
        },
        query: {
            searchSettingsTable: "#searchSettingsDialogWrapper table",
            jobSearchForm      : "#jobSearchWrapper form"
        }
    },
    api: {
        saveSearchSetting: {
            url   : "search-settings/ajax/save",
            method: "POST",
        },
        loadSearchSetting: {
            urlWithoutParams   : "search-settings/ajax/load",
            method: "GET",
        }
    },
    messages: {
      couldNotHandleAjaxResponse: "Could not handle the ajax response"
    },
    init: function(){
      this.attachCallBootBoxDialog();
    },
    /**
     * This function will the bootbox dialog and append logic to it based on html attributes
     */
    attachCallBootBoxDialog: function (){
        let _this = this;
        let allElementsWithBootboxCall = $('[' + _this.attributes.data.bootbox.callBootboxDialog + ' = "true"]');

        $.each(allElementsWithBootboxCall, function(index, element){
            let $element            = $(element);
            let bootboxSize         = $element.attr(_this.attributes.data.bootbox.bootboxSize);
            let bootboxType         = $element.attr(_this.attributes.data.bootbox.bootboxType);
            let bootboxCallbackType = $element.attr(_this.attributes.data.bootbox.bootboxCallbackType);
            let bootboxMessage      = $element.attr(_this.attributes.data.bootbox.bootboxMessage);

            bootboxMessage = ( "undefined" == typeof bootboxMessage ? "" : bootboxMessage);

            if( "undefined" == typeof bootboxType){
                throw({
                    "message": "bootboxType was not defined"
                })
            }

            if( "undefined" == typeof bootboxSize){
                throw({
                    "message": "bootboxSize was not defined"
                })
            }

            if( "undefined" == typeof bootboxCallbackType){
                throw({
                    "message": "bootboxCallbackType was not defined"
                })
            }

            switch( bootboxType ){
                case BOOTBOX_TYPE_CONFIRM:
                case BOOTBOX_TYPE_ALERT:
                        //no code - this is just for filtering types
                    break;
                default:
                    throw({
                        "message" : "This type is not supported",
                        "type"    : bootboxType
                    })
            }

            $element.on("click", function(event){
                event.preventDefault();

                // call bootbox
            bootbox[bootboxType]({
                    message : bootboxMessage,
                    backdrop: true,
                    size    : bootboxSize,
                    callback: function (result) {
                        if(result){
                        }
                    }
                }).init(function () {

                }).bind(_this.eventsNames.bootstrap.showModal, () => {
                    // add content to dialog body
                    switch(bootboxCallbackType){

                        case BOOTBOX_CALLBACK_TYPE_LOAD_TEMPLATE:
                            let templateType = $element.attr(_this.attributes.data.bootbox.bootboxCallbackTemplateType);

                            if( "undefined" == typeof templateType){
                                throw({
                                    "message": "templateType was not defined for bootbox call with template callback"
                                })
                            }

                            // todo:
                            let $bootboxBody = $(_this.selectors.classes.bootboxBody);
                            let callback = function(){
                                tables.datatables.init();
                                _this.attachAjaxCallForElementClick();
                                _this.dataTables.attachDatatableEvent(templateType);
                            };
                            dialogs.setDialogBody($bootboxBody);
                            dialogs.makeAjaxCallForDialogTemplateType(templateType, callback);

                            break;
                        default:
                            throw({
                                "message": "This callback type is not supported",
                                "type"   : bootboxCallbackType
                            })
                    }
                });
            });
        });
    },
    /**
     * This function will attach click logic for given elements - call ajax method
     * @param allElementsToHandle {array}
     */
    attachAjaxCallForElementClick: function (allElementsToHandle){
        let _this = this;

        if( "undefined" === typeof allElementsToHandle ){
            allElementsToHandle = $("[" + this.attributes.data.ajax.callOnClick + "='true']");
        }

        if( 0 === allElementsToHandle.length ){
            return;
        }

        $.each(allElementsToHandle, function(index, element) {
            let $element   = $(element);
            let method     = $element.attr(_this.attributes.data.ajax.callMethod);
            let jsonParams = $element.attr(_this.attributes.data.ajax.callMethodParams);

            if( "undefined" === typeof method ) {
                throw({
                    "message": "method to call was not provided"
                })
            }

            if( "undefined" === jsonParams ){
                jsonParams = "{}";
            }

            // decide if the click is directly on the element or element pointed by selector
            // this is required as bootbox does not allow to pass additional attributes to the buttons
            let selectorForClick = $element.attr(_this.attributes.data.ajax.callForSelectorClick);
            let $elementToHandle = $element;
            if( "undefined" !== typeof selectorForClick )
            {
                $elementToHandle = $(selectorForClick);
            }

            $elementToHandle.off("click");
            $elementToHandle.on('click', () => {

                switch(method) {
                    case "saveSearchSetting" :
                        let name = $element.val();
                        let id   = ""; //todo : temporary solution

                        let jsonObject = {
                            "name": name,
                             id   : id,
                        };

                        jsonParams = JSON.stringify(jsonObject);
                        break;
                    default:
                        // do nothing
                }

                try{
                    _this.ajaxCalls[method](jsonParams);
                }catch(Exception){
                    throw({
                        "message"   : "Could not handle method named: " + method,
                        "exception" : Exception,
                        "hint #1"   : "Method may not exist"
                    })
                }
            });
        })

    },
    /**
     * Handle general ajax call
     */
    ajaxCalls: {
        /**
         * This function will perform call to either save new search setting or update existing one
         * @param jsonParams  {string}
         */
        saveSearchSetting: function(jsonParams){

            let paramsObject        = JSON.parse(jsonParams);
            let $form               = $(events.selectors.query.jobSearchForm);
            let serializedFormArray = $form.serializeArray();

            try{
                var id   = paramsObject.id;
                var name = paramsObject.name;
            }catch(Exception){
                throw({
                    "message"   : events.messages.couldNotHandleAjaxResponse,
                    "exception" : Exception,
                    "hint#1"    : "Object may not contains give params"
                })
            }

            let ajaxData = [
                {
                    name  : "name",
                    value : name
                },
                {
                    name  : "id",
                    value : id
                }
            ];

            ajaxData = $.merge(serializedFormArray, ajaxData);

            loaders.spinner.showSpinner();
            $.ajax({
                url     : events.api.saveSearchSetting.url,
                method  : events.api.saveSearchSetting.method,
                data    : ajaxData
            }).always( (data) => {

                try{
                    var error   = data[KEY_JSON_RESPONSE_ERROR];
                    var message = data[KEY_JSON_RESPONSE_MESSAGE];
                }catch(Exception){
                    throw({
                        "message": events.messages.couldNotHandleAjaxResponse
                    })
                }

                if( true === error ){
                    loaders.spinner.hideSpinner();
                    infoBox.showDangerBox(message);
                    return;
                }

                infoBox.showSuccessBox(message);
                loaders.spinner.hideSpinner();
            });

        },
        /**
         * This function will load search setting for given id
         * @param id {string}
         */
        loadSearchSetting: function(id){

            $.ajax({
                url: events.api.loadSearchSetting.urlWithoutParams + '/' + id,
                method: events.api.loadSearchSetting.method
            }).always( (data) => {

                try{
                    var error   = data[KEY_JSON_RESPONSE_ERROR];
                    var message = data[KEY_JSON_RESPONSE_MESSAGE];
                }catch(Exception){
                    throw({
                        "message"  : "Could not handle the ajax response",
                        "exception": Exception
                    })
                }

                if( error ){
                    infoBox.showDangerBox(message);
                    return;
                }

                let searchSettingString = data[KEY_JSON_RESPONSE_SEARCH_SETTING];
                let searchSettingJson   = JSON.parse(searchSettingString);

                let $jobSearchForm      = $(events.selectors.query.jobSearchForm);
                let jobSearchFormInputs = $jobSearchForm.find('input');

                $.each( jobSearchFormInputs, (index, input) => {
                   let $input = $(input);

                   $.each( searchSettingJson, (name, value) => {
                       if( $input.attr("name") === "job_offer_scrapping["+ name +"]"){
                           $input.val(value);
                       }
                   });
                });
            });
        }
    },
    /**
     * Handle events for bootbox
     */
    bootbox: {
    },
    /**
     * Handle events for dataTables
     */
    dataTables: {
        /**
         * This function will attach logic to datable
         * @param templateType
         */
        attachDatatableEvent:function (templateType){

            switch( templateType ){
                case TEMPLATE_TYPE_SEARCH_SETTINGS:

                    $table = $(events.selectors.query.searchSettingsTable);
                    $rows  = $table.find("tbody tr");

                    $.each($rows, (index, row) => {
                        let $row      = $(row);

                        $row.on('click', () => {
                            let settingId = $row.find('.id').text();
                            events.ajaxCalls.loadSearchSetting(settingId);
                        });

                    });

                    break;
                default:
                    throw({
                        "message"       : "DataTable event attaching could not been done, give template type is not supported",
                        "templateType" :  templateType
                    })
            }
        }
    }
};

$(document).ready(function(){
    events.init();
});
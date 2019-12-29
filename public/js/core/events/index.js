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
            buttons: {
                entityName                  : "data-entity-name",
                removeEntity                : "data-remove-entity",
                ajaxRemovalLink             : "data-entity-removal-ajax-link",
                removedIdsElementsSelector  : "data-entity-removed-ids-elements-selector",
                entityId                    : "data-entity-id",
                parentToRemoveSelector      : "data-parent-element-to-remove-selector"
            },
            forms: {
                submitViaAjax               : "data-submit-via-ajax",
                ajaxUrl                     : "data-ajax-url"
            },
            ajax: {
                callOnClick          : "data-ajax-call-on-click",
                callForSelectorClick : "data-call-ajax-for-selector-click",
                callMethod           : "data-ajax-call-method",
                callMethodParams     : "data-ajax-call-method-params"
            },
            jobSearchResult: {
                offerDescription : "data-job-offer-description",
                offerLink        : "data-job-offer-offer-link"
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
            bootboxBody          : ".bootbox-body",
            mainContainerWrapper : ".main-container-wrapper"
        },
        query: {
            searchSettingsTable : "#searchSettingsDialogWrapper table",
            jobSearchResultTable: "#jobSearchResultWrapper table",
            jobSearchForm       : "#jobSearchWrapper form"
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
    domElements: {
      mainContainerWrapper: null,
      init: function () {
        this.mainContainerWrapper = $(events.selectors.classes.mainContainerWrapper);
      }
    },
    init: function(){
      this.attachCallBootBoxDialog();
      this.buttons.attachRemoveEntitiesEvent();
      this.forms.submitViaAjax();
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

            $element.off("click");
            $element.on("click", function(event){
                event.preventDefault();

                // call bootbox
                let bootboxInstance = bootbox[bootboxType]({
                    message : bootboxMessage,
                    backdrop: true,
                    size    : bootboxSize,
                    callback: function (result) {
                        if(result){
                        }
                    }
                }).init(function () {

                });

                bootboxInstance.unbind(_this.eventsNames.bootstrap.showModal);
                bootboxInstance.bind(_this.eventsNames.bootstrap.showModal, () => {
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
                                tables.datatables.domElements.init();
                                tables.datatables.init();

                                events.buttons.attachRemoveEntitiesEvent();

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


            loaders.spinner.showSpinner();
            $.ajax({
                url: events.api.loadSearchSetting.urlWithoutParams + '/' + id,
                method: events.api.loadSearchSetting.method
            }).always( (data) => {
                loaders.spinner.hideSpinner();

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

                infoBox.showSuccessBox(message);
            });
        },
        /**
         * This function will delete searchSettings with given id
         * If the id sent to the backend does no exist then it will just be skipped and information will be returned
         * @param ids
         */
        deleteSearchSettings: function(ids){



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
                {

                    let $table = $(events.selectors.query.searchSettingsTable);
                    let $rows  = $table.find("tbody tr");

                    $.each($rows, (index, row) => {
                        let $row      = $(row);
                        let $nameCell = $row.find('.name');
                        let $checkbox = $row.find('input');

                        $nameCell.off('click');
                        $nameCell.on('click', () => {
                            let settingId = $row.find('.id').text();
                            events.ajaxCalls.loadSearchSetting(settingId);
                        });

                        $checkbox.off("click");
                        $checkbox.on('click', (event) => {
                            let $clickedCheckbox = $(event.currentTarget);

                            if( $clickedCheckbox.prop('checked') ){
                                tables.datatables.markRowSelected($row);
                            }else{
                                tables.datatables.unmarkRowSelected($row);
                            }

                            let allCheckboxes          = $table.find('input');
                            let checkedCheckboxesCount = 0;

                            $.each(allCheckboxes, (index, checkbox) => {
                                let $checkbox = $(checkbox);
                                if( $checkbox.prop('checked') ){
                                    checkedCheckboxesCount++;
                                }
                            });

                            if( checkedCheckboxesCount > 0 ){
                                tables.datatables.enableRemoveButton();
                            }else{
                                tables.datatables.disableRemoveButton();
                            }

                        });
                    });
                }
                    break;
                case TEMPLATE_JOB_SEARCH_RESULTS:
                {
                    let $table = $(events.selectors.query.jobSearchResultTable);
                    let $rows  = $table.find("tbody tr");

                    $.each($rows, (index, row) => {
                        let $row      = $(row);
                        let $nameCell = $row.find('.job-offer-header');

                        let offerDescription = $row.attr(events.attributes.data.jobSearchResult.offerDescription);
                        let offerLink        = $row.attr(events.attributes.data.jobSearchResult.offerLink);

                        $nameCell.off('click');
                        $nameCell.on('click', () => {
                            console.log('test');
                        });
                    });

                }
                    break;
                default:
                    //do nothing
            }
        }
    },
    buttons: {
        /**
         * This function will remove entities of given type with given ids
         * @param ids      {array}
         * @param callback {function}
         */
        attachRemoveEntitiesEvent: function(ids, callback) {
            let buttonsToHandle = $("[" + events.attributes.data.buttons.removeEntity + "='true']");

            $.each(buttonsToHandle, (index, button) => {
                let $button = $(button);

                $button.off("click");
                $button.on('click', () => {
                    let ajaxRemovalLink             = $button.attr(events.attributes.data.buttons.ajaxRemovalLink);
                    let removedIdsElementsSelector  = $button.attr(events.attributes.data.buttons.removedIdsElementsSelector);
                    let parentToRemoveSelector      = $button.attr(events.attributes.data.buttons.parentToRemoveSelector);
                    let elementsToRemove            = [];

                    let allElementsWithIds = $(removedIdsElementsSelector);
                    let idsToRemove        = [];
                    if( "undefined" === typeof ids ) {
                        $.each(allElementsWithIds, (index, element) => {
                            let $element = $(element);

                            if( !$element.is("INPUT") ){
                                throw({
                                    "message": "Target element is not input",
                                    "hint#1" : "Input must be of type checkbox"
                                })
                            }

                            if( $element.prop('checked') ){
                                let id  = $element.attr(events.attributes.data.buttons.entityId);

                                if( "undefined" !== parentToRemoveSelector ){
                                    let elementToRemove = $element.closest(parentToRemoveSelector);
                                    elementsToRemove.push(elementToRemove);
                                }

                                idsToRemove.push(id)
                            }
                        });
                    } else {
                        idsToRemove = ids;
                    }

                    if( 0 === idsToRemove.length ){
                        console.info("There are no elements with id's to remove");
                        return;
                    }

                    let ajaxData = {
                        "ids": idsToRemove
                    };

                    loaders.spinner.showSpinner();
                    $.ajax({
                        url    : ajaxRemovalLink,
                        method : "POST",
                        data   : ajaxData
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

                        $.each(elementsToRemove, (index, element) => {
                            let $element = $(element);
                            $element.remove();
                        });

                        infoBox.showSuccessBox(message);
                    });
                });
            })
        }
    },
    forms: {
        submitViaAjax: function() {
            let _this            = this;
            let allFormsToHandle = $("[" + events.attributes.data.forms.submitViaAjax + "=true]");

            $.each(allFormsToHandle, (index, form) => {
                let $form         = $(form);
                let $submitButton = $form.find('button[type="submit"');

                $submitButton.on('click', function(event) {
                    event.preventDefault();

                   let $clickedButton = $(event.currentTarget);
                   let serializedForm = $form.serializeArray();
                   let ajaxUrl        = $form.attr(events.attributes.data.forms.ajaxUrl);

                   if( "undefined" === ajaxUrl ){
                       throw({
                           "message": "Ajax url is missing for form to be submitted via ajax",
                           "hint#1" : "Form is missing attribute: " + events.attributes.data.forms.ajaxUrl
                       })
                   }

                   loaders.spinner.showSpinner();
                    $.ajax({
                        url     : ajaxUrl,
                        method  : "POST",
                        data    : serializedForm
                    }).always( (data) => {

                        try{
                            var error    = data[KEY_JSON_RESPONSE_ERROR];
                            var message  = data[KEY_JSON_RESPONSE_MESSAGE]
                            var template = data[KEY_JSON_RESPONSE_TEMPLATE];
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

                        if( "undefined" !== typeof template ) {
                            events.domElements.mainContainerWrapper.html(template);
                            tables.datatables.init();
                            events.init();
                        }

                        infoBox.showSuccessBox(message);
                        loaders.spinner.hideSpinner();

                    });

                });

            });
        }
    }
};

$(document).ready(function(){
    events.domElements.init();
    events.init();
});
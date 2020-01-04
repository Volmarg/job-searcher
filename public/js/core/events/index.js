var events = {

    attributes: {
        data: {
            bootbox: {
                callBootboxDialog             : "data-call-bootbox-dialog",
                bootboxSize                   : "data-bootbox-size",
                bootboxType                   : "data-bootbox-type",
                bootboxMessage                : "data-bootbox-message",
                bootboxCallbackType           : "data-bootbox-callback-type",
                bootboxCallbackTemplateType   : "data-bootbox-callback-type-template-name",
                bootboxCallbackTemplateParams : "data-bootbox-callback-type-template-params"
            },
            buttons: {
                entityName                  : "data-entity-name",
                removeEntity                : "data-remove-entity",
                ajaxRemovalLink             : "data-entity-removal-ajax-link",
                removedIdsElementsSelector  : "data-entity-removed-ids-elements-selector",
                entityId                    : "data-entity-id",
                parentToRemoveSelector      : "data-parent-element-to-remove-selector",
                loadMailTemplate            : "data-load-mail-template",
                mailTemplateId              : "data-mail-template-id",
                cleanMailTemplateForm       : "data-clean-mail-template-form",
                ajaxUrl                     : "data-ajax-url",
                ajaxMethod                  : "data-ajax-method"
            },
            forms: {
                submitViaAjax               : "data-submit-via-ajax",
                elementForSubmitViaAjax     : "data-ajax-form-submit",
                ajaxUrl                     : "data-ajax-url"
            },
            ajax: {
                callOnClick             : "data-ajax-call-on-click",
                callForSelectorClick    : "data-call-ajax-for-selector-click",
                callMethod              : "data-ajax-call-method",
                callMethodParams        : "data-ajax-call-method-params",
                loadPageContent         : "data-load-page-content",
                loadPageContentUrl      : "data-load-page-content-url",
                loadPageContentMethod   : "data-load-page-content-method",
                generateMailFromTemplate: "data-generate-mail-from-template"
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
            jobSearchForm       : "#jobSearchWrapper form",
            mailTemplateForm    : "#mailManageWrapper form"
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
        },
        loadEmailTemplate: {
            urlWithoutParams   : "mail-template/ajax/load",
            method: "GET",
        },
        saveEmailTemplate: {
            urlWithoutParams   : "mail-template/ajax/save/",
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
      this.attachAjaxPageContentLoadOnElementClick();
      this.buttons.attachRemoveEntitiesEvent();
      this.buttons.attachLoadMailTemplateEvent();
      this.buttons.attachClearMailTemplateFormEvent();
      this.buttons.attachGenerateMailFromTemplateEvent();
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
                            let params       = $element.attr(_this.attributes.data.bootbox.bootboxCallbackTemplateParams);

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
                                dialogs.attachTemplateAfterLoadLogicForTemplateType(templateType, $element);
                            };
                            dialogs.setDialogBody($bootboxBody);
                            dialogs.makeAjaxCallForDialogTemplateType(templateType, callback, params);

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
     * This function will search for elements with given attr. and attach an ajax call event on them
     */
    attachAjaxPageContentLoadOnElementClick: function (){
        let _this = this;
        let allElementsWithBootboxCall = $('[' + _this.attributes.data.ajax.loadPageContent + '= "true"]');

        $.each(allElementsWithBootboxCall, function(index, element) {

            let $element = $(element);

            $element.off('click');
            $element.on('click', () => {
               let $clickedElement = $(element);
               let url             = $clickedElement.attr(_this.attributes.data.ajax.loadPageContentUrl);
               let method          = $clickedElement.attr(_this.attributes.data.ajax.loadPageContentMethod);
               let menuElementId   = $clickedElement.prop("id");

               if( "undefined" === typeof url ){
                   throw({
                      "message": "Missing url attribute for ajax page content load",
                      "element":  $clickedElement
                   });
               }

                if( "undefined" === typeof method ){
                    throw({
                        "message": "Missing method attribute for ajax page content load",
                        "element":  $clickedElement
                    });
                }

                switch(menuElementId){
                    case MENU_ELEMENT_JOB_SEARCH:
                        var callbackAfter = () => {
                            let menuElementsIdsToShow = [
                                MENU_ELEMENT_JOB_SEARCH_LOAD_SETTING
                            ];
                            nav.showMenuElementsByIds(menuElementsIdsToShow)
                        };
                        break;
                    default:
                        var callbackAfter = () => {
                            let menuElementsIdsToHide = [
                                MENU_ELEMENT_JOB_SEARCH_LOAD_SETTING
                            ];
                            nav.hideMenuElementsByIds(menuElementsIdsToHide)
                        };
                }

                _this.ajaxCalls.loadPageTemplate(url, method, undefined, callbackAfter);
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

                       // if input has been selectized then anything inserted into value is removed
                       if( $input.attr("name") === "job_offer_scrapping["+ name +"]"){
                           let isSelectize = ( $input.attr(selectize.attributes.data.isSelectize) == "true" );

                           if( isSelectize ){
                               selectize.addItems($input, value);
                               return;
                           }
                           $input.val(value);
                       }
                   });
                });

                selectize.init();
                infoBox.showSuccessBox(message);
            });
        },
        /**
         * This function will make an ajax and place the resulted template into main content wrapper
         * @param url           {string}
         * @param method        {string}
         * @param data          {object}
         * @param callbackAfter {function}
         */
        loadPageTemplate: function(url, method, data, callbackAfter){

            if( "undefined" === typeof data){
                data = {};
            }

            loaders.spinner.showSpinner();
            $.ajax({
                url    : url,
                method : method,
                data   : data
            }).always( (data) => {

                try{
                    var error    = data[KEY_JSON_RESPONSE_ERROR];
                    var message  = data[KEY_JSON_RESPONSE_MESSAGE];
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

                if( "undefined" === typeof template ){
                    throw({
                        "message": "No template was returned for ajax call",
                        "url"    : url,
                    })
                }

                events.domElements.mainContainerWrapper.html(template);
                tinyMce.init();
                events.init();
                selectize.init();

                if( "function" === typeof callbackAfter){
                    callbackAfter();
                }
            });
        },
        /**
         * This function will load the saved email template
         * @param id
         */
        loadEmailTemplate: function(id){
            loaders.spinner.showSpinner();
            $.ajax({
                url: events.api.loadEmailTemplate.urlWithoutParams + '/' + id,
                method: events.api.loadEmailTemplate.method
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

                let mailTemplateString = data[KEY_JSON_RESPONSE_MAIL_TEMPLATE];
                let mailTemplateJson   = JSON.parse(mailTemplateString);

                let $mailTemplateForm        = $(events.selectors.query.mailTemplateForm);
                let mailTemplateFormElements = $mailTemplateForm.find('input, textarea');

                $.each( mailTemplateFormElements, (index, input) => {
                    let $formElement = $(input);

                    $.each( mailTemplateJson, (name, value) => {

                        if( $formElement.attr("name") === "mail_template["+ name +"]") {
                            
                            // if textarea is tinymce then we need to handle passing data to textarea and tinymce editor
                            if( $formElement.is("textarea")){
                                let isTinymce = ( $formElement.attr(tinyMce.attributes.data.isTinyMce) == "true" );
                                $formElement.text(value);

                                if( isTinymce ){
                                    tinymce.get($formElement.attr('id')).setContent(value);
                                    tinyMce.init();
                                }

                                return;
                            }

                            // if element has been selectized then anything inserted into value is removed
                            let isSelectize = ( $formElement.attr(selectize.attributes.data.isSelectize) == "true" );

                            if( isSelectize ){
                                selectize.addItems($formElement, value);
                                return;
                            }

                            $formElement.val(value);
                        }
                    });
                });

                selectize.init();
                infoBox.showSuccessBox(message);
            });
        },
        /**
         * This function will make ajax call that will return generated mail from template
         * @param url     {string}
         * @param method  {string}
         * @param data    {object}
         */
        buildEmailFromEmailTemplate: function(url, method, data){

            loaders.spinner.showSpinner();
            $.ajax({
                url    : url,
                method : method,
                data   : data
            }).always( (data) => {

                try{
                    var error           = data[KEY_JSON_RESPONSE_ERROR];
                    var message         = data[KEY_JSON_RESPONSE_MESSAGE];
                    var mailDescription = data[KEY_JSON_RESPONSE_MAIL_DESCRIPTION];
                    var mailTitle       = data[KEY_JSON_RESPONSE_MAIL_TITLE];
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

                if(
                        "undefined" === typeof mailDescription
                    ||  "undefined" === typeof mailTitle
                ){
                    throw({
                        "message"           : "No title or description in ajax response for generated mail from template",
                        "mailDescription"   : mailDescription,
                        "mailTitle"         : mailTitle,
                    })
                }

                let $titleInput          = $(dialogs.selectors.ids.generatedEmailTitle);
                let $descriptionTextarea = $(dialogs.selectors.ids.generatedEmailDescription);

                $titleInput.val(mailTitle);
                $descriptionTextarea.text(mailDescription);
                tinyMce.init();
                events.init();
                selectize.init();
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
                default:
                    //do nothing
            }
        }
    },
    /**
     * Handle events for various buttons
     */
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
                            let $element  = $(element);
                            let isRemoved = false;

                            // if this is checkbox then we handle removal for each selected checkbox, otherwise only clicked element
                            if( $element.is("INPUT") ){
                                if( $element.prop('checked') ){
                                    var id    = $element.attr(events.attributes.data.buttons.entityId);
                                    isRemoved = true;
                                }
                            }else {
                                var id    = $button.attr(events.attributes.data.buttons.entityId);
                                isRemoved = true;
                            }

                            if( "undefined" !== parentToRemoveSelector && isRemoved ){
                                let elementToRemove = $element.closest(parentToRemoveSelector);
                                elementsToRemove.push(elementToRemove);
                            }

                                idsToRemove.push(id)
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
        },
        /**
         * This function attaches the mail template load event handling
         */
        attachLoadMailTemplateEvent: function(){
            let allElementsToHandle = $("[" + events.attributes.data.buttons.loadMailTemplate + "='true']");

            $.each(allElementsToHandle, (index, element) => {
                let $element = $(element);

                $element.off("click");
                $element.on('click', (event) => {
                    let $clickedElement = $(event.currentTarget);
                    let mailTemplateId  = $clickedElement.attr(events.attributes.data.buttons.mailTemplateId);

                    if( "undefined" === typeof mailTemplateId ){
                        throw({
                            "message"       : "Mail template id attribute is missing for mail template load",
                            "clickedElement": $clickedElement
                        });
                    }

                    events.ajaxCalls.loadEmailTemplate(mailTemplateId);

                    // set the id of edited template to form action attribute.
                    let $mailTemplateForm = $(events.selectors.query.mailTemplateForm);
                    let ajaxUrl           = events.api.saveEmailTemplate.urlWithoutParams + mailTemplateId;
                    $mailTemplateForm.attr(events.attributes.data.forms.ajaxUrl, ajaxUrl);
                });
            });
        },
        /**
         * This function will attach event that clears the mailTemplate form and resets the ajax call url on form
         */
        attachClearMailTemplateFormEvent: function(){
            let $elementToHandle  = $("[" + events.attributes.data.buttons.cleanMailTemplateForm + "]");

            $elementToHandle.off('click');
            $elementToHandle.on('click', () => {
                let $mailTemplateForm         = $(events.selectors.query.mailTemplateForm);
                let $mailTemplateFormElements = $mailTemplateForm.find('input, textarea');

                $.each($mailTemplateFormElements, (index, element) => {
                    let $element = $(element);

                    // if textarea is tinymce then we need to handle passing data to textarea and tinymce editor
                    if( $element.is("textarea")){
                        let isTinymce = ( $element.attr(tinyMce.attributes.data.isTinyMce) == "true" );
                        $element.text('');

                        if( isTinymce ){
                            tinymce.get($element.attr('id')).setContent('');
                            tinyMce.init();
                        }

                        return;
                    }

                    let isSelectize = ( $element.attr(selectize.attributes.data.isSelectize) == "true" );
                    $element.val('');

                    if( isSelectize ){
                        selectize.clear($element);
                        return;
                    }

                });

            })
        },
        /**
         * This function attaches the on click logic to get email for saved template
         */
        attachGenerateMailFromTemplateEvent:function(){
            let elementsToHandle = $("[" + events.attributes.data.ajax.generateMailFromTemplate + "=true]");

            $.each(elementsToHandle, (index, element) => {
                let $element = $(element);

                $element.off("click");
                $element.on("click", (event) => {

                    let $clickedElement = $(event.currentTarget);
                    let ajaxUrl         = $clickedElement.attr(events.attributes.data.buttons.ajaxUrl);
                    let ajaxMethod      = $clickedElement.attr(events.attributes.data.buttons.ajaxMethod);

                    if( "undefined" === typeof ajaxUrl ){
                        throw({
                            "message": "Ajax url is missing for generating mail from template",
                            "element": $clickedElement
                        })
                    }

                    if( "undefined" === typeof ajaxMethod ){
                        throw({
                            "message": "Ajax method is missing for generating mail from template",
                            "element": $clickedElement
                        })
                    }

                    let jobOfferUrl     = $(dialogs.selectors.ids.jobOfferUrlForMail).val();
                    let jobOfferHeader  = $(dialogs.selectors.ids.jobOfferHeaderForMail).val();

                    jobOfferUrl     = ( "undefined" === typeof jobOfferUrl      ? "" : jobOfferUrl );
                    jobOfferHeader  = ( "undefined" === typeof jobOfferHeader   ? "" : jobOfferHeader );

                    let data = {
                        "{jobOfferUrl}"     : jobOfferUrl,
                        "{jobOfferHeader}"  : jobOfferHeader,
                    };

                    events.ajaxCalls.buildEmailFromEmailTemplate(ajaxUrl, ajaxMethod, data);
                })


            })
        },
    },
    /**
     * Handle events for forms
     */
    forms: {
        submitViaAjax: function() {
            let _this            = this;
            let allFormsToHandle = $("[" + events.attributes.data.forms.submitViaAjax + "=true]");

            $.each(allFormsToHandle, (index, form) => {
                let $form         = $(form);
                let $submitButton = $form.find("[" + events.attributes.data.forms.elementForSubmitViaAjax + "=true]");

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
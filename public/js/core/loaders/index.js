var loaders = {
    selectors: {
        ids: {
        },
        classes: {
            spinner: ".loading"
        }
    },
    domElements: {
      $spinner: null,
      init   : function(){
        this.$spinner = $(loaders.selectors.ids.spinner);
      }
    },
    spinner: {
        showSpinner: function (){
            loaders.domElements.$spinner.removeClass("hidden");
        },
        hideSpinner: function(){
            loaders.domElements.$spinner.addClass("hidden");
        }
    }
};

$(document).ready(function(){
   loaders.domElements.init() ;
});
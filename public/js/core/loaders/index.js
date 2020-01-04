var loaders = {
    selectors: {
        ids: {
        },
        classes: {
            spinner: ".spinner"
        }
    },
    domElements: {
      $spinner: null,
      init   : function(){
        this.$spinner = $(loaders.selectors.classes.spinner);
      }
    },
    spinner: {
        showSpinner: function (){
            loaders.domElements.$spinner.removeClass("d-none");
        },
        hideSpinner: function(){
            loaders.domElements.$spinner.addClass("d-none");
        }
    }
};

$(document).ready(function(){
   loaders.domElements.init() ;
});
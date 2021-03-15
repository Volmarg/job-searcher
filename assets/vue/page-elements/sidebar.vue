<script lang="ts">
import AjaxResponseDto  from "../../js/core/dto/AjaxResponseDto";
import AjaxContentLoad  from "../../js/core/Ajax/AjaxContentLoad";
import PreconfiguredVue from "../PreconfiguredVue";
import axios            from 'axios';
import SweetAlert       from "../../js/libs/sweetalert/SweetAlert";

PreconfiguredVue.createApp('#sidebar-menu', {
  methods: {
    /**
     * @description will load page content
     */
    loadPageContent(event){

      let clickedHtmlElement = event.currentTarget;
      let url                = clickedHtmlElement.dataset.ajaxHref;
      axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'; // this makes symfony think that this is ajax request

      let pageContentLoadPromise = axios.get(url).then( (response) => {
        let ajaxResponseDto = AjaxResponseDto.fromAxiosResponse(response.data);
        return ajaxResponseDto;
      });

      if( "undefined" !== typeof clickedHtmlElement.dataset.loadInBootbox ){
        SweetAlert.showSimpleAlertForDialogTemplate(pageContentLoadPromise);
      }else{
        pageContentLoadPromise.then( (ajaxResponseDto) => {
          AjaxContentLoad.loadContentIntoMainWrapper(ajaxResponseDto.template);
          AjaxContentLoad.appendAndExecuteScriptsIntoMainWrapper(ajaxResponseDto.scriptsSources);
        })
      }

    }
  },
});
export default{}
</script>
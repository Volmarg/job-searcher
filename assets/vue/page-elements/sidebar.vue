<script lang="ts">
import AjaxResponseDto  from "../../js/core/dto/AjaxResponseDto";
import AjaxContentLoad  from "../../js/core/Ajax/AjaxContentLoad";
import PreconfiguredVue from "../PreconfiguredVue";
import Axios            from "../../js/libs/axios/Axios";
import SweetAlert       from "../../js/libs/sweetalert/SweetAlert";

let axios = Axios.getAxiosInstanceForSymfony();

PreconfiguredVue.createApp('#sidebar-menu', {
  methods: {
    /**
     * @description will load page content
     */
    loadPageContent(event){

      let clickedHtmlElement = event.currentTarget;
      let url                = clickedHtmlElement.dataset.ajaxHref;

      let pageContentLoadPromise = axios.get(url).then( (response) => {
        let ajaxResponseDto = AjaxResponseDto.fromAxiosResponse(response.data);
        return ajaxResponseDto;
      });

      if( "undefined" !== typeof clickedHtmlElement.dataset.loadInBootbox ){
        // SweetAlert.showSimpleAlertForDialogTemplate(pageContentLoadPromise);
        // todo
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
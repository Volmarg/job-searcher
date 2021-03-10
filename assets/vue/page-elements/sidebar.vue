<script lang="ts">
import AjaxResponseDto  from "../../js/core/dto/AjaxResponseDto";
import AjaxContentLoad  from "../../js/core/Ajax/AjaxContentLoad";
import PreconfiguredVue from "../PreconfiguredVue";
import axios            from 'axios';

PreconfiguredVue.createApp('#sidebar-menu', {
  methods: {
    /**
     * @description will load page content
     */
    loadPageContent(event){
      let url = event.currentTarget.dataset.ajaxHref;
      axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'; // this makes symfony think that this is ajax request
      axios.get(url).then( (response) => {
        let ajaxResponseDto = AjaxResponseDto.fromAxiosResponse(response.data);
        AjaxContentLoad.loadContentIntoMainWrapper(ajaxResponseDto.template);
        AjaxContentLoad.appendAndExecuteScriptsIntoMainWrapper(ajaxResponseDto.scriptsSources);
      })
    }
  },
});
export default{}
</script>
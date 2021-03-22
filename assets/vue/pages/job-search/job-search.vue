<script lang="ts">
import PreconfiguredVue    from "../../PreconfiguredVue";
import StringUtils         from "../../../js/core/utils/StringUtils";
import Axios               from "../../../js/libs/axios/Axios";
import SymfonyRoutes       from "../../../js/core/symfony/SymfonyRoutes";
import AjaxResponseDto     from "../../../js/core/dto/AjaxResponseDto";
import SweetAlertComponent from '../../../vue/components/dialog/sweet-alert/sweet-alert';
import NotyfService        from "../../../js/libs/notyf/NotyfService";

let axios = Axios.getAxiosInstanceForSymfony();
let notyf = new NotyfService();

const EMITTED_EVENT_NAME_SAVE_JOB_SEARCH_SETTINGS = "save-job-search-settings";

PreconfiguredVue.createApp('#jobSearchMainContent', {
  data(){
    return {
      isFormValid: false,
    }
  },
  emits: [
    EMITTED_EVENT_NAME_SAVE_JOB_SEARCH_SETTINGS,
  ],
  components: {
    "sweet-alert": SweetAlertComponent
  },
  methods: {
    /**
     * @description will check if the form is valid
     */
    checkIfFormIsValid(): void{
      this.isFormValid = (
             !StringUtils.isEmptyString(this.$refs.urlPatternInput.value)
          && !StringUtils.isEmptyString(this.$refs.pageOffsetReplacePatternInput.value)
          && !StringUtils.isEmptyString(this.$refs.pageOffsetStepsInput.value)
          && !StringUtils.isEmptyString(this.$refs.startPageOffsetInput.value)
          && !StringUtils.isEmptyString(this.$refs.endPageOffsetInput.value)
          && !StringUtils.isEmptyString(this.$refs.bodyQuerySelectrInput.value)
          && !StringUtils.isEmptyString(this.$refs.headerQuerySelectorInput.value)
          && !StringUtils.isEmptyString(this.$refs.linkQuerySelectorInput.value)
          && !StringUtils.isEmptyString(this.$refs.acceptedKeywordsInput.value)
          && !StringUtils.isEmptyString(this.$refs.rejectedKeywordsInput.value)
      );
    },
    /**
     * @description handles the logic upon clicking the `submit` button
     */
    submitButtonClicked(){

    },
    /**
     * @description handles logic upon clicking the `save` button
     */
    saveButtonClicked(){
      this.$refs.saveSearchSettingsDialog.showDialog();
    },
    saveJobSearchSettingsDialogConfirmed(){
      let dataBag = {
        urlPattern               : this.$refs.urlPatternInput.value,
        startPageOffset          : this.$refs.startPageOffsetInput.value,
        endPageOffset            : this.$refs.endPageOffsetInput.value,
        pageOffsetSteps          : this.$refs.pageOffsetStepsInput.value,
        pageOffsetReplacePattern : this.$refs.pageOffsetReplacePatternInput.value,
        bodyQuerySelector        : this.$refs.bodyQuerySelectrInput.value,
        headerQuerySelector      : this.$refs.headerQuerySelectorInput.value,
        linkQuerySelector        : this.$refs.linkQuerySelectorInput.value,
        linksSkippingRegex       : this.$refs.linksSkippingRegexInput.value,
        acceptedKeywords         : this.$refs.acceptedKeywordsInput.value,
        rejectedKeywords         : this.$refs.rejectedKeywordsInput.value,
        name                     : this.$refs.saveSearchSettingsNameInput.value,
      };

      axios.post(SymfonyRoutes.ROUTE_SAVE_JOB_SEARCH_SETTINGS, dataBag).then( (response) => {
        let ajaxResponseDto = AjaxResponseDto.fromAxiosResponse(response.data);
        console.log(ajaxResponseDto);
        if(ajaxResponseDto.success){
          notyf.showGreenNotification(ajaxResponseDto.message);
        }else{
          notyf.showRedNotification(ajaxResponseDto.message);
        }
      });

    }
  }
});


export default{}
</script>
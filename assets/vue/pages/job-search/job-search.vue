<script lang="ts">
import PreconfiguredVue    from "../../PreconfiguredVue";
import StringUtils         from "../../../js/core/utils/StringUtils";
import Axios               from "../../../js/libs/axios/Axios";
import SymfonyRoutes       from "../../../js/core/symfony/SymfonyRoutes";
import SweetAlert          from "../../../js/libs/sweetalert/SweetAlert";
import AjaxResponseDto     from "../../../js/core/dto/AjaxResponseDto";
import SweetAlertComponent from '../../../vue/components/dialog/sweet-alert/sweet-alert';

let axios = Axios.getAxiosInstanceForSymfony();

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
      };

      let getDialogTemplateUrl = SymfonyRoutes.buildRouteWithParameters(SymfonyRoutes.ROUTE_GET_DIALOG_TEMPLATE, {
        [SymfonyRoutes.ROUTE_GET_DIALOG_TEMPLATE_PARAM_TEMPLATE_TYPE]: SymfonyRoutes.DIALOG_TEMPLATE_TYPE_SAVE_SEARCH_SETTINGS,
      })

      let getDialogContentPromise = axios.get(getDialogTemplateUrl).then( (response) => {
        let ajaxResponse = AjaxResponseDto.fromAxiosResponse(response.data);
        return ajaxResponse;
      });

      let dialogConfirmationCallback = () => {
        // axios.post(SymfonyRoutes.ROUTE_SAVE_JOB_SEARCH_SETTINGS, dataBag).then( (response) => {
        //   console.log(response);
        //   // todo
        // })
      }

    },
    saveJobSearchSettingsDialogConfirmed(){
      console.log("confirmed");
    }
  }
});


export default{}
</script>
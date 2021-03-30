<script lang="ts">
import PreconfiguredVue     from "../../PreconfiguredVue";
import StringUtils          from "../../../js/core/utils/StringUtils";
import Axios                from "../../../js/libs/axios/Axios";
import SymfonyRoutes        from "../../../js/core/symfony/SymfonyRoutes";
import AjaxResponseDto      from "../../../js/core/dto/AjaxResponseDto";
import SweetAlertComponent  from '../../../vue/components/dialog/sweet-alert/sweet-alert';
import NotyfService         from "../../../js/libs/notyf/NotyfService";
import JobSearchSettingDto  from "../../../js/core/dto/JobSearchSettingDto";
import TableRowComponent    from "../../../vue/components/dialog/manage-search-settings/table-row"

let axios = Axios.getAxiosInstanceForSymfony();
let notyf = new NotyfService();

PreconfiguredVue.createApp('#jobSearchMainContent', {
  data(){
    return {
      urlPatternInput               : "",
      pageOffsetReplacePatternInput : "",
      linksSkippingRegexInput       : "",
      pageOffsetStepsInput          : "",
      startPageOffsetInput          : "",
      endPageOffsetInput            : "",
      bodyQuerySelectorInput        : "",
      headerQuerySelectorInput      : "",
      linkQuerySelectorInput        : "",
      acceptedKeywordsInput         : "",
      rejectedKeywordsInput         : "",
      isFormValid                   : false,
    }
  },
  components: {
    "sweet-alert" : SweetAlertComponent,
    "table-row"   : TableRowComponent,
  },
  methods: {
    /**
     * @description will check if the form is valid
     */
    checkIfFormIsValid(): void {
      this.isFormValid = (
             !StringUtils.isEmptyString(this.urlPatternInput)
          && !StringUtils.isEmptyString(this.pageOffsetReplacePatternInput)
          && !StringUtils.isEmptyString(this.pageOffsetStepsInput)
          && !StringUtils.isEmptyString(this.startPageOffsetInput)
          && !StringUtils.isEmptyString(this.endPageOffsetInput)
          && !StringUtils.isEmptyString(this.bodyQuerySelectorInput)
          && !StringUtils.isEmptyString(this.headerQuerySelectorInput)
          && !StringUtils.isEmptyString(this.linkQuerySelectorInput)
          && !StringUtils.isEmptyString(this.acceptedKeywordsInput)
          && !StringUtils.isEmptyString(this.rejectedKeywordsInput)
      );
    },
    /**
     * @description handles the logic upon clicking the `submit` button
     */
    submitButtonClicked(): void {

    },
    /**
     * @description handles logic upon clicking the `save` button
     */
    saveButtonClicked(): void {
      this.$refs.saveSearchSettingsDialog.showDialog();
    },
    /**
     * @description handles logic upon clicking the `load` button
     */
    manageButtonClicked(): void {
      this.$refs.manageSearchSettingsDialog.showDialog();
    },
    /**
     * @description handles the logic upon clicking on the removal action in the settings management dialog
     */
    removeSettingInManageDialogClicked(searchSettingId: number){
      let calledUrl = SymfonyRoutes.buildRouteWithParameters(SymfonyRoutes.REMOVE_SEARCH_SETTING, {
        [SymfonyRoutes.REMOVE_SEARCH_SETTING_ID_PARAM]: searchSettingId,
      })

      Axios.getAxiosInstanceForSymfony().post(calledUrl).then( (response) => {
        let ajaxResponse = AjaxResponseDto.fromAxiosResponse(response.data);
        if(ajaxResponse.success){
          notyf.showGreenNotification(ajaxResponse.message);
          this.$refs['searchSettingRow_' + searchSettingId].remove();
        }else{
          notyf.showRedNotification(ajaxResponse.message);
        }
      })
    },
    loadSettingInManageDialogClicked(searchSettingId: number){
      let calledUrl = SymfonyRoutes.buildRouteWithParameters(SymfonyRoutes.LOAD_SEARCH_SETTING, {
        [SymfonyRoutes.LOAD_SEARCH_SETTING_ID_PARAM]: searchSettingId,
      })

      Axios.getAxiosInstanceForSymfony().get(calledUrl).then( (response) => {
        let ajaxResponse     = AjaxResponseDto.fromAxiosResponse(response.data);
        let jobSearchSetting = JobSearchSettingDto.fromAxiosResponse(ajaxResponse.dataBag[AjaxResponseDto.KEY_DATA_BAG_SETTING])

        this.urlPatternInput               = jobSearchSetting.urlPattern;
        this.pageOffsetReplacePatternInput = jobSearchSetting.pageOffsetReplacePattern;
        this.pageOffsetStepsInput          = jobSearchSetting.pageOffsetSteps;
        this.startPageOffsetInput          = jobSearchSetting.startPageOffset;
        this.endPageOffsetInput            = jobSearchSetting.endPageOffset;
        this.bodyQuerySelectorInput        = jobSearchSetting.bodyQuerySelector;
        this.headerQuerySelectorInput      = jobSearchSetting.headerQuerySelector;
        this.linkQuerySelectorInput        = jobSearchSetting.linkQuerySelector;
        this.acceptedKeywordsInput         = jobSearchSetting.acceptedKeywords;
        this.rejectedKeywordsInput         = jobSearchSetting.rejectedKeywords;
        this.linksSkippingRegexInput       = jobSearchSetting.linksSkippingRegex;
      })
    },
    saveJobSearchSettingsDialogConfirmed(): void {
      let dataBag = {
        urlPattern               : this.urlPatternInput,
        startPageOffset          : this.pageOffsetReplacePatternInput,
        endPageOffset            : this.pageOffsetStepsInput,
        pageOffsetSteps          : this.startPageOffsetInput,
        pageOffsetReplacePattern : this.endPageOffsetInput,
        bodyQuerySelector        : this.bodyQuerySelectorInput,
        headerQuerySelector      : this.headerQuerySelectorInput,
        linkQuerySelector        : this.linkQuerySelectorInput,
        linksSkippingRegex       : this.linksSkippingRegexInput,
        acceptedKeywords         : this.acceptedKeywordsInput,
        rejectedKeywords         : this.rejectedKeywordsInput,
        name                     : this.$refs.saveSearchSettingsNameInput.value, //todo: retrieve it also and allow update setting
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
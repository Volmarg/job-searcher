<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DialogsController extends AbstractController {

    const DIALOG_TEMPLATE_SEARCH_SETTINGS       = "dialogs/search-settings.twig";
    const DIALOG_TEMPLATE_SAVE_SEARCH_SETTING   = "dialogs/save-search-settings.twig";
    const DIALOG_TEMPLATE_SEARCH_RESULT_DETAILS = "dialogs/search-result-details.twig";

    const KEY_PARAMS                       = "params";
    const KEY_PARAM_JOB_OFFER_DESCRIPTION  = "jobOfferDescription";
    const KEY_PARAM_JOB_OFFER_LINK         = "jobOfferLink";
    const KEY_PARAM_JOB_OFFER_HEADER       = "jobOfferHeader";
    const KEY_PARAM_JOB_OFFER_REJECTED_KEYWORDS = "jobOfferRejectedKeywords";
    const KEY_PARAM_JOB_OFFER_ACCEPTED_KEYWORDS = "jobOfferAcceptedKeywords";

    const TEMPLATE_TYPE_SEARCH_SETTINGS       = "templateTypeSearchSettings";
    const TEMPLATE_TYPE_SAVE_SEARCH_SETTINGS  = "templateTypeSaveSearchSettings";
    const TEMPLATE_TYPE_SEARCH_RESULT_DETAILS = "templateTypeSearchResultDetails";

    const TWIG_VAR_SEARCH_SETTINGS = "searchSettings";

    /**
     * @var Application $app
     */
    private $app;

    public function __construct(Application $app) {
        $this->app = $app;
    }

    /**
     * @Route("/dialog-template/ajax/load/{templateType}", name="dialog_template_ajax_load_template_type")
     * @param Request $request
     * @param string $templateType
     * @return JsonResponse
     */
    public function getDialogTemplate(Request $request, string $templateType = ""): JsonResponse {

        $template = "";
        $errors   = false;
        $code     = 200;
        $message  = $this->app->getTranslator()->trans("dialogs.messages.success.templateLoadedSuccessfully");

        if( empty($templateType) ){
            $code    = 400;
            $message = $this->app->getTranslator()->trans("dialogs.messages.failure.dialogTypeWasNotProvided");
        }

        try {
            switch($templateType){
                case self::TEMPLATE_TYPE_SEARCH_SETTINGS:
                    $template = $this->getTemplateForSearchSettingsDialog();
                    break;
                case self::TEMPLATE_TYPE_SAVE_SEARCH_SETTINGS:
                    $template = $this->getTemplateForSavingSearchSetting();
                    break;
                case self::TEMPLATE_TYPE_SEARCH_RESULT_DETAILS:
                    $template = $this->getTemplateForSearchResultDetails($request);
                    break;
                default:
                    $code    = 500;
                    $message = $this->app->getTranslator()->trans("dialogs.messages.failure.thisDialogTypeIsNotSupported");
            }
        } catch (Exception $e) {
            $message = $this->app->getTranslator()->trans("dialogs.messages.failure.exception");
            $code    = 500;
        }


        $responseData = [
          ConstantsController::KEY_JSON_RESPONSE_ERROR    => $errors,
          ConstantsController::KEY_JSON_RESPONSE_MESSAGE  => $message,
          ConstantsController::KEY_JSON_RESPONSE_TEMPLATE => $template,
        ];

        $jsonResponse = new JsonResponse($responseData, $code);
        return $jsonResponse;
    }

    private function getTemplateForSearchSettingsDialog(): string {

        $allSearchSettings = $this->app->getRepositories()->searchSettingsRepository()->getAllSearchSettings();
        $templateData      = [
            self::TWIG_VAR_SEARCH_SETTINGS => $allSearchSettings,
        ];
        $templateResponse  = $this->render(self::DIALOG_TEMPLATE_SEARCH_SETTINGS, $templateData);
        $templateString    = $templateResponse->getContent();

        return $templateString;
    }

    private function getTemplateForSavingSearchSetting(){

        $templateData      = [
        ];
        $templateResponse  = $this->render(self::DIALOG_TEMPLATE_SAVE_SEARCH_SETTING, $templateData);
        $templateString    = $templateResponse->getContent();

        return $templateString;
    }

    /**
     * @param Request $request
     * @return false|string
     * @throws Exception
     */
    private function getTemplateForSearchResultDetails(Request $request){

        if( !$request->query->has(self::KEY_PARAMS) ){
            throw new Exception(); //todo
        }

        $paramsString = Utils::newLineToSpacebar(nl2br(trim($request->query->get(self::KEY_PARAMS))));
        $paramsArray  = json_decode($paramsString, true);

        if( !array_key_exists(self::KEY_PARAM_JOB_OFFER_DESCRIPTION, $paramsArray) ){
            throw new Exception(); //todo
        }

        if( !array_key_exists(self::KEY_PARAM_JOB_OFFER_LINK, $paramsArray) ){
            throw new Exception(); //todo
        }

        $jobOfferLink             = $paramsArray[self::KEY_PARAM_JOB_OFFER_LINK];
        $jobOfferHeader           = $paramsArray[self::KEY_PARAM_JOB_OFFER_HEADER];
        $jobOfferDescription      = $paramsArray[self::KEY_PARAM_JOB_OFFER_DESCRIPTION];
        $jobOfferRejectedKeywords = $paramsArray[self::KEY_PARAM_JOB_OFFER_REJECTED_KEYWORDS];
        $jobOfferAcceptedKeywords = $paramsArray[self::KEY_PARAM_JOB_OFFER_ACCEPTED_KEYWORDS];

        $templateData = [
            self::KEY_PARAM_JOB_OFFER_LINK              => $jobOfferLink,
            self::KEY_PARAM_JOB_OFFER_HEADER            => $jobOfferHeader,
            self::KEY_PARAM_JOB_OFFER_DESCRIPTION       => $jobOfferDescription,
            //todo: add a func with checks for this json decode?
            self::KEY_PARAM_JOB_OFFER_REJECTED_KEYWORDS => json_decode(str_replace("'", '"', $jobOfferRejectedKeywords), true),
            self::KEY_PARAM_JOB_OFFER_ACCEPTED_KEYWORDS => json_decode(str_replace("'", '"', $jobOfferAcceptedKeywords), true),
        ];

        $templateResponse  = $this->render(self::DIALOG_TEMPLATE_SEARCH_RESULT_DETAILS, $templateData);
        $templateString    = $templateResponse->getContent();

        return $templateString;
    }
}
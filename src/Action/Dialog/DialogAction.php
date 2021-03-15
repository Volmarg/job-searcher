<?php

namespace App\Action\Dialog;

use App\Controller\Core\AjaxResponse;
use App\Controller\Core\Application;
use App\Controller\Utils;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DialogAction extends AbstractController {

    const DIALOG_TEMPLATE_SEARCH_SETTINGS             = "dialogs/search-settings.twig";
    const DIALOG_TEMPLATE_SAVE_SEARCH_SETTING         = "dialogs/save-search-settings.twig";
    const DIALOG_TEMPLATE_SEARCH_RESULT_DETAILS       = "dialogs/search-result-details.twig";
    const DIALOG_TEMPLATE_GENERATE_MAIL_FROM_TEMPLATE = "dialogs/generate-mail-from-template.twig";

    const KEY_PARAMS                       = "params";
    const KEY_PARAM_JOB_OFFER_DESCRIPTION  = "jobOfferDescription";
    const KEY_PARAM_JOB_OFFER_LINK         = "jobOfferLink";
    const KEY_PARAM_JOB_OFFER_HEADER       = "jobOfferHeader";
    const KEY_PARAM_JOB_OFFER_REJECTED_KEYWORDS = "jobOfferRejectedKeywords";
    const KEY_PARAM_JOB_OFFER_ACCEPTED_KEYWORDS = "jobOfferAcceptedKeywords";
    const KEY_PARAM_IS_AJAX                     = "isAjax";

    const TEMPLATE_TYPE_SEARCH_SETTINGS             = "templateTypeSearchSettings";
    const TEMPLATE_TYPE_SAVE_SEARCH_SETTINGS        = "templateTypeSaveSearchSettings";
    const TEMPLATE_TYPE_SEARCH_RESULT_DETAILS       = "templateTypeSearchResultDetails";
    const TEMPLATE_TYPE_GENERATE_MAIL_FROM_TEMPLATE = "templateTypeGenerateMailFromTemplate";

    const TWIG_VAR_SEARCH_SETTINGS = "searchSettings";

    /**
     * @var Application $app
     */
    private $app;

    public function __construct(Application $app) {
        $this->app = $app;
    }

    /**
     * @Route("/dialog-template/load/{templateType}", name="dialog_template_load_template_type")
     * @param Request $request
     * @param string $templateType
     * @return JsonResponse
     * @throws Exception
     */
    public function getDialogTemplate(Request $request, string $templateType = ""): JsonResponse {

        $message      = $this->app->getTranslator()->trans("dialogs.messages.success.templateLoadedSuccessfully");
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->setSuccess(false);
        $ajaxResponse->setCode(Response::HTTP_OK);
        $ajaxResponse->setMessage($message);

        if( empty($templateType) ){
            $message = $this->app->getTranslator()->trans("dialogs.messages.failure.dialogTypeWasNotProvided");
            $ajaxResponse->setCode(Response::HTTP_BAD_REQUEST);
            $ajaxResponse->setMessage($message);
        }

        $isAJax   = $request->isXmlHttpRequest();
        $template = "";

        try {
            switch($templateType){
                case self::TEMPLATE_TYPE_SEARCH_SETTINGS:
                    $template = $this->getTemplateForSearchSettingsDialog($isAJax);
                    break;
                case self::TEMPLATE_TYPE_SAVE_SEARCH_SETTINGS:
                    $template = $this->getTemplateForSavingSearchSetting($isAJax);
                    break;
                case self::TEMPLATE_TYPE_SEARCH_RESULT_DETAILS:
                    $template = $this->getTemplateForSearchResultDetails($request, $isAJax);
                    break;
                case self::TEMPLATE_TYPE_GENERATE_MAIL_FROM_TEMPLATE:
                    $template = $this->generateMailFromTemplate($request, $isAJax);
                    break;
                default:
                    $message = $this->app->getTranslator()->trans("dialogs.messages.failure.thisDialogTypeIsNotSupported");
                    $ajaxResponse->setCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                    $ajaxResponse->setMessage($message);

                    $this->app->getLogger()->critical($message, [
                        'templateType' => $templateType,
                    ]);
            }
            $ajaxResponse->setTemplate($template);
        } catch (Exception $e) {
            $this->app->logException($e);
            $ajaxResponse->setCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $ajaxResponse->setMessage($message);

            return $ajaxResponse->buildJsonResponse();
        }

        if( $request->isXmlHttpRequest() ){
            return $ajaxResponse->buildJsonResponse();
        }

        $message = "This call is only allowed for ajax!";
        $this->app->getLogger()->critical($message);
        throw new Exception();
    }

    private function getTemplateForSearchSettingsDialog(bool $isAJax): string
    {

        $allSearchSettings = $this->app->getRepositories()->searchSettingsRepository()->getAllSearchSettings();
        $templateData      = [
            self::TWIG_VAR_SEARCH_SETTINGS => $allSearchSettings,
            self::KEY_PARAM_IS_AJAX        => $isAJax
        ];
        $templateResponse  = $this->render(self::DIALOG_TEMPLATE_SEARCH_SETTINGS, $templateData);
        $templateString    = $templateResponse->getContent();

        return $templateString;
    }

    private function getTemplateForSavingSearchSetting(bool $isAJax): string
    {

        $templateData = [
            self::KEY_PARAM_IS_AJAX => $isAJax
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
    private function getTemplateForSearchResultDetails(Request $request, bool $isAjax): string {

        if( !$request->query->has(self::KEY_PARAMS) ){
            $message = $this->app->getTranslator()->trans("request.missingKey") . self::KEY_PARAMS;
            throw new Exception($message);
        }

        $paramsString = Utils::newLineToSpacebar(nl2br(trim($request->query->get(self::KEY_PARAMS))));
        $paramsArray  = json_decode($paramsString, true);

        if( !array_key_exists(self::KEY_PARAM_JOB_OFFER_DESCRIPTION, $paramsArray) ){
            $message = $this->app->getTranslator()->trans("modules.jobSearchResults.missingParamForDetailPage" . self::KEY_PARAM_JOB_OFFER_DESCRIPTION);
            $this->app->getLogger()->critical($message);
            throw new Exception($message , Response::HTTP_BAD_REQUEST);
        }

        if( !array_key_exists(self::KEY_PARAM_JOB_OFFER_LINK, $paramsArray) ){
            $message = $this->app->getTranslator()->trans("modules.jobSearchResults.missingParamForDetailPage" . self::KEY_PARAM_JOB_OFFER_LINK);
            $this->app->getLogger()->critical($message);
            throw new Exception($message , Response::HTTP_BAD_REQUEST);
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
            self::KEY_PARAM_JOB_OFFER_REJECTED_KEYWORDS => json_decode(str_replace("'", '"', $jobOfferRejectedKeywords), true),
            self::KEY_PARAM_JOB_OFFER_ACCEPTED_KEYWORDS => json_decode(str_replace("'", '"', $jobOfferAcceptedKeywords), true),
            self::KEY_PARAM_IS_AJAX                     => $isAjax
        ];

        $templateResponse  = $this->render(self::DIALOG_TEMPLATE_SEARCH_RESULT_DETAILS, $templateData);
        $templateString    = $templateResponse->getContent();

        return $templateString;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function generateMailFromTemplate(Request $request, bool $isAjax): string {
        $allSavedTemplates = $this->app->getRepositories()->mailTemplateRepository()->findAll();

        $templateData = [
            self::KEY_PARAM_IS_AJAX => $isAjax,
            'templates'             => $allSavedTemplates,
        ];

        $templateResponse  = $this->render(self::DIALOG_TEMPLATE_GENERATE_MAIL_FROM_TEMPLATE, $templateData);
        $templateString    = $templateResponse->getContent();

        return $templateString;
    }
}
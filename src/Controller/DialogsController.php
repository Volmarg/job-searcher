<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DialogsController extends AbstractController {

    const DIALOG_TEMPLATE_SEARCH_SETTINGS     = "dialogs/search-settings.twig";
    const DIALOG_TEMPLATE_SAVE_SEARCH_SETTING = "dialogs/save-search-settings.twig";

    const TEMPLATE_TYPE_SEARCH_SETTINGS      = "templateTypeSearchSettings";
    const TEMPLATE_TYPE_SAVE_SEARCH_SETTINGS = "templateTypeSaveSearchSettings";

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
     * @param string $templateType
     * @return JsonResponse
     */
    public function getDialogTemplate(string $templateType = ""): JsonResponse {

        $template = "";
        $errors   = false;
        $code     = 200;
        $message  = $this->app->getTranslator()->trans("dialogs.messages.success.templateLoadedSuccessfully");

        if( empty($templateType) ){
            $code    = 400;
            $message = $this->app->getTranslator()->trans("dialogs.messages.failure.dialogTypeWasNotProvided");
        }

        switch($templateType){
            case self::TEMPLATE_TYPE_SEARCH_SETTINGS:
                $template = $this->getTemplateForSearchSettingsDialog();
                break;
            case self::TEMPLATE_TYPE_SAVE_SEARCH_SETTINGS:
                $template = $this->getTemplateForSavingSearchSetting();
                break;
            default:
                $code    = 500;
                $message = $this->app->getTranslator()->trans("dialogs.messages.failure.thisDialogTypeIsNotSupported");
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

}
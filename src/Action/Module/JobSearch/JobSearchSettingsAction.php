<?php

namespace App\Action\Module\JobSearch;

use App\Controller\Core\AjaxResponse;
use App\Controller\Core\Application;
use App\Controller\Core\ConstantsController;
use App\Services\Form\FormService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TypeError;

/**
 * This class is responsible for handling the logic of loading/saving search settings
 * Class DecisionController
 * @package App\Controller\Logic
 */
class JobSearchSettingsAction extends AbstractController
{

    const KEY_REQUEST_ID    = "id";
    const KEY_REQUEST_NAME  = "name";
    const KEY_SETTING       = "setting";

    /**
     * @var Application $app
     */
    private $app;

    /**
     * @var FormService $formService
     */
    private FormService $formService;

    public function __construct(Application $app, FormService $formService) {
        $this->app         = $app;
        $this->formService = $formService;
    }

    /**
     * This function handles saving new/updating existing record in DB via ajax call
     * @Route("/search-settings/ajax/save", name="search_settings_ajax_save", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function ajaxSaveSettings(Request $request): JsonResponse {

        try{
            $dataArray = json_decode($request->getContent(), true);
            if( JSON_ERROR_NONE !== json_last_error() ){
                $this->app->getLogger()->critical("Data provided in the request is malformed", [
                    "requestContent" => $request->getContent(),
                ]);

                $message = $this->app->getTranslator()->trans('request.malformedData');
                return (new AjaxResponse($message, false, Response::HTTP_BAD_REQUEST))->buildJsonResponse();
            }

            $id   = $dataArray[self::KEY_REQUEST_ID]   ?? "";
            $name = $dataArray[self::KEY_REQUEST_NAME] ?? "";

            $jobScrappingForm = $this->app->getForms()->getJobSearchScrappingForm();
            $this->formService->handlePostFormForAxiosCall($jobScrappingForm, $request);

            if( !empty($id) ) {
                $searchSetting = $this->app->getRepositories()->searchSettingsRepository()->find($id);

                if( empty($searchSetting) ){
                    $message = $this->app->getTranslator()->trans("searchSetting.save.failure.noSearchSettingForId");
                    $this->app->getLogger()->critical($message, [
                        "id" => $id,
                    ]);
                    return (new AjaxResponse($message, false, Response::HTTP_BAD_REQUEST))->buildJsonResponse();
                }

            } elseif( $jobScrappingForm->isSubmitted() && $jobScrappingForm->isValid() ) {
                $searchSetting = $jobScrappingForm->getData();
            }else{
                $message = $this->app->getTranslator()->trans('badRequest');
                $this->app->getLogger()->critical($message, [
                    "information" => "Form data is probably corrupted",
                    "formErrors"  => $jobScrappingForm->getErrors(),
                ]);
                return (new AjaxResponse($message, false, Response::HTTP_BAD_REQUEST))->buildJsonResponse();
            }

            if( empty($name) ){
                $message = $this->app->getTranslator()->trans("searchSetting.save.failure.nameMissing");
                $this->app->getLogger()->critical($message);
                return (new AjaxResponse($message, false, Response::HTTP_BAD_REQUEST))->buildJsonResponse();
            }

            $searchSetting->setName($name);
            $message = $this->app->getTranslator()->trans("searchSetting.save.success");

            $this->app->getRepositories()->searchSettingsRepository()->saveSettings($searchSetting);

            return (new AjaxResponse($message, true, Response::HTTP_OK))->buildJsonResponse();
        }catch(Exception| TypeError $e){
            $this->app->logException($e);
            $message = $this->app->getTranslator()->trans('internalServerError');
            return (new AjaxResponse($message, true, Response::HTTP_INTERNAL_SERVER_ERROR))->buildJsonResponse();
        }
    }

    /**
     * This function handles loading saved in DB via ajax call
     * @Route("/search-settings/ajax/load/{id}", name="search_settings_ajax_load")
     * @param string $id
     * @return JsonResponse
     */
    public function ajaxLoadSettings(string $id): JsonResponse {

        try{
            $setting = $this->app->getRepositories()->searchSettingsRepository()->find($id);
            $message = $this->app->getTranslator()->trans("searchSetting.load.success");

            if( empty($setting) ){
                $message = $this->app->getTranslator()->trans("searchSetting.load.noEntityForId");
                return (new AjaxResponse($message, false, Response::HTTP_BAD_REQUEST))->buildJsonResponse();
            }

            $ajaxResponse = new AjaxResponse();
            $ajaxResponse->setMessage($message);
            $ajaxResponse->setSuccess(false);
            $ajaxResponse->setCode(Response::HTTP_OK);
            $ajaxResponse->setDataBag([
                self::KEY_SETTING => $setting,
            ]);

            return $ajaxResponse->buildJsonResponse();
        }catch(Exception| TypeError $e){
            $this->app->logException($e);
            $message = $this->app->getTranslator()->trans('internalServerError');
            return (new AjaxResponse($message, true, Response::HTTP_INTERNAL_SERVER_ERROR))->buildJsonResponse();
        }
    }

    /**
     * This function handles removing settings via ajax call
     * @Route("/search-settings/ajax/remove/", name="search_settings_ajax_remove")
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxRemoveSettings(Request $request): JsonResponse {

        if( !$request->request->has(ConstantsController::KEY_REQUEST_IDS) ){
            $message = $this->app->getTranslator()->trans("request.missingKey") . ConstantsController::KEY_REQUEST_IDS;
            return (new AjaxResponse($message, false, Response::HTTP_BAD_REQUEST))->buildJsonResponse();
        }

        try{
            $ids = $request->request->get(ConstantsController::KEY_REQUEST_IDS);
            $this->app->getRepositories()->searchSettingsRepository()->removeSettingsForIds($ids);
        }catch( Exception $e){
            $message = $this->app->getTranslator()->trans("searchSetting.remove.fail.noEntityForId");
            $code    = $e->getCode();
            return (new AjaxResponse($message, false, $code))->buildJsonResponse();
        }

        $message = $this->app->getTranslator()->trans("searchSetting.remove.success");
        return (new AjaxResponse($message, false, Response::HTTP_OK))->buildJsonResponse();
    }

}

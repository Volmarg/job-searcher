<?php

namespace App\Action\Module\JobSearch;

use App\Controller\Core\AjaxResponse;
use App\Controller\Core\Application;
use App\Controller\Core\ConstantsController;
use App\Controller\Utils;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This class is responsible for handling the logic of loading/saving search settings
 * Class DecisionController
 * @package App\Controller\Logic
 */
class JobSearchCriteriaAction extends AbstractController
{

    const KEY_SETTING = "setting";

    /**
     * @var Application $app
     */
    private $app;

    public function __construct(Application $app) {
        $this->app = $app;
    }

    /**
     * This function handles saving new/updating existing record in DB via ajax call
     * @Route("/search-settings/ajax/save", name="search_settings_ajax_save", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function ajaxSaveSettings(Request $request): JsonResponse {

        if( !$request->request->has(ConstantsController::KEY_REQUEST_NAME) ){
            $message = $this->app->getTranslator()->trans("request.missingKey") . ConstantsController::KEY_REQUEST_NAME;
            return (new AjaxResponse($message, false, Response::HTTP_BAD_REQUEST))->buildJsonResponse();
        }

        $id   = $request->request->get(ConstantsController::KEY_REQUEST_ID, "");
        $name = $request->request->get(ConstantsController::KEY_REQUEST_NAME);

        $jobScrappingForm = $this->app->getForms()->getJobSearchScrappingForm();
        $jobScrappingForm->handleRequest($request);

        if( !empty($id) ) {
            $searchSetting = $this->app->getRepositories()->searchSettingsRepository()->find($id);

            if( empty($searchSetting) ){
                $message = $this->app->getTranslator()->trans("searchSetting.save.failure.noSearchSettingForId");
                return (new AjaxResponse($message, false, Response::HTTP_BAD_REQUEST))->buildJsonResponse();
            }

        } else {
            $searchSetting = $jobScrappingForm->getData();
        }

        if( empty($name) ){
            $message = $this->app->getTranslator()->trans("searchSetting.save.failure.nameMissing");
            return (new AjaxResponse($message, false, Response::HTTP_BAD_REQUEST))->buildJsonResponse();
        }

        $searchSetting->setName($name);
        $message = $this->app->getTranslator()->trans("searchSetting.save.success");

        $this->app->getRepositories()->searchSettingsRepository()->saveSettings($searchSetting);

        return (new AjaxResponse($message, true, Response::HTTP_OK))->buildJsonResponse();
    }

    /**
     * This function handles loading saved in DB via ajax call
     * @Route("/search-settings/ajax/load/{id}", name="search_settings_ajax_load")
     * @param string $id
     * @return JsonResponse
     */
    public function ajaxLoadSettings(string $id): JsonResponse {
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
        }catch( \Exception $e){
            $message = $this->app->getTranslator()->trans("searchSetting.remove.fail.noEntityForId");
            $code    = $e->getCode();
            return (new AjaxResponse($message, false, $code))->buildJsonResponse();
        }

        $message = $this->app->getTranslator()->trans("searchSetting.remove.success");
        return (new AjaxResponse($message, false, Response::HTTP_OK))->buildJsonResponse();
    }

}

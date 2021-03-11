<?php

namespace App\Action\Module\JobSearch;

use App\Controller\Core\Application;
use App\Controller\Core\ConstantsController;
use App\Controller\Utils;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This class is responsible for handling the logic of loading/saving search settings
 * Class DecisionController
 * @package App\Controller\Logic
 */
class JobSearchCriteriaAction extends AbstractController
{

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
            return Utils::buildAjaxResponse($message, true, 500);
        }

        $id   = $request->request->get(ConstantsController::KEY_REQUEST_ID, "");
        $name = $request->request->get(ConstantsController::KEY_REQUEST_NAME);

        $jobScrappingForm = $this->app->getForms()->getJobSearchScrappingForm();
        $jobScrappingForm->handleRequest($request);

        if( !empty($id) ) {
            $searchSetting = $this->app->getRepositories()->searchSettingsRepository()->find($id);

            if( empty($searchSetting) ){
                $message = $this->app->getTranslator()->trans("searchSetting.save.failure.noSearchSettingForId");
                return Utils::buildAjaxResponse($message, true, 500);
            }

        } else {
            $searchSetting = $jobScrappingForm->getData();
        }

        if( empty($name) ){
            $message = $this->app->getTranslator()->trans("searchSetting.save.failure.nameMissing");
            return Utils::buildAjaxResponse($message, true, 400);
        }

        $searchSetting->setName($name);
        $message = $this->app->getTranslator()->trans("searchSetting.save.success");

        $this->app->getRepositories()->searchSettingsRepository()->saveSettings($searchSetting);

        return Utils::buildAjaxResponse($message, false, 200);
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
            return Utils::buildAjaxResponse($message, true, 400);
        }

        return Utils::buildAjaxResponse($message, false, 200, $setting);
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
            return Utils::buildAjaxResponse($message, true, 400);
        }

        try{
            $ids = $request->request->get(ConstantsController::KEY_REQUEST_IDS);
            $this->app->getRepositories()->searchSettingsRepository()->removeSettingsForIds($ids);
        }catch( \Exception $e){
            $message = $this->app->getTranslator()->trans("searchSetting.remove.fail.noEntityForId");
            $code    = $e->getCode();
            return Utils::buildAjaxResponse($message, true, $code);
        }

        $message = $this->app->getTranslator()->trans("searchSetting.remove.success");
        return Utils::buildAjaxResponse($message, false, 200);
    }

}

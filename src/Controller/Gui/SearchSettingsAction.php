<?php

namespace App\Controller\Gui;

use App\Controller\Application;
use App\Controller\ConstantsController;
use App\Controller\Logic\JobOffer\JobOfferScrappingController;
use App\Entity\SearchSetting;
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
class SearchSettingsAction extends AbstractController
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
     * @Route("search-settings/ajax/save/{?id}" name="search_settings_ajax_save")
     * @param Request $request
     * @param string|null $id
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function ajaxSaveSettings(Request $request, ?string $id) {
        $ajaxScrapDataRequestDTO = JobOfferScrappingController::buildAjaxScrapDataRequestDTOFromRequest($request);

        if( !empty($id) ) {
            $setting = $this->app->getRepositories()->searchSettingsRepository()->find($id);
        } else {
            $setting = new SearchSetting();
        }

        $rejectedKeywords         = $ajaxScrapDataRequestDTO->getRejectedKeywords();
        $acceptedKeywords         = $ajaxScrapDataRequestDTO->getAcceptedKeywords();
        $regexForLinksScrapping   = $ajaxScrapDataRequestDTO->getRegexForLinksSkipping();
        $headerQuerySelector      = $ajaxScrapDataRequestDTO->getHeaderQuerySelector();
        $bodyQuerySelector        = $ajaxScrapDataRequestDTO->getBodyQuerySelector();
        $linkQuerySelector        = $ajaxScrapDataRequestDTO->getLinkQuerySelector();
        $urlPattern               = $ajaxScrapDataRequestDTO->getUrlPattern();
        $pageOffsetReplacePattern = $ajaxScrapDataRequestDTO->getPageOffsetReplacePattern();
        $pageOffsetSteps          = $ajaxScrapDataRequestDTO->getPageOffsetSteps();
        $startPageOffset          = $ajaxScrapDataRequestDTO->getStartPageOffset();
        $endPageOffset            = $ajaxScrapDataRequestDTO->getEndPageOffset();

        $setting->setRejectedKeywords($rejectedKeywords);
        $setting->setAcceptedKeywords($acceptedKeywords);
        $setting->setHeaderQuerySelector($headerQuerySelector);
        $setting->setBodyQuerySelector($bodyQuerySelector);
        $setting->setLinkQuerySelector($linkQuerySelector);
        $setting->setUrlPattern($urlPattern);
        $setting->setPageOffsetReplacePattern($pageOffsetReplacePattern);
        $setting->setPageOffsetSteps($pageOffsetSteps);
        $setting->setStartPageOffset($startPageOffset);
        $setting->setEndPageOffset($endPageOffset);
        $setting->setLinksSkippingRegex($regexForLinksScrapping);

        $this->app->getRepositories()->searchSettingsRepository()->saveSettings($setting);
    }

    /**
     * This function handles loading saved in DB via ajax call
     * @Route("search-settings/ajax/load/{id}", name="search_settings_ajax_load")
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function ajaxLoadSettings(Request $request, string $id): JsonResponse {
        $setting = $this->app->getRepositories()->searchSettingsRepository()->find($id);
        $message = $this->app->getTranslator()->trans("searchSetting.load.success");
        $error   = false;
        $code    = 200;

        if( !empty($setting) ){
            $message = $this->app->getTranslator()->trans("searchSetting.load.noEntityForId");
            $error   = true;
            $code    = 400;
        }

        $responseData = [
            ConstantsController::KEY_JSON_RESPONSE_MESSAGE        => $message,
            ConstantsController::KEY_JSON_RESPONSE_ERROR          => $error,
            ConstantsController::KEY_JSON_RESPONSE_SEARCH_SETTING => $setting
        ];

        $jsonResponse = new JsonResponse($responseData,$code);
        return $jsonResponse;
    }

    /**
     * This function handles removing settings via ajax call
     * @Route("search-settings/ajax/remove/{id}" name="search_settings_ajax_remove")
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function ajaxRemoveSettings(Request $request, string $id): JsonResponse {

        $error = false;
        $code  = 200;
        $message = $this->app->getTranslator()->trans("searchSetting.remove.success");

        try{
            $this->app->getRepositories()->searchSettingsRepository()->removeSettingForId($id);
        }catch( \Exception $e){
            $error   = true;
            $message = $this->app->getTranslator()->trans("searchSettings.remove.fail.noEntityForId");
            $code    = $e->getCode();
        }

        $responseData = [
            ConstantsController::KEY_JSON_RESPONSE_ERROR   => $error,
            ConstantsController::KEY_JSON_RESPONSE_MESSAGE => $message,
        ];

        $jsonResponse = new JsonResponse($responseData, $code);

        return $jsonResponse;
    }

}
<?php

namespace App\Controller\Gui;

use App\Controller\Application;
use App\Controller\ConstantsController;
use App\Controller\Logic\JobOffer\JobOfferScrappingController;
use App\Controller\Logic\JobOffer\ScrappingController;
use App\Controller\Logic\JobOffer\DomCrawlerController;
use App\DTO\JobOfferDataDTO;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This class handles the pages displaying and responds to performed actions
 * Class DashboardController
 * @package App\Controller\Gui
 */
class JobOfferScrappingAction extends AbstractController
{
    const MAIN_PAGE_TWIG_TPL            = "dashboard/index.html.twig"; //todo: change
    const TEMPLATE_JOB_SEARCH_RESULTS   = "modules/job-search/job-search-results.twig";

    const TEMPLATE_VAR_JOB_OFFER_DATA_DTOS = "jobOfferDataDtos";

    /**
     * @var ScrappingController $scrappingController
     */
    private $scrappingController;

    /**
     * @var DomCrawlerController $domCrawlerController
     */
    private $domCrawlerController;

    /**
     * @var JobOfferScrappingController $jobOfferScrappingController
     */
    private $jobOfferScrappingController;

    /**
     * @var Application $app
     */
    private $app;

    public function __construct(
        ScrappingController         $scrappingController,
        DomCrawlerController        $textFilterController,
        JobOfferScrappingController $jobOfferScrappingController,
        Application                 $app
    ) {
        $this->app                          = $app;
        $this->scrappingController          = $scrappingController;
        $this->domCrawlerController         = $textFilterController;
        $this->jobOfferScrappingController  = $jobOfferScrappingController;

    }

    /**
     * @Route("/", name="dashboard")
     */
    public function index()
    {
        $jobOfferScrappingForm = $this->app->getForms()->getJobOfferScrappingForm();
        $searchSettings        = $this->app->getRepositories()->searchSettingsRepository()->findAll();

        $data = [
            "jobOfferScrappingForm" => $jobOfferScrappingForm->createView(),
            "searchSettings"        => $searchSettings,
        ];



        return $this->render(self::MAIN_PAGE_TWIG_TPL, $data);
    }

    /**
     * This function handles the scrapping logic for ajax call
     * @Route("/ajax/scrap-data-for-request", name="ajax_scrap_data_for_request")
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function ajaxScrapData(Request $request) {

        $templateString = '';
        $error          = false;
        $message        = $this->app->getTranslator()->trans("ajaxScrapData.status.success");
        $code           = 200;

        try {
            $ajaxScrapDataRequestDTO               = $this->jobOfferScrappingController->buildAjaxScrapDataRequestDTOFromRequest($request);
            $searchResultsLinks                    = $this->scrappingController->buildLinksForScrappingFromAjaxScrapDataRequest($ajaxScrapDataRequestDTO);

            $jobSearchRequestsDtosForSearchResults = $this->scrappingController->buildJobSearchRequestDtosFromLinks($searchResultsLinks);
            $jobSearchResponseDtosForSearchResults = $this->scrappingController->scrapDataForWebsites($jobSearchRequestsDtosForSearchResults);

            $this->domCrawlerController->setParamsFromAjaxScrapDataRequestDto($ajaxScrapDataRequestDTO);

            $directJobOfferPagesLinks           = $this->domCrawlerController->getLinksFromJobSearchResponseDtos($jobSearchResponseDtosForSearchResults);

            $jobSearchRequestsDtosForOfferPages = $this->scrappingController->buildJobSearchRequestDtosFromLinks($directJobOfferPagesLinks);
            $jobSearchResponseDtosForOfferPages = $this->scrappingController->scrapDataForWebsites($jobSearchRequestsDtosForOfferPages);

            $jobOfferDataDtos = $this->jobOfferScrappingController->buildJobOfferDataDtosFromJobSearchResponseDtos($jobSearchResponseDtosForOfferPages);
            $jobOfferDataDtos = $this->jobOfferScrappingController->searchForKeywordsInJobOffersDataDtos($jobOfferDataDtos, $ajaxScrapDataRequestDTO);
            $jobOfferDataDtos = $this->jobOfferScrappingController->markKeywordsInJobOffersDataDtos($jobOfferDataDtos);
            $jobOfferDataDtos = $this->jobOfferScrappingController->makeDecisionsForJobOffersDataDtos($jobOfferDataDtos);

            $templateString = $this->renderJobOfferScrappingResultTemplate($jobOfferDataDtos);
        } catch (Exception $e){
            $error   = true;
            $code    = $e->getCode();
            $message = $this->app->getTranslator()->trans("ajaxScrapData.status.failure.exception");
        }

        $responseData = [
            ConstantsController::KEY_JSON_RESPONSE_TEMPLATE => $templateString,
            ConstantsController::KEY_JSON_RESPONSE_ERROR    => $error,
            ConstantsController::KEY_JSON_RESPONSE_CODE     => $code,
            ConstantsController::KEY_JSON_RESPONSE_MESSAGE  => $message,
        ];

        $jsonResponse = new JsonResponse($responseData, 200);

        return $jsonResponse;
    }

    /**
     * @param JobOfferDataDTO[] $jobOfferDataDtos
     * @return string
     */
    private function renderJobOfferScrappingResultTemplate(array $jobOfferDataDtos): string {

        $templateData =[
            self::TEMPLATE_VAR_JOB_OFFER_DATA_DTOS => $jobOfferDataDtos
        ];

        $template = $this->render(self::TEMPLATE_JOB_SEARCH_RESULTS, $templateData);
        $templateString = $template->getContent();

        return $templateString;
    }

}

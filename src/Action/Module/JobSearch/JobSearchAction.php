<?php

namespace App\Action\Module\JobSearch;

use App\Controller\Core\AjaxResponse;
use App\Controller\Core\Application;
use App\Controller\Core\ConstantsController;
use App\Controller\Module\JobSearch\ToRework\JobSearchScrappingController;
use App\Controller\Module\JobSearch\ToRework\ScrappingController;
use App\Controller\Module\JobSearch\JobSearchDomCrawlerController;
use App\DTO\JobOfferDataDTO;
use App\Services\Encore\EncoreService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This class handles the pages displaying and responds to performed actions
 * Class DashboardController
 * @package App\Controller\Gui
 */
class JobSearchAction extends AbstractController
{
    const TEMPLATE_JOB_SEARCH         = "modules/job-search/job-search.twig";
    const TEMPLATE_JOB_SEARCH_RESULTS = "modules/job-search/ajax-calls/job-search-results.twig";

    const TEMPLATE_VAR_JOB_OFFER_DATA_DTOS = "jobOfferDataDtos";

    /**
     * @var ScrappingController $scrappingController
     */
    private $scrappingController;

    /**
     * @var JobSearchDomCrawlerController $domCrawlerController
     */
    private $domCrawlerController;

    /**
     * @var JobSearchScrappingController $jobOfferScrappingController
     */
    private $jobOfferScrappingController;

    /**
     * @var Application $app
     */
    private $app;

    /**
     * @var EncoreService $encoreService
     */
    private EncoreService $encoreService;

    public function __construct(
        ScrappingController             $scrappingController,
        JobSearchDomCrawlerController   $textFilterController,
        JobSearchScrappingController    $jobOfferScrappingController,
        Application                     $app,
        EncoreService                   $encoreService
    ) {
        $this->app                          = $app;
        $this->encoreService                = $encoreService;
        $this->scrappingController          = $scrappingController;
        $this->domCrawlerController         = $textFilterController;
        $this->jobOfferScrappingController  = $jobOfferScrappingController;
    }

    /**
     * This function displays the job searching page
     * @Route("/", name="job_search")
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Request $request): Response
    {
        $ajaxResponse = new AjaxResponse();
        $isAjax       = $request->isXmlHttpRequest();

        try{
            $jobOfferScrappingForm = $this->app->getForms()->getJobSearchScrappingForm();
            $searchSettings        = $this->app->getRepositories()->searchSettingsRepository()->findAll();

            $templateData = [
                "jobOfferScrappingForm" => $jobOfferScrappingForm->createView(),
                "searchSettings"        => $searchSettings,
                "isAjax"                => $isAjax,
            ];

            $scriptSources = $this->encoreService->getJsChunkFileLocationForChunkName(EncoreService::CHUNK_PAGE_JOB_SEARCH);

            if( !$request->isXmlHttpRequest() ){
                $templateData['scriptsSources'] = [$scriptSources];
            }

            $renderedView = $this->render(self::TEMPLATE_JOB_SEARCH, $templateData);

            if( $isAjax ){
                $viewContent  = $renderedView->getContent();
                $ajaxResponse->setCode(Response::HTTP_OK);
                $ajaxResponse->setSuccess(true);
                $ajaxResponse->setTemplate($viewContent);
                $ajaxResponse->setScriptSources([$scriptSources]);
                return $ajaxResponse->buildJsonResponse();
            }

            return $renderedView;
        }catch(Exception $e){
            $this->app->logException($e);

            if($isAjax){
                $ajaxResponse->setCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                $ajaxResponse->setSuccess(false);
                return $ajaxResponse->buildJsonResponse();
            }
            throw $e;
        }

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
            $jobOfferDataDtos = $this->jobOfferScrappingController->searchForEmailsInJobOffersDataDtos($jobOfferDataDtos);
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
     * This function returns the content of template containing job search results
     * @param JobOfferDataDTO[] $jobOfferDataDtos
     * @return string
     */
    private function renderJobOfferScrappingResultTemplate(array $jobOfferDataDtos): string {

        $templateData =[
            self::TEMPLATE_VAR_JOB_OFFER_DATA_DTOS => $jobOfferDataDtos
        ];

        $template       = $this->render(self::TEMPLATE_JOB_SEARCH_RESULTS, $templateData);
        $templateString = $template->getContent();

        return $templateString;
    }

}

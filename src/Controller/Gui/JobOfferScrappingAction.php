<?php

namespace App\Controller\Gui;

use App\Controller\Logic\JobOffer\DecisionController;
use App\Controller\Logic\JobOffer\JobOfferScrappingController;
use App\Controller\Logic\JobOffer\KeywordsController;
use App\Controller\Logic\JobOffer\ScrappingController;
use App\Controller\Logic\JobOffer\DomCrawlerController;
use App\DTO\AjaxScrapDataRequestDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This class handles the pages displaying and responds to performed actions
 * Class DashboardController
 * @package App\Controller\Gui
 */
class JobOfferScrappingAction extends AbstractController
{
    const MAIN_PAGE_TWIG_TPL = "dashboard/index.html.twig"; //todo: change

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

    public function __construct(
        ScrappingController         $scrappingController,
        DomCrawlerController        $textFilterController,
        JobOfferScrappingController $jobOfferScrappingController
    ) {
        $this->scrappingController          = $scrappingController;
        $this->domCrawlerController         = $textFilterController;
        $this->jobOfferScrappingController  = $jobOfferScrappingController;
    }

    /**
     * @Route("/", name="dashboard")
     */
    public function index()
    {

        $data = [];

        return $this->render(self::MAIN_PAGE_TWIG_TPL, $data);
    }

    /**
     * This function handles the scrapping logic for ajax call
     * @Route("/ajax/scrapa-data-for-request", name="ajax_scrap_data_for_request")
     * @param Request $request
     * @return array|string[]
     * @throws \ErrorException
     * @throws \Exception
     */
    public function ajaxScrapData(Request $request) {

        $ajaxScrapDataRequestDTO               = JobOfferScrappingController::buildAjaxScrapDataRequestDTOFromRequest($request);
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

        var_dump($jobOfferDataDtos);

        return $directJobOfferPagesLinks;
        //return new JsonResponse($links);
    }

    /**
     * @Route("/tests", name="tests")
     * @throws \ErrorException
     */
    public function tests(){

        $request = new Request();
        $request->request->set(AjaxScrapDataRequestDTO::KEY_END_PAGE_OFFSET, 10);
        $request->request->set(AjaxScrapDataRequestDTO::KEY_START_PAGE_OFFSET,10);
        $request->request->set(AjaxScrapDataRequestDTO::KEY_PAGE_OFFSET_STEPS, 10);
        $request->request->set(AjaxScrapDataRequestDTO::KEY_PAGE_OFFSET_REPLACE_PATTERN, "{test}");
        $request->request->set(AjaxScrapDataRequestDTO::KEY_URL_PATTERN, "https://de.indeed.com/Jobs?q=php+developer&l=Frankfurt+am+Main&start={test}");

        $request->request->set(AjaxScrapDataRequestDTO::KEY_BODY_QUERY_SELECTOR, ".jobsearch-JobComponent-description #jobDescriptionText");
        $request->request->set(AjaxScrapDataRequestDTO::KEY_HEADER_QUERY_SELECTOR, "h3.jobsearch-JobInfoHeader-title");
        $request->request->set(AjaxScrapDataRequestDTO::KEY_LINK_QUERY_SELECTOR, '.result .title .jobtitle ');

        $request->request->set(AjaxScrapDataRequestDTO::KEY_REGEX_FOR_LINKS_SKIPPING, '\/pagead\/');

        $request->request->set(AjaxScrapDataRequestDTO::KEY_ACCEPTED_KEYWORDS, ["php", "css", "js"]);
        $request->request->set(AjaxScrapDataRequestDTO::KEY_REJECTED_KEYWORDS, ["deutsche", "sprache", "c#"]);

        $scrappedData = $this->ajaxScrapData($request);

        var_dump($scrappedData);

        return new Response("");

    }
}

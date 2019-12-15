<?php

namespace App\Controller\Gui;

use App\Controller\Logic\ScrappingController;
use App\Controller\Logic\DomCrawlerController;
use App\DTO\AjaxScrapDataRequestDTO;
use App\DTO\JobOfferDataDTO;
use App\DTO\JobSearchResponseDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This class handles the pages displaying and responds to performed actions
 * Class DashboardController
 * @package App\Controller\Gui
 */
class DashboardController extends AbstractController
{
    const MAIN_PAGE_TWIG_TPL = "dashboard/index.html.twig";

    /**
     * @var ScrappingController $scrappingController
     */
    private $scrappingController;

    /**
     * @var DomCrawlerController $domCrawlerController
     */
    private $domCrawlerController;

    public function __construct(ScrappingController $scrappingController, DomCrawlerController $textFilterController) {
        $this->scrappingController  = $scrappingController;
        $this->domCrawlerController = $textFilterController;
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
     * //todo: add ajax route
     * This function handles the scrapping logic for ajax call
     * @param Request $request
     * @return array|string[]
     * @throws \ErrorException
     */
    public function ajaxScrapData(Request $request) {

        $ajaxScrapDataRequestDTO               = $this->buildAjaxScrapDataRequestDTOFromRequest($request);
        $searchResultsLinks                    = $this->scrappingController->buildLinksForScrappingFromAjaxScrapDataRequest($ajaxScrapDataRequestDTO);

        $jobSearchRequestsDtosForSearchResults = $this->scrappingController->buildJobSearchRequestDtosFromLinks($searchResultsLinks);
        $jobSearchResponseDtosForSearchResults = $this->scrappingController->scrapDataForWebsites($jobSearchRequestsDtosForSearchResults);

        $this->domCrawlerController->setParamsFromAjaxScrapDataRequestDto($ajaxScrapDataRequestDTO);

        $directJobOfferPagesLinks           = $this->domCrawlerController->getLinksFromJobSearchResponseDtos($jobSearchResponseDtosForSearchResults);

        $jobSearchRequestsDtosForOfferPages = $this->scrappingController->buildJobSearchRequestDtosFromLinks($directJobOfferPagesLinks);
        $jobSearchResponseDtosForOfferPages = $this->scrappingController->scrapDataForWebsites($jobSearchRequestsDtosForOfferPages);

        $jobOfferDataDtos = $this->buildJobOfferDataDtosFromJobSearchResponseDtos($jobSearchResponseDtosForOfferPages);

        var_dump($jobOfferDataDtos);

        return $directJobOfferPagesLinks;
        //return new JsonResponse($links);
    }

    /**
     * This function will attempt build ajax request dto from request
     * @param Request $request
     * @return AjaxScrapDataRequestDTO
     */
    private function buildAjaxScrapDataRequestDTOFromRequest(Request $request): AjaxScrapDataRequestDTO {
        $endPageOffset   = 0;
        $startPageOffset = 0;
        $pageOffsetSteps = 0;

        $pageOffsetReplacePattern = '';
        $urlPattern               = '';

        $bodyQuerySelector   = '';
        $headerQuerySelector = '';
        $linkQuerySelector   = '';

        $regexForLinksSkipping = '';

        if( $request->request->has(AjaxScrapDataRequestDTO::KEY_END_PAGE_OFFSET) ) {
            $endPageOffset = $request->request->get(AjaxScrapDataRequestDTO::KEY_END_PAGE_OFFSET);
        }

        if( $request->request->has(AjaxScrapDataRequestDTO::KEY_START_PAGE_OFFSET) ) {
            $startPageOffset = $request->request->get(AjaxScrapDataRequestDTO::KEY_START_PAGE_OFFSET);
        }

        if( $request->request->has(AjaxScrapDataRequestDTO::KEY_PAGE_OFFSET_STEPS) ) {
            $pageOffsetSteps = $request->request->get(AjaxScrapDataRequestDTO::KEY_PAGE_OFFSET_STEPS);
        }

        if( $request->request->has(AjaxScrapDataRequestDTO::KEY_PAGE_OFFSET_REPLACE_PATTERN) ) {
            $pageOffsetReplacePattern = $request->request->get(AjaxScrapDataRequestDTO::KEY_PAGE_OFFSET_REPLACE_PATTERN);
        }

        if( $request->request->has(AjaxScrapDataRequestDTO::KEY_URL_PATTERN) ) {
            $urlPattern = $request->request->get(AjaxScrapDataRequestDTO::KEY_URL_PATTERN);
        }

        if( $request->request->has(AjaxScrapDataRequestDTO::KEY_LINK_QUERY_SELECTOR) ) {
            $linkQuerySelector = $request->request->get(AjaxScrapDataRequestDTO::KEY_LINK_QUERY_SELECTOR);
        }

        if( $request->request->has(AjaxScrapDataRequestDTO::KEY_BODY_QUERY_SELECTOR) ) {
            $bodyQuerySelector = $request->request->get(AjaxScrapDataRequestDTO::KEY_BODY_QUERY_SELECTOR);
        }

        if( $request->request->has(AjaxScrapDataRequestDTO::KEY_HEADER_QUERY_SELECTOR) ) {
            $headerQuerySelector = $request->request->get(AjaxScrapDataRequestDTO::KEY_HEADER_QUERY_SELECTOR);
        }

        if( $request->request->has(AjaxScrapDataRequestDTO::KEY_REGEX_FOR_LINKS_SKIPPING) ) {
            $regexForLinksSkipping = $request->request->get(AjaxScrapDataRequestDTO::KEY_REGEX_FOR_LINKS_SKIPPING);
        }

        $ajaxScrapDataRequestDTO = new AjaxScrapDataRequestDTO();
        $ajaxScrapDataRequestDTO->setEndPageOffset($endPageOffset);
        $ajaxScrapDataRequestDTO->setStartPageOffset($startPageOffset);
        $ajaxScrapDataRequestDTO->setPageOffsetSteps($pageOffsetSteps);
        $ajaxScrapDataRequestDTO->setPageOffsetReplacePattern($pageOffsetReplacePattern);
        $ajaxScrapDataRequestDTO->setUrlPattern($urlPattern);
        $ajaxScrapDataRequestDTO->setLinkQuerySelector($linkQuerySelector);
        $ajaxScrapDataRequestDTO->setBodyQuerySelector($bodyQuerySelector);
        $ajaxScrapDataRequestDTO->setHeaderQuerySelector($headerQuerySelector);
        $ajaxScrapDataRequestDTO->setRegexForLinksSkipping($regexForLinksSkipping);

        return $ajaxScrapDataRequestDTO;
    }

    /**
     * This function will build the @see JobOfferDataDTO
     * @param JobSearchResponseDTO[] $jobSearchResponseDtos
     * @return array
     */
    private function buildJobOfferDataDtosFromJobSearchResponseDtos(array $jobSearchResponseDtos): array {

        $jobOfferDataDtos = [];

        foreach( $jobSearchResponseDtos as $responseDto ){

            $offerLink    = $responseDto->getWebsiteUrl();
            $curlResponse = $responseDto->getCurlResponse();

            $this->domCrawlerController->setText($curlResponse);
            $this->domCrawlerController->initCrawler();

            $offerPageHeader = $this->domCrawlerController->getOfferHeaderFromText();
            $offerPageBody   = $this->domCrawlerController->getOfferBodyFromText(); // todo: is empty

            $jobOfferDataDto = new JobOfferDataDTO();
            $jobOfferDataDto->setOfferLink($offerLink);
            $jobOfferDataDto->setHeader($offerPageHeader);
            $jobOfferDataDto->setDescription($offerPageBody);

            $jobOfferDataDtos[] = $jobOfferDataDto;
        }

        return $jobOfferDataDtos;
    }

    /**
     * @Route("/tests", name="tests")
     * @throws \ErrorException
     */
    public function tests(){

        $request = new Request();
        $request->request->set(AjaxScrapDataRequestDTO::KEY_END_PAGE_OFFSET, 20);
        $request->request->set(AjaxScrapDataRequestDTO::KEY_START_PAGE_OFFSET,10);
        $request->request->set(AjaxScrapDataRequestDTO::KEY_PAGE_OFFSET_STEPS, 10);
        $request->request->set(AjaxScrapDataRequestDTO::KEY_PAGE_OFFSET_REPLACE_PATTERN, "{test}");
        $request->request->set(AjaxScrapDataRequestDTO::KEY_URL_PATTERN, "https://de.indeed.com/Jobs?q=php+developer&l=Frankfurt+am+Main&start={test}");

        $request->request->set(AjaxScrapDataRequestDTO::KEY_BODY_QUERY_SELECTOR, ".jobsearch-JobComponent-description #jobDescriptionText");
        $request->request->set(AjaxScrapDataRequestDTO::KEY_HEADER_QUERY_SELECTOR, "h3.jobsearch-JobInfoHeader-title");
        $request->request->set(AjaxScrapDataRequestDTO::KEY_LINK_QUERY_SELECTOR, '.result .title .jobtitle ');

        $request->request->set(AjaxScrapDataRequestDTO::KEY_REGEX_FOR_LINKS_SKIPPING, '\/pagead\/');

        $scrappedData = $this->ajaxScrapData($request);

        var_dump($scrappedData);

        return new Response("");

    }
}

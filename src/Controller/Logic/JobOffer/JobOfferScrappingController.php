<?php

namespace App\Controller\Logic\JobOffer;

use App\Controller\Application;
use App\DTO\AjaxScrapDataRequestDTO;
use App\DTO\JobOfferDataDTO;
use App\DTO\JobSearchResponseDTO;
use App\Entity\SearchSetting;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * This class handles the pages displaying and responds to performed actions
 * Class DashboardController
 * @package App\Controller\Gui
 */
class JobOfferScrappingController extends AbstractController
{
    const MAIN_PAGE_TWIG_TPL = "dashboard/index.html.twig";

    /**
     * @var DomCrawlerController $domCrawlerController
     */
    private $domCrawlerController;

    /**
     * @var KeywordsController $keywordsController
     */
    private $keywordsController;

    /**
     * @var DecisionController $decisionController
     */
    private $decisionController;

    /**
     * @var Application $app
     */
    private $app;

    public function __construct(
        DomCrawlerController    $textFilterController,
        KeywordsController      $keywordsController,
        DecisionController      $decisionController,
        Application             $app
    ) {
        $this->domCrawlerController = $textFilterController;
        $this->keywordsController   = $keywordsController;
        $this->decisionController   = $decisionController;
        $this->app                  = $app;
    }

    /**
     * This function will attempt build ajax request dto from request
     * @param Request $request
     * @return AjaxScrapDataRequestDTO
     */
    public function buildAjaxScrapDataRequestDTOFromRequest(Request $request): AjaxScrapDataRequestDTO {
        $endPageOffset   = 0;
        $startPageOffset = 0;
        $pageOffsetSteps = 0;

        $pageOffsetReplacePattern = '';
        $urlPattern               = '';

        $bodyQuerySelector   = '';
        $headerQuerySelector = '';
        $linkQuerySelector   = '';

        $regexForLinksSkipping = '';

        $acceptableKeywords = [];
        $rejectableKeywords = [];

        $jobOfferScrappingForm = $this->app->getForms()->getJobOfferScrappingForm();
        $jobOfferScrappingForm->handleRequest($request);
        $searchSetting = $jobOfferScrappingForm->getData();

        if( $searchSetting instanceof SearchSetting ){
            $endPageOffset              = $searchSetting->getEndPageOffset();
            $startPageOffset            = $searchSetting->getStartPageOffset();
            $pageOffsetSteps            = $searchSetting->getPageOffsetSteps();
            $pageOffsetReplacePattern   = $searchSetting->getPageOffsetReplacePattern();
            $urlPattern                 = $searchSetting->getUrlPattern();
            $bodyQuerySelector          = $searchSetting->getBodyQuerySelector();
            $headerQuerySelector        = $searchSetting->getHeaderQuerySelector();
            $linkQuerySelector          = $searchSetting->getLinkQuerySelector();
            $regexForLinksSkipping      = $searchSetting->getLinksSkippingRegex();
            $acceptableKeywords         = $searchSetting->getAcceptedKeywords();
            $rejectableKeywords         = $searchSetting->getRejectedKeywords();
        } else {
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

            if( $request->request->has(AjaxScrapDataRequestDTO::KEY_ACCEPTED_KEYWORDS) ) {
                $acceptableKeywords = $request->request->get(AjaxScrapDataRequestDTO::KEY_ACCEPTED_KEYWORDS);
            }

            if( $request->request->has(AjaxScrapDataRequestDTO::KEY_REJECTED_KEYWORDS) ) {
                $rejectableKeywords = $request->request->get(AjaxScrapDataRequestDTO::KEY_REJECTED_KEYWORDS);
            }
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
        $ajaxScrapDataRequestDTO->setAcceptedKeywords($acceptableKeywords);
        $ajaxScrapDataRequestDTO->setRejectedKeywords($rejectableKeywords);

        return $ajaxScrapDataRequestDTO;
    }


    /**
     * @param JobOfferDataDTO[] $jobOfferDataDtos
     * @param AjaxScrapDataRequestDTO $ajaxScrapDataRequestDTO
     * @return array
     */
    public function searchForKeywordsInJobOffersDataDtos(array $jobOfferDataDtos, AjaxScrapDataRequestDTO $ajaxScrapDataRequestDTO): array {

        foreach( $jobOfferDataDtos as &$jobOfferDataDto ){
            $this->keywordsController->findKeywordsInText($jobOfferDataDto, $ajaxScrapDataRequestDTO);
        }

        return $jobOfferDataDtos;
    }

    /**
     * @param JobOfferDataDTO[] $jobOfferDataDtos
     * @return array
     */
    public function markKeywordsInJobOffersDataDtos(array $jobOfferDataDtos): array {

        foreach( $jobOfferDataDtos as &$jobOfferDataDto ){
            $this->keywordsController->markKeywordsInText($jobOfferDataDto);
        }

        return $jobOfferDataDtos;
    }

    /**
     * @param JobOfferDataDTO[] $jobOfferDataDtos
     * @return array
     */
    public function makeDecisionsForJobOffersDataDtos(array $jobOfferDataDtos): array {

        foreach( $jobOfferDataDtos as &$jobOfferDataDto ){
            $this->decisionController->makeDecision($jobOfferDataDto);
        }

        return $jobOfferDataDtos;
    }

    /**
     * This function will build the @param JobSearchResponseDTO[] $jobSearchResponseDtos
     * @return array
     * @throws \Exception
     * @see JobOfferDataDTO
     */
    public function buildJobOfferDataDtosFromJobSearchResponseDtos(array $jobSearchResponseDtos): array {

        $jobOfferDataDtos = [];

        foreach( $jobSearchResponseDtos as $responseDto ){

            $offerLink    = $responseDto->getWebsiteUrl();
            $curlResponse = $responseDto->getCurlResponse();

            $this->domCrawlerController->setText($curlResponse);
            $this->domCrawlerController->initCrawler();

            $offerPageHeader = $this->domCrawlerController->getOfferHeaderFromText();
            $offerPageBody   = $this->domCrawlerController->getOfferBodyFromText();

            $jobOfferDataDto = new JobOfferDataDTO();
            $jobOfferDataDto->setOfferLink($offerLink);
            $jobOfferDataDto->setHeader($offerPageHeader);
            $jobOfferDataDto->setDescription($offerPageBody);

            $jobOfferDataDtos[] = $jobOfferDataDto;
        }

        return $jobOfferDataDtos;
    }


}

<?php

namespace App\Controller\Module\JobSearch;

use App\Controller\Core\Application;
use App\DTO\AjaxScrapDataRequestDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Crawler;

/**
 * This class handles the logic of getting the data out of the page dom
 * Class TextFilterController
 * @package App\Controller\Logic
 */
class JobSearchDomCrawlerController extends AbstractController
{

    /**
     * @var string $linkQuerySelector
     */
    private $linkQuerySelector = '';

    /**
     * @var string $bodyQuerySelector
     */
    private $bodyQuerySelector = '';

    /**
     * @var string $headerQuerySelector
     */
    private $headerQuerySelector = '';

    /**
     * @var string $regexForLinksSkipping
     */
    private $regexForLinksSkipping = '';

    /**
     * @var string $domainWithProtocol
     */
    private $domainWithProtocol = '';

    /**
     * @var string $text
     */
    private $text = '';

    /**
     * @var Crawler $crawler
     */
    private $crawler;

    /**
     * @var Application $app
     */
    private $app;

    public function setParamsFromAjaxScrapDataRequestDto(AjaxScrapDataRequestDTO $ajaxScrapDataRequestDTO): void{
        $this->linkQuerySelector     = $ajaxScrapDataRequestDTO->getLinkQuerySelector();
        $this->bodyQuerySelector     = $ajaxScrapDataRequestDTO->getBodyQuerySelector();
        $this->headerQuerySelector   = $ajaxScrapDataRequestDTO->getHeaderQuerySelector();
        $this->domainWithProtocol    = $ajaxScrapDataRequestDTO->getDomainWithProtocol();
        $this->regexForLinksSkipping = $ajaxScrapDataRequestDTO->getRegexForLinksSkipping();
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void {
        $this->text = $text;
    }

    public function __construct(Application $app) {
        $this->app = $app;
    }

    /**
     * This function initialize the new Crawler instance
     */
    public function initCrawler(){
        $this->crawler = new Crawler($this->text);
    }

    /**
     * This function will get links for every text in response dto
     * @param array $responseDtos
     * @return array
     * @throws \Exception
     */
    public function getLinksFromJobSearchResponseDtos(array $responseDtos): array {

        $directJobOfferPagesLinks = [];

        foreach($responseDtos as $responseDto ){
            $pageContent = $responseDto->getCurlResponse();

            $this->setText($pageContent);
            $this->initCrawler();

            $links                    = $this->getLinksFromText();
            $directJobOfferPagesLinks = array_merge($directJobOfferPagesLinks, $links);
        }
        $directJobOfferPagesLinks = array_unique($directJobOfferPagesLinks);

        return $directJobOfferPagesLinks;
    }

    /**
     * This function will get the offer body from the text - via query selector
     * @throws \Exception
     */
    public function getOfferBodyFromText(){

        $this->validateCrawler();

        $body           = '';
        $crawlerResults = $this->crawler->filter($this->bodyQuerySelector);

        /**
         * @var \DOMElement $crawlerResult;
         */
        foreach($crawlerResults as $crawlerResult){
            $body = $crawlerResult->nodeValue;
        }

        return $body;
    }

    /**
     * This function will get the offer header from the text - via query selector
     * @throws \Exception
     */
    public function getOfferHeaderFromText(){

        $this->validateCrawler();

        $header         = '';
        $crawlerResults = $this->crawler->filter($this->headerQuerySelector);

        /**
         * @var \DOMElement $crawlerResult;
         */
        foreach($crawlerResults as $crawlerResult){
            $header = strip_tags($crawlerResult->nodeValue);
        }

        return $header;
    }

    /**
     * This function will attempt to extract the links to direct offer page (from search result - based on query selectors)
     * @return array
     * @throws \Exception
     */
    private function getLinksFromText(){
        $this->validateCrawler();

        $links          = [];
        $crawlerResults = $this->crawler->filter($this->linkQuerySelector);

        /**
         * @var \DOMElement $crawlerResult;
         */
        foreach($crawlerResults as $crawlerResult){

            if( !$crawlerResult->hasAttribute("href") ){
                continue;
            }

            $link = $crawlerResult->getAttribute("href");

            if(
                    !empty($this->regexForLinksSkipping)
                &&  preg_match("#{$this->regexForLinksSkipping}#", $link) )
            {
                continue;
            }

            $link    = $this->parseLink($link);
            $links[] = $link;
        }

        return $links;
    }

    /**
     * This function will check if the link has domain in it, if not then will apply it
     * @param string $link
     * @return string
     */
    private function parseLink(string $link): string {

        if( 0 === strpos($link, DIRECTORY_SEPARATOR) ){
            $link = $this->domainWithProtocol . $link;
        }

        return $link;
    }

    /**
     * This function will check if required things are done before scrapping:
     * - is crawler initialized?
     * - is text not empty?
     */
    private function validateCrawler(){

        if( empty($this->crawler) ){
            $message = $this->app->getTranslator()->trans('domCrawlerController.crawlerWasNotInitialized');

            $this->app->getLogger()->critical($message);
            throw new \Exception($message, 500);
        }

    }
}

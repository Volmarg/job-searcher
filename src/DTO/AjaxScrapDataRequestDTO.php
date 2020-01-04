<?php

namespace App\DTO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * This dto is being built from data sent via ajax to backend for further manipulations
 * Class AjaxScrapDataRequestDTO
 * @package App\DTO
 */
class AjaxScrapDataRequestDTO extends AbstractController
{
    const KEY_URL_PATTERN                 = 'urlPattern';

    const KEY_START_PAGE_OFFSET           = 'startPageOffset';
    const KEY_END_PAGE_OFFSET             = 'endPageOffset';

    const KEY_PAGE_OFFSET_STEPS           = 'pageOffsetSteps';

    const KEY_PAGE_OFFSET_REPLACE_PATTERN = 'pageOffsetReplacePattern';

    const KEY_BODY_QUERY_SELECTOR   = "bodyQuerySelector";
    const KEY_HEADER_QUERY_SELECTOR = "headerQuerySelector";
    const KEY_LINK_QUERY_SELECTOR   = "linkQuerySelector";

    const KEY_REGEX_FOR_LINKS_SKIPPING = 'regexForLinksSkipping';

    const KEY_ACCEPTED_KEYWORDS = "acceptedKeywords";
    const KEY_REJECTED_KEYWORDS = "rejectedKeywords";

    /**
     * Url pattern used to build final urls for scrapping
     * @info must contain the same pattern as in $pageOffsetReplacePattern
     * @var string $urlPattern
     */
    private $urlPattern = '';

    /**
     * This string will be used to replace it with the iterated pagination number to build scrappable url
     * @var string
     */
    private $pageOffsetReplacePattern = '';

    /**
     * This value will be used as steps to jump from startOffset to endOffset
     * @var int $pageOffsetSteps
     */
    private $pageOffsetSteps = 0;

    /**
     * This value is used to determine the final offset that will be build by jumping steps from startOffset
     * @var int
     */
    private $endPageOffset = 0;

    /**
     * This value is used to determine the start offset that will be build for jumping steps
     * @var int
     */
    private $startPageOffset = 0;

    /**
     * This selector (like in js) will be used to find element that contain the job offer description in dom
     * @var string $bodyQuerySelector
     */
    private $bodyQuerySelector   = '';

    /**
     * This selector (like in js) will be used to find element that contain the job offer header in dom
     * @var string $headerQuerySelector
     */
    private $headerQuerySelector = '';

    /**
     * This selector (like in js) will be used to find elements that contain link to the job offer (in dom)
     * @var string $linkQuerySelector
     */
    private $linkQuerySelector = '';

    /**
     * This regex (if not empty) will be used to filter the unwanted scrapped links as often on such pages there are
     * sponsored offers which pretty much are repeated on every pagination.
     * @var string $regexForLinksSkipping
     */
    private $regexForLinksSkipping = '';

    /**
     * These are acceptable keywords
     * @var array $acceptedKeywords
     */
    private $acceptedKeywords = [];

    /**
     * These ar rejectable keywords
     * @var array $rejectedKeywords
     */
    private $rejectedKeywords = [];

    /**
     * @return string
     */
    public function getUrlPattern(): string {
        return $this->urlPattern;
    }

    /**
     * @param string $urlPattern
     */
    public function setUrlPattern(string $urlPattern): void {
        $this->urlPattern = $urlPattern;
    }

    /**
     * @return string
     */
    public function getPageOffsetReplacePattern(): string {
        return $this->pageOffsetReplacePattern;
    }

    /**
     * @param string $pageOffsetReplacePattern
     */
    public function setPageOffsetReplacePattern(string $pageOffsetReplacePattern): void {
        $this->pageOffsetReplacePattern = $pageOffsetReplacePattern;
    }

    /**
     * @return int
     */
    public function getPageOffsetSteps(): int {
        return $this->pageOffsetSteps;
    }

    /**
     * @param int $pageOffsetSteps
     */
    public function setPageOffsetSteps(int $pageOffsetSteps): void {
        $this->pageOffsetSteps = $pageOffsetSteps;
    }

    /**
     * @return int
     */
    public function getEndPageOffset(): int {
        return $this->endPageOffset;
    }

    /**
     * @param int $endPageOffset
     */
    public function setEndPageOffset(int $endPageOffset): void {
        $this->endPageOffset = $endPageOffset;
    }

    /**
     * @return int
     */
    public function getStartPageOffset(): int {
        return $this->startPageOffset;
    }

    /**
     * @param int $startPageOffset
     */
    public function setStartPageOffset(int $startPageOffset): void {
        $this->startPageOffset = $startPageOffset;
    }

    /**
     * @return string
     */
    public function getBodyQuerySelector(): string {
        return $this->bodyQuerySelector;
    }

    /**
     * @param string $bodyQuerySelector
     */
    public function setBodyQuerySelector(string $bodyQuerySelector): void {
        $this->bodyQuerySelector = $bodyQuerySelector;
    }

    /**
     * @return string
     */
    public function getHeaderQuerySelector(): string {
        return $this->headerQuerySelector;
    }

    /**
     * @param string $headerQuerySelector
     */
    public function setHeaderQuerySelector(string $headerQuerySelector): void {
        $this->headerQuerySelector = $headerQuerySelector;
    }

    /**
     * @return string
     */
    public function getLinkQuerySelector(): string {
        return $this->linkQuerySelector;
    }

    /**
     * @param string $linkQuerySelector
     */
    public function setLinkQuerySelector(string $linkQuerySelector): void {
        $this->linkQuerySelector = $linkQuerySelector;
    }

    /**
     * @return string
     */
    public function getRegexForLinksSkipping(): string {
        return $this->regexForLinksSkipping;
    }

    /**
     * @param string $regexForLinksSkipping
     */
    public function setRegexForLinksSkipping(string $regexForLinksSkipping): void {
        $this->regexForLinksSkipping = $regexForLinksSkipping;
    }

    public function getDomainWithProtocol($withTrailingSlash = false){
        $protocol = parse_url($this->urlPattern, PHP_URL_SCHEME);
        $host     = parse_url($this->urlPattern, PHP_URL_HOST);

        $domainWithProtocol = $protocol . '://' . $host;

        if( $withTrailingSlash ){
            $domainWithProtocol .= '/';
        }

        return $domainWithProtocol;
    }

    /**
     * @return array
     */
    public function getAcceptedKeywords(): array {
        return $this->acceptedKeywords;
    }

    /**
     * @param array $acceptedKeywords
     */
    public function setAcceptedKeywords(array $acceptedKeywords): void {
        $this->acceptedKeywords = $acceptedKeywords;
    }

    /**
     * @return array
     */
    public function getRejectedKeywords(): array {
        return $this->rejectedKeywords;
    }

    /**
     * @param array $rejectedKeywords
     */
    public function setRejectedKeywords(array $rejectedKeywords): void {
        $this->rejectedKeywords = $rejectedKeywords;
    }

    /**
     * This function will check if the data provided for the DTO is valid
     */
    private function validateAjaxScrapDataRequestDto(){
        //todo: check if patterns in url and offset replace are the same
    }
}

<?php

namespace App\DTO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * This dto is response (result of) scrapping
 * Class JobSearchResponseDTO
 * @package App\DTO
 */
class JobSearchResponseDTO extends AbstractController
{

    const KEY_CURL_RESPONSE = "curlResponse";

    /**
     * Content returned from scrapping
     * @var string $curlResponse
     */
    private $curlResponse = '';

    /**
     * Url of scrapped website
     * @var string $websiteUrl
     */
    private $websiteUrl = '';

    /**
     * @return string
     */
    public function getCurlResponse(): string {
        return $this->curlResponse;
    }

    /**
     * @param string $curlResponse
     */
    public function setCurlResponse(string $curlResponse): void {
        $this->curlResponse = $curlResponse;
    }

    /**
     * @return string
     */
    public function getWebsiteUrl(): string {
        return $this->websiteUrl;
    }

    /**
     * @param string $websiteUrl
     */
    public function setWebsiteUrl(string $websiteUrl): void {
        $this->websiteUrl = $websiteUrl;
    }

}

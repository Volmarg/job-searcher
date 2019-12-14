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
     * @var string $curlResponse
     */
    private $curlResponse = '';

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

}

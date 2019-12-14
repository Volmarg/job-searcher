<?php

namespace App\Services;

use App\DTO\JobSearchRequestDTO;
use App\DTO\JobSearchResponseDTO;
use Curl\Curl;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * This class is a curl decorator for this project usage
 * Class CurlService
 * @package App\Services
 */
class CurlService extends AbstractController
{

    /**
     * @param JobSearchRequestDTO $requestDto
     * @return JobSearchResponseDTO
     * @throws \ErrorException
     */
    public function sendGetRequest(JobSearchRequestDTO $requestDto): JobSearchResponseDTO {

        $url = $requestDto->getWebsiteUrl();

        $curl = new Curl();
        $curl->get($url);

        $curl = $this->setCurlOptsForGetMethodScrapping($curl);

        $curlResponse = $curl->getResponse();

        $responseDto = new JobSearchResponseDTO();
        $responseDto->setCurlResponse($curlResponse);

        return $responseDto;
    }

    /**
     * @param Curl $curl
     * @return Curl
     */
    private function setCurlOptsForGetMethodScrapping(Curl $curl): Curl {
        #Https fixes
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST, false);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
        $curl->setOpt(CURLOPT_FOLLOWLOCATION, true);

        #Keep Session
        $curl->setOpt(CURLOPT_COOKIESESSION, true);
        $curl->setOpt(CURLOPT_COOKIEJAR, 'cookie-name');

        #Could be empty, but cause problems on some hosts
        $curl->setOpt(CURLOPT_COOKIEFILE, '/var/www/ip4.x/file/tmp');

        return $curl;
    }

}

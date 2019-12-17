<?php

namespace App\Services;

use App\Controller\Application;
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
     * @var Application $app
     */
    private $app;

    public function __construct(Application $app) {
        $this->app = $app;
    }

    /**
     * @param JobSearchRequestDTO $requestDto
     * @return JobSearchResponseDTO
     * @throws \ErrorException
     */
    public function sendGetRequest(JobSearchRequestDTO $requestDto): JobSearchResponseDTO {

        $url = $requestDto->getWebsiteUrl();

        $curl = new Curl();
        $curl = $this->setCurlOptsForGetMethodScrapping($curl);

        $curl->get($url);
        $curlResponse = $curl->getResponse();
        $curl->close();

        $responseDto = new JobSearchResponseDTO();
        $responseDto->setCurlResponse($curlResponse);
        $responseDto->setWebsiteUrl($url);

        $this->validateCurlResponse($curlResponse, $url);

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


    /**
     * This function will check if the text used for dom crawling is empty
     * It might be empty, as url can be invalid or something but it needs to be logged then
     * @param string $curlResponse
     * @param string $websiteUrl $text
     */
    private function validateCurlResponse(string $curlResponse, string $websiteUrl): void {

        if( empty($curlResponse) ){
            $message = $this->app->getTranslator()->trans('domCrawlerController.textIsAnEmptyString');

            $this->app->getLogger()->info($message, [
                "pageUrl" => $websiteUrl
            ]);
        }

    }

}

<?php

namespace App\Controller\Logic;

use App\DTO\AjaxScrapDataRequestDTO;
use App\DTO\JobSearchRequestDTO;
use App\DTO\JobSearchResponseDTO;
use App\Services\CurlService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * This class handles the logic of scrapping data from target pages
 * Class ScrappingController
 * @package App\Controller
 */
class ScrappingController extends AbstractController
{

    /**
     * @var CurlService $curlService
     */
    private $curlService;

    public function __construct(CurlService $curlService) {
        $this->curlService = $curlService;
    }

    /**
     * @param array $links
     * @return JobSearchRequestDTO[]
     */
    public function buildJobSearchRequestDtosFromLinks(array $links): array {
        $jobSearchRequestsDtos = [];

        foreach( $links as $link ){
            $jobSearchRequestDto = new JobSearchRequestDTO();
            $jobSearchRequestDto->setWebsiteUrl($link);
            $jobSearchRequestsDtos[] = $jobSearchRequestDto;
        }

        return $jobSearchRequestsDtos;
    }

    /**
     * This function will scrap data from target url
     * @param JobSearchRequestDTO $dto
     * @return JobSearchResponseDTO
     * @throws \ErrorException
     */
    private function scrapDataForWebsite(JobSearchRequestDTO $dto): JobSearchResponseDTO {
        $responseDto = $this->curlService->sendGetRequest($dto);
        return $responseDto;
    }

    /**
     * This function will handle scrapping data for multiple urls
     * @param JobSearchRequestDTO[] $dtos
     * @return JobSearchResponseDTO[]
     * @throws \ErrorException
     */
    public function scrapDataForWebsites(array $dtos): array {

        $responseDtos = [];

        foreach( $dtos as $dto ){
            $responseDto    = $this->scrapDataForWebsite($dto);
            $responseDtos[] = $responseDto;
        }

        return $responseDtos;
    }

    /**
     * This function will build the links that will be used to scrap data from them
     * @param AjaxScrapDataRequestDTO $dto
     * @return string[]
     */
    public function buildLinksForScrappingFromAjaxScrapDataRequest(AjaxScrapDataRequestDTO $dto): array {

        $links = [];

        $endPageOffset   = $dto->getEndPageOffset();
        $startPageOffset = $dto->getStartPageOffset();
        $pageOffsetSteps = $dto->getPageOffsetSteps();

        $pageOffsetReplacePattern = $dto->getPageOffsetReplacePattern();
        $urlPattern               = $dto->getUrlPattern();

        for( $x = $startPageOffset; $x <= $endPageOffset; $x += $pageOffsetSteps )
        {
            $link    = str_replace($pageOffsetReplacePattern, $x, $urlPattern);
            $links[] = $link;
        }

        return $links;
    }

}

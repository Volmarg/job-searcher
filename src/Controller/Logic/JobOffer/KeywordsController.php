<?php

namespace App\Controller\Logic\JobOffer;

use App\DTO\AjaxScrapDataRequestDTO;
use App\DTO\JobOfferDataDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This class handles the logic of searching and marking for given keywords in texts
 * Class KeywordsController
 * @package App\Controller\Logic
 */
class KeywordsController extends AbstractController
{
    /**
     * @param JobOfferDataDTO $jobOfferDataDTO
     * @param AjaxScrapDataRequestDTO $ajaxScrapDataRequestDTO
     * @return JobOfferDataDTO
     */
    public function findKeywordsInText(JobOfferDataDTO $jobOfferDataDTO, AjaxScrapDataRequestDTO $ajaxScrapDataRequestDTO): JobOfferDataDTO {
        $foundAcceptedKeywords = $this->findAcceptedKeywords($jobOfferDataDTO, $ajaxScrapDataRequestDTO);
        $foundRejectedKeywords = $this->findRejectedKeywords($jobOfferDataDTO, $ajaxScrapDataRequestDTO);

        $jobOfferDataDTO->setRejectedKeywords($foundRejectedKeywords);
        $jobOfferDataDTO->setAcceptedKeywords($foundAcceptedKeywords);

        return $jobOfferDataDTO;
    }

    /**
     * @param JobOfferDataDTO $jobOfferDataDTO
     * @return JobOfferDataDTO
     */
    public function markKeywordsInText(JobOfferDataDTO $jobOfferDataDTO){
        $foundAcceptedKeywords = $jobOfferDataDTO->getAcceptedKeywords();
        $foundRejectedKeywords = $jobOfferDataDTO->getRejectedKeywords();

        $body   = $jobOfferDataDTO->getDescription();
        $header = $jobOfferDataDTO->getHeader();

        foreach( $foundRejectedKeywords as $keyword ){
            $replaceWith = "<span class='text-danger font-weight-bold'>{$keyword}</span>";
            $header      = str_ireplace($keyword, $replaceWith, $header);
            $body        = str_ireplace($keyword, $replaceWith, $body);
        }

        foreach( $foundAcceptedKeywords as $keyword ){
            $replaceWith = "<span class='text-success font-weight-bold'>{$keyword}</span>";
            $header      = str_ireplace($keyword, $replaceWith, $header);
            $body        = str_ireplace($keyword, $replaceWith, $body);
        }

        $jobOfferDataDTO->setDescription($body);
        $jobOfferDataDTO->setHeader($header);

        return $jobOfferDataDTO;
    }

    /**
     * @param JobOfferDataDTO $jobOfferDataDTO
     * @param AjaxScrapDataRequestDTO $ajaxScrapDataRequestDTO
     * @return string[]
     */
    private function findRejectedKeywords(JobOfferDataDTO $jobOfferDataDTO, AjaxScrapDataRequestDTO $ajaxScrapDataRequestDTO): array {
        $rejectedKeywords = $ajaxScrapDataRequestDTO->getRejectedKeywords();

        $body = $jobOfferDataDTO->getDescription();
        $head = $jobOfferDataDTO->getHeader();

        $foundRejectedKeywordsInBody = $this->findKeywords($body, $rejectedKeywords);
        $foundRejectedKeywordsInHead = $this->findKeywords($head, $rejectedKeywords);

        $foundRejectedKeywords = array_merge($foundRejectedKeywordsInBody, $foundRejectedKeywordsInHead);
        $foundRejectedKeywords = array_unique($foundRejectedKeywords);

        return $foundRejectedKeywords;
    }

    /**
     * @param JobOfferDataDTO $jobOfferDataDTO
     * @param AjaxScrapDataRequestDTO $ajaxScrapDataRequestDTO
     * @return array
     */
    private function findAcceptedKeywords(JobOfferDataDTO $jobOfferDataDTO, AjaxScrapDataRequestDTO $ajaxScrapDataRequestDTO): array {
        $acceptedKeywords = $ajaxScrapDataRequestDTO->getAcceptedKeywords();

        $body = $jobOfferDataDTO->getDescription();
        $head = $jobOfferDataDTO->getHeader();

        $foundAcceptedKeywordsInBody = $this->findKeywords($body, $acceptedKeywords);
        $foundAcceptedKeywordsInHead = $this->findKeywords($head, $acceptedKeywords);

        $foundAcceptedKeywords = array_merge($foundAcceptedKeywordsInBody, $foundAcceptedKeywordsInHead);
        $foundAcceptedKeywords = array_unique($foundAcceptedKeywords);

        return $foundAcceptedKeywords;
    }

    /**
     * @param string $text
     * @param array $keywords
     * @return array
     */
    private function findKeywords(string $text, array $keywords): array {
        $foundKeywords = [];

        foreach($keywords as $keyword){
            if( stristr($text, $keyword) ){
                $foundKeywords[] = $keyword;
            }
        }

        return $foundKeywords;
    }

}

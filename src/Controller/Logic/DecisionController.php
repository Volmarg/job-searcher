<?php

namespace App\Controller\Logic;

use App\DTO\JobOfferDataDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This class is responsible for handling the logic of decisions which mark offer as proper or not
 * Class DecisionController
 * @package App\Controller\Logic
 */
class DecisionController extends AbstractController
{

    const STATUS_REJECTED           = "REJECTED";
    const STATUS_ACCEPTED           = "ACCEPTED";
    const STATUS_PARTIALLY_ACCEPTED = "PARTIALLY_ACCEPTED";

    const REJECTION_REASON_NO_HEADER                            = "Offer header is empty";
    const REJECTION_REASON_NO_BODY                              = "Offer body is empty";
    const REJECTION_REASON_NO_KEYWORDS_FOUND                    = "No matching keywords were found for this offer";
    const REJECTION_REASON_TO_MANY_REJECTED_KEYWORDS_WERE_FOUND = "To many rejected keywords are present";

    const ACCEPTANCE_REASON_INITIAL = "Initially accepted";

    /**
     * If the percentage of accepted keywords in all found keywords is equal to this value then it will be partially accepted
     * @var int
     */
    private $partialAcceptancePercentThreshold = 70;

    public function makeDecision(JobOfferDataDTO $jobOfferDataDTO): JobOfferDataDTO {
        $jobOfferDataDTO = $this->voteForRejection($jobOfferDataDTO);

        return $jobOfferDataDTO;
    }

    /**
     * By default every offer is set to Accepted so there is need only to check for rejection
     * @param JobOfferDataDTO $jobOfferDataDTO
     * @return JobOfferDataDTO
     */
    private function voteForRejection(JobOfferDataDTO $jobOfferDataDTO): JobOfferDataDTO {

        $isReasonSet = false;

        $header           = $jobOfferDataDTO->getHeader();
        $body             = $jobOfferDataDTO->getDescription();
        $acceptedKeywords = $jobOfferDataDTO->getAcceptedKeywords();
        $rejectedKeywords = $jobOfferDataDTO->getRejectedKeywords();

        $isBody                       = $this->isBody($body);
        $isHeader                     = $this->isHeader($header);
        $isNoKeywordFound             = $this->isNoKeywordFound($acceptedKeywords, $rejectedKeywords);
        $isRejectedKeywordsDomination = $this->isRejectedKeywordsDomination($acceptedKeywords, $rejectedKeywords);

        if( !$isBody ){
            $jobOfferDataDTO->setRejectReason(self::REJECTION_REASON_NO_BODY);
            $isReasonSet = true;
        }

        if( !$isHeader && !$isReasonSet ){
            $jobOfferDataDTO->setRejectReason(self::REJECTION_REASON_NO_HEADER);
            $isReasonSet = true;
        }

        if( $isNoKeywordFound && !$isReasonSet ){
            $jobOfferDataDTO->setRejectReason(self::REJECTION_REASON_NO_KEYWORDS_FOUND);
            $isReasonSet = true;
        }

        if( $isRejectedKeywordsDomination && !$isReasonSet ){
            $jobOfferDataDTO->setRejectReason(self::REJECTION_REASON_TO_MANY_REJECTED_KEYWORDS_WERE_FOUND);
        }

        if( $isReasonSet ){
            $jobOfferDataDTO->setIsRejected(true);
        }

        return $jobOfferDataDTO;
    }

    /**
     * This function checks if the header is present for fetched offer data
     * @param string $header
     * @return bool
     */
    private function isHeader(string $header): bool {
        return !empty($header);
    }

    /**
     * This function checks if the body is present for fetched data
     * @param string $body
     * @return bool
     */
    private function isBody(string $body){
        return !empty($body);
    }

    /**
     * This function checks the percentage amount of rejected/accepted keywords
     * @param array $acceptedKeywords
     * @param array $rejectedKeywords
     * @return bool
     */
    private function isRejectedKeywordsDomination(array $acceptedKeywords, array $rejectedKeywords){
        $rejectedKeywordsCount = count($rejectedKeywords);
        $acceptedKeywordsCount = count($acceptedKeywords);

        $divideBy = ( $acceptedKeywordsCount + $rejectedKeywordsCount );

        if( 0 === $divideBy){
            return false;
        }

        $acceptedKeywordsPercentage = $acceptedKeywordsCount / ( $acceptedKeywordsCount + $rejectedKeywordsCount ) * 100;

        return !( $acceptedKeywordsPercentage >= $this->partialAcceptancePercentThreshold) ;
    }

    /**
     * This function checks if there are any keywords found at all
     * @param array $acceptedKeywords
     * @param array $rejectedKeywords
     * @return bool
     */
    private function isNoKeywordFound(array $acceptedKeywords, array $rejectedKeywords){

        return ( empty($acceptedKeywords) && empty($rejectedKeywords) );
    }

}

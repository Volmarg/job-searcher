<?php


namespace App\DTO;

use App\Controller\Logic\JobOffer\DecisionController;

/**
 * This class contains data of job offer after all filtering and checking keywords
 * Class JobOfferDataDTO
 * @package App\DTO
 */
class JobOfferDataDTO {

    /**
     * @var string $header
     */
    private $header = '';

    /**
     * @var string $description
     */
    private $description = '';

    /**
     * @var string $offerLink
     */
    private $offerLink = '';

    /**
     * @var array $allFoundKeywords
     */
    private $allFoundKeywords = [];

    /**
     * @var array $rejectedKeywords
     */
    private $rejectedKeywords = [];

    /**
     * @var array $acceptedKeywords
     */
    private $acceptedKeywords = [];

    /**
     * @var string $acceptReason
     */
    private $acceptReason = DecisionController::ACCEPTANCE_REASON_INITIAL;

    /**
     * @var string $rejectReason
     */
    private $rejectReason = '';

    /**
     * @var bool $isRejected
     */
    private $isRejected = false;

    /**
     * @var int $rejectionPercentage
     */
    private $rejectionPercentage = 0;

    /**
     * @return string
     */
    public function getHeader(): string {
        return $this->header;
    }

    /**
     * @param string $header
     */
    public function setHeader(string $header): void {
        $this->header = $header;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getOfferLink(): string {
        return $this->offerLink;
    }

    /**
     * @param string $offerLink
     */
    public function setOfferLink(string $offerLink): void {
        $this->offerLink = $offerLink;
    }

    /**
     * @return array
     */
    public function getAllFoundKeywords(): array {
        return $this->allFoundKeywords;
    }

    /**
     * @param array $allFoundKeywords
     */
    public function setAllFoundKeywords(array $allFoundKeywords): void {
        $this->allFoundKeywords = $allFoundKeywords;
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
     * @return string
     */
    public function getAcceptReason(): string {
        return $this->acceptReason;
    }

    /**
     * @param string $acceptReason
     */
    public function setAcceptReason(string $acceptReason): void {
        $this->acceptReason = $acceptReason;
    }

    /**
     * @return string
     */
    public function getRejectReason(): string {
        return $this->rejectReason;
    }

    /**
     * @param string $rejectReason
     */
    public function setRejectReason(string $rejectReason): void {
        $this->rejectReason = $rejectReason;
    }

    /**
     * @return bool
     */
    public function isRejected(): bool {
        return $this->isRejected;
    }

    /**
     * @param bool $isRejected
     */
    public function setIsRejected(bool $isRejected): void {
        $this->isRejected = $isRejected;
    }

    public function isAccepted(): bool {
        return !$this->isRejected;
    }
}
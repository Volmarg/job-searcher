<?php

namespace App\DTO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This dto is request is used for scrapping
 * Class JobSearchRequestDTO
 * @package App\DTO
 */
class JobSearchRequestDTO extends AbstractController
{

    /**
     * @var string
     */
    private $websiteUrl = '';

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

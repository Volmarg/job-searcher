<?php


namespace App\Controller;

use App\Form\JobOfferScrappingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;

class Forms extends AbstractController {

    public function getJobOfferScrappingForm(): FormInterface {
        return $this->createForm(JobOfferScrappingType::class);
    }

}
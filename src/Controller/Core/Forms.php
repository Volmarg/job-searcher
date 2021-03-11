<?php


namespace App\Controller\Core;

use App\Form\Module\JobSearch\JobSearchScrappingForm;
use App\Form\Module\Mail\MailTemplateForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;

class Forms extends AbstractController {

    public function getJobSearchScrappingForm(): FormInterface {
        return $this->createForm(JobSearchScrappingForm::class);
    }

    public function getMailTemplateForm(): FormInterface {
        return $this->createForm(MailTemplateForm::class);
    }

}
<?php


namespace App\Controller\Core;


use App\Entity\Module\Mail\MailTemplate;
use App\Entity\Module\JobSearch\JobSearchSetting;
use App\Repository\Module\Mail\MailTemplateRepository;
use App\Repository\Module\JobSearch\JobSearchSettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Repositories extends AbstractController {

    /**
     * @return JobSearchSettingRepository
     */
    public function searchSettingsRepository() {
        return $this->getDoctrine()->getRepository(JobSearchSetting::class);
    }

    /**
     * @return MailTemplateRepository
     */
    public function mailTemplateRepository(){
        return $this->getDoctrine()->getRepository(MailTemplate::class);
    }

}
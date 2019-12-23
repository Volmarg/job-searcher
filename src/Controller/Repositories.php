<?php


namespace App\Controller;


use App\Entity\MailTemplate;
use App\Entity\SearchSetting;
use App\Repository\MailTemplateRepository;
use App\Repository\SearchSettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Repositories extends AbstractController {

    /**
     * @return SearchSettingRepository
     */
    public function searchSettingsRepository() {
        return $this->getDoctrine()->getRepository(SearchSetting::class);
    }

    /**
     * @return MailTemplateRepository
     */
    public function mailTemplateRepository(){
        return $this->getDoctrine()->getRepository(MailTemplate::class);
    }

}
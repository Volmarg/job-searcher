<?php

namespace App\Controller\Logic\Mail;

use App\Controller\Application;
use App\Entity\MailTemplate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * This class is responsible for handling the logic of loading/saving search settings
 * Class DecisionController
 * @package App\Controller\Logic
 */
class MailTemplateController extends AbstractController
{

    const MAIL_TEMPLATE_VARIABLE_JOB_OFFER_URL    = "{jobOfferUrl}";
    const MAIL_TEMPLATE_VARIABLE_JOB_OFFER_HEADER = "{jobOfferHeader}";

    const AVAILABLE_MAIL_TEMPLATE_VARIABLES = [
        self::MAIL_TEMPLATE_VARIABLE_JOB_OFFER_HEADER,
        self::MAIL_TEMPLATE_VARIABLE_JOB_OFFER_URL
    ];

    /**
     * @var Application $app
     */
    private $app;

    public function __construct(Application $app) {
        $this->app = $app;
    }

    /**
     * @param Request $request
     * @return MailTemplate
     * @throws \Exception
     */
    public function buildMailTemplateEntityFromRequest(Request $request): MailTemplate {

        $mailTemplateForm   = $this->app->getForms()->getMailTemplateForm()->handleRequest($request);
        /**
         * @var $mailTemplate MailTemplate
         */
        $mailTemplate    = $mailTemplateForm->getData();
        $name            = $mailTemplate->getName();
        $description     = $mailTemplate->getDescription();;
        $title           = $mailTemplate->getTitle();

        $missingFieldsNames = [];

        if( empty($name) ){
            $missingFieldsNames[] = MailTemplate::KEY_NAME;
        }

        if( empty($description) ){
            $missingFieldsNames[] = MailTemplate::KEY_DESCRIPTION;
        }

        if( empty($title) ){
            $missingFieldsNames[] = MailTemplate::KEY_TITLE;
        }

        if( !empty($missingFieldsNames) ){
            $missingFieldsNamesString = implode(",", $missingFieldsNames);
            throw new \Exception("There are missing keys in request: {$missingFieldsNamesString}");
        }

        return $mailTemplate;
    }

}

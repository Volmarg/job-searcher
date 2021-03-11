<?php

namespace App\Controller\Module\Mail;

use App\Controller\Core\Application;
use App\Entity\Module\Mail\MailTemplate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;

/**
 * This class is responsible for handling the logic of loading/saving/removing mail templates
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
     * This function builds mail template from request
     * @param FormInterface $mailTemplateForm
     * @return MailTemplate
     * @throws \Exception
     */
    public function buildMailTemplateEntityFromForm(FormInterface $mailTemplateForm): MailTemplate {

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

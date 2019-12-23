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

        $name            = "";
        $title           = "";
        $description     = "";
        $attachmentLinks = "";

        $missingFieldsNames = [];

        if( !$request->request->has(MailTemplate::KEY_NAME) ){
            $missingFieldsNames[] = MailTemplate::KEY_NAME;
        }

        if( !$request->request->has(MailTemplate::KEY_DESCRIPTION) ){
            $missingFieldsNames[] = MailTemplate::KEY_DESCRIPTION;
        }

        if( !$request->request->has(MailTemplate::KEY_TITLE) ){
            $missingFieldsNames[] = MailTemplate::KEY_TITLE;
        }

        if( !$request->request->has(MailTemplate::KEY_ATTACHMENT_LINKS) ){
            $missingFieldsNames[] = MailTemplate::KEY_ATTACHMENT_LINKS;
        }

        if( !empty($missingFieldsNames) ){
            $missingFieldsNamesString = implode(",", $missingFieldsNames);
            throw new \Exception("There are missing keys in request: {$missingFieldsNamesString}");
        }

        $name            = $request->request->get(MailTemplate::KEY_NAME);
        $description     = $request->request->get(MailTemplate::KEY_DESCRIPTION);
        $title           = $request->request->get(MailTemplate::KEY_TITLE);
        $attachmentLinks = $request->request->get(MailTemplate::KEY_ATTACHMENT_LINKS);

        $mailTemplate = new MailTemplate()        ;
        $mailTemplate->setDescription($description);
        $mailTemplate->setName($name);
        $mailTemplate->setTitle($title);
        $mailTemplate->setAttachmentLinks($attachmentLinks);

        return $mailTemplate;
    }

}

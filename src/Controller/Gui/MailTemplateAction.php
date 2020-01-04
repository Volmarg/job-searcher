<?php

namespace App\Controller\Gui;

use App\Controller\Application;
use App\Controller\ConstantsController;
use App\Controller\Logic\Mail\MailTemplateController;
use App\Controller\Utils;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This class is responsible for handling the logic of loading/saving search settings
 * Class DecisionController
 * @package App\Controller\Logic
 */
class MailTemplateAction extends AbstractController
{

    const TWIG_TEMPLATE_SHOW_MANAGEMENT_PAGE = "modules/mail-templates/manage.twig";

    /**
     * @var Application $app
     */
    private $app;

    /**
     * @var MailTemplateController $mailTemplateController
     */
    private $mailTemplateController;

    public function __construct(Application $app, MailTemplateController $mailTemplateController) {
        $this->mailTemplateController = $mailTemplateController;
        $this->app = $app;
    }

    /**
     * This function handles showing the page for creating mail templates
     * @Route("mail-template/ajax/page", name="mail_template_ajax_page")
     * @return JsonResponse
     */
    public function getManagementPageContent(): JsonResponse{

        $allSavedTemplates = $this->app->getRepositories()->mailTemplateRepository()->findAll();

        $form         = $this->app->getForms()->getMailTemplateForm();
        $templateData = [
            'form'              => $form->createView(),
            'templates'         => $allSavedTemplates,
            'templateVariables' => MailTemplateController::AVAILABLE_MAIL_TEMPLATE_VARIABLES
        ];
        $renderedPage = $this->render(self::TWIG_TEMPLATE_SHOW_MANAGEMENT_PAGE, $templateData);
        $pageContent  = $renderedPage->getContent();

        return Utils::buildAjaxResponse('', false, 200, null, $pageContent);
    }

    /**
     * This function handles loading mail template
     * @Route("mail-template/ajax/load/{id}", name="mail_template_ajax_load")
     * @param string $id
     * @return JsonResponse
     */
    public function loadTemplateViaAjax(string $id): JsonResponse {
        $mailTemplate = $this->app->getRepositories()->mailTemplateRepository()->find($id);

        if( empty($mailTemplate) ){
            $message = $this->app->getTranslator()->trans("modules.mailTemplatesManage.load.fail.noTemplateFoundForId");
            return Utils::buildAjaxResponse($message, true, 200);
        }

        $message = $this->app->getTranslator()->trans("modules.mailTemplatesManage.load.success");
        return Utils::buildAjaxResponse($message, false, 200, null, null, $mailTemplate);
    }

    /**
     * This function handles saving mail template
     * @Route("mail-template/ajax/save/{id}", name="mail_template_ajax_save")
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function saveTemplateViaAjax(Request $request, string $id = null): JsonResponse {

        $message = $this->app->getTranslator()->trans("mailTemplate.save.success");
        $code    = 200;
        $error   = false;

        $mailTemplateForm        = $this->app->getForms()->getMailTemplateForm()->handleRequest($request);
        $mailTemplateFromRequest = $this->mailTemplateController->buildMailTemplateEntityFromForm($mailTemplateForm);

        if( empty($id) ){
            $mailTemplate = $mailTemplateFromRequest;
        }else {
            $mailTemplate = $this->app->getRepositories()->mailTemplateRepository()->find($id);

            if( empty($mailTemplate) ){
                $message = $this->app->getTranslator()->trans("mailTemplate.save.fail.noEntity");
                $code    = 500;
                $error   = true;
            }else{
                $attachmentLinks = $mailTemplateFromRequest->getAttachmentLinks();
                $description     = $mailTemplateFromRequest->getDescription();
                $title           = $mailTemplateFromRequest->getTitle();
                $name            = $mailTemplateFromRequest->getName();

                $mailTemplate->setAttachmentLinks($attachmentLinks);
                $mailTemplate->setTitle($title);
                $mailTemplate->setName($name);
                $mailTemplate->setDescription($description);
            }

        }

        if( !empty($mailTemplate) ){
            $this->app->getRepositories()->mailTemplateRepository()->saveMailTemplate($mailTemplate);
        }

        $responseData = [
          ConstantsController::KEY_JSON_RESPONSE_MESSAGE => $message,
          ConstantsController::KEY_JSON_RESPONSE_ERROR   => $error,
        ];

        $jsonResponse = new JsonResponse($responseData, $code);

        return $jsonResponse;
    }

    /**
     * This function handles removing mail template
     * @Route("mail-template/ajax/remove/{id}", name="mail_template_ajax_remove")
     * @param string $id
     * @throws ORMException
     */
    public function removeTemplateViaAjax(string $id): void {
        $this->app->getRepositories()->mailTemplateRepository()->removeMailTemplateForId($id);
    }

    /**
     * This function will build the email from saved email template
     * @Route("mail-template/ajax/generate-mail/{id}", name="mail_template_generate_mail")
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function buildEmailFromTemplate(Request $request, string $id): JsonResponse {
        $jobOfferUrl    = $request->request->get(MailTemplateController::MAIL_TEMPLATE_VARIABLE_JOB_OFFER_URL, "");
        $jobOfferHeader = $request->request->get(MailTemplateController::MAIL_TEMPLATE_VARIABLE_JOB_OFFER_HEADER, "");

        $mailTemplate = $this->app->getRepositories()->mailTemplateRepository()->find($id);

        if( empty($mailTemplate) ){
            $message = $this->app->getTranslator()->trans("modules.mailTemplatesManage.message.fail.noEntity");
            return Utils::buildAjaxResponse($message, true, 200);
        }

        $message         = $this->app->getTranslator()->trans("modules.mailTemplatesManage.message.success.emailGenerated");
        $error           = false;
        $code            = 200;
        $mailTitle       = $this->replaceMailTemplateVariablesWithStrings($mailTemplate->getTitle(), $jobOfferUrl, $jobOfferHeader);
        $mailDescription = $this->replaceMailTemplateVariablesWithStrings($mailTemplate->getDescription(), $jobOfferUrl, $jobOfferHeader);

        $responseData = [
            ConstantsController::KEY_JSON_RESPONSE_MESSAGE          => $message,
            ConstantsController::KEY_JSON_RESPONSE_ERROR            => $error,
            ConstantsController::KEY_JSON_RESPONSE_CODE             => $code,
            ConstantsController::KEY_JSON_RESPONSE_MAIL_DESCRIPTION => $mailDescription,
            ConstantsController::KEY_JSON_RESPONSE_MAIL_TITLE       => strip_tags($mailTitle),
        ];

        $jsonResponse = new JsonResponse($responseData, 200);
        return $jsonResponse;
    }

    /**
     * This function will replace emailTemplate variables in texts with strings
     * @param string $text
     * @param string|null $jobOfferUrl
     * @param string|null $jobOfferHeader
     * @return string
     */
    private function replaceMailTemplateVariablesWithStrings(string $text, ?string $jobOfferUrl = null, ?string $jobOfferHeader = null): string {

        if( !empty($jobOfferUrl) ){
            $text = str_replace(MailTemplateController::MAIL_TEMPLATE_VARIABLE_JOB_OFFER_HEADER, $jobOfferHeader, $text);
        }

        if( !empty($jobOfferHeader) ){
            $text = str_replace(MailTemplateController::MAIL_TEMPLATE_VARIABLE_JOB_OFFER_URL, $jobOfferUrl, $text);
        }

        return $text;
    }
}

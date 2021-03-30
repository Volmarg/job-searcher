<?php

namespace App\Action\Module\Mail;

use App\Controller\Core\AjaxResponse;
use App\Controller\Core\Application;
use App\Controller\Core\ConstantsController;
use App\Controller\Module\Mail\MailTemplateController;
use App\Services\Encore\EncoreService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TypeError;

/**
 * This class is responsible for handling the logic of loading/saving search settings
 * Class DecisionController
 * @package App\Controller\Logic
 */
class MailTemplateAction extends AbstractController
{
    const TWIG_MAIL_TEMPLATE_MANAGE = "modules/mail/manage-templates.twig";
    const KEY_MAIL_TEMPLATE         = "mailTemplate";

    /**
     * @var Application $app
     */
    private $app;

    /**
     * @var MailTemplateController $mailTemplateController
     */
    private $mailTemplateController;

    /**
     * @var EncoreService $encoreService
     */
    private $encoreService;

    public function __construct(Application $app, MailTemplateController $mailTemplateController, EncoreService $encoreService) {
        $this->mailTemplateController = $mailTemplateController;
        $this->encoreService          = $encoreService;
        $this->app                    = $app;
    }

    /**
     * This function handles showing the page for creating mail templates
     *
     * @Route("/mail/template/manage", name="mail_template_manage")
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function getManagementPageContent(Request $request): Response
    {
        $ajaxResponse = new AjaxResponse();

        $allSavedTemplates = $this->app->getRepositories()->mailTemplateRepository()->findAll();
        $form              = $this->app->getForms()->getMailTemplateForm();

        $scriptSources = [$this->encoreService->getJsChunkFileLocationForChunkName(EncoreService::CHUNK_PAGE_MAIL_TEMPLATES_MANAGE)];

        $templateData = [
            'isAjax'            => $request->isXmlHttpRequest(),
            'form'              => $form->createView(),
            'templates'         => $allSavedTemplates,
            'templateVariables' => MailTemplateController::AVAILABLE_MAIL_TEMPLATE_VARIABLES
        ];

        if( !$request->isXmlHttpRequest() ){
            $templateData['scriptsSources'] = $scriptSources;
        }

        $renderedPage = $this->render(self::TWIG_MAIL_TEMPLATE_MANAGE, $templateData);
        if( $request->isXmlHttpRequest() ){
            $ajaxResponse->setMessage("");
            $ajaxResponse->setSuccess(true);;
            $ajaxResponse->setCode(Response::HTTP_OK);
            $ajaxResponse->setTemplate($renderedPage->getContent());
            $ajaxResponse->setDataBag([
                AjaxResponse::KEY_SCRIPTS_SOURCES => $scriptSources,
            ]);

            return $ajaxResponse->buildJsonResponse();
        }

        return $renderedPage;
    }

    /**
     * This function handles loading mail template
     * @Route("mail-template/ajax/load/{id}", name="mail_template_ajax_load")
     * @param string $id
     * @return JsonResponse
     */
    public function loadTemplateViaAjax(string $id): JsonResponse {
        $ajaxResponse = new AjaxResponse();
        $mailTemplate = $this->app->getRepositories()->mailTemplateRepository()->find($id);

        if( empty($mailTemplate) ){
            $message = $this->app->getTranslator()->trans("modules.mailTemplatesManage.load.fail.noTemplateFoundForId");
            $ajaxResponse->setCode(Response::HTTP_NOT_FOUND);
            $ajaxResponse->setSuccess(false);
            $ajaxResponse->setMessage($message);
            return $ajaxResponse->buildJsonResponse();
        }

        $message = $this->app->getTranslator()->trans("modules.mailTemplatesManage.load.success");
        $ajaxResponse->setMessage($message);
        $ajaxResponse->setSuccess(true);
        $ajaxResponse->setCode(Response::HTTP_OK);
        $ajaxResponse->setDataBag([
            self::KEY_MAIL_TEMPLATE => $mailTemplate,
        ]);
        return $ajaxResponse->buildJsonResponse();
    }

    /**
     * This function handles saving mail template
     * @Route("mail-template/ajax/save/{id}", name="mail_template_ajax_save")
     * @param Request $request
     * @param string|null $id
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveTemplateViaAjax(Request $request, ?string $id = null): JsonResponse {

        $ajaxResponse = new AjaxResponse();

        $message = $this->app->getTranslator()->trans("mailTemplate.save.success");
        $ajaxResponse->setCode(Response::HTTP_OK);
        $ajaxResponse->setSuccess(true);
        $ajaxResponse->setMessage($message);

        try{
            $mailTemplateForm        = $this->app->getForms()->getMailTemplateForm()->handleRequest($request);
            $mailTemplateFromRequest = $this->mailTemplateController->buildMailTemplateEntityFromForm($mailTemplateForm);
        } catch (Exception $e){
            $message = $this->app->getTranslator()->trans("mailTemplate.save.fail.couldNotHandleRequest");

            $ajaxResponse->setMessage($message);
            $ajaxResponse->setCode(Response::HTTP_BAD_REQUEST);
            return $ajaxResponse->buildJsonResponse();
        }

        if( empty($id) ){
            $mailTemplate = $mailTemplateFromRequest;
        }else {
            $mailTemplate = $this->app->getRepositories()->mailTemplateRepository()->find($id);

            if( empty($mailTemplate) ){
                $message = $this->app->getTranslator()->trans("mailTemplate.save.fail.noEntity");

                $ajaxResponse->setCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                $ajaxResponse->setSuccess(false);
                $ajaxResponse->setMessage($message);
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

        return $ajaxResponse->buildJsonResponse();
    }

    /**
     * This function handles removing mail template
     * @Route("mail-template/ajax/remove/{id}", name="mail_template_ajax_remove")
     * @param string $id
     * @return Response
     */
    public function removeTemplateViaAjax(string $id): Response {
        $ajaxResponse = new AjaxResponse();

        try{
            $this->app->getRepositories()->mailTemplateRepository()->removeMailTemplateForId($id);
            $message = $this->app->getTranslator()->trans('mailTemplate.remove.success');

            $ajaxResponse->setMessage($message);
            $ajaxResponse->setSuccess(true);
            $ajaxResponse->setCode(Response::HTTP_OK);
        }catch(Exception | TypeError $e){
            $this->app->logException($e);
            $ajaxResponse->setCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $ajaxResponse->setSuccess(false);
        }

        return $ajaxResponse->buildJsonResponse();
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
        $ajaxResponse   = new AjaxResponse();

        $mailTemplate = $this->app->getRepositories()->mailTemplateRepository()->find($id);

        if( empty($mailTemplate) ){
            $message = $this->app->getTranslator()->trans("modules.mailTemplatesManage.message.fail.noEntity");

            $ajaxResponse->setCode(Response::HTTP_NOT_FOUND);
            $ajaxResponse->setSuccess(false);
            $ajaxResponse->setMessage($message);

            return $ajaxResponse->buildJsonResponse();
        }

        $message         = $this->app->getTranslator()->trans("modules.mailTemplatesManage.message.success.emailGenerated");
        $mailTitle       = $this->replaceMailTemplateVariablesWithStrings($mailTemplate->getTitle(), $jobOfferUrl, $jobOfferHeader);
        $mailDescription = $this->replaceMailTemplateVariablesWithStrings($mailTemplate->getDescription(), $jobOfferUrl, $jobOfferHeader);

        $dataBag = [
            ConstantsController::KEY_JSON_RESPONSE_MAIL_DESCRIPTION => $mailDescription,
            ConstantsController::KEY_JSON_RESPONSE_MAIL_TITLE       => strip_tags($mailTitle),
        ];

        $ajaxResponse->setMessage($message);
        $ajaxResponse->setSuccess(true);
        $ajaxResponse->setCode(Response::HTTP_OK);
        $ajaxResponse->setDataBag($dataBag);;

        return $ajaxResponse->buildJsonResponse();
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

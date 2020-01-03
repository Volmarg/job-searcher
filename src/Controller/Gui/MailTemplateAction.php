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
     * @Route("mail-template/ajax/page", name="mail_template_ajax_page")
     * @param Request $request
     * @return JsonResponse
     */
    public function getManagementPageContent(Request $request): JsonResponse{

        $allSavedTemplates = $this->app->getRepositories()->mailTemplateRepository()->findAll();

        $form         = $this->app->getForms()->getMailTemplateForm();
        $templateData = [
            'form'      => $form->createView(),
            'templates' => $allSavedTemplates,
        ];
        $renderedPage = $this->render(self::TWIG_TEMPLATE_SHOW_MANAGEMENT_PAGE, $templateData);
        $pageContent  = $renderedPage->getContent();

        return Utils::buildAjaxResponse('', false, 200, null, $pageContent);
    }

    public function loadTemplateViaAjax() {

    }

    /**
     * @Route("mail-template/ajax/save{?id}", name="mail_template_ajax_save")
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

        $mailTemplateFromRequest = $this->mailTemplateController->buildMailTemplateEntityFromRequest($request);

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
     * @Route("mail-template/ajax/remove/{id}", name="mail_template_ajax_remove")
     * @param string $id
     * @throws ORMException
     */
    public function removeTemplateViaAjax(string $id){
        $this->app->getRepositories()->mailTemplateRepository()->removeMailTemplateForId($id);
    }

}

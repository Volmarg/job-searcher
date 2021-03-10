<?php

namespace App\Controller\Action\Module\Mail;

use App\Controller\Application;
use App\Controller\Logic\Mail\MailTemplateController;
use App\Controller\Utils;
use App\Services\Encore\EncoreService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupCollectionInterface;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupInterface;

/**
 * This class is responsible for handling the logic of loading/saving search settings
 * Class DecisionController
 * @package App\Controller\Logic
 */
class TemplateAction extends AbstractController
{
    const TWIG_MAIL_TEMPLATE_MANAGE = "modules/mail/template/manage.twig";

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
        $this->app = $app;
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
            return Utils::buildAjaxResponse('', false, Response::HTTP_OK, $renderedPage->getContent(), $scriptSources);
        }

        return $renderedPage;
    }



}

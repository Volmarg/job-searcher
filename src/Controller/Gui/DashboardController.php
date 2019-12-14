<?php

namespace App\Controller\Gui;

use App\Controller\ScrappingController;
use App\DTO\AjaxScrapDataRequestDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This class handles the pages displaying and responds to performed actions
 * Class DashboardController
 * @package App\Controller\Gui
 */
class DashboardController extends AbstractController
{
    const MAIN_PAGE_TWIG_TPL = "dashboard/index.html.twig";

    /**
     * @var ScrappingController $scrappingController
     */
    private $scrappingController;

    public function __construct(ScrappingController $scrappingController) {
        $this->scrappingController = $scrappingController;
    }

    /**
     * @Route("/", name="dashboard")
     */
    public function index()
    {

        $data = [];

        return $this->render(self::MAIN_PAGE_TWIG_TPL, $data);
    }

    /**
     * //todo: add ajax route
     * This function handles the scrapping logic for ajax call
     * @param Request $request
     * @return array|string[]
     * @throws \ErrorException
     */
    public function ajaxScrapData(Request $request) {

        $ajaxScrapDataRequestDTO = $this->buildAjaxScrapDataRequestDTOFromRequest($request);
        $links                   = $this->scrappingController->buildLinksForScrappingFromAjaxScrapDataRequest($ajaxScrapDataRequestDTO);
        $jobSearchRequestsDtos   = $this->scrappingController->buildJobSearchRequestDtosFromLinks($links);

        $responseDtos = $this->scrappingController->scrapDataForWebsites($jobSearchRequestsDtos);
        return $links;
        //return new JsonResponse($links);
    }

    /**
     * This function will attempt build ajax request dto from request
     * @param Request $request
     * @return AjaxScrapDataRequestDTO
     */
    private function buildAjaxScrapDataRequestDTOFromRequest(Request $request): AjaxScrapDataRequestDTO {
        $endPageOffset   = 0;
        $startPageOffset = 0;
        $pageOffsetSteps = 0;

        $pageOffsetReplacePattern = '';
        $urlPattern               = '';

        if( $request->request->has(AjaxScrapDataRequestDTO::KEY_END_PAGE_OFFSET) ) {
            $endPageOffset = $request->request->get(AjaxScrapDataRequestDTO::KEY_END_PAGE_OFFSET);
        }

        if( $request->request->has(AjaxScrapDataRequestDTO::KEY_START_PAGE_OFFSET) ) {
            $startPageOffset = $request->request->get(AjaxScrapDataRequestDTO::KEY_START_PAGE_OFFSET);
        }

        if( $request->request->has(AjaxScrapDataRequestDTO::KEY_PAGE_OFFSET_STEPS) ) {
            $pageOffsetSteps = $request->request->get(AjaxScrapDataRequestDTO::KEY_PAGE_OFFSET_STEPS);
        }

        if( $request->request->has(AjaxScrapDataRequestDTO::KEY_PAGE_OFFSET_REPLACE_PATTERN) ) {
            $pageOffsetReplacePattern = $request->request->get(AjaxScrapDataRequestDTO::KEY_PAGE_OFFSET_REPLACE_PATTERN);
        }

        if( $request->request->has(AjaxScrapDataRequestDTO::KEY_URL_PATTERN) ) {
            $urlPattern = $request->request->get(AjaxScrapDataRequestDTO::KEY_URL_PATTERN);
        }

        $ajaxScrapDataRequestDTO = new AjaxScrapDataRequestDTO();
        $ajaxScrapDataRequestDTO->setEndPageOffset($endPageOffset);
        $ajaxScrapDataRequestDTO->setStartPageOffset($startPageOffset);
        $ajaxScrapDataRequestDTO->setPageOffsetSteps($pageOffsetSteps);
        $ajaxScrapDataRequestDTO->setPageOffsetReplacePattern($pageOffsetReplacePattern);
        $ajaxScrapDataRequestDTO->setUrlPattern($urlPattern);

        return $ajaxScrapDataRequestDTO;
    }

}

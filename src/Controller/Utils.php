<?php


namespace App\Controller;

use App\Form\JobOfferScrappingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class Utils extends AbstractController {

    public static function buildAjaxResponse(string $message, bool $error, int $code): JsonResponse {
        $responseData = [
          ConstantsController::KEY_JSON_RESPONSE_MESSAGE => $message,
          ConstantsController::KEY_JSON_RESPONSE_ERROR   => $error,
        ];

        $jsonResponse = new JsonResponse($responseData, $code);
        return $jsonResponse;
    }

}
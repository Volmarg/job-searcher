<?php


namespace App\Controller;

use App\Entity\SearchSetting;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class Utils extends AbstractController {

    public static function buildAjaxResponse(string $message, bool $error, int $code, SearchSetting $searchSetting = null): JsonResponse {

        $serializer = new Serializer([new GetSetMethodNormalizer()], [new JsonEncoder()]);

        $responseData = [
          ConstantsController::KEY_JSON_RESPONSE_MESSAGE => $message,
          ConstantsController::KEY_JSON_RESPONSE_ERROR   => $error,
          ConstantsController::KEY_JSON_RESPONSE_CODE    => $code,
        ];

        if( !empty($searchSetting) ){
            $serializedSearchSetting = $serializer->serialize($searchSetting, 'json');
            $responseData[ConstantsController::KEY_JSON_RESPONSE_SEARCH_SETTING] = $serializedSearchSetting;
        }

        $jsonResponse = new JsonResponse($responseData, 200);
        return $jsonResponse;
    }

}
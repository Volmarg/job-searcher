<?php


namespace App\Controller;

use App\Entity\SearchSetting;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class Utils extends AbstractController {

    /**
     * @param string $message
     * @param bool $error
     * @param int $code
     * @param SearchSetting|null $searchSetting
     * @param string|null $template
     * @return JsonResponse
     */
    public static function buildAjaxResponse(string $message, bool $error, int $code, SearchSetting $searchSetting = null, string $template = null ): JsonResponse {

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

        if( !empty($template) ){
            $responseData[ConstantsController::KEY_JSON_RESPONSE_TEMPLATE] = $template;
        }

        $jsonResponse = new JsonResponse($responseData, 200);
        return $jsonResponse;
    }

    public static function newLineToSpacebar(string $text): string {
        $replacedText = trim(preg_replace('/\s+/', ' ', $text));
        return $replacedText;
    }
}
<?php


namespace App\Controller;

use App\Controller\Core\ConstantsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class Utils extends AbstractController {

    const EMAIL_ADDRESS_MATCH_REGEX = '/([a-z0-9_\.\-])+(\@|\[at\])+(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+/i';

    /**
     * //todo: turn params into dto if this will keep growing.
     * @param string $message
     * @param bool $error
     * @param int $code
     * @param string|null $template
     * @param array $scriptSources
     * @return JsonResponse
     */
    public static function buildAjaxResponse(
        string        $message,
        bool          $error,
        int           $code,
        string        $template      = null,
        array         $scriptSources = []
    ): JsonResponse {

        $responseData = [
          ConstantsController::KEY_JSON_RESPONSE_MESSAGE        => $message,
          ConstantsController::KEY_JSON_RESPONSE_ERROR          => $error,
          ConstantsController::KEY_JSON_RESPONSE_CODE           => $code,
          ConstantsController::KEY_JSON_RESPONSE_SCRIPT_SOURCES => $scriptSources,
        ];

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
<?php


namespace App\Controller;

use App\Entity\MailTemplate;
use App\Entity\SearchSetting;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class Utils extends AbstractController {

    const EMAIL_ADDRESS_MATCH_REGEX = '/([a-z0-9_\.\-])+(\@|\[at\])+(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+/i';

    /**
     * //todo: turn params into dto if this will keep growing.
     * @param string $message
     * @param bool $error
     * @param int $code
     * @param SearchSetting|null $searchSetting
     * @param string|null $template
     * @param MailTemplate|null $mailTemplate
     * @return JsonResponse
     */
    public static function buildAjaxResponse(
        string        $message,
        bool          $error,
        int           $code,
        SearchSetting $searchSetting = null,
        string        $template      = null,
        MailTemplate  $mailTemplate  = null
    ): JsonResponse {

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

        if( !empty($mailTemplate) ){
            $serializedMailTemplate = $serializer->serialize($mailTemplate, 'json');
            $responseData[ConstantsController::KEY_JSON_RESPONSE_MAIL_TEMPLATE] = $serializedMailTemplate;
        }

        $jsonResponse = new JsonResponse($responseData, 200);
        return $jsonResponse;
    }

    public static function newLineToSpacebar(string $text): string {
        $replacedText = trim(preg_replace('/\s+/', ' ', $text));
        return $replacedText;
    }
}
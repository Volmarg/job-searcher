<?php

namespace App\Controller\Core;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AjaxResponse extends AbstractController {

    const KEY_CODE     = "code";
    const KEY_MESSAGE  = "message";
    const KEY_TEMPLATE = "template";
    const KEY_SUCCESS  = "success";
    const KEY_DATA_BAG = "dataBag";

    /**
     * @var int $code
     */
    private $code = Response::HTTP_OK;

    /**
     * @var string $message
     */
    private $message = "";

    /**
     * @var null|string $template
     */
    private $template = null;

    /**
     * @var bool $success
     */
    private $success = true;

    /**
     * Used on front to find the form fields
     * @var string $validatedFormPrefix
     */
    private $validatedFormPrefix = "";

    /**
     * @var array $dataBag
     */
    private $dataBag = [];

    /**
     * @return int
     */
    public function getCode(): int {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getMessage(): string {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void {
        $this->message = $message;
    }

    /**
     * @return string|null
     */
    public function getTemplate(): ?string {
        return $this->template;
    }

    /**
     * @param string|null $template
     */
    public function setTemplate(?string $template): void {
        $this->template = $template;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool {
        return $this->success;
    }

    /**
     * @param bool $success
     */
    public function setSuccess(bool $success): void {
        $this->success = $success;
    }

    /**
     * @param string $validatedFormPrefix
     */
    public function setValidatedFormPrefix(string $validatedFormPrefix): void {
        $this->validatedFormPrefix = $validatedFormPrefix;
    }

    /**
     * @return array
     */
    public function getDataBag(): array
    {
        return $this->dataBag;
    }

    /**
     * @param array $dataBag
     */
    public function setDataBag(array $dataBag): void
    {
        $this->dataBag = $dataBag;
    }

    /**
     * @param int           $code
     * @param string        $message
     * @param string|null   $template
     * @param bool          $success
     * @param array         $dataBag
     * @return JsonResponse
     * @throws Exception
     */
    public static function buildJsonResponseForAjaxCall(
        int     $code,
        string  $message  = "",
        ?string $template = null,
        bool    $success  = true,
        array   $dataBag  = []
    ): JsonResponse {

        $responseData = [
            self::KEY_CODE    => $code,
            self::KEY_MESSAGE => $message,
        ];

        if( !empty($template) ){
            $responseData[self::KEY_TEMPLATE] = $template;
        }


        $responseData[self::KEY_SUCCESS]  = $success;
        $responseData[self::KEY_DATA_BAG] = $dataBag;

        $response = new JsonResponse($responseData, 200);
        return $response;
    }

    /**
     * Will pre-fill code/message from Response and return AjaxResponse
     * @param Response $response
     * @return AjaxResponse
     */
    public static function initializeFromResponse(Response $response): AjaxResponse
    {
        $ajaxResponseDto = new AjaxResponse();

        $message = $response->getContent();
        $code    = $response->getStatusCode();

        $ajaxResponseDto->setMessage($message);
        $ajaxResponseDto->setCode($code);

        return $ajaxResponseDto;
    }
    
    /**
     * Transforms AjaxResponse to JsonResponse usable for Ajax call
     * @return JsonResponse
     */
    public function buildJsonResponse(): JsonResponse
    {
        $responseData = [
            self::KEY_CODE     => $this->getCode(),
            self::KEY_MESSAGE  => $this->getMessage(),
            self::KEY_TEMPLATE => $this->getTemplate(),
            self::KEY_SUCCESS  => $this->isSuccess(),
            self::KEY_DATA_BAG => $this->getDataBag(),
        ];

        $response = new JsonResponse($responseData, Response::HTTP_OK);
        return $response;
    }

}

<?php

namespace App\Controller\Core;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AjaxResponse extends AbstractController {

    const KEY_CODE             = "code";
    const KEY_MESSAGE          = "message";
    const KEY_TEMPLATE         = "template";
    const KEY_SUCCESS          = "success";
    const KEY_DATA_BAG         = "dataBag";
    const KEY_SCRIPTS_SOURCES  = "scriptsSources";

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
     * Special array that contains locations of scripts which should be loaded additionally to the template
     *
     * @var array $scriptSources
     */
    private $scriptSources = [];

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
     * @return array
     */
    public function getScriptSources(): array
    {
        return $this->scriptSources;
    }

    /**
     * @param array $scriptSources
     */
    public function setScriptSources(array $scriptSources): void
    {
        $this->scriptSources = $scriptSources;
    }

    public function __construct(string $message = "", bool $isSuccess = true, int $code = Response::HTTP_OK)
    {
        $this->message = $message;
        $this->code    = $code;
        $this->success = $isSuccess;
    }

    /**
     * Transforms AjaxResponse to JsonResponse usable for Ajax call
     * @return JsonResponse
     */
    public function buildJsonResponse(): JsonResponse
    {
        $responseData = [
            self::KEY_CODE            => $this->getCode(),
            self::KEY_MESSAGE         => $this->getMessage(),
            self::KEY_TEMPLATE        => $this->getTemplate(),
            self::KEY_SUCCESS         => $this->isSuccess(),
            self::KEY_DATA_BAG        => $this->getDataBag(),
            self::KEY_SCRIPTS_SOURCES => $this->getScriptSources(),
        ];

        $response = new JsonResponse($responseData, Response::HTTP_OK);
        return $response;
    }

}

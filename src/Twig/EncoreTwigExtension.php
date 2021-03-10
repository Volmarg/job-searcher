<?php

namespace App\Twig;

use App\Services\Encore\EncoreService;
use Exception;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 *
 * Class EncoreTwigExtension
 * @package App\Twig
 */
class EncoreTwigExtension extends AbstractExtension
{
    /**
     * @var EncoreService $encoreService
     */
    private EncoreService $encoreService;

    public function __construct(EncoreService $encoreService)
    {
        $this->encoreService = $encoreService;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction("getVendorJsScriptChunkFileLocation",  [$this, 'getVendorJsScriptChunkFileLocation']),
            new TwigFunction("getRuntimeJsScriptChunkFileLocation", [$this, 'getRuntimeJsScriptChunkFileLocation']),
            new TwigFunction("getJsChunkFileLocationForChunkName",  [$this, 'getJsChunkFileLocationForChunkName']),
        ];
    }

    /**
     * Will return the js chunk file location which consists of common code used for all chunks
     *
     * @return string
     * @throws Exception
     */
    public function getVendorJsScriptChunkFileLocation(): string
    {
        return $this->encoreService->getVendorJsScriptChunkFileLocation();
    }

    /**
     * Will return the webpack runtime chunk file location
     *
     * @return string
     * @throws Exception
     */
    public function getRuntimeJsScriptChunkFileLocation(): string
    {
        return $this->encoreService->getRuntimeJsScriptChunkFileLocation();
    }

    /**
     * Will return the webpack chunk file location
     *
     * @param string $chunkName
     * @return string
     * @throws Exception
     */
    public function getJsChunkFileLocationForChunkName(string $chunkName): string
    {
        return $this->encoreService->getJsChunkFileLocationForChunkName($chunkName);
    }
}
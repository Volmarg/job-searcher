<?php


namespace App\Services\Encore;


use Exception;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupCollectionInterface;
use TypeError;

/**
 * Contains special logic to handle manipulated webpack and the way that Vue.js works like with the ajax loaded content
 * This does not support fetching the css files at this moment, it was not required on implementation
 *
 * Class EncoreService
 * @package App\Services\Encore
 */
class EncoreService
{
    const CHUNK_TYPE_CSS = "css";
    const CHUNK__TYPE_JS = "js";

    const CHUNK_VENDOR_NAME  = "vendor";
    const CHUNK_RUNTIME_NAME = "runtime";
    const CHUNK_PAGE_MAIL_TEMPLATES_MANAGE = "page-mail-templates-manage";

    /**
     * @var EntrypointLookupCollectionInterface $entrypointLookupCollection
     */
    private EntrypointLookupCollectionInterface $entrypointLookupCollection;

    /**
     * @var array $appEntryPointScriptFiles
     */
    private array $appEntryPointScriptFiles = [];

    public function __construct(EntrypointLookupCollectionInterface $entrypointLookupCollection)
    {
        $this->entrypointLookupCollection = $entrypointLookupCollection;

        /**
         * This is required as the entrypoint lookup logic is a bit fishy and will actually REMOVE the fetched data from lookup
         * which means that next time that this gets called within this service - it's empty, this is safe as long
         * as no more files with logic are generated per chunk (this might interfere with symfony encore twig methods!)
         */
        $this->appEntryPointScriptFiles = $this->entrypointLookupCollection->getEntrypointLookup()->getJavaScriptFiles("app");
    }

    /**
     * Will return the js chunk file location which consists of common code used for all chunks
     *
     * @return string
     * @throws Exception
     */
    public function getVendorJsScriptChunkFileLocation(): string
    {
        return $this->getJsScriptChunkFileLocation(self::CHUNK_VENDOR_NAME, $this->appEntryPointScriptFiles);
    }

    /**
     * Will return the webpack runtime chunk file location
     *
     * @return string
     * @throws Exception
     */
    public function getRuntimeJsScriptChunkFileLocation(): string
    {
        return $this->getJsScriptChunkFileLocation(self::CHUNK_RUNTIME_NAME, $this->appEntryPointScriptFiles);
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
        $filesLocations           = $this->entrypointLookupCollection->getEntrypointLookup()->getJavaScriptFiles($chunkName);
        $fileLocationForChunkName = $this->getJsScriptChunkFileLocation($chunkName, $filesLocations);
        return $fileLocationForChunkName;
    }

    /**
     * Will return the js chunk file location for chunk name
     *
     * @param string $chunkName
     * @param array $filesLocations
     * @return mixed
     * @throws Exception
     */
    private function getJsScriptChunkFileLocation(string $chunkName, array $filesLocations)
    {
        try{
            $matches          = preg_grep("#" . $chunkName . "#", $filesLocations);
            $firstMatchingKey = array_key_first($matches);

            $chunkLocation = $matches[$firstMatchingKey];
        }catch(Exception | TypeError $e){
            throw new Exception("Could not get the chunk: {$chunkName}");
        }

        return $chunkLocation;
    }
}
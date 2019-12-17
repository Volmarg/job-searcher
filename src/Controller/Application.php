<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class Application extends AbstractController
{

    /**
     * @var LoggerInterface $logger
     */
    private $logger;

    /**
     * @var TranslatorInterface $translator
     */
    private $translator;

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface {
        return $this->logger;
    }

    /**
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface {
        return $this->translator;
    }

    public function __construct(TranslatorInterface $translator, LoggerInterface $logger) {
        $this->translator = $translator;
        $this->logger     = $logger;
    }


}

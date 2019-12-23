<?php

namespace App\Controller\Logic\Search;

use App\Controller\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * This class is responsible for handling the logic of loading/saving search settings
 * Class DecisionController
 * @package App\Controller\Logic
 */
class SearchSettingsController extends AbstractController
{

    /**
     * @var Application $app
     */
    private $app;

    public function __construct(Application $app) {
        $this->app = $app;
    }

}

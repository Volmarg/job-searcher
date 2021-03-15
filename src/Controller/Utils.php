<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Utils extends AbstractController {

    const EMAIL_ADDRESS_MATCH_REGEX = '/([a-z0-9_\.\-])+(\@|\[at\])+(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+/i';
}
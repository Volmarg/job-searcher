<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Utils extends AbstractExtension {

    public function getFunctions() {
        return [
            new TwigFunction('escapeDoubleQuotes', [$this, 'escapeDoubleQuotes']),
        ];
    }

    public function escapeDoubleQuotes(string $text): string {
        $escapedText = str_replace('"','\\"', $text);
        return $escapedText;
    }
}
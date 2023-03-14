<?php

namespace App\Templating;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Template
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(CONFIG['templating']['templates']);
        $this->twig = new Environment($loader, [
            'cache' => CONFIG['templating']['cache'],
            'debug' => true
        ]);
        $this->twig->addGlobal("APP_NAME", CONFIG['app_name']);

        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    public function render(string $template, array $args = []): string
    {
        $template = $this->twig->load($template);
        return $template->render($args);
    }
}

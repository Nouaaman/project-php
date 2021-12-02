<?php

namespace Framework\Controller;

use Framework\Templating\Twig;

abstract class AbstractController
{
    public function render(string $template, array $args = []): string
    {
        $twig = new Twig();

        return $twig->render($template, $args);
    }

    public function isPost(): bool
    {
      return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
    }

    public function redirect(string $uri): void
    {
      header("Location: $uri");
      die;
    }
}

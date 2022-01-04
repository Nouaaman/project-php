<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* layout.html.twig */
class __TwigTemplate_45699c3dd1b2f9ad9a3b9d56290cbc6d8c54fb4b222b67b1416dc6b5318c5e6a extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'css' => [$this, 'block_css'],
            'js' => [$this, 'block_js'],
            'body' => [$this, 'block_body'],
            'bottom_js' => [$this, 'block_bottom_js'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!doctype html>
<html lang=\"fr\">

<head>
    <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    ";
        // line 8
        $this->displayBlock('css', $context, $blocks);
        // line 9
        echo "    ";
        $this->displayBlock('js', $context, $blocks);
        // line 10
        echo "    <script src=\"https://cdn.jsdelivr.net/npm/less@4.1.1\"></script>
</head>

<body>
    ";
        // line 14
        $this->displayBlock('body', $context, $blocks);
        // line 15
        echo "    ";
        $this->displayBlock('bottom_js', $context, $blocks);
        // line 16
        echo "</body>

</html>";
    }

    // line 5
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo "BOARD GAME - ";
    }

    // line 8
    public function block_css($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 9
    public function block_js($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 14
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 15
    public function block_bottom_js($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    public function getTemplateName()
    {
        return "layout.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  101 => 15,  95 => 14,  89 => 9,  83 => 8,  76 => 5,  70 => 16,  67 => 15,  65 => 14,  59 => 10,  56 => 9,  54 => 8,  48 => 5,  42 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!doctype html>
<html lang=\"fr\">

<head>
    <title>{% block title %}BOARD GAME - {% endblock %}</title>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    {% block css %}{% endblock %}
    {% block js %}{% endblock %}
    <script src=\"https://cdn.jsdelivr.net/npm/less@4.1.1\"></script>
</head>

<body>
    {% block body %}{% endblock %}
    {% block bottom_js %}{% endblock %}
</body>

</html>", "layout.html.twig", "C:\\xampp\\htdocs\\project-php\\templates\\layout.html.twig");
    }
}

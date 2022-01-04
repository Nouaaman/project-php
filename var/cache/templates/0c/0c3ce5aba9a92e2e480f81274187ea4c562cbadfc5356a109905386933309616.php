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

/* home.html.twig */
class __TwigTemplate_e2553d2a2716c37ad6031e486c47acc64cbeb2fb57865fb8477cea9f21f5b414 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'css' => [$this, 'block_css'],
            'body' => [$this, 'block_body'],
            'bottom_js' => [$this, 'block_bottom_js'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("layout.html.twig", "home.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "\t";
        $this->displayParentBlock("title", $context, $blocks);
        echo "Accueil
";
    }

    // line 8
    public function block_css($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 9
        echo "\t<link rel=\"stylesheet/less\" href=\"/assets/css/home.less\">
";
    }

    // line 13
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 14
        echo "\t<div class=\"land\">
\t\t<div class=\"nav\">
\t\t\t<div class=\"logo\">
\t\t\t\t<h4><img src=\"/assets/img/logo.png\"></h4>
\t\t\t</div>
\t\t\t<ul>
\t\t\t\t";
        // line 20
        if ((($context["userIsConnected"] ?? null) == true)) {
            // line 21
            echo "\t\t\t\t\t<li>
\t\t\t\t\t\t<div class=\"user-icon-container\">
\t\t\t\t\t\t\t<div class=\"user-icon-content\" id=\"userIcon\">
\t\t\t\t\t\t\t\t<img src=\"/assets/img/user-white.png\" alt=\"\" class=\"user-icon\">
\t\t\t\t\t\t\t\t<p>";
            // line 25
            echo twig_escape_filter($this->env, ($context["username"] ?? null), "html", null, true);
            echo "</p>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"user-actions\">
\t\t\t\t\t\t\t\t<a href=\"/user/profile\" class=\"action\">Profil</a>
\t\t\t\t\t\t\t\t";
            // line 29
            if ((($context["role"] ?? null) == "admin")) {
                // line 30
                echo "\t\t\t\t\t\t\t\t\t<a href=\"/admin/homepage\" class=\"action\">Admin</a>
\t\t\t\t\t\t\t\t";
            }
            // line 32
            echo "\t\t\t\t\t\t\t\t<form action=\"\" method=\"POST\">
\t\t\t\t\t\t\t\t\t<input type=\"submit\" value=\"Déconnexion\" name=\"signOut\" class=\"action\">
\t\t\t\t\t\t\t\t</form>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</li>
\t\t\t\t";
        }
        // line 39
        echo "\t\t\t\t";
        if ((($context["userIsConnected"] ?? null) == false)) {
            // line 40
            echo "\t\t\t\t\t<li>
\t\t\t\t\t\t<a href=\"login\">Connexion | Inscription</a>
\t\t\t\t\t</li>
\t\t\t\t";
        }
        // line 44
        echo "
\t\t\t\t<!-- <li><a href=\"admin/users\">Admin</a></li> -->

\t\t\t</ul>
\t\t</div>
\t\t<div class=\"presentation\">
\t\t\t<div class=\"title\">BOARD GAME</div>
\t\t\t<div class=\"textpres\">Défiez vos amis en découvrant votre culture cachée au fond de vous
\t\t\t</div>
\t\t\t<div class=\"play\">
\t\t\t\t<a id=\"play\" href=\"/game/create\">Jouer</a>
\t\t\t</div>
\t\t</div>
\t\t<div class=\"down\">
\t\t\t<img src=\"https://img.icons8.com/glyph-neue/64/ffffff/chevron-down.png\"/>
\t\t</div>
\t\t<div class=\"rules\">
\t\t\t<div class=\"description\">
\t\t\t\t<h3>Fonctionnement du jeu</h3>
\t\t\t\t<p>
\t\t\t\t\t<b>Le but du jeu est simple :</b>
\t\t\t\t\tRépondre au maximum de question, et finir avant ses adversaires
\t\t\t\t</p>
\t\t\t\t<p>Il faudra arriver au bout du plateau le plus rapidement possible.</p>
\t\t\t\t<p>Lorsque ce sera à votre tour de jouer, vous choisirez le niveau de difficulté entre 1 et 6 de la
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tquestion
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tà laquelle vous allez répondre.
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tPlus le niveau est élevé, plus vous avancerez</p>
\t\t\t\t<p>Les joueurs jouent chacun leur tour</p>
\t\t\t\t<p>Avant de commencer, connectez-vous à votre compte. Si ce n'est pas déjà fait, inscrivrez-vous
\t\t\t\t</p>
\t\t\t\t<p>Faites travailler vos méninges et bon chance !</p>
\t\t\t</div>
\t\t</div>
\t</div>
";
    }

    // line 82
    public function block_bottom_js($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 83
        echo "\t<script>
\t\tlet userIcon = document.getElementById('userIcon')
userIcon.addEventListener('click', toggle)

function toggle() {
userIcon.classList.toggle('visible')
}
\t</script>
\t<script type=\"text/javascript\" src=\"js/vanilla-tilt.js\"></script>

";
    }

    public function getTemplateName()
    {
        return "home.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  163 => 83,  159 => 82,  120 => 44,  114 => 40,  111 => 39,  102 => 32,  98 => 30,  96 => 29,  89 => 25,  83 => 21,  81 => 20,  73 => 14,  69 => 13,  64 => 9,  60 => 8,  53 => 4,  49 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'layout.html.twig' %}

{% block title %}
\t{{ parent() }}Accueil
{% endblock %}


{% block css %}
\t<link rel=\"stylesheet/less\" href=\"/assets/css/home.less\">
{% endblock %}


{% block body %}
\t<div class=\"land\">
\t\t<div class=\"nav\">
\t\t\t<div class=\"logo\">
\t\t\t\t<h4><img src=\"/assets/img/logo.png\"></h4>
\t\t\t</div>
\t\t\t<ul>
\t\t\t\t{% if userIsConnected == true %}
\t\t\t\t\t<li>
\t\t\t\t\t\t<div class=\"user-icon-container\">
\t\t\t\t\t\t\t<div class=\"user-icon-content\" id=\"userIcon\">
\t\t\t\t\t\t\t\t<img src=\"/assets/img/user-white.png\" alt=\"\" class=\"user-icon\">
\t\t\t\t\t\t\t\t<p>{{username}}</p>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"user-actions\">
\t\t\t\t\t\t\t\t<a href=\"/user/profile\" class=\"action\">Profil</a>
\t\t\t\t\t\t\t\t{% if role == 'admin' %}
\t\t\t\t\t\t\t\t\t<a href=\"/admin/homepage\" class=\"action\">Admin</a>
\t\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t\t<form action=\"\" method=\"POST\">
\t\t\t\t\t\t\t\t\t<input type=\"submit\" value=\"Déconnexion\" name=\"signOut\" class=\"action\">
\t\t\t\t\t\t\t\t</form>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</li>
\t\t\t\t{% endif %}
\t\t\t\t{% if userIsConnected == false %}
\t\t\t\t\t<li>
\t\t\t\t\t\t<a href=\"login\">Connexion | Inscription</a>
\t\t\t\t\t</li>
\t\t\t\t{% endif %}

\t\t\t\t<!-- <li><a href=\"admin/users\">Admin</a></li> -->

\t\t\t</ul>
\t\t</div>
\t\t<div class=\"presentation\">
\t\t\t<div class=\"title\">BOARD GAME</div>
\t\t\t<div class=\"textpres\">Défiez vos amis en découvrant votre culture cachée au fond de vous
\t\t\t</div>
\t\t\t<div class=\"play\">
\t\t\t\t<a id=\"play\" href=\"/game/create\">Jouer</a>
\t\t\t</div>
\t\t</div>
\t\t<div class=\"down\">
\t\t\t<img src=\"https://img.icons8.com/glyph-neue/64/ffffff/chevron-down.png\"/>
\t\t</div>
\t\t<div class=\"rules\">
\t\t\t<div class=\"description\">
\t\t\t\t<h3>Fonctionnement du jeu</h3>
\t\t\t\t<p>
\t\t\t\t\t<b>Le but du jeu est simple :</b>
\t\t\t\t\tRépondre au maximum de question, et finir avant ses adversaires
\t\t\t\t</p>
\t\t\t\t<p>Il faudra arriver au bout du plateau le plus rapidement possible.</p>
\t\t\t\t<p>Lorsque ce sera à votre tour de jouer, vous choisirez le niveau de difficulté entre 1 et 6 de la
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tquestion
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tà laquelle vous allez répondre.
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tPlus le niveau est élevé, plus vous avancerez</p>
\t\t\t\t<p>Les joueurs jouent chacun leur tour</p>
\t\t\t\t<p>Avant de commencer, connectez-vous à votre compte. Si ce n'est pas déjà fait, inscrivrez-vous
\t\t\t\t</p>
\t\t\t\t<p>Faites travailler vos méninges et bon chance !</p>
\t\t\t</div>
\t\t</div>
\t</div>
{% endblock %}


{% block bottom_js %}
\t<script>
\t\tlet userIcon = document.getElementById('userIcon')
userIcon.addEventListener('click', toggle)

function toggle() {
userIcon.classList.toggle('visible')
}
\t</script>
\t<script type=\"text/javascript\" src=\"js/vanilla-tilt.js\"></script>

{% endblock %}
", "home.html.twig", "C:\\xampp\\htdocs\\project-php\\templates\\home.html.twig");
    }
}

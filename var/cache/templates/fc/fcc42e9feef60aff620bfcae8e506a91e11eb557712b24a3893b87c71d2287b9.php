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

/* user/login.html.twig */
class __TwigTemplate_57152929aa7d88de1f23e1191ef326a917b1576ef539e2c76511ed65448330eb extends Template
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
        $this->parent = $this->loadTemplate("layout.html.twig", "user/login.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        $this->displayParentBlock("title", $context, $blocks);
        echo "Connexion | Inscription
";
    }

    // line 8
    public function block_css($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 9
        echo "<link rel=\"stylesheet/less\" href=\"/assets/css/login.less\">
";
    }

    // line 13
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 14
        echo "<!-- messages -->
<div class=\"container\">
\t<div class=\"content ";
        // line 16
        echo twig_escape_filter($this->env, ($context["classCss"] ?? null), "html", null, true);
        echo "\">
\t\t<div class=\"sign-in\">
\t\t\t<div class=\"form-container\">
\t\t\t\t<form method=\"POST\">
\t\t\t\t\t<input type=\"hidden\" name=\"action\" value=\"login\">
\t\t\t\t\t<h2>Connexion</h2>
\t\t\t\t\t<div class=\"field\">
\t\t\t\t\t\t<label for=\"username\">Username</label>
\t\t\t\t\t\t<input type=\"text\" name=\"username\" id=\"username\" value=\"";
        // line 24
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["post"] ?? null), "username", [], "any", false, false, false, 24), "html", null, true);
        echo "\">
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"field\">
\t\t\t\t\t\t<label for=\"password\">Mot de passe</label>
\t\t\t\t\t\t<input type=\"password\" name=\"password\" id=\"password\">
\t\t\t\t\t</div>

\t\t\t\t\t<p class=\"message warning\">";
        // line 31
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["loginMessages"] ?? null), "username", [], "any", false, false, false, 31), "html", null, true);
        echo "</p>
\t\t\t\t\t<div class=\"buttons\">
\t\t\t\t\t\t<input type=\"submit\" value=\"Se connecter\" class=\"btn fill\">
\t\t\t\t\t\t<a class=\"btn outline toggle\">S'inscrire</a>
\t\t\t\t\t</div>
\t\t\t\t</form>
\t\t\t</div>
\t\t\t<div class=\"img-container\">
\t\t\t\t<img src=\"assets/img/login.png\" alt=\"\">
\t\t\t</div>
\t\t</div>

\t\t<div class=\"sign-up\">
\t\t\t<div class=\"img-container\">
\t\t\t\t<img src=\"assets/img/signup.png\" alt=\"\">
\t\t\t</div>
\t\t\t<div class=\"form-container\">
\t\t\t\t<form method=\"POST\">
\t\t\t\t\t<input type=\"hidden\" name=\"action\" value=\"signUp\">
\t\t\t\t\t<h2>Creer un compte</h2>
\t\t\t\t\t<div class=\"field\">
\t\t\t\t\t\t<label for=\"lastName\">Nom</label>
\t\t\t\t\t\t<input type=\"text\" name=\"lastName\" id=\"lastName\" value=\"";
        // line 53
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["post"] ?? null), "lastName", [], "any", false, false, false, 53), "html", null, true);
        echo "\">
\t\t\t\t\t\t<p class=\"message warning\">";
        // line 54
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["registerMessages"] ?? null), "lastName", [], "any", false, false, false, 54), "html", null, true);
        echo "</p>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"field\">
\t\t\t\t\t\t<label for=\"firstName\">Prenom</label>
\t\t\t\t\t\t<input type=\"text\" name=\"firstName\" id=\"firstName\" value=\"";
        // line 58
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["post"] ?? null), "firstName", [], "any", false, false, false, 58), "html", null, true);
        echo "\">
\t\t\t\t\t\t<p class=\"message warning\">";
        // line 59
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["registerMessages"] ?? null), "firstName", [], "any", false, false, false, 59), "html", null, true);
        echo "</p>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"field\">
\t\t\t\t\t\t<label for=\"username\">Username</label>
\t\t\t\t\t\t<input type=\"text\" name=\"username\" id=\"username\" value=\"";
        // line 63
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["post"] ?? null), "username", [], "any", false, false, false, 63), "html", null, true);
        echo "\">
\t\t\t\t\t\t<p class=\"message warning\">";
        // line 64
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["registerMessages"] ?? null), "username", [], "any", false, false, false, 64), "html", null, true);
        echo "</p>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"field\">
\t\t\t\t\t\t<label for=\"email\">Email</label>
\t\t\t\t\t\t<input type=\"email\" name=\"email\" id=\"email\" value=\"";
        // line 68
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["post"] ?? null), "email", [], "any", false, false, false, 68), "html", null, true);
        echo "\">
\t\t\t\t\t\t<p class=\"message warning\">";
        // line 69
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["registerMessages"] ?? null), "email", [], "any", false, false, false, 69), "html", null, true);
        echo "</p>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"field\">
\t\t\t\t\t\t<label for=\"password\">Mot de passe</label>
\t\t\t\t\t\t<input type=\"password\" name=\"password\" id=\"password\">
\t\t\t\t\t\t<p class=\"message warning\">";
        // line 74
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["registerMessages"] ?? null), "password", [], "any", false, false, false, 74), "html", null, true);
        echo "</p>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"field\">
\t\t\t\t\t\t<label for=\"passwordConfirmation\">Confirmer mot de passe</label>
\t\t\t\t\t\t<input type=\"password\" name=\"passwordConfirmation\" id=\"passwordConfirmation\">
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"buttons\">
\t\t\t\t\t\t<a class=\"btn outline toggle\">Se connecter</a>
\t\t\t\t\t\t<button type=\"submit\" class=\"btn fill\">S'inscrire</button>
\t\t\t\t\t</div>
\t\t\t\t</form>
\t\t\t</div>

\t\t</div>
\t\t<div class=\"back\">
\t\t\t<a href=\"/\"><img src=\"assets/img/back-100.png\" alt=\"\" class=\"back-btn\"></a>
\t\t</div>
\t</div>
</div>
";
    }

    // line 96
    public function block_bottom_js($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 97
        echo "<script>
\tconsole.log(document.querySelectorAll('.toggle'))
\tdocument.querySelectorAll('a.toggle').forEach(element => {
\t\telement.addEventListener('click', toggle)
\t})

\tfunction toggle() {
\t\tdocument.querySelector('.content').classList.toggle('signing-up')
\t}
</script>
";
    }

    public function getTemplateName()
    {
        return "user/login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  195 => 97,  191 => 96,  167 => 74,  159 => 69,  155 => 68,  148 => 64,  144 => 63,  137 => 59,  133 => 58,  126 => 54,  122 => 53,  97 => 31,  87 => 24,  76 => 16,  72 => 14,  68 => 13,  63 => 9,  59 => 8,  53 => 4,  49 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'layout.html.twig' %}

{% block title %}
{{ parent() }}Connexion | Inscription
{% endblock %}


{% block css %}
<link rel=\"stylesheet/less\" href=\"/assets/css/login.less\">
{% endblock %}


{% block body %}
<!-- messages -->
<div class=\"container\">
\t<div class=\"content {{ classCss }}\">
\t\t<div class=\"sign-in\">
\t\t\t<div class=\"form-container\">
\t\t\t\t<form method=\"POST\">
\t\t\t\t\t<input type=\"hidden\" name=\"action\" value=\"login\">
\t\t\t\t\t<h2>Connexion</h2>
\t\t\t\t\t<div class=\"field\">
\t\t\t\t\t\t<label for=\"username\">Username</label>
\t\t\t\t\t\t<input type=\"text\" name=\"username\" id=\"username\" value=\"{{ post.username }}\">
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"field\">
\t\t\t\t\t\t<label for=\"password\">Mot de passe</label>
\t\t\t\t\t\t<input type=\"password\" name=\"password\" id=\"password\">
\t\t\t\t\t</div>

\t\t\t\t\t<p class=\"message warning\">{{loginMessages.username}}</p>
\t\t\t\t\t<div class=\"buttons\">
\t\t\t\t\t\t<input type=\"submit\" value=\"Se connecter\" class=\"btn fill\">
\t\t\t\t\t\t<a class=\"btn outline toggle\">S'inscrire</a>
\t\t\t\t\t</div>
\t\t\t\t</form>
\t\t\t</div>
\t\t\t<div class=\"img-container\">
\t\t\t\t<img src=\"assets/img/login.png\" alt=\"\">
\t\t\t</div>
\t\t</div>

\t\t<div class=\"sign-up\">
\t\t\t<div class=\"img-container\">
\t\t\t\t<img src=\"assets/img/signup.png\" alt=\"\">
\t\t\t</div>
\t\t\t<div class=\"form-container\">
\t\t\t\t<form method=\"POST\">
\t\t\t\t\t<input type=\"hidden\" name=\"action\" value=\"signUp\">
\t\t\t\t\t<h2>Creer un compte</h2>
\t\t\t\t\t<div class=\"field\">
\t\t\t\t\t\t<label for=\"lastName\">Nom</label>
\t\t\t\t\t\t<input type=\"text\" name=\"lastName\" id=\"lastName\" value=\"{{post.lastName}}\">
\t\t\t\t\t\t<p class=\"message warning\">{{registerMessages.lastName}}</p>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"field\">
\t\t\t\t\t\t<label for=\"firstName\">Prenom</label>
\t\t\t\t\t\t<input type=\"text\" name=\"firstName\" id=\"firstName\" value=\"{{post.firstName}}\">
\t\t\t\t\t\t<p class=\"message warning\">{{registerMessages.firstName}}</p>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"field\">
\t\t\t\t\t\t<label for=\"username\">Username</label>
\t\t\t\t\t\t<input type=\"text\" name=\"username\" id=\"username\" value=\"{{post.username}}\">
\t\t\t\t\t\t<p class=\"message warning\">{{registerMessages.username}}</p>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"field\">
\t\t\t\t\t\t<label for=\"email\">Email</label>
\t\t\t\t\t\t<input type=\"email\" name=\"email\" id=\"email\" value=\"{{post.email}}\">
\t\t\t\t\t\t<p class=\"message warning\">{{registerMessages.email}}</p>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"field\">
\t\t\t\t\t\t<label for=\"password\">Mot de passe</label>
\t\t\t\t\t\t<input type=\"password\" name=\"password\" id=\"password\">
\t\t\t\t\t\t<p class=\"message warning\">{{registerMessages.password}}</p>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"field\">
\t\t\t\t\t\t<label for=\"passwordConfirmation\">Confirmer mot de passe</label>
\t\t\t\t\t\t<input type=\"password\" name=\"passwordConfirmation\" id=\"passwordConfirmation\">
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"buttons\">
\t\t\t\t\t\t<a class=\"btn outline toggle\">Se connecter</a>
\t\t\t\t\t\t<button type=\"submit\" class=\"btn fill\">S'inscrire</button>
\t\t\t\t\t</div>
\t\t\t\t</form>
\t\t\t</div>

\t\t</div>
\t\t<div class=\"back\">
\t\t\t<a href=\"/\"><img src=\"assets/img/back-100.png\" alt=\"\" class=\"back-btn\"></a>
\t\t</div>
\t</div>
</div>
{% endblock %}


{% block bottom_js %}
<script>
\tconsole.log(document.querySelectorAll('.toggle'))
\tdocument.querySelectorAll('a.toggle').forEach(element => {
\t\telement.addEventListener('click', toggle)
\t})

\tfunction toggle() {
\t\tdocument.querySelector('.content').classList.toggle('signing-up')
\t}
</script>
{% endblock %}", "user/login.html.twig", "C:\\xampp\\htdocs\\project-php\\templates\\user\\login.html.twig");
    }
}

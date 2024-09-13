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

/* home/index.html.twig */
class __TwigTemplate_c7a8086f054b3455e0686080d2cf679a5904144241984abd14b7b2624b0386b2 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "/base/base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("/base/base.html.twig", "home/index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "    <h3 style=\"
          color: #ffc107;
          font-family: Vertexio;
          text-decoration: none;
          margin-top: 0px;
          background-color: #2b79b5;
          padding: 8px;
          text-transform: uppercase;
          font-size: 26px;
          font-weight: bold;
\">     &nbsp; Listes ";
        // line 14
        echo twig_escape_filter($this->env, ($context["count"] ?? null), "html", null, true);
        echo " des cours / étudiants </h3>
    <table class=\"table\" id=\"userTable\">
        <thead>

        <tr style=\"background-color: #2273a6\">
            <th bgcolor=\"#2273a6\">Nom</th>
            <th bgcolor=\"#2273a6\">Code</th>
            <th bgcolor=\"#2273a6\">Année</th>
            <th bgcolor=\"#2273a6\">Code II </th>
        </tr>
        </thead>
        <tbody>
        ";
        // line 26
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["results"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["table"]) {
            // line 27
            echo "            <tr>
                <td> <a href=\"\" style=\"text-decoration: none\"> ";
            // line 28
            echo twig_get_attribute($this->env, $this->source, $context["table"], "nom", [], "any", false, false, false, 28);
            echo " </a> </td>
                <td> ";
            // line 29
            echo twig_get_attribute($this->env, $this->source, $context["table"], "code", [], "any", false, false, false, 29);
            echo "</td>
                <td> ";
            // line 30
            echo twig_get_attribute($this->env, $this->source, $context["table"], "annee", [], "any", false, false, false, 30);
            echo "</td>
                <td> ";
            // line 31
            echo twig_get_attribute($this->env, $this->source, $context["table"], "code2", [], "any", false, false, false, 31);
            echo "</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['table'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 34
        echo "        </tbody>
        <br/>
    </table>


    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css\">
    <script src=\"//cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>
    <script type=\"text/javascript\" src=\"//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js\"></script>

";
    }

    public function getTemplateName()
    {
        return "home/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  105 => 34,  96 => 31,  92 => 30,  88 => 29,  84 => 28,  81 => 27,  77 => 26,  62 => 14,  50 => 4,  46 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"/base/base.html.twig\" %}

{% block content %}
    <h3 style=\"
          color: #ffc107;
          font-family: Vertexio;
          text-decoration: none;
          margin-top: 0px;
          background-color: #2b79b5;
          padding: 8px;
          text-transform: uppercase;
          font-size: 26px;
          font-weight: bold;
\">     &nbsp; Listes {{ count }} des cours / étudiants </h3>
    <table class=\"table\" id=\"userTable\">
        <thead>

        <tr style=\"background-color: #2273a6\">
            <th bgcolor=\"#2273a6\">Nom</th>
            <th bgcolor=\"#2273a6\">Code</th>
            <th bgcolor=\"#2273a6\">Année</th>
            <th bgcolor=\"#2273a6\">Code II </th>
        </tr>
        </thead>
        <tbody>
        {% for table in results %}
            <tr>
                <td> <a href=\"\" style=\"text-decoration: none\"> {{ table.nom   | raw  }} </a> </td>
                <td> {{ table.code  | raw  }}</td>
                <td> {{ table.annee | raw  }}</td>
                <td> {{ table.code2 | raw  }}</td>
            </tr>
        {% endfor %}
        </tbody>
        <br/>
    </table>


    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css\">
    <script src=\"//cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>
    <script type=\"text/javascript\" src=\"//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js\"></script>

{% endblock %}




", "home/index.html.twig", "/var/www/html/eleves/src/Bundles/AcmeBundle/Templates/home/index.html.twig");
    }
}

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

/* themes/contrib/bootstrap_custom/templates/views/views-mini-pager.html.twig */
class __TwigTemplate_78be2c710deb336e740dd1e86f04448ba734f6f98dcebe2b34cca130e4301d3a extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "    ";
        // line 14
        echo "    ";
        if ((twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "previous", [], "any", false, false, true, 14) || twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "next", [], "any", false, false, true, 14))) {
            // line 15
            echo "      <nav aria-label=\"Page navigation\">
        <h4 class=\"visually-hidden\">";
            // line 16
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Pagination"));
            echo "</h4>
        <ul class=\"js-pager__items pagination\">
          ";
            // line 18
            if (twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "previous", [], "any", false, false, true, 18)) {
                // line 19
                echo "            <li class=\"page-item\">
              <a class=\"page-link\" href=\"";
                // line 20
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "previous", [], "any", false, false, true, 20), "href", [], "any", false, false, true, 20), 20, $this->source), "html", null, true);
                echo "\" title=\"";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Go to previous page"));
                echo "\" rel=\"prev\"";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->withoutFilter($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "previous", [], "any", false, false, true, 20), "attributes", [], "any", false, false, true, 20), 20, $this->source), "href", "title", "rel"), "html", null, true);
                echo ">
                <span class=\"visually-hidden\">";
                // line 21
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Previous page"));
                echo "</span>
                <span aria-hidden=\"true\">";
                // line 22
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "previous", [], "any", false, true, true, 22), "text", [], "any", true, true, true, 22)) ? (_twig_default_filter($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "previous", [], "any", false, true, true, 22), "text", [], "any", false, false, true, 22), 22, $this->source), t("‹‹"))) : (t("‹‹"))), "html", null, true);
                echo "</span>
              </a>
            </li>
          ";
            }
            // line 26
            echo "          ";
            if (twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "current", [], "any", false, false, true, 26)) {
                // line 27
                echo "            <li class=\"page-item\">
              <span class=\"page-link\">
                ";
                // line 29
                echo t("Page @items.current", array("@items.current" => twig_get_attribute($this->env, $this->source,                 // line 30
($context["items"] ?? null), "current", [], "any", false, false, true, 30), ));
                // line 32
                echo "              </span>
            </li>
          ";
            }
            // line 35
            echo "          ";
            if (twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "next", [], "any", false, false, true, 35)) {
                // line 36
                echo "            <li class=\"page-item\">
              <a class=\"page-link\" href=\"";
                // line 37
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "next", [], "any", false, false, true, 37), "href", [], "any", false, false, true, 37), 37, $this->source), "html", null, true);
                echo "\" title=\"";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Go to next page"));
                echo "\" rel=\"next\"";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->withoutFilter($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "next", [], "any", false, false, true, 37), "attributes", [], "any", false, false, true, 37), 37, $this->source), "href", "title", "rel"), "html", null, true);
                echo ">
                <span class=\"visually-hidden\">";
                // line 38
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Next page"));
                echo "</span>
                <span aria-hidden=\"true\">";
                // line 39
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "next", [], "any", false, true, true, 39), "text", [], "any", true, true, true, 39)) ? (_twig_default_filter($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "next", [], "any", false, true, true, 39), "text", [], "any", false, false, true, 39), 39, $this->source), t("››"))) : (t("››"))), "html", null, true);
                echo "</span>
              </a>
            </li>
          ";
            }
            // line 43
            echo "        </ul>
      </nav>
    ";
        }
    }

    public function getTemplateName()
    {
        return "themes/contrib/bootstrap_custom/templates/views/views-mini-pager.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  116 => 43,  109 => 39,  105 => 38,  97 => 37,  94 => 36,  91 => 35,  86 => 32,  84 => 30,  83 => 29,  79 => 27,  76 => 26,  69 => 22,  65 => 21,  57 => 20,  54 => 19,  52 => 18,  47 => 16,  44 => 15,  41 => 14,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("    {#
    /**
     * @file
     * Default theme implementation for a views mini-pager.
     *
     * Available variables:
     * - items: List of pager items.
     *
     * @see template_preprocess_views_mini_pager()
     *
     * @ingroup themeable
     */
    #}
    {% if items.previous or items.next %}
      <nav aria-label=\"Page navigation\">
        <h4 class=\"visually-hidden\">{{ 'Pagination'|t }}</h4>
        <ul class=\"js-pager__items pagination\">
          {% if items.previous %}
            <li class=\"page-item\">
              <a class=\"page-link\" href=\"{{ items.previous.href }}\" title=\"{{ 'Go to previous page'|t }}\" rel=\"prev\"{{ items.previous.attributes|without('href', 'title', 'rel') }}>
                <span class=\"visually-hidden\">{{ 'Previous page'|t }}</span>
                <span aria-hidden=\"true\">{{ items.previous.text|default('‹‹'|t) }}</span>
              </a>
            </li>
          {% endif %}
          {% if items.current %}
            <li class=\"page-item\">
              <span class=\"page-link\">
                {% trans %}
                  Page {{ items.current }}
                {% endtrans %}
              </span>
            </li>
          {% endif %}
          {% if items.next %}
            <li class=\"page-item\">
              <a class=\"page-link\" href=\"{{ items.next.href }}\" title=\"{{ 'Go to next page'|t }}\" rel=\"next\"{{ items.next.attributes|without('href', 'title', 'rel') }}>
                <span class=\"visually-hidden\">{{ 'Next page'|t }}</span>
                <span aria-hidden=\"true\">{{ items.next.text|default('››'|t) }}</span>
              </a>
            </li>
          {% endif %}
        </ul>
      </nav>
    {% endif %}
", "themes/contrib/bootstrap_custom/templates/views/views-mini-pager.html.twig", "/Applications/MAMP/htdocs/drupaldemo/themes/contrib/bootstrap_custom/templates/views/views-mini-pager.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 14, "trans" => 29);
        static $filters = array("t" => 16, "escape" => 20, "without" => 20, "default" => 22);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if', 'trans'],
                ['t', 'escape', 'without', 'default'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}

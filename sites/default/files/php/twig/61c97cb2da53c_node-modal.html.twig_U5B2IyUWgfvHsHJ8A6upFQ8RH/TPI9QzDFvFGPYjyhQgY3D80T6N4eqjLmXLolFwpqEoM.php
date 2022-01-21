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

/* modules/drupaltest/templates/node-modal.html.twig */
class __TwigTemplate_8323af9f9e8dc82851b37bfadb4fa4f72a110decdf2c3fe409cbdae1fced27d9 extends \Twig\Template
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
        echo "<a class=\"use-ajax\"
   data-dialog-options=\"{&quot;width&quot;:600}\"
   data-dialog-type=\"modal\"
   href=\"node/";
        // line 4
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["nid"] ?? null), 4, $this->source), "html", null, true);
        echo "\">
   ";
        // line 5
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Click to open Node 1 with Modal box"));
        echo "
</a>";
    }

    public function getTemplateName()
    {
        return "modules/drupaltest/templates/node-modal.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  48 => 5,  44 => 4,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<a class=\"use-ajax\"
   data-dialog-options=\"{&quot;width&quot;:600}\"
   data-dialog-type=\"modal\"
   href=\"node/{{nid}}\">
   {{ 'Click to open Node 1 with Modal box'|t}}
</a>", "modules/drupaltest/templates/node-modal.html.twig", "/Applications/MAMP/htdocs/drupaldemo/modules/drupaltest/templates/node-modal.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array("escape" => 4, "t" => 5);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                [],
                ['escape', 't'],
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

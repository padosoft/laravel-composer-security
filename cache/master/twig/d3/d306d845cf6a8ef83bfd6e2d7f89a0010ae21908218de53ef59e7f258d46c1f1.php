<?php

/* classes.twig */
class __TwigTemplate_9a678aef793fca7e4fb479d8aceced02dace3aa9a52ddbb6e08b7ac9147f6ee9 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout/layout.twig", "classes.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body_class' => array($this, 'block_body_class'),
            'page_content' => array($this, 'block_page_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout/layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        $context["__internal_be743c5cd8557cea54a0d042ffddf7cd609e5de609f236a0a5f869eab02a5197"] = $this->loadTemplate("macros.twig", "classes.twig", 2);
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "All Classes | ";
        $this->displayParentBlock("title", $context, $blocks);
    }

    // line 4
    public function block_body_class($context, array $blocks = array())
    {
        echo "classes";
    }

    // line 6
    public function block_page_content($context, array $blocks = array())
    {
        // line 7
        echo "    <div class=\"page-header\">
        <h1>Classes</h1>
    </div>

    ";
        // line 11
        echo $context["__internal_be743c5cd8557cea54a0d042ffddf7cd609e5de609f236a0a5f869eab02a5197"]->getrender_classes((isset($context["classes"]) ? $context["classes"] : $this->getContext($context, "classes")));
        echo "
";
    }

    public function getTemplateName()
    {
        return "classes.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  55 => 11,  49 => 7,  46 => 6,  40 => 4,  33 => 3,  29 => 1,  27 => 2,  11 => 1,);
    }
}
/* {% extends "layout/layout.twig" %}*/
/* {% from "macros.twig" import render_classes %}*/
/* {% block title %}All Classes | {{ parent() }}{% endblock %}*/
/* {% block body_class 'classes' %}*/
/* */
/* {% block page_content %}*/
/*     <div class="page-header">*/
/*         <h1>Classes</h1>*/
/*     </div>*/
/* */
/*     {{ render_classes(classes) }}*/
/* {% endblock %}*/
/* */

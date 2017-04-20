<?php

/* index.twig */
class __TwigTemplate_89e4e7ac3acd36363edf6e1d346046ef5aaae064b898bc84ebe7aefe833594e5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!doctype html>
<html lang=\"en\">
<head>
  <meta charset=\"UTF-8\">
  <title>Optimizer</title>
  <link rel=\"stylesheet\" href=\"./css/main.css\">
  <link href=\"//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css\" rel=\"stylesheet\">
  <script src=\"./js/jquery.min.js\"></script>
  <script src=\"./js/html2canvas.svg.js\"></script>
</head>
<body>
<div id=\"page\">
  <section id=\"content\">
    <h1>Image Optimizer</h1>
    <div class=\"progress hidden\">
      <div class=\"progress-bar progress-bar-success\" role=\"progressbar\" aria-valuenow=\"0\"
           aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width:0%\">
      </div>
      <span class=\"percent\">0% Complete (success)</span>
      <span class=\"hidden complete\"><i class=\"icon-ok\"></i> Complete (<a href=\"#\">Download Zip</a>)</span>
    </div>
    <form class=\"form-horizontal\" role=\"form\" method=\"post\">
      <div class=\"form-group\">
          <input type=\"text\" class=\"form-control\" id=\"path\" name=\"path\" placeholder=\"Enter path\">
          <button id=\"optimize\" name=\"optimize\" type=\"submit\" class=\"btn btn-default pull-right btn-success\"><i class=\"icon-magic\"></i></button>
        ";
        // line 27
        echo "          ";
        // line 28
        echo "        ";
        // line 29
        echo "      </div>
    </form>
    <div class=\"alert alert-danger hidden\"></div>
  </section>
</div>
<script src=\"./js/main.js\"></script>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "index.twig";
    }

    public function getDebugInfo()
    {
        return array (  50 => 29,  48 => 28,  46 => 27,  19 => 1,);
    }
}
/* <!doctype html>*/
/* <html lang="en">*/
/* <head>*/
/*   <meta charset="UTF-8">*/
/*   <title>Optimizer</title>*/
/*   <link rel="stylesheet" href="./css/main.css">*/
/*   <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">*/
/*   <script src="./js/jquery.min.js"></script>*/
/*   <script src="./js/html2canvas.svg.js"></script>*/
/* </head>*/
/* <body>*/
/* <div id="page">*/
/*   <section id="content">*/
/*     <h1>Image Optimizer</h1>*/
/*     <div class="progress hidden">*/
/*       <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0"*/
/*            aria-valuemin="0" aria-valuemax="100" style="width:0%">*/
/*       </div>*/
/*       <span class="percent">0% Complete (success)</span>*/
/*       <span class="hidden complete"><i class="icon-ok"></i> Complete (<a href="#">Download Zip</a>)</span>*/
/*     </div>*/
/*     <form class="form-horizontal" role="form" method="post">*/
/*       <div class="form-group">*/
/*           <input type="text" class="form-control" id="path" name="path" placeholder="Enter path">*/
/*           <button id="optimize" name="optimize" type="submit" class="btn btn-default pull-right btn-success"><i class="icon-magic"></i></button>*/
/*         {#<div class="checkbox pull-left">#}*/
/*           {#<label><input type="checkbox" value="" name="replace" id="replace">Replace origin files</label>#}*/
/*         {#</div>#}*/
/*       </div>*/
/*     </form>*/
/*     <div class="alert alert-danger hidden"></div>*/
/*   </section>*/
/* </div>*/
/* <script src="./js/main.js"></script>*/
/* </body>*/
/* </html>*/

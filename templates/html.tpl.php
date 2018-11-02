<?php

/**
 * @file
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE tag.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 *
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 */
?><?php print $doctype; ?>
<html lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>" <?php print $rdf->version . $rdf->namespaces; ?> class="no-js">
<head<?php print $rdf->profile; ?>>

<?php print $head; ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5P793ZX');</script>
<!-- End Google Tag Manager -->
<title><?php print $head_title; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="author" content="Vanderbilt University School of Medicine" />

<?php print $styles; ?>
<!-- Swap class "no-js" with "js" on html tag. Hide items that will be processed by js. -->
<script>(function(h){h.className = h.className.replace('no-js', 'js')})(document.documentElement)</script>
<style>.js .hide-until-processed { display: none; }</style>

<!-- Accent Color -->
<style>
a, a:hover, button.search-submit:hover .icon-search,
.nav-pills a:hover, .nav-pills a:focus,
.nav-pills a, .nav-pills a:visited {
  color: <?php print $link_color ?>;
}
.site-link-color, .site-link-color:hover, .site-link-color:focus, .site-link-color:visited {
  color: <?php print $link_color ?> !important;
}
.site-link-color-border {
  border-color: <?php print $link_color ?> !important;
}
.hero-homepage .container-hero-homepage-slideshow-and-sidebar, .sidenav, .sidenav h1, a.som-menu-dd-button, .app .banner, .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-list > li.active > a, .nav-list > li.active > a:hover, .blockstyle-accent > .block-inner, .blockstyle-lightaccent > .block-inner, .blockstyle-accentheader > .block-inner {
  background: <?php print $site_accent ?>;
}
.site-accent-background-color {
  background: <?php print $site_accent ?> !important;
}
blockquote {
  border-left-color: <?php print $site_accent ?>;
}

.fc-event-inner {
    border-top: 2px solid <?php print $link_color ?> !important;
}

.fc-event-time,
.fc-event-time a {
  color: <?php print $link_color ?> !important;
}

.fc-event-default {
  background-color: <?php print $site_accent ?> !important;
  color: <?php print $link_color ?> !important;
}
.fc-state-highlight {
  border-color: <?php print $link_color ?> !important;
}

.btn-accent-color {
  background-color: <?php print $site_accent ?> !important;
}

.region-featured .block-inner {
  background: <?php print $site_complement ?> !important;
}

.block-title-wrapper h1,
.header-page h1 {
  color: <?php print $site_complement ?> !important;
  font-weight: 400 !important;
  line-height: 1.5em !important;
}

.block-content h2, .category h2, .block-content h3, .block-content h4, .block-content h5 {
  color: <?php print $site_complement ?> !important;
}

.hero-text h2 {
  color: white !important;
}

.blockstyle-accentheader h1,
.blockstyle-accent h1 {
  color: white !important;
}

#block-barista-blocks-vusm-prospective-students-menu h1 {
  color: white !important;
}

</style>
<!-- Polyfill for HTML5 support in older browsers - respond and html5shiv -->
  <!--[if lt IE 9]>
  <script type="text/javascript" src="<?php print base_path() . path_to_theme("macchiato"); ?>/assets/vendor/html5shiv-and-respond/html5shiv-and-respond-old.js"></script>
  <![endif]-->

  <?php print $scripts; ?>
  <!-- fav and touch icons -->
  <link rel="shortcut icon" href="https://medschool.vanderbilt.edu/shared-assets/macchiato/2.0.3/images/favicon.ico" />
  <link rel="apple-touch-icon" href="https://medschool.vanderbilt.edu/shared-assets/macchiato/2.0.3/images/apple-touch-icon.png" />
  <!-- SiteImprove - end of head -->
  <script type="text/javascript">
          /*<![CDATA[*/
          (function() {
              var sz = document.createElement('script'); sz.type = 'text/javascript'; sz.async = true;
              sz.src = '//us2.siteimprove.com/js/siteanalyze_55081.js';
              var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sz, s);
          })();
          /*]]>*/
  </script>
  <!-- End SiteImprove -->
</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?> itemscope itemtype="http://schema.org/WebPage">
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5P793ZX"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->


  <span class="font-preload"><span class="f1"></span><span class="f2"></span><span class="f3"></span></span>
  <a href="#main" class="skip-link">skip to main content <i class="icon-double-angle-down"></i></a>
  <!-- Encourage users to update IE <=8 -->
  <!--[if lte IE 8]>
  <p class="chromeframe">Welcome, visitor.  You are using an extremely <strong>outdated</strong> browser. We suggest <a href="http://browsehappy.com/">upgrading your browser</a>.</p>
  <![endif]-->

  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
</body>
</html>

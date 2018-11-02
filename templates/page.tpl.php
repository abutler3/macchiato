<?php
global $base_url;
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/garland.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 */
?>


<!-- Begin Topbar.  -->
<div class="topbar">
  <div class="container">
    <div class="row" role="navigation"><div class="col-sm-12">

      <a href="#" class="btn-search-toggle collapsed" id="cssMonitorSearchToggle" data-toggle="collapse" data-target="#searchFormWrapper"><i class="fa fa-search"></i></a>

      <?php if(!theme_get_setting("use_nonbranded_template")){ ?>

      <div class="container-brand-dropdown">
        <div class="container-som-logo"><a href="#" id="brandCollapseButton" class="btn-brand-dropdown-collapse change-to-x" data-toggle="collapse" data-target="#brandDropdown"><i class="fa fa-caret-down"></i></a>
          <a href="http://ww2.mc.vanderbilt.edu" class="link-som-logo">
          <img src="<?php print $base_path . path_to_theme("macchiato"); ?>/assets/images/VUMCNavBar.jpg" data-retina-src="<?php print $base_path . path_to_theme("macchiato"); ?>/assets/images/VUMCNavBarRetina.jpg" alt="Vanderbilt University Medical Center" /></a>

        </div>

        <div id="brandDropdown" class="brand-dropdown collapse out">

          <?php if(!theme_get_setting("use_vanderbilt_template") && !theme_get_setting("use_v_vanderbilt_template")){ ?>

          <!-- Top Links (on small screens, embedded within brand dropdown) -->
          <ul class="brandbar-toplinks">
            <?php $toplinks = '
            <li><a href="https://phonedirectory.vanderbilt.edu/cdb/">People Finder</a></li>
            <li><a href="https://www.vanderbilthealth.com">For Patients and Visitors</a></li>
            ';
            echo $toplinks;
            ?>
          </ul>
          <!-- End Top Links -->

          <?php } ?>

          <ul>
           <li><a href="https://www.vanderbilthealth.com">For Patients and Visitors</a></li>
           <li><a href="http://medschool.vanderbilt.edu">Vanderbilt University School of Medicine</a></li>
           <li><a href="https://ww2.mc.vanderbilt.edu/gme/">Office of Postgraduate Medical Education</a></li>
           <li><a href="https://vumc.org/faculty">Faculty Affairs</a></li>
           <li><a href="http://research.vanderbilt.edu/">Office of Research</a></li>
           <li><a href="https://vumc.org/postdoc/">Office of Postdoctoral Affairs</a></li>

         </ul>

       </div>
     </div>

     <?php if(!theme_get_setting("use_vanderbilt_template") && !theme_get_setting("use_v_vanderbilt_template")){ ?>
     <!-- Top Links (repeated from above, for larger screens) -->
     <ul class="list-topbar-toplinks">
      <?php echo $toplinks; ?>
    </ul>
    <!-- End Top Links -->
    <?php } ?>
    <?php } ?>

  </div></div>
</div>
</div>
<!-- End Topbar -->

<!-- Begin Site Banner -->
<div class="banner" role="banner">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="wrapper-form-search <?php if($sitename_is_prefixed) { ?>title-has-prefix<?php } ?>" id="searchFormWrapper">
            <?php
            $url = $base_url;
            // $url2 = $GLOBALS['base_url'];
            $path = parse_url($url, PHP_URL_PATH);

            $firstSubDir = explode('/', $path)[1]; // [0] is the domain [1] is the first subdirectory, etc.
            // if ($firstSubDir = nil) {
            //   $firstSubDir = 'www.vumc.org';
            // }
            // echo $firstSubDir; //one
          ?>
          <form class="form-search" action="https://search.vumc.org" role="search" id="searchFormWrapper">
            <div class="container-search-button-and-arrow">
              <button name="op" value="Search" class="btn-search-submit" type="submit"><i class="fa fa-search"></i><span class="sr-only">Submit</span></button>
            </div>
            <div class="wrapper-input-search">
              <label><span class="sr-only">Search</span> <input maxlength="255" name="query" class="form-control" type="text" placeholder="Search"><span></span></label>
            </div>
            <input type="hidden" name="pipeline" value="MC-vumc-org-drupal">
            <input type="hidden" name="collection" value="Vanderbilt">
            <input type="hidden" name="collection_ss" value="vumc_org_drupal">
            <input type="hidden" name="site" value="vumc.org/<?php echo $firstSubDir; ?>">
          </form>
        </div>
        <div class="wrapper-header-site">
          <?php if(theme_get_setting("act_like_vusm_homepage")){
            ?>
          <h1 class="header-site"><a href="/"><img src="<?php print $base_path . path_to_theme("macchiato"); ?>/assets/images/logo-stacked.png" data-retina-src="<?php print $base_path . path_to_theme("macchiato"); ?>/assets/images/logo-stacked@2x.png" alt="Vanderbilt University School of Medicine" width="350" height="51" /></a></h1>
          <?php } else {
            ?>

          <h1 class="header-site">
            <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><?php print $formatted_site_name; ?></a>
          </h1>
          <?php print $parent_entity_links; ?>

          <?php } ?>
        </div>
      </div>
    </div>

    <div class="row wrapper-nav-site" id="siteNavWrapper"><div class="col-sm-12">
        <nav class="nav-site" id="siteNav" role="navigation">
          <?php
          print $dropdown_menu;
          ?>
        </nav>
        <span id="cssMonitorDropdownMenu"></span>
      </div></div>



    </div>
  </div>
  <!-- End Site Banner -->

  <?php if ($page['featured']){ ?>
  <?php print render($page['featured']); ?>
  <?php } ?>


  <div class="container">

    <div class="row main-content-container">

      <!-- Main content column.  In a two column layout, this section is class span8.  For a full width layout, choose span12 -->

      <?php if ($page['sidebar_first']) { ?>
        <section class="col-sm-8 section-main-content" role="main" id="main">
      <?php } else { ?>
        <section class="col-sm-12 section-main-content" role="main" id="main">
      <?php } ?>

          <!-- Primary page content -->
        <?php if ($breadcrumb): ?>
          <div id="breadcrumb"><?php print $breadcrumb; ?></div>
        <?php endif; ?>

        <?php print $messages; ?>

        <?php if ($tabs): ?>
        <div class="drupal-tabs"><?php print render($tabs); ?></div>
      <?php endif; ?>

      <!-- Page header -->
      <?php // If this is a node, the title will be output by the title block; ?>
      <?php if (!isset($node)): ?>
      <?php print render($title_prefix); ?>
      <?php if ($title): ?>
      <header class="header-page"><h1><?php print $title; ?></h1></header>
    <?php endif; ?>
    <?php print render($title_suffix); ?>
  <?php endif; ?>
  <?php
    // If user logged in and user clicks on Redcap link, user's VUNetID is session_set_save_handler
    // and entered in the form on the first RedCap page the user sees
    if (isset($user->name)) {
      drupal_add_js('var bool = "'. $user->name .'";
      jQuery(document).on("click", "a[href]", function (event) {
          var clickedUrl = this.href;
          if (this.hostname == "redcap.vanderbilt.edu") {
            event.preventDefault();
            location.href = clickedUrl + "&vunetid=" + bool;
          }

      });',
        array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)
      );
      // For Demo
      // drupal_add_js('var bool = "'. $user->name .'";
      // jQuery(document).on("click", "a[href]", function (event) {
      //     var clickedUrl = "https://redcap.vanderbilt.edu/surveys/?s=YAFLWHRNWW";
      //     if (this.hostname != "redcap.vanderbilt.edu") {
      //       event.preventDefault();
      //       location.href = clickedUrl + "&vunetid=" + bool;
      //     }
      //
      // });',
      //   array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)
      // );
    }
  ?>
  <?php print render($page['help']); ?>

  <?php if ($action_links): ?>
  <ul class="action-links"><?php print render($action_links); ?></ul>
<?php endif; ?>

<?php print render($page['content']); ?>

<?php print $feed_icons; ?>

</section>
<!-- End of main content column -->


<?php if ($page['sidebar_first']): ?>
  <!-- Sidebar column -->
  <div class="col-sm-4 sidebar" role="complementary">
    <div class="sidebar-inner">

      <?php print render($page['sidebar_first']); ?>

    </div>
  </div>
  <!-- End of sidebar column -->
<?php endif; ?>

</div>



<!-- Site Footer -->
<footer class="row footer" role="contentinfo"><div class="col-sm-12">

  <hr />

  <div class="footer-logo-container"><a href="http://ww2.mc.vanderbilt.edu"><img src="<?php print $base_path . path_to_theme("macchiato"); ?>/assets/images/vumcFINAL4_c.png" data-retina-src="<?php print $base_path . path_to_theme("macchiato"); ?>/assets/images/vumcFINAL4_c.png" alt="Vanderbilt University Medical Center" width="231" height="70" /></a></div>
  <small>
    <p>
      Copyright &copy; <?php echo date("Y"); ?>
      <a href="https://ww2.mc.vanderbilt.edu">Vanderbilt University Medical Center</a>.

      <a href="https://ww2.mc.vanderbilt.edu/WDCS/35030" rel="external">Issues with this site?</a><br />
      Vanderbilt University Medical Center is committed to principles of equal opportunity and affirmative&nbsp;action.

    </p></small>

  </div></footer>
  <!-- End of site footer -->

</div>





<?php print render($page['footer']); ?>

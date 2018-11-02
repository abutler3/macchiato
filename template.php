<?php

/**
 * @file
 * Contains theme override functions and preprocess functions for the macchiato theme.
 */

/**
 * Changes the default meta content-type tag to the shorter HTML5 version
 */
function macchiato_html_head_alter(&$head_elements) {
  $head_elements['system_meta_content_type']['#attributes'] = array(
    'charset' => 'utf-8'
    );
}

/**
 * Changes the search form to use the HTML5 "search" input attribute
 */
/*
function macchiato_preprocess_search_block_form(&$vars) {
  $vars['search_form'] = str_replace('type="text"', 'type="search"', $vars['search_form']);
}
*/

function macchiato_format_title($title){
  // wrap "unspecific" parts of site name with a span
  // List from MORE SPECIFIC to LEAST SPECIFIC... e.g., starts with Vanderbilt University School of Medicine before Vanderbilt Unversity
  $prefixes = array(
    '/^Division of /',      // starts with Division of
    '/^The Division of /',  
    '/^Department of /',    
    '/^The Department of /',
    '/^Institute of /',
    '/^The Institute of /',
    '/^The Institute for /',
    '/^Vanderbilt Institute of /',
    '/^Vanderbilt Institute for /',
    '/^School of /',
    '/^Office of the /',
    '/^Office of /',
    '/^The Office of /',
    '/^Section of /',
    '/^The Section of /',
    '/^Center for /',
    '/^Vanderbilt Center for /',
    '/^Program for/',
    '/^Program in/',
    '/^Vanderbilt University Medical Center /', 
    '/^Vanderbilt University /', 
    '/^Vanderbilt Medical Center /', 
    '/^Vanderbilt /',        

    );
  $suffixes = array(
    '/ Division$/',       // ends with Division
    '/ Department$/',       
    '/ Institute$/',
    '/ Office$/',
    '/ Laboratory$/',
    '/ Lab$/',
    '/ Group$/',
    '/ Groups$/',
    '/ Core$/',
    '/ Cores$/',
    '/ Shared Resource$/',
    '/ Service$/',
    '/ Team$/',
    '/ Program$/',
    '/ at Vanderbilt$/',
    '/ at Vanderbilt University$/',
    '/ at Vanderbilt University Medical Center$/',
    '/ at Vanderbilt Medical Center$/',
    '/ Center$/',
    '/ at VUMC$/',
    '/ at VUSM$/',
    );
  $new_needle = '<span>$0</span>';

  $old_title = $title;
  foreach($prefixes as $needle){
    $new_title = preg_replace($needle, '<span class="prefix">$0</span>', $title,1);
    if($new_title != $title){
      $title = $new_title;
      break;
    } 
  }
  foreach($suffixes as $needle){
    $new_title = preg_replace($needle, '<span class="suffix">$0</span>', $title,1);
    if($new_title != $title){
      $title = $new_title;
      break;
    } 
  }

// if nothing has changed, and there is a ':', wrap the second half
  if($old_title == $title && strpos($title,":")){
    $title = preg_replace('/(.*):(.*)/','$1: <span>$2</span>', $title,1);
  }

  return $title;
}

function macchiato_preprocess_page(&$vars) {
  // Wrap less significant parts of title with <span> (only first occurance)
  $vars['formatted_site_name'] = macchiato_format_title($vars["site_name"]);
  $vars['sitename_is_prefixed'] = strpos($vars['formatted_site_name'],'<span class="prefix">') === 0;

  // reduce size of title if that setting was set
  if(theme_get_setting("header_scale_factor")){
    $vars['formatted_site_name'] = '<div style="font-size:'.theme_get_setting("header_scale_factor").'">' . $vars['formatted_site_name'] . '</div>';
  }

  if (!module_exists('jquery_update'))
  {
    print "<h1>"  . t( 'Macchiato requires that jquery_update be enabled.') . "</h1>";
  }
  if (!module_exists('rdf'))
  {
    print "<h1>"  . t( 'Macchiato requires that rdf be enabled.') . "</h1>";
  }

  $top_menu_array = menu_navigation_links('main-menu');
  $vars['top_menu'] = theme('links__system_main_menu', array(
    'links' => $top_menu_array,
    'attributes' => array(
      'id' => 'main-menu',
      'class' => array(
        'links', 'inline', 'clearfix')
      ), 
      //'heading' => t('Main menu')
    )
  );

  $menu_data = menu_tree_all_data('main-menu');
  $menu_output_dropdown = macchiato_menu_tree_output($menu_data, "fullnav_dropdown");

  $rendered_menu_dropdown = render($menu_output_dropdown);

  // if we have a for patients link, tack it onto the end of the menu
  if(theme_get_setting("patient_link") && theme_get_setting("patient_link_title")){
    // replace the final </ul>
    $replace = '<li class="patient-link">'.l(theme_get_setting("patient_link_title") . ' <i class="fa fa-external-link-square"></i>',theme_get_setting("patient_link"), array("html"=>true)).'</li></ul>';

    $pos = strrpos($rendered_menu_dropdown,'</ul>');
    $rendered_menu_dropdown = substr_replace($rendered_menu_dropdown,$replace, $pos, strlen('</ul>'));

  }

  $vars['dropdown_menu'] = $rendered_menu_dropdown;

  $parent_links = "";
  $vars['parent_entity_links'] = "";
  if(theme_get_setting("parent_entity_name")){
    if(theme_get_setting("parent_entity_link")){
      $parent_links = l(theme_get_setting("parent_entity_name"),theme_get_setting("parent_entity_link"));
      // if this is the last link, put the level up icon
      if(!theme_get_setting("parent2_entity_link")){
        $parent_links .= '&nbsp;<i class="fa fa-level-up"></i>';
      }
    } else {
      $parent_links = theme_get_setting("parent_entity_name");
    }
    // is there a second link?
    if(theme_get_setting("parent2_entity_name")){


      $combine_strings = array("Center for " => "Centers for ", "Department of " => "Departments of ", "Department for " => "Departments for ");
      $combined = false;
      foreach($combine_strings as $check => $plural){
        // if both the first and second start with "Department of ", consolidate
        if(strpos(strtolower(theme_get_setting("parent_entity_name")),strtolower($check)) === 0 && strpos(strtolower(theme_get_setting("parent2_entity_name")),strtolower($check))===0){
          $combined = true;
          $parent_links = $plural;
          $singular = preg_replace('/'.$check.'/i', '', theme_get_setting("parent_entity_name"), 1);
          if(theme_get_setting("parent_entity_link")){
            $parent_links .= l($singular, theme_get_setting("parent_entity_link")). '';
              // if this is the last link (the second entity has no url), put the level up icon
            if(!theme_get_setting("parent2_entity_link")){
              $parent_links .= '&nbsp;<i class="fa fa-level-up"></i>';
            }
          } else {
            $parent_links .= $singular;
          }
          $parent_links .= ' and ';
          $singular = preg_replace('/'.$check.'/i', '', theme_get_setting("parent2_entity_name"), 1);
          if(theme_get_setting("parent2_entity_link")){
            $parent_links .= l($singular, theme_get_setting("parent2_entity_link")). '&nbsp;<i class="fa fa-level-up"></i>';
          } else {
            $parent_links .= $singular;
          }

        }
      // It's not two departments 
      } 

      if(!$combined){

        $parent_links .= ' and '; 
        if(theme_get_setting("parent2_entity_link")){
          $parent_links .= l(theme_get_setting("parent2_entity_name"),theme_get_setting("parent2_entity_link")) . '&nbsp;<i class="fa fa-level-up"></i>';
        } else {
          $parent_links .= theme_get_setting("parent2_entity_name");
        }

      }
    }

    $vars['parent_entity_links'] = '<div class="parent-entity-links">' . $parent_links . '</div>';

  }
}


// a custom implementation of  menu_tree_output
// sensitive to context
// http://api.drupal.org/api/drupal/includes%21menu.inc/function/menu_tree_output/7
function macchiato_menu_tree_output($tree, $context) {
  $build = array();
  $items = array();

  // Pull out just the menu links we are going to render so that we
  // get an accurate count for the first/last classes.
  foreach ($tree as $data) {
    if ($data['link']['access'] && !$data['link']['hidden']) {
      $items[] = $data;
    }
  }

  $router_item = menu_get_item();
  $num_items = count($items);
  foreach ($items as $i => $data) {
    $class = array();
    if ($i == 0) {
      $class[] = 'first';
    }
    if ($i == $num_items - 1) {
      $class[] = 'last';
    }
    // Set a class for the <li>-tag. Since $data['below'] may contain local
    // tasks, only set 'expanded' class if the link also has children within
    // the current menu.
    if ($data['link']['has_children'] && $data['below'] && $data['link']['expanded']) {

        $class[] = 'expanded dropdown'; // Dropdown or collapse

      }
      elseif ($data['link']['has_children'] && !$data['link']['expanded']) {
        $class[] = 'collapsed';
        $data['link']['has_children'] = false;
        $data['below'] = array();
      }
      else {

        $class[] = 'leaf';

      // If this link is external to this site, add an icon.
        if(isset($data["link"]['external']) && $data["link"]['external']){
         $class[] = 'external';
       }

     }
    // Set a class if the link is in the active trail.
     if ($data['link']['in_active_trail']) {
      $class[] = 'active-trail';
      $data['link']['localized_options']['attributes']['class'][] = 'active-trail';
    }
    // Normally, l() compares the href of every link with $_GET['q'] and sets
    // the active class accordingly. But local tasks do not appear in menu
    // trees, so if the current path is a local task, and this link is its
    // tab root, then we have to set the class manually.
    if ($data['link']['href'] == $router_item['tab_root_href'] && $data['link']['href'] != $_GET['q']) {
      $data['link']['localized_options']['attributes']['class'][] = 'active';
    }

    // Allow menu-specific theme overrides.
    $element['#theme'] = 'menu_link__' . strtr($data['link']['menu_name'], '-', '_');
    $element['#attributes']['class'] = $class;
    $element['#title'] = $data['link']['title'];
    $element['#href'] = $data['link']['href'];
    $element['#localized_options'] = !empty($data['link']['localized_options']) ? $data['link']['localized_options'] : array();
    $element['#below'] = $data['below'] ? macchiato_menu_tree_output($data['below'], $context . "_child") : $data['below'];
    $element['#original_link'] = $data['link'];
    // Index using the link's unique mlid.
    $build[$data['link']['mlid']] = $element;
  }
  if ($build) {
    // Make sure drupal_render() does not re-order the links.
    $build['#sorted'] = TRUE;
    // Add the theme wrapper for outer markup.
    // Allow menu-specific theme overrides.
    if($context){
      $build['#theme_wrappers'][] = 'menu_tree__'. $context . '_' . strtr($data['link']['menu_name'], '-', '_');
    } else {
      $build['#theme_wrappers'][] = 'menu_tree__' . strtr($data['link']['menu_name'], '-', '_');
    }
  }
  return $build;
}

function macchiato_menu_tree__fullnav_dropdown_main_menu($variables) {
  return '<ul class="sitenav-dropdown">' . $variables['tree'] . '</ul>';
}


function macchiato_menu_tree__fullnav_dropdown_child_main_menu($variables) {
  return '<span> </span><a href="#" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-caret-down"></i></a><div aria-expanded=”false" class="dropdown-menu"><ul>' . $variables['tree'] . '</ul></div>';
}


function macchiato_menu_link($variables) {

  $element = $variables['element'];

  // Remove some of the drupal classes that we don't need  
  if(is_array( $element['#attributes']['class'])) {
    foreach($element['#attributes']['class'] as $key=>$value){
      //'expanded','collapsed'
      if(in_array($value,array('first','last','leaf') ) ){
        unset($element['#attributes']['class'][$key]);
      }
    }

  }

  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }

  // If this page is not accessible to all users
  if(isset($element['#barista_lockdown']) && sizeof($element['#barista_lockdown'])>0 && !in_array(1,$element['#barista_lockdown'])){
    $element['#title'] = '<i class="fa fa-lock"></i> ' . $element['#title'];
    $element["#localized_options"]['html'] = TRUE;
  }



  $output = l($element['#title'], $element['#href'], $element['#localized_options']);

  //return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}


function macchiato_preprocess_html(&$vars) {

  // If this is the homepage, set the head title to just be the site name (not "Home | Site Name")
  // and set meta description as set on theme settings page
  if(drupal_is_front_page()){
    $vars["head_title"] = trim(preg_replace('/<[^>]*>/', ' ', variable_get('site_name', 'Drupal')));

    if($meta_description = variable_get("meta_description")){
      $meta_data = array(
        '#tag' => 'meta',
        '#attributes' => array(
         'name' => 'description',
         'content' => $meta_description,
         ),
        );
      drupal_add_html_head($meta_data,'meta_description');
    }

  }
else { //need to string out html tags
$vars["head_title"] = trim(preg_replace('/<[^>]*>/', ' ', htmlspecialchars_decode($vars["head_title"])));
}
  

  // Ensure that the $vars['rdf'] variable is an object.
  if (!isset($vars['rdf']) || !is_object($vars['rdf'])) {
    $vars['rdf'] = new StdClass();
  }
  $vars['doctype'] = '<!DOCTYPE html>' . "\n";
  $vars['rdf']->version = '';
  $vars['rdf']->namespaces = '';
  $vars['rdf']->profile = '';

  $vars['featured'] = block_get_blocks_by_region('featured');


  // add a class to the body tag indicating whether or not
  // there is anything in the featured area
  if($vars['featured']){
    $vars['classes_array'][] = "has-featured";
  } else {
    $vars['classes_array'][] = "nothing-featured";
  }


  if(theme_get_setting("act_like_vusm_homepage")){
    $vars['classes_array'][] = "act-like-vusm-homepage";
  } else {
    $vars['classes_array'][] = "not-like-vusm-homepage";
  }

  $colors = macchiato_site_accent_colors();
  $vars['site_accent'] = $colors['accent'];
  $vars['site_complement'] = $colors['complement'];
  $vars['link_color'] = $colors['link'];


 // Send X-UA-Compatible HTTP header to force IE to use the most recent
  // rendering engine or use Chrome's frame rendering engine if available.
  if (is_null(drupal_get_http_header('X-UA-Compatible'))) {
    drupal_add_http_header('X-UA-Compatible', 'IE=edge,chrome=1');
  }

  drupal_add_css('
    @font-face{
      font-family:"Futura Plus W08_n4";
      src:url("../assets/fonts/macchiato2-08102014/Fonts/2f6406ca-a7e5-4511-8b62-a512d422694f.eot?#iefix") format("eot")
    }
    @font-face{
      font-family:"Futura Plus W08";
      src:url("../assets/fonts/macchiato2-08102014/Fonts/2f6406ca-a7e5-4511-8b62-a512d422694f.eot?#iefix");
      src:url("../assets/fonts/macchiato2-08102014/Fonts/2f6406ca-a7e5-4511-8b62-a512d422694f.eot?#iefix") format("eot"),url("../assets/fonts/macchiato2-08102014/Fonts/40780796-f5dd-4ccf-89d6-5e9feed1b4c3.woff") format("woff"),url("../assets/fonts/macchiato2-08102014/Fonts/23f02811-b2c6-4ebb-8d95-27bda6a2745a.ttf") format("truetype"),url("../assets/fonts/macchiato2-08102014/Fonts/b38e2f36-b705-4816-baaf-083a1a6ae753.svg#b38e2f36-b705-4816-baaf-083a1a6ae753") format("svg");
      font-weight: 400;
      font-style: normal;
    }
    @font-face{
      font-family:"Futura Plus W08_n3";
      src:url("../assets/fonts/macchiato2-08102014/Fonts/27e35786-951e-4f3f-8819-f57fb26b5f59.eot?#iefix") format("eot")
    }
    @font-face{
      font-family:"Futura Plus W08";
      src:url("../assets/fonts/macchiato2-08102014/Fonts/27e35786-951e-4f3f-8819-f57fb26b5f59.eot?#iefix");
      src:url("../assets/fonts/macchiato2-08102014/Fonts/27e35786-951e-4f3f-8819-f57fb26b5f59.eot?#iefix") format("eot"),url("../assets/fonts/macchiato2-08102014/Fonts/46e5db04-2200-416c-8772-e8e92ac66d85.woff") format("woff"),url("../assets/fonts/macchiato2-08102014/Fonts/c34adf43-f679-46f0-8f37-6d892f520fc9.ttf") format("truetype"),url("../assets/fonts/macchiato2-08102014/Fonts/ba579ea8-4cf7-445f-ad75-cdca4f8438d6.svg#ba579ea8-4cf7-445f-ad75-cdca4f8438d6") format("svg");
      font-weight: 300;
      font-style: normal;
    }
    @font-face{
      font-family:"Futura Plus W08_n1";
      src:url("../assets/fonts/macchiato2-08102014/Fonts/81c68bb2-c8a7-490a-86a2-8b8e4ea83e52.eot?#iefix") format("eot")
    }
    @font-face{
      font-family:"Futura Plus W08";
      src:url("../assets/fonts/macchiato2-08102014/Fonts/81c68bb2-c8a7-490a-86a2-8b8e4ea83e52.eot?#iefix");
      src:url("../assets/fonts/macchiato2-08102014/Fonts/81c68bb2-c8a7-490a-86a2-8b8e4ea83e52.eot?#iefix") format("eot"),url("../assets/fonts/macchiato2-08102014/Fonts/accdf66a-3ef9-40bd-a2d9-141ce67745a0.woff") format("woff"),url("../assets/fonts/macchiato2-08102014/Fonts/91b74c83-4dbb-4d24-abf2-7665c88d68c1.ttf") format("truetype"),url("../assets/fonts/macchiato2-08102014/Fonts/fec411ea-113e-46b5-af10-c4cb416eaaf9.svg#fec411ea-113e-46b5-af10-c4cb416eaaf9") format("svg");
      font-weight: 100;
      font-style: normal;
    }

    ', array(
      'type' => 'inline',
      'group' => CSS_THEME,
      'weight' => 0,
      )
    );
drupal_add_css(path_to_theme() . '/assets/vendor/bootstrap/css/bootstrap.min.css', array(
  'group' => CSS_THEME, 
  'preprocess' => TRUE
  )
);
drupal_add_css(path_to_theme() . '/assets/vendor/font-awesome-4.2.0/css/font-awesome.min.css', array(
  'group' => CSS_THEME, 
  'preprocess' => TRUE
  )
);
drupal_add_css(path_to_theme() . '/assets/css/flexslider-modified.css', array(
  'group' => CSS_THEME, 
  'preprocess' => TRUE
  )
);
drupal_add_css(path_to_theme() . '/assets/css/macchiato.css', array(
  'group' => CSS_THEME, 
  'preprocess' => TRUE
  )
);
drupal_add_css(path_to_theme() . '/assets/vendor/bootstrap-ie7/css/bootstrap-ie7.css', array(
  'group' => CSS_THEME, 
  'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 
  'preprocess' => FALSE,
  'weight' => 10000,
  )
);
drupal_add_css(path_to_theme() . '/assets/css/macchiato-lte7.css', array(
  'group' => CSS_THEME, 
  'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 
  'preprocess' => FALSE,
  'weight' => 10001,
  )
);
drupal_add_js(path_to_theme() . '/assets/vendor/easing/jquery.easing.1.3.js', array(
      // 'type' => 'external',
  'scope' => 'footer',
  'group' => JS_THEME,
  'every_page' => TRUE,
  'weight' => 0,
  )
);
drupal_add_js(path_to_theme() . '/assets/vendor/flexslider/jquery.flexslider-min.js', array(
      // 'type' => 'external',
  'scope' => 'footer',
  'group' => JS_THEME,
  'every_page' => TRUE,
  'weight' => 0,
  )
);
drupal_add_js(path_to_theme() . '/assets/vendor/bootstrap/js/bootstrap.min.js', array(
      // 'type' => 'external',
  'scope' => 'footer',
  'group' => JS_THEME,
  'every_page' => TRUE,
  'weight' => 0,
  )
);
drupal_add_js(path_to_theme() . '/assets/js/browser-tweaks-polyfills-and-detections.js', array(
      // 'type' => 'external',
  'scope' => 'footer',
  'group' => JS_THEME,
  'every_page' => TRUE,
  'weight' => 0,
  )
);
drupal_add_js(path_to_theme() . '/assets/js/main-menu.js', array(
      // 'type' => 'external',
  'scope' => 'footer',
  'group' => JS_THEME,
  'every_page' => TRUE,
  'weight' => 0,
  )
);
drupal_add_js(path_to_theme() . '/assets/js/slideshows.js', array(
      // 'type' => 'external',
  'scope' => 'footer',
  'group' => JS_THEME,
  'every_page' => TRUE,
  'weight' => 0,
  )
);
drupal_add_js(path_to_theme() . '/assets/js/sidebar.js', array(
      // 'type' => 'external',
  'scope' => 'footer',
  'group' => JS_THEME,
  'every_page' => TRUE,
  'weight' => 0,
  )
);
drupal_add_js(path_to_theme() . '/assets/js/retinafy.js', array(
      // 'type' => 'external',
  'scope' => 'footer',
  'group' => JS_THEME,
  'every_page' => TRUE,
  'weight' => 0,
  )
);
drupal_add_js(path_to_theme() . '/assets/js/macchiato.js', array(
      // 'type' => 'external',
  'scope' => 'footer',
  'group' => JS_THEME,
  'every_page' => TRUE,
  'weight' => 0,
  )
);
drupal_add_js(path_to_theme() . '/assets/js/somanalytics.js', array(
      // 'type' => 'external',
  'scope' => 'footer',
  'group' => JS_THEME,
  'every_page' => TRUE,
  'weight' => 0,
  )
);
drupal_add_js(path_to_theme() . '/assets/js/jquery.vide.min.js', array(
      // 'type' => 'external',
  'scope' => 'footer',
  'group' => JS_THEME,
  'every_page' => TRUE,
  'weight' => 0,
  )
);

/* This is the Macchiato2 Tracker that is required for using the fonts */
drupal_add_js("
  var MTIProjectId='dfd66154-ef40-43bc-900c-1627a441160c';
  (function() {
    var mtiTracking = document.createElement('script');
    mtiTracking.type='text/javascript';
    mtiTracking.async='true';
    mtiTracking.src=('https:'==document.location.protocol?'https:':'http:')+'//fast.fonts.net/t/trackingCode.js';
    (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild( mtiTracking );
  })();", array(
  'type' => 'inline',
  'scope' => 'footer',
  'group' => JS_THEME,
  'every_page' => TRUE,
  'weight' => 100000,
  )
  );

}


/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return
 *   A string containing the breadcrumb output.
 */
function macchiato_breadcrumb($vars) {

  $breadcrumb = $vars['breadcrumb'];
  $breadcrumb_html = "";

  // Remove the link to the homepage
  $removed = array_shift($breadcrumb);

  // If the parent page is (also) the homepage, remove it (as we tack the homepage on manually)
  if(isset($breadcrumb[0])){
    module_load_include("module", "barista_frontpage");
    $frontpage = drupal_get_path_alias(_barista_frontpage_first_path_in_menu());
    $search_string = '<a href="/'.$frontpage.'">';
    // If the frontpage matches the url from the first link ()
    if(strpos($breadcrumb[0],$search_string) > -1){
      array_shift($breadcrumb);
    }
  }

  if(!theme_get_setting("act_like_vusm_homepage")){
      // Prepend Site Name (homepage)
    array_unshift($breadcrumb, l(variable_get("site_name"),"<front>"));

      // Prepend Parent Entity
    if(theme_get_setting("parent_entity_name") && theme_get_setting("parent_entity_link")){
      array_unshift($breadcrumb, l(theme_get_setting("parent_entity_name"),theme_get_setting("parent_entity_link")));
    }
  }

  if(theme_get_setting("use_vanderbilt_branding")){
    // Prepend Vanderbilt
    array_unshift($breadcrumb, l("Vanderbilt University","http://www.vanderbilt.edu"));
  } else {
    // Prepend School of Medicine
    array_unshift($breadcrumb, l("School of Medicine","https://medschool.vanderbilt.edu"));
  }

  // If this is the School of Medicine site homepage,  

  // Tack on the title of the current page
  if($title = drupal_get_title()){
    array_push($breadcrumb, drupal_get_title());
  }

  // Return the breadcrumb with separators.
  if (!empty($breadcrumb)) {
    $formatted_breadcrumbs = array();
    $breadcrumb_html = '<div class="hide">';
    foreach($breadcrumb as $crumb){
      $item = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';
      // is it a link
      if(strpos($crumb,"<a href") > -1){
        $crumb = str_replace('<a href=', '<a itemprop="url" href=', $crumb);
        $crumb = str_replace('">','"><span itemprop="title">', $crumb);
        $crumb = str_replace('</a>','</span></a>', $crumb);
      } else {
        $crumb = '<span itemprop="title">' . $crumb . '</span>';
      }
      $item .= $crumb . '</div>';

      $formatted_breadcrumbs[] = $item;

    }
    $breadcrumb_html .= implode(' <i class="fa fa-chevron-right"></i> ', $formatted_breadcrumbs);
    $breadcrumb_html .= '</div>';
  }
  return $breadcrumb_html;
}


/**
 * Override default local task formatting 
 * (e.g., page edit tabs)
 */
function macchiato_menu_local_tasks(&$variables) {
  $output = "";
  if (!empty($variables['primary'])) {

    // determine if this list is entirely admin links
    $alladmin = true;
    foreach($variables['primary'] as $key=>$child){
      // if a page isn't an admin page and it isn't the active page, we need to show the menu
      if(!path_is_admin($child["#link"]["href"])){
        if(!isset($child["#active"]) || $child["#active"] != TRUE){
          $alladmin = false;
        }
      }
    }
    $alladmin_class = "";
    if($alladmin){
      $alladmin_class = " entirely-admin-links";
    }

    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="nav nav-pills primary-local' . $alladmin_class.'">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="nav nav-pills secondary-local">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }
  return $output;
}


function macchiato_menu_local_task($variables) {

  $link = $variables['element']['#link'];
  $link_text = $link['title'];

  // based on whether it is an admin link or not, give it a class
  $is_admin = path_is_admin($link["href"]);
  if($link_text == "View"){
    $is_admin = true;
  }
  $adminclass = "";
  if($is_admin){
    $adminclass = "admin-localtask";
  }

  if (!empty($variables['element']['#active'])) {
    // Add text to indicate active tab for non-visual users.
    $active = '<span class="element-invisible">' . t('(active tab)') . '</span>';

    // If the link does not contain HTML already, check_plain() it now.
    // After we set 'html'=TRUE the link will not be sanitized by l().
    if (empty($link['localized_options']['html'])) {
      $link['title'] = check_plain($link['title']);
    }
    
    $link_text = t('!local-task-title!active', array('!local-task-title' => $link['title'], '!active' => $active));
  }

  $link['localized_options']['html'] = TRUE;

  // These icons should match those found in barista_backstage as well
  $icon_html = "";
  if($link_text == "List"){
    $icon_html = '<i class="fa fa-bars"></i>';
  } elseif($link_text == "Edit"){
    $icon_html = '<i class="fa fa-pencil"></i>';
  } elseif($link_text == "Update"){
    $icon_html = '<i class="fa fa-wrench"></i>';
  } elseif($link_text == "View"){
    $icon_html = '<i class="fa fa-eye"></i>';
  } elseif($link_text == "Settings"){
    $icon_html = '<i class="fa fa-cog"></i>';
  } elseif($link_text == "Revisions"){
    $icon_html = '<i class="fa fa-history"></i>';
  } elseif($link_text == "Log"){
    $icon_html = '<i class="fa fa-history"></i>';
  } elseif($link_text == "Permissions"){
    $icon_html = '<i class="fa fa-key"></i>';
  } elseif($link_text == "Blocks"){
    $icon_html = '<i class="fa fa-th-large"></i>';
  } elseif($link_text == "Uninstall"){
    $icon_html = '<i class="fa fa-trash-o"></i>';
  } elseif($link_text == "Manage fields"){
    $icon_html = '<i class="fa fa-check"></i>';
  } elseif($link_text == "Manage display"){
    $icon_html = '<i class="fa fa-eye"></i>';
  } elseif($link_text == "Comment fields"){
    $icon_html = '<i class="fa fa-comment"></i>';
  } elseif($link_text == "Comment display"){
    $icon_html = '<i class="fa fa-comments"></i>';
  } elseif($link_text == "Devel"){
    $icon_html = '<i class="fa fa-dashboard"></i>';
  } elseif($link_text == "Content"){
    $icon_html = '<i class="fa fa-list"></i>';
  } elseif($link_text == "Comments"){
    $icon_html = '<i class="fa fa-comments"></i>';
  } elseif($link_text == "Scheduled"){
    $icon_html = '<i class="fa fa-clock-o"></i>';
  } elseif($link_text == "Remove"){
    $icon_html = '<i class="fa fa-times"></i>';
  } elseif($link_text == "Files"){
    $icon_html = '<i class="fa fa-paper-clip"></i>';
  } elseif($link_text == "Media"){
    $icon_html = '<i class="fa fa-picture-o"></i>';
  } elseif($link_text == "Create Person"){
    $icon_html = '<i class="fa fa-plus"></i> ';
  } elseif($link_text == "Manage Categories"){
    $icon_html = '<i class="fa fa-bookmark"></i> ';
  } elseif($link_text == "Manage Tags"){
    $icon_html = '<i class="fa fa-tag"></i> ';
  } elseif(strpos($link_text,"Create")===0){
    $icon_html = '<i class="fa fa-plus"></i> ';  
  } elseif(strpos($link_text,"Add")===0){
    $icon_html = '<i class="fa fa-plus"></i> ';  
  } elseif(strpos($link_text,"Webform")===0){
    $icon_html = '<i class="fa fa-check"></i> ';  
  } elseif(strpos($link_text,"Results")===0){
    $icon_html = '<i class="fa fa-bar-chart-o"></i> ';  
  } elseif(strpos($link_text,"Edit")===0){
    $icon_html = '<i class="fa fa-pencil"></i>';
  } elseif(strpos($link_text,"Delete")===0){
    $icon_html = '<i class="fa fa-times"></i>';
  } elseif(strpos($link_text,"Import from")===0){
    $icon_html = '<i class="fa fa-cloud-download"></i>';
  }

  return '<li class="'. $adminclass . (!empty($variables['element']['#active']) ? ' active' : '') . '">' . l($icon_html.$link_text, $link['href'], $link['localized_options']) . "</li>\n";
}


/**
 * Implements hook_form_alter().
 */
function macchiato_form_alter(&$form, &$form_state, $form_id) {

  if($form_id == "user_login"){
    $form["name"]["#title"] = "Username (not your VUNetID)";
    unset($form["name"]["#description"]);
    unset($form["pass"]["#description"]);
    $form["#prefix"] = '
    <div class="panel panel-default user-login-well">
    <div class="panel-heading"><h3><i class="fa fa-lock"></i> Log in</h3></div>
    <div class="panel-body">';
    
    $form["#suffix"] = "</div></div>";
    
    $form["actions"]["cas_links"] = $form["cas_links"];
    unset($form["cas_links"]);
  }

}


/**
 * Implements hook_menu_local_tasks_alter().
 * Hide the "Request New Password Tab"
 */
function macchiato_menu_local_tasks_alter(&$data, $router_item, $root_path) {
  // Add an action to all pages.
  // $data['actions']['output'][] = array(
  //
  // Add a tab to all pages.

  if($root_path == "user"){
    unset($data["tabs"]);
  }

}


function macchiato_button($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'submit';

  element_set_attributes($element, array('id', 'name', 'value'));

  $element['#attributes']['class'][] = 'form-' . $element['#button_type'];
  if (!empty($element['#attributes']['disabled'])) {
    $element['#attributes']['class'][] = 'btn-disabled';
  }


  $element['#attributes']['class'][] = 'btn';

  foreach($element['#attributes']['class'] as $key=>$child){
    // remove this class (default form button styling for seven)
    if($child == "form-submit"){
      unset($element['#attributes']['class'][$key]);
    }
  }

  $title = $element['#value'];
  if(strpos($title, "Delete") === 0){
    $element['#attributes']['class'][] = 'btn-danger';
  } elseif(strpos($title, "Preview") === 0){
    $element['#attributes']['class'][] = '';
  } elseif($element["#id"]=="edit-submit") {
    $element['#attributes']['class'][] = 'btn-primary';
  } elseif($element["#value"]=="Remove") {
    unset($element['#type']);
    $element['#attributes']['class'][] = 'btn-link';
    $element['#attributes']['class'][] = 'remove-button';
    //$element['#value'] = '<i class="fa fa-remove"></i>';

    if(strpos($element["#name"], "field_barista_blocks_") === 0){
      return '<button type="submit"' . drupal_attributes($element['#attributes']) . '><i class="fa fa-remove"></i></button>';
    } else {
      return '<button type="submit"' . drupal_attributes($element['#attributes']) . '><i class="fa fa-remove"></i> Remove</button>';
    }

  } elseif($element["#value"]=="Add another item") {
    unset($element['#type']);
    $element['#attributes']['class'][] = 'btn-link';
    //$element['#value'] = '<i class="fa fa-add"></i> Add another';
    return '<button type="submit"' . drupal_attributes($element['#attributes']) . '><i class="fa fa-plus"></i> Add another</button>';
  }

  return '<input' . drupal_attributes($element['#attributes']) . ' />';

}

/**
 * Implements hook_page_alter().
 * Functionally eliminate /user page for logged in users.
 */
function macchiato_page_alter(&$page) {
  if(arg(0)=="user" && user_is_logged_in()){
    drupal_goto("<front>");
  }
  // Add help text to the user login block.
  /*
   *$page['sidebar_first']['user_login']['help'] = array(
   *  '#weight' => -10,
   *  '#markup' => t('To post comments or add new content, you first have to log in.'),
   *);
   */
  /* Your code here */
}


require_once dirname(__FILE__).'/theme-settings.php';

/**
 * Overrides theme_breadcrumb().
 */
function macchiato_status_messages($variables) {
  $display = $variables['display'];
  $output = '';

  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
    'info' => t('Informative message'),
    );

  // Map Drupal message types to their corresponding Bootstrap classes.
  // @see http://twitter.github.com/bootstrap/components.html#alerts
  $status_class = array(
    'status' => 'success',
    'error' => 'danger',
    'warning' => 'warning',
    // Not supported, but in theory a module could send any type of message.
    // @see drupal_set_message()
    // @see theme_status_messages()
    'info' => 'info',
    );

  foreach (drupal_get_messages($display) as $type => $messages) {
    $class = (isset($status_class[$type])) ? ' alert-' . $status_class[$type] : '';
    $output .= "<div class=\"alert alert-block$class\">\n";
    $output .= "  <a class=\"close\" data-dismiss=\"alert\" href=\"#\">&times;</a>\n";

    if (!empty($status_heading[$type])) {
      $output .= '<h4 class="element-invisible">' . $status_heading[$type] . "</h4>\n";
    }

    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li>' . $message . "</li>\n";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= $messages[0];
    }

    $output .= "</div>\n";
  }
  return $output;
}

/**
 * Overrides theme_feed_icon
 */
function macchiato_feed_icon($variables) {
  // Taken from original function
  $text = t('Subscribe to !feed-title', array('!feed-title' => $variables['title']));
  // Overridden to not render an image element (will use 100% CSS here instead)
  return '<div class="rss-link">'.l('RSS<i class="fa fa-rss-square"></i>', $variables['url'], array('html' => TRUE, 'attributes' => array('class' => array('feed-icon'), 'title' => $text))) . '</div>';
}

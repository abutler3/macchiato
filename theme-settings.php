<?php



function macchiato_form_system_theme_settings_alter(&$form, &$form_state) {

  // Hide the littany of checkboxes that do nothing in this theme
  $form['theme_settings']["#access"] = FALSE;  
  $form['logo']["#access"] = FALSE;
  $form['favicon']["#access"] = FALSE;

  $form['theme_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Theme Settings'),
    // Make the fieldset collapsible.
    //'#collapsible' => TRUE, // Added
    //'#collapsed' => FALSE,  // Added
    );

  $color_options = macchiato_coloroptions();
  $form['theme_settings']['site_accent_color'] = array(
    '#type' => 'radios',
    '#title' => t('Site accent color'),
    '#required' => TRUE, // Added
    '#options' => $color_options,
    '#default_value' => theme_get_setting("site_accent_color"),
    '#description' => t('This color is used in various places, such as the background of slideshows, link colors, block backgrounds, etc.'),
    );


  $form['theme_settings']['custom_colors'] = array(
    '#type' => 'fieldset',
    '#title' => t('Custom Colors (Administrators Only)'),
    '#access' => user_access("administer themes")
    );
  $form['theme_settings']['custom_colors']['custom_primarycolor'] = array(
    '#type' => 'textfield',
    '#title' => 'Custom Primary Color',
    '#description' => 'Hex. Include #.  Leave blank to use Primary Color.',
    '#default_value' => theme_get_setting("custom_primarycolor"),
    '#access' => user_access("administer themes")
    );
  $form['theme_settings']['custom_colors']['custom_secondarycolor'] = array(
    '#type' => 'textfield',
    '#title' => 'Custom Secondary Color',
    '#description' => 'Hex. Include #.  Leave blank to use Primary Color.',
    '#default_value' => theme_get_setting("custom_secondarycolor"),
    '#access' => user_access("administer themes")
    );
  $form['theme_settings']['custom_colors']['custom_linkcolor'] = array(
    '#type' => 'textfield',
    '#title' => 'Custom Links Color (hex -- include #)',
    '#description' => 'Hex. Include #.  Leave blank to use Primary Color.',
    '#default_value' => theme_get_setting("custom_linkcolor"),
    '#access' => user_access("administer themes")
    );


  $form['theme_settings']['advanced'] = array(
    '#type' => 'fieldset',
    '#title' => t('Advanced Settings'),
    '#access' => user_access("administer themes")
    );
  $form['theme_settings']['advanced']['use_v_vanderbilt_template'] = array(
    '#type' => 'checkbox',
    '#title' => 'Use Vanderbilt branding.',
    '#description' => 'This is primarily for VUMC transition sites.',
    '#default_value' => theme_get_setting("use_v_vanderbilt_template"), 
    '#access' => user_access("administer themes")
    );
  $form['theme_settings']['advanced']['use_vanderbilt_template'] = array(
    '#type' => 'checkbox',
    '#title' => 'Use University branding instead of School of Medicine (use sparingly!)',
    '#description' => 'This is for non-standard use cases, like the Student Health site.',
    '#default_value' => theme_get_setting("use_vanderbilt_template"), 
    '#access' => user_access("administer themes")
    );
  $form['theme_settings']['advanced']['use_nonbranded_template'] = array(
    '#type' => 'checkbox',
    '#title' => 'Remove all VU/VUSM branding (No logos)',
    '#description' => 'This is for non-standard use cases.',
    '#default_value' => theme_get_setting("use_nonbranded_template"), 
    '#access' => user_access("administer themes")
    );
  
  $form['theme_settings']['advanced']['act_like_vusm_homepage'] = array(
    '#type' => 'checkbox',
    '#title' => 'Act like VUSM homepage (use logo as title /  use VUSM navigation)',
    '#description' => '',
    '#default_value' => theme_get_setting("act_like_vusm_homepage"), 
    '#access' => user_access("administer themes")
  );


  $form['theme_settings']['related_sites'] = array(
    '#type' => 'fieldset',
    '#title' => t('Related Sites'),
    );
  $form['theme_settings']['related_sites']['parent_entity'] = array(
    '#type' => 'fieldset',
    '#title' => t('Parent Department / Division / etc.'),
    '#description' => t('A link to this Department will be automatically added below your site title.')
    // Make the fieldset collapsible.
    //'#collapsible' => TRUE, // Added
    //'#collapsed' => FALSE,  // Added
    );

  // Collect information about the parent entity 
  $form['theme_settings']['related_sites']['parent_entity']['parent_entity_name'] = array(
    '#type' => 'textfield',
    '#title' => 'Name (e.g., Department of Biochemistry)',
    '#default_value' => theme_get_setting("parent_entity_name"),
    );
  $form['theme_settings']['related_sites']['parent_entity']['parent_entity_link'] = array(
    '#type' => 'textfield',
    '#title' => 'Web Address',
    '#description' => '(include the http://)',
    '#default_value' => theme_get_setting("parent_entity_link"),
    );
  $form['theme_settings']['related_sites']['parent_entity']['parent2_entity'] = array(
    '#type' => 'fieldset',
    '#title' => t('Additional Parent Department / Division / etc.'),
    // Make the fieldset collapsible.
    '#collapsible' => TRUE, // Added
    '#collapsed' => TRUE,  // Added
    );
  $form['theme_settings']['related_sites']['parent_entity']['parent2_entity']['parent2_entity_name'] = array(
    '#type' => 'textfield',
    '#title' => 'Name (e.g., Department of Biochemistry)',
    '#default_value' => theme_get_setting("parent2_entity_name"),
    );
  $form['theme_settings']['related_sites']['parent_entity']['parent2_entity']['parent2_entity_link'] = array(
    '#type' => 'textfield',
    '#title' => 'Web Address',
    '#description' => '(include the http://)',
    '#default_value' => theme_get_setting("parent2_entity_link"),
    );


  $form['theme_settings']['related_sites']['patient_site'] = array(
    '#type' => 'fieldset',
    '#title' => t('Patient Site (if applicable)'),
    '#description' => t('A link to your patient site (if applicable) will be automatically added to your main menu if specified below.'),
    // Make the fieldset collapsible.
    '#collapsible' => TRUE, // Added
    '#collapsed' => FALSE,  // Added
    );

    // Collect information about the patient site
  $form['theme_settings']['related_sites']['patient_site']['patient_link_title'] = array(
    '#type' => 'textfield',
    '#title' => 'Name',
    '#default_value' => theme_get_setting("patient_link_title") ? theme_get_setting("patient_link_title") : "For Patients",
    '#description' => 'In most cases, you should leave this is "For Patients".'
    );
  $form['theme_settings']['related_sites']['patient_site']['patient_link'] = array(
    '#type' => 'textfield',
    '#title' => 'Web Address',
    '#description' => '(include the http://)  For example, http://www.vanderbilthealth.com',
    '#default_value' => theme_get_setting("patient_link"),
    );

  $scale_options = array("100%"=>"100%","95%"=>"95%","90%"=>"90%","85%"=>"85%","80%"=>"80%","75%"=>"75%","70%"=>"70%","65%"=>"65%");
  $form['theme_settings']['header_scale_factor'] = array(
    '#type' => 'select',
    '#title' => 'Reduce site title size',
    '#description' => 'If your site title wraps even at large screen sizes, you can adjust the size here. (Almost all site titles will wrap at small screen sizes.)',
    '#options' => $scale_options,
    '#default_value' => theme_get_setting("header_scale_factor") ? theme_get_setting("header_scale_factor") : "100%",
    );




  /*
  $form['theme_settings']['show_standard_footer_links'] = array(
    '#type' => 'checkbox',
    '#title' => 'Show standard School of Medicine links / address in footer.',
    '#description' => '"Core" School of Medicine web properties should leave this checked.',
    '#default_value' => theme_get_setting("show_standard_footer_links"), 
    );
  $form['theme_settings']['show_vusm_social_media_links'] = array(
    '#type' => 'checkbox',
    '#title' => 'Show standard School of Medicine social media links in footer.',
    '#description' => 'Leave this checked unless you are not affiliated with the School of Medicine.',
    '#default_value' => theme_get_setting("show_vusm_social_media_links"), 
    );
  $form['theme_settings']['show_site_breadcrumb'] = array(
    '#type' => 'checkbox',
    '#title' => 'Show "Institutional Breadcrumb" at the bottom of each page',
    '#default_value' => theme_get_setting("show_site_breadcrumb"), 
    );
*/
$form['#attached']['css'][] = array(
  'type' => 'inline',
  'data' => macchiato_colorcss(),
  );
/*
  $form['theme_settings']['site_breadcrumb'] = array(
    '#type' => 'fieldset',
    '#title' => t("Institutional breadcrumb settings"),
    '#description' => 'The institutional breadcrumb appears below your content and helps the user understand how your site relates to parent organizations (schools, divisions, departments, etc). Note:  List in order of parent to child.  If you check VUMC or VUSM, you should check all of the options above it (all VUSM entities are part of VUMC and all VUMC entities are part of VU.)',
      '#states' => array(
        'invisible' => array(
          ":input[id=edit-show-site-breadcrumb]" => array('checked' => false),
        ),
      ),
    );


  $form['theme_settings']['site_breadcrumb']['site_breadcrumb_settings'] = array(
    '#type'=> 'container',
    '#attributes' => array(
      'class' => array(
        'breadcrumb-settings'
        )
      )
  );


  $form['theme_settings']['site_breadcrumb']['site_breadcrumb_settings']['institutional_breadcrumb_show_vu'] = array(
    '#type' => 'checkbox',
    '#title' => 'Vanderbilt University',
    '#default_value' => theme_get_setting("institutional_breadcrumb_show_vu"),
    '#attributes' => array(
      'class' => array(
        //'breadcrumb-entry'
        )
      )
    );

  $form['theme_settings']['site_breadcrumb']['site_breadcrumb_settings']['institutional_breadcrumb_show_vumc'] = array(
    '#type' => 'checkbox',
    '#title' => 'Vanderbilt University Medical Center',
    '#default_value' => theme_get_setting("institutional_breadcrumb_show_vumc"),
    '#attributes' => array(
      'class' => array(
        //'breadcrumb-entry'
        )
      )
    );

  $form['theme_settings']['site_breadcrumb']['site_breadcrumb_settings']['institutional_breadcrumb_show_vusm'] = array(
    '#type' => 'checkbox',
    '#title' => 'Vanderbilt University School of Medicine',
    '#default_value' => theme_get_setting("institutional_breadcrumb_show_vusm"),
    '#attributes' => array(
      'class' => array(
        //'breadcrumb-entry'
        )
      )
    );


  for($i=1; $i<=2; $i++){
    $form['theme_settings']['site_breadcrumb']['site_breadcrumb_settings']['level_' . $i] = array(
      '#type' => 'container',
      '#attributes' => array(
        'class' => array(
          'breadcrumb-entry'
          )
        )
      );
    $form['theme_settings']['site_breadcrumb']['site_breadcrumb_settings']['level_' . $i]['institutional_breadcrumb_title_level_' . $i] = array(
      '#type' => 'textfield',
      '#title' => 'Title (e.g., Department of Biochemistry)',
      '#default_value' => theme_get_setting("institutional_breadcrumb_title_level_" . $i),
      '#title_display' => 'after',
      //'#prefix' => '<input class="dummycheckbox" type="checkbox" disabled="disabled" checked="checked" /> '
      );
    $form['theme_settings']['site_breadcrumb']['site_breadcrumb_settings']['level_' . $i]['institutional_breadcrumb_url_level_' . $i] = array(
      '#type' => 'textfield',
      '#title' => 'Web Address (e.g., http://www.vanderbilt.edu)',
      '#default_value' => theme_get_setting("institutional_breadcrumb_url_level_" . $i),
      '#title_display' => 'after',
      );
  }


  $form['theme_settings']['site_breadcrumb']['site_breadcrumb_settings']['institutional_breadcrumb_this_site'] = array(
    '#type' => 'checkbox',
    '#title' => "This site (" . variable_get('site_name', 'Site name not specified yet.') . ")",
    '#default_value' => 1,
    '#disabled' => true,
    //'#default_value' => array_keys($options)
    '#attributes' => array(
      'class' => array(
        'breadcrumb-entry'
        )
      )
    );
*/
}


// Generate a little CSS to make the color picker pretty
function macchiato_colorcss(){
  $colorcss = '';

  $motif = macchiato_colors();
  foreach($motif as $motifname => $motifvalues){

    $colorcss .= '
    html .form-item label[for="edit-site-accent-color-'.drupal_clean_css_identifier($motifname).'"] {
      background-color: '.$motifvalues["primarycolor"].';
      border: 5px solid '.$motifvalues["primarycolor"].';
      border-right: 2em solid '.$motifvalues["secondarycolor"].';
      color: white;
    }
    html .form-item label[for="edit-site-accent-color-'.drupal_clean_css_identifier($motifname).'"]:hover {
      color: '.$motifvalues["primarycolor"].';
      background: white;
    }
    ';
  }

  return $colorcss;
}

/*
  Color functions.  Used to populate form in theme-settings.php
  defined here so these functions are available within tpl files
  Marking as inactive will make it no longer selectable, 
  deleting it will cause sites with it selected to immediately default to first color (active or not.)
*/

  function macchiato_colors(){
    $motif = array();

    $motif['asparagus'] = array("active" => true, "primarycolor" => '#6A985A', "secondarycolor" => '#3f5b36');
    $motif['hippie green'] = array("active" => true, "primarycolor" => '#62894D', "secondarycolor" => '#336633');
    $motif['battleship gray'] = array("active" => true, "primarycolor" => '#849879', "secondarycolor" => '#4B2D4B');
    $motif['granny smith'] = array("active" => true, "primarycolor" => '#809692', "secondarycolor" => '#4c5a57');
    $motif['horizon'] = array("active" => true, "primarycolor" => '#5E86A0', "secondarycolor" => '#533E20');
    $motif['steel blue'] = array("active" => true, "primarycolor" => '#4080AE', "secondarycolor" => '#264c68');
    $motif['matisse'] = array("active" => true, "primarycolor" => '#1F6499', "secondarycolor" => '#6c6c6c');
    $motif['eastern blue'] = array("active" => true, "primarycolor" => '#188BAD', "secondarycolor" => '#0E5367');
    $motif['jelly bean'] = array("active" => true, "primarycolor" => '#269199', "secondarycolor" => '#565656');
    $motif['concord'] = array("active" => true, "primarycolor" => '#846196', "secondarycolor" => '#8A9660');
    $motif['soft lavender'] = array("active" => true, "primarycolor" => '#9372A4', "secondarycolor" => '#584462');
    $motif['mulberry'] = array("active" => true, "primarycolor" => '#C95579', "secondarycolor" => '#7C4455');
    $motif['mojo'] = array("active" => true, "primarycolor" => '#C24E37', "secondarycolor" => '#873626');
    $motif['thunderbird'] = array("active" => true, "primarycolor" => '#B62E1C', "secondarycolor" => '#69261D');
    $motif['tamarillo'] = array("active" => true, "primarycolor" => '#A81818', "secondarycolor" => '#4b4b4b');
    $motif['muesli'] = array("active" => true, "primarycolor" => '#A6785D', "secondarycolor" => '#205959');
    $motif['old gold'] = array("active" => true, "primarycolor" => '#C3993F', "secondarycolor" => '#766135');

    $motif['cranberry'] = array("active" => true, "primarycolor" => '#701326', "secondarycolor" => '#8b8b8b');
    $motif['deep purple'] = array("active" => true, "primarycolor" => '#5d3170', "secondarycolor" => '#9d83a9');

    $motif['cosmos'] = array("active" => true, "primarycolor" => '#203470', "secondarycolor" => '#5e6c97');
    $motif['velvet'] = array("active" => true, "primarycolor" => '#701651', "secondarycolor" => '#6c6c6c');
    $motif['evergreen'] = array("active" => true, "primarycolor" => '#50796e', "secondarycolor" => '#054030');
    $motif['sea turtle'] = array("active" => true, "primarycolor" => '#2fa186', "secondarycolor" => '#7a7a7a');
    $motif['coral'] = array("active" => true, "primarycolor" => '#a36761', "secondarycolor" => '#6b3c38');
    $motif['slate'] = array("active" => true, "primarycolor" => '#798aa1', "secondarycolor" => '#485260');






    if(theme_get_setting("custom_primarycolor")){
      $motif['custom']['active'] = true;
      $motif['custom']['primarycolor'] = theme_get_setting("custom_primarycolor");

      if(theme_get_setting("custom_secondarycolor")){
        $motif['custom']['secondarycolor'] = theme_get_setting("custom_secondarycolor");
      } else {
        $motif['custom']['secondarycolor'] = theme_get_setting("custom_primarycolor");
      }

      if(theme_get_setting("custom_linkcolor")){
        $motif['custom']['linkcolor'] = theme_get_setting("custom_linkcolor");
      } else {
        $motif['custom']['linkcolor'] = theme_get_setting("custom_primarycolor");
      }
    }

    return $motif;
  }

// format available color options for the option menu
  function macchiato_coloroptions(){
    $options = array();

    $motif = macchiato_colors();
    foreach($motif as $motifname => $motifvalues){
    // only make the active ones available (this allows us to maintain legacy colors, or change them if necessary.)
      if($motifvalues["active"] !== false){
        $options[$motifname] = t($motifname);
      }
    }

    return $options;
  }


// returns site accent color as hex
  function macchiato_site_accent_colors(){

    $colors = array();

    $colorname = theme_get_setting("site_accent_color");

    // allow active or inactive colors
    $color_options = macchiato_colors();

    if(!isset($color_options[$colorname])){
      // use the first color
      $color = reset($color_options);
    }

    $colors["accent"] = $color_options[$colorname]["primarycolor"];
    $colors["complement"] = $color_options[$colorname]["secondarycolor"];

    // grab linkcolor if it is set, else use the primary color
    if(isset($color_options[$colorname]["linkcolor"])){
      $colors["link"] = $color_options[$colorname]["linkcolor"];
    } else {
      $colors["link"] = $color_options[$colorname]["primarycolor"];
    }

    return $colors;

  }

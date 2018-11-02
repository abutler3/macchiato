/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/


// Register a template definition set named "default".
CKEDITOR.addTemplates( 'default',
{
  // The name of the subfolder that contains the preview images of the templates.
  imagesPath : CKEDITOR.getUrl( CKEDITOR.plugins.getPath( 'templates' ) + 'images/' ),
 
  // Template definitions.
  templates :
    [
      {
        title: 'Two Column Template',
        //image: 'template1.gif',
        description: 'A simple two column design that collapses to one column at small browser widths.',
        html:
          '<div class="row">' +
          '  <div class="col-md-6"><p>Sample text. This text is here to give you an idea of how your content will look here. Edit this text and replace it with your own content. Sample text. This text is here to give you an idea of how your content will look here. Edit this text and replace it with your own content.</p></div>'+
          '  <div class="col-md-6"><p>Sample text. This text is here to give you an idea of how your content will look here. Edit this text and replace it with your own content.Sample text. This text is here to give you an idea of how your content will look here. Edit this text and replace it with your own content.</p></div>'+
          '</div>'
      },
      {
        title: 'Three Column Template',
        //image: 'template1.gif',
        description: 'A simple three column design that collapses to one column at small browser widths.',
        html:
          '<div class="row">' +
          '  <div class="col-md-4"><p>Sample text. This text is here to give you an idea of how your content will look here. Edit this text and replace it with your own content. Sample text. This text is here to give you an idea of how your content will look here. Edit this text and replace it with your own content.</p></div>'+
          '  <div class="col-md-4"><p>Sample text. This text is here to give you an idea of how your content will look here. Edit this text and replace it with your own content.Sample text. This text is here to give you an idea of how your content will look here. Edit this text and replace it with your own content.</p></div>'+
          '  <div class="col-md-4"><p>Sample text. This text is here to give you an idea of how your content will look here. Edit this text and replace it with your own content.Sample text. This text is here to give you an idea of how your content will look here. Edit this text and replace it with your own content.</p></div>'+
          '</div>'
      },
    ]
});


/*
 WARNING: clear browser's cache after you modify this file.
 If you don't do this, you may notice that browser is ignoring all your changes.
 */
CKEDITOR.editorConfig = function(config) {


  /*
  * This bit is custom
  */

  config.allowedContent = true;
  config.templates_replaceContent = false;
  config.templates_files =   [];


  /*
  * The following is from the drupal ckeditor default ckeditor.config.js file
  */

  config.indentClasses = [ 'rteindent1', 'rteindent2', 'rteindent3', 'rteindent4' ];

  // [ Left, Center, Right, Justified ]
  config.justifyClasses = [ 'rteleft', 'rtecenter', 'rteright', 'rtejustify' ];

  // The minimum editor width, in pixels, when resizing it with the resize handle.
  config.resize_minWidth = 450;

  // Protect PHP code tags (<?...?>) so CKEditor will not break them when
  // switching from Source to WYSIWYG.
  // Uncommenting this line doesn't mean the user will not be able to type PHP
  // code in the source. This kind of prevention must be done in the server
  // side
  // (as does Drupal), so just leave this line as is.
  config.protectedSource.push(/<\?[\s\S]*?\?>/g); // PHP Code
  config.protectedSource.push(/<code>[\s\S]*?<\/code>/gi); // Code tags
  // ALLOW <i></i>
  config.protectedSource.push(/<i[^>]*><\/i>/g);
  config.extraPlugins = '';

  /*
    * Append here extra CSS rules that should be applied into the editing area.
    * Example:
    * config.extraCss = 'body {color:#FF0000;}';
    */
  config.extraCss = '';
  /**
    * Sample extraCss code for the "marinelli" theme.
    */
  if (Drupal.settings.ckeditor.theme == "marinelli") {
    config.extraCss += "body{background:#FFF;text-align:left;font-size:0.8em;}";
    config.extraCss += "#primary ol, #primary ul{margin:10px 0 10px 25px;}";
  }
  if (Drupal.settings.ckeditor.theme == "newsflash") {
    config.extraCss = "body{min-width:400px}";
  }

  /**
    * CKEditor's editing area body ID & class.
    * See http://drupal.ckeditor.com/tricks
    * This setting can be used if CKEditor does not work well with your theme by default.
    */
  config.bodyClass = '';
  config.bodyId = '';
  /**
    * Sample bodyClass and BodyId for the "marinelli" theme.
    */
  if (Drupal.settings.ckeditor.theme == "marinelli") {
    config.bodyClass = 'singlepage';
    config.bodyId = 'primary';
  }
}

/*
 * Sample toolbars
 */

//Toolbar definition for basic buttons
Drupal.settings.cke_toolbar_DrupalBasic = [ [ 'Format', 'Bold', 'Italic', '-', 'NumberedList','BulletedList', '-', 'Link', 'Unlink', 'Image' ] ];

//Toolbar definition for Advanced buttons
Drupal.settings.cke_toolbar_DrupalAdvanced = [
  ['Source'],
  ['Cut','Copy','Paste','PasteText','PasteFromWord','-','SpellChecker', 'Scayt'],
  ['Undo','Redo','Find','Replace','-','SelectAll','RemoveFormat'],
  ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar'],
  ['Maximize', 'ShowBlocks'],
  '/',
  ['Format'],
  ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
  ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
  ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiRtl','BidiLtr'],
  ['Link','Unlink','Anchor','Linkit','LinkToNode','LinkToMenu'],
  ['DrupalBreak', 'DrupalPageBreak']
];

// Toolbar definiton for all buttons
Drupal.settings.cke_toolbar_DrupalFull = [
  ['Source'],
  ['Cut','Copy','Paste','PasteText','PasteFromWord','-','SpellChecker', 'Scayt'],
  ['Undo','Redo','Find','Replace','-','SelectAll','RemoveFormat'],
  ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','Iframe'],
  '/',
  ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
  ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
  ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiRtl','BidiLtr'],
  ['Link','Unlink','Anchor','Linkit','LinkToNode', 'LinkToMenu'],
  '/',
  ['Format','Font','FontSize'],
  ['TextColor','BGColor'],
  ['Maximize', 'ShowBlocks'],
  ['DrupalBreak', 'DrupalPageBreak']
];
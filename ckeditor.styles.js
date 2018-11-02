/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/*
 * This file is used/requested by the 'Styles' button.
 * The 'Styles' button is not enabled by default in DrupalFull and DrupalFiltered toolbars.
 */
 if(typeof(CKEDITOR) !== 'undefined') {
 	CKEDITOR.addStylesSet( 'drupal',
 		[
 		/* Block Styles */

            // These styles are already available in the "Format" drop-down list, so they are
            // not needed here by default. You may enable them to avoid placing the
            // "Format" drop-down list in the toolbar, maintaining the same features.
            
            { name : 'Paragraph (Normal)'	, element : 'p' },
            { name : 'Heading', element : 'h2' },
            { name : 'Subheading', element : 'h3' },
            { name : 'Sub-subheading', element : 'h4' },
            { name : 'Sub-sub-subheading'	, element : 'h5' },

            //{ name : 'Preformatted Text'	, element : 'pre' },

            { name : 'Lead Paragraph', element : 'p', attributes : { 'class' : 'lead' } },


            /* Inline Styles */

            // These are core styles available as toolbar buttons. You may opt enabling
            // some of them in the "Styles" drop-down list, removing them from the toolbar.
            /*
            { name : 'Strong'			, element : 'strong', overrides : 'b' },
            { name : 'Emphasis'			, element : 'em'	, overrides : 'i' },
            { name : 'Underline'		, element : 'u' },
            { name : 'Strikethrough'	, element : 'strike' },
            { name : 'Subscript'		, element : 'sub' },
            { name : 'Superscript'		, element : 'sup' },
            { name : 'De-Emphasized Text', element : 'small' },
            */

            { name : 'Muted text', 		element : 'span', attributes : { 'class' : 'muted' } },
            { name : 'Warning text', 	element : 'span', attributes : { 'class' : 'text-warning' } },
            { name : 'Error text', 		element : 'span', attributes : { 'class' : 'text-error' } },
            { name : 'Info text', 		element : 'span', attributes : { 'class' : 'text-info' } },
            { name : 'Success text', 	element : 'span', attributes : { 'class' : 'text-success' } },

            { name : 'Label', 		element : 'span', attributes : { 'class' : 'label label-default' } },
            { name : 'Success label', 	element : 'span', attributes : { 'class' : 'label label-success' } },
            { name : 'Warning label', 	element : 'span', attributes : { 'class' : 'label label-warning' } },
            { name : 'Important label',   element : 'span', attributes : { 'class' : 'label label-danger' } },
            { name : 'Info label', 		element : 'span', attributes : { 'class' : 'label label-info' } },

/*
            { name : 'Badge', 	      element : 'span', attributes : { 'class' : 'badge' } },
            { name : 'Success badge',     element : 'span', attributes : { 'class' : 'badge badge-success' } },
            { name : 'Warning badge',     element : 'span', attributes : { 'class' : 'badge badge-warning' } },
            { name : 'Important badge',   element : 'span', attributes : { 'class' : 'badge badge-danger' } },
            { name : 'Info badge', 	      element : 'span', attributes : { 'class' : 'badge badge-info' } },
*/


            /* Object Styles */

            { name : 'Basic Table', 	element : 'table', attributes : { 'class' : 'table' } },
            { name : 'Striped Table', 	element : 'table', attributes : { 'class' : 'table, table-striped' } },
            { name : 'Bordered Table', 	element : 'table', attributes : { 'class' : 'table, table-bordered' } },
            { name : 'Condensed Table',   element : 'table', attributes : { 'class' : 'table, table-condensed' } },

            { name : 'Success Row', 	 element : 'tr', attributes : { 'class' : 'success' } },
            { name : 'Error / Danger Row', element : 'tr', attributes : { 'class' : 'error' } },
            { name : 'Warning Row', 	element : 'tr', attributes : { 'class' : 'warning' } },
            { name : 'Info Row', 		element : 'tr', attributes : { 'class' : 'info' } },

            { name : 'Rounded Image', 	element : 'img', attributes : { 'class' : 'img-rounded' } },
            { name : 'Circle Image', 	element : 'img', attributes : { 'class' : 'img-circle' } },
            { name : 'Polaroid Image', 	element : 'img', attributes : { 'class' : 'img-polaroid' } },


            /* Grid Styles */


            { name : 'Row of columns',    element : 'div', attributes : { 'class' : 'row' } },
            { name : '5/6 width column', 	element : 'div', attributes : { 'class' : 'col-md-10' } },
            { name : '3/4 width column', 	element : 'div', attributes : { 'class' : 'col-md-9' } },
            { name : '2/3 width column',  element : 'div', attributes : { 'class' : 'col-md-8' } },
            { name : '1/2 width column', 	element : 'div', attributes : { 'class' : 'col-md-6' } },
            { name : '1/3 width column', 	element : 'div', attributes : { 'class' : 'col-md-4' } },
            { name : '1/4 width column', 	element : 'div', attributes : { 'class' : 'col-md-3' } },
            { name : '1/6 width column', 	element : 'div', attributes : { 'class' : 'col-md-2' } },




            ]);
}
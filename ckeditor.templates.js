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
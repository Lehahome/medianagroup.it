/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
		//config.language = 'ru';
		//config.uiColor = '#AADC6E';
	    // config.extraAllowedContent = '*(*)';
		config.allowedContent = true;
		//config.fillEmptyBlocks = false;
		//config.autoParagraph = false;
		//config.extraAllowedContent = 'a(*)[*]{*};p(*)[*]{*};div(*)[*]{*};li(*)[*]{*};ul(*)[*]{*};li(*)[*]{*}';
		
		//config.extraAllowedContent = "a div";
		
	//config.allowedContent = true;
	//config.allowedContentRules = true;
	config.contentsCss = 'http://romir.ru/css/style.css';
};
 CKEDITOR.dtd.$removeEmpty.i = 0;
 //CKEDITOR.dtd.button.a = 1;
 CKEDITOR.dtd.a.div = 1;

 
 //CKEDITOR.config.allowedContent = true;
 
 // CKEDITOR.dtd.span.ul = 1;
// CKEDITOR.dtd.span.ol = 1;
// CKEDITOR.dtd.span.table = 1;
//CKEDITOR.config.allowedContent = true;

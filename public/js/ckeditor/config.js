/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';

    // Toolbar configuration generated automatically by the editor based on config.toolbarGroups.
    config.toolbar = [
        {
            name: 'document',
            groups: ['mode', 'document', 'doctools'],
            items: ['Source'/*, '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates'*/]
        },
        {
            name: 'clipboard',
            groups: ['clipboard', 'undo'],
            items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
        },
        {
            name: 'editing',
            groups: ['find', 'selection'/*, 'spellchecker'*/],
            items: ['Find', 'Replace', '-', 'SelectAll'/*, '-', 'Scayt'*/]
        },
        /*{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },*/
        '/',
        {
            name: 'basicstyles',
            groups: ['basicstyles', 'cleanup'],
            items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat']
        },
        {
            name: 'paragraph',
            groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
            items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'/*, 'Language'*/]
        },
        {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
        {
            name: 'insert',
            items: ['Image', 'Html5video', 'Iframe'/*, 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak'*/]
        },
        '/',
        {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
        {name: 'colors', items: ['TextColor', 'BGColor']},
        {name: 'tools', items: ['Maximize', 'ShowBlocks']},
        {name: 'others', items: ['-']},
        {name: 'about', items: ['About']}
    ];

    // Toolbar groups configuration.
    config.toolbarGroups = [
        {name: 'document', groups: ['mode', 'document', 'doctools']},
        {name: 'clipboard', groups: ['clipboard', 'undo']},
        {name: 'editing', groups: ['find', 'selection', 'spellchecker']},
        {name: 'forms'},
        '/',
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi']},
        {name: 'links'},
        {name: 'insert'},
        '/',
        {name: 'styles'},
        {name: 'colors'},
        {name: 'tools'},
        {name: 'others'},
        {name: 'about'}
    ];

    // Add plugins
    config.extraPlugins = 'filebrowser';
    config.extraPlugins = 'imagebrowser';
    config.extraPlugins = 'html5video,widget,widgetselection,clipboard,lineutils';

    // Construct path to file upload route
    // Useful if your dev and prod URLs are different
    var path = CKEDITOR.basePath.split('/');
    path[path.length - 5] = 'upload_image_ck';
    //config.filebrowserUploadUrl = path.splice(0,5).join('/').replace(/\/+$/, '');
    config.filebrowserUploadUrl = sAdminBaseURI + '/ckeditor_image_upload';

    // Browse Image List
    config.imageBrowser_listUrl = sBaseURI + '/public/uploads/ckeditor/image_list.json';

    // Image Preview Text
    config.image_previewText = ' ';

    // Editor Height
    config.height = ['300px'];

    // Load Front end CSS
    config.contentsCss = [
        // sBaseURI + '/public/proui-frontend/css/bootstrap.min.css',
        sBaseURI + '/public/css/app.css',
        sBaseURI + '/public/css/ckeditor.css',
        /* include front end css */

    ];

    // Important! If set to true, classes will not be removed. Some classes are being removed by the editor.
    config.allowedContent = true;
    // Allow empty <i></i>
    CKEDITOR.dtd.$removeEmpty.i = 0;
    config.protectedSource.push(/<i[^>]*><\/i>/g);
    config.extraAllowedContent = 'p(*)[*]{*};div(*)[*]{*};li(*)[*]{*};ul(*)[*]{*}';

    config.entities = false;

    console.log(CKEDITOR.dtd[ 'a' ]);

// Simply redefine DTD like this:
    CKEDITOR.dtd['a']['div'] = 1;
    CKEDITOR.dtd['a']['p'] = 1;
    CKEDITOR.dtd['a']['i'] = 1;
    CKEDITOR.dtd['a']['span'] = 1;

// Check if <div> can be contained in a <p> element.
    console.log( !!CKEDITOR.dtd[ 'a' ][ 'div' ] ); // default false

// Check if <a> can be contained in a <div> element.
    console.log( !!CKEDITOR.dtd[ 'div' ][ 'a' ] ); // default true

    CKEDITOR.config.autoParagraph = false;
    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
    CKEDITOR.config.shiftEnterMode= CKEDITOR.ENTER_P;
};

CKEDITOR.editorConfig = function (config) {
    config.toolbarGroups = [{
            name: 'document',
            groups: ['mode', 'document', 'doctools']
        },
        {
            name: 'clipboard',
            groups: ['clipboard', 'undo']
        },
        {
            name: 'editing',
            groups: ['find', 'selection', 'spellchecker', 'editing']
        },
        {
            name: 'forms',
            groups: ['forms']
        },
        {
            name: 'basicstyles',
            groups: ['basicstyles', 'cleanup']
        },
        {
            name: 'links',
            groups: ['links']
        },
        {
            name: 'insert',
            groups: ['insert']
        },
        {
            name: 'paragraph',
            groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']
        },
        {
            name: 'styles',
            groups: ['styles']
        },
        {
            name: 'colors',
            groups: ['colors']
        },
        {
            name: 'tools',
            groups: ['tools']
        },
        {
            name: 'others',
            groups: ['others']
        },
        {
            name: 'about',
            groups: ['about']
        }
    ];

    config.removeButtons = 'Outdent,BidiLtr,Replace,Language,Anchor,PageBreak,ShowBlocks,Subscript,Superscript,RemoveFormat,CreateDiv,Indent,BidiRtl,Flash,Preview,Print,Save,NewPage';

    config.format_tags = 'p;h1;h2;h3;pre';

    config.extraPlugins = 'lineheight';


    // Simplify the dialog windows.
    config.removeDialogTabs = 'image:advanced;link:advanced';

    // config.filebrowserBrowseUrl = 'https://dev-vbd.gamota.net/landing/assets/ckfinder/ckfinder.html';

    // config.filebrowserImageBrowseUrl = 'https://dev-vbd.gamota.net/landing/ckfinder/ckfinder.html?type=Images';

    // config.filebrowserFlashBrowseUrl = 'https://dev-vbd.gamota.net/landing/assets/ckfinder/ckfinder.html?type=Flash';

    // config.filebrowserUploadUrl = 'https://dev-vbd.gamota.net/landing/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';

    // config.filebrowserImageUploadUrl = 'https://dev-vbd.gamota.net/landing/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';

    // config.filebrowserFlashUploadUrl = 'https://dev-vbd.gamota.net/landing/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';

    config.filebrowserBrowseUrl = '/assets/ckfinder/ckfinder.html';

    config.filebrowserImageBrowseUrl = '/ckfinder/ckfinder.html?type=Images';

    config.filebrowserFlashBrowseUrl = '/assets/ckfinder/ckfinder.html?type=Flash';

    config.filebrowserUploadUrl = '/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';

    config.filebrowserImageUploadUrl = '/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';

    config.filebrowserFlashUploadUrl = '/assets/ckfinder / core / connector / php / connector.php ? command = QuickUpload & type = Flash ';




};
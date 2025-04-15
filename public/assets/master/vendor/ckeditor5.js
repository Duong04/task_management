import {
    ClassicEditor,
    AccessibilityHelp,
    Autosave,
    Bold,
    Essentials,
    Italic,
    Mention,
    Paragraph,
    SelectAll,
    Undo,
    Typing,
    Image,
    ImageToolbar,
    ImageUpload,
    ImageResize,
    ImageStyle,
    SimpleUploadAdapter,
    FontFamily,
    FontSize,
    Alignment
} from 'ckeditor5';

const editorConfig = {
    toolbar: {
        items: [
            'undo', 'redo', 'alignment', '|', 'selectAll', '|', 'bold', 'italic', 
            'fontFamily', 'fontSize', '|', 'accessibilityHelp', 'imageUpload'
        ],
        shouldNotGroupWhenFull: false
    },
    placeholder: 'Mô tả !',
    plugins: [
        AccessibilityHelp, Autosave, Bold, Essentials, Italic, Mention, Paragraph, SelectAll,
        Undo, Typing, Image, ImageToolbar, ImageUpload, ImageResize, ImageStyle, SimpleUploadAdapter, FontFamily, FontSize, Alignment
    ],
    simpleUpload: {
        uploadUrl: `http://127.0.0.1:8000/api/uploads/cloundinary`,
    },
    image: {
        resizeUnit: 'px',
        toolbar: [
            'resizeImage:25',
            'resizeImage:50',
            'resizeImage:75',
            'resizeImage:100',
            'imageTextAlternative',
            'imageStyle:alignLeft',    
            'imageStyle:alignCenter', 
            'imageStyle:alignRight',   
            'imageStyle:full',
            'imageStyle:side'
        ],
        styles: [
            { name: 'alignLeft', title: 'Align Left', icon: 'alignLeft', className: 'image-style-align-left' },
            { name: 'alignCenter', title: 'Align Center', icon: 'alignCenter', className: 'image-style-align-center' },
            { name: 'alignRight', title: 'Align Right', icon: 'alignRight', className: 'image-style-align-right' },
            'full',
            'side'
        ]
    },
    alignment: {
        options: ['left', 'center', 'right', 'justify']
    },
    licenseKey: '',
    mention: {
        feeds: [
            {
                marker: '@',
                feed: []
            }
        ]
    },
};

ClassicEditor
    .create( document.querySelector( '#description' ), editorConfig )
    .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );
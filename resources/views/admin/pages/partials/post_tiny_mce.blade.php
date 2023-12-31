<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.0/tinymce.min.js" integrity="sha512-XaygRY58e7fVVWydN6jQsLpLMyf7qb4cKZjIi93WbKjT6+kG/x4H5Q73Tff69trL9K0YDPIswzWe6hkcyuOHlw==" crossorigin="anonymous"></script>
<script>
    tinymce.init({
        selector: 'textarea.content',
        relative_urls: false,
        path_absolute : "/",
        theme: "silver",
        convert_urls: false,
        menubar: true,
        height: 500,
        contextmenu: "link cut copy paste",
        plugins: [
            "advlist autolink link image media code lists print"
        ],
        toolbar1: "undo redo | bold italic underline | forecolor backcolor | alignleft aligncenter alignright  alignjustify | bullist numlist outdent indent",
        toolbar2: "| image | link unlink |  media pdf pageembed | code | youtube  flickr |",
        powerpaste_allow_local_images: true,
        powerpaste_word_import: 'prompt',
        powerpaste_html_import: 'prompt',
        file_picker_types: 'file image media',
        image_advtab: false,
        external_filemanager_path: '/admin/laravel-filemanager?editor=tinymce5&type=Images',
        filemanager_title: "Filemanager",

        browser_spellcheck: true,

        file_picker_callback : function(callback, value, meta) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config_attachment.path_absolute + 'admin/laravel-filemanager?editor=' + meta.fieldname;
            if (meta.filetype == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }
            console.log({x,y,cmsURL})
            tinyMCE.activeEditor.windowManager.openUrl({
                url : cmsURL,
                title : 'Filemanager',
                // width : x * 0.8,
                // height : y * 0.8,
                resizable : "yes",
                close_previous : "no",
                onMessage: (api, message) => {
                    callback(message.content);
                }
            });
        }

    });

    var editor_config_attachment= {
        selector: "textarea.attachement",
        relative_urls: false,
        path_absolute : "/",
        menubar: false,
        theme: "silver",
        convert_urls: false,
        height: 400,
        contextmenu: "link cut copy paste",
        plugins: [
            "advlist autolink link image media code lists"
        ],
        toolbar1: "",
        toolbar2: " image",
        external_filemanager_path: '/admin/laravel-filemanager?editor=tinymce5&type=Images',
        filemanager_title: "Filemanager",
        file_picker_types: 'image',
        file_picker_callback : function(callback, value, meta) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config_attachment.path_absolute + 'admin/laravel-filemanager?editor=' + meta.fieldname;
            if (meta.filetype == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }
            console.log({x,y,cmsURL})
            tinyMCE.activeEditor.windowManager.openUrl({
                url : cmsURL,
                title : 'Filemanager',
                // width : x * 0.8,
                // height : y * 0.8,
                resizable : "yes",
                close_previous : "no",
                onMessage: (api, message) => {
                    callback(message.content);
                }
            });
        }
    }
    tinymce.init(editor_config_attachment);

</script>

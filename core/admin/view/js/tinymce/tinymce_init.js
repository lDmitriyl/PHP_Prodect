  function MCEInit(element, height = 400){

    tinymce.init({
        language: 'ru',
        mode: 'exact',
        elements : element,
        height: height,
        gecko_spellcheck: true,
        relative_urls: false,
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table directionality",
            "emoticons template paste textpattern media imagetools"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | forecolor backcolor emoticons | " +
            "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | " +
            "formatselect fontsizeselect | code media emoticons ",
        image_advtab: true,
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        images_reuse_filename: true,
        imagetools_toolbar: 'editimage imageoptions',
        images_upload_handler: function (file, success, fail){

            let formData = new FormData;

            console.log(file);

            formData.append('file', file.blob(), file.filename());

            formData.append('ajax', 'wyswyg_file');

            Ajax({
                url: document.querySelector('#main-form').getAttribute('action'),
                data: formData,
                contentType: false,
                processData: false,
                type: 'post'
            }).then(res =>{
                console.log(res)

                success(JSON.parse(res).location)
            })

        },
        file_picker_callback: function (callback, value, meta){

            let input = document.createElement('input');

            input.setAttribute('type', 'file');

            input.setAttribute('accept','image/*');

            input.click();

            input.onchange = function (){

                let reader = new FileReader

                reader.readAsDataURL(this.files[0]);

                reader.onload = () => {

                    let blobCache = tinymce.activeEditor.editorUpload.blobCache;

                    let base64 = reader.result.split(',')[1];

                    let blobInfo = blobCache.create(this.files[0].name, this.files[0], base64);

                    blobCache.add(blobInfo);

                    callback(blobInfo.blobUri(), {title: this.files[0].name})

                }

            }

        }
    })

}

MCEInit()

let mceElements = document.querySelectorAll('input.tinyMceInit');

if(mceElements.length){

    mceElements.forEach(item => {

        item.onchange = () => {

            let textArea = item.closest('.input-group').querySelector('textarea');

            let textAreaName = textArea.getAttribute('name');

            if(textAreaName){

                if(item.checked){

                    MCEInit(textAreaName, 400)

                }else{

                    tinymce.remove(`[name="${textAreaName}"]`)

                    textArea.value = textArea.value.replace(/<\/?[^>]+(>|$)/g, '');

                }

            }

        }

    })

}

createFile()

function createFile(){

    let files = document.querySelectorAll('input[type=file]');

    let fileStore = [];

    if(files.length){

        files.forEach(item =>{

            item.onchange = function (){

                let multiple = false;

                let container

                let parentContainer

                if(this.hasAttribute('multiple')){

                    multiple = true

                    parentContainer = this.closest('.gallery_container')

                    if (!parentContainer) return false

                    container = parentContainer.querySelectorAll('.empty_container')

                    if(container.length < this.files.length){

                        for( let i = 0 ; i < this.files.length - container.length; i++) {

                            let el = document.createElement('div')

                            el.classList.add('vg-dotted-square', 'vg-center', 'empty_container');

                            parentContainer.append(el);

                        }

                        container = parentContainer.querySelectorAll('.empty_container')

                    }
                }

                let fileName = item.name

                let attributeName = fileName.replace(/[\[\]]]/g, '');

                for( let i in this.files){

                    if(this.files.hasOwnProperty(i)){

                        if(multiple){

                            if(typeof fileStore[fileName] === 'undefined') fileStore[fileName] = [];

                            let elId = fileStore[fileName].push(this.files[i]) - 1;

                            container[i].setAttribute(`data-delete-Field-${attributeName}`, elId)

                            showImage(this.files[i], container[i], function (){

                                parentContainer.sortable({excludedElements: 'label .empty_container'});

                            });

                            deleteImage(elId, attributeName, container[i]);

                        }else{

                            container = this.closest('.img_container').querySelector('.card-img')

                            showImage(this.files[i], container);

                        }
                    }
                }
            }

            let area = item.closest('.img_wrapper')

            if(area){

                dragAndDrop(area, item);

            }

        })

        let form = document.querySelector('#main-form')

        if(form){

            form.onsubmit = function (e){

                createJsSortable(form);

                if(!isEmpty(fileStore)){

                    e.preventDefault();

                    let formData = new FormData(this)

                    for (let i in fileStore){

                        if(fileStore.hasOwnProperty(i)){

                            formData.delete(i)

                            let rowName = i.replace(/[\[\]]]/g, '');

                            fileStore[i].forEach((item,index) =>{

                                formData.append(`${rowName}[${index}]`, item)

                            })

                        }

                    }

                    formData.append('ajax', 'editData');

                    Ajax({
                        url: this.getAttribute('action'),
                        type: 'post',
                        data: formData,
                        processData: false,
                        contentType: false
                    }).then(res => {
                        try{

                            res = JSON.parse(res);

                            if(!res.success) throw new Error();

                            location.reload();

                        }catch (e){

                            alert('Произошла внутренняя ошибка')

                        }
                    })
                }
            }
        }

        function deleteImage(elId, attributeName, container){

            container.addEventListener('click', function (){

                this.remove()

                delete fileStore[attributeName][elId]

            })
        }

        function showImage(item, container, callback){

            container.innerHTML = '';

            let reader = new FileReader();

            reader.readAsDataURL(item);

            reader.onload = e => {

                container.innerHTML = '<img class="img_item" src="">';

                container.querySelector('img').setAttribute('src', e.target.result);

                container.classList.remove('empty_container')

                callback && callback();

            }
        }

        function  dragAndDrop(area, input){

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach((eventName, index) => {

                area.addEventListener(eventName, e => {

                    e.preventDefault();

                    e.stopPropagation();

                    if(index < 2){

                        area.style.background = 'lightblue';

                    }else{

                        area.style.background = '#fff';

                        if(index === 3){

                            input.files = e.dataTransfer.files;

                            input.dispatchEvent(new Event('change'));

                        }
                    }
                });
            });
        }
    }
}


let galleries = document.querySelectorAll('.gallery_container');

if(galleries.length){

    galleries.forEach(item => {

        item.sortable({

            excludedElements: 'label .empty_container',
            stop: function (dragEl){

            }

        })

    });

}

function createJsSortable(form){

    if(form){

        let sortable = form.querySelectorAll('input[type=file][multiple]');

        if(sortable.length){

            sortable.forEach(item => {

                let container = item.closest('.gallery_container');

                let name = item.getAttribute('name');

                if(name && container){

                    name = name.replace(/\[\]/g, '');

                    let inputSorting = form.querySelector(`input[name="js-sorting[${name}]"]`);

                    if(!inputSorting){

                        inputSorting = document.createElement('input');

                        inputSorting.name = `js-sorting[${name}]`;

                        form.append(inputSorting);

                    }

                    let res = [];

                    for(let i in container.children){

                        if(container.children.hasOwnProperty(i)){

                            if(!container.children[i].matches('label') && !container.children[i].matches('.empty_container')){

                                if(container.children[i].tagName === 'A'){

                                    res.push(container.children[i].querySelector('img').getAttribute('src'));

                                }else{

                                    res.push(container.children[i].getAttribute(`data-delete-Field-${name}`));

                                }

                            }

                        }

                    }

                    inputSorting.value = JSON.stringify(res);

                }

            })

        }

    }



}





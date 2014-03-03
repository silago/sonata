/* function deletePhoto(){
 if(confirm('Удалить фото?')){

 }
 return false;
 };	*/


function openGroup(id) {
    $('a').each(function () {
        if (id == $(this).attr('href')) {
            var t = $(this).html();
            var hr = $(this).attr('href');

            $(this).parents('.expandable').each(function () {
                if ($(this).has('li.expandable')) {
                    $(this).find('div:first').click();
                }
            });

            $(this).parents('.expandable.lastExpandable').each(function () {
                if ($(this).has('li.expandable.lastExpandable')) {
                    $(this).find('div:first').click();
                }
            });
            window.location.assign(hr);
        }
        ;
    });
    return false;
}
;


$().ready(function () {
    /* Фотографии группы каталога */
    /*Фотография*/
    var arrPhoto = [];
    var finder = $('#catalog_group_photo').elfinder({
        url:'/include/ext/elfinder/php/connector.php',
        lang:'ru',
        commandsOptions:{getfile:{onlyURL:false, multiple:false, folders:true, oncomplete:''}},
        customData:{module:'catalog', area:'images'},
        validName: "/^[0-9A-Za-z_.-]+$/",
        height:'465',
        width:'800',
        onlyMimes:["image"],
        commands :
            ['reload', 'quicklook', 'rm', 'upload', 'copy',
                'cut', 'paste', 'info', 'view', 'resize'],
        uiOptions : {
            toolbar : [
                ['upload'],
                ['reload'],
                // ['home', 'up'],
                ['info'],
                ['quicklook'],
                ['copy', 'cut', 'paste'],
                ['rm'],
                ['rename', 'resize']
            ]
        },

        handlers:{
            remove:function (event, elfinderInstance) {
                for (i = 0; i <= event.data.removed.length; i++) {

                    if ((event.data.added)) {
                        var uploaded = event.data.added[i].name
                    } else {
                        var uploaded = '';
                    }

                    $.ajax({
                        type:'POST',
                        url:'/admin/catalog/photoDelete.php',
                        data:{hash:event.data.removed[i], uploaded:uploaded},
                    })
                }
            }
        },

        getFileCallback:function (data) {
            if (($.trim(data.mime)).match('(image/)')) {
                var ext = data.name.split('.');
                $("div#resultphoto > ul.thumbnails").empty();
                $("div#resultphoto > ul.thumbnails").append('<li class="span2" style="text-align:center;position:relative;"><div onclick="if(confirm(\'Удалить фото?\')) $(this).parent().remove(); return false;" style="position:absolute;top:-10px; right:-10px;z-index:1000;"><img title="Удалить фото" src="/include/ext/bootstrap/img/x.png"></div><a class="thumbnail"><img src="/upload/thumbnails/' + data.hash + '.' + ext[1] + '" /></a></li><input type="hidden" name="thumb" value="/upload/thumbnails/' + data.hash + '.' + ext[1] + '" /><input type="hidden" value=' + data.url + ' name="photo"/>');
                $("a#close").click();
                alert('Фотография добавлена');
            } else {
                data.open();
            }
        },
    }).elfinder('instance');

    $("a#add").click(function () {
        if (($('div.elfinder-stat-selected').html()).match('(jpg|png|gif)')) {
            finder.dblclick();
        } else {
            alert('Для группы можно добавить только 1 картинку')
        }
    });

    /*Фотография*/
    /* Фотографий группы каталога */

    /* Мультивставка фотонрафий из elfinder */
    var f = $('#catalog_item_photo').elfinder({
        url:'/include/ext/elfinder/php/connector.php',
        lang:'ru',
        commandsOptions:{getfile:{onlyURL:false, multiple:true, folders:true, oncomplete:''}},
        customData:{module:'catalog', area:'images'},
        validName: "/^[0-9A-Za-z_.-]+$/",
        height:'465',
        width:'800',
        onlyMimes:["image"],
        commands :
            ['reload', 'quicklook', 'rm', 'upload', 'copy',
                'cut', 'paste', 'info', 'view', 'resize'],
        uiOptions : {
            toolbar : [
                ['upload'],
                ['reload'],
                // ['home', 'up'],
                ['info'],
                ['quicklook'],
                ['copy', 'cut', 'paste'],
                ['rm'],
                ['rename', 'resize']
            ]
        },

        handlers:{
            upload:function (event, elfinderInstance) {
                for (i = 0; i <= event.data.added.length; i++) {
                    $.ajax({
                        type:'POST',
                        url:'/admin/catalog/photoResize.php',
                        data:{photo:event.data.added[i].name, type:'group', hash:event.data.added[i].hash}

                    })
                f.sync();
                }

            },

            remove:function (event, elfinderInstance) {
                for (i = 0; i <= event.data.removed.length; i++) {

                    if ((event.data.added)) {
                        var uploaded = event.data.added[i].name
                    } else {
                        var uploaded = '';
                    }

                    $.ajax({
                        type:'POST',
                        url:'/admin/catalog/photoDelete.php',
                        data:{hash:event.data.removed[i], uploaded:uploaded},
                    })
                }
            }
        },

        getFileCallback:function (data) {
            var i = 0;
            var ext = [];

            $("div#resultphoto > ul.thumbnails > div.well").remove();
            if (!($("div#resultphoto > ul.thumbnails").find('input[name="primary"]:checked').val())) {
                var primary = 0;
            }

            for (i; i < data.length; i++) {
                if (data[i].mime != 'directory') {
                    var photoCount = $("li.span2").length
                    ext[i] = data[i].name.split('.');
                    if (i == 0 && primary == '') {
                        var select = 'checked';
                    } else {
                        var select = '';
                    }
                    $("div#resultphoto > ul.thumbnails").append('<li class="span2" style="text-align:center;position:relative;">' +
                        '<div onclick="if(confirm(\'Удалить фото?\')) $(this).parent().remove(); return false;" style="position:absolute;top:-10px; right:-10px;z-index:1000;">' +
                        '<img title="Удалить фото" src="/include/ext/bootstrap/img/x.png">' +
                        '</div>' +
                        '<a class="thumbnail">' +
                        '<img src="/upload/thumbnails/' + data[i].hash + '.' + ext[i][1] + '" />' +
                        '</a>' +
                        '<input type="radio" name="primary" id="primary" value=\'' + photoCount + '\' ' + select + '><br/>Главное фото' +
                        '<input type="hidden" value=' + data[i].url + ' name="photo[]"/>' +
                        '<input type="hidden" value="' + photoCount + '" name="position[]"/>' +
                        '<input type="hidden" value="/upload/thumbnails/' + data[i].hash + '.' + ext[i][1] + '" name="thumb[]"/></li>');
                    $("a#close").click();
                } else {
                    data[i].open();
                }
            }
            ;
        },

    }).elfinder('instance');

    $("a#additem").click(function () {
        f.dblclick();
    });

    /* Мультивставка фотонрафий из elfinder */
});


/**
 * Функция для изменения позиции страницы
 *
 * @param id
 * @param parentid
 */
function pagePosChange(id, parentid){
    var val = $('input#pos'+id).val()
    var id = id;
    $.ajax({
        type:'POST',
        url:'/admin/page/posChange.php',
        data:{id:id, value:val},
        success: function(data){
          $('div#content').html(data);
            $("#tree").treeTable({
                initialState: 'collapsed',
                treeColumn: 0,
                expandable: true,
                expand: 'node#-'+id,
            });
            $('tr#node-0').find('td > a.expander').click();
            $('tr#node-0').find('td > a.expander').remove();
            $('tr#node-'+id).reveal();

            var elem = $('input#pos'+id);
            var rowpos = $('tr#node-'+id).offset();

            $('html, body').animate({
                scrollTop: rowpos.top - 180
            }, 'fast');


            //$('body').scrollTop(rowpos.top+100);

            elem.tooltip({placement: "right",title: 'Изменено',trigger: 'manual'});
            elem.tooltip('show');
            elem.oneTime("1500ms", function() {
                elem.tooltip('hide');
            });
        }
    })
}


/**
 * Функция проверки uri (группы, товара, страницы, новости, группы новостей etc.
 */
function uricheck(){
    var area = document.location.href.split('/')
    var reguri = /[a-z0-9]{1,}[a-z0-9\-]{1,}[a-z0-9]/;
    var value = $('#uri').val().replace("--", "-");
    var action = $('input#action').val();
    if(value.substr(0,1) == '-'){value = value.substr(1);} //убираем дефис в начале строки
    if((value.substr(value.length - 1)) == '-'){value = value.substr(0, value.length - 1);} //убираем дефис в конце строки
    $('#uri').val(value);//устанавливаем новое значение uri

    var endValue = $('#uri').val();
    $.ajax({
        type: 'POST',
        url: '/admin/'+area[4]+'/uriCheck.php',
        data: {uri:endValue, action:action},
        success: function(data){
            data = data.trim();
            if(!($('#uri').val() == data)){
                $('#uri').val(data)
            }
        }
    })
}

function addField(id){

    var regtitle = /^[a-zа-я0-9]+$/i;
    var groupUri = document.location.pathname.split('/');

    var count = $('div#'+id).find('li.field').size()
    var title = $('div#'+id).find('input#title').val()

    var fieldNumber = count + 1;


    console.log(count);
    console.log(type);

    switch (type){
        case '0':
            var content = ''+
                '<li id="list_'+count+'" class="field">'+
                    '<div>' +
                    '<span class="blockTitle">'+title+'</span>' +
                    '<span style="float:right;cursor:pointer;" onclick="return ShowOrHide('+count+')">' +
                    '<i title="Подробнее" class="icon-chevron-down"></i>' +
                    '</span>' +
                    '</div>'+
                    '<div id="info_'+count+'" class="info">' +
                    '<form action="#" class="form-inline">' +
                    '<div class="control-group">' +
                    '<label class="control-label" for="title">Заголовок ссылки:</label>' +
                    '<div class="controls">' +
                    '<input onBlur="return checkTitle();" type="text" name="title" id="title" value="'+title+'">' +
                    '</div>' +
                    '</div>' +
                    '<div class="control-group">' +
                    '<label class="control-label" for="url">URL:</label>' +
                    '<div class="controls">' +
                    '<input onBlur="return checkUrl();" type="text" name="url" id="url" value="">' +
                    '</div>' +
                    '</div>' +
                    '</form>'+
                    '<div class="btn-group">' +
                    '<button title="Отменить изменения" data-placement="bottom" class="btn btn-info" onclick="return cancelChange();"> <i class="icon-refresh"></i></button>'+
                    '<button title="Удалить пункт меню" data-placement="bottom" class="btn btn-danger" onclick="return deleteNode(\''+count+'\')"> <i class="icon-trash"></i></button>' +
                    '</div>' +
                    '</div>' +
                    '<input type=hidden class="title" name="itemsArr['+count+'][title]" value="'+title+'">'+
                    '<input type=hidden class="url" name="itemsArr['+count+'][uri]" value="">'+
                    '<input type=hidden class="item_id" name="itemsArr['+count+'][item_id]" value="'+count+'">'+
                    '<input type=hidden class="parent_id" name="itemsArr['+count+'][parent_id]" value="">'+
                    '<input type=hidden class="order" name="itemsArr['+count+'][order]" value="">'+
                    '<ol id="'+count+'"></ol>'+
                    '</li>';
            //'' +
                /*'<li id="list_'+count+'"><div id="'+groupUri[2]+'_'+id+'_field_'+count+'" class="row field">' +
                        '<span class="span7">Поле № '+fieldNumber+'</span><br/><br/>' +
                        //'<div class="span5">' +
                            'Имя поля только латинские символы и цифры (например "adress", "phone") <br/><input class="span5" type="text" value="" name="name['+count+']">' +
                        //'</div>' +
                        //'<div class="span5">' +
                            'Название поля (например "Ваш адрес", "Телефон") <br/><input class="span5" type="text" value="" name="description['+count+']">' +
                        //'</div>' +
                        //'<div class="span5">' +
                            'Значение поля по-умолчанию (например "340-911") <br/><input class="span5" type="text" value="" name="value['+count+']">' +
                            '<input type="hidden" value="input" name="type['+count+']">' +
                        //'</div>' +
                '</div></li>'; */
        break;

        case '1':
            var content = '' +
                '<div id="'+groupUri[2]+'_'+id+'_field_'+count+'" class="row field">' +
                '<div class="span6">' +
                'Имя поля только латинские символы и цифры (например "adress", "phone") <br/><input class="span6" type="text" value="" name="name['+count+']">' +
                '</div>' +
                '<div class="span6">' +
                'Название поля (например "Ваш адрес", "Телефон") <br/><input class="span6" type="text" value="" name="description['+count+']">' +
                '</div>' +
                '<div class="span6">' +
                'Значение поля по-умолчанию (например "340-911") <br/><input class="span6" type="text" value="" name="value['+count+']">' +
                '<input type="hidden" value="input" name="type['+count+']">' +
                '</div>' +
                '</div>';
            break;
    }

    if(!(title.match(regtitle))){
        var error = 'Поле название содержит недопустимые символы';
        $('div#'+id).prepend('<div class="alert alert-error">'+error+'</div>');
    }else{
        $('div#'+id).find('ol.sortable').append(content);
    }

    return false;
}

function changeFieldType(id){
    var val = $('div#'+id).find('select > option:selected').val();

    switch(val){
        case '0':
           var content = '<div class="row" id="cont">' +
                    '<div class="span6">'+
                        'Название поля <br/> <input type="text" class="span6" name="title">'+
                    '</div>'+
                    '<div class="span6">'+
                        'Значение поля по умолчанию <br/> <input type="text" class="span6" name="value">'+
                    '</div>'+
               '</div>'
        break;
        case '1':
            var content = '<div class="row" id="cont">' +
                '<div class="span6">'+
                'Название поля <br/> <input type="text" class="span6" name="title">'+
                '</div>'+
                '<div class="span6">'+
                'Значение поля по умолчанию <br/> <input type="text" class="span6" name="value">'+
                '</div>'+
                '</div>'
        break;
        case '2':
            var content = '<div class="row" id="cont">' +
                '<div class="span6">'+
                'Название поля <br/> <input type="text" class="span6" name="title">'+
                '</div>'+
                '<div class="span12" style="padding: 12px 0px 12px 0px;">'+
                    '<button class="btn btn-primary" onclick="return addPoint(id)">Добавить пункт</button>'+
                '</div>'+
                '<div class="span3 point">'+
                    'Имя пункта #1 <br/> <input type="text" class="span3" name="option[0]">'+
                '</div>'+
                '<div class="span3 point">'+
                'Имя пункта #2 <br/> <input type="text" class="span3" name="option[1]">'+
                '</div>'+
                '<div class="span3 point">'+
                    'Имя пункта #3 <br/> <input type="text" class="span3" name="option[2]">'+
                '</div>'+
                '</div>'
        break;
        case '3':
            var content = '<div class="row" id="cont">' +
                '<div class="span6">'+
                'Название поля <br/> <input type="text" class="span6" name="title">'+
                '</div>'+
                '<div class="span12" style="padding: 12px 0px 12px 0px;">'+
                '<button class="btn btn-primary" onclick="return addPoint(id)">Добавить пункт</button>'+
                '</div>'+
                '<div class="span3 point">'+
                'Имя пункта #1 <br/> <input type="text" class="span3" name="option[0]">'+
                '</div>'+
                '<div class="span3 point">'+
                'Имя пункта #2 <br/> <input type="text" class="span3" name="option[1]">'+
                '</div>'+
                '<div class="span3 point">'+
                'Имя пункта #3 <br/> <input type="text" class="span3" name="option[2]">'+
                '</div>'+
                '</div>'
        break;
        case '4':
            var content = '<div class="row" id="cont">' +
                '<div class="span6">'+
                'Название поля <br/> <input type="text" class="span6" name="title">'+
                '</div>'+
                '<div class="span12" style="padding: 12px 0px 12px 0px;">'+
                '<button class="btn btn-primary" onclick="return addPoint(id)">Добавить пункт</button>'+
                '</div>'+
                '<div class="span3 point">'+
                'Имя пункта #1 <br/> <input type="text" class="span3" name="option[0]">'+
                '</div>'+
                '<div class="span3 point">'+
                'Имя пункта #2 <br/> <input type="text" class="span3" name="option[1]">'+
                '</div>'+
                '<div class="span3 point">'+
                'Имя пункта #3 <br/> <input type="text" class="span3" name="option[2]">'+
                '</div>'+
                '</div>'
        break;
    }

    $('div#'+id+' > div#fieldlist').find('div#cont').remove();
    $('div#'+id+' > div#fieldlist').append(content);

}

function addPoint(id){
    var countPoints = $('div#'+id+' > div#cont').find('div.point').size();
    var num = countPoints+1;
    $('div#'+id+' > div#cont').append('<div class="span3 point">Имя пункта #'+num+'<br/><input type="text" class="span3" name="option['+countPoints+']"></div>')
    return false;
}


jQuery(document).on('click', '.post-type-shop_order .wp-list-table tbody td').on('click', '.order-preview:not(.disabled)', function () {
    //Вызывается при нажатии на глаз
    addUrlToProducts(30); //30 секунд будем ожидать появления окна, чтобы добавить ссылок
});


function addUrlToProducts(i) {
    if (i < 0) return;

    setTimeout(function () {
        var modalDialog = jQuery('#wc-backbone-modal-dialog');
        if (modalDialog.length == 0) {
            //Если окна нет, то ждем дальше
            addUrlToProducts(--i);
            return;
        };

        jQuery(modalDialog).find('tr.wc-order-preview-table__item').each(function(i,elem) {
            var classes = jQuery(this).attr('class').split(/\s+/);

            jQuery.each(classes,function(index,value){
                if (value.indexOf("urlb--") == 0) {
                    var urlb = value.substr(6);
                    console.log(urlb);

                    jQuery(elem).find('td.wc-order-preview-table__column--product').wrapInner("<a href='" + atob(urlb) + "'></a>");

                }
            });
        });

    }, 1000); //задержка перед выполнением 1 секунда
}


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
        //Далее уже при присутствующем окне

        //var products = jQuery(modalDialog).find('tr.wc-order-preview-table__item');

        //[class ^= pre]

        jQuery(modalDialog).find('tr.wc-order-preview-table__item').each(function(i,elem) {
            var classes = jQuery(this).attr('class').split(/\s+/);

            jQuery.each(classes,function(index,value){
                if (value.indexOf("slug--") == 0) {
                    var slug = value.substr(6);
                    console.log(slug);
                }
            });
            //alert(jQuery(this).attr('class'));
            /*if ($(this).hasClass("stop")) {
                alert("Остановлено на " + i + "-м пункте списка.");
                return false;
            } else {
                alert(i + ': ' + $(elem).text());
            }*/
        });

        alert(modalDialog.length + " " + i);




    }, 1000); //задержка перед выполнением 1 секунда
}


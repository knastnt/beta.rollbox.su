jQuery(document).on('click', '.post-type-shop_order .wp-list-table tbody td').on('click', '.order-preview:not(.disabled)', function () {
    //Вызывается при нажатии на глаз
    addUrlToProducts(3);
});


function addUrlToProducts(i) {
    if (i < 0) return;

    setTimeout(function () {

        alert("Hello " + i);

        addUrlToProducts(--i);

    }, 2000);
}


jQuery( function( $ ) {
			  
	$(".quantity-arrow-minus").live('click', function(){
	  var $input = $(this).attr('id');
	  $input = $input.replace('btn-', '');
	  var $quantityNum = $('#' + $input);	
	  if ($quantityNum.val() > 1) {
		$quantityNum.val(+$quantityNum.val() - 1);
		$( '.woocommerce-cart-form :input[name="update_cart"]' ).prop( 'disabled', false );
	  }
	});

	/*$('.quantity-arrow-plus').unbind().click(function() {
	  var $input = $(this).attr('id');
	  $input = $input.replace('btn-', '');
	  var $quantityNum = $('#' + $input);
	  $quantityNum.val(+$quantityNum.val() + 1);
	  $( '.woocommerce-cart-form :input[name="update_cart"]' ).prop( 'disabled', false );
	});*/
	
	
	/*$('.quantity-arrow-plus').on('click', function(e){
      var $input = $(this).attr('id');
	  $input = $input.replace('btn-', '');
	  var $quantityNum = $('#' + $input);
	  $quantityNum.val(+$quantityNum.val() + 1);
	  $( '.woocommerce-cart-form :input[name="update_cart"]' ).prop( 'disabled', false );
    });*/
	
	$(".quantity-arrow-plus").live('click', function(){
      var $input = $(this).attr('id');
	  $input = $input.replace('btn-', '');
	  var $quantityNum = $('#' + $input);
	  $quantityNum.val(+$quantityNum.val() + 1);
	  $( '.woocommerce-cart-form :input[name="update_cart"]' ).prop( 'disabled', false );
	  //$( '.woocommerce-cart-form :input[name="update_cart"]' ).click();
	});

});
<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 06.08.2019
 * Time: 13:42
 */

add_action( 'wp_enqueue_scripts', 'homepage_map_include_script' );
function homepage_map_include_script() {
    wp_enqueue_script( 'homepage-map-script', "https://maps.api.2gis.ru/2.0/loader.js" );
}


function print_homepage_map() {
?>

<div id="map"></div>
        <script>
			var map, marker;

            f = DG.then(function() {

                    map = DG.map('map', {
                    center: [50.544124, 137.019548],
                    zoom: 13,
					maxBounds: [
                        [50.524124, 137.009548],
                        [50.564124, 137.029548]
                    ],
                    minZoom: 12
                });


				myPopUp = DG.popup({
						minWidth: 400,
						sprawling: true
					})
                    .setContent('<a class="geoPhoto" href="https://2gis.ru/komsomolsk/firm/70000001024179653" target="_blank"></a>Мы находимся здесь!<br><i>проспект Мира, 29 - цокольный этаж</i><br><a style="color: #b3b3b3;" href="javascript:MyFunction();">Показать вход</a>');

				marker = DG.marker([50.544124, 137.019548])
                    .addTo(map)
                    .bindPopup(myPopUp);

	           });


			function MyFunction() {
                var options = {vectors: [
                    "LINESTRING(137.019508 50.544274, 137.019548 50.544174)"
                ]}
				door = DG.entrance(options).addTo(map).show(true);
				marker.removeFrom(map);


				setTimeout(function() {
                    marker.addTo(map);
                    door.removeFrom(map);
                    myPopUp.openOn(map);
                }, 2000);
			}
        </script>
		<style>
		 .geoPhoto {
            background-image: url(https://beta.rollbox.su/wp-content/uploads/2019/08/logo-small.png);
			background-size: contain;
			width: 65px;
			display: block;
			float: left;
			margin-right: 13px;
			background-position: center;
			background-repeat: no-repeat;
			height: 50px;
		 }
            #map {
                /*width:1140px;*/
                height:143px
            }
		</style>
<?php
}
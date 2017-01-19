<?php
use PentagonalProject\AlmiraTrans\Template;

if (!isset($this) || ! $this instanceof Template) {
    return;
}
?>
  </div>
  <!-- .wrap -->
  <!--
    // javascript
  -->
  <script type="text/javascript" async>
    var keyNameJs,
        jsBody = typeof jsBody == 'object' ? jsBody : {};

    for (keyNameJs in jsBody) {
        try {
            document.write('<script src="'+ jsBody[keyNameJs] +'" type="text/javascript"><\/script>');
        } catch (err) {}
    }

    /* Replace no-js
     -------------------------------------- */
    window.document.documentElement.className = window.document.documentElement.className.replace(/no-js/, 'js');

    /* --------------------------------------
     * GOOGLE MAPS API
     * --------------------------------------
     */
    var map;
    function initMap() {
        try {
            var idMap = document.getElementById('map');
            var myLatLng = {lat: -7.9240115, lng: 112.5958141};
            map = new google.maps.Map(idMap, {
                center: myLatLng,
                zoom: 15,
                mapTypeId: 'roadmap'
            });
            google.maps.event.addListenerOnce(map, 'idle', function(){
                try {
                    jQuery(idMap).removeClass('map-preload');
                } catch(err) {}
            });
            var contentString = '<h2>Almira Trans Wisata</h2>'
              + '<p>'
              + '<strong>Perumahan Landungsari Asri Blok A no. 17</strong><br/>'
              + '<small><em>(Jl. Tirto Utomo Gang 2 Sebelah barat Universitas Muhammadiyah Malang)</em></small>'
              + '</p>';
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: 'Almira Trans Wisata'
            });
            marker.addListener('click', function() {
                try {
                    map.setCenter(marker.getPosition());
                    var zoom = map.getZoom();
                    var defZoom = 10;
                    if (typeof zoom == "number") {
                        defZoom = zoom;
                    }
                    console.log(defZoom);
                    if (defZoom < 13) {
                        map.setZoom(13);
                    } else if (defZoom > 18) {
                        map.setZoom(15);
                    }
                    infowindow.open(map, marker);
                } catch(err){}
            });
        } catch (err) {}
    }

    // hack Google Maps to bypass API v3 key
    // needed since 22 June 2016
    // (http://googlegeodevelopers.blogspot.com.es/2016/06/building-for-scale-updates-to-google.html)
    var target = document.head;
    var observer = new MutationObserver(function(mutations) {
        try {
            for (var i = 0; mutations[i]; ++i) { // notify when script to hack is added in HTML head
                if (mutations[i].addedNodes[0].nodeName == "SCRIPT" && mutations[i].addedNodes[0].src.match(/\/AuthenticationService.Authenticate?/g)) {
                    var str = mutations[i].addedNodes[0].src.match(/[?&]callback=.*[&$]/g);
                    if (str) {
                        if (str[0][str[0].length - 1] == '&') {
                            str = str[0].substring(10, str[0].length - 1);
                        } else {
                            str = str[0].substring(10);
                        }
                        var split = str.split(".");
                        var object = split[0];
                        var method = split[1];
                        window[object][method] = null;
                    }
                    observer.disconnect();
                }
            }
        } catch (e){}
    });

    var config = {
        attributes: true,
        childList: true,
        characterData: true
    };
    observer.observe(target, config);
  </script>
</body>
</html>
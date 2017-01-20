/* --------------------------------------
 * GOOGLE MAPS API
 * --------------------------------------
 */

/* Callback MAP API
 ----------------------------------- */
initMap = function () {
    try {
        var idMap = document.getElementById('map');
        if (!idMap) {
            return;
        }
        map = new google.maps.Map(idMap, {
            center: MapLatLong,
            zoom: 15,
            mapTypeId: 'roadmap'
        });
        google.maps.event.addListenerOnce(map, 'idle', function () {
            try {
                jQuery(idMap).removeClass('map-preload');
            } catch (err) {
            }
        });

        /**
         * Check Marker Container
         */
        if (typeof MarkerContainer != 'string'
            || MarkerContainer.replace(/\s*/, '') == ''
        ) {
            return;
        }
        var infowindow = new google.maps.InfoWindow({
            content: MarkerContainer
        });
        var marker = new google.maps.Marker({
            position: MapLatLong,
            map: map,
            title: 'Almira Trans Wisata'
        });
        marker.addListener('click', function () {
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
            } catch (err) {
            }
        });
    } catch (err) {
    }
}

if (typeof MapLatLong == 'object'
    && MapLatLong.hasOwnProperty('lat')
    && MapLatLong.hasOwnProperty('lng')
) {
    /**
     * Google MAP
     */
    window.addEventListener('load', function () {

        var script = document.createElement('script');
        script.src = '//maps.googleapis.com/maps/api/js?callback=initMap';
        document.body.appendChild(script);
        /* hack Google Maps to bypass API v3 key
         * needed since 22 June 2016
         * (http://googlegeodevelopers.blogspot.com.es/2016/06/building-for-scale-updates-to-google.html)
         */
        (new MutationObserver(function (mutations) {
            try {
                for (var i = 0; mutations[i]; ++i) {
                    // notify when script to hack is added in HTML head
                    if (mutations[i].addedNodes[0].nodeName == "SCRIPT"
                        && mutations[i].addedNodes[0].src.match(/\/AuthenticationService.Authenticate?/g)
                    ) {
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
                        this.disconnect();
                    }
                }
            } catch (e) {
            }
        })).observe(
            document.head,
            {
                attributes: true,
                childList: true,
                characterData: true
            }
        );
    });
}

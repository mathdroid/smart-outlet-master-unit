var map = L.map('map', {
      maxZoom: 4,
      minZoom: 1,
      crs: L.CRS.Simple
    }).setView([0, 0], 2);

    // dimensions of the image
    var w = 1080,
        h = 855,
        imageUrl = 'img/Smiley_13.jpg';
    var outlet1 = L.marker([-21.5, 59.39]).addTo(map);
    outlet1.bindPopup("<b>Outlet 1</b><br/> Hyun Tae's Room").openPopup();

    var outlet2 = L.marker([-31.5, 93.09]).addTo(map);
    outlet2.bindPopup("<b>Outlet 2</b><br/> Andi's Room").openPopup();

    var outlet3 = L.marker([-31.5, 59.39]).addTo(map);
    outlet3.bindPopup("<b>Outlet 3</b><br/> EXO's Room").openPopup();

    var southWest = map.unproject([0, h], map.getMaxZoom()-1);
    var northEast = map.unproject([w, 0], map.getMaxZoom()-1);
    var bounds = new L.LatLngBounds(southWest, northEast);

    L.imageOverlay(imageUrl, bounds).addTo(map);

    // tell leaflet that the map is exactly as big as the image
    map.setMaxBounds(bounds);
    

    var dataPoints = [
    [-60, 50],
    [-20, 100],
    [-30, 31],
    [-40, 28],
    [-61, 51],
    [-20, 100],
    [-34, 30],
    [-40, 28],    
    [-62, 52],
    [-20, 100],
    [-32, 32],
    [-40, 28],    
    ];
**Deprecated message**:
```
As of February 21st, 2024, google.maps.Marker is deprecated. Please use google.maps.marker.AdvancedMarkerElement instead. At this time, google.maps.Marker is not scheduled to be discontinued, but google.maps.marker.AdvancedMarkerElement is recommended over google.maps.Marker. While google.maps.Marker will continue to receive bug fixes for any major regressions, existing bugs in google.maps.Marker will not be addressed. At least 12 months notice will be given before support is discontinued. Please see https://developers.google.com/maps/deprecations for additional details and
```

**Status**: Still works as of Sep 2025

**Looks like**:
![[Pasted image 20250901005007.png]]

**Requirement**: Get a Google Map API key at Google Cloud Console

**Code**:
- Add your Google Map API key at `<script async defer src="https://maps.googleapis.com/maps/api/js?key=XXX&callback=initMap"></script>`
- Note that the JS code injects into a div with id `map`
```
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Southern California Service Area Map</title>
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }
    #map {
      height: 100%;
      width: 100%;
    }
    .text-block {
      position: absolute;
      top: 16px;
      left: 50%;
      transform: translateX(-50%);
      background: white;
      padding: 10px 14px;
      border-radius: 14px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.15);
      font: 500 14px system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
      max-width: min(92vw, 720px);
      line-height: 1.4;
      pointer-events: none;
      text-align: center;
    }
    .page {
      position: relative;
      height: 100%;
      width: 100%;
    }
  </style>
</head>
<body>
  <div class="page">
    <div id="map"></div>
    <div class="text-block">
      Service Area coverage for Southern California. The shaded rectangle indicates our operating region; pins mark key cities.
    </div>
  </div>
  <script>
    function initMap() {
      const map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 34.0522, lng: -118.2437 },
        zoom: 7,
        mapTypeId: "roadmap",
        streetViewControl: false,
        mapTypeControl: false,
        fullscreenControl: false,
        styles: [
          { "featureType": "all", "elementType": "geometry.fill", "stylers": [{ "saturation": -20 }, { "lightness": 10 }] },
          { "featureType": "water", "elementType": "geometry", "stylers": [{ "color": "#2D7A79" }] }
        ]
      });
      const socalBounds = { north: 35.5, south: 32.45, west: -121.0, east: -114.0 };
      new google.maps.Rectangle({
        bounds: socalBounds,
        strokeColor: "#F4741E",
        strokeOpacity: 0.9,
        strokeWeight: 2,
        fillColor: "#F4741E",
        fillOpacity: 0.08,
        clickable: false,
        geodesic: true,
        map,
      });
      map.fitBounds(socalBounds);
      const cities = [
        { pos: { lat: 34.0522, lng: -118.2437 }, label: "Los Angeles" },
        { pos: { lat: 33.7701, lng: -118.1937 }, label: "Long Beach" },
        { pos: { lat: 33.8366, lng: -117.9143 }, label: "Anaheim" },
        { pos: { lat: 32.7157, lng: -117.1611 }, label: "San Diego" },
        { pos: { lat: 34.2746, lng: -119.2290 }, label: "Ventura" },
        { pos: { lat: 34.4208, lng: -119.6982 }, label: "Santa Barbara" },
        { pos: { lat: 33.9806, lng: -117.3755 }, label: "Riverside" },
        { pos: { lat: 34.1083, lng: -117.2898 }, label: "San Bernardino" },
        { pos: { lat: 32.8370, lng: -115.5719 }, label: "El Centro" },
      ];
      cities.forEach(c => new google.maps.Marker({ position: c.pos, map, title: c.label }));
      const legend = document.createElement("div");
      legend.style.background = "white";
      legend.style.borderRadius = "14px";
      legend.style.padding = "8px 12px";
      legend.style.boxShadow = "0 2px 10px rgba(0,0,0,0.15)";
      legend.style.font = "500 14px system-ui, -apple-system, Segoe UI, Roboto, sans-serif";
      legend.textContent = "Service Area — Entire Southern California";
      map.controls[google.maps.ControlPosition.TOP_LEFT].push(legend);
    }
  </script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=XXX&callback=initMap"></script>
</body>
</html>
```
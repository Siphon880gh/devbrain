**Deprecated message**:
```
As of February 21st, 2024, google.maps.Marker is deprecated. Please use google.maps.marker.AdvancedMarkerElement instead. At this time, google.maps.Marker is not scheduled to be discontinued, but google.maps.marker.AdvancedMarkerElement is recommended over google.maps.Marker. While google.maps.Marker will continue to receive bug fixes for any major regressions, existing bugs in google.maps.Marker will not be addressed. At least 12 months notice will be given before support is discontinued. Please see https://developers.google.com/maps/deprecations for additional details and
```

**Status**: Still works as of Sep 2025

**Looks like**:
![[Pasted image 20250901004918.png]]

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
    
    // Google Maps initialization
    function initMap() {
      // Center on LA with cleaner map
      const map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 34.0522, lng: -118.2437 },
        zoom: 8,
        mapTypeId: "roadmap",
        streetViewControl: false,
        mapTypeControl: false,
        fullscreenControl: false,
        gestureHandling: "cooperative",
        zoomControl: true,
        scaleControl: false,
        rotateControl: false,
        styles: [
          {
            "featureType": "all",
            "elementType": "geometry.fill",
            "stylers": [{ "saturation": -20 }, { "lightness": 10 }]
          },
          {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [{ "color": "#2D7A79" }]
          },
          {
            "featureType": "poi",
            "elementType": "labels",
            "stylers": [{ "visibility": "off" }]
          }
        ]
      });

      // Create a circular service area overlay centered on LA
      const serviceAreaCircle = new google.maps.Circle({
        strokeColor: "#F4741E",
        strokeOpacity: 0.9,
        strokeWeight: 3,
        fillColor: "#F4741E",
        fillOpacity: 0.25,
        map: map,
        center: { lat: 34.0522, lng: -118.2437 },
        radius: 200000, // 200km radius (covers most of SoCal)
        clickable: false,
        geodesic: true
      });

      // Add a single marker for LA headquarters
      const headquartersMarker = new google.maps.Marker({
        position: { lat: 34.0522, lng: -118.2437 },
        map: map,
        title: "Video Production Studios - Los Angeles",
        icon: {
          path: google.maps.SymbolPath.CIRCLE,
          fillColor: "#F4741E",
          fillOpacity: 1,
          strokeColor: "#FFFFFF",
          strokeWeight: 2,
          scale: 8
        }
      });

      // Simple legend badge
      const legend = document.createElement("div");
      legend.style.background = "rgba(255, 255, 255, 0.95)";
      legend.style.borderRadius = "12px";
      legend.style.padding = "8px 12px";
      legend.style.boxShadow = "0 2px 10px rgba(0,0,0,0.15)";
      legend.style.font = "500 14px Inter, system-ui, sans-serif";
      legend.style.color = "#333";
      legend.textContent = "Service Area — 200km from Los Angeles";
      map.controls[google.maps.ControlPosition.BOTTOM_LEFT].push(legend);
    }
  </script>
  <!-- Important: load with 'libraries=marker' to enable AdvancedMarkerElement -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=XXX&callback=initMap&libraries=marker"></script>
</body>
</html>

```
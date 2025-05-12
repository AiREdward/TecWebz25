document.addEventListener('DOMContentLoaded', function() {
    const lat = 45.41123820134286;
    const lng = 11.887567492273224;
    const map = L.map('map-container').setView([lat, lng], 19);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);
    
    const marker = L.marker([lat, lng]).addTo(map);
    marker.bindPopup("GameStart").openPopup();
});


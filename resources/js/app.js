import 'bootstrap/dist/js/bootstrap.bundle.min.js';

const init = () => {
    const map = new ymaps.Map("map", {
        center: [55.7522, 37.6156],
        zoom: 13
    });

    let placemark;
    map.events.add('click', (e) => {
        const coords = e.get('coords');

        document.getElementById('coords').value = coords[0] + ',' + coords[1];
        ymaps.geocode(coords).then((res) => {
            const firstGeoObject = res.geoObjects.get(0);
            const address = firstGeoObject.getAddressLine();
            console.log(address)
            $wire.dispatchSelf('updateAddress', {address});
        })
        if (placemark) {
            placemark.geometry.setCoordinates(coords);
        } else {
            placemark = new ymaps.Placemark(coords, {}, {
                preset: 'islands#redIcon'
            });
            map.geoObjects.add(placemark);
        }
    });
}

ymaps.ready(init);

function init() {
    let map = new ymaps.Map('yandex-map', {
        center: [57.991711137883534,56.207295924606306],
        zoom: 16
    });

    let placemark = new ymaps.Placemark([57.991711137883534,56.207295924606306], {}, {
        iconLayout: 'default#image',
        iconImageHref: './../img/index_html/marker-gps.svg',
        iconImageSize: [50, 50],
        iconImageOffset: [-35, -50]
    });

    map.controls.remove('geolocationControl');
    map.controls.remove(' searchControl'); // удаляем поиск
    map.controls.remove('trafficControl'); // удаляем контроль трафика
    map.controls.remove('typeSelector'); // удаляем тип
    map.controls.remove('fullscreenControl'); // удаляем кнопку перехода в полноэкранный режим
    map.controls.remove( 'zoomControl'); // удаляем контрол зуммирования
    map.controls.remove('rulerControl'); // удаляем контрол правил
    //map.behaviors.disable(['scrollZoom']); // отключаем скролл карты (опционально)

    map.geoObjects.add(placemark);
}
ymaps.ready(init);
function closeThanks(){
    document.querySelector('.full_thanks').classList.toggle('active');
}
function clodeWarning() {
    document.querySelector('.full_warning').classList.toggle('active');
    document.querySelector('.popup_warning').classList.toggle('active');
}
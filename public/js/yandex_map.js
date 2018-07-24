ymaps.ready(function () {
    var myMap = new ymaps.Map('map', {
            center: [55.751574, 37.573856],
            zoom: 9
        }, {
            searchControlProvider: 'yandex#search'
        }),

        // Создаём макет содержимого.
        MyIconContentLayout = ymaps.templateLayoutFactory.createClass(
            '<div style="color: #FFFFFF; font-weight: bold;">$[properties.iconContent]</div>'
        ),

        myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
            hintContent: 'Собственный значок метки',
            balloonContent: 'Это красивая метка'
        });

    myPlacemark2 = new ymaps.Placemark([55.76, 37.64], {
        // Хинт показывается при наведении мышкой на иконку метки.
        hintContent: 'Содержимое всплывающей подсказки',
        // Балун откроется при клике по метке.
        balloonContent: 'Содержимое балуна'
    });

    myPlacemark.events.add('click', function () {
        alert('О, событие!');
    });
    myMap.geoObjects
        .add(myPlacemark)
        .add(myPlacemark2);
});

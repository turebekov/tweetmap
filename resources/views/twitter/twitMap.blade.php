@extends('index')

@section('content')

    <div style="height: 700px;border: 1px solid #e3e3e3;">
        <div id="map"></div>
    </div>


    <script>
        var info = [];
        $(document).ready(function () {

            $.ajax({
                type: "GET",
                url: '/twits',
                success: function (res) {
                    // Вывод текста результата отправки
                        info = res.twits;
                        console.log(res.twits);
                        yandexMap(res.twits);
                },
                error: function (jqXHR, text, error) {
                    // Вывод текста ошибки отправки
                    console.log(error);
                }
            });
        });
        var twitPlacemark = [];
        function yandexMap(data) {
            ymaps.ready(function () {
                var myMap = new ymaps.Map('map', {
                        center: [51.147537, 71.395202],
                        zoom: 9
                    }, {
                        searchControlProvider: 'yandex#search'
                    }),

                    // Создаём макет содержимого.
                    MyIconContentLayout = ymaps.templateLayoutFactory.createClass(
                        '<div style="color: #FFFFFF; font-weight: bold;">$[properties.iconContent]</div>'
                    );


                data.forEach(function (data,index) {
                    if (data.geo != null) {
                        console.log(data);
                        twitPlacemark[index] = new ymaps.Placemark([data.geo.coordinates[0], data.geo.coordinates[1]], {
                            // Хинт показывается при наведении мышкой на иконку метки.
                            hintContent: 'Содержимое всплывающей подсказки',
                            // Балун откроется при клике по метке.

                            balloonContent: data.text+'<br><button onclick="addMapinfo('+index+')" ">Добавить в базу</button>',

                        });
                    }

                });

                twitPlacemark.forEach(function (map) {
                    myMap.geoObjects.add(map);
                })

            });
        }

        function addMapinfo(data) {
           console.log(data);
           info.forEach(function (info,index) {
               if (data == index){

                   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                   console.log(CSRF_TOKEN);
                   $.ajax({
                       url: '/saveTweet',
                       type: "POST",
                       data: {_token:CSRF_TOKEN,data:info},
                       dataType: 'JSON',
                       success: function (res) {
                           // Вывод текста результата отправки
                           console.log(res);
                           alert(res.message)
                       },
                       error: function (jqXHR, text, error) {
                           // Вывод текста ошибки отправки
                           console.log(error);
                       }
                   });
               }
           })
       }
    </script>
@endsection
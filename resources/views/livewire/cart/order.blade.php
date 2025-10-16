<div class="container py-4">
    <div>
        <h1 class="mb-4 text-dark-emphasis border-bottom pb-2">Отправка заказа</h1>
    </div>

    <div>
        <h3 class="mt-4 mb-4">Итоговая сумма: {{ $total }} руб.</h3>

        <button class="btn btn-outline-success">Заказать</button>
    </div>

    <div>
        @foreach($items as $product)
            <div>
                {{ $product->name }} {{ $product->price }} руб.
            </div>
        @endforeach
    </div>

    <div id="map" class="my-4" style="height: 400px; width: 600px;"></div>
</div>

<!-- Загрузка API Яндекс.Карт -->
<script src="https://api-maps.yandex.ru/v3/?apikey=f156e2f8-9507-4e0f-aa54-ed054e50cc7a&lang=ru_RU"></script>
<!-- Инициализация карты в отдельном теге script -->
<script>    async function initMap() {
        // Ожидание загрузки модуля ymaps3
        await ymaps3.ready;

        const {YMap, YMapDefaultSchemeLayer} = ymaps3;

        // Инициализация карты
        const map = new YMap(
            document.getElementById('map'),
            {
                location: {
                    center: [37.588144, 55.733842],
                    zoom: 10
                }
            }
        );

        // Добавление слоя схемы карты
        map.addChild(new YMapDefaultSchemeLayer());
    }

    // Вызов функции инициализации
    initMap();
</script>

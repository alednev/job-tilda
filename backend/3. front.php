<?php

/**
 * На страницу контактов заходят люди из разных городов, нужно чтобы они видели телефон из своего города.
 * По умолчанию, в HTML-страницы прописан телефон 8-800-DIGITS. Телефон размещен в верху и внизу страницы.
 *
 * Непонятно когда маркетолог вернётся, может быть только через месяц ;)
 */

$defaultCountry = 'RU';
$defaultCity    = 'Moscow';

// выясняем IP-адрес пользователя
$ip = $_SERVER['REMOTE_ADDR']; // если мы где-то за прокси (CDN) то при согласовании с админом нужно использовать HTTP_X_FORWARDED_FOR

// тут можно будет погуглить если не знаем в каких городах работает компания )
// названия городов должны совпадать с тем, что приходит от гео-определителя, для скорости разработки положим их тут,
// но вообще их надо хранить в БД и доставать оттуда
$cities = [
    'moscow'       => '8-800-DIGITS',
    'speterburg'   => '8-800-SPBDIGITS',
    'novosibirsk'  => '8-800-NVSDIGITS',
    'ekaterinburg' => '8-800-EKTDIGITS',
];

/**
 * GeoIP
 *
 * тут варианты:
 * 1. nginx сам определяет через lua скрипт по IP страну и город посетителя и передаёт их в скрипт
 * 2. php определяет через GeoIP2 (тут нужен composer и будет дополнительная задержка на curl запрос к сервису,
 * но судя по stackoverflow можно и бесплатную базу выкачать)
 *
 * на выходе мы имеем и страну и город
 */
$reader = new stdClass(); // new Reader(path_to/GeoIP2-City.mmdb)
$record = $reader->city($ip);

if ($record->country->isoCode !== $defaultCountry
    || $record->city->name === null
    || !array_key_exists($record->city->name, $cities)) {
    $city = $defaultCity;
}

// прокидываем на верстку телефон, и не важно сколько раз он встречается на странице
$phone = $cities[$record->city->name];

// однако, правильно, имхо, будет если мы уточним у пользователя, правильно ли мы его определили, потому что гео-
// опредитель не всегда корректно это делает, и поэтому надо передать на верстку еще и сам $city = $record->city->name
// и общий список городов в $cities
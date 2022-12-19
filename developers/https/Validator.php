<?php

class Validator
{
    public static function domain($value)
    {
        $value = trim(str_replace(['https://', 'http://'], '', $value));

        // честно свиснул из интернета
        $pattern = '/(?!-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}/';
        $result  = preg_match($pattern, $value, $matches);

        if (!$result) {
            return false;
        }

        return $matches[0];
    }

    public static function uploadFile($name, $config)
    {
        $errors = [];

        if ($_FILES[$name]['error'] > 0) {
            $errors[$name] = 'Есть проблема с загрузкой файла: ';

            switch ($_FILES[$name]['error']) {
                case 1:
                    $errors[$name] .= 'файл превышает максимальный размер загрузки на сервер. Обратитесь к разработчикам';
                    break;
                case 2:
                    $errors[$name] .= 'файл больше положенного максимального размера в ' . $config['uploadMaxFilesize'] . ' килобайт';
                    break;
                case 3:
                    $errors[$name] .= 'файл частично загружен';
                    break;
                case 4:
                    $errors[$name] .= 'не выбран файл для загрузки';
                    break;
            }
        }
        // дополнительная проверка на mime type
//        } elseif (!in_array($_FILES[$name]['type'], $config[$name]['mimeType'])) {
//            $errors[$name] = 'выбран не файл сертификата';
//        }

        if (empty($errors)) {
            return true;
        }

        return $errors[$name];
    }
}

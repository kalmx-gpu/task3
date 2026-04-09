<?php


function utf8_strlen($string) {
    if (function_exists('iconv_strlen')) {
        return iconv_strlen($string, 'UTF-8');
    }
    // Запасной вариант через регулярное выражение
    return preg_match_all('/./u', $string, $matches);
}

/**
 * Проверяет ФИО
 */
function validateFullName($value) {
    $value = trim($value);
    if ($value === '') {
        return 'Поле ФИО обязательно для заполнения.';
    }
    if (utf8_strlen($value) > 150) {
        return 'ФИО не должно превышать 150 символов.';
    }
    if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $value)) {
        return 'ФИО должно содержать только буквы, пробелы и дефис.';
    }
    return null;
}

/**
 * Проверяет телефон
 */
function validatePhone($value) {
    $value = trim($value);
    if ($value === '') {
        return 'Поле Телефон обязательно.';
    }
    $digits = preg_replace('/\D/', '', $value);
    if (strlen($digits) != 11) {
        return 'Телефон должен содержать 11 цифр (например, +7XXXXXXXXXX).';
    }
    if ($digits[0] != '7' && $digits[0] != '8') {
        return 'Номер должен начинаться с +7 или 8.';
    }
    return null;
}

/**
 * Проверяет email
 */
function validateEmail($value) {
    $value = trim($value);
    if ($value === '') {
        return 'Поле E-mail обязательно.';
    }
    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return 'Некорректный формат E-mail.';
    }
    return null;
}

/**
 * Проверяет дату рождения
 */
function validateBirthDate($value) {
    if (empty($value)) {
        return 'Дата рождения обязательна.';
    }
    $date = DateTime::createFromFormat('Y-m-d', $value);
    if (!$date || $date->format('Y-m-d') !== $value) {
        return 'Некорректная дата.';
    }
    $now = new DateTime();
    if ($date > $now) {
        return 'Дата рождения не может быть в будущем.';
    }
    // Дополнительно: проверка на адекватный возраст 
    $minDate = (new DateTime())->sub(new DateInterval('P100Y'));
    if ($date < $minDate) {
        return 'Пожалуйста, укажите реальную дату рождения.';
    }
    return null;
}

/**
 * Проверяет пол
 */
function validateGender($value) {
    if (!in_array($value, ['male', 'female'])) {
        return 'Выберите пол.';
    }
    return null;
}

/**
 * Проверяет выбранные языки программирования
 */
function validateLanguages($values) {
    if (!is_array($values) || count($values) == 0) {
        return 'Выберите хотя бы один язык программирования.';
    }
    $allowed = [
        'Pascal', 'C', 'C++', 'JavaScript', 'PHP',
        'Python', 'Java', 'Haskell', 'Clojure', 'Prolog',
        'Scala', 'Go'
    ];
    foreach ($values as $lang) {
        if (!in_array($lang, $allowed)) {
            return 'Выбран недопустимый язык программирования.';
        }
    }
    return null;
}

/**
 * Проверяет биографию
 */
function validateBio($value) {
    $value = trim($value);
    if ($value === '') {
        return 'Поле Биография обязательно.';
    }
    if (utf8_strlen($value) > 5000) {
        return 'Биография слишком длинная (максимум 5000 символов).';
    }
    return null;
}

/**
 * Проверяет чекбокс согласия с контрактом
 */
function validateContract($value) {
    if ($value != '1') {
        return 'Необходимо подтвердить ознакомление с контрактом.';
    }
    return null;
}

/**
 * Основная функция валидации всех полей.
 * Возвращает массив с ошибками (ключ - имя поля).
 */
function validateAllFields($data) {
    $errors = [];
    
    $errors['full_name']    = validateFullName($data['full_name'] ?? '');
    $errors['phone']        = validatePhone($data['phone'] ?? '');
    $errors['email']        = validateEmail($data['email'] ?? '');
    $errors['birth_date']   = validateBirthDate($data['birth_date'] ?? '');
    $errors['gender']       = validateGender($data['gender'] ?? '');
    $errors['languages']    = validateLanguages($data['languages'] ?? []);
    $errors['bio']          = validateBio($data['bio'] ?? '');
    $errors['contract']     = validateContract($data['contract_agreed'] ?? '');
    
    // Убираем поля без ошибок (null)
    return array_filter($errors, function($error) {
        return $error !== null;
    });
}
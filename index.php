<?php
header('Content-Type: text/html; charset=UTF-8');

// Подключаем нужные модули
require_once 'validators.php';
require_once 'save.php';

// Инициализируем переменные для формы
$values = [];
$errors = [];
$success = false;

// Если запрос POST – обрабатываем данные
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Сохраняем введённые значения для повторного отображения
    $values = $_POST;
    
    // Валидируем все поля
    $errors = validateAllFields($_POST);
    
    if (empty($errors)) {
        // Ошибок нет, пробуем сохранить в БД
        try {
            $id = saveApplication($_POST);
            $success = true;
            // Очищаем значения, чтобы форма показывалась пустой после успеха
            $values = [];
        } catch (Exception $e) {
            // Логируем реальную ошибку (можно в файл), а пользователю показываем общее сообщение
            error_log('Ошибка сохранения: ' . $e->getMessage());
            $errors['db'] = 'Произошла ошибка при сохранении данных. Попробуйте позже.';
        }
    }
}

// Если запрос GET, или после POST нужно показать форму
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Анкета</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php if ($success): ?>
        <div class="form-container">
            <h2>Данные успешно сохранены!</h2>
            <div class="success-message">Спасибо за заполнение анкеты.</div>
            <a href="/" style="display: block; text-align: center; margin-top: 20px; color: #3498db;">Вернуться к форме</a>
        </div>
    <?php else: ?>
        <?php include 'form.php'; ?>
    <?php endif; ?>
</body>
</html>
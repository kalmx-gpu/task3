<?php
header('Content-Type: text/html; charset=UTF-8');

require_once 'validators.php';
require_once 'save.php';

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
            $values = [];
        } catch (Exception $e) {
            error_log('Ошибка сохранения: ' . $e->getMessage());
            $errors['db'] = 'Произошла ошибка при сохранении данных. Попробуйте позже.';
        }
    }
}

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
            <h2>Работу выполнил Царенов Олег ПИ22/2</h2>
            <h2>Данные успешно сохранены!</h2>
            <div class="success-message">Спасибо за заполнение анкеты.</div>
            <a href="/task3/" style="display: block; text-align: center; margin-top: 20px; color: #3498db;">Вернуться к форме</a>
        </div>
    <?php else: ?>
        <?php include 'form.php'; ?>
    <?php endif; ?>
</body>
</html>
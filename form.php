<?php
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Анкета</title>
    <link rel="stylesheet" href="/task3/style.css">
</head>
<body>
    <div class="form-container">
        <h2>Заполните анкету</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="error-container">
                <?php foreach ($errors as $field => $message): ?>
                    <div class="error-message"><?= htmlspecialchars($message) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form action="" method="POST">
            <!-- ФИО -->
            <div class="form-group">
                <label class="required" for="full_name">ФИО</label>
                <input type="text" name="full_name" id="full_name" 
                       value="<?= htmlspecialchars($values['full_name'] ?? '') ?>"
                       maxlength="150" required>
                <small>Только буквы и пробелы, не более 150 символов</small>
            </div>

            <!-- Телефон -->
            <div class="form-group">
                <label class="required" for="phone">Телефон</label>
                <input type="tel" name="phone" id="phone" 
                       value="<?= htmlspecialchars($values['phone'] ?? '') ?>"
                       placeholder="+7XXXXXXXXXX" required>
                <small>В формате +7XXXXXXXXXX или 8XXXXXXXXXX</small>
            </div>

            <!-- E-mail -->
            <div class="form-group">
                <label class="required" for="email">E-mail</label>
                <input type="email" name="email" id="email" 
                       value="<?= htmlspecialchars($values['email'] ?? '') ?>" required>
            </div>

            <!-- Дата рождения -->
            <div class="form-group">
                <label class="required" for="birth_date">Дата рождения</label>
                <input type="date" name="birth_date" id="birth_date" 
                       value="<?= htmlspecialchars($values['birth_date'] ?? '') ?>" required>
            </div>

            <!-- Пол -->
            <div class="form-group">
                <label class="required">Пол</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="gender" value="male" 
                               <?= (isset($values['gender']) && $values['gender'] == 'male') ? 'checked' : '' ?> required>
                        Мужской
                    </label>
                    <label>
                        <input type="radio" name="gender" value="female" 
                               <?= (isset($values['gender']) && $values['gender'] == 'female') ? 'checked' : '' ?> required>
                        Женский
                    </label>
                </div>
            </div>

            <!-- Любимые языки программирования -->
            <div class="form-group">
                <label class="required" for="languages">Любимые языки программирования</label>
                <select name="languages[]" id="languages" multiple required>
                    <?php
                    $all_languages = [
                        'Pascal', 'C', 'C++', 'JavaScript', 'PHP',
                        'Python', 'Java', 'Haskell', 'Clojure', 'Prolog',
                        'Scala', 'Go'
                    ];
                    $selected_langs = $values['languages'] ?? [];
                    foreach ($all_languages as $lang) {
                        $selected = in_array($lang, $selected_langs) ? 'selected' : '';
                        echo "<option value=\"" . htmlspecialchars($lang) . "\" $selected>" 
                             . htmlspecialchars($lang) . "</option>";
                    }
                    ?>
                </select>
                <small>Удерживайте Ctrl (Cmd) для выбора нескольких</small>
            </div>

            <!-- Биография -->
            <div class="form-group">
                <label class="required" for="bio">Биография</label>
                <textarea name="bio" id="bio" rows="5" required><?= 
                    htmlspecialchars($values['bio'] ?? '') 
                ?></textarea>
            </div>

            <!-- Чекбокс контракта -->
            <div class="form-group checkbox-group">
                <input type="checkbox" name="contract_agreed" id="contract" value="1" 
                       <?= isset($values['contract_agreed']) ? 'checked' : '' ?> required>
                <label for="contract" class="required">С контрактом ознакомлен(а)</label>
            </div>

            <button type="submit">Сохранить</button>
        </form>
    </div>
</body>
</html>
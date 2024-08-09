<?php

/** @var yii\web\View $this */

//var_dump(Yii::$app->user->identity->id);

$this->title = 'Connection';
?>

<button type="button" class="btn btn-primary position-relative mt-5">
  <h5>Результат проверки Вашего Токена: </h5><h5 id="message"></h5>
</button>




<script>
    const connection = new WebSocket('ws://127.0.0.2:8080');

    connection.onopen = () => {
    // Получаем токен пользователя
    const token = '<?= (Yii::$app->user->isGuest) ? "unknown token" : Yii::$app->user->identity->access_token; ?>';
    const user_id = '<?= (Yii::$app->user->isGuest) ? "unknown user" : Yii::$app->user->identity->id; ?>';
    const user_agent = '<?= $_SERVER['HTTP_USER_AGENT'] ?>';
    
    console.log('WebSocket check token', token);
    // Отправляем токен на сервер для проверки
    connection.send(JSON.stringify({ token: token, user_id: user_id, user_agent: user_agent}));
};

    connection.onerror = (error) => {
        console.error('WebSocket error:', error);
    };

    connection.onclose = () => {
        console.log('WebSocket connection closed');
        document.getElementById('message').innerText = 'Доступ запрещён';
    };

    connection.onmessage = (message) => {
        const data = JSON.parse(message.data);
        console.log(data);
        document.getElementById('message').innerText = 'Доступ разрешён';
    };
</script>
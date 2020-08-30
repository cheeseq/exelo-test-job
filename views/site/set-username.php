<?php
/* @var yii\web\View $this */
$this->title = 'Set username';
?>

<form method="post">
    <input type="hidden" name="<?=\Yii::$app->request->csrfParam?>" value="<?=\Yii::$app->request->getCsrfToken()?>">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="chat_username" id="username" required>
    </div>
    <input type="submit" value="Enter chat" class="btn btn-primary">
</form>
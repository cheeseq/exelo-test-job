<?php
/* @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Чат';
/* @var \app\models\ChatMessage[] $messages */
?>
<div class="col-sm-12">
    <h3 class="text-center">Уютный Чатик</h3>
    <div class="messaging">
        <div class="inbox_msg">
            <div class="mesgs">
                <div class="msg_history">
                    <?php foreach ($messages as $message): ?>
                        <?php if($message->username == \Yii::$app->session->get("chat_username")): ?>
                            <div class="outgoing_msg">
                                <div class="sent_msg">
                                    <p><?=Html::encode($message->message)?></p>
                                    <span class="time_date">From: <?=Html::encode($message->username)?> | <?=\Yii::$app->formatter->asDatetime($message->created_at)?> </span>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="incoming_msg">
                                <div class="received_msg">
                                    <div class="received_withd_msg">
                                        <p><?=Html::encode($message->message)?></p>
                                        <span class="time_date">From: <?=Html::encode($message->username)?> | <?=\Yii::$app->formatter->asDatetime($message->created_at)?> </span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class="type_msg">
                    <div class="input_msg_write">
                        <form id="send_msg_form">
                            <input type="hidden" value="<?=Html::encode(\Yii::$app->session->get("chat_username"))?>" id="send_chat_username"/>
                            <input type="text" class="write_msg" placeholder="Type a message"/>
                            <button class="msg_send_btn" type="submit"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cursor-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103z"/>
                                </svg></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

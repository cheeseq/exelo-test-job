<?php


namespace app\models;


use app\models\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class ChatMessage extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%chat}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'message'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

}
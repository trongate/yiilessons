<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property integer $id
 * @property string $title
 * @property string $message
 * @property string $image
 * @property integer $timestamp
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'message'], 'required'],
            [['message'], 'string'],
            [['title'], 'string', 'max' => 255],
            ['title', 'validateText'],
            [['image'], 'required', 'on' => 'update-image'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'message' => 'Message',
            'image' => 'Image',
            'timestamp' => 'Timestamp',
        ];
    }


    public function beforeSave($insert)
    {
        $this->timestamp = time();
        return parent::beforeSave($insert);
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['update-image'] = ['image'];
        return $scenarios;
    }

    public function validateText($attribute, $params)
    {
        if (!preg_match("/^[a-zA-Z ]*$/", $this->$attribute)) {
            $this->addError($attribute, "Only letters and white spaces are allowed");
        }
    }
}

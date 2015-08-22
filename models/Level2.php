<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "level2".
 *
 * @property integer $id
 * @property string $rus_phrase
 * @property string $eng_phrase
 * @property integer $appeared
 * @property integer $wrong
 */
class Level2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'level2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rus_phrase', 'eng_phrase'], 'required'],
            [['appeared', 'wrong'], 'integer'],
            [['rus_phrase', 'eng_phrase'], 'string', 'max' => 255],
            [['rus_phrase'], 'unique'],
            [['eng_phrase'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rus_phrase' => 'Rus Phrase',
            'eng_phrase' => 'Eng Phrase',
            'appeared' => 'Appeared',
            'wrong' => 'Wrong',
        ];
    }
}

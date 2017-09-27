<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\query\SettingsQuery;

/**
 * This is the model class for table "{{%settings}}".
 *
 * @property string $key
 * @property string $data
 */
class Settings extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['data'], 'string'],
            [['key'], 'string', 'max' => 25],
            [['key'], 'unique'],
            ['key', 'match', 'pattern' => '/^[a-zA-Z0-9.-]+$/', 'message' => Yii::t(
                'app',
                'Key can only contain alphanumeric characters, point and dashes.'
            )],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'key' => Yii::t('app', 'Key'),
            'data' => Yii::t('app', 'Data'),
        ];
    }

    public static function getKey($key, $default)
    {
        $value = self::find($key)->one();

        if(!empty($value)) {
            return $value->data;
        }

        return $default;
    }

    /**
     * @inheritdoc
     * @return \app\models\query\SettingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SettingsQuery(get_called_class());
    }
}

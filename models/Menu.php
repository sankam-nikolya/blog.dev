<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\query\MenuQuery;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property int $id
 * @property string $title
 * @property int $type
 * @property string $route
 * @property string $url
 * @property int $status
 */
class Menu extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status'], 'integer'],
            [['type', 'title'], 'required'],
            [['title', 'route', 'url'], 'string', 'max' => 255],
            ['route', 'required',
                'when' => function($model) use ($field, $value) {
                    return $model->type === 0;
                },
                'whenClient' => "function(attribute,value){var require=!1;$.each(\$form.data('yiiActiveForm').attributes,function(){if(this.name=='type'){require=this.value=='0';return!1}});return require}"
            ],
            ['url', 'required',
                'when' => function($model) use ($field, $value) {
                    return $model->type === 1;
                },
                'whenClient' => "function(attribute,value){var require=!1;$.each(\$form.data('yiiActiveForm').attributes,function(){if(this.name=='type'){require=this.value=='1';return!1}});return require}"
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'type' => Yii::t('app', 'Type'),
            'route' => Yii::t('app', 'Route'),
            'url' => Yii::t('app', 'Url'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\query\MenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }
}

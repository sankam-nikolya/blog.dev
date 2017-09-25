<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\query\UsersQuery;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string $user_name
 * @property string $name
 * @property string $email
 * @property int $status
 *
 * @property Articles[] $articles
 * @property Comments[] $comments
 */
class Users extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_name', 'email'], 'required'],
            [['status'], 'integer'],
            [['user_name'], 'string', 'max' => 30],
            [['name', 'email'], 'string', 'max' => 50],
            [['user_name'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_name' => Yii::t('app', 'User Name'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Articles::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['created_by' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
}

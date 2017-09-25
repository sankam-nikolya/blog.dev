<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\query\ArticlesQuery;

/**
 * This is the model class for table "{{%articles}}".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $intro
 * @property string $description
 * @property int $created_by
 * @property int $created_at
 * @property int $updated_at
 * @property int $published_at
 * @property int $status
 *
 * @property Users $createdBy
 * @property ArticlesCategories[] $articlesCategories
 * @property Categories[] $categories
 * @property Comments[] $comments
 */
class Articles extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%articles}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'intro', 'description'], 'required'],
            [['intro', 'description'], 'string'],
            [['created_by', 'created_at', 'updated_at', 'published_at', 'status'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'id']],
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
            'slug' => Yii::t('app', 'Slug'),
            'intro' => Yii::t('app', 'Intro'),
            'description' => Yii::t('app', 'Description'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'published_at' => Yii::t('app', 'Published At'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['id' => 'category_id'])
            ->viaTable(Categories::junctionTableName(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['article_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\ArticlesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticlesQuery(get_called_class());
    }
}
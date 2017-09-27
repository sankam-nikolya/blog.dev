<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use app\models\query\ArticlesQuery;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use components\behaviors\UploadImageBehavior;

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

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className()
            ],
            'author' => [
                'class' => BlameableBehavior::className(),
                'updatedByAttribute' => false
            ],
            'saveRelations' => [
                'class'     => SaveRelationsBehavior::className(),
                'relations' => ['categories']
            ],
            'uploads' => [
                'class' => UploadImageBehavior::className(),
                'attribute' => 'image',
                'placeholder' => '@webroot/images/no-image.png',
                'path' => '@webroot/upload/images',
                'url' => '@web/upload/images',
                'thumbPath' => '@webroot/upload/images/thumb',
                'thumbUrl' => '@web/upload/images/thumb',
                'thumbs' => [
                    'thumb' => ['width' => 400, 'quality' => 90],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'intro', 'description', 'categories'], 'required'],
            [['intro', 'description'], 'string'],
            [['published_at'], 'default', 'value' => function () {
                return date('Y-m-d');
            }],
            [['published_at'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['created_by', 'created_at', 'updated_at', 'published_at', 'status'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'id']],
            ['image', 'image', 'extensions' => 'jpg, jpeg, png'],
            ['categories', 'safe']
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
            'image' => Yii::t('app', 'Image'),
            'categories' => Yii::t('app', 'Categories'),
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

    public static function getArticleCategories($model)
    {
        return ArrayHelper::map($model->categories, 'id', 'title');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['article_id' => 'id']);
    }

    public static function getCategoriesList()
    {
        return ArrayHelper::map(Categories::find()->all(), 'id', 'title');
    }

    public static function getUsersList()
    {
        return ArrayHelper::map(Users::find()->all(), 'id', 'username');
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

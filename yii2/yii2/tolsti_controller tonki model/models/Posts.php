<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "posts".
 *
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $autor_id
 * @property string $create_date
 * @property string $update_date
 * @property string $category_id
 */
class Posts extends \yii\db\ActiveRecord
{
    protected $duplicate_entry;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'autor_id'], 'required'],
            [['description'], 'string'],
            [['autor_id', 'category_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['title'], 'string', 'max' => 255],
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
            'description' => Yii::t('app', 'Description'),
            'autor_id' => Yii::t('app', 'Autor ID'),
            'create_date' => Yii::t('app', 'Create Date'),
            'update_date' => Yii::t('app', 'Update Date'),
            'category_id' => Yii::t('app', 'Category'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        return ArrayHelper::map(Categories::find()->all(), 'id', 'name');
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if ($this->isNewRecord) {
                $this->autor_id = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getDuplicateEntry()
    {
        return $this->duplicate_entry;
    }

    /**
     * @return mixed
     */
    public function setDuplicateEntry($val)
    {
        $this->duplicate_entry = $val;
    }
}

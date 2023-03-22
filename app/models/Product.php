<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $photo
 * @property string $photoFile
 * @property string $name
 * @property string $price
 * @property int $category_id
 *
 * @property Product $category
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['photo', 'name', 'price', 'category_id'], 'required'],
            [['category_id'], 'integer'],
            [['photo', 'name', 'price'], 'string', 'max' => 255],
            [['photoFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер',
            'photo' => 'Фото',
            'photoFile' => 'Файл фото',
            'name' => 'Название',
            'price' => 'Цена',
            'category_id' => 'Категория',
        ];
    }

    public function upload()
    {
        $this->photo = 'uploads/' . $this->photoFile->baseName . '.' . $this->photoFile->extension;
        if ($this->validate()) {
            $this->photoFile->saveAs($this->photo);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
}

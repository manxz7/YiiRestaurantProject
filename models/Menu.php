<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "menus".
 *
 * @property int $id
 * @property string $name
 * @property string|null $ingredients
 * @property float $price
 * @property string|null $image
 * @property string $category
 * @property int $is_available
 * @property int $created_at
 * @property int $updated_at
 */
class Menu extends \yii\db\ActiveRecord
{
    /** @var UploadedFile|null */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menus';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ingredients', 'image'], 'default', 'value' => null],
            [['is_available'], 'default', 'value' => 1],
            [['name', 'price', 'category'], 'required'],
            [['ingredients'], 'string'],
            [['price'], 'number', 'min' => 0],
            [['is_available'], 'boolean'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'jpeg', 'webp'], 'maxSize' => 2 * 1024 * 1024],
            [['category'], 'in', 'range' => array_keys(self::categoryOptions())],
            [['name', 'image', 'category'], 'string', 'max' => 255],
        ];
    }

    /**
     * Menu category choices.
     *
     * @return array<string, string>
     */
    public static function categoryOptions()
    {
        return [
            'starters' => 'Starters',
            'breakfast' => 'Breakfast',
            'lunch' => 'Lunch',
            'dinner' => 'Dinner',
        ];
    }

    /**
     * Resolve the image URL for the frontend/admin views.
     *
     * @return string
     */
    public function getImageUrl()
    {
        if (empty($this->image)) {
            return Url::to('@web/yummy-red/img/menu/menu-item-1.png');
        }

        if (preg_match('/^https?:\/\//i', $this->image) === 1) {
            return $this->image;
        }

        return Url::to('@web/yummy-red/img/menu/' . ltrim($this->image, '/'));
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'ingredients' => 'Ingredients',
            'price' => 'Price',
            'image' => 'Image',
            'category' => 'Category',
            'is_available' => 'Is Available',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}

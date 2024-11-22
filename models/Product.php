<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Product".
 *
 * @property int $id
 * @property string $name
 * @property string $french_name
 * @property int $GTIN
 * @property string $description
 * @property string $french_description
 * @property string $brand
 * @property string $country
 * @property float $weight
 * @property float $unit_weight
 * @property float $gross_weight
 * 
 * @property int $company_id
 * @property bool $is_hidden
 * 
 */
class Product extends \yii\db\ActiveRecord
{

    public $file;
    public $file_name;
    public $gtin_arr;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'french_name', 'GTIN', 'description', 'french_description', 'brand', 'country', 'weight', 'unit_weight', 'company_id', 'gross_weight'], 'required'],
            [['company_id', 'is_hidden'], 'integer'],
            [['description', 'french_description'], 'string'],
            [['weight', 'gross_weight'], 'number'],
            ['GTIN', 'string', 'max' => 14, 'min' => 13],
            ['unit_weight', 'string', 'min' => 1, 'max' => 3],
            [['name', 'french_name', 'brand', 'country'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
            ['file', 'file', 'maxSize' => 100 * 1024 * 1024, 'extensions' => 'png, jpeg, jpg'],
            ['gtin_arr', 'safe']

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'french_name' => 'French Name',
            'GTIN' => 'Gtin',
            'description' => 'Description',
            'french_description' => 'French Description',
            'brand' => 'Brand',
            'country' => 'Country',
            'weight' => 'Weight',
            'unit_weight' => 'Unit Weight',
            'file_id' => 'File',
            'company_id' => 'Company ID',
        ];
    }

    public function upload()
    {
        $pathFile =
            Yii::$app->security->generateRandomString(15)
            . '.'
            . $this->file->extension;

        if ($this->validate()) {

            if ($this->file->saveAs('src/' . $pathFile)) {
                return $pathFile;
            }
        } else {
            return false;
        }
    }

    public static function checkGTIN($arr)
    {

        // var_dump($arr);die;
        $query =  self::find()
            ->select('GTIN')
            ->filterWhere(['GTIN' => $arr])
            ->asArray()
            ->all()
            ;
            // var_dump($query->createCommand()->getRawSql());
            return $query;
    }
}

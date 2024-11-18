<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $company_name
 * @property string $company_address
 * @property string $company_telephone_number
 * @property string $company_email_address
 * @property int $owner_id
 * @property int $isActivate
 *
 * @property Owner $owner
 * @property Product[] $products
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_name', 'company_address', 'company_telephone_number', 'company_email_address', 'owner_id', 'isActivate'], 'required'],
            [['owner_id', 'isActivate'], 'integer'],
            [['company_name', 'company_address', 'company_telephone_number', 'company_email_address'], 'string', 'max' => 255],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Owner::class, 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'company_address' => 'Company Address',
            'company_telephone_number' => 'Company Telephone Number',
            'company_email_address' => 'Company Email Address',
            'owner_id' => 'Owner ID',
            'isActivate' => 'Is Activate',
        ];
    }

    /**
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(Owner::class, ['id' => 'owner_id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['company_id' => 'id']);
    }
}

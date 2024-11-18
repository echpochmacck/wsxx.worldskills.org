<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "owner".
 *
 * @property int $id
 * @property string $name
 * @property string $mobile_number
 * @property string $email_address
 * @property int $conctact_id
 *
 * @property Company[] $companies
 * @property Contacts $conctact
 */
class Owner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'owner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'mobile_number', 'email_address', 'conctact_id'], 'required'],
            [['conctact_id'], 'integer'],
            [['name', 'mobile_number', 'email_address'], 'string', 'max' => 255],
            [['conctact_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contacts::class, 'targetAttribute' => ['conctact_id' => 'id']],
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
            'mobile_number' => 'Mobile Number',
            'email_address' => 'Email Address',
            'conctact_id' => 'Conctact ID',
        ];
    }

    /**
     * Gets query for [[Companies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::class, ['owner_id' => 'id']);
    }

    /**
     * Gets query for [[Conctact]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConctact()
    {
        return $this->hasOne(Contacts::class, ['id' => 'conctact_id']);
    }
}

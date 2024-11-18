<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contacts".
 *
 * @property int $id
 * @property string $name
 * @property string $mobile_number
 * @property string $email_address
 *
 * @property Owner[] $owners
 */
class Contacts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'mobile_number', 'email_address'], 'required'],
            [['name', 'mobile_number', 'email_address'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * Gets query for [[Owners]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwners()
    {
        return $this->hasMany(Owner::class, ['conctact_id' => 'id']);
    }
}

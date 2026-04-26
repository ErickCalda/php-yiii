<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ubicaciones".
 *
 * @property int $id
 * @property string $edificio
 * @property string|null $bloque
 * @property string|null $piso
 * @property string|null $aula
 * @property string|null $referencia
 * @property string|null $fecha_creacion
 *
 * @property Laboratorios[] $laboratorios
 */
class Ubicaciones extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ubicaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloque', 'piso', 'aula', 'referencia'], 'default', 'value' => null],
            [['edificio'], 'required'],
            [['fecha_creacion'], 'safe'],
            [['edificio'], 'string', 'max' => 100],
            [['bloque', 'aula'], 'string', 'max' => 50],
            [['piso'], 'string', 'max' => 20],
            [['referencia'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'edificio' => Yii::t('app', 'Edificio'),
            'bloque' => Yii::t('app', 'Bloque'),
            'piso' => Yii::t('app', 'Piso'),
            'aula' => Yii::t('app', 'Aula'),
            'referencia' => Yii::t('app', 'Referencia'),
            'fecha_creacion' => Yii::t('app', 'Fecha Creacion'),
        ];
    }

    /**
     * Gets query for [[Laboratorios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLaboratorios()
    {
        return $this->hasMany(Laboratorios::class, ['ubicacion_id' => 'id']);
    }

}

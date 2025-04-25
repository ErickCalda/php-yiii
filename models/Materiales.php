<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "materiales".
 *
 * @property int $id
 * @property string $nombre
 * @property string $unidad_medida
 * @property float $cantidad
 * @property int $laboratorio_id
 *
 * @property EntradasMateriales[] $entradasMateriales
 * @property Laboratorios $laboratorio
 */
class Materiales extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'materiales';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cantidad'], 'default', 'value' => 0.00],
            [['nombre', 'unidad_medida', 'laboratorio_id'], 'required'],
            [['cantidad'], 'number'],
            [['laboratorio_id'], 'integer'],
            [['nombre'], 'string', 'max' => 150],
            [['unidad_medida'], 'string', 'max' => 50],
            [['laboratorio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Laboratorios::class, 'targetAttribute' => ['laboratorio_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'unidad_medida' => Yii::t('app', 'Unidad Medida'),
            'cantidad' => Yii::t('app', 'Cantidad'),
            'laboratorio_id' => Yii::t('app', 'Laboratorio ID'),
        ];
    }

    /**
     * Gets query for [[EntradasMateriales]].
     *
     * @return \yii\db\ActiveQuery|EntradasMaterialesQuery
     */
    public function getEntradasMateriales()
    {
        return $this->hasMany(EntradasMateriales::class, ['material_id' => 'id']);
    }

    /**
     * Gets query for [[Laboratorio]].
     *
     * @return \yii\db\ActiveQuery|LaboratoriosQuery
     */
    public function getLaboratorio()
    {
        return $this->hasOne(Laboratorios::class, ['id' => 'laboratorio_id']);
    }

    /**
     * {@inheritdoc}
     * @return MaterialesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MaterialesQuery(get_called_class());
    }

}

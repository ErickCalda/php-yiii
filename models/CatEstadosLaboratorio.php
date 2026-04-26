<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_estados_laboratorio".
 *
 * @property int $id
 * @property string $codigo
 * @property string $nombre
 * @property string|null $descripcion
 * @property string|null $color
 * @property int|null $activo
 * @property string|null $fecha_creacion
 * @property string|null $fecha_actualizacion
 *
 * @property Laboratorios[] $laboratorios
 */
class CatEstadosLaboratorio extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cat_estados_laboratorio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'color'], 'default', 'value' => null],
            [['activo'], 'default', 'value' => 1],
            [['codigo', 'nombre'], 'required'],
            [['activo'], 'integer'],
            [['fecha_creacion', 'fecha_actualizacion'], 'safe'],
            [['codigo'], 'string', 'max' => 30],
            [['nombre'], 'string', 'max' => 80],
            [['descripcion'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 20],
            [['codigo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codigo' => Yii::t('app', 'Codigo'),
            'nombre' => Yii::t('app', 'Nombre'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'color' => Yii::t('app', 'Color'),
            'activo' => Yii::t('app', 'Activo'),
            'fecha_creacion' => Yii::t('app', 'Fecha Creacion'),
            'fecha_actualizacion' => Yii::t('app', 'Fecha Actualizacion'),
        ];
    }

    /**
     * Gets query for [[Laboratorios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLaboratorios()
    {
        return $this->hasMany(Laboratorios::class, ['estado_id' => 'id']);
    }

}

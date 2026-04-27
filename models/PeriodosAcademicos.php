<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "periodos_academicos".
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $fecha_inicio
 * @property string|null $fecha_fin
 * @property int|null $activo
 *
 * @property ClasesProgramadas[] $clasesProgramadas
 */
class PeriodosAcademicos extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'periodos_academicos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_inicio', 'fecha_fin'], 'default', 'value' => null],
            [['activo'], 'default', 'value' => 1],
            [['nombre'], 'required'],
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            [['activo'], 'integer'],
            [['nombre'], 'string', 'max' => 30],
            [['nombre'], 'unique'],
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
            'fecha_inicio' => Yii::t('app', 'Fecha Inicio'),
            'fecha_fin' => Yii::t('app', 'Fecha Fin'),
            'activo' => Yii::t('app', 'Activo'),
        ];
    }

    /**
     * Gets query for [[ClasesProgramadas]].
     *
     * @return \yii\db\ActiveQuery|ClasesProgramadasQuery
     */
    public function getClasesProgramadas()
    {
        return $this->hasMany(ClasesProgramadas::class, ['periodo_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PeriodosAcademicosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PeriodosAcademicosQuery(get_called_class());
    }

}

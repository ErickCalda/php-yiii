<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_tipos_evento".
 *
 * @property int $id
 * @property string $codigo
 * @property string $nombre
 * @property string|null $descripcion
 * @property int|null $es_critico
 * @property int|null $activo
 * @property string|null $fecha_creacion
 * @property string|null $fecha_actualizacion
 *
 * @property Bitacoras[] $bitacoras
 */
class CatTiposEvento extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cat_tipos_evento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'default', 'value' => null],
            [['es_critico'], 'default', 'value' => 0],
            [['activo'], 'default', 'value' => 1],
            [['codigo', 'nombre'], 'required'],
            [['es_critico', 'activo'], 'integer'],
            [['fecha_creacion', 'fecha_actualizacion'], 'safe'],
            [['codigo'], 'string', 'max' => 50],
            [['nombre'], 'string', 'max' => 100],
            [['descripcion'], 'string', 'max' => 255],
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
            'es_critico' => Yii::t('app', 'Es Critico'),
            'activo' => Yii::t('app', 'Activo'),
            'fecha_creacion' => Yii::t('app', 'Fecha Creacion'),
            'fecha_actualizacion' => Yii::t('app', 'Fecha Actualizacion'),
        ];
    }

    /**
     * Gets query for [[Bitacoras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBitacoras()
    {
        return $this->hasMany(Bitacoras::class, ['tipo_evento_id' => 'id']);
    }

}

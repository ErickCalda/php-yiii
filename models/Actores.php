<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actores".
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $fecha_nacimiento
 * @property string|null $nacionalidad
 *
 * @property Peliculas[] $peliculas
 * @property Reparto[] $repartos
 */
class Actores extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_nacimiento', 'nacionalidad'], 'default', 'value' => null],
            [['nombre'], 'required'],
            [['fecha_nacimiento'], 'string'],
            [['nombre'], 'string', 'max' => 255],
            [['nacionalidad'], 'string', 'max' => 100],
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
            'fecha_nacimiento' => Yii::t('app', 'Fecha Nacimiento'),
            'nacionalidad' => Yii::t('app', 'Nacionalidad'),
        ];
    }

    /**
     * Gets query for [[Peliculas]].
     *
     * @return \yii\db\ActiveQuery|PeliculasQuery
     */
    public function getPeliculas()
    {
        return $this->hasMany(Peliculas::class, ['id' => 'pelicula_id'])->viaTable('reparto', ['actor_id' => 'id']);
    }

    /**
     * Gets query for [[Repartos]].
     *
     * @return \yii\db\ActiveQuery|RepartoQuery
     */
    public function getRepartos()
    {
        return $this->hasMany(Reparto::class, ['actor_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ActoresQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActoresQuery(get_called_class());
    }

}

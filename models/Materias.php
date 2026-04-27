<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "materias".
 *
 * @property int $id
 * @property string $codigo
 * @property string $nombre
 *
 * @property ClasesProgramadas[] $clasesProgramadas
 */
class Materias extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'materias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo', 'nombre'], 'required'],
            [['codigo'], 'string', 'max' => 20],
            [['nombre'], 'string', 'max' => 120],
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
        ];
    }

    /**
     * Gets query for [[ClasesProgramadas]].
     *
     * @return \yii\db\ActiveQuery|ClasesProgramadasQuery
     */
    public function getClasesProgramadas()
    {
        return $this->hasMany(ClasesProgramadas::class, ['materia_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return MateriasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MateriasQuery(get_called_class());
    }

}

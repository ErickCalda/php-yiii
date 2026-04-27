<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cursos".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property ClasesProgramadas[] $clasesProgramadas
 */
class Cursos extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cursos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
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
        ];
    }

    /**
     * Gets query for [[ClasesProgramadas]].
     *
     * @return \yii\db\ActiveQuery|ClasesProgramadasQuery
     */
    public function getClasesProgramadas()
    {
        return $this->hasMany(ClasesProgramadas::class, ['curso_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CursosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CursosQuery(get_called_class());
    }

}

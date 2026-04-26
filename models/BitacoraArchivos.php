<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bitacora_archivos".
 *
 * @property int $id
 * @property int $bitacora_id
 * @property string $nombre_archivo
 * @property string $ruta
 * @property string|null $tipo_mime
 * @property int|null $tamano
 * @property string|null $fecha_subida
 *
 * @property Bitacoras $bitacora
 */
class BitacoraArchivos extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bitacora_archivos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_mime', 'tamano'], 'default', 'value' => null],
            [['bitacora_id', 'nombre_archivo', 'ruta'], 'required'],
            [['bitacora_id', 'tamano'], 'integer'],
            [['fecha_subida'], 'safe'],
            [['nombre_archivo', 'ruta'], 'string', 'max' => 255],
            [['tipo_mime'], 'string', 'max' => 100],
            [['bitacora_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bitacoras::class, 'targetAttribute' => ['bitacora_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'bitacora_id' => Yii::t('app', 'Bitacora ID'),
            'nombre_archivo' => Yii::t('app', 'Nombre Archivo'),
            'ruta' => Yii::t('app', 'Ruta'),
            'tipo_mime' => Yii::t('app', 'Tipo Mime'),
            'tamano' => Yii::t('app', 'Tamano'),
            'fecha_subida' => Yii::t('app', 'Fecha Subida'),
        ];
    }

    /**
     * Gets query for [[Bitacora]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBitacora()
    {
        return $this->hasOne(Bitacoras::class, ['id' => 'bitacora_id']);
    }

}

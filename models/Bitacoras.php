<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "bitacoras".
 *
 * @property int $id
 * @property int $reserva_id
 * @property string $descripcion
 * @property string|null $archivo_adjunto
 * @property string|null $fecha_registro
 *
 * @property Reservas $reserva
 */
class Bitacoras extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bitacoras';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['archivo_adjunto'], 'default', 'value' => null],
            [['reserva_id', 'descripcion'], 'required'],
            [['reserva_id'], 'integer'],
            [['descripcion'], 'string'],
            [['fecha_registro'], 'safe'],
            [['archivo_adjunto'], 'string', 'max' => 255],
            [['reserva_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reservas::class, 'targetAttribute' => ['reserva_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'reserva_id' => Yii::t('app', 'Reserva ID'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'archivo_adjunto' => Yii::t('app', 'Archivo Adjunto'),
            'fecha_registro' => Yii::t('app', 'Fecha Registro'),
        ];
    }

    /**
     * Gets query for [[Reserva]].
     *
     * @return \yii\db\ActiveQuery|ReservasQuery
     */
    public function getReserva()
    {
        return $this->hasOne(Reservas::class, ['id' => 'reserva_id']);
    }

    /**
     * {@inheritdoc}
     * @return BitacorasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BitacorasQuery(get_called_class());
    }

    /**
     * Automatically sets fecha_registro when creating or updating a record
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            // Si es un nuevo registro, asignar fecha de creación
            $this->fecha_registro = date('Y-m-d H:i:s');
        } else {
            // Si no es nuevo, actualizar fecha de última actualización
            $this->fecha_registro = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }
}

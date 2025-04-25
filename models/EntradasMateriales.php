<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "entradas_materiales".
 *
 * @property int $id
 * @property int $material_id
 * @property string $fecha_ingreso
 * @property float $cantidad
 * @property string $tipo_entrada
 * @property string|null $proveedor
 * @property int|null $usuario_id
 * @property string|null $observaciones
 * @property string|null $creado_en
 *
 * @property Materiales $material
 * @property Usuarios $usuario
 */
class EntradasMateriales extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const TIPO_ENTRADA_COMPRA = 'compra';
    const TIPO_ENTRADA_DONACION = 'donacion';
    const TIPO_ENTRADA_OTRO = 'otro';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'entradas_materiales';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proveedor', 'usuario_id', 'observaciones'], 'default', 'value' => null],
            [['material_id', 'fecha_ingreso', 'cantidad', 'tipo_entrada'], 'required'],
            [['material_id', 'usuario_id'], 'integer'],
            [['fecha_ingreso', 'creado_en'], 'safe'],
            [['cantidad'], 'number'],
            [['tipo_entrada', 'observaciones'], 'string'],
            [['proveedor'], 'string', 'max' => 150],
            ['tipo_entrada', 'in', 'range' => array_keys(self::optsTipoEntrada())],
            [['material_id'], 'exist', 'skipOnError' => true, 'targetClass' => Materiales::class, 'targetAttribute' => ['material_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'material_id' => Yii::t('app', 'Material ID'),
            'fecha_ingreso' => Yii::t('app', 'Fecha Ingreso'),
            'cantidad' => Yii::t('app', 'Cantidad'),
            'tipo_entrada' => Yii::t('app', 'Tipo Entrada'),
            'proveedor' => Yii::t('app', 'Proveedor'),
            'usuario_id' => Yii::t('app', 'Usuario ID'),
            'observaciones' => Yii::t('app', 'Observaciones'),
            'creado_en' => Yii::t('app', 'Creado En'),
        ];
    }

    /**
     * Gets query for [[Material]].
     *
     * @return \yii\db\ActiveQuery|MaterialesQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Materiales::class, ['id' => 'material_id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery|UsuariosQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id']);
    }

    /**
     * {@inheritdoc}
     * @return EntradasMaterialesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EntradasMaterialesQuery(get_called_class());
    }


    /**
     * column tipo_entrada ENUM value labels
     * @return string[]
     */
    public static function optsTipoEntrada()
    {
        return [
            self::TIPO_ENTRADA_COMPRA => Yii::t('app', 'compra'),
            self::TIPO_ENTRADA_DONACION => Yii::t('app', 'donacion'),
            self::TIPO_ENTRADA_OTRO => Yii::t('app', 'otro'),
        ];
    }

    /**
     * @return string
     */
    public function displayTipoEntrada()
    {
        return self::optsTipoEntrada()[$this->tipo_entrada];
    }

    /**
     * @return bool
     */
    public function isTipoEntradaCompra()
    {
        return $this->tipo_entrada === self::TIPO_ENTRADA_COMPRA;
    }

    public function setTipoEntradaToCompra()
    {
        $this->tipo_entrada = self::TIPO_ENTRADA_COMPRA;
    }

    /**
     * @return bool
     */
    public function isTipoEntradaDonacion()
    {
        return $this->tipo_entrada === self::TIPO_ENTRADA_DONACION;
    }

    public function setTipoEntradaToDonacion()
    {
        $this->tipo_entrada = self::TIPO_ENTRADA_DONACION;
    }

    /**
     * @return bool
     */
    public function isTipoEntradaOtro()
    {
        return $this->tipo_entrada === self::TIPO_ENTRADA_OTRO;
    }

    public function setTipoEntradaToOtro()
    {
        $this->tipo_entrada = self::TIPO_ENTRADA_OTRO;
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clases_programadas".
 *
 * @property int $id
 * @property int $laboratorio_id
 * @property int $docente_id
 * @property int $materia_id
 * @property int $curso_id
 * @property int $periodo_id
 * @property string $dia_semana
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property int|null $estado
 *
 * @property Bitacoras[] $bitacoras
 * @property Cursos $cursos
 * @property Laboratorios $laboratorios
 * @property Materias $materias
 * @property PeriodosAcademicos $periodosAcademicos
 * @property Usuarios $usuarios
 */
class ClasesProgramadas extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const DIA_SEMANA_LUNES = 'lunes';
    const DIA_SEMANA_MARTES = 'martes';
    const DIA_SEMANA_MIERCOLES = 'miercoles';
    const DIA_SEMANA_JUEVES = 'jueves';
    const DIA_SEMANA_VIERNES = 'viernes';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clases_programadas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado'], 'default', 'value' => 1],
            [['laboratorio_id', 'docente_id', 'materia_id', 'curso_id', 'periodo_id', 'dia_semana', 'hora_inicio', 'hora_fin'], 'required'],
            [['laboratorio_id', 'docente_id', 'materia_id', 'curso_id', 'periodo_id', 'estado'], 'integer'],
            [['dia_semana'], 'string'],
            [['hora_inicio', 'hora_fin'], 'safe'],
            ['dia_semana', 'in', 'range' => array_keys(self::optsDiaSemana())],
            [['laboratorio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Laboratorios::class, 'targetAttribute' => ['laboratorio_id' => 'id']],
            [['docente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['docente_id' => 'id']],
            [['materia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Materias::class, 'targetAttribute' => ['materia_id' => 'id']],
            [['curso_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cursos::class, 'targetAttribute' => ['curso_id' => 'id']],
            [['periodo_id'], 'exist', 'skipOnError' => true, 'targetClass' => PeriodosAcademicos::class, 'targetAttribute' => ['periodo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'laboratorio_id' => Yii::t('app', 'Laboratorio ID'),
            'docente_id' => Yii::t('app', 'Docente ID'),
            'materia_id' => Yii::t('app', 'Materia ID'),
            'curso_id' => Yii::t('app', 'Curso ID'),
            'periodo_id' => Yii::t('app', 'Periodo ID'),
            'dia_semana' => Yii::t('app', 'Dia Semana'),
            'hora_inicio' => Yii::t('app', 'Hora Inicio'),
            'hora_fin' => Yii::t('app', 'Hora Fin'),
            'estado' => Yii::t('app', 'Estado'),
        ];
    }

    /**
     * Gets query for [[Bitacoras]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getBitacoras()
    {
        return $this->hasMany(Bitacoras::class, ['clase_programada_id' => 'id']);
    }

    /**
     * Gets query for [[Cursos]].
     *
     * @return \yii\db\ActiveQuery|CursosQuery
     */
    public function getCursos()
    {
        return $this->hasOne(Cursos::class, ['id' => 'curso_id']);
    }

    /**
     * Gets query for [[Laboratorios]].
     *
     * @return \yii\db\ActiveQuery|LaboratoriosQuery
     */
    public function getLaboratorios()
    {
        return $this->hasOne(Laboratorios::class, ['id' => 'laboratorio_id']);
    }

    /**
     * Gets query for [[Materias]].
     *
     * @return \yii\db\ActiveQuery|MateriasQuery
     */
    public function getMaterias()
    {
        return $this->hasOne(Materias::class, ['id' => 'materia_id']);
    }

    /**
     * Gets query for [[PeriodosAcademicos]].
     *
     * @return \yii\db\ActiveQuery|PeriodosAcademicosQuery
     */
    public function getPeriodosAcademicos()
    {
        return $this->hasOne(PeriodosAcademicos::class, ['id' => 'periodo_id']);
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'docente_id']);
    }

    /**
     * {@inheritdoc}
     * @return ClasesProgramadasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClasesProgramadasQuery(get_called_class());
    }


    /**
     * column dia_semana ENUM value labels
     * @return string[]
     */
    public static function optsDiaSemana()
    {
        return [
            self::DIA_SEMANA_LUNES => Yii::t('app', 'lunes'),
            self::DIA_SEMANA_MARTES => Yii::t('app', 'martes'),
            self::DIA_SEMANA_MIERCOLES => Yii::t('app', 'miercoles'),
            self::DIA_SEMANA_JUEVES => Yii::t('app', 'jueves'),
            self::DIA_SEMANA_VIERNES => Yii::t('app', 'viernes'),
        ];
    }

    /**
     * @return string
     */
    public function displayDiaSemana()
    {
        return self::optsDiaSemana()[$this->dia_semana];
    }

    /**
     * @return bool
     */
    public function isDiaSemanaLunes()
    {
        return $this->dia_semana === self::DIA_SEMANA_LUNES;
    }

    public function setDiaSemanaToLunes()
    {
        $this->dia_semana = self::DIA_SEMANA_LUNES;
    }

    /**
     * @return bool
     */
    public function isDiaSemanaMartes()
    {
        return $this->dia_semana === self::DIA_SEMANA_MARTES;
    }

    public function setDiaSemanaToMartes()
    {
        $this->dia_semana = self::DIA_SEMANA_MARTES;
    }

    /**
     * @return bool
     */
    public function isDiaSemanaMiercoles()
    {
        return $this->dia_semana === self::DIA_SEMANA_MIERCOLES;
    }

    public function setDiaSemanaToMiercoles()
    {
        $this->dia_semana = self::DIA_SEMANA_MIERCOLES;
    }

    /**
     * @return bool
     */
    public function isDiaSemanaJueves()
    {
        return $this->dia_semana === self::DIA_SEMANA_JUEVES;
    }

    public function setDiaSemanaToJueves()
    {
        $this->dia_semana = self::DIA_SEMANA_JUEVES;
    }

    /**
     * @return bool
     */
    public function isDiaSemanaViernes()
    {
        return $this->dia_semana === self::DIA_SEMANA_VIERNES;
    }

    public function setDiaSemanaToViernes()
    {
        $this->dia_semana = self::DIA_SEMANA_VIERNES;
    }


    public function getLaboratorio()
{
    return $this->hasOne(Laboratorios::class, ['id' => 'laboratorio_id']);
}

public function getMateria()
{
    return $this->hasOne(Materias::class, ['id' => 'materia_id']);
}

public function getCurso()
{
    return $this->hasOne(Cursos::class, ['id' => 'curso_id']);
}

    public function puedeGestionar()
{
    $usuario = Yii::$app->user->identity;

    // Admin puede siempre
    if ($usuario->rol_id == Usuarios::ROL_ADMIN) {
        return true;
    }

    // Solo el creador
    if ($this->docente_id != $usuario->id) {
        return false;
    }

    // Máximo 10 minutos
    $creado = strtotime($this->created_at);

    return (time() - $creado) <= 600;
}





public function puedeEditar()
{
    $usuario = Yii::$app->user->identity;

    // Admin siempre puede
    if ($usuario->rol_id == \app\models\Usuarios::ROL_ADMIN) {
        return true;
    }

    // Solo el dueño de la reserva
    if ($this->docente_id != $usuario->id) {
        return false;
    }

    $creado = strtotime($this->created_at);
    $ahora  = time();

    // 10 minutos = 600 segundos
    return ($ahora - $creado) <= 600;
}



}

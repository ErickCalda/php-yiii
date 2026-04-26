<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Laboratorios]].
 *
 * @see Laboratorios
 */
class LaboratoriosQuery extends ActiveQuery
{
    /**
     * Laboratorios activos
     */
    public function activos()
    {
        return $this->joinWith('estado')
            ->andWhere(['cat_estados_laboratorio.codigo' => 'ACTIVO']);
    }

    /**
     * Con relaciones principales
     */
    public function completos()
    {
        return $this->with([
            'tipo',
            'estado',
            'ubicacion',
        ]);
    }

    /**
     * Ordenados por nombre
     */
    public function ordenNombre()
    {
        return $this->orderBy(['nombre' => SORT_ASC]);
    }

    /**
     * Buscar por tipo
     */
    public function porTipo($tipoId)
    {
        return $this->andWhere(['tipo_id' => $tipoId]);
    }

    /**
     * Buscar por estado
     */
    public function porEstado($estadoId)
    {
        return $this->andWhere(['estado_id' => $estadoId]);
    }

    /**
     * Con capacidad mínima
     */
    public function capacidadMin($capacidad)
    {
        return $this->andWhere(['>=', 'capacidad', $capacidad]);
    }

    /**
     * Disponibles para reservas
     */
    public function disponibles()
    {
        return $this->joinWith('estado')
            ->andWhere([
                'cat_estados_laboratorio.codigo' => 'ACTIVO'
            ]);
    }

    /**
     * {@inheritdoc}
     * @return Laboratorios[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Laboratorios|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
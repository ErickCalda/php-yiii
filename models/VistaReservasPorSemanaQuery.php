<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[VistaReservasPorSemana]].
 *
 * @see VistaReservasPorSemana
 */
class VistaReservasPorSemanaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VistaReservasPorSemana[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VistaReservasPorSemana|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

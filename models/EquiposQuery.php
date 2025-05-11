<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Equipos]].
 *
 * @see Equipos
 */
class EquiposQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Equipos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Equipos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
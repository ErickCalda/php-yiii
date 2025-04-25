<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Reservas]].
 *
 * @see Reservas
 */
class ReservasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Reservas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Reservas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

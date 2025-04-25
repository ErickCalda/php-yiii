<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Laboratorios]].
 *
 * @see Laboratorios
 */
class LaboratoriosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

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

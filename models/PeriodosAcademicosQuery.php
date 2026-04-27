<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PeriodosAcademicos]].
 *
 * @see PeriodosAcademicos
 */
class PeriodosAcademicosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PeriodosAcademicos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PeriodosAcademicos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

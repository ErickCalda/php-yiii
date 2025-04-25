<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EntradasMateriales]].
 *
 * @see EntradasMateriales
 */
class EntradasMaterialesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EntradasMateriales[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EntradasMateriales|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

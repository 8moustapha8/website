<?php

use Base\Store as BaseStore;

/**
 * Skeleton subclass for representing a row from the 'store' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Store extends BaseStore
{

    public function getCategory() {
        if(is_null($this->getStoreCategory())) return "";

        return $this->getStoreCategory()->getName();
    }

}

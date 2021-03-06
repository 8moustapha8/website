<?php

namespace Map;

use \Insurance;
use \InsuranceQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'insurance' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class InsuranceTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.InsuranceTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'insurance';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Insurance';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Insurance';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the insurance_id field
     */
    const COL_INSURANCE_ID = 'insurance.insurance_id';

    /**
     * the column name for the credit_card_id field
     */
    const COL_CREDIT_CARD_ID = 'insurance.credit_card_id';

    /**
     * the column name for the insurance_type_id field
     */
    const COL_INSURANCE_TYPE_ID = 'insurance.insurance_type_id';

    /**
     * the column name for the guaranteed_period field
     */
    const COL_GUARANTEED_PERIOD = 'insurance.guaranteed_period';

    /**
     * the column name for the max_insured_amount field
     */
    const COL_MAX_INSURED_AMOUNT = 'insurance.max_insured_amount';

    /**
     * the column name for the value field
     */
    const COL_VALUE = 'insurance.value';

    /**
     * the column name for the update_time field
     */
    const COL_UPDATE_TIME = 'insurance.update_time';

    /**
     * the column name for the update_user field
     */
    const COL_UPDATE_USER = 'insurance.update_user';

    /**
     * the column name for the reference field
     */
    const COL_REFERENCE = 'insurance.reference';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('InsuranceId', 'CreditCardId', 'InsuranceTypeId', 'GuaranteedPeriod', 'MaxInsuredAmount', 'Value', 'UpdateTime', 'UpdateUser', 'Reference', ),
        self::TYPE_CAMELNAME     => array('insuranceId', 'creditCardId', 'insuranceTypeId', 'guaranteedPeriod', 'maxInsuredAmount', 'value', 'updateTime', 'updateUser', 'reference', ),
        self::TYPE_COLNAME       => array(InsuranceTableMap::COL_INSURANCE_ID, InsuranceTableMap::COL_CREDIT_CARD_ID, InsuranceTableMap::COL_INSURANCE_TYPE_ID, InsuranceTableMap::COL_GUARANTEED_PERIOD, InsuranceTableMap::COL_MAX_INSURED_AMOUNT, InsuranceTableMap::COL_VALUE, InsuranceTableMap::COL_UPDATE_TIME, InsuranceTableMap::COL_UPDATE_USER, InsuranceTableMap::COL_REFERENCE, ),
        self::TYPE_FIELDNAME     => array('insurance_id', 'credit_card_id', 'insurance_type_id', 'guaranteed_period', 'max_insured_amount', 'value', 'update_time', 'update_user', 'reference', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('InsuranceId' => 0, 'CreditCardId' => 1, 'InsuranceTypeId' => 2, 'GuaranteedPeriod' => 3, 'MaxInsuredAmount' => 4, 'Value' => 5, 'UpdateTime' => 6, 'UpdateUser' => 7, 'Reference' => 8, ),
        self::TYPE_CAMELNAME     => array('insuranceId' => 0, 'creditCardId' => 1, 'insuranceTypeId' => 2, 'guaranteedPeriod' => 3, 'maxInsuredAmount' => 4, 'value' => 5, 'updateTime' => 6, 'updateUser' => 7, 'reference' => 8, ),
        self::TYPE_COLNAME       => array(InsuranceTableMap::COL_INSURANCE_ID => 0, InsuranceTableMap::COL_CREDIT_CARD_ID => 1, InsuranceTableMap::COL_INSURANCE_TYPE_ID => 2, InsuranceTableMap::COL_GUARANTEED_PERIOD => 3, InsuranceTableMap::COL_MAX_INSURED_AMOUNT => 4, InsuranceTableMap::COL_VALUE => 5, InsuranceTableMap::COL_UPDATE_TIME => 6, InsuranceTableMap::COL_UPDATE_USER => 7, InsuranceTableMap::COL_REFERENCE => 8, ),
        self::TYPE_FIELDNAME     => array('insurance_id' => 0, 'credit_card_id' => 1, 'insurance_type_id' => 2, 'guaranteed_period' => 3, 'max_insured_amount' => 4, 'value' => 5, 'update_time' => 6, 'update_user' => 7, 'reference' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('insurance');
        $this->setPhpName('Insurance');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Insurance');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('insurance_id', 'InsuranceId', 'INTEGER', true, null, null);
        $this->addForeignKey('credit_card_id', 'CreditCardId', 'INTEGER', 'credit_card', 'credit_card_id', true, null, null);
        $this->addForeignKey('insurance_type_id', 'InsuranceTypeId', 'INTEGER', 'insurance_type', 'insurance_type_id', true, null, null);
        $this->addColumn('guaranteed_period', 'GuaranteedPeriod', 'INTEGER', false, null, null);
        $this->addColumn('max_insured_amount', 'MaxInsuredAmount', 'INTEGER', false, null, null);
        $this->addColumn('value', 'Value', 'INTEGER', false, null, null);
        $this->addColumn('update_time', 'UpdateTime', 'TIMESTAMP', true, null, null);
        $this->addColumn('update_user', 'UpdateUser', 'VARCHAR', true, 100, null);
        $this->addColumn('reference', 'Reference', 'VARCHAR', false, 255, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('CreditCard', '\\CreditCard', RelationMap::MANY_TO_ONE, array('credit_card_id' => 'credit_card_id', ), null, null);
        $this->addRelation('InsuranceType', '\\InsuranceType', RelationMap::MANY_TO_ONE, array('insurance_type_id' => 'insurance_type_id', ), null, null);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InsuranceId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InsuranceId', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('InsuranceId', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? InsuranceTableMap::CLASS_DEFAULT : InsuranceTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Insurance object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = InsuranceTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = InsuranceTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + InsuranceTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = InsuranceTableMap::OM_CLASS;
            /** @var Insurance $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            InsuranceTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = InsuranceTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = InsuranceTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Insurance $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                InsuranceTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(InsuranceTableMap::COL_INSURANCE_ID);
            $criteria->addSelectColumn(InsuranceTableMap::COL_CREDIT_CARD_ID);
            $criteria->addSelectColumn(InsuranceTableMap::COL_INSURANCE_TYPE_ID);
            $criteria->addSelectColumn(InsuranceTableMap::COL_GUARANTEED_PERIOD);
            $criteria->addSelectColumn(InsuranceTableMap::COL_MAX_INSURED_AMOUNT);
            $criteria->addSelectColumn(InsuranceTableMap::COL_VALUE);
            $criteria->addSelectColumn(InsuranceTableMap::COL_UPDATE_TIME);
            $criteria->addSelectColumn(InsuranceTableMap::COL_UPDATE_USER);
            $criteria->addSelectColumn(InsuranceTableMap::COL_REFERENCE);
        } else {
            $criteria->addSelectColumn($alias . '.insurance_id');
            $criteria->addSelectColumn($alias . '.credit_card_id');
            $criteria->addSelectColumn($alias . '.insurance_type_id');
            $criteria->addSelectColumn($alias . '.guaranteed_period');
            $criteria->addSelectColumn($alias . '.max_insured_amount');
            $criteria->addSelectColumn($alias . '.value');
            $criteria->addSelectColumn($alias . '.update_time');
            $criteria->addSelectColumn($alias . '.update_user');
            $criteria->addSelectColumn($alias . '.reference');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(InsuranceTableMap::DATABASE_NAME)->getTable(InsuranceTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(InsuranceTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(InsuranceTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new InsuranceTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Insurance or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Insurance object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InsuranceTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Insurance) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(InsuranceTableMap::DATABASE_NAME);
            $criteria->add(InsuranceTableMap::COL_INSURANCE_ID, (array) $values, Criteria::IN);
        }

        $query = InsuranceQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            InsuranceTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                InsuranceTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the insurance table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return InsuranceQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Insurance or Criteria object.
     *
     * @param mixed               $criteria Criteria or Insurance object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InsuranceTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Insurance object
        }

        if ($criteria->containsKey(InsuranceTableMap::COL_INSURANCE_ID) && $criteria->keyContainsValue(InsuranceTableMap::COL_INSURANCE_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.InsuranceTableMap::COL_INSURANCE_ID.')');
        }


        // Set the correct dbName
        $query = InsuranceQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // InsuranceTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
InsuranceTableMap::buildTableMap();

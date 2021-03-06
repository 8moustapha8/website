<?php

namespace Base;

use \City as ChildCity;
use \CityQuery as ChildCityQuery;
use \Trip as ChildTrip;
use \TripQuery as ChildTripQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\CityTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'city' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class City implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\CityTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the city_id field.
     * @var        int
     */
    protected $city_id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the region field.
     * @var        string
     */
    protected $region;

    /**
     * The value for the display field.
     * @var        string
     */
    protected $display;

    /**
     * The value for the update_time field.
     * @var        \DateTime
     */
    protected $update_time;

    /**
     * The value for the update_user field.
     * @var        string
     */
    protected $update_user;

    /**
     * @var        ObjectCollection|ChildTrip[] Collection to store aggregation of ChildTrip objects.
     */
    protected $collTripsRelatedByFromCityId;
    protected $collTripsRelatedByFromCityIdPartial;

    /**
     * @var        ObjectCollection|ChildTrip[] Collection to store aggregation of ChildTrip objects.
     */
    protected $collTripsRelatedByToCityId;
    protected $collTripsRelatedByToCityIdPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTrip[]
     */
    protected $tripsRelatedByFromCityIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTrip[]
     */
    protected $tripsRelatedByToCityIdScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\City object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>City</code> instance.  If
     * <code>obj</code> is an instance of <code>City</code>, delegates to
     * <code>equals(City)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|City The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [city_id] column value.
     *
     * @return int
     */
    public function getCityId()
    {
        return $this->city_id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [region] column value.
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Get the [display] column value.
     *
     * @return string
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * Get the [optionally formatted] temporal [update_time] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdateTime($format = NULL)
    {
        if ($format === null) {
            return $this->update_time;
        } else {
            return $this->update_time instanceof \DateTime ? $this->update_time->format($format) : null;
        }
    }

    /**
     * Get the [update_user] column value.
     *
     * @return string
     */
    public function getUpdateUser()
    {
        return $this->update_user;
    }

    /**
     * Set the value of [city_id] column.
     *
     * @param  int $v new value
     * @return $this|\City The current object (for fluent API support)
     */
    public function setCityId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->city_id !== $v) {
            $this->city_id = $v;
            $this->modifiedColumns[CityTableMap::COL_CITY_ID] = true;
        }

        return $this;
    } // setCityId()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return $this|\City The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[CityTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [region] column.
     *
     * @param  string $v new value
     * @return $this|\City The current object (for fluent API support)
     */
    public function setRegion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->region !== $v) {
            $this->region = $v;
            $this->modifiedColumns[CityTableMap::COL_REGION] = true;
        }

        return $this;
    } // setRegion()

    /**
     * Set the value of [display] column.
     *
     * @param  string $v new value
     * @return $this|\City The current object (for fluent API support)
     */
    public function setDisplay($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->display !== $v) {
            $this->display = $v;
            $this->modifiedColumns[CityTableMap::COL_DISPLAY] = true;
        }

        return $this;
    } // setDisplay()

    /**
     * Sets the value of [update_time] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\City The current object (for fluent API support)
     */
    public function setUpdateTime($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->update_time !== null || $dt !== null) {
            if ($dt !== $this->update_time) {
                $this->update_time = $dt;
                $this->modifiedColumns[CityTableMap::COL_UPDATE_TIME] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdateTime()

    /**
     * Set the value of [update_user] column.
     *
     * @param  string $v new value
     * @return $this|\City The current object (for fluent API support)
     */
    public function setUpdateUser($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->update_user !== $v) {
            $this->update_user = $v;
            $this->modifiedColumns[CityTableMap::COL_UPDATE_USER] = true;
        }

        return $this;
    } // setUpdateUser()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CityTableMap::translateFieldName('CityId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->city_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CityTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CityTableMap::translateFieldName('Region', TableMap::TYPE_PHPNAME, $indexType)];
            $this->region = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CityTableMap::translateFieldName('Display', TableMap::TYPE_PHPNAME, $indexType)];
            $this->display = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : CityTableMap::translateFieldName('UpdateTime', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->update_time = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : CityTableMap::translateFieldName('UpdateUser', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_user = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = CityTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\City'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CityTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCityQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collTripsRelatedByFromCityId = null;

            $this->collTripsRelatedByToCityId = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see City::setDeleted()
     * @see City::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CityTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildCityQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CityTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                CityTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->tripsRelatedByFromCityIdScheduledForDeletion !== null) {
                if (!$this->tripsRelatedByFromCityIdScheduledForDeletion->isEmpty()) {
                    \TripQuery::create()
                        ->filterByPrimaryKeys($this->tripsRelatedByFromCityIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->tripsRelatedByFromCityIdScheduledForDeletion = null;
                }
            }

            if ($this->collTripsRelatedByFromCityId !== null) {
                foreach ($this->collTripsRelatedByFromCityId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->tripsRelatedByToCityIdScheduledForDeletion !== null) {
                if (!$this->tripsRelatedByToCityIdScheduledForDeletion->isEmpty()) {
                    \TripQuery::create()
                        ->filterByPrimaryKeys($this->tripsRelatedByToCityIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->tripsRelatedByToCityIdScheduledForDeletion = null;
                }
            }

            if ($this->collTripsRelatedByToCityId !== null) {
                foreach ($this->collTripsRelatedByToCityId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[CityTableMap::COL_CITY_ID] = true;
        if (null !== $this->city_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CityTableMap::COL_CITY_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CityTableMap::COL_CITY_ID)) {
            $modifiedColumns[':p' . $index++]  = 'city_id';
        }
        if ($this->isColumnModified(CityTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(CityTableMap::COL_REGION)) {
            $modifiedColumns[':p' . $index++]  = 'region';
        }
        if ($this->isColumnModified(CityTableMap::COL_DISPLAY)) {
            $modifiedColumns[':p' . $index++]  = 'display';
        }
        if ($this->isColumnModified(CityTableMap::COL_UPDATE_TIME)) {
            $modifiedColumns[':p' . $index++]  = 'update_time';
        }
        if ($this->isColumnModified(CityTableMap::COL_UPDATE_USER)) {
            $modifiedColumns[':p' . $index++]  = 'update_user';
        }

        $sql = sprintf(
            'INSERT INTO city (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'city_id':
                        $stmt->bindValue($identifier, $this->city_id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'region':
                        $stmt->bindValue($identifier, $this->region, PDO::PARAM_STR);
                        break;
                    case 'display':
                        $stmt->bindValue($identifier, $this->display, PDO::PARAM_STR);
                        break;
                    case 'update_time':
                        $stmt->bindValue($identifier, $this->update_time ? $this->update_time->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'update_user':
                        $stmt->bindValue($identifier, $this->update_user, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setCityId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CityTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getCityId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getRegion();
                break;
            case 3:
                return $this->getDisplay();
                break;
            case 4:
                return $this->getUpdateTime();
                break;
            case 5:
                return $this->getUpdateUser();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['City'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['City'][$this->hashCode()] = true;
        $keys = CityTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getCityId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getRegion(),
            $keys[3] => $this->getDisplay(),
            $keys[4] => $this->getUpdateTime(),
            $keys[5] => $this->getUpdateUser(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collTripsRelatedByFromCityId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'trips';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'trips';
                        break;
                    default:
                        $key = 'Trips';
                }

                $result[$key] = $this->collTripsRelatedByFromCityId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTripsRelatedByToCityId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'trips';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'trips';
                        break;
                    default:
                        $key = 'Trips';
                }

                $result[$key] = $this->collTripsRelatedByToCityId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\City
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CityTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\City
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setCityId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setRegion($value);
                break;
            case 3:
                $this->setDisplay($value);
                break;
            case 4:
                $this->setUpdateTime($value);
                break;
            case 5:
                $this->setUpdateUser($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = CityTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setCityId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setRegion($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDisplay($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setUpdateTime($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setUpdateUser($arr[$keys[5]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\City The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CityTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CityTableMap::COL_CITY_ID)) {
            $criteria->add(CityTableMap::COL_CITY_ID, $this->city_id);
        }
        if ($this->isColumnModified(CityTableMap::COL_NAME)) {
            $criteria->add(CityTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(CityTableMap::COL_REGION)) {
            $criteria->add(CityTableMap::COL_REGION, $this->region);
        }
        if ($this->isColumnModified(CityTableMap::COL_DISPLAY)) {
            $criteria->add(CityTableMap::COL_DISPLAY, $this->display);
        }
        if ($this->isColumnModified(CityTableMap::COL_UPDATE_TIME)) {
            $criteria->add(CityTableMap::COL_UPDATE_TIME, $this->update_time);
        }
        if ($this->isColumnModified(CityTableMap::COL_UPDATE_USER)) {
            $criteria->add(CityTableMap::COL_UPDATE_USER, $this->update_user);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildCityQuery::create();
        $criteria->add(CityTableMap::COL_CITY_ID, $this->city_id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getCityId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getCityId();
    }

    /**
     * Generic method to set the primary key (city_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setCityId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getCityId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \City (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setRegion($this->getRegion());
        $copyObj->setDisplay($this->getDisplay());
        $copyObj->setUpdateTime($this->getUpdateTime());
        $copyObj->setUpdateUser($this->getUpdateUser());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getTripsRelatedByFromCityId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTripRelatedByFromCityId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTripsRelatedByToCityId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTripRelatedByToCityId($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setCityId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \City Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('TripRelatedByFromCityId' == $relationName) {
            return $this->initTripsRelatedByFromCityId();
        }
        if ('TripRelatedByToCityId' == $relationName) {
            return $this->initTripsRelatedByToCityId();
        }
    }

    /**
     * Clears out the collTripsRelatedByFromCityId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTripsRelatedByFromCityId()
     */
    public function clearTripsRelatedByFromCityId()
    {
        $this->collTripsRelatedByFromCityId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTripsRelatedByFromCityId collection loaded partially.
     */
    public function resetPartialTripsRelatedByFromCityId($v = true)
    {
        $this->collTripsRelatedByFromCityIdPartial = $v;
    }

    /**
     * Initializes the collTripsRelatedByFromCityId collection.
     *
     * By default this just sets the collTripsRelatedByFromCityId collection to an empty array (like clearcollTripsRelatedByFromCityId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTripsRelatedByFromCityId($overrideExisting = true)
    {
        if (null !== $this->collTripsRelatedByFromCityId && !$overrideExisting) {
            return;
        }
        $this->collTripsRelatedByFromCityId = new ObjectCollection();
        $this->collTripsRelatedByFromCityId->setModel('\Trip');
    }

    /**
     * Gets an array of ChildTrip objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTrip[] List of ChildTrip objects
     * @throws PropelException
     */
    public function getTripsRelatedByFromCityId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTripsRelatedByFromCityIdPartial && !$this->isNew();
        if (null === $this->collTripsRelatedByFromCityId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTripsRelatedByFromCityId) {
                // return empty collection
                $this->initTripsRelatedByFromCityId();
            } else {
                $collTripsRelatedByFromCityId = ChildTripQuery::create(null, $criteria)
                    ->filterByCityRelatedByFromCityId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTripsRelatedByFromCityIdPartial && count($collTripsRelatedByFromCityId)) {
                        $this->initTripsRelatedByFromCityId(false);

                        foreach ($collTripsRelatedByFromCityId as $obj) {
                            if (false == $this->collTripsRelatedByFromCityId->contains($obj)) {
                                $this->collTripsRelatedByFromCityId->append($obj);
                            }
                        }

                        $this->collTripsRelatedByFromCityIdPartial = true;
                    }

                    return $collTripsRelatedByFromCityId;
                }

                if ($partial && $this->collTripsRelatedByFromCityId) {
                    foreach ($this->collTripsRelatedByFromCityId as $obj) {
                        if ($obj->isNew()) {
                            $collTripsRelatedByFromCityId[] = $obj;
                        }
                    }
                }

                $this->collTripsRelatedByFromCityId = $collTripsRelatedByFromCityId;
                $this->collTripsRelatedByFromCityIdPartial = false;
            }
        }

        return $this->collTripsRelatedByFromCityId;
    }

    /**
     * Sets a collection of ChildTrip objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $tripsRelatedByFromCityId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCity The current object (for fluent API support)
     */
    public function setTripsRelatedByFromCityId(Collection $tripsRelatedByFromCityId, ConnectionInterface $con = null)
    {
        /** @var ChildTrip[] $tripsRelatedByFromCityIdToDelete */
        $tripsRelatedByFromCityIdToDelete = $this->getTripsRelatedByFromCityId(new Criteria(), $con)->diff($tripsRelatedByFromCityId);


        $this->tripsRelatedByFromCityIdScheduledForDeletion = $tripsRelatedByFromCityIdToDelete;

        foreach ($tripsRelatedByFromCityIdToDelete as $tripRelatedByFromCityIdRemoved) {
            $tripRelatedByFromCityIdRemoved->setCityRelatedByFromCityId(null);
        }

        $this->collTripsRelatedByFromCityId = null;
        foreach ($tripsRelatedByFromCityId as $tripRelatedByFromCityId) {
            $this->addTripRelatedByFromCityId($tripRelatedByFromCityId);
        }

        $this->collTripsRelatedByFromCityId = $tripsRelatedByFromCityId;
        $this->collTripsRelatedByFromCityIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Trip objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Trip objects.
     * @throws PropelException
     */
    public function countTripsRelatedByFromCityId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTripsRelatedByFromCityIdPartial && !$this->isNew();
        if (null === $this->collTripsRelatedByFromCityId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTripsRelatedByFromCityId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTripsRelatedByFromCityId());
            }

            $query = ChildTripQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCityRelatedByFromCityId($this)
                ->count($con);
        }

        return count($this->collTripsRelatedByFromCityId);
    }

    /**
     * Method called to associate a ChildTrip object to this object
     * through the ChildTrip foreign key attribute.
     *
     * @param  ChildTrip $l ChildTrip
     * @return $this|\City The current object (for fluent API support)
     */
    public function addTripRelatedByFromCityId(ChildTrip $l)
    {
        if ($this->collTripsRelatedByFromCityId === null) {
            $this->initTripsRelatedByFromCityId();
            $this->collTripsRelatedByFromCityIdPartial = true;
        }

        if (!$this->collTripsRelatedByFromCityId->contains($l)) {
            $this->doAddTripRelatedByFromCityId($l);
        }

        return $this;
    }

    /**
     * @param ChildTrip $tripRelatedByFromCityId The ChildTrip object to add.
     */
    protected function doAddTripRelatedByFromCityId(ChildTrip $tripRelatedByFromCityId)
    {
        $this->collTripsRelatedByFromCityId[]= $tripRelatedByFromCityId;
        $tripRelatedByFromCityId->setCityRelatedByFromCityId($this);
    }

    /**
     * @param  ChildTrip $tripRelatedByFromCityId The ChildTrip object to remove.
     * @return $this|ChildCity The current object (for fluent API support)
     */
    public function removeTripRelatedByFromCityId(ChildTrip $tripRelatedByFromCityId)
    {
        if ($this->getTripsRelatedByFromCityId()->contains($tripRelatedByFromCityId)) {
            $pos = $this->collTripsRelatedByFromCityId->search($tripRelatedByFromCityId);
            $this->collTripsRelatedByFromCityId->remove($pos);
            if (null === $this->tripsRelatedByFromCityIdScheduledForDeletion) {
                $this->tripsRelatedByFromCityIdScheduledForDeletion = clone $this->collTripsRelatedByFromCityId;
                $this->tripsRelatedByFromCityIdScheduledForDeletion->clear();
            }
            $this->tripsRelatedByFromCityIdScheduledForDeletion[]= clone $tripRelatedByFromCityId;
            $tripRelatedByFromCityId->setCityRelatedByFromCityId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this City is new, it will return
     * an empty collection; or if this City has previously
     * been saved, it will retrieve related TripsRelatedByFromCityId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in City.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTrip[] List of ChildTrip objects
     */
    public function getTripsRelatedByFromCityIdJoinUnit(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTripQuery::create(null, $criteria);
        $query->joinWith('Unit', $joinBehavior);

        return $this->getTripsRelatedByFromCityId($query, $con);
    }

    /**
     * Clears out the collTripsRelatedByToCityId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTripsRelatedByToCityId()
     */
    public function clearTripsRelatedByToCityId()
    {
        $this->collTripsRelatedByToCityId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTripsRelatedByToCityId collection loaded partially.
     */
    public function resetPartialTripsRelatedByToCityId($v = true)
    {
        $this->collTripsRelatedByToCityIdPartial = $v;
    }

    /**
     * Initializes the collTripsRelatedByToCityId collection.
     *
     * By default this just sets the collTripsRelatedByToCityId collection to an empty array (like clearcollTripsRelatedByToCityId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTripsRelatedByToCityId($overrideExisting = true)
    {
        if (null !== $this->collTripsRelatedByToCityId && !$overrideExisting) {
            return;
        }
        $this->collTripsRelatedByToCityId = new ObjectCollection();
        $this->collTripsRelatedByToCityId->setModel('\Trip');
    }

    /**
     * Gets an array of ChildTrip objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTrip[] List of ChildTrip objects
     * @throws PropelException
     */
    public function getTripsRelatedByToCityId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTripsRelatedByToCityIdPartial && !$this->isNew();
        if (null === $this->collTripsRelatedByToCityId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTripsRelatedByToCityId) {
                // return empty collection
                $this->initTripsRelatedByToCityId();
            } else {
                $collTripsRelatedByToCityId = ChildTripQuery::create(null, $criteria)
                    ->filterByCityRelatedByToCityId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTripsRelatedByToCityIdPartial && count($collTripsRelatedByToCityId)) {
                        $this->initTripsRelatedByToCityId(false);

                        foreach ($collTripsRelatedByToCityId as $obj) {
                            if (false == $this->collTripsRelatedByToCityId->contains($obj)) {
                                $this->collTripsRelatedByToCityId->append($obj);
                            }
                        }

                        $this->collTripsRelatedByToCityIdPartial = true;
                    }

                    return $collTripsRelatedByToCityId;
                }

                if ($partial && $this->collTripsRelatedByToCityId) {
                    foreach ($this->collTripsRelatedByToCityId as $obj) {
                        if ($obj->isNew()) {
                            $collTripsRelatedByToCityId[] = $obj;
                        }
                    }
                }

                $this->collTripsRelatedByToCityId = $collTripsRelatedByToCityId;
                $this->collTripsRelatedByToCityIdPartial = false;
            }
        }

        return $this->collTripsRelatedByToCityId;
    }

    /**
     * Sets a collection of ChildTrip objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $tripsRelatedByToCityId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCity The current object (for fluent API support)
     */
    public function setTripsRelatedByToCityId(Collection $tripsRelatedByToCityId, ConnectionInterface $con = null)
    {
        /** @var ChildTrip[] $tripsRelatedByToCityIdToDelete */
        $tripsRelatedByToCityIdToDelete = $this->getTripsRelatedByToCityId(new Criteria(), $con)->diff($tripsRelatedByToCityId);


        $this->tripsRelatedByToCityIdScheduledForDeletion = $tripsRelatedByToCityIdToDelete;

        foreach ($tripsRelatedByToCityIdToDelete as $tripRelatedByToCityIdRemoved) {
            $tripRelatedByToCityIdRemoved->setCityRelatedByToCityId(null);
        }

        $this->collTripsRelatedByToCityId = null;
        foreach ($tripsRelatedByToCityId as $tripRelatedByToCityId) {
            $this->addTripRelatedByToCityId($tripRelatedByToCityId);
        }

        $this->collTripsRelatedByToCityId = $tripsRelatedByToCityId;
        $this->collTripsRelatedByToCityIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Trip objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Trip objects.
     * @throws PropelException
     */
    public function countTripsRelatedByToCityId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTripsRelatedByToCityIdPartial && !$this->isNew();
        if (null === $this->collTripsRelatedByToCityId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTripsRelatedByToCityId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTripsRelatedByToCityId());
            }

            $query = ChildTripQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCityRelatedByToCityId($this)
                ->count($con);
        }

        return count($this->collTripsRelatedByToCityId);
    }

    /**
     * Method called to associate a ChildTrip object to this object
     * through the ChildTrip foreign key attribute.
     *
     * @param  ChildTrip $l ChildTrip
     * @return $this|\City The current object (for fluent API support)
     */
    public function addTripRelatedByToCityId(ChildTrip $l)
    {
        if ($this->collTripsRelatedByToCityId === null) {
            $this->initTripsRelatedByToCityId();
            $this->collTripsRelatedByToCityIdPartial = true;
        }

        if (!$this->collTripsRelatedByToCityId->contains($l)) {
            $this->doAddTripRelatedByToCityId($l);
        }

        return $this;
    }

    /**
     * @param ChildTrip $tripRelatedByToCityId The ChildTrip object to add.
     */
    protected function doAddTripRelatedByToCityId(ChildTrip $tripRelatedByToCityId)
    {
        $this->collTripsRelatedByToCityId[]= $tripRelatedByToCityId;
        $tripRelatedByToCityId->setCityRelatedByToCityId($this);
    }

    /**
     * @param  ChildTrip $tripRelatedByToCityId The ChildTrip object to remove.
     * @return $this|ChildCity The current object (for fluent API support)
     */
    public function removeTripRelatedByToCityId(ChildTrip $tripRelatedByToCityId)
    {
        if ($this->getTripsRelatedByToCityId()->contains($tripRelatedByToCityId)) {
            $pos = $this->collTripsRelatedByToCityId->search($tripRelatedByToCityId);
            $this->collTripsRelatedByToCityId->remove($pos);
            if (null === $this->tripsRelatedByToCityIdScheduledForDeletion) {
                $this->tripsRelatedByToCityIdScheduledForDeletion = clone $this->collTripsRelatedByToCityId;
                $this->tripsRelatedByToCityIdScheduledForDeletion->clear();
            }
            $this->tripsRelatedByToCityIdScheduledForDeletion[]= clone $tripRelatedByToCityId;
            $tripRelatedByToCityId->setCityRelatedByToCityId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this City is new, it will return
     * an empty collection; or if this City has previously
     * been saved, it will retrieve related TripsRelatedByToCityId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in City.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTrip[] List of ChildTrip objects
     */
    public function getTripsRelatedByToCityIdJoinUnit(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTripQuery::create(null, $criteria);
        $query->joinWith('Unit', $joinBehavior);

        return $this->getTripsRelatedByToCityId($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->city_id = null;
        $this->name = null;
        $this->region = null;
        $this->display = null;
        $this->update_time = null;
        $this->update_user = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collTripsRelatedByFromCityId) {
                foreach ($this->collTripsRelatedByFromCityId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTripsRelatedByToCityId) {
                foreach ($this->collTripsRelatedByToCityId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collTripsRelatedByFromCityId = null;
        $this->collTripsRelatedByToCityId = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CityTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}

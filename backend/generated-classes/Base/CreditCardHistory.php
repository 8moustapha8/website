<?php

namespace Base;

use \CreditCardHistoryQuery as ChildCreditCardHistoryQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\CreditCardHistoryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'credit_card_history' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class CreditCardHistory implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\CreditCardHistoryTableMap';


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
     * The value for the credit_card_id field.
     * @var        int
     */
    protected $credit_card_id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the issuer_id field.
     * @var        int
     */
    protected $issuer_id;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * The value for the image_link field.
     * @var        string
     */
    protected $image_link;

    /**
     * The value for the visa field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $visa;

    /**
     * The value for the master field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $master;

    /**
     * The value for the jcb field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $jcb;

    /**
     * The value for the amex field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $amex;

    /**
     * The value for the diners field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $diners;

    /**
     * The value for the afilliate_link field.
     * @var        string
     */
    protected $afilliate_link;

    /**
     * The value for the affiliate_id field.
     * @var        int
     */
    protected $affiliate_id;

    /**
     * The value for the time_beg field.
     * @var        \DateTime
     */
    protected $time_beg;

    /**
     * The value for the time_end field.
     * @var        \DateTime
     */
    protected $time_end;

    /**
     * The value for the update_user field.
     * @var        string
     */
    protected $update_user;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->visa = false;
        $this->master = false;
        $this->jcb = false;
        $this->amex = false;
        $this->diners = false;
    }

    /**
     * Initializes internal state of Base\CreditCardHistory object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
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
     * Compares this with another <code>CreditCardHistory</code> instance.  If
     * <code>obj</code> is an instance of <code>CreditCardHistory</code>, delegates to
     * <code>equals(CreditCardHistory)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|CreditCardHistory The current object, for fluid interface
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
     * Get the [credit_card_id] column value.
     *
     * @return int
     */
    public function getCreditCardId()
    {
        return $this->credit_card_id;
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
     * Get the [issuer_id] column value.
     *
     * @return int
     */
    public function getIssuerId()
    {
        return $this->issuer_id;
    }

    /**
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the [image_link] column value.
     *
     * @return string
     */
    public function getImageLink()
    {
        return $this->image_link;
    }

    /**
     * Get the [visa] column value.
     *
     * @return boolean
     */
    public function getVisa()
    {
        return $this->visa;
    }

    /**
     * Get the [visa] column value.
     *
     * @return boolean
     */
    public function isVisa()
    {
        return $this->getVisa();
    }

    /**
     * Get the [master] column value.
     *
     * @return boolean
     */
    public function getMaster()
    {
        return $this->master;
    }

    /**
     * Get the [master] column value.
     *
     * @return boolean
     */
    public function isMaster()
    {
        return $this->getMaster();
    }

    /**
     * Get the [jcb] column value.
     *
     * @return boolean
     */
    public function getJcb()
    {
        return $this->jcb;
    }

    /**
     * Get the [jcb] column value.
     *
     * @return boolean
     */
    public function isJcb()
    {
        return $this->getJcb();
    }

    /**
     * Get the [amex] column value.
     *
     * @return boolean
     */
    public function getAmex()
    {
        return $this->amex;
    }

    /**
     * Get the [amex] column value.
     *
     * @return boolean
     */
    public function isAmex()
    {
        return $this->getAmex();
    }

    /**
     * Get the [diners] column value.
     *
     * @return boolean
     */
    public function getDiners()
    {
        return $this->diners;
    }

    /**
     * Get the [diners] column value.
     *
     * @return boolean
     */
    public function isDiners()
    {
        return $this->getDiners();
    }

    /**
     * Get the [afilliate_link] column value.
     *
     * @return string
     */
    public function getAfilliateLink()
    {
        return $this->afilliate_link;
    }

    /**
     * Get the [affiliate_id] column value.
     *
     * @return int
     */
    public function getAffiliateId()
    {
        return $this->affiliate_id;
    }

    /**
     * Get the [optionally formatted] temporal [time_beg] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getTimeBeg($format = NULL)
    {
        if ($format === null) {
            return $this->time_beg;
        } else {
            return $this->time_beg instanceof \DateTime ? $this->time_beg->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [time_end] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getTimeEnd($format = NULL)
    {
        if ($format === null) {
            return $this->time_end;
        } else {
            return $this->time_end instanceof \DateTime ? $this->time_end->format($format) : null;
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
     * Set the value of [credit_card_id] column.
     *
     * @param  int $v new value
     * @return $this|\CreditCardHistory The current object (for fluent API support)
     */
    public function setCreditCardId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->credit_card_id !== $v) {
            $this->credit_card_id = $v;
            $this->modifiedColumns[CreditCardHistoryTableMap::COL_CREDIT_CARD_ID] = true;
        }

        return $this;
    } // setCreditCardId()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return $this|\CreditCardHistory The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[CreditCardHistoryTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [issuer_id] column.
     *
     * @param  int $v new value
     * @return $this|\CreditCardHistory The current object (for fluent API support)
     */
    public function setIssuerId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->issuer_id !== $v) {
            $this->issuer_id = $v;
            $this->modifiedColumns[CreditCardHistoryTableMap::COL_ISSUER_ID] = true;
        }

        return $this;
    } // setIssuerId()

    /**
     * Set the value of [description] column.
     *
     * @param  string $v new value
     * @return $this|\CreditCardHistory The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[CreditCardHistoryTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Set the value of [image_link] column.
     *
     * @param  string $v new value
     * @return $this|\CreditCardHistory The current object (for fluent API support)
     */
    public function setImageLink($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->image_link !== $v) {
            $this->image_link = $v;
            $this->modifiedColumns[CreditCardHistoryTableMap::COL_IMAGE_LINK] = true;
        }

        return $this;
    } // setImageLink()

    /**
     * Sets the value of the [visa] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\CreditCardHistory The current object (for fluent API support)
     */
    public function setVisa($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->visa !== $v) {
            $this->visa = $v;
            $this->modifiedColumns[CreditCardHistoryTableMap::COL_VISA] = true;
        }

        return $this;
    } // setVisa()

    /**
     * Sets the value of the [master] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\CreditCardHistory The current object (for fluent API support)
     */
    public function setMaster($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->master !== $v) {
            $this->master = $v;
            $this->modifiedColumns[CreditCardHistoryTableMap::COL_MASTER] = true;
        }

        return $this;
    } // setMaster()

    /**
     * Sets the value of the [jcb] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\CreditCardHistory The current object (for fluent API support)
     */
    public function setJcb($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->jcb !== $v) {
            $this->jcb = $v;
            $this->modifiedColumns[CreditCardHistoryTableMap::COL_JCB] = true;
        }

        return $this;
    } // setJcb()

    /**
     * Sets the value of the [amex] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\CreditCardHistory The current object (for fluent API support)
     */
    public function setAmex($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->amex !== $v) {
            $this->amex = $v;
            $this->modifiedColumns[CreditCardHistoryTableMap::COL_AMEX] = true;
        }

        return $this;
    } // setAmex()

    /**
     * Sets the value of the [diners] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\CreditCardHistory The current object (for fluent API support)
     */
    public function setDiners($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->diners !== $v) {
            $this->diners = $v;
            $this->modifiedColumns[CreditCardHistoryTableMap::COL_DINERS] = true;
        }

        return $this;
    } // setDiners()

    /**
     * Set the value of [afilliate_link] column.
     *
     * @param  string $v new value
     * @return $this|\CreditCardHistory The current object (for fluent API support)
     */
    public function setAfilliateLink($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->afilliate_link !== $v) {
            $this->afilliate_link = $v;
            $this->modifiedColumns[CreditCardHistoryTableMap::COL_AFILLIATE_LINK] = true;
        }

        return $this;
    } // setAfilliateLink()

    /**
     * Set the value of [affiliate_id] column.
     *
     * @param  int $v new value
     * @return $this|\CreditCardHistory The current object (for fluent API support)
     */
    public function setAffiliateId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->affiliate_id !== $v) {
            $this->affiliate_id = $v;
            $this->modifiedColumns[CreditCardHistoryTableMap::COL_AFFILIATE_ID] = true;
        }

        return $this;
    } // setAffiliateId()

    /**
     * Sets the value of [time_beg] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\CreditCardHistory The current object (for fluent API support)
     */
    public function setTimeBeg($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->time_beg !== null || $dt !== null) {
            if ($dt !== $this->time_beg) {
                $this->time_beg = $dt;
                $this->modifiedColumns[CreditCardHistoryTableMap::COL_TIME_BEG] = true;
            }
        } // if either are not null

        return $this;
    } // setTimeBeg()

    /**
     * Sets the value of [time_end] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\CreditCardHistory The current object (for fluent API support)
     */
    public function setTimeEnd($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->time_end !== null || $dt !== null) {
            if ($dt !== $this->time_end) {
                $this->time_end = $dt;
                $this->modifiedColumns[CreditCardHistoryTableMap::COL_TIME_END] = true;
            }
        } // if either are not null

        return $this;
    } // setTimeEnd()

    /**
     * Set the value of [update_user] column.
     *
     * @param  string $v new value
     * @return $this|\CreditCardHistory The current object (for fluent API support)
     */
    public function setUpdateUser($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->update_user !== $v) {
            $this->update_user = $v;
            $this->modifiedColumns[CreditCardHistoryTableMap::COL_UPDATE_USER] = true;
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
            if ($this->visa !== false) {
                return false;
            }

            if ($this->master !== false) {
                return false;
            }

            if ($this->jcb !== false) {
                return false;
            }

            if ($this->amex !== false) {
                return false;
            }

            if ($this->diners !== false) {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CreditCardHistoryTableMap::translateFieldName('CreditCardId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->credit_card_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CreditCardHistoryTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CreditCardHistoryTableMap::translateFieldName('IssuerId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->issuer_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CreditCardHistoryTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : CreditCardHistoryTableMap::translateFieldName('ImageLink', TableMap::TYPE_PHPNAME, $indexType)];
            $this->image_link = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : CreditCardHistoryTableMap::translateFieldName('Visa', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visa = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : CreditCardHistoryTableMap::translateFieldName('Master', TableMap::TYPE_PHPNAME, $indexType)];
            $this->master = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : CreditCardHistoryTableMap::translateFieldName('Jcb', TableMap::TYPE_PHPNAME, $indexType)];
            $this->jcb = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : CreditCardHistoryTableMap::translateFieldName('Amex', TableMap::TYPE_PHPNAME, $indexType)];
            $this->amex = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : CreditCardHistoryTableMap::translateFieldName('Diners', TableMap::TYPE_PHPNAME, $indexType)];
            $this->diners = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : CreditCardHistoryTableMap::translateFieldName('AfilliateLink', TableMap::TYPE_PHPNAME, $indexType)];
            $this->afilliate_link = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : CreditCardHistoryTableMap::translateFieldName('AffiliateId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->affiliate_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : CreditCardHistoryTableMap::translateFieldName('TimeBeg', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->time_beg = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : CreditCardHistoryTableMap::translateFieldName('TimeEnd', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->time_end = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : CreditCardHistoryTableMap::translateFieldName('UpdateUser', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_user = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 15; // 15 = CreditCardHistoryTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\CreditCardHistory'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(CreditCardHistoryTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCreditCardHistoryQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see CreditCardHistory::setDeleted()
     * @see CreditCardHistory::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CreditCardHistoryTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildCreditCardHistoryQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(CreditCardHistoryTableMap::DATABASE_NAME);
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
                CreditCardHistoryTableMap::addInstanceToPool($this);
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_CREDIT_CARD_ID)) {
            $modifiedColumns[':p' . $index++]  = 'credit_card_id';
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_ISSUER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'issuer_id';
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_IMAGE_LINK)) {
            $modifiedColumns[':p' . $index++]  = 'image_link';
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_VISA)) {
            $modifiedColumns[':p' . $index++]  = 'visa';
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_MASTER)) {
            $modifiedColumns[':p' . $index++]  = 'master';
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_JCB)) {
            $modifiedColumns[':p' . $index++]  = 'jcb';
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_AMEX)) {
            $modifiedColumns[':p' . $index++]  = 'amex';
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_DINERS)) {
            $modifiedColumns[':p' . $index++]  = 'diners';
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_AFILLIATE_LINK)) {
            $modifiedColumns[':p' . $index++]  = 'afilliate_link';
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_AFFILIATE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'affiliate_id';
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_TIME_BEG)) {
            $modifiedColumns[':p' . $index++]  = 'time_beg';
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_TIME_END)) {
            $modifiedColumns[':p' . $index++]  = 'time_end';
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_UPDATE_USER)) {
            $modifiedColumns[':p' . $index++]  = 'update_user';
        }

        $sql = sprintf(
            'INSERT INTO credit_card_history (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'credit_card_id':
                        $stmt->bindValue($identifier, $this->credit_card_id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'issuer_id':
                        $stmt->bindValue($identifier, $this->issuer_id, PDO::PARAM_INT);
                        break;
                    case 'description':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'image_link':
                        $stmt->bindValue($identifier, $this->image_link, PDO::PARAM_STR);
                        break;
                    case 'visa':
                        $stmt->bindValue($identifier, (int) $this->visa, PDO::PARAM_INT);
                        break;
                    case 'master':
                        $stmt->bindValue($identifier, (int) $this->master, PDO::PARAM_INT);
                        break;
                    case 'jcb':
                        $stmt->bindValue($identifier, (int) $this->jcb, PDO::PARAM_INT);
                        break;
                    case 'amex':
                        $stmt->bindValue($identifier, (int) $this->amex, PDO::PARAM_INT);
                        break;
                    case 'diners':
                        $stmt->bindValue($identifier, (int) $this->diners, PDO::PARAM_INT);
                        break;
                    case 'afilliate_link':
                        $stmt->bindValue($identifier, $this->afilliate_link, PDO::PARAM_STR);
                        break;
                    case 'affiliate_id':
                        $stmt->bindValue($identifier, $this->affiliate_id, PDO::PARAM_INT);
                        break;
                    case 'time_beg':
                        $stmt->bindValue($identifier, $this->time_beg ? $this->time_beg->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'time_end':
                        $stmt->bindValue($identifier, $this->time_end ? $this->time_end->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
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
        $pos = CreditCardHistoryTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getCreditCardId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getIssuerId();
                break;
            case 3:
                return $this->getDescription();
                break;
            case 4:
                return $this->getImageLink();
                break;
            case 5:
                return $this->getVisa();
                break;
            case 6:
                return $this->getMaster();
                break;
            case 7:
                return $this->getJcb();
                break;
            case 8:
                return $this->getAmex();
                break;
            case 9:
                return $this->getDiners();
                break;
            case 10:
                return $this->getAfilliateLink();
                break;
            case 11:
                return $this->getAffiliateId();
                break;
            case 12:
                return $this->getTimeBeg();
                break;
            case 13:
                return $this->getTimeEnd();
                break;
            case 14:
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
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array())
    {

        if (isset($alreadyDumpedObjects['CreditCardHistory'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['CreditCardHistory'][$this->hashCode()] = true;
        $keys = CreditCardHistoryTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getCreditCardId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getIssuerId(),
            $keys[3] => $this->getDescription(),
            $keys[4] => $this->getImageLink(),
            $keys[5] => $this->getVisa(),
            $keys[6] => $this->getMaster(),
            $keys[7] => $this->getJcb(),
            $keys[8] => $this->getAmex(),
            $keys[9] => $this->getDiners(),
            $keys[10] => $this->getAfilliateLink(),
            $keys[11] => $this->getAffiliateId(),
            $keys[12] => $this->getTimeBeg(),
            $keys[13] => $this->getTimeEnd(),
            $keys[14] => $this->getUpdateUser(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
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
     * @return $this|\CreditCardHistory
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CreditCardHistoryTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\CreditCardHistory
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setCreditCardId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setIssuerId($value);
                break;
            case 3:
                $this->setDescription($value);
                break;
            case 4:
                $this->setImageLink($value);
                break;
            case 5:
                $this->setVisa($value);
                break;
            case 6:
                $this->setMaster($value);
                break;
            case 7:
                $this->setJcb($value);
                break;
            case 8:
                $this->setAmex($value);
                break;
            case 9:
                $this->setDiners($value);
                break;
            case 10:
                $this->setAfilliateLink($value);
                break;
            case 11:
                $this->setAffiliateId($value);
                break;
            case 12:
                $this->setTimeBeg($value);
                break;
            case 13:
                $this->setTimeEnd($value);
                break;
            case 14:
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
        $keys = CreditCardHistoryTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setCreditCardId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setIssuerId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDescription($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setImageLink($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setVisa($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setMaster($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setJcb($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setAmex($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setDiners($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setAfilliateLink($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setAffiliateId($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setTimeBeg($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setTimeEnd($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setUpdateUser($arr[$keys[14]]);
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
     * @return $this|\CreditCardHistory The current object, for fluid interface
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
        $criteria = new Criteria(CreditCardHistoryTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_CREDIT_CARD_ID)) {
            $criteria->add(CreditCardHistoryTableMap::COL_CREDIT_CARD_ID, $this->credit_card_id);
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_NAME)) {
            $criteria->add(CreditCardHistoryTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_ISSUER_ID)) {
            $criteria->add(CreditCardHistoryTableMap::COL_ISSUER_ID, $this->issuer_id);
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_DESCRIPTION)) {
            $criteria->add(CreditCardHistoryTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_IMAGE_LINK)) {
            $criteria->add(CreditCardHistoryTableMap::COL_IMAGE_LINK, $this->image_link);
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_VISA)) {
            $criteria->add(CreditCardHistoryTableMap::COL_VISA, $this->visa);
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_MASTER)) {
            $criteria->add(CreditCardHistoryTableMap::COL_MASTER, $this->master);
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_JCB)) {
            $criteria->add(CreditCardHistoryTableMap::COL_JCB, $this->jcb);
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_AMEX)) {
            $criteria->add(CreditCardHistoryTableMap::COL_AMEX, $this->amex);
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_DINERS)) {
            $criteria->add(CreditCardHistoryTableMap::COL_DINERS, $this->diners);
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_AFILLIATE_LINK)) {
            $criteria->add(CreditCardHistoryTableMap::COL_AFILLIATE_LINK, $this->afilliate_link);
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_AFFILIATE_ID)) {
            $criteria->add(CreditCardHistoryTableMap::COL_AFFILIATE_ID, $this->affiliate_id);
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_TIME_BEG)) {
            $criteria->add(CreditCardHistoryTableMap::COL_TIME_BEG, $this->time_beg);
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_TIME_END)) {
            $criteria->add(CreditCardHistoryTableMap::COL_TIME_END, $this->time_end);
        }
        if ($this->isColumnModified(CreditCardHistoryTableMap::COL_UPDATE_USER)) {
            $criteria->add(CreditCardHistoryTableMap::COL_UPDATE_USER, $this->update_user);
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
        $criteria = ChildCreditCardHistoryQuery::create();
        $criteria->add(CreditCardHistoryTableMap::COL_CREDIT_CARD_ID, $this->credit_card_id);
        $criteria->add(CreditCardHistoryTableMap::COL_TIME_BEG, $this->time_beg);

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
        $validPk = null !== $this->getCreditCardId() &&
            null !== $this->getTimeBeg();

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
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getCreditCardId();
        $pks[1] = $this->getTimeBeg();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setCreditCardId($keys[0]);
        $this->setTimeBeg($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getCreditCardId()) && (null === $this->getTimeBeg());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \CreditCardHistory (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCreditCardId($this->getCreditCardId());
        $copyObj->setName($this->getName());
        $copyObj->setIssuerId($this->getIssuerId());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setImageLink($this->getImageLink());
        $copyObj->setVisa($this->getVisa());
        $copyObj->setMaster($this->getMaster());
        $copyObj->setJcb($this->getJcb());
        $copyObj->setAmex($this->getAmex());
        $copyObj->setDiners($this->getDiners());
        $copyObj->setAfilliateLink($this->getAfilliateLink());
        $copyObj->setAffiliateId($this->getAffiliateId());
        $copyObj->setTimeBeg($this->getTimeBeg());
        $copyObj->setTimeEnd($this->getTimeEnd());
        $copyObj->setUpdateUser($this->getUpdateUser());
        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @return \CreditCardHistory Clone of current object.
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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->credit_card_id = null;
        $this->name = null;
        $this->issuer_id = null;
        $this->description = null;
        $this->image_link = null;
        $this->visa = null;
        $this->master = null;
        $this->jcb = null;
        $this->amex = null;
        $this->diners = null;
        $this->afilliate_link = null;
        $this->affiliate_id = null;
        $this->time_beg = null;
        $this->time_end = null;
        $this->update_user = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
        } // if ($deep)

    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CreditCardHistoryTableMap::DEFAULT_STRING_FORMAT);
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

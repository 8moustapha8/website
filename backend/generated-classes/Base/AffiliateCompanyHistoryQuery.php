<?php

namespace Base;

use \AffiliateCompanyHistory as ChildAffiliateCompanyHistory;
use \AffiliateCompanyHistoryQuery as ChildAffiliateCompanyHistoryQuery;
use \Exception;
use \PDO;
use Map\AffiliateCompanyHistoryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'affiliate_company_history' table.
 *
 *
 *
 * @method     ChildAffiliateCompanyHistoryQuery orderByAffiliateId($order = Criteria::ASC) Order by the affiliate_id column
 * @method     ChildAffiliateCompanyHistoryQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildAffiliateCompanyHistoryQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildAffiliateCompanyHistoryQuery orderByWebsite($order = Criteria::ASC) Order by the website column
 * @method     ChildAffiliateCompanyHistoryQuery orderBySignedUpDate($order = Criteria::ASC) Order by the signed_up_date column
 * @method     ChildAffiliateCompanyHistoryQuery orderByTimeBeg($order = Criteria::ASC) Order by the time_beg column
 * @method     ChildAffiliateCompanyHistoryQuery orderByTimeEnd($order = Criteria::ASC) Order by the time_end column
 * @method     ChildAffiliateCompanyHistoryQuery orderByUpdateUser($order = Criteria::ASC) Order by the update_user column
 *
 * @method     ChildAffiliateCompanyHistoryQuery groupByAffiliateId() Group by the affiliate_id column
 * @method     ChildAffiliateCompanyHistoryQuery groupByName() Group by the name column
 * @method     ChildAffiliateCompanyHistoryQuery groupByDescription() Group by the description column
 * @method     ChildAffiliateCompanyHistoryQuery groupByWebsite() Group by the website column
 * @method     ChildAffiliateCompanyHistoryQuery groupBySignedUpDate() Group by the signed_up_date column
 * @method     ChildAffiliateCompanyHistoryQuery groupByTimeBeg() Group by the time_beg column
 * @method     ChildAffiliateCompanyHistoryQuery groupByTimeEnd() Group by the time_end column
 * @method     ChildAffiliateCompanyHistoryQuery groupByUpdateUser() Group by the update_user column
 *
 * @method     ChildAffiliateCompanyHistoryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAffiliateCompanyHistoryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAffiliateCompanyHistoryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAffiliateCompanyHistory findOne(ConnectionInterface $con = null) Return the first ChildAffiliateCompanyHistory matching the query
 * @method     ChildAffiliateCompanyHistory findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAffiliateCompanyHistory matching the query, or a new ChildAffiliateCompanyHistory object populated from the query conditions when no match is found
 *
 * @method     ChildAffiliateCompanyHistory findOneByAffiliateId(int $affiliate_id) Return the first ChildAffiliateCompanyHistory filtered by the affiliate_id column
 * @method     ChildAffiliateCompanyHistory findOneByName(string $name) Return the first ChildAffiliateCompanyHistory filtered by the name column
 * @method     ChildAffiliateCompanyHistory findOneByDescription(string $description) Return the first ChildAffiliateCompanyHistory filtered by the description column
 * @method     ChildAffiliateCompanyHistory findOneByWebsite(string $website) Return the first ChildAffiliateCompanyHistory filtered by the website column
 * @method     ChildAffiliateCompanyHistory findOneBySignedUpDate(string $signed_up_date) Return the first ChildAffiliateCompanyHistory filtered by the signed_up_date column
 * @method     ChildAffiliateCompanyHistory findOneByTimeBeg(string $time_beg) Return the first ChildAffiliateCompanyHistory filtered by the time_beg column
 * @method     ChildAffiliateCompanyHistory findOneByTimeEnd(string $time_end) Return the first ChildAffiliateCompanyHistory filtered by the time_end column
 * @method     ChildAffiliateCompanyHistory findOneByUpdateUser(string $update_user) Return the first ChildAffiliateCompanyHistory filtered by the update_user column
 *
 * @method     ChildAffiliateCompanyHistory[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAffiliateCompanyHistory objects based on current ModelCriteria
 * @method     ChildAffiliateCompanyHistory[]|ObjectCollection findByAffiliateId(int $affiliate_id) Return ChildAffiliateCompanyHistory objects filtered by the affiliate_id column
 * @method     ChildAffiliateCompanyHistory[]|ObjectCollection findByName(string $name) Return ChildAffiliateCompanyHistory objects filtered by the name column
 * @method     ChildAffiliateCompanyHistory[]|ObjectCollection findByDescription(string $description) Return ChildAffiliateCompanyHistory objects filtered by the description column
 * @method     ChildAffiliateCompanyHistory[]|ObjectCollection findByWebsite(string $website) Return ChildAffiliateCompanyHistory objects filtered by the website column
 * @method     ChildAffiliateCompanyHistory[]|ObjectCollection findBySignedUpDate(string $signed_up_date) Return ChildAffiliateCompanyHistory objects filtered by the signed_up_date column
 * @method     ChildAffiliateCompanyHistory[]|ObjectCollection findByTimeBeg(string $time_beg) Return ChildAffiliateCompanyHistory objects filtered by the time_beg column
 * @method     ChildAffiliateCompanyHistory[]|ObjectCollection findByTimeEnd(string $time_end) Return ChildAffiliateCompanyHistory objects filtered by the time_end column
 * @method     ChildAffiliateCompanyHistory[]|ObjectCollection findByUpdateUser(string $update_user) Return ChildAffiliateCompanyHistory objects filtered by the update_user column
 * @method     ChildAffiliateCompanyHistory[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AffiliateCompanyHistoryQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\AffiliateCompanyHistoryQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\AffiliateCompanyHistory', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAffiliateCompanyHistoryQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAffiliateCompanyHistoryQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAffiliateCompanyHistoryQuery) {
            return $criteria;
        }
        $query = new ChildAffiliateCompanyHistoryQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$affiliate_id, $time_beg] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAffiliateCompanyHistory|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AffiliateCompanyHistoryTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AffiliateCompanyHistoryTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAffiliateCompanyHistory A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT affiliate_id, name, description, website, signed_up_date, time_beg, time_end, update_user FROM affiliate_company_history WHERE affiliate_id = :p0 AND time_beg = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1] ? $key[1]->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildAffiliateCompanyHistory $obj */
            $obj = new ChildAffiliateCompanyHistory();
            $obj->hydrate($row);
            AffiliateCompanyHistoryTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildAffiliateCompanyHistory|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildAffiliateCompanyHistoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(AffiliateCompanyHistoryTableMap::COL_AFFILIATE_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(AffiliateCompanyHistoryTableMap::COL_TIME_BEG, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAffiliateCompanyHistoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(AffiliateCompanyHistoryTableMap::COL_AFFILIATE_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(AffiliateCompanyHistoryTableMap::COL_TIME_BEG, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the affiliate_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAffiliateId(1234); // WHERE affiliate_id = 1234
     * $query->filterByAffiliateId(array(12, 34)); // WHERE affiliate_id IN (12, 34)
     * $query->filterByAffiliateId(array('min' => 12)); // WHERE affiliate_id > 12
     * </code>
     *
     * @param     mixed $affiliateId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAffiliateCompanyHistoryQuery The current query, for fluid interface
     */
    public function filterByAffiliateId($affiliateId = null, $comparison = null)
    {
        if (is_array($affiliateId)) {
            $useMinMax = false;
            if (isset($affiliateId['min'])) {
                $this->addUsingAlias(AffiliateCompanyHistoryTableMap::COL_AFFILIATE_ID, $affiliateId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($affiliateId['max'])) {
                $this->addUsingAlias(AffiliateCompanyHistoryTableMap::COL_AFFILIATE_ID, $affiliateId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AffiliateCompanyHistoryTableMap::COL_AFFILIATE_ID, $affiliateId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAffiliateCompanyHistoryQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AffiliateCompanyHistoryTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAffiliateCompanyHistoryQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AffiliateCompanyHistoryTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the website column
     *
     * Example usage:
     * <code>
     * $query->filterByWebsite('fooValue');   // WHERE website = 'fooValue'
     * $query->filterByWebsite('%fooValue%'); // WHERE website LIKE '%fooValue%'
     * </code>
     *
     * @param     string $website The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAffiliateCompanyHistoryQuery The current query, for fluid interface
     */
    public function filterByWebsite($website = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($website)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $website)) {
                $website = str_replace('*', '%', $website);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AffiliateCompanyHistoryTableMap::COL_WEBSITE, $website, $comparison);
    }

    /**
     * Filter the query on the signed_up_date column
     *
     * Example usage:
     * <code>
     * $query->filterBySignedUpDate('2011-03-14'); // WHERE signed_up_date = '2011-03-14'
     * $query->filterBySignedUpDate('now'); // WHERE signed_up_date = '2011-03-14'
     * $query->filterBySignedUpDate(array('max' => 'yesterday')); // WHERE signed_up_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $signedUpDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAffiliateCompanyHistoryQuery The current query, for fluid interface
     */
    public function filterBySignedUpDate($signedUpDate = null, $comparison = null)
    {
        if (is_array($signedUpDate)) {
            $useMinMax = false;
            if (isset($signedUpDate['min'])) {
                $this->addUsingAlias(AffiliateCompanyHistoryTableMap::COL_SIGNED_UP_DATE, $signedUpDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($signedUpDate['max'])) {
                $this->addUsingAlias(AffiliateCompanyHistoryTableMap::COL_SIGNED_UP_DATE, $signedUpDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AffiliateCompanyHistoryTableMap::COL_SIGNED_UP_DATE, $signedUpDate, $comparison);
    }

    /**
     * Filter the query on the time_beg column
     *
     * Example usage:
     * <code>
     * $query->filterByTimeBeg('2011-03-14'); // WHERE time_beg = '2011-03-14'
     * $query->filterByTimeBeg('now'); // WHERE time_beg = '2011-03-14'
     * $query->filterByTimeBeg(array('max' => 'yesterday')); // WHERE time_beg > '2011-03-13'
     * </code>
     *
     * @param     mixed $timeBeg The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAffiliateCompanyHistoryQuery The current query, for fluid interface
     */
    public function filterByTimeBeg($timeBeg = null, $comparison = null)
    {
        if (is_array($timeBeg)) {
            $useMinMax = false;
            if (isset($timeBeg['min'])) {
                $this->addUsingAlias(AffiliateCompanyHistoryTableMap::COL_TIME_BEG, $timeBeg['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timeBeg['max'])) {
                $this->addUsingAlias(AffiliateCompanyHistoryTableMap::COL_TIME_BEG, $timeBeg['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AffiliateCompanyHistoryTableMap::COL_TIME_BEG, $timeBeg, $comparison);
    }

    /**
     * Filter the query on the time_end column
     *
     * Example usage:
     * <code>
     * $query->filterByTimeEnd('2011-03-14'); // WHERE time_end = '2011-03-14'
     * $query->filterByTimeEnd('now'); // WHERE time_end = '2011-03-14'
     * $query->filterByTimeEnd(array('max' => 'yesterday')); // WHERE time_end > '2011-03-13'
     * </code>
     *
     * @param     mixed $timeEnd The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAffiliateCompanyHistoryQuery The current query, for fluid interface
     */
    public function filterByTimeEnd($timeEnd = null, $comparison = null)
    {
        if (is_array($timeEnd)) {
            $useMinMax = false;
            if (isset($timeEnd['min'])) {
                $this->addUsingAlias(AffiliateCompanyHistoryTableMap::COL_TIME_END, $timeEnd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timeEnd['max'])) {
                $this->addUsingAlias(AffiliateCompanyHistoryTableMap::COL_TIME_END, $timeEnd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AffiliateCompanyHistoryTableMap::COL_TIME_END, $timeEnd, $comparison);
    }

    /**
     * Filter the query on the update_user column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateUser('fooValue');   // WHERE update_user = 'fooValue'
     * $query->filterByUpdateUser('%fooValue%'); // WHERE update_user LIKE '%fooValue%'
     * </code>
     *
     * @param     string $updateUser The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAffiliateCompanyHistoryQuery The current query, for fluid interface
     */
    public function filterByUpdateUser($updateUser = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($updateUser)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $updateUser)) {
                $updateUser = str_replace('*', '%', $updateUser);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AffiliateCompanyHistoryTableMap::COL_UPDATE_USER, $updateUser, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAffiliateCompanyHistory $affiliateCompanyHistory Object to remove from the list of results
     *
     * @return $this|ChildAffiliateCompanyHistoryQuery The current query, for fluid interface
     */
    public function prune($affiliateCompanyHistory = null)
    {
        if ($affiliateCompanyHistory) {
            $this->addCond('pruneCond0', $this->getAliasedColName(AffiliateCompanyHistoryTableMap::COL_AFFILIATE_ID), $affiliateCompanyHistory->getAffiliateId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(AffiliateCompanyHistoryTableMap::COL_TIME_BEG), $affiliateCompanyHistory->getTimeBeg(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the affiliate_company_history table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AffiliateCompanyHistoryTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AffiliateCompanyHistoryTableMap::clearInstancePool();
            AffiliateCompanyHistoryTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AffiliateCompanyHistoryTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AffiliateCompanyHistoryTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AffiliateCompanyHistoryTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AffiliateCompanyHistoryTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AffiliateCompanyHistoryQuery

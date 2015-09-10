<?php

namespace Base;

use \Persona as ChildPersona;
use \PersonaQuery as ChildPersonaQuery;
use \Exception;
use \PDO;
use Map\PersonaTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'persona' table.
 *
 *
 *
 * @method     ChildPersonaQuery orderByPersonaId($order = Criteria::ASC) Order by the persona_id column
 * @method     ChildPersonaQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildPersonaQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildPersonaQuery orderByUpdateTime($order = Criteria::ASC) Order by the update_time column
 * @method     ChildPersonaQuery orderByUpdateUser($order = Criteria::ASC) Order by the update_user column
 *
 * @method     ChildPersonaQuery groupByPersonaId() Group by the persona_id column
 * @method     ChildPersonaQuery groupByName() Group by the name column
 * @method     ChildPersonaQuery groupByDescription() Group by the description column
 * @method     ChildPersonaQuery groupByUpdateTime() Group by the update_time column
 * @method     ChildPersonaQuery groupByUpdateUser() Group by the update_user column
 *
 * @method     ChildPersonaQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPersonaQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPersonaQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPersonaQuery leftJoinMapPersonaScene($relationAlias = null) Adds a LEFT JOIN clause to the query using the MapPersonaScene relation
 * @method     ChildPersonaQuery rightJoinMapPersonaScene($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MapPersonaScene relation
 * @method     ChildPersonaQuery innerJoinMapPersonaScene($relationAlias = null) Adds a INNER JOIN clause to the query using the MapPersonaScene relation
 *
 * @method     \MapPersonaSceneQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPersona findOne(ConnectionInterface $con = null) Return the first ChildPersona matching the query
 * @method     ChildPersona findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPersona matching the query, or a new ChildPersona object populated from the query conditions when no match is found
 *
 * @method     ChildPersona findOneByPersonaId(int $persona_id) Return the first ChildPersona filtered by the persona_id column
 * @method     ChildPersona findOneByName(string $name) Return the first ChildPersona filtered by the name column
 * @method     ChildPersona findOneByDescription(string $description) Return the first ChildPersona filtered by the description column
 * @method     ChildPersona findOneByUpdateTime(string $update_time) Return the first ChildPersona filtered by the update_time column
 * @method     ChildPersona findOneByUpdateUser(string $update_user) Return the first ChildPersona filtered by the update_user column
 *
 * @method     ChildPersona[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPersona objects based on current ModelCriteria
 * @method     ChildPersona[]|ObjectCollection findByPersonaId(int $persona_id) Return ChildPersona objects filtered by the persona_id column
 * @method     ChildPersona[]|ObjectCollection findByName(string $name) Return ChildPersona objects filtered by the name column
 * @method     ChildPersona[]|ObjectCollection findByDescription(string $description) Return ChildPersona objects filtered by the description column
 * @method     ChildPersona[]|ObjectCollection findByUpdateTime(string $update_time) Return ChildPersona objects filtered by the update_time column
 * @method     ChildPersona[]|ObjectCollection findByUpdateUser(string $update_user) Return ChildPersona objects filtered by the update_user column
 * @method     ChildPersona[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PersonaQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\PersonaQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Persona', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPersonaQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPersonaQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPersonaQuery) {
            return $criteria;
        }
        $query = new ChildPersonaQuery();
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPersona|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PersonaTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PersonaTableMap::DATABASE_NAME);
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
     * @return ChildPersona A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT persona_id, name, description, update_time, update_user FROM persona WHERE persona_id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildPersona $obj */
            $obj = new ChildPersona();
            $obj->hydrate($row);
            PersonaTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPersona|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(12, 56, 832), $con);
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
     * @return $this|ChildPersonaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PersonaTableMap::COL_PERSONA_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPersonaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PersonaTableMap::COL_PERSONA_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the persona_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPersonaId(1234); // WHERE persona_id = 1234
     * $query->filterByPersonaId(array(12, 34)); // WHERE persona_id IN (12, 34)
     * $query->filterByPersonaId(array('min' => 12)); // WHERE persona_id > 12
     * </code>
     *
     * @param     mixed $personaId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersonaQuery The current query, for fluid interface
     */
    public function filterByPersonaId($personaId = null, $comparison = null)
    {
        if (is_array($personaId)) {
            $useMinMax = false;
            if (isset($personaId['min'])) {
                $this->addUsingAlias(PersonaTableMap::COL_PERSONA_ID, $personaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($personaId['max'])) {
                $this->addUsingAlias(PersonaTableMap::COL_PERSONA_ID, $personaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersonaTableMap::COL_PERSONA_ID, $personaId, $comparison);
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
     * @return $this|ChildPersonaQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PersonaTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildPersonaQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PersonaTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the update_time column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateTime('2011-03-14'); // WHERE update_time = '2011-03-14'
     * $query->filterByUpdateTime('now'); // WHERE update_time = '2011-03-14'
     * $query->filterByUpdateTime(array('max' => 'yesterday')); // WHERE update_time > '2011-03-13'
     * </code>
     *
     * @param     mixed $updateTime The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersonaQuery The current query, for fluid interface
     */
    public function filterByUpdateTime($updateTime = null, $comparison = null)
    {
        if (is_array($updateTime)) {
            $useMinMax = false;
            if (isset($updateTime['min'])) {
                $this->addUsingAlias(PersonaTableMap::COL_UPDATE_TIME, $updateTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updateTime['max'])) {
                $this->addUsingAlias(PersonaTableMap::COL_UPDATE_TIME, $updateTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersonaTableMap::COL_UPDATE_TIME, $updateTime, $comparison);
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
     * @return $this|ChildPersonaQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PersonaTableMap::COL_UPDATE_USER, $updateUser, $comparison);
    }

    /**
     * Filter the query by a related \MapPersonaScene object
     *
     * @param \MapPersonaScene|ObjectCollection $mapPersonaScene  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPersonaQuery The current query, for fluid interface
     */
    public function filterByMapPersonaScene($mapPersonaScene, $comparison = null)
    {
        if ($mapPersonaScene instanceof \MapPersonaScene) {
            return $this
                ->addUsingAlias(PersonaTableMap::COL_PERSONA_ID, $mapPersonaScene->getPersonaId(), $comparison);
        } elseif ($mapPersonaScene instanceof ObjectCollection) {
            return $this
                ->useMapPersonaSceneQuery()
                ->filterByPrimaryKeys($mapPersonaScene->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMapPersonaScene() only accepts arguments of type \MapPersonaScene or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MapPersonaScene relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPersonaQuery The current query, for fluid interface
     */
    public function joinMapPersonaScene($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MapPersonaScene');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'MapPersonaScene');
        }

        return $this;
    }

    /**
     * Use the MapPersonaScene relation MapPersonaScene object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MapPersonaSceneQuery A secondary query class using the current class as primary query
     */
    public function useMapPersonaSceneQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMapPersonaScene($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MapPersonaScene', '\MapPersonaSceneQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPersona $persona Object to remove from the list of results
     *
     * @return $this|ChildPersonaQuery The current query, for fluid interface
     */
    public function prune($persona = null)
    {
        if ($persona) {
            $this->addUsingAlias(PersonaTableMap::COL_PERSONA_ID, $persona->getPersonaId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the persona table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PersonaTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PersonaTableMap::clearInstancePool();
            PersonaTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PersonaTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PersonaTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PersonaTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PersonaTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PersonaQuery
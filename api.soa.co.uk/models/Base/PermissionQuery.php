<?php

namespace Base;

use \Permission as ChildPermission;
use \PermissionQuery as ChildPermissionQuery;
use \Exception;
use \PDO;
use Map\PermissionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'permission' table.
 *
 *
 *
 * @method     ChildPermissionQuery orderByPermissionid($order = Criteria::ASC) Order by the PermissionID column
 * @method     ChildPermissionQuery orderByName($order = Criteria::ASC) Order by the Name column
 * @method     ChildPermissionQuery orderByAdmin($order = Criteria::ASC) Order by the Admin column
 * @method     ChildPermissionQuery orderByDelted($order = Criteria::ASC) Order by the delted column
 *
 * @method     ChildPermissionQuery groupByPermissionid() Group by the PermissionID column
 * @method     ChildPermissionQuery groupByName() Group by the Name column
 * @method     ChildPermissionQuery groupByAdmin() Group by the Admin column
 * @method     ChildPermissionQuery groupByDelted() Group by the delted column
 *
 * @method     ChildPermissionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPermissionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPermissionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPermissionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPermissionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPermissionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPermissionQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildPermissionQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildPermissionQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildPermissionQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildPermissionQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildPermissionQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildPermissionQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     \UserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPermission findOne(ConnectionInterface $con = null) Return the first ChildPermission matching the query
 * @method     ChildPermission findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPermission matching the query, or a new ChildPermission object populated from the query conditions when no match is found
 *
 * @method     ChildPermission findOneByPermissionid(int $PermissionID) Return the first ChildPermission filtered by the PermissionID column
 * @method     ChildPermission findOneByName(string $Name) Return the first ChildPermission filtered by the Name column
 * @method     ChildPermission findOneByAdmin(boolean $Admin) Return the first ChildPermission filtered by the Admin column
 * @method     ChildPermission findOneByDelted(boolean $delted) Return the first ChildPermission filtered by the delted column *

 * @method     ChildPermission requirePk($key, ConnectionInterface $con = null) Return the ChildPermission by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPermission requireOne(ConnectionInterface $con = null) Return the first ChildPermission matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPermission requireOneByPermissionid(int $PermissionID) Return the first ChildPermission filtered by the PermissionID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPermission requireOneByName(string $Name) Return the first ChildPermission filtered by the Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPermission requireOneByAdmin(boolean $Admin) Return the first ChildPermission filtered by the Admin column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPermission requireOneByDelted(boolean $delted) Return the first ChildPermission filtered by the delted column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPermission[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPermission objects based on current ModelCriteria
 * @method     ChildPermission[]|ObjectCollection findByPermissionid(int $PermissionID) Return ChildPermission objects filtered by the PermissionID column
 * @method     ChildPermission[]|ObjectCollection findByName(string $Name) Return ChildPermission objects filtered by the Name column
 * @method     ChildPermission[]|ObjectCollection findByAdmin(boolean $Admin) Return ChildPermission objects filtered by the Admin column
 * @method     ChildPermission[]|ObjectCollection findByDelted(boolean $delted) Return ChildPermission objects filtered by the delted column
 * @method     ChildPermission[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PermissionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PermissionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Permission', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPermissionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPermissionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPermissionQuery) {
            return $criteria;
        }
        $query = new ChildPermissionQuery();
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
     * @return ChildPermission|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PermissionTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PermissionTableMap::DATABASE_NAME);
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
     * @return ChildPermission A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT PermissionID, Name, Admin, delted FROM permission WHERE PermissionID = :p0';
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
            /** @var ChildPermission $obj */
            $obj = new ChildPermission();
            $obj->hydrate($row);
            PermissionTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPermission|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPermissionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PermissionTableMap::COL_PERMISSIONID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPermissionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PermissionTableMap::COL_PERMISSIONID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the PermissionID column
     *
     * Example usage:
     * <code>
     * $query->filterByPermissionid(1234); // WHERE PermissionID = 1234
     * $query->filterByPermissionid(array(12, 34)); // WHERE PermissionID IN (12, 34)
     * $query->filterByPermissionid(array('min' => 12)); // WHERE PermissionID > 12
     * </code>
     *
     * @param     mixed $permissionid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPermissionQuery The current query, for fluid interface
     */
    public function filterByPermissionid($permissionid = null, $comparison = null)
    {
        if (is_array($permissionid)) {
            $useMinMax = false;
            if (isset($permissionid['min'])) {
                $this->addUsingAlias(PermissionTableMap::COL_PERMISSIONID, $permissionid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($permissionid['max'])) {
                $this->addUsingAlias(PermissionTableMap::COL_PERMISSIONID, $permissionid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PermissionTableMap::COL_PERMISSIONID, $permissionid, $comparison);
    }

    /**
     * Filter the query on the Name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE Name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE Name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPermissionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PermissionTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the Admin column
     *
     * Example usage:
     * <code>
     * $query->filterByAdmin(true); // WHERE Admin = true
     * $query->filterByAdmin('yes'); // WHERE Admin = true
     * </code>
     *
     * @param     boolean|string $admin The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPermissionQuery The current query, for fluid interface
     */
    public function filterByAdmin($admin = null, $comparison = null)
    {
        if (is_string($admin)) {
            $admin = in_array(strtolower($admin), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PermissionTableMap::COL_ADMIN, $admin, $comparison);
    }

    /**
     * Filter the query on the delted column
     *
     * Example usage:
     * <code>
     * $query->filterByDelted(true); // WHERE delted = true
     * $query->filterByDelted('yes'); // WHERE delted = true
     * </code>
     *
     * @param     boolean|string $delted The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPermissionQuery The current query, for fluid interface
     */
    public function filterByDelted($delted = null, $comparison = null)
    {
        if (is_string($delted)) {
            $delted = in_array(strtolower($delted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PermissionTableMap::COL_DELTED, $delted, $comparison);
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPermissionQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(PermissionTableMap::COL_PERMISSIONID, $user->getPermissionid(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            return $this
                ->useUserQuery()
                ->filterByPrimaryKeys($user->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPermissionQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\UserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPermission $permission Object to remove from the list of results
     *
     * @return $this|ChildPermissionQuery The current query, for fluid interface
     */
    public function prune($permission = null)
    {
        if ($permission) {
            $this->addUsingAlias(PermissionTableMap::COL_PERMISSIONID, $permission->getPermissionid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the permission table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PermissionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PermissionTableMap::clearInstancePool();
            PermissionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PermissionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PermissionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PermissionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PermissionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PermissionQuery

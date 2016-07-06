<?php

namespace Base;

use \Location as ChildLocation;
use \LocationQuery as ChildLocationQuery;
use \Exception;
use \PDO;
use Map\LocationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'location' table.
 *
 *
 *
 * @method     ChildLocationQuery orderByLocationid($order = Criteria::ASC) Order by the LocationID column
 * @method     ChildLocationQuery orderByAddressline($order = Criteria::ASC) Order by the AddressLine column
 * @method     ChildLocationQuery orderByTowncity($order = Criteria::ASC) Order by the TownCity column
 * @method     ChildLocationQuery orderByCountry($order = Criteria::ASC) Order by the Country column
 * @method     ChildLocationQuery orderByDelted($order = Criteria::ASC) Order by the delted column
 * @method     ChildLocationQuery orderByPostcode($order = Criteria::ASC) Order by the Postcode column
 *
 * @method     ChildLocationQuery groupByLocationid() Group by the LocationID column
 * @method     ChildLocationQuery groupByAddressline() Group by the AddressLine column
 * @method     ChildLocationQuery groupByTowncity() Group by the TownCity column
 * @method     ChildLocationQuery groupByCountry() Group by the Country column
 * @method     ChildLocationQuery groupByDelted() Group by the delted column
 * @method     ChildLocationQuery groupByPostcode() Group by the Postcode column
 *
 * @method     ChildLocationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildLocationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildLocationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildLocationQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildLocationQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildLocationQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildLocationQuery leftJoinCompany($relationAlias = null) Adds a LEFT JOIN clause to the query using the Company relation
 * @method     ChildLocationQuery rightJoinCompany($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Company relation
 * @method     ChildLocationQuery innerJoinCompany($relationAlias = null) Adds a INNER JOIN clause to the query using the Company relation
 *
 * @method     ChildLocationQuery joinWithCompany($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Company relation
 *
 * @method     ChildLocationQuery leftJoinWithCompany() Adds a LEFT JOIN clause and with to the query using the Company relation
 * @method     ChildLocationQuery rightJoinWithCompany() Adds a RIGHT JOIN clause and with to the query using the Company relation
 * @method     ChildLocationQuery innerJoinWithCompany() Adds a INNER JOIN clause and with to the query using the Company relation
 *
 * @method     ChildLocationQuery leftJoinVendingmachine($relationAlias = null) Adds a LEFT JOIN clause to the query using the Vendingmachine relation
 * @method     ChildLocationQuery rightJoinVendingmachine($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Vendingmachine relation
 * @method     ChildLocationQuery innerJoinVendingmachine($relationAlias = null) Adds a INNER JOIN clause to the query using the Vendingmachine relation
 *
 * @method     ChildLocationQuery joinWithVendingmachine($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Vendingmachine relation
 *
 * @method     ChildLocationQuery leftJoinWithVendingmachine() Adds a LEFT JOIN clause and with to the query using the Vendingmachine relation
 * @method     ChildLocationQuery rightJoinWithVendingmachine() Adds a RIGHT JOIN clause and with to the query using the Vendingmachine relation
 * @method     ChildLocationQuery innerJoinWithVendingmachine() Adds a INNER JOIN clause and with to the query using the Vendingmachine relation
 *
 * @method     \CompanyQuery|\VendingmachineQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildLocation findOne(ConnectionInterface $con = null) Return the first ChildLocation matching the query
 * @method     ChildLocation findOneOrCreate(ConnectionInterface $con = null) Return the first ChildLocation matching the query, or a new ChildLocation object populated from the query conditions when no match is found
 *
 * @method     ChildLocation findOneByLocationid(int $LocationID) Return the first ChildLocation filtered by the LocationID column
 * @method     ChildLocation findOneByAddressline(string $AddressLine) Return the first ChildLocation filtered by the AddressLine column
 * @method     ChildLocation findOneByTowncity(string $TownCity) Return the first ChildLocation filtered by the TownCity column
 * @method     ChildLocation findOneByCountry(string $Country) Return the first ChildLocation filtered by the Country column
 * @method     ChildLocation findOneByDelted(boolean $delted) Return the first ChildLocation filtered by the delted column
 * @method     ChildLocation findOneByPostcode(string $Postcode) Return the first ChildLocation filtered by the Postcode column *

 * @method     ChildLocation requirePk($key, ConnectionInterface $con = null) Return the ChildLocation by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLocation requireOne(ConnectionInterface $con = null) Return the first ChildLocation matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLocation requireOneByLocationid(int $LocationID) Return the first ChildLocation filtered by the LocationID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLocation requireOneByAddressline(string $AddressLine) Return the first ChildLocation filtered by the AddressLine column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLocation requireOneByTowncity(string $TownCity) Return the first ChildLocation filtered by the TownCity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLocation requireOneByCountry(string $Country) Return the first ChildLocation filtered by the Country column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLocation requireOneByDelted(boolean $delted) Return the first ChildLocation filtered by the delted column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLocation requireOneByPostcode(string $Postcode) Return the first ChildLocation filtered by the Postcode column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLocation[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildLocation objects based on current ModelCriteria
 * @method     ChildLocation[]|ObjectCollection findByLocationid(int $LocationID) Return ChildLocation objects filtered by the LocationID column
 * @method     ChildLocation[]|ObjectCollection findByAddressline(string $AddressLine) Return ChildLocation objects filtered by the AddressLine column
 * @method     ChildLocation[]|ObjectCollection findByTowncity(string $TownCity) Return ChildLocation objects filtered by the TownCity column
 * @method     ChildLocation[]|ObjectCollection findByCountry(string $Country) Return ChildLocation objects filtered by the Country column
 * @method     ChildLocation[]|ObjectCollection findByDelted(boolean $delted) Return ChildLocation objects filtered by the delted column
 * @method     ChildLocation[]|ObjectCollection findByPostcode(string $Postcode) Return ChildLocation objects filtered by the Postcode column
 * @method     ChildLocation[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class LocationQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\LocationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Location', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildLocationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildLocationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildLocationQuery) {
            return $criteria;
        }
        $query = new ChildLocationQuery();
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
     * @return ChildLocation|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = LocationTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(LocationTableMap::DATABASE_NAME);
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
     * @return ChildLocation A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT LocationID, AddressLine, TownCity, Country, delted, Postcode FROM location WHERE LocationID = :p0';
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
            /** @var ChildLocation $obj */
            $obj = new ChildLocation();
            $obj->hydrate($row);
            LocationTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildLocation|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(LocationTableMap::COL_LOCATIONID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(LocationTableMap::COL_LOCATIONID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the LocationID column
     *
     * Example usage:
     * <code>
     * $query->filterByLocationid(1234); // WHERE LocationID = 1234
     * $query->filterByLocationid(array(12, 34)); // WHERE LocationID IN (12, 34)
     * $query->filterByLocationid(array('min' => 12)); // WHERE LocationID > 12
     * </code>
     *
     * @param     mixed $locationid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByLocationid($locationid = null, $comparison = null)
    {
        if (is_array($locationid)) {
            $useMinMax = false;
            if (isset($locationid['min'])) {
                $this->addUsingAlias(LocationTableMap::COL_LOCATIONID, $locationid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($locationid['max'])) {
                $this->addUsingAlias(LocationTableMap::COL_LOCATIONID, $locationid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LocationTableMap::COL_LOCATIONID, $locationid, $comparison);
    }

    /**
     * Filter the query on the AddressLine column
     *
     * Example usage:
     * <code>
     * $query->filterByAddressline('fooValue');   // WHERE AddressLine = 'fooValue'
     * $query->filterByAddressline('%fooValue%'); // WHERE AddressLine LIKE '%fooValue%'
     * </code>
     *
     * @param     string $addressline The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByAddressline($addressline = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($addressline)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $addressline)) {
                $addressline = str_replace('*', '%', $addressline);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LocationTableMap::COL_ADDRESSLINE, $addressline, $comparison);
    }

    /**
     * Filter the query on the TownCity column
     *
     * Example usage:
     * <code>
     * $query->filterByTowncity('fooValue');   // WHERE TownCity = 'fooValue'
     * $query->filterByTowncity('%fooValue%'); // WHERE TownCity LIKE '%fooValue%'
     * </code>
     *
     * @param     string $towncity The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByTowncity($towncity = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($towncity)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $towncity)) {
                $towncity = str_replace('*', '%', $towncity);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LocationTableMap::COL_TOWNCITY, $towncity, $comparison);
    }

    /**
     * Filter the query on the Country column
     *
     * Example usage:
     * <code>
     * $query->filterByCountry('fooValue');   // WHERE Country = 'fooValue'
     * $query->filterByCountry('%fooValue%'); // WHERE Country LIKE '%fooValue%'
     * </code>
     *
     * @param     string $country The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByCountry($country = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($country)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $country)) {
                $country = str_replace('*', '%', $country);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LocationTableMap::COL_COUNTRY, $country, $comparison);
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
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByDelted($delted = null, $comparison = null)
    {
        if (is_string($delted)) {
            $delted = in_array(strtolower($delted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(LocationTableMap::COL_DELTED, $delted, $comparison);
    }

    /**
     * Filter the query on the Postcode column
     *
     * Example usage:
     * <code>
     * $query->filterByPostcode('fooValue');   // WHERE Postcode = 'fooValue'
     * $query->filterByPostcode('%fooValue%'); // WHERE Postcode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $postcode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByPostcode($postcode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($postcode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $postcode)) {
                $postcode = str_replace('*', '%', $postcode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LocationTableMap::COL_POSTCODE, $postcode, $comparison);
    }

    /**
     * Filter the query by a related \Company object
     *
     * @param \Company|ObjectCollection $company the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLocationQuery The current query, for fluid interface
     */
    public function filterByCompany($company, $comparison = null)
    {
        if ($company instanceof \Company) {
            return $this
                ->addUsingAlias(LocationTableMap::COL_LOCATIONID, $company->getLocationid(), $comparison);
        } elseif ($company instanceof ObjectCollection) {
            return $this
                ->useCompanyQuery()
                ->filterByPrimaryKeys($company->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCompany() only accepts arguments of type \Company or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Company relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function joinCompany($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Company');

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
            $this->addJoinObject($join, 'Company');
        }

        return $this;
    }

    /**
     * Use the Company relation Company object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CompanyQuery A secondary query class using the current class as primary query
     */
    public function useCompanyQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCompany($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Company', '\CompanyQuery');
    }

    /**
     * Filter the query by a related \Vendingmachine object
     *
     * @param \Vendingmachine|ObjectCollection $vendingmachine the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLocationQuery The current query, for fluid interface
     */
    public function filterByVendingmachine($vendingmachine, $comparison = null)
    {
        if ($vendingmachine instanceof \Vendingmachine) {
            return $this
                ->addUsingAlias(LocationTableMap::COL_LOCATIONID, $vendingmachine->getLocationid(), $comparison);
        } elseif ($vendingmachine instanceof ObjectCollection) {
            return $this
                ->useVendingmachineQuery()
                ->filterByPrimaryKeys($vendingmachine->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByVendingmachine() only accepts arguments of type \Vendingmachine or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Vendingmachine relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function joinVendingmachine($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Vendingmachine');

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
            $this->addJoinObject($join, 'Vendingmachine');
        }

        return $this;
    }

    /**
     * Use the Vendingmachine relation Vendingmachine object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \VendingmachineQuery A secondary query class using the current class as primary query
     */
    public function useVendingmachineQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinVendingmachine($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Vendingmachine', '\VendingmachineQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildLocation $location Object to remove from the list of results
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function prune($location = null)
    {
        if ($location) {
            $this->addUsingAlias(LocationTableMap::COL_LOCATIONID, $location->getLocationid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the location table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LocationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            LocationTableMap::clearInstancePool();
            LocationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(LocationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(LocationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            LocationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            LocationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // LocationQuery

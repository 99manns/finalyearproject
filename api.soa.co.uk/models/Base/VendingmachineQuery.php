<?php

namespace Base;

use \Vendingmachine as ChildVendingmachine;
use \VendingmachineQuery as ChildVendingmachineQuery;
use \Exception;
use \PDO;
use Map\VendingmachineTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'vendingmachine' table.
 *
 *
 *
 * @method     ChildVendingmachineQuery orderByVendingmachineid($order = Criteria::ASC) Order by the vendingmachineID column
 * @method     ChildVendingmachineQuery orderByLocationid($order = Criteria::ASC) Order by the LocationID column
 * @method     ChildVendingmachineQuery orderByCompanyid($order = Criteria::ASC) Order by the CompanyID column
 * @method     ChildVendingmachineQuery orderByName($order = Criteria::ASC) Order by the Name column
 * @method     ChildVendingmachineQuery orderByDelted($order = Criteria::ASC) Order by the delted column
 *
 * @method     ChildVendingmachineQuery groupByVendingmachineid() Group by the vendingmachineID column
 * @method     ChildVendingmachineQuery groupByLocationid() Group by the LocationID column
 * @method     ChildVendingmachineQuery groupByCompanyid() Group by the CompanyID column
 * @method     ChildVendingmachineQuery groupByName() Group by the Name column
 * @method     ChildVendingmachineQuery groupByDelted() Group by the delted column
 *
 * @method     ChildVendingmachineQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildVendingmachineQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildVendingmachineQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildVendingmachineQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildVendingmachineQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildVendingmachineQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildVendingmachineQuery leftJoinCompany($relationAlias = null) Adds a LEFT JOIN clause to the query using the Company relation
 * @method     ChildVendingmachineQuery rightJoinCompany($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Company relation
 * @method     ChildVendingmachineQuery innerJoinCompany($relationAlias = null) Adds a INNER JOIN clause to the query using the Company relation
 *
 * @method     ChildVendingmachineQuery joinWithCompany($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Company relation
 *
 * @method     ChildVendingmachineQuery leftJoinWithCompany() Adds a LEFT JOIN clause and with to the query using the Company relation
 * @method     ChildVendingmachineQuery rightJoinWithCompany() Adds a RIGHT JOIN clause and with to the query using the Company relation
 * @method     ChildVendingmachineQuery innerJoinWithCompany() Adds a INNER JOIN clause and with to the query using the Company relation
 *
 * @method     ChildVendingmachineQuery leftJoinLocation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Location relation
 * @method     ChildVendingmachineQuery rightJoinLocation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Location relation
 * @method     ChildVendingmachineQuery innerJoinLocation($relationAlias = null) Adds a INNER JOIN clause to the query using the Location relation
 *
 * @method     ChildVendingmachineQuery joinWithLocation($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Location relation
 *
 * @method     ChildVendingmachineQuery leftJoinWithLocation() Adds a LEFT JOIN clause and with to the query using the Location relation
 * @method     ChildVendingmachineQuery rightJoinWithLocation() Adds a RIGHT JOIN clause and with to the query using the Location relation
 * @method     ChildVendingmachineQuery innerJoinWithLocation() Adds a INNER JOIN clause and with to the query using the Location relation
 *
 * @method     ChildVendingmachineQuery leftJoinItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the Item relation
 * @method     ChildVendingmachineQuery rightJoinItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Item relation
 * @method     ChildVendingmachineQuery innerJoinItem($relationAlias = null) Adds a INNER JOIN clause to the query using the Item relation
 *
 * @method     ChildVendingmachineQuery joinWithItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Item relation
 *
 * @method     ChildVendingmachineQuery leftJoinWithItem() Adds a LEFT JOIN clause and with to the query using the Item relation
 * @method     ChildVendingmachineQuery rightJoinWithItem() Adds a RIGHT JOIN clause and with to the query using the Item relation
 * @method     ChildVendingmachineQuery innerJoinWithItem() Adds a INNER JOIN clause and with to the query using the Item relation
 *
 * @method     ChildVendingmachineQuery leftJoinStock($relationAlias = null) Adds a LEFT JOIN clause to the query using the Stock relation
 * @method     ChildVendingmachineQuery rightJoinStock($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Stock relation
 * @method     ChildVendingmachineQuery innerJoinStock($relationAlias = null) Adds a INNER JOIN clause to the query using the Stock relation
 *
 * @method     ChildVendingmachineQuery joinWithStock($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Stock relation
 *
 * @method     ChildVendingmachineQuery leftJoinWithStock() Adds a LEFT JOIN clause and with to the query using the Stock relation
 * @method     ChildVendingmachineQuery rightJoinWithStock() Adds a RIGHT JOIN clause and with to the query using the Stock relation
 * @method     ChildVendingmachineQuery innerJoinWithStock() Adds a INNER JOIN clause and with to the query using the Stock relation
 *
 * @method     \CompanyQuery|\LocationQuery|\ItemQuery|\StockQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildVendingmachine findOne(ConnectionInterface $con = null) Return the first ChildVendingmachine matching the query
 * @method     ChildVendingmachine findOneOrCreate(ConnectionInterface $con = null) Return the first ChildVendingmachine matching the query, or a new ChildVendingmachine object populated from the query conditions when no match is found
 *
 * @method     ChildVendingmachine findOneByVendingmachineid(int $vendingmachineID) Return the first ChildVendingmachine filtered by the vendingmachineID column
 * @method     ChildVendingmachine findOneByLocationid(int $LocationID) Return the first ChildVendingmachine filtered by the LocationID column
 * @method     ChildVendingmachine findOneByCompanyid(int $CompanyID) Return the first ChildVendingmachine filtered by the CompanyID column
 * @method     ChildVendingmachine findOneByName(string $Name) Return the first ChildVendingmachine filtered by the Name column
 * @method     ChildVendingmachine findOneByDelted(boolean $delted) Return the first ChildVendingmachine filtered by the delted column *

 * @method     ChildVendingmachine requirePk($key, ConnectionInterface $con = null) Return the ChildVendingmachine by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVendingmachine requireOne(ConnectionInterface $con = null) Return the first ChildVendingmachine matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVendingmachine requireOneByVendingmachineid(int $vendingmachineID) Return the first ChildVendingmachine filtered by the vendingmachineID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVendingmachine requireOneByLocationid(int $LocationID) Return the first ChildVendingmachine filtered by the LocationID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVendingmachine requireOneByCompanyid(int $CompanyID) Return the first ChildVendingmachine filtered by the CompanyID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVendingmachine requireOneByName(string $Name) Return the first ChildVendingmachine filtered by the Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVendingmachine requireOneByDelted(boolean $delted) Return the first ChildVendingmachine filtered by the delted column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVendingmachine[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildVendingmachine objects based on current ModelCriteria
 * @method     ChildVendingmachine[]|ObjectCollection findByVendingmachineid(int $vendingmachineID) Return ChildVendingmachine objects filtered by the vendingmachineID column
 * @method     ChildVendingmachine[]|ObjectCollection findByLocationid(int $LocationID) Return ChildVendingmachine objects filtered by the LocationID column
 * @method     ChildVendingmachine[]|ObjectCollection findByCompanyid(int $CompanyID) Return ChildVendingmachine objects filtered by the CompanyID column
 * @method     ChildVendingmachine[]|ObjectCollection findByName(string $Name) Return ChildVendingmachine objects filtered by the Name column
 * @method     ChildVendingmachine[]|ObjectCollection findByDelted(boolean $delted) Return ChildVendingmachine objects filtered by the delted column
 * @method     ChildVendingmachine[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class VendingmachineQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\VendingmachineQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Vendingmachine', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildVendingmachineQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildVendingmachineQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildVendingmachineQuery) {
            return $criteria;
        }
        $query = new ChildVendingmachineQuery();
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
     * @return ChildVendingmachine|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = VendingmachineTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(VendingmachineTableMap::DATABASE_NAME);
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
     * @return ChildVendingmachine A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT vendingmachineID, LocationID, CompanyID, Name, delted FROM vendingmachine WHERE vendingmachineID = :p0';
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
            /** @var ChildVendingmachine $obj */
            $obj = new ChildVendingmachine();
            $obj->hydrate($row);
            VendingmachineTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildVendingmachine|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildVendingmachineQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(VendingmachineTableMap::COL_VENDINGMACHINEID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildVendingmachineQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(VendingmachineTableMap::COL_VENDINGMACHINEID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the vendingmachineID column
     *
     * Example usage:
     * <code>
     * $query->filterByVendingmachineid(1234); // WHERE vendingmachineID = 1234
     * $query->filterByVendingmachineid(array(12, 34)); // WHERE vendingmachineID IN (12, 34)
     * $query->filterByVendingmachineid(array('min' => 12)); // WHERE vendingmachineID > 12
     * </code>
     *
     * @param     mixed $vendingmachineid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVendingmachineQuery The current query, for fluid interface
     */
    public function filterByVendingmachineid($vendingmachineid = null, $comparison = null)
    {
        if (is_array($vendingmachineid)) {
            $useMinMax = false;
            if (isset($vendingmachineid['min'])) {
                $this->addUsingAlias(VendingmachineTableMap::COL_VENDINGMACHINEID, $vendingmachineid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($vendingmachineid['max'])) {
                $this->addUsingAlias(VendingmachineTableMap::COL_VENDINGMACHINEID, $vendingmachineid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VendingmachineTableMap::COL_VENDINGMACHINEID, $vendingmachineid, $comparison);
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
     * @see       filterByLocation()
     *
     * @param     mixed $locationid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVendingmachineQuery The current query, for fluid interface
     */
    public function filterByLocationid($locationid = null, $comparison = null)
    {
        if (is_array($locationid)) {
            $useMinMax = false;
            if (isset($locationid['min'])) {
                $this->addUsingAlias(VendingmachineTableMap::COL_LOCATIONID, $locationid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($locationid['max'])) {
                $this->addUsingAlias(VendingmachineTableMap::COL_LOCATIONID, $locationid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VendingmachineTableMap::COL_LOCATIONID, $locationid, $comparison);
    }

    /**
     * Filter the query on the CompanyID column
     *
     * Example usage:
     * <code>
     * $query->filterByCompanyid(1234); // WHERE CompanyID = 1234
     * $query->filterByCompanyid(array(12, 34)); // WHERE CompanyID IN (12, 34)
     * $query->filterByCompanyid(array('min' => 12)); // WHERE CompanyID > 12
     * </code>
     *
     * @see       filterByCompany()
     *
     * @param     mixed $companyid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVendingmachineQuery The current query, for fluid interface
     */
    public function filterByCompanyid($companyid = null, $comparison = null)
    {
        if (is_array($companyid)) {
            $useMinMax = false;
            if (isset($companyid['min'])) {
                $this->addUsingAlias(VendingmachineTableMap::COL_COMPANYID, $companyid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($companyid['max'])) {
                $this->addUsingAlias(VendingmachineTableMap::COL_COMPANYID, $companyid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VendingmachineTableMap::COL_COMPANYID, $companyid, $comparison);
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
     * @return $this|ChildVendingmachineQuery The current query, for fluid interface
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

        return $this->addUsingAlias(VendingmachineTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildVendingmachineQuery The current query, for fluid interface
     */
    public function filterByDelted($delted = null, $comparison = null)
    {
        if (is_string($delted)) {
            $delted = in_array(strtolower($delted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(VendingmachineTableMap::COL_DELTED, $delted, $comparison);
    }

    /**
     * Filter the query by a related \Company object
     *
     * @param \Company|ObjectCollection $company The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVendingmachineQuery The current query, for fluid interface
     */
    public function filterByCompany($company, $comparison = null)
    {
        if ($company instanceof \Company) {
            return $this
                ->addUsingAlias(VendingmachineTableMap::COL_COMPANYID, $company->getCompanyid(), $comparison);
        } elseif ($company instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VendingmachineTableMap::COL_COMPANYID, $company->toKeyValue('PrimaryKey', 'Companyid'), $comparison);
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
     * @return $this|ChildVendingmachineQuery The current query, for fluid interface
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
     * Filter the query by a related \Location object
     *
     * @param \Location|ObjectCollection $location The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVendingmachineQuery The current query, for fluid interface
     */
    public function filterByLocation($location, $comparison = null)
    {
        if ($location instanceof \Location) {
            return $this
                ->addUsingAlias(VendingmachineTableMap::COL_LOCATIONID, $location->getLocationid(), $comparison);
        } elseif ($location instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VendingmachineTableMap::COL_LOCATIONID, $location->toKeyValue('PrimaryKey', 'Locationid'), $comparison);
        } else {
            throw new PropelException('filterByLocation() only accepts arguments of type \Location or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Location relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildVendingmachineQuery The current query, for fluid interface
     */
    public function joinLocation($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Location');

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
            $this->addJoinObject($join, 'Location');
        }

        return $this;
    }

    /**
     * Use the Location relation Location object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \LocationQuery A secondary query class using the current class as primary query
     */
    public function useLocationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinLocation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Location', '\LocationQuery');
    }

    /**
     * Filter the query by a related \Item object
     *
     * @param \Item|ObjectCollection $item the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildVendingmachineQuery The current query, for fluid interface
     */
    public function filterByItem($item, $comparison = null)
    {
        if ($item instanceof \Item) {
            return $this
                ->addUsingAlias(VendingmachineTableMap::COL_VENDINGMACHINEID, $item->getVendingmachineid(), $comparison);
        } elseif ($item instanceof ObjectCollection) {
            return $this
                ->useItemQuery()
                ->filterByPrimaryKeys($item->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByItem() only accepts arguments of type \Item or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Item relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildVendingmachineQuery The current query, for fluid interface
     */
    public function joinItem($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Item');

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
            $this->addJoinObject($join, 'Item');
        }

        return $this;
    }

    /**
     * Use the Item relation Item object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ItemQuery A secondary query class using the current class as primary query
     */
    public function useItemQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Item', '\ItemQuery');
    }

    /**
     * Filter the query by a related \Stock object
     *
     * @param \Stock|ObjectCollection $stock the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildVendingmachineQuery The current query, for fluid interface
     */
    public function filterByStock($stock, $comparison = null)
    {
        if ($stock instanceof \Stock) {
            return $this
                ->addUsingAlias(VendingmachineTableMap::COL_VENDINGMACHINEID, $stock->getVendingmachineid(), $comparison);
        } elseif ($stock instanceof ObjectCollection) {
            return $this
                ->useStockQuery()
                ->filterByPrimaryKeys($stock->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStock() only accepts arguments of type \Stock or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Stock relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildVendingmachineQuery The current query, for fluid interface
     */
    public function joinStock($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Stock');

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
            $this->addJoinObject($join, 'Stock');
        }

        return $this;
    }

    /**
     * Use the Stock relation Stock object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \StockQuery A secondary query class using the current class as primary query
     */
    public function useStockQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStock($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Stock', '\StockQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildVendingmachine $vendingmachine Object to remove from the list of results
     *
     * @return $this|ChildVendingmachineQuery The current query, for fluid interface
     */
    public function prune($vendingmachine = null)
    {
        if ($vendingmachine) {
            $this->addUsingAlias(VendingmachineTableMap::COL_VENDINGMACHINEID, $vendingmachine->getVendingmachineid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the vendingmachine table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VendingmachineTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            VendingmachineTableMap::clearInstancePool();
            VendingmachineTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(VendingmachineTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(VendingmachineTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            VendingmachineTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            VendingmachineTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // VendingmachineQuery

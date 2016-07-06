<?php

namespace Base;

use \Company as ChildCompany;
use \CompanyQuery as ChildCompanyQuery;
use \Exception;
use \PDO;
use Map\CompanyTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'company' table.
 *
 *
 *
 * @method     ChildCompanyQuery orderByCompanyid($order = Criteria::ASC) Order by the CompanyID column
 * @method     ChildCompanyQuery orderByApikey($order = Criteria::ASC) Order by the APIkey column
 * @method     ChildCompanyQuery orderByLocationid($order = Criteria::ASC) Order by the LocationID column
 * @method     ChildCompanyQuery orderByName($order = Criteria::ASC) Order by the Name column
 * @method     ChildCompanyQuery orderByTelephone($order = Criteria::ASC) Order by the Telephone column
 * @method     ChildCompanyQuery orderByDelted($order = Criteria::ASC) Order by the delted column
 *
 * @method     ChildCompanyQuery groupByCompanyid() Group by the CompanyID column
 * @method     ChildCompanyQuery groupByApikey() Group by the APIkey column
 * @method     ChildCompanyQuery groupByLocationid() Group by the LocationID column
 * @method     ChildCompanyQuery groupByName() Group by the Name column
 * @method     ChildCompanyQuery groupByTelephone() Group by the Telephone column
 * @method     ChildCompanyQuery groupByDelted() Group by the delted column
 *
 * @method     ChildCompanyQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCompanyQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCompanyQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCompanyQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCompanyQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCompanyQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCompanyQuery leftJoinLocation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Location relation
 * @method     ChildCompanyQuery rightJoinLocation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Location relation
 * @method     ChildCompanyQuery innerJoinLocation($relationAlias = null) Adds a INNER JOIN clause to the query using the Location relation
 *
 * @method     ChildCompanyQuery joinWithLocation($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Location relation
 *
 * @method     ChildCompanyQuery leftJoinWithLocation() Adds a LEFT JOIN clause and with to the query using the Location relation
 * @method     ChildCompanyQuery rightJoinWithLocation() Adds a RIGHT JOIN clause and with to the query using the Location relation
 * @method     ChildCompanyQuery innerJoinWithLocation() Adds a INNER JOIN clause and with to the query using the Location relation
 *
 * @method     ChildCompanyQuery leftJoinOffer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Offer relation
 * @method     ChildCompanyQuery rightJoinOffer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Offer relation
 * @method     ChildCompanyQuery innerJoinOffer($relationAlias = null) Adds a INNER JOIN clause to the query using the Offer relation
 *
 * @method     ChildCompanyQuery joinWithOffer($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Offer relation
 *
 * @method     ChildCompanyQuery leftJoinWithOffer() Adds a LEFT JOIN clause and with to the query using the Offer relation
 * @method     ChildCompanyQuery rightJoinWithOffer() Adds a RIGHT JOIN clause and with to the query using the Offer relation
 * @method     ChildCompanyQuery innerJoinWithOffer() Adds a INNER JOIN clause and with to the query using the Offer relation
 *
 * @method     ChildCompanyQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildCompanyQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildCompanyQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildCompanyQuery joinWithProduct($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Product relation
 *
 * @method     ChildCompanyQuery leftJoinWithProduct() Adds a LEFT JOIN clause and with to the query using the Product relation
 * @method     ChildCompanyQuery rightJoinWithProduct() Adds a RIGHT JOIN clause and with to the query using the Product relation
 * @method     ChildCompanyQuery innerJoinWithProduct() Adds a INNER JOIN clause and with to the query using the Product relation
 *
 * @method     ChildCompanyQuery leftJoinVendingmachine($relationAlias = null) Adds a LEFT JOIN clause to the query using the Vendingmachine relation
 * @method     ChildCompanyQuery rightJoinVendingmachine($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Vendingmachine relation
 * @method     ChildCompanyQuery innerJoinVendingmachine($relationAlias = null) Adds a INNER JOIN clause to the query using the Vendingmachine relation
 *
 * @method     ChildCompanyQuery joinWithVendingmachine($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Vendingmachine relation
 *
 * @method     ChildCompanyQuery leftJoinWithVendingmachine() Adds a LEFT JOIN clause and with to the query using the Vendingmachine relation
 * @method     ChildCompanyQuery rightJoinWithVendingmachine() Adds a RIGHT JOIN clause and with to the query using the Vendingmachine relation
 * @method     ChildCompanyQuery innerJoinWithVendingmachine() Adds a INNER JOIN clause and with to the query using the Vendingmachine relation
 *
 * @method     \LocationQuery|\OfferQuery|\ProductQuery|\VendingmachineQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCompany findOne(ConnectionInterface $con = null) Return the first ChildCompany matching the query
 * @method     ChildCompany findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCompany matching the query, or a new ChildCompany object populated from the query conditions when no match is found
 *
 * @method     ChildCompany findOneByCompanyid(int $CompanyID) Return the first ChildCompany filtered by the CompanyID column
 * @method     ChildCompany findOneByApikey(string $APIkey) Return the first ChildCompany filtered by the APIkey column
 * @method     ChildCompany findOneByLocationid(int $LocationID) Return the first ChildCompany filtered by the LocationID column
 * @method     ChildCompany findOneByName(string $Name) Return the first ChildCompany filtered by the Name column
 * @method     ChildCompany findOneByTelephone(string $Telephone) Return the first ChildCompany filtered by the Telephone column
 * @method     ChildCompany findOneByDelted(boolean $delted) Return the first ChildCompany filtered by the delted column *

 * @method     ChildCompany requirePk($key, ConnectionInterface $con = null) Return the ChildCompany by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompany requireOne(ConnectionInterface $con = null) Return the first ChildCompany matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCompany requireOneByCompanyid(int $CompanyID) Return the first ChildCompany filtered by the CompanyID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompany requireOneByApikey(string $APIkey) Return the first ChildCompany filtered by the APIkey column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompany requireOneByLocationid(int $LocationID) Return the first ChildCompany filtered by the LocationID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompany requireOneByName(string $Name) Return the first ChildCompany filtered by the Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompany requireOneByTelephone(string $Telephone) Return the first ChildCompany filtered by the Telephone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompany requireOneByDelted(boolean $delted) Return the first ChildCompany filtered by the delted column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCompany[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCompany objects based on current ModelCriteria
 * @method     ChildCompany[]|ObjectCollection findByCompanyid(int $CompanyID) Return ChildCompany objects filtered by the CompanyID column
 * @method     ChildCompany[]|ObjectCollection findByApikey(string $APIkey) Return ChildCompany objects filtered by the APIkey column
 * @method     ChildCompany[]|ObjectCollection findByLocationid(int $LocationID) Return ChildCompany objects filtered by the LocationID column
 * @method     ChildCompany[]|ObjectCollection findByName(string $Name) Return ChildCompany objects filtered by the Name column
 * @method     ChildCompany[]|ObjectCollection findByTelephone(string $Telephone) Return ChildCompany objects filtered by the Telephone column
 * @method     ChildCompany[]|ObjectCollection findByDelted(boolean $delted) Return ChildCompany objects filtered by the delted column
 * @method     ChildCompany[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CompanyQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CompanyQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Company', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCompanyQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCompanyQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCompanyQuery) {
            return $criteria;
        }
        $query = new ChildCompanyQuery();
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
     * @return ChildCompany|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CompanyTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CompanyTableMap::DATABASE_NAME);
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
     * @return ChildCompany A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT CompanyID, APIkey, LocationID, Name, Telephone, delted FROM company WHERE CompanyID = :p0';
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
            /** @var ChildCompany $obj */
            $obj = new ChildCompany();
            $obj->hydrate($row);
            CompanyTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCompany|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCompanyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CompanyTableMap::COL_COMPANYID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCompanyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CompanyTableMap::COL_COMPANYID, $keys, Criteria::IN);
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
     * @param     mixed $companyid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompanyQuery The current query, for fluid interface
     */
    public function filterByCompanyid($companyid = null, $comparison = null)
    {
        if (is_array($companyid)) {
            $useMinMax = false;
            if (isset($companyid['min'])) {
                $this->addUsingAlias(CompanyTableMap::COL_COMPANYID, $companyid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($companyid['max'])) {
                $this->addUsingAlias(CompanyTableMap::COL_COMPANYID, $companyid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompanyTableMap::COL_COMPANYID, $companyid, $comparison);
    }

    /**
     * Filter the query on the APIkey column
     *
     * Example usage:
     * <code>
     * $query->filterByApikey('fooValue');   // WHERE APIkey = 'fooValue'
     * $query->filterByApikey('%fooValue%'); // WHERE APIkey LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apikey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompanyQuery The current query, for fluid interface
     */
    public function filterByApikey($apikey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apikey)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apikey)) {
                $apikey = str_replace('*', '%', $apikey);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CompanyTableMap::COL_APIKEY, $apikey, $comparison);
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
     * @return $this|ChildCompanyQuery The current query, for fluid interface
     */
    public function filterByLocationid($locationid = null, $comparison = null)
    {
        if (is_array($locationid)) {
            $useMinMax = false;
            if (isset($locationid['min'])) {
                $this->addUsingAlias(CompanyTableMap::COL_LOCATIONID, $locationid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($locationid['max'])) {
                $this->addUsingAlias(CompanyTableMap::COL_LOCATIONID, $locationid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompanyTableMap::COL_LOCATIONID, $locationid, $comparison);
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
     * @return $this|ChildCompanyQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CompanyTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the Telephone column
     *
     * Example usage:
     * <code>
     * $query->filterByTelephone('fooValue');   // WHERE Telephone = 'fooValue'
     * $query->filterByTelephone('%fooValue%'); // WHERE Telephone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $telephone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompanyQuery The current query, for fluid interface
     */
    public function filterByTelephone($telephone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($telephone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $telephone)) {
                $telephone = str_replace('*', '%', $telephone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CompanyTableMap::COL_TELEPHONE, $telephone, $comparison);
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
     * @return $this|ChildCompanyQuery The current query, for fluid interface
     */
    public function filterByDelted($delted = null, $comparison = null)
    {
        if (is_string($delted)) {
            $delted = in_array(strtolower($delted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CompanyTableMap::COL_DELTED, $delted, $comparison);
    }

    /**
     * Filter the query by a related \Location object
     *
     * @param \Location|ObjectCollection $location The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCompanyQuery The current query, for fluid interface
     */
    public function filterByLocation($location, $comparison = null)
    {
        if ($location instanceof \Location) {
            return $this
                ->addUsingAlias(CompanyTableMap::COL_LOCATIONID, $location->getLocationid(), $comparison);
        } elseif ($location instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CompanyTableMap::COL_LOCATIONID, $location->toKeyValue('PrimaryKey', 'Locationid'), $comparison);
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
     * @return $this|ChildCompanyQuery The current query, for fluid interface
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
     * Filter the query by a related \Offer object
     *
     * @param \Offer|ObjectCollection $offer the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCompanyQuery The current query, for fluid interface
     */
    public function filterByOffer($offer, $comparison = null)
    {
        if ($offer instanceof \Offer) {
            return $this
                ->addUsingAlias(CompanyTableMap::COL_COMPANYID, $offer->getCompanyid(), $comparison);
        } elseif ($offer instanceof ObjectCollection) {
            return $this
                ->useOfferQuery()
                ->filterByPrimaryKeys($offer->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByOffer() only accepts arguments of type \Offer or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Offer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCompanyQuery The current query, for fluid interface
     */
    public function joinOffer($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Offer');

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
            $this->addJoinObject($join, 'Offer');
        }

        return $this;
    }

    /**
     * Use the Offer relation Offer object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \OfferQuery A secondary query class using the current class as primary query
     */
    public function useOfferQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOffer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Offer', '\OfferQuery');
    }

    /**
     * Filter the query by a related \Product object
     *
     * @param \Product|ObjectCollection $product the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCompanyQuery The current query, for fluid interface
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof \Product) {
            return $this
                ->addUsingAlias(CompanyTableMap::COL_COMPANYID, $product->getCompanyid(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            return $this
                ->useProductQuery()
                ->filterByPrimaryKeys($product->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProduct() only accepts arguments of type \Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Product relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCompanyQuery The current query, for fluid interface
     */
    public function joinProduct($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Product');

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
            $this->addJoinObject($join, 'Product');
        }

        return $this;
    }

    /**
     * Use the Product relation Product object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Product', '\ProductQuery');
    }

    /**
     * Filter the query by a related \Vendingmachine object
     *
     * @param \Vendingmachine|ObjectCollection $vendingmachine the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCompanyQuery The current query, for fluid interface
     */
    public function filterByVendingmachine($vendingmachine, $comparison = null)
    {
        if ($vendingmachine instanceof \Vendingmachine) {
            return $this
                ->addUsingAlias(CompanyTableMap::COL_COMPANYID, $vendingmachine->getCompanyid(), $comparison);
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
     * @return $this|ChildCompanyQuery The current query, for fluid interface
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
     * @param   ChildCompany $company Object to remove from the list of results
     *
     * @return $this|ChildCompanyQuery The current query, for fluid interface
     */
    public function prune($company = null)
    {
        if ($company) {
            $this->addUsingAlias(CompanyTableMap::COL_COMPANYID, $company->getCompanyid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the company table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CompanyTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CompanyTableMap::clearInstancePool();
            CompanyTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CompanyTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CompanyTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CompanyTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CompanyTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CompanyQuery

<?php

namespace Base;

use \Offer as ChildOffer;
use \OfferQuery as ChildOfferQuery;
use \Exception;
use \PDO;
use Map\OfferTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'offer' table.
 *
 *
 *
 * @method     ChildOfferQuery orderByOfferid($order = Criteria::ASC) Order by the OfferID column
 * @method     ChildOfferQuery orderByName($order = Criteria::ASC) Order by the Name column
 * @method     ChildOfferQuery orderByDescription($order = Criteria::ASC) Order by the Description column
 * @method     ChildOfferQuery orderByProductid($order = Criteria::ASC) Order by the ProductID column
 * @method     ChildOfferQuery orderByUserid($order = Criteria::ASC) Order by the UserID column
 * @method     ChildOfferQuery orderByCompanyid($order = Criteria::ASC) Order by the CompanyID column
 * @method     ChildOfferQuery orderByStartdate($order = Criteria::ASC) Order by the StartDate column
 * @method     ChildOfferQuery orderByEnddate($order = Criteria::ASC) Order by the EndDate column
 * @method     ChildOfferQuery orderByQuanitity($order = Criteria::ASC) Order by the Quanitity column
 * @method     ChildOfferQuery orderByDiscount($order = Criteria::ASC) Order by the Discount column
 * @method     ChildOfferQuery orderByDelted($order = Criteria::ASC) Order by the delted column
 *
 * @method     ChildOfferQuery groupByOfferid() Group by the OfferID column
 * @method     ChildOfferQuery groupByName() Group by the Name column
 * @method     ChildOfferQuery groupByDescription() Group by the Description column
 * @method     ChildOfferQuery groupByProductid() Group by the ProductID column
 * @method     ChildOfferQuery groupByUserid() Group by the UserID column
 * @method     ChildOfferQuery groupByCompanyid() Group by the CompanyID column
 * @method     ChildOfferQuery groupByStartdate() Group by the StartDate column
 * @method     ChildOfferQuery groupByEnddate() Group by the EndDate column
 * @method     ChildOfferQuery groupByQuanitity() Group by the Quanitity column
 * @method     ChildOfferQuery groupByDiscount() Group by the Discount column
 * @method     ChildOfferQuery groupByDelted() Group by the delted column
 *
 * @method     ChildOfferQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOfferQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOfferQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOfferQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildOfferQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildOfferQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildOfferQuery leftJoinCompany($relationAlias = null) Adds a LEFT JOIN clause to the query using the Company relation
 * @method     ChildOfferQuery rightJoinCompany($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Company relation
 * @method     ChildOfferQuery innerJoinCompany($relationAlias = null) Adds a INNER JOIN clause to the query using the Company relation
 *
 * @method     ChildOfferQuery joinWithCompany($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Company relation
 *
 * @method     ChildOfferQuery leftJoinWithCompany() Adds a LEFT JOIN clause and with to the query using the Company relation
 * @method     ChildOfferQuery rightJoinWithCompany() Adds a RIGHT JOIN clause and with to the query using the Company relation
 * @method     ChildOfferQuery innerJoinWithCompany() Adds a INNER JOIN clause and with to the query using the Company relation
 *
 * @method     ChildOfferQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildOfferQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildOfferQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildOfferQuery joinWithProduct($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Product relation
 *
 * @method     ChildOfferQuery leftJoinWithProduct() Adds a LEFT JOIN clause and with to the query using the Product relation
 * @method     ChildOfferQuery rightJoinWithProduct() Adds a RIGHT JOIN clause and with to the query using the Product relation
 * @method     ChildOfferQuery innerJoinWithProduct() Adds a INNER JOIN clause and with to the query using the Product relation
 *
 * @method     ChildOfferQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildOfferQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildOfferQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildOfferQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildOfferQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildOfferQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildOfferQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     ChildOfferQuery leftJoinItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the Item relation
 * @method     ChildOfferQuery rightJoinItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Item relation
 * @method     ChildOfferQuery innerJoinItem($relationAlias = null) Adds a INNER JOIN clause to the query using the Item relation
 *
 * @method     ChildOfferQuery joinWithItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Item relation
 *
 * @method     ChildOfferQuery leftJoinWithItem() Adds a LEFT JOIN clause and with to the query using the Item relation
 * @method     ChildOfferQuery rightJoinWithItem() Adds a RIGHT JOIN clause and with to the query using the Item relation
 * @method     ChildOfferQuery innerJoinWithItem() Adds a INNER JOIN clause and with to the query using the Item relation
 *
 * @method     \CompanyQuery|\ProductQuery|\UserQuery|\ItemQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildOffer findOne(ConnectionInterface $con = null) Return the first ChildOffer matching the query
 * @method     ChildOffer findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOffer matching the query, or a new ChildOffer object populated from the query conditions when no match is found
 *
 * @method     ChildOffer findOneByOfferid(int $OfferID) Return the first ChildOffer filtered by the OfferID column
 * @method     ChildOffer findOneByName(string $Name) Return the first ChildOffer filtered by the Name column
 * @method     ChildOffer findOneByDescription(string $Description) Return the first ChildOffer filtered by the Description column
 * @method     ChildOffer findOneByProductid(int $ProductID) Return the first ChildOffer filtered by the ProductID column
 * @method     ChildOffer findOneByUserid(int $UserID) Return the first ChildOffer filtered by the UserID column
 * @method     ChildOffer findOneByCompanyid(int $CompanyID) Return the first ChildOffer filtered by the CompanyID column
 * @method     ChildOffer findOneByStartdate(string $StartDate) Return the first ChildOffer filtered by the StartDate column
 * @method     ChildOffer findOneByEnddate(string $EndDate) Return the first ChildOffer filtered by the EndDate column
 * @method     ChildOffer findOneByQuanitity(int $Quanitity) Return the first ChildOffer filtered by the Quanitity column
 * @method     ChildOffer findOneByDiscount(string $Discount) Return the first ChildOffer filtered by the Discount column
 * @method     ChildOffer findOneByDelted(boolean $delted) Return the first ChildOffer filtered by the delted column *

 * @method     ChildOffer requirePk($key, ConnectionInterface $con = null) Return the ChildOffer by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOffer requireOne(ConnectionInterface $con = null) Return the first ChildOffer matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOffer requireOneByOfferid(int $OfferID) Return the first ChildOffer filtered by the OfferID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOffer requireOneByName(string $Name) Return the first ChildOffer filtered by the Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOffer requireOneByDescription(string $Description) Return the first ChildOffer filtered by the Description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOffer requireOneByProductid(int $ProductID) Return the first ChildOffer filtered by the ProductID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOffer requireOneByUserid(int $UserID) Return the first ChildOffer filtered by the UserID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOffer requireOneByCompanyid(int $CompanyID) Return the first ChildOffer filtered by the CompanyID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOffer requireOneByStartdate(string $StartDate) Return the first ChildOffer filtered by the StartDate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOffer requireOneByEnddate(string $EndDate) Return the first ChildOffer filtered by the EndDate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOffer requireOneByQuanitity(int $Quanitity) Return the first ChildOffer filtered by the Quanitity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOffer requireOneByDiscount(string $Discount) Return the first ChildOffer filtered by the Discount column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOffer requireOneByDelted(boolean $delted) Return the first ChildOffer filtered by the delted column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOffer[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildOffer objects based on current ModelCriteria
 * @method     ChildOffer[]|ObjectCollection findByOfferid(int $OfferID) Return ChildOffer objects filtered by the OfferID column
 * @method     ChildOffer[]|ObjectCollection findByName(string $Name) Return ChildOffer objects filtered by the Name column
 * @method     ChildOffer[]|ObjectCollection findByDescription(string $Description) Return ChildOffer objects filtered by the Description column
 * @method     ChildOffer[]|ObjectCollection findByProductid(int $ProductID) Return ChildOffer objects filtered by the ProductID column
 * @method     ChildOffer[]|ObjectCollection findByUserid(int $UserID) Return ChildOffer objects filtered by the UserID column
 * @method     ChildOffer[]|ObjectCollection findByCompanyid(int $CompanyID) Return ChildOffer objects filtered by the CompanyID column
 * @method     ChildOffer[]|ObjectCollection findByStartdate(string $StartDate) Return ChildOffer objects filtered by the StartDate column
 * @method     ChildOffer[]|ObjectCollection findByEnddate(string $EndDate) Return ChildOffer objects filtered by the EndDate column
 * @method     ChildOffer[]|ObjectCollection findByQuanitity(int $Quanitity) Return ChildOffer objects filtered by the Quanitity column
 * @method     ChildOffer[]|ObjectCollection findByDiscount(string $Discount) Return ChildOffer objects filtered by the Discount column
 * @method     ChildOffer[]|ObjectCollection findByDelted(boolean $delted) Return ChildOffer objects filtered by the delted column
 * @method     ChildOffer[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class OfferQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\OfferQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Offer', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOfferQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOfferQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildOfferQuery) {
            return $criteria;
        }
        $query = new ChildOfferQuery();
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
     * @return ChildOffer|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OfferTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OfferTableMap::DATABASE_NAME);
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
     * @return ChildOffer A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT OfferID, Name, Description, ProductID, UserID, CompanyID, StartDate, EndDate, Quanitity, Discount, delted FROM offer WHERE OfferID = :p0';
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
            /** @var ChildOffer $obj */
            $obj = new ChildOffer();
            $obj->hydrate($row);
            OfferTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildOffer|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildOfferQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OfferTableMap::COL_OFFERID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildOfferQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OfferTableMap::COL_OFFERID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the OfferID column
     *
     * Example usage:
     * <code>
     * $query->filterByOfferid(1234); // WHERE OfferID = 1234
     * $query->filterByOfferid(array(12, 34)); // WHERE OfferID IN (12, 34)
     * $query->filterByOfferid(array('min' => 12)); // WHERE OfferID > 12
     * </code>
     *
     * @param     mixed $offerid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOfferQuery The current query, for fluid interface
     */
    public function filterByOfferid($offerid = null, $comparison = null)
    {
        if (is_array($offerid)) {
            $useMinMax = false;
            if (isset($offerid['min'])) {
                $this->addUsingAlias(OfferTableMap::COL_OFFERID, $offerid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($offerid['max'])) {
                $this->addUsingAlias(OfferTableMap::COL_OFFERID, $offerid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferTableMap::COL_OFFERID, $offerid, $comparison);
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
     * @return $this|ChildOfferQuery The current query, for fluid interface
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

        return $this->addUsingAlias(OfferTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the Description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE Description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE Description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOfferQuery The current query, for fluid interface
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

        return $this->addUsingAlias(OfferTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the ProductID column
     *
     * Example usage:
     * <code>
     * $query->filterByProductid(1234); // WHERE ProductID = 1234
     * $query->filterByProductid(array(12, 34)); // WHERE ProductID IN (12, 34)
     * $query->filterByProductid(array('min' => 12)); // WHERE ProductID > 12
     * </code>
     *
     * @see       filterByProduct()
     *
     * @param     mixed $productid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOfferQuery The current query, for fluid interface
     */
    public function filterByProductid($productid = null, $comparison = null)
    {
        if (is_array($productid)) {
            $useMinMax = false;
            if (isset($productid['min'])) {
                $this->addUsingAlias(OfferTableMap::COL_PRODUCTID, $productid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productid['max'])) {
                $this->addUsingAlias(OfferTableMap::COL_PRODUCTID, $productid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferTableMap::COL_PRODUCTID, $productid, $comparison);
    }

    /**
     * Filter the query on the UserID column
     *
     * Example usage:
     * <code>
     * $query->filterByUserid(1234); // WHERE UserID = 1234
     * $query->filterByUserid(array(12, 34)); // WHERE UserID IN (12, 34)
     * $query->filterByUserid(array('min' => 12)); // WHERE UserID > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOfferQuery The current query, for fluid interface
     */
    public function filterByUserid($userid = null, $comparison = null)
    {
        if (is_array($userid)) {
            $useMinMax = false;
            if (isset($userid['min'])) {
                $this->addUsingAlias(OfferTableMap::COL_USERID, $userid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userid['max'])) {
                $this->addUsingAlias(OfferTableMap::COL_USERID, $userid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferTableMap::COL_USERID, $userid, $comparison);
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
     * @return $this|ChildOfferQuery The current query, for fluid interface
     */
    public function filterByCompanyid($companyid = null, $comparison = null)
    {
        if (is_array($companyid)) {
            $useMinMax = false;
            if (isset($companyid['min'])) {
                $this->addUsingAlias(OfferTableMap::COL_COMPANYID, $companyid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($companyid['max'])) {
                $this->addUsingAlias(OfferTableMap::COL_COMPANYID, $companyid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferTableMap::COL_COMPANYID, $companyid, $comparison);
    }

    /**
     * Filter the query on the StartDate column
     *
     * Example usage:
     * <code>
     * $query->filterByStartdate('2011-03-14'); // WHERE StartDate = '2011-03-14'
     * $query->filterByStartdate('now'); // WHERE StartDate = '2011-03-14'
     * $query->filterByStartdate(array('max' => 'yesterday')); // WHERE StartDate > '2011-03-13'
     * </code>
     *
     * @param     mixed $startdate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOfferQuery The current query, for fluid interface
     */
    public function filterByStartdate($startdate = null, $comparison = null)
    {
        if (is_array($startdate)) {
            $useMinMax = false;
            if (isset($startdate['min'])) {
                $this->addUsingAlias(OfferTableMap::COL_STARTDATE, $startdate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startdate['max'])) {
                $this->addUsingAlias(OfferTableMap::COL_STARTDATE, $startdate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferTableMap::COL_STARTDATE, $startdate, $comparison);
    }

    /**
     * Filter the query on the EndDate column
     *
     * Example usage:
     * <code>
     * $query->filterByEnddate('2011-03-14'); // WHERE EndDate = '2011-03-14'
     * $query->filterByEnddate('now'); // WHERE EndDate = '2011-03-14'
     * $query->filterByEnddate(array('max' => 'yesterday')); // WHERE EndDate > '2011-03-13'
     * </code>
     *
     * @param     mixed $enddate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOfferQuery The current query, for fluid interface
     */
    public function filterByEnddate($enddate = null, $comparison = null)
    {
        if (is_array($enddate)) {
            $useMinMax = false;
            if (isset($enddate['min'])) {
                $this->addUsingAlias(OfferTableMap::COL_ENDDATE, $enddate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($enddate['max'])) {
                $this->addUsingAlias(OfferTableMap::COL_ENDDATE, $enddate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferTableMap::COL_ENDDATE, $enddate, $comparison);
    }

    /**
     * Filter the query on the Quanitity column
     *
     * Example usage:
     * <code>
     * $query->filterByQuanitity(1234); // WHERE Quanitity = 1234
     * $query->filterByQuanitity(array(12, 34)); // WHERE Quanitity IN (12, 34)
     * $query->filterByQuanitity(array('min' => 12)); // WHERE Quanitity > 12
     * </code>
     *
     * @param     mixed $quanitity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOfferQuery The current query, for fluid interface
     */
    public function filterByQuanitity($quanitity = null, $comparison = null)
    {
        if (is_array($quanitity)) {
            $useMinMax = false;
            if (isset($quanitity['min'])) {
                $this->addUsingAlias(OfferTableMap::COL_QUANITITY, $quanitity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quanitity['max'])) {
                $this->addUsingAlias(OfferTableMap::COL_QUANITITY, $quanitity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferTableMap::COL_QUANITITY, $quanitity, $comparison);
    }

    /**
     * Filter the query on the Discount column
     *
     * Example usage:
     * <code>
     * $query->filterByDiscount(1234); // WHERE Discount = 1234
     * $query->filterByDiscount(array(12, 34)); // WHERE Discount IN (12, 34)
     * $query->filterByDiscount(array('min' => 12)); // WHERE Discount > 12
     * </code>
     *
     * @param     mixed $discount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOfferQuery The current query, for fluid interface
     */
    public function filterByDiscount($discount = null, $comparison = null)
    {
        if (is_array($discount)) {
            $useMinMax = false;
            if (isset($discount['min'])) {
                $this->addUsingAlias(OfferTableMap::COL_DISCOUNT, $discount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($discount['max'])) {
                $this->addUsingAlias(OfferTableMap::COL_DISCOUNT, $discount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferTableMap::COL_DISCOUNT, $discount, $comparison);
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
     * @return $this|ChildOfferQuery The current query, for fluid interface
     */
    public function filterByDelted($delted = null, $comparison = null)
    {
        if (is_string($delted)) {
            $delted = in_array(strtolower($delted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(OfferTableMap::COL_DELTED, $delted, $comparison);
    }

    /**
     * Filter the query by a related \Company object
     *
     * @param \Company|ObjectCollection $company The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildOfferQuery The current query, for fluid interface
     */
    public function filterByCompany($company, $comparison = null)
    {
        if ($company instanceof \Company) {
            return $this
                ->addUsingAlias(OfferTableMap::COL_COMPANYID, $company->getCompanyid(), $comparison);
        } elseif ($company instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OfferTableMap::COL_COMPANYID, $company->toKeyValue('PrimaryKey', 'Companyid'), $comparison);
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
     * @return $this|ChildOfferQuery The current query, for fluid interface
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
     * Filter the query by a related \Product object
     *
     * @param \Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildOfferQuery The current query, for fluid interface
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof \Product) {
            return $this
                ->addUsingAlias(OfferTableMap::COL_PRODUCTID, $product->getProductid(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OfferTableMap::COL_PRODUCTID, $product->toKeyValue('PrimaryKey', 'Productid'), $comparison);
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
     * @return $this|ChildOfferQuery The current query, for fluid interface
     */
    public function joinProduct($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useProductQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Product', '\ProductQuery');
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildOfferQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(OfferTableMap::COL_USERID, $user->getUserid(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OfferTableMap::COL_USERID, $user->toKeyValue('PrimaryKey', 'Userid'), $comparison);
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
     * @return $this|ChildOfferQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useUserQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\UserQuery');
    }

    /**
     * Filter the query by a related \Item object
     *
     * @param \Item|ObjectCollection $item the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferQuery The current query, for fluid interface
     */
    public function filterByItem($item, $comparison = null)
    {
        if ($item instanceof \Item) {
            return $this
                ->addUsingAlias(OfferTableMap::COL_OFFERID, $item->getOfferid(), $comparison);
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
     * @return $this|ChildOfferQuery The current query, for fluid interface
     */
    public function joinItem($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useItemQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Item', '\ItemQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildOffer $offer Object to remove from the list of results
     *
     * @return $this|ChildOfferQuery The current query, for fluid interface
     */
    public function prune($offer = null)
    {
        if ($offer) {
            $this->addUsingAlias(OfferTableMap::COL_OFFERID, $offer->getOfferid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the offer table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OfferTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            OfferTableMap::clearInstancePool();
            OfferTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(OfferTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OfferTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            OfferTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            OfferTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // OfferQuery

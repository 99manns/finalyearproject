<?php

namespace Base;

use \Item as ChildItem;
use \ItemQuery as ChildItemQuery;
use \Exception;
use \PDO;
use Map\ItemTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'item' table.
 *
 *
 *
 * @method     ChildItemQuery orderByItemid($order = Criteria::ASC) Order by the ItemID column
 * @method     ChildItemQuery orderByProductid($order = Criteria::ASC) Order by the ProductID column
 * @method     ChildItemQuery orderByUserid($order = Criteria::ASC) Order by the UserID column
 * @method     ChildItemQuery orderByVendingmachineid($order = Criteria::ASC) Order by the vendingmachineID column
 * @method     ChildItemQuery orderByOfferid($order = Criteria::ASC) Order by the OfferID column
 * @method     ChildItemQuery orderByPurchaseprice($order = Criteria::ASC) Order by the PurchasePrice column
 * @method     ChildItemQuery orderBySaleprice($order = Criteria::ASC) Order by the SalePrice column
 * @method     ChildItemQuery orderByAddeddate($order = Criteria::ASC) Order by the AddedDate column
 *
 * @method     ChildItemQuery groupByItemid() Group by the ItemID column
 * @method     ChildItemQuery groupByProductid() Group by the ProductID column
 * @method     ChildItemQuery groupByUserid() Group by the UserID column
 * @method     ChildItemQuery groupByVendingmachineid() Group by the vendingmachineID column
 * @method     ChildItemQuery groupByOfferid() Group by the OfferID column
 * @method     ChildItemQuery groupByPurchaseprice() Group by the PurchasePrice column
 * @method     ChildItemQuery groupBySaleprice() Group by the SalePrice column
 * @method     ChildItemQuery groupByAddeddate() Group by the AddedDate column
 *
 * @method     ChildItemQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildItemQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildItemQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildItemQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildItemQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildItemQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildItemQuery leftJoinOffer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Offer relation
 * @method     ChildItemQuery rightJoinOffer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Offer relation
 * @method     ChildItemQuery innerJoinOffer($relationAlias = null) Adds a INNER JOIN clause to the query using the Offer relation
 *
 * @method     ChildItemQuery joinWithOffer($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Offer relation
 *
 * @method     ChildItemQuery leftJoinWithOffer() Adds a LEFT JOIN clause and with to the query using the Offer relation
 * @method     ChildItemQuery rightJoinWithOffer() Adds a RIGHT JOIN clause and with to the query using the Offer relation
 * @method     ChildItemQuery innerJoinWithOffer() Adds a INNER JOIN clause and with to the query using the Offer relation
 *
 * @method     ChildItemQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildItemQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildItemQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildItemQuery joinWithProduct($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Product relation
 *
 * @method     ChildItemQuery leftJoinWithProduct() Adds a LEFT JOIN clause and with to the query using the Product relation
 * @method     ChildItemQuery rightJoinWithProduct() Adds a RIGHT JOIN clause and with to the query using the Product relation
 * @method     ChildItemQuery innerJoinWithProduct() Adds a INNER JOIN clause and with to the query using the Product relation
 *
 * @method     ChildItemQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildItemQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildItemQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildItemQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildItemQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildItemQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildItemQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     ChildItemQuery leftJoinVendingmachine($relationAlias = null) Adds a LEFT JOIN clause to the query using the Vendingmachine relation
 * @method     ChildItemQuery rightJoinVendingmachine($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Vendingmachine relation
 * @method     ChildItemQuery innerJoinVendingmachine($relationAlias = null) Adds a INNER JOIN clause to the query using the Vendingmachine relation
 *
 * @method     ChildItemQuery joinWithVendingmachine($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Vendingmachine relation
 *
 * @method     ChildItemQuery leftJoinWithVendingmachine() Adds a LEFT JOIN clause and with to the query using the Vendingmachine relation
 * @method     ChildItemQuery rightJoinWithVendingmachine() Adds a RIGHT JOIN clause and with to the query using the Vendingmachine relation
 * @method     ChildItemQuery innerJoinWithVendingmachine() Adds a INNER JOIN clause and with to the query using the Vendingmachine relation
 *
 * @method     \OfferQuery|\ProductQuery|\UserQuery|\VendingmachineQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildItem findOne(ConnectionInterface $con = null) Return the first ChildItem matching the query
 * @method     ChildItem findOneOrCreate(ConnectionInterface $con = null) Return the first ChildItem matching the query, or a new ChildItem object populated from the query conditions when no match is found
 *
 * @method     ChildItem findOneByItemid(int $ItemID) Return the first ChildItem filtered by the ItemID column
 * @method     ChildItem findOneByProductid(int $ProductID) Return the first ChildItem filtered by the ProductID column
 * @method     ChildItem findOneByUserid(int $UserID) Return the first ChildItem filtered by the UserID column
 * @method     ChildItem findOneByVendingmachineid(int $vendingmachineID) Return the first ChildItem filtered by the vendingmachineID column
 * @method     ChildItem findOneByOfferid(int $OfferID) Return the first ChildItem filtered by the OfferID column
 * @method     ChildItem findOneByPurchaseprice(string $PurchasePrice) Return the first ChildItem filtered by the PurchasePrice column
 * @method     ChildItem findOneBySaleprice(string $SalePrice) Return the first ChildItem filtered by the SalePrice column
 * @method     ChildItem findOneByAddeddate(string $AddedDate) Return the first ChildItem filtered by the AddedDate column *

 * @method     ChildItem requirePk($key, ConnectionInterface $con = null) Return the ChildItem by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOne(ConnectionInterface $con = null) Return the first ChildItem matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItem requireOneByItemid(int $ItemID) Return the first ChildItem filtered by the ItemID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByProductid(int $ProductID) Return the first ChildItem filtered by the ProductID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByUserid(int $UserID) Return the first ChildItem filtered by the UserID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByVendingmachineid(int $vendingmachineID) Return the first ChildItem filtered by the vendingmachineID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByOfferid(int $OfferID) Return the first ChildItem filtered by the OfferID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByPurchaseprice(string $PurchasePrice) Return the first ChildItem filtered by the PurchasePrice column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneBySaleprice(string $SalePrice) Return the first ChildItem filtered by the SalePrice column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByAddeddate(string $AddedDate) Return the first ChildItem filtered by the AddedDate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItem[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildItem objects based on current ModelCriteria
 * @method     ChildItem[]|ObjectCollection findByItemid(int $ItemID) Return ChildItem objects filtered by the ItemID column
 * @method     ChildItem[]|ObjectCollection findByProductid(int $ProductID) Return ChildItem objects filtered by the ProductID column
 * @method     ChildItem[]|ObjectCollection findByUserid(int $UserID) Return ChildItem objects filtered by the UserID column
 * @method     ChildItem[]|ObjectCollection findByVendingmachineid(int $vendingmachineID) Return ChildItem objects filtered by the vendingmachineID column
 * @method     ChildItem[]|ObjectCollection findByOfferid(int $OfferID) Return ChildItem objects filtered by the OfferID column
 * @method     ChildItem[]|ObjectCollection findByPurchaseprice(string $PurchasePrice) Return ChildItem objects filtered by the PurchasePrice column
 * @method     ChildItem[]|ObjectCollection findBySaleprice(string $SalePrice) Return ChildItem objects filtered by the SalePrice column
 * @method     ChildItem[]|ObjectCollection findByAddeddate(string $AddedDate) Return ChildItem objects filtered by the AddedDate column
 * @method     ChildItem[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ItemQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ItemQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Item', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildItemQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildItemQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildItemQuery) {
            return $criteria;
        }
        $query = new ChildItemQuery();
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
     * @return ChildItem|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ItemTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ItemTableMap::DATABASE_NAME);
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
     * @return ChildItem A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ItemID, ProductID, UserID, vendingmachineID, OfferID, PurchasePrice, SalePrice, AddedDate FROM item WHERE ItemID = :p0';
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
            /** @var ChildItem $obj */
            $obj = new ChildItem();
            $obj->hydrate($row);
            ItemTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildItem|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ItemTableMap::COL_ITEMID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ItemTableMap::COL_ITEMID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the ItemID column
     *
     * Example usage:
     * <code>
     * $query->filterByItemid(1234); // WHERE ItemID = 1234
     * $query->filterByItemid(array(12, 34)); // WHERE ItemID IN (12, 34)
     * $query->filterByItemid(array('min' => 12)); // WHERE ItemID > 12
     * </code>
     *
     * @param     mixed $itemid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByItemid($itemid = null, $comparison = null)
    {
        if (is_array($itemid)) {
            $useMinMax = false;
            if (isset($itemid['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_ITEMID, $itemid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemid['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_ITEMID, $itemid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_ITEMID, $itemid, $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByProductid($productid = null, $comparison = null)
    {
        if (is_array($productid)) {
            $useMinMax = false;
            if (isset($productid['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_PRODUCTID, $productid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productid['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_PRODUCTID, $productid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_PRODUCTID, $productid, $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByUserid($userid = null, $comparison = null)
    {
        if (is_array($userid)) {
            $useMinMax = false;
            if (isset($userid['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_USERID, $userid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userid['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_USERID, $userid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_USERID, $userid, $comparison);
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
     * @see       filterByVendingmachine()
     *
     * @param     mixed $vendingmachineid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByVendingmachineid($vendingmachineid = null, $comparison = null)
    {
        if (is_array($vendingmachineid)) {
            $useMinMax = false;
            if (isset($vendingmachineid['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_VENDINGMACHINEID, $vendingmachineid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($vendingmachineid['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_VENDINGMACHINEID, $vendingmachineid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_VENDINGMACHINEID, $vendingmachineid, $comparison);
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
     * @see       filterByOffer()
     *
     * @param     mixed $offerid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByOfferid($offerid = null, $comparison = null)
    {
        if (is_array($offerid)) {
            $useMinMax = false;
            if (isset($offerid['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_OFFERID, $offerid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($offerid['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_OFFERID, $offerid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_OFFERID, $offerid, $comparison);
    }

    /**
     * Filter the query on the PurchasePrice column
     *
     * Example usage:
     * <code>
     * $query->filterByPurchaseprice(1234); // WHERE PurchasePrice = 1234
     * $query->filterByPurchaseprice(array(12, 34)); // WHERE PurchasePrice IN (12, 34)
     * $query->filterByPurchaseprice(array('min' => 12)); // WHERE PurchasePrice > 12
     * </code>
     *
     * @param     mixed $purchaseprice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByPurchaseprice($purchaseprice = null, $comparison = null)
    {
        if (is_array($purchaseprice)) {
            $useMinMax = false;
            if (isset($purchaseprice['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_PURCHASEPRICE, $purchaseprice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($purchaseprice['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_PURCHASEPRICE, $purchaseprice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_PURCHASEPRICE, $purchaseprice, $comparison);
    }

    /**
     * Filter the query on the SalePrice column
     *
     * Example usage:
     * <code>
     * $query->filterBySaleprice(1234); // WHERE SalePrice = 1234
     * $query->filterBySaleprice(array(12, 34)); // WHERE SalePrice IN (12, 34)
     * $query->filterBySaleprice(array('min' => 12)); // WHERE SalePrice > 12
     * </code>
     *
     * @param     mixed $saleprice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterBySaleprice($saleprice = null, $comparison = null)
    {
        if (is_array($saleprice)) {
            $useMinMax = false;
            if (isset($saleprice['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_SALEPRICE, $saleprice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($saleprice['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_SALEPRICE, $saleprice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_SALEPRICE, $saleprice, $comparison);
    }

    /**
     * Filter the query on the AddedDate column
     *
     * Example usage:
     * <code>
     * $query->filterByAddeddate('2011-03-14'); // WHERE AddedDate = '2011-03-14'
     * $query->filterByAddeddate('now'); // WHERE AddedDate = '2011-03-14'
     * $query->filterByAddeddate(array('max' => 'yesterday')); // WHERE AddedDate > '2011-03-13'
     * </code>
     *
     * @param     mixed $addeddate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByAddeddate($addeddate = null, $comparison = null)
    {
        if (is_array($addeddate)) {
            $useMinMax = false;
            if (isset($addeddate['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_ADDEDDATE, $addeddate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($addeddate['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_ADDEDDATE, $addeddate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_ADDEDDATE, $addeddate, $comparison);
    }

    /**
     * Filter the query by a related \Offer object
     *
     * @param \Offer|ObjectCollection $offer The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByOffer($offer, $comparison = null)
    {
        if ($offer instanceof \Offer) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_OFFERID, $offer->getOfferid(), $comparison);
        } elseif ($offer instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemTableMap::COL_OFFERID, $offer->toKeyValue('PrimaryKey', 'Offerid'), $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function joinOffer($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useOfferQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinOffer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Offer', '\OfferQuery');
    }

    /**
     * Filter the query by a related \Product object
     *
     * @param \Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof \Product) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_PRODUCTID, $product->getProductid(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemTableMap::COL_PRODUCTID, $product->toKeyValue('PrimaryKey', 'Productid'), $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
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
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_USERID, $user->getUserid(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemTableMap::COL_USERID, $user->toKeyValue('PrimaryKey', 'Userid'), $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
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
     * Filter the query by a related \Vendingmachine object
     *
     * @param \Vendingmachine|ObjectCollection $vendingmachine The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByVendingmachine($vendingmachine, $comparison = null)
    {
        if ($vendingmachine instanceof \Vendingmachine) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_VENDINGMACHINEID, $vendingmachine->getVendingmachineid(), $comparison);
        } elseif ($vendingmachine instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemTableMap::COL_VENDINGMACHINEID, $vendingmachine->toKeyValue('PrimaryKey', 'Vendingmachineid'), $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
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
     * @param   ChildItem $item Object to remove from the list of results
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function prune($item = null)
    {
        if ($item) {
            $this->addUsingAlias(ItemTableMap::COL_ITEMID, $item->getItemid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ItemTableMap::clearInstancePool();
            ItemTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ItemTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ItemTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ItemTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ItemQuery

<?php

namespace Base;

use \Stock as ChildStock;
use \StockQuery as ChildStockQuery;
use \Exception;
use \PDO;
use Map\StockTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'stock' table.
 *
 *
 *
 * @method     ChildStockQuery orderByStockid($order = Criteria::ASC) Order by the StockID column
 * @method     ChildStockQuery orderByProductid($order = Criteria::ASC) Order by the ProductID column
 * @method     ChildStockQuery orderByRetailprice($order = Criteria::ASC) Order by the RetailPrice column
 * @method     ChildStockQuery orderByQuanitity($order = Criteria::ASC) Order by the Quanitity column
 * @method     ChildStockQuery orderByVendingmachineid($order = Criteria::ASC) Order by the vendingmachineID column
 *
 * @method     ChildStockQuery groupByStockid() Group by the StockID column
 * @method     ChildStockQuery groupByProductid() Group by the ProductID column
 * @method     ChildStockQuery groupByRetailprice() Group by the RetailPrice column
 * @method     ChildStockQuery groupByQuanitity() Group by the Quanitity column
 * @method     ChildStockQuery groupByVendingmachineid() Group by the vendingmachineID column
 *
 * @method     ChildStockQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStockQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStockQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStockQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildStockQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildStockQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildStockQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildStockQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildStockQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildStockQuery joinWithProduct($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Product relation
 *
 * @method     ChildStockQuery leftJoinWithProduct() Adds a LEFT JOIN clause and with to the query using the Product relation
 * @method     ChildStockQuery rightJoinWithProduct() Adds a RIGHT JOIN clause and with to the query using the Product relation
 * @method     ChildStockQuery innerJoinWithProduct() Adds a INNER JOIN clause and with to the query using the Product relation
 *
 * @method     ChildStockQuery leftJoinVendingmachine($relationAlias = null) Adds a LEFT JOIN clause to the query using the Vendingmachine relation
 * @method     ChildStockQuery rightJoinVendingmachine($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Vendingmachine relation
 * @method     ChildStockQuery innerJoinVendingmachine($relationAlias = null) Adds a INNER JOIN clause to the query using the Vendingmachine relation
 *
 * @method     ChildStockQuery joinWithVendingmachine($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Vendingmachine relation
 *
 * @method     ChildStockQuery leftJoinWithVendingmachine() Adds a LEFT JOIN clause and with to the query using the Vendingmachine relation
 * @method     ChildStockQuery rightJoinWithVendingmachine() Adds a RIGHT JOIN clause and with to the query using the Vendingmachine relation
 * @method     ChildStockQuery innerJoinWithVendingmachine() Adds a INNER JOIN clause and with to the query using the Vendingmachine relation
 *
 * @method     \ProductQuery|\VendingmachineQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildStock findOne(ConnectionInterface $con = null) Return the first ChildStock matching the query
 * @method     ChildStock findOneOrCreate(ConnectionInterface $con = null) Return the first ChildStock matching the query, or a new ChildStock object populated from the query conditions when no match is found
 *
 * @method     ChildStock findOneByStockid(int $StockID) Return the first ChildStock filtered by the StockID column
 * @method     ChildStock findOneByProductid(int $ProductID) Return the first ChildStock filtered by the ProductID column
 * @method     ChildStock findOneByRetailprice(string $RetailPrice) Return the first ChildStock filtered by the RetailPrice column
 * @method     ChildStock findOneByQuanitity(int $Quanitity) Return the first ChildStock filtered by the Quanitity column
 * @method     ChildStock findOneByVendingmachineid(int $vendingmachineID) Return the first ChildStock filtered by the vendingmachineID column *

 * @method     ChildStock requirePk($key, ConnectionInterface $con = null) Return the ChildStock by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStock requireOne(ConnectionInterface $con = null) Return the first ChildStock matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStock requireOneByStockid(int $StockID) Return the first ChildStock filtered by the StockID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStock requireOneByProductid(int $ProductID) Return the first ChildStock filtered by the ProductID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStock requireOneByRetailprice(string $RetailPrice) Return the first ChildStock filtered by the RetailPrice column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStock requireOneByQuanitity(int $Quanitity) Return the first ChildStock filtered by the Quanitity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStock requireOneByVendingmachineid(int $vendingmachineID) Return the first ChildStock filtered by the vendingmachineID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStock[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildStock objects based on current ModelCriteria
 * @method     ChildStock[]|ObjectCollection findByStockid(int $StockID) Return ChildStock objects filtered by the StockID column
 * @method     ChildStock[]|ObjectCollection findByProductid(int $ProductID) Return ChildStock objects filtered by the ProductID column
 * @method     ChildStock[]|ObjectCollection findByRetailprice(string $RetailPrice) Return ChildStock objects filtered by the RetailPrice column
 * @method     ChildStock[]|ObjectCollection findByQuanitity(int $Quanitity) Return ChildStock objects filtered by the Quanitity column
 * @method     ChildStock[]|ObjectCollection findByVendingmachineid(int $vendingmachineID) Return ChildStock objects filtered by the vendingmachineID column
 * @method     ChildStock[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class StockQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\StockQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Stock', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStockQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStockQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildStockQuery) {
            return $criteria;
        }
        $query = new ChildStockQuery();
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
     * @return ChildStock|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StockTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StockTableMap::DATABASE_NAME);
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
     * @return ChildStock A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT StockID, ProductID, RetailPrice, Quanitity, vendingmachineID FROM stock WHERE StockID = :p0';
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
            /** @var ChildStock $obj */
            $obj = new ChildStock();
            $obj->hydrate($row);
            StockTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildStock|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StockTableMap::COL_STOCKID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StockTableMap::COL_STOCKID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the StockID column
     *
     * Example usage:
     * <code>
     * $query->filterByStockid(1234); // WHERE StockID = 1234
     * $query->filterByStockid(array(12, 34)); // WHERE StockID IN (12, 34)
     * $query->filterByStockid(array('min' => 12)); // WHERE StockID > 12
     * </code>
     *
     * @param     mixed $stockid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByStockid($stockid = null, $comparison = null)
    {
        if (is_array($stockid)) {
            $useMinMax = false;
            if (isset($stockid['min'])) {
                $this->addUsingAlias(StockTableMap::COL_STOCKID, $stockid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stockid['max'])) {
                $this->addUsingAlias(StockTableMap::COL_STOCKID, $stockid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockTableMap::COL_STOCKID, $stockid, $comparison);
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
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByProductid($productid = null, $comparison = null)
    {
        if (is_array($productid)) {
            $useMinMax = false;
            if (isset($productid['min'])) {
                $this->addUsingAlias(StockTableMap::COL_PRODUCTID, $productid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productid['max'])) {
                $this->addUsingAlias(StockTableMap::COL_PRODUCTID, $productid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockTableMap::COL_PRODUCTID, $productid, $comparison);
    }

    /**
     * Filter the query on the RetailPrice column
     *
     * Example usage:
     * <code>
     * $query->filterByRetailprice(1234); // WHERE RetailPrice = 1234
     * $query->filterByRetailprice(array(12, 34)); // WHERE RetailPrice IN (12, 34)
     * $query->filterByRetailprice(array('min' => 12)); // WHERE RetailPrice > 12
     * </code>
     *
     * @param     mixed $retailprice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByRetailprice($retailprice = null, $comparison = null)
    {
        if (is_array($retailprice)) {
            $useMinMax = false;
            if (isset($retailprice['min'])) {
                $this->addUsingAlias(StockTableMap::COL_RETAILPRICE, $retailprice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($retailprice['max'])) {
                $this->addUsingAlias(StockTableMap::COL_RETAILPRICE, $retailprice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockTableMap::COL_RETAILPRICE, $retailprice, $comparison);
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
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByQuanitity($quanitity = null, $comparison = null)
    {
        if (is_array($quanitity)) {
            $useMinMax = false;
            if (isset($quanitity['min'])) {
                $this->addUsingAlias(StockTableMap::COL_QUANITITY, $quanitity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quanitity['max'])) {
                $this->addUsingAlias(StockTableMap::COL_QUANITITY, $quanitity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockTableMap::COL_QUANITITY, $quanitity, $comparison);
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
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByVendingmachineid($vendingmachineid = null, $comparison = null)
    {
        if (is_array($vendingmachineid)) {
            $useMinMax = false;
            if (isset($vendingmachineid['min'])) {
                $this->addUsingAlias(StockTableMap::COL_VENDINGMACHINEID, $vendingmachineid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($vendingmachineid['max'])) {
                $this->addUsingAlias(StockTableMap::COL_VENDINGMACHINEID, $vendingmachineid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockTableMap::COL_VENDINGMACHINEID, $vendingmachineid, $comparison);
    }

    /**
     * Filter the query by a related \Product object
     *
     * @param \Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildStockQuery The current query, for fluid interface
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof \Product) {
            return $this
                ->addUsingAlias(StockTableMap::COL_PRODUCTID, $product->getProductid(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StockTableMap::COL_PRODUCTID, $product->toKeyValue('PrimaryKey', 'Productid'), $comparison);
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
     * @return $this|ChildStockQuery The current query, for fluid interface
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
     * @param \Vendingmachine|ObjectCollection $vendingmachine The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildStockQuery The current query, for fluid interface
     */
    public function filterByVendingmachine($vendingmachine, $comparison = null)
    {
        if ($vendingmachine instanceof \Vendingmachine) {
            return $this
                ->addUsingAlias(StockTableMap::COL_VENDINGMACHINEID, $vendingmachine->getVendingmachineid(), $comparison);
        } elseif ($vendingmachine instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StockTableMap::COL_VENDINGMACHINEID, $vendingmachine->toKeyValue('PrimaryKey', 'Vendingmachineid'), $comparison);
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
     * @return $this|ChildStockQuery The current query, for fluid interface
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
     * @param   ChildStock $stock Object to remove from the list of results
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function prune($stock = null)
    {
        if ($stock) {
            $this->addUsingAlias(StockTableMap::COL_STOCKID, $stock->getStockid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the stock table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StockTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            StockTableMap::clearInstancePool();
            StockTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(StockTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StockTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            StockTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StockTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // StockQuery

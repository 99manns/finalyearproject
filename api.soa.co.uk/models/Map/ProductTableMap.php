<?php

namespace Map;

use \Product;
use \ProductQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'product' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ProductTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ProductTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'product';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Product';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Product';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the ProductID field
     */
    const COL_PRODUCTID = 'product.ProductID';

    /**
     * the column name for the Name field
     */
    const COL_NAME = 'product.Name';

    /**
     * the column name for the Description field
     */
    const COL_DESCRIPTION = 'product.Description';

    /**
     * the column name for the CompanyID field
     */
    const COL_COMPANYID = 'product.CompanyID';

    /**
     * the column name for the Image field
     */
    const COL_IMAGE = 'product.Image';

    /**
     * the column name for the delted field
     */
    const COL_DELTED = 'product.delted';

    /**
     * the column name for the Purchaseprice field
     */
    const COL_PURCHASEPRICE = 'product.Purchaseprice';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Productid', 'Name', 'Description', 'Companyid', 'Image', 'Delted', 'Purchaseprice', ),
        self::TYPE_CAMELNAME     => array('productid', 'name', 'description', 'companyid', 'image', 'delted', 'purchaseprice', ),
        self::TYPE_COLNAME       => array(ProductTableMap::COL_PRODUCTID, ProductTableMap::COL_NAME, ProductTableMap::COL_DESCRIPTION, ProductTableMap::COL_COMPANYID, ProductTableMap::COL_IMAGE, ProductTableMap::COL_DELTED, ProductTableMap::COL_PURCHASEPRICE, ),
        self::TYPE_FIELDNAME     => array('ProductID', 'Name', 'Description', 'CompanyID', 'Image', 'delted', 'Purchaseprice', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Productid' => 0, 'Name' => 1, 'Description' => 2, 'Companyid' => 3, 'Image' => 4, 'Delted' => 5, 'Purchaseprice' => 6, ),
        self::TYPE_CAMELNAME     => array('productid' => 0, 'name' => 1, 'description' => 2, 'companyid' => 3, 'image' => 4, 'delted' => 5, 'purchaseprice' => 6, ),
        self::TYPE_COLNAME       => array(ProductTableMap::COL_PRODUCTID => 0, ProductTableMap::COL_NAME => 1, ProductTableMap::COL_DESCRIPTION => 2, ProductTableMap::COL_COMPANYID => 3, ProductTableMap::COL_IMAGE => 4, ProductTableMap::COL_DELTED => 5, ProductTableMap::COL_PURCHASEPRICE => 6, ),
        self::TYPE_FIELDNAME     => array('ProductID' => 0, 'Name' => 1, 'Description' => 2, 'CompanyID' => 3, 'Image' => 4, 'delted' => 5, 'Purchaseprice' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('product');
        $this->setPhpName('Product');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Product');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ProductID', 'Productid', 'INTEGER', true, null, null);
        $this->addColumn('Name', 'Name', 'VARCHAR', true, 1000, null);
        $this->addColumn('Description', 'Description', 'VARCHAR', true, 10000, null);
        $this->addForeignKey('CompanyID', 'Companyid', 'INTEGER', 'company', 'CompanyID', true, null, null);
        $this->addColumn('Image', 'Image', 'VARCHAR', true, 10000, null);
        $this->addColumn('delted', 'Delted', 'BOOLEAN', true, 1, false);
        $this->addColumn('Purchaseprice', 'Purchaseprice', 'DECIMAL', true, 10, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Company', '\\Company', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':CompanyID',
    1 => ':CompanyID',
  ),
), null, null, null, false);
        $this->addRelation('Item', '\\Item', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':ProductID',
    1 => ':ProductID',
  ),
), null, null, 'Items', false);
        $this->addRelation('Offer', '\\Offer', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':ProductID',
    1 => ':ProductID',
  ),
), null, null, 'Offers', false);
        $this->addRelation('Stock', '\\Stock', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':ProductID',
    1 => ':ProductID',
  ),
), null, null, 'Stocks', false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Productid', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Productid', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Productid', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? ProductTableMap::CLASS_DEFAULT : ProductTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Product object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ProductTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ProductTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ProductTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ProductTableMap::OM_CLASS;
            /** @var Product $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ProductTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = ProductTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ProductTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Product $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ProductTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(ProductTableMap::COL_PRODUCTID);
            $criteria->addSelectColumn(ProductTableMap::COL_NAME);
            $criteria->addSelectColumn(ProductTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(ProductTableMap::COL_COMPANYID);
            $criteria->addSelectColumn(ProductTableMap::COL_IMAGE);
            $criteria->addSelectColumn(ProductTableMap::COL_DELTED);
            $criteria->addSelectColumn(ProductTableMap::COL_PURCHASEPRICE);
        } else {
            $criteria->addSelectColumn($alias . '.ProductID');
            $criteria->addSelectColumn($alias . '.Name');
            $criteria->addSelectColumn($alias . '.Description');
            $criteria->addSelectColumn($alias . '.CompanyID');
            $criteria->addSelectColumn($alias . '.Image');
            $criteria->addSelectColumn($alias . '.delted');
            $criteria->addSelectColumn($alias . '.Purchaseprice');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(ProductTableMap::DATABASE_NAME)->getTable(ProductTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ProductTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ProductTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ProductTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Product or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Product object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Product) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ProductTableMap::DATABASE_NAME);
            $criteria->add(ProductTableMap::COL_PRODUCTID, (array) $values, Criteria::IN);
        }

        $query = ProductQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ProductTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ProductTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the product table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ProductQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Product or Criteria object.
     *
     * @param mixed               $criteria Criteria or Product object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Product object
        }

        if ($criteria->containsKey(ProductTableMap::COL_PRODUCTID) && $criteria->keyContainsValue(ProductTableMap::COL_PRODUCTID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ProductTableMap::COL_PRODUCTID.')');
        }


        // Set the correct dbName
        $query = ProductQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ProductTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ProductTableMap::buildTableMap();

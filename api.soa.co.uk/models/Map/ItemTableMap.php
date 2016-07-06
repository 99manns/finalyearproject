<?php

namespace Map;

use \Item;
use \ItemQuery;
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
 * This class defines the structure of the 'item' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ItemTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ItemTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'item';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Item';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Item';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the ItemID field
     */
    const COL_ITEMID = 'item.ItemID';

    /**
     * the column name for the ProductID field
     */
    const COL_PRODUCTID = 'item.ProductID';

    /**
     * the column name for the UserID field
     */
    const COL_USERID = 'item.UserID';

    /**
     * the column name for the vendingmachineID field
     */
    const COL_VENDINGMACHINEID = 'item.vendingmachineID';

    /**
     * the column name for the OfferID field
     */
    const COL_OFFERID = 'item.OfferID';

    /**
     * the column name for the PurchasePrice field
     */
    const COL_PURCHASEPRICE = 'item.PurchasePrice';

    /**
     * the column name for the SalePrice field
     */
    const COL_SALEPRICE = 'item.SalePrice';

    /**
     * the column name for the AddedDate field
     */
    const COL_ADDEDDATE = 'item.AddedDate';

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
        self::TYPE_PHPNAME       => array('Itemid', 'Productid', 'Userid', 'Vendingmachineid', 'Offerid', 'Purchaseprice', 'Saleprice', 'Addeddate', ),
        self::TYPE_CAMELNAME     => array('itemid', 'productid', 'userid', 'vendingmachineid', 'offerid', 'purchaseprice', 'saleprice', 'addeddate', ),
        self::TYPE_COLNAME       => array(ItemTableMap::COL_ITEMID, ItemTableMap::COL_PRODUCTID, ItemTableMap::COL_USERID, ItemTableMap::COL_VENDINGMACHINEID, ItemTableMap::COL_OFFERID, ItemTableMap::COL_PURCHASEPRICE, ItemTableMap::COL_SALEPRICE, ItemTableMap::COL_ADDEDDATE, ),
        self::TYPE_FIELDNAME     => array('ItemID', 'ProductID', 'UserID', 'vendingmachineID', 'OfferID', 'PurchasePrice', 'SalePrice', 'AddedDate', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Itemid' => 0, 'Productid' => 1, 'Userid' => 2, 'Vendingmachineid' => 3, 'Offerid' => 4, 'Purchaseprice' => 5, 'Saleprice' => 6, 'Addeddate' => 7, ),
        self::TYPE_CAMELNAME     => array('itemid' => 0, 'productid' => 1, 'userid' => 2, 'vendingmachineid' => 3, 'offerid' => 4, 'purchaseprice' => 5, 'saleprice' => 6, 'addeddate' => 7, ),
        self::TYPE_COLNAME       => array(ItemTableMap::COL_ITEMID => 0, ItemTableMap::COL_PRODUCTID => 1, ItemTableMap::COL_USERID => 2, ItemTableMap::COL_VENDINGMACHINEID => 3, ItemTableMap::COL_OFFERID => 4, ItemTableMap::COL_PURCHASEPRICE => 5, ItemTableMap::COL_SALEPRICE => 6, ItemTableMap::COL_ADDEDDATE => 7, ),
        self::TYPE_FIELDNAME     => array('ItemID' => 0, 'ProductID' => 1, 'UserID' => 2, 'vendingmachineID' => 3, 'OfferID' => 4, 'PurchasePrice' => 5, 'SalePrice' => 6, 'AddedDate' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('item');
        $this->setPhpName('Item');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Item');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ItemID', 'Itemid', 'INTEGER', true, null, null);
        $this->addForeignKey('ProductID', 'Productid', 'INTEGER', 'product', 'ProductID', true, null, null);
        $this->addForeignKey('UserID', 'Userid', 'INTEGER', 'user', 'UserID', true, null, null);
        $this->addForeignKey('vendingmachineID', 'Vendingmachineid', 'INTEGER', 'vendingmachine', 'vendingmachineID', true, null, null);
        $this->addForeignKey('OfferID', 'Offerid', 'INTEGER', 'offer', 'OfferID', false, null, null);
        $this->addColumn('PurchasePrice', 'Purchaseprice', 'DECIMAL', true, null, null);
        $this->addColumn('SalePrice', 'Saleprice', 'DECIMAL', true, null, null);
        $this->addColumn('AddedDate', 'Addeddate', 'TIMESTAMP', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Offer', '\\Offer', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':OfferID',
    1 => ':OfferID',
  ),
), null, null, null, false);
        $this->addRelation('Product', '\\Product', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':ProductID',
    1 => ':ProductID',
  ),
), null, null, null, false);
        $this->addRelation('User', '\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':UserID',
    1 => ':UserID',
  ),
), null, null, null, false);
        $this->addRelation('Vendingmachine', '\\Vendingmachine', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':vendingmachineID',
    1 => ':vendingmachineID',
  ),
), null, null, null, false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Itemid', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Itemid', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('Itemid', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? ItemTableMap::CLASS_DEFAULT : ItemTableMap::OM_CLASS;
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
     * @return array           (Item object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ItemTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ItemTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ItemTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ItemTableMap::OM_CLASS;
            /** @var Item $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ItemTableMap::addInstanceToPool($obj, $key);
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
            $key = ItemTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ItemTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Item $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ItemTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ItemTableMap::COL_ITEMID);
            $criteria->addSelectColumn(ItemTableMap::COL_PRODUCTID);
            $criteria->addSelectColumn(ItemTableMap::COL_USERID);
            $criteria->addSelectColumn(ItemTableMap::COL_VENDINGMACHINEID);
            $criteria->addSelectColumn(ItemTableMap::COL_OFFERID);
            $criteria->addSelectColumn(ItemTableMap::COL_PURCHASEPRICE);
            $criteria->addSelectColumn(ItemTableMap::COL_SALEPRICE);
            $criteria->addSelectColumn(ItemTableMap::COL_ADDEDDATE);
        } else {
            $criteria->addSelectColumn($alias . '.ItemID');
            $criteria->addSelectColumn($alias . '.ProductID');
            $criteria->addSelectColumn($alias . '.UserID');
            $criteria->addSelectColumn($alias . '.vendingmachineID');
            $criteria->addSelectColumn($alias . '.OfferID');
            $criteria->addSelectColumn($alias . '.PurchasePrice');
            $criteria->addSelectColumn($alias . '.SalePrice');
            $criteria->addSelectColumn($alias . '.AddedDate');
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
        return Propel::getServiceContainer()->getDatabaseMap(ItemTableMap::DATABASE_NAME)->getTable(ItemTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ItemTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ItemTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ItemTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Item or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Item object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Item) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ItemTableMap::DATABASE_NAME);
            $criteria->add(ItemTableMap::COL_ITEMID, (array) $values, Criteria::IN);
        }

        $query = ItemQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ItemTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ItemTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ItemQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Item or Criteria object.
     *
     * @param mixed               $criteria Criteria or Item object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Item object
        }

        if ($criteria->containsKey(ItemTableMap::COL_ITEMID) && $criteria->keyContainsValue(ItemTableMap::COL_ITEMID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ItemTableMap::COL_ITEMID.')');
        }


        // Set the correct dbName
        $query = ItemQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ItemTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ItemTableMap::buildTableMap();

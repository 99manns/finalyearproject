<?php

namespace Map;

use \Offer;
use \OfferQuery;
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
 * This class defines the structure of the 'offer' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class OfferTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.OfferTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'offer';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Offer';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Offer';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the OfferID field
     */
    const COL_OFFERID = 'offer.OfferID';

    /**
     * the column name for the Name field
     */
    const COL_NAME = 'offer.Name';

    /**
     * the column name for the Description field
     */
    const COL_DESCRIPTION = 'offer.Description';

    /**
     * the column name for the ProductID field
     */
    const COL_PRODUCTID = 'offer.ProductID';

    /**
     * the column name for the UserID field
     */
    const COL_USERID = 'offer.UserID';

    /**
     * the column name for the CompanyID field
     */
    const COL_COMPANYID = 'offer.CompanyID';

    /**
     * the column name for the StartDate field
     */
    const COL_STARTDATE = 'offer.StartDate';

    /**
     * the column name for the EndDate field
     */
    const COL_ENDDATE = 'offer.EndDate';

    /**
     * the column name for the Quanitity field
     */
    const COL_QUANITITY = 'offer.Quanitity';

    /**
     * the column name for the Discount field
     */
    const COL_DISCOUNT = 'offer.Discount';

    /**
     * the column name for the delted field
     */
    const COL_DELTED = 'offer.delted';

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
        self::TYPE_PHPNAME       => array('Offerid', 'Name', 'Description', 'Productid', 'Userid', 'Companyid', 'Startdate', 'Enddate', 'Quanitity', 'Discount', 'Delted', ),
        self::TYPE_CAMELNAME     => array('offerid', 'name', 'description', 'productid', 'userid', 'companyid', 'startdate', 'enddate', 'quanitity', 'discount', 'delted', ),
        self::TYPE_COLNAME       => array(OfferTableMap::COL_OFFERID, OfferTableMap::COL_NAME, OfferTableMap::COL_DESCRIPTION, OfferTableMap::COL_PRODUCTID, OfferTableMap::COL_USERID, OfferTableMap::COL_COMPANYID, OfferTableMap::COL_STARTDATE, OfferTableMap::COL_ENDDATE, OfferTableMap::COL_QUANITITY, OfferTableMap::COL_DISCOUNT, OfferTableMap::COL_DELTED, ),
        self::TYPE_FIELDNAME     => array('OfferID', 'Name', 'Description', 'ProductID', 'UserID', 'CompanyID', 'StartDate', 'EndDate', 'Quanitity', 'Discount', 'delted', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Offerid' => 0, 'Name' => 1, 'Description' => 2, 'Productid' => 3, 'Userid' => 4, 'Companyid' => 5, 'Startdate' => 6, 'Enddate' => 7, 'Quanitity' => 8, 'Discount' => 9, 'Delted' => 10, ),
        self::TYPE_CAMELNAME     => array('offerid' => 0, 'name' => 1, 'description' => 2, 'productid' => 3, 'userid' => 4, 'companyid' => 5, 'startdate' => 6, 'enddate' => 7, 'quanitity' => 8, 'discount' => 9, 'delted' => 10, ),
        self::TYPE_COLNAME       => array(OfferTableMap::COL_OFFERID => 0, OfferTableMap::COL_NAME => 1, OfferTableMap::COL_DESCRIPTION => 2, OfferTableMap::COL_PRODUCTID => 3, OfferTableMap::COL_USERID => 4, OfferTableMap::COL_COMPANYID => 5, OfferTableMap::COL_STARTDATE => 6, OfferTableMap::COL_ENDDATE => 7, OfferTableMap::COL_QUANITITY => 8, OfferTableMap::COL_DISCOUNT => 9, OfferTableMap::COL_DELTED => 10, ),
        self::TYPE_FIELDNAME     => array('OfferID' => 0, 'Name' => 1, 'Description' => 2, 'ProductID' => 3, 'UserID' => 4, 'CompanyID' => 5, 'StartDate' => 6, 'EndDate' => 7, 'Quanitity' => 8, 'Discount' => 9, 'delted' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $this->setName('offer');
        $this->setPhpName('Offer');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Offer');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('OfferID', 'Offerid', 'INTEGER', true, null, null);
        $this->addColumn('Name', 'Name', 'VARCHAR', true, 1000, null);
        $this->addColumn('Description', 'Description', 'VARCHAR', true, 10000, null);
        $this->addForeignKey('ProductID', 'Productid', 'INTEGER', 'product', 'ProductID', false, null, null);
        $this->addForeignKey('UserID', 'Userid', 'INTEGER', 'user', 'UserID', false, null, null);
        $this->addForeignKey('CompanyID', 'Companyid', 'INTEGER', 'company', 'CompanyID', true, null, null);
        $this->addColumn('StartDate', 'Startdate', 'TIMESTAMP', false, null, null);
        $this->addColumn('EndDate', 'Enddate', 'TIMESTAMP', false, null, null);
        $this->addColumn('Quanitity', 'Quanitity', 'INTEGER', false, null, null);
        $this->addColumn('Discount', 'Discount', 'DECIMAL', false, 10, null);
        $this->addColumn('delted', 'Delted', 'BOOLEAN', true, 1, false);
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
        $this->addRelation('Item', '\\Item', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':OfferID',
    1 => ':OfferID',
  ),
), null, null, 'Items', false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Offerid', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Offerid', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('Offerid', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? OfferTableMap::CLASS_DEFAULT : OfferTableMap::OM_CLASS;
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
     * @return array           (Offer object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = OfferTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = OfferTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + OfferTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = OfferTableMap::OM_CLASS;
            /** @var Offer $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            OfferTableMap::addInstanceToPool($obj, $key);
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
            $key = OfferTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = OfferTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Offer $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                OfferTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(OfferTableMap::COL_OFFERID);
            $criteria->addSelectColumn(OfferTableMap::COL_NAME);
            $criteria->addSelectColumn(OfferTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(OfferTableMap::COL_PRODUCTID);
            $criteria->addSelectColumn(OfferTableMap::COL_USERID);
            $criteria->addSelectColumn(OfferTableMap::COL_COMPANYID);
            $criteria->addSelectColumn(OfferTableMap::COL_STARTDATE);
            $criteria->addSelectColumn(OfferTableMap::COL_ENDDATE);
            $criteria->addSelectColumn(OfferTableMap::COL_QUANITITY);
            $criteria->addSelectColumn(OfferTableMap::COL_DISCOUNT);
            $criteria->addSelectColumn(OfferTableMap::COL_DELTED);
        } else {
            $criteria->addSelectColumn($alias . '.OfferID');
            $criteria->addSelectColumn($alias . '.Name');
            $criteria->addSelectColumn($alias . '.Description');
            $criteria->addSelectColumn($alias . '.ProductID');
            $criteria->addSelectColumn($alias . '.UserID');
            $criteria->addSelectColumn($alias . '.CompanyID');
            $criteria->addSelectColumn($alias . '.StartDate');
            $criteria->addSelectColumn($alias . '.EndDate');
            $criteria->addSelectColumn($alias . '.Quanitity');
            $criteria->addSelectColumn($alias . '.Discount');
            $criteria->addSelectColumn($alias . '.delted');
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
        return Propel::getServiceContainer()->getDatabaseMap(OfferTableMap::DATABASE_NAME)->getTable(OfferTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(OfferTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(OfferTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new OfferTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Offer or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Offer object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(OfferTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Offer) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(OfferTableMap::DATABASE_NAME);
            $criteria->add(OfferTableMap::COL_OFFERID, (array) $values, Criteria::IN);
        }

        $query = OfferQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            OfferTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                OfferTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the offer table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return OfferQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Offer or Criteria object.
     *
     * @param mixed               $criteria Criteria or Offer object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OfferTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Offer object
        }

        if ($criteria->containsKey(OfferTableMap::COL_OFFERID) && $criteria->keyContainsValue(OfferTableMap::COL_OFFERID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.OfferTableMap::COL_OFFERID.')');
        }


        // Set the correct dbName
        $query = OfferQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // OfferTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
OfferTableMap::buildTableMap();

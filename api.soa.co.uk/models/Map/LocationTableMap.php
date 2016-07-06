<?php

namespace Map;

use \Location;
use \LocationQuery;
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
 * This class defines the structure of the 'location' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class LocationTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.LocationTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'location';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Location';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Location';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the LocationID field
     */
    const COL_LOCATIONID = 'location.LocationID';

    /**
     * the column name for the AddressLine field
     */
    const COL_ADDRESSLINE = 'location.AddressLine';

    /**
     * the column name for the TownCity field
     */
    const COL_TOWNCITY = 'location.TownCity';

    /**
     * the column name for the Country field
     */
    const COL_COUNTRY = 'location.Country';

    /**
     * the column name for the delted field
     */
    const COL_DELTED = 'location.delted';

    /**
     * the column name for the Postcode field
     */
    const COL_POSTCODE = 'location.Postcode';

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
        self::TYPE_PHPNAME       => array('Locationid', 'Addressline', 'Towncity', 'Country', 'Delted', 'Postcode', ),
        self::TYPE_CAMELNAME     => array('locationid', 'addressline', 'towncity', 'country', 'delted', 'postcode', ),
        self::TYPE_COLNAME       => array(LocationTableMap::COL_LOCATIONID, LocationTableMap::COL_ADDRESSLINE, LocationTableMap::COL_TOWNCITY, LocationTableMap::COL_COUNTRY, LocationTableMap::COL_DELTED, LocationTableMap::COL_POSTCODE, ),
        self::TYPE_FIELDNAME     => array('LocationID', 'AddressLine', 'TownCity', 'Country', 'delted', 'Postcode', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Locationid' => 0, 'Addressline' => 1, 'Towncity' => 2, 'Country' => 3, 'Delted' => 4, 'Postcode' => 5, ),
        self::TYPE_CAMELNAME     => array('locationid' => 0, 'addressline' => 1, 'towncity' => 2, 'country' => 3, 'delted' => 4, 'postcode' => 5, ),
        self::TYPE_COLNAME       => array(LocationTableMap::COL_LOCATIONID => 0, LocationTableMap::COL_ADDRESSLINE => 1, LocationTableMap::COL_TOWNCITY => 2, LocationTableMap::COL_COUNTRY => 3, LocationTableMap::COL_DELTED => 4, LocationTableMap::COL_POSTCODE => 5, ),
        self::TYPE_FIELDNAME     => array('LocationID' => 0, 'AddressLine' => 1, 'TownCity' => 2, 'Country' => 3, 'delted' => 4, 'Postcode' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
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
        $this->setName('location');
        $this->setPhpName('Location');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Location');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('LocationID', 'Locationid', 'INTEGER', true, null, null);
        $this->addColumn('AddressLine', 'Addressline', 'VARCHAR', true, 10000, null);
        $this->addColumn('TownCity', 'Towncity', 'VARCHAR', true, 10000, null);
        $this->addColumn('Country', 'Country', 'VARCHAR', true, 10000, null);
        $this->addColumn('delted', 'Delted', 'BOOLEAN', true, 1, false);
        $this->addColumn('Postcode', 'Postcode', 'VARCHAR', false, 1000, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Company', '\\Company', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':LocationID',
    1 => ':LocationID',
  ),
), null, null, 'Companies', false);
        $this->addRelation('Vendingmachine', '\\Vendingmachine', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':LocationID',
    1 => ':LocationID',
  ),
), null, null, 'Vendingmachines', false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Locationid', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Locationid', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('Locationid', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? LocationTableMap::CLASS_DEFAULT : LocationTableMap::OM_CLASS;
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
     * @return array           (Location object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = LocationTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = LocationTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + LocationTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = LocationTableMap::OM_CLASS;
            /** @var Location $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            LocationTableMap::addInstanceToPool($obj, $key);
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
            $key = LocationTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = LocationTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Location $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                LocationTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(LocationTableMap::COL_LOCATIONID);
            $criteria->addSelectColumn(LocationTableMap::COL_ADDRESSLINE);
            $criteria->addSelectColumn(LocationTableMap::COL_TOWNCITY);
            $criteria->addSelectColumn(LocationTableMap::COL_COUNTRY);
            $criteria->addSelectColumn(LocationTableMap::COL_DELTED);
            $criteria->addSelectColumn(LocationTableMap::COL_POSTCODE);
        } else {
            $criteria->addSelectColumn($alias . '.LocationID');
            $criteria->addSelectColumn($alias . '.AddressLine');
            $criteria->addSelectColumn($alias . '.TownCity');
            $criteria->addSelectColumn($alias . '.Country');
            $criteria->addSelectColumn($alias . '.delted');
            $criteria->addSelectColumn($alias . '.Postcode');
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
        return Propel::getServiceContainer()->getDatabaseMap(LocationTableMap::DATABASE_NAME)->getTable(LocationTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(LocationTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(LocationTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new LocationTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Location or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Location object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(LocationTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Location) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(LocationTableMap::DATABASE_NAME);
            $criteria->add(LocationTableMap::COL_LOCATIONID, (array) $values, Criteria::IN);
        }

        $query = LocationQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            LocationTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                LocationTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the location table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return LocationQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Location or Criteria object.
     *
     * @param mixed               $criteria Criteria or Location object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LocationTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Location object
        }

        if ($criteria->containsKey(LocationTableMap::COL_LOCATIONID) && $criteria->keyContainsValue(LocationTableMap::COL_LOCATIONID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.LocationTableMap::COL_LOCATIONID.')');
        }


        // Set the correct dbName
        $query = LocationQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // LocationTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
LocationTableMap::buildTableMap();

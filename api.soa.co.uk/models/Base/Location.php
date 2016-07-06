<?php

namespace Base;

use \Company as ChildCompany;
use \CompanyQuery as ChildCompanyQuery;
use \Location as ChildLocation;
use \LocationQuery as ChildLocationQuery;
use \Vendingmachine as ChildVendingmachine;
use \VendingmachineQuery as ChildVendingmachineQuery;
use \Exception;
use \PDO;
use Map\LocationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'location' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Location implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\LocationTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the locationid field.
     * @var        int
     */
    protected $locationid;

    /**
     * The value for the addressline field.
     * @var        string
     */
    protected $addressline;

    /**
     * The value for the towncity field.
     * @var        string
     */
    protected $towncity;

    /**
     * The value for the country field.
     * @var        string
     */
    protected $country;

    /**
     * The value for the delted field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $delted;

    /**
     * The value for the postcode field.
     * @var        string
     */
    protected $postcode;

    /**
     * @var        ObjectCollection|ChildCompany[] Collection to store aggregation of ChildCompany objects.
     */
    protected $collCompanies;
    protected $collCompaniesPartial;

    /**
     * @var        ObjectCollection|ChildVendingmachine[] Collection to store aggregation of ChildVendingmachine objects.
     */
    protected $collVendingmachines;
    protected $collVendingmachinesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCompany[]
     */
    protected $companiesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildVendingmachine[]
     */
    protected $vendingmachinesScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->delted = false;
    }

    /**
     * Initializes internal state of Base\Location object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Location</code> instance.  If
     * <code>obj</code> is an instance of <code>Location</code>, delegates to
     * <code>equals(Location)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Location The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [locationid] column value.
     *
     * @return int
     */
    public function getLocationid()
    {
        return $this->locationid;
    }

    /**
     * Get the [addressline] column value.
     *
     * @return string
     */
    public function getAddressline()
    {
        return $this->addressline;
    }

    /**
     * Get the [towncity] column value.
     *
     * @return string
     */
    public function getTowncity()
    {
        return $this->towncity;
    }

    /**
     * Get the [country] column value.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get the [delted] column value.
     *
     * @return boolean
     */
    public function getDelted()
    {
        return $this->delted;
    }

    /**
     * Get the [delted] column value.
     *
     * @return boolean
     */
    public function isDelted()
    {
        return $this->getDelted();
    }

    /**
     * Get the [postcode] column value.
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set the value of [locationid] column.
     *
     * @param int $v new value
     * @return $this|\Location The current object (for fluent API support)
     */
    public function setLocationid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->locationid !== $v) {
            $this->locationid = $v;
            $this->modifiedColumns[LocationTableMap::COL_LOCATIONID] = true;
        }

        return $this;
    } // setLocationid()

    /**
     * Set the value of [addressline] column.
     *
     * @param string $v new value
     * @return $this|\Location The current object (for fluent API support)
     */
    public function setAddressline($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->addressline !== $v) {
            $this->addressline = $v;
            $this->modifiedColumns[LocationTableMap::COL_ADDRESSLINE] = true;
        }

        return $this;
    } // setAddressline()

    /**
     * Set the value of [towncity] column.
     *
     * @param string $v new value
     * @return $this|\Location The current object (for fluent API support)
     */
    public function setTowncity($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->towncity !== $v) {
            $this->towncity = $v;
            $this->modifiedColumns[LocationTableMap::COL_TOWNCITY] = true;
        }

        return $this;
    } // setTowncity()

    /**
     * Set the value of [country] column.
     *
     * @param string $v new value
     * @return $this|\Location The current object (for fluent API support)
     */
    public function setCountry($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->country !== $v) {
            $this->country = $v;
            $this->modifiedColumns[LocationTableMap::COL_COUNTRY] = true;
        }

        return $this;
    } // setCountry()

    /**
     * Sets the value of the [delted] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Location The current object (for fluent API support)
     */
    public function setDelted($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->delted !== $v) {
            $this->delted = $v;
            $this->modifiedColumns[LocationTableMap::COL_DELTED] = true;
        }

        return $this;
    } // setDelted()

    /**
     * Set the value of [postcode] column.
     *
     * @param string $v new value
     * @return $this|\Location The current object (for fluent API support)
     */
    public function setPostcode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->postcode !== $v) {
            $this->postcode = $v;
            $this->modifiedColumns[LocationTableMap::COL_POSTCODE] = true;
        }

        return $this;
    } // setPostcode()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->delted !== false) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : LocationTableMap::translateFieldName('Locationid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->locationid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : LocationTableMap::translateFieldName('Addressline', TableMap::TYPE_PHPNAME, $indexType)];
            $this->addressline = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : LocationTableMap::translateFieldName('Towncity', TableMap::TYPE_PHPNAME, $indexType)];
            $this->towncity = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : LocationTableMap::translateFieldName('Country', TableMap::TYPE_PHPNAME, $indexType)];
            $this->country = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : LocationTableMap::translateFieldName('Delted', TableMap::TYPE_PHPNAME, $indexType)];
            $this->delted = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : LocationTableMap::translateFieldName('Postcode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->postcode = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = LocationTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Location'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(LocationTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildLocationQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collCompanies = null;

            $this->collVendingmachines = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Location::setDeleted()
     * @see Location::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(LocationTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildLocationQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(LocationTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                LocationTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->companiesScheduledForDeletion !== null) {
                if (!$this->companiesScheduledForDeletion->isEmpty()) {
                    \CompanyQuery::create()
                        ->filterByPrimaryKeys($this->companiesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->companiesScheduledForDeletion = null;
                }
            }

            if ($this->collCompanies !== null) {
                foreach ($this->collCompanies as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->vendingmachinesScheduledForDeletion !== null) {
                if (!$this->vendingmachinesScheduledForDeletion->isEmpty()) {
                    \VendingmachineQuery::create()
                        ->filterByPrimaryKeys($this->vendingmachinesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->vendingmachinesScheduledForDeletion = null;
                }
            }

            if ($this->collVendingmachines !== null) {
                foreach ($this->collVendingmachines as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[LocationTableMap::COL_LOCATIONID] = true;
        if (null !== $this->locationid) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . LocationTableMap::COL_LOCATIONID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(LocationTableMap::COL_LOCATIONID)) {
            $modifiedColumns[':p' . $index++]  = 'LocationID';
        }
        if ($this->isColumnModified(LocationTableMap::COL_ADDRESSLINE)) {
            $modifiedColumns[':p' . $index++]  = 'AddressLine';
        }
        if ($this->isColumnModified(LocationTableMap::COL_TOWNCITY)) {
            $modifiedColumns[':p' . $index++]  = 'TownCity';
        }
        if ($this->isColumnModified(LocationTableMap::COL_COUNTRY)) {
            $modifiedColumns[':p' . $index++]  = 'Country';
        }
        if ($this->isColumnModified(LocationTableMap::COL_DELTED)) {
            $modifiedColumns[':p' . $index++]  = 'delted';
        }
        if ($this->isColumnModified(LocationTableMap::COL_POSTCODE)) {
            $modifiedColumns[':p' . $index++]  = 'Postcode';
        }

        $sql = sprintf(
            'INSERT INTO location (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'LocationID':
                        $stmt->bindValue($identifier, $this->locationid, PDO::PARAM_INT);
                        break;
                    case 'AddressLine':
                        $stmt->bindValue($identifier, $this->addressline, PDO::PARAM_STR);
                        break;
                    case 'TownCity':
                        $stmt->bindValue($identifier, $this->towncity, PDO::PARAM_STR);
                        break;
                    case 'Country':
                        $stmt->bindValue($identifier, $this->country, PDO::PARAM_STR);
                        break;
                    case 'delted':
                        $stmt->bindValue($identifier, (int) $this->delted, PDO::PARAM_INT);
                        break;
                    case 'Postcode':
                        $stmt->bindValue($identifier, $this->postcode, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setLocationid($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = LocationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getLocationid();
                break;
            case 1:
                return $this->getAddressline();
                break;
            case 2:
                return $this->getTowncity();
                break;
            case 3:
                return $this->getCountry();
                break;
            case 4:
                return $this->getDelted();
                break;
            case 5:
                return $this->getPostcode();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Location'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Location'][$this->hashCode()] = true;
        $keys = LocationTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getLocationid(),
            $keys[1] => $this->getAddressline(),
            $keys[2] => $this->getTowncity(),
            $keys[3] => $this->getCountry(),
            $keys[4] => $this->getDelted(),
            $keys[5] => $this->getPostcode(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collCompanies) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'companies';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'companies';
                        break;
                    default:
                        $key = 'Companies';
                }

                $result[$key] = $this->collCompanies->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collVendingmachines) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'vendingmachines';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'vendingmachines';
                        break;
                    default:
                        $key = 'Vendingmachines';
                }

                $result[$key] = $this->collVendingmachines->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Location
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = LocationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Location
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setLocationid($value);
                break;
            case 1:
                $this->setAddressline($value);
                break;
            case 2:
                $this->setTowncity($value);
                break;
            case 3:
                $this->setCountry($value);
                break;
            case 4:
                $this->setDelted($value);
                break;
            case 5:
                $this->setPostcode($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = LocationTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setLocationid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setAddressline($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTowncity($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCountry($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDelted($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPostcode($arr[$keys[5]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Location The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(LocationTableMap::DATABASE_NAME);

        if ($this->isColumnModified(LocationTableMap::COL_LOCATIONID)) {
            $criteria->add(LocationTableMap::COL_LOCATIONID, $this->locationid);
        }
        if ($this->isColumnModified(LocationTableMap::COL_ADDRESSLINE)) {
            $criteria->add(LocationTableMap::COL_ADDRESSLINE, $this->addressline);
        }
        if ($this->isColumnModified(LocationTableMap::COL_TOWNCITY)) {
            $criteria->add(LocationTableMap::COL_TOWNCITY, $this->towncity);
        }
        if ($this->isColumnModified(LocationTableMap::COL_COUNTRY)) {
            $criteria->add(LocationTableMap::COL_COUNTRY, $this->country);
        }
        if ($this->isColumnModified(LocationTableMap::COL_DELTED)) {
            $criteria->add(LocationTableMap::COL_DELTED, $this->delted);
        }
        if ($this->isColumnModified(LocationTableMap::COL_POSTCODE)) {
            $criteria->add(LocationTableMap::COL_POSTCODE, $this->postcode);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildLocationQuery::create();
        $criteria->add(LocationTableMap::COL_LOCATIONID, $this->locationid);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getLocationid();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getLocationid();
    }

    /**
     * Generic method to set the primary key (locationid column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setLocationid($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getLocationid();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Location (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setAddressline($this->getAddressline());
        $copyObj->setTowncity($this->getTowncity());
        $copyObj->setCountry($this->getCountry());
        $copyObj->setDelted($this->getDelted());
        $copyObj->setPostcode($this->getPostcode());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCompanies() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCompany($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getVendingmachines() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addVendingmachine($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setLocationid(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Location Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Company' == $relationName) {
            return $this->initCompanies();
        }
        if ('Vendingmachine' == $relationName) {
            return $this->initVendingmachines();
        }
    }

    /**
     * Clears out the collCompanies collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCompanies()
     */
    public function clearCompanies()
    {
        $this->collCompanies = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCompanies collection loaded partially.
     */
    public function resetPartialCompanies($v = true)
    {
        $this->collCompaniesPartial = $v;
    }

    /**
     * Initializes the collCompanies collection.
     *
     * By default this just sets the collCompanies collection to an empty array (like clearcollCompanies());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCompanies($overrideExisting = true)
    {
        if (null !== $this->collCompanies && !$overrideExisting) {
            return;
        }
        $this->collCompanies = new ObjectCollection();
        $this->collCompanies->setModel('\Company');
    }

    /**
     * Gets an array of ChildCompany objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildLocation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCompany[] List of ChildCompany objects
     * @throws PropelException
     */
    public function getCompanies(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCompaniesPartial && !$this->isNew();
        if (null === $this->collCompanies || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCompanies) {
                // return empty collection
                $this->initCompanies();
            } else {
                $collCompanies = ChildCompanyQuery::create(null, $criteria)
                    ->filterByLocation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCompaniesPartial && count($collCompanies)) {
                        $this->initCompanies(false);

                        foreach ($collCompanies as $obj) {
                            if (false == $this->collCompanies->contains($obj)) {
                                $this->collCompanies->append($obj);
                            }
                        }

                        $this->collCompaniesPartial = true;
                    }

                    return $collCompanies;
                }

                if ($partial && $this->collCompanies) {
                    foreach ($this->collCompanies as $obj) {
                        if ($obj->isNew()) {
                            $collCompanies[] = $obj;
                        }
                    }
                }

                $this->collCompanies = $collCompanies;
                $this->collCompaniesPartial = false;
            }
        }

        return $this->collCompanies;
    }

    /**
     * Sets a collection of ChildCompany objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $companies A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildLocation The current object (for fluent API support)
     */
    public function setCompanies(Collection $companies, ConnectionInterface $con = null)
    {
        /** @var ChildCompany[] $companiesToDelete */
        $companiesToDelete = $this->getCompanies(new Criteria(), $con)->diff($companies);


        $this->companiesScheduledForDeletion = $companiesToDelete;

        foreach ($companiesToDelete as $companyRemoved) {
            $companyRemoved->setLocation(null);
        }

        $this->collCompanies = null;
        foreach ($companies as $company) {
            $this->addCompany($company);
        }

        $this->collCompanies = $companies;
        $this->collCompaniesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Company objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Company objects.
     * @throws PropelException
     */
    public function countCompanies(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCompaniesPartial && !$this->isNew();
        if (null === $this->collCompanies || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCompanies) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCompanies());
            }

            $query = ChildCompanyQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByLocation($this)
                ->count($con);
        }

        return count($this->collCompanies);
    }

    /**
     * Method called to associate a ChildCompany object to this object
     * through the ChildCompany foreign key attribute.
     *
     * @param  ChildCompany $l ChildCompany
     * @return $this|\Location The current object (for fluent API support)
     */
    public function addCompany(ChildCompany $l)
    {
        if ($this->collCompanies === null) {
            $this->initCompanies();
            $this->collCompaniesPartial = true;
        }

        if (!$this->collCompanies->contains($l)) {
            $this->doAddCompany($l);
        }

        return $this;
    }

    /**
     * @param ChildCompany $company The ChildCompany object to add.
     */
    protected function doAddCompany(ChildCompany $company)
    {
        $this->collCompanies[]= $company;
        $company->setLocation($this);
    }

    /**
     * @param  ChildCompany $company The ChildCompany object to remove.
     * @return $this|ChildLocation The current object (for fluent API support)
     */
    public function removeCompany(ChildCompany $company)
    {
        if ($this->getCompanies()->contains($company)) {
            $pos = $this->collCompanies->search($company);
            $this->collCompanies->remove($pos);
            if (null === $this->companiesScheduledForDeletion) {
                $this->companiesScheduledForDeletion = clone $this->collCompanies;
                $this->companiesScheduledForDeletion->clear();
            }
            $this->companiesScheduledForDeletion[]= clone $company;
            $company->setLocation(null);
        }

        return $this;
    }

    /**
     * Clears out the collVendingmachines collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addVendingmachines()
     */
    public function clearVendingmachines()
    {
        $this->collVendingmachines = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collVendingmachines collection loaded partially.
     */
    public function resetPartialVendingmachines($v = true)
    {
        $this->collVendingmachinesPartial = $v;
    }

    /**
     * Initializes the collVendingmachines collection.
     *
     * By default this just sets the collVendingmachines collection to an empty array (like clearcollVendingmachines());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initVendingmachines($overrideExisting = true)
    {
        if (null !== $this->collVendingmachines && !$overrideExisting) {
            return;
        }
        $this->collVendingmachines = new ObjectCollection();
        $this->collVendingmachines->setModel('\Vendingmachine');
    }

    /**
     * Gets an array of ChildVendingmachine objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildLocation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildVendingmachine[] List of ChildVendingmachine objects
     * @throws PropelException
     */
    public function getVendingmachines(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collVendingmachinesPartial && !$this->isNew();
        if (null === $this->collVendingmachines || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collVendingmachines) {
                // return empty collection
                $this->initVendingmachines();
            } else {
                $collVendingmachines = ChildVendingmachineQuery::create(null, $criteria)
                    ->filterByLocation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collVendingmachinesPartial && count($collVendingmachines)) {
                        $this->initVendingmachines(false);

                        foreach ($collVendingmachines as $obj) {
                            if (false == $this->collVendingmachines->contains($obj)) {
                                $this->collVendingmachines->append($obj);
                            }
                        }

                        $this->collVendingmachinesPartial = true;
                    }

                    return $collVendingmachines;
                }

                if ($partial && $this->collVendingmachines) {
                    foreach ($this->collVendingmachines as $obj) {
                        if ($obj->isNew()) {
                            $collVendingmachines[] = $obj;
                        }
                    }
                }

                $this->collVendingmachines = $collVendingmachines;
                $this->collVendingmachinesPartial = false;
            }
        }

        return $this->collVendingmachines;
    }

    /**
     * Sets a collection of ChildVendingmachine objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $vendingmachines A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildLocation The current object (for fluent API support)
     */
    public function setVendingmachines(Collection $vendingmachines, ConnectionInterface $con = null)
    {
        /** @var ChildVendingmachine[] $vendingmachinesToDelete */
        $vendingmachinesToDelete = $this->getVendingmachines(new Criteria(), $con)->diff($vendingmachines);


        $this->vendingmachinesScheduledForDeletion = $vendingmachinesToDelete;

        foreach ($vendingmachinesToDelete as $vendingmachineRemoved) {
            $vendingmachineRemoved->setLocation(null);
        }

        $this->collVendingmachines = null;
        foreach ($vendingmachines as $vendingmachine) {
            $this->addVendingmachine($vendingmachine);
        }

        $this->collVendingmachines = $vendingmachines;
        $this->collVendingmachinesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Vendingmachine objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Vendingmachine objects.
     * @throws PropelException
     */
    public function countVendingmachines(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collVendingmachinesPartial && !$this->isNew();
        if (null === $this->collVendingmachines || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collVendingmachines) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getVendingmachines());
            }

            $query = ChildVendingmachineQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByLocation($this)
                ->count($con);
        }

        return count($this->collVendingmachines);
    }

    /**
     * Method called to associate a ChildVendingmachine object to this object
     * through the ChildVendingmachine foreign key attribute.
     *
     * @param  ChildVendingmachine $l ChildVendingmachine
     * @return $this|\Location The current object (for fluent API support)
     */
    public function addVendingmachine(ChildVendingmachine $l)
    {
        if ($this->collVendingmachines === null) {
            $this->initVendingmachines();
            $this->collVendingmachinesPartial = true;
        }

        if (!$this->collVendingmachines->contains($l)) {
            $this->doAddVendingmachine($l);
        }

        return $this;
    }

    /**
     * @param ChildVendingmachine $vendingmachine The ChildVendingmachine object to add.
     */
    protected function doAddVendingmachine(ChildVendingmachine $vendingmachine)
    {
        $this->collVendingmachines[]= $vendingmachine;
        $vendingmachine->setLocation($this);
    }

    /**
     * @param  ChildVendingmachine $vendingmachine The ChildVendingmachine object to remove.
     * @return $this|ChildLocation The current object (for fluent API support)
     */
    public function removeVendingmachine(ChildVendingmachine $vendingmachine)
    {
        if ($this->getVendingmachines()->contains($vendingmachine)) {
            $pos = $this->collVendingmachines->search($vendingmachine);
            $this->collVendingmachines->remove($pos);
            if (null === $this->vendingmachinesScheduledForDeletion) {
                $this->vendingmachinesScheduledForDeletion = clone $this->collVendingmachines;
                $this->vendingmachinesScheduledForDeletion->clear();
            }
            $this->vendingmachinesScheduledForDeletion[]= clone $vendingmachine;
            $vendingmachine->setLocation(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Location is new, it will return
     * an empty collection; or if this Location has previously
     * been saved, it will retrieve related Vendingmachines from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Location.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildVendingmachine[] List of ChildVendingmachine objects
     */
    public function getVendingmachinesJoinCompany(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildVendingmachineQuery::create(null, $criteria);
        $query->joinWith('Company', $joinBehavior);

        return $this->getVendingmachines($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->locationid = null;
        $this->addressline = null;
        $this->towncity = null;
        $this->country = null;
        $this->delted = null;
        $this->postcode = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collCompanies) {
                foreach ($this->collCompanies as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collVendingmachines) {
                foreach ($this->collVendingmachines as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCompanies = null;
        $this->collVendingmachines = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(LocationTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}

<?php

namespace Base;

use \Company as ChildCompany;
use \CompanyQuery as ChildCompanyQuery;
use \Location as ChildLocation;
use \LocationQuery as ChildLocationQuery;
use \Offer as ChildOffer;
use \OfferQuery as ChildOfferQuery;
use \Product as ChildProduct;
use \ProductQuery as ChildProductQuery;
use \Vendingmachine as ChildVendingmachine;
use \VendingmachineQuery as ChildVendingmachineQuery;
use \Exception;
use \PDO;
use Map\CompanyTableMap;
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
 * Base class that represents a row from the 'company' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Company implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\CompanyTableMap';


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
     * The value for the companyid field.
     * @var        int
     */
    protected $companyid;

    /**
     * The value for the apikey field.
     * @var        string
     */
    protected $apikey;

    /**
     * The value for the locationid field.
     * @var        int
     */
    protected $locationid;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the telephone field.
     * @var        string
     */
    protected $telephone;

    /**
     * The value for the delted field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $delted;

    /**
     * @var        ChildLocation
     */
    protected $aLocation;

    /**
     * @var        ObjectCollection|ChildOffer[] Collection to store aggregation of ChildOffer objects.
     */
    protected $collOffers;
    protected $collOffersPartial;

    /**
     * @var        ObjectCollection|ChildProduct[] Collection to store aggregation of ChildProduct objects.
     */
    protected $collProducts;
    protected $collProductsPartial;

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
     * @var ObjectCollection|ChildOffer[]
     */
    protected $offersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildProduct[]
     */
    protected $productsScheduledForDeletion = null;

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
     * Initializes internal state of Base\Company object.
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
     * Compares this with another <code>Company</code> instance.  If
     * <code>obj</code> is an instance of <code>Company</code>, delegates to
     * <code>equals(Company)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Company The current object, for fluid interface
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
     * Get the [companyid] column value.
     *
     * @return int
     */
    public function getCompanyid()
    {
        return $this->companyid;
    }

    /**
     * Get the [apikey] column value.
     *
     * @return string
     */
    public function getApikey()
    {
        return $this->apikey;
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
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [telephone] column value.
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
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
     * Set the value of [companyid] column.
     *
     * @param int $v new value
     * @return $this|\Company The current object (for fluent API support)
     */
    public function setCompanyid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->companyid !== $v) {
            $this->companyid = $v;
            $this->modifiedColumns[CompanyTableMap::COL_COMPANYID] = true;
        }

        return $this;
    } // setCompanyid()

    /**
     * Set the value of [apikey] column.
     *
     * @param string $v new value
     * @return $this|\Company The current object (for fluent API support)
     */
    public function setApikey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->apikey !== $v) {
            $this->apikey = $v;
            $this->modifiedColumns[CompanyTableMap::COL_APIKEY] = true;
        }

        return $this;
    } // setApikey()

    /**
     * Set the value of [locationid] column.
     *
     * @param int $v new value
     * @return $this|\Company The current object (for fluent API support)
     */
    public function setLocationid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->locationid !== $v) {
            $this->locationid = $v;
            $this->modifiedColumns[CompanyTableMap::COL_LOCATIONID] = true;
        }

        if ($this->aLocation !== null && $this->aLocation->getLocationid() !== $v) {
            $this->aLocation = null;
        }

        return $this;
    } // setLocationid()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Company The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[CompanyTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [telephone] column.
     *
     * @param string $v new value
     * @return $this|\Company The current object (for fluent API support)
     */
    public function setTelephone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->telephone !== $v) {
            $this->telephone = $v;
            $this->modifiedColumns[CompanyTableMap::COL_TELEPHONE] = true;
        }

        return $this;
    } // setTelephone()

    /**
     * Sets the value of the [delted] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Company The current object (for fluent API support)
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
            $this->modifiedColumns[CompanyTableMap::COL_DELTED] = true;
        }

        return $this;
    } // setDelted()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CompanyTableMap::translateFieldName('Companyid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->companyid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CompanyTableMap::translateFieldName('Apikey', TableMap::TYPE_PHPNAME, $indexType)];
            $this->apikey = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CompanyTableMap::translateFieldName('Locationid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->locationid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CompanyTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : CompanyTableMap::translateFieldName('Telephone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->telephone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : CompanyTableMap::translateFieldName('Delted', TableMap::TYPE_PHPNAME, $indexType)];
            $this->delted = (null !== $col) ? (boolean) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = CompanyTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Company'), 0, $e);
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
        if ($this->aLocation !== null && $this->locationid !== $this->aLocation->getLocationid()) {
            $this->aLocation = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(CompanyTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCompanyQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aLocation = null;
            $this->collOffers = null;

            $this->collProducts = null;

            $this->collVendingmachines = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Company::setDeleted()
     * @see Company::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CompanyTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildCompanyQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(CompanyTableMap::DATABASE_NAME);
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
                CompanyTableMap::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aLocation !== null) {
                if ($this->aLocation->isModified() || $this->aLocation->isNew()) {
                    $affectedRows += $this->aLocation->save($con);
                }
                $this->setLocation($this->aLocation);
            }

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

            if ($this->offersScheduledForDeletion !== null) {
                if (!$this->offersScheduledForDeletion->isEmpty()) {
                    \OfferQuery::create()
                        ->filterByPrimaryKeys($this->offersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->offersScheduledForDeletion = null;
                }
            }

            if ($this->collOffers !== null) {
                foreach ($this->collOffers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->productsScheduledForDeletion !== null) {
                if (!$this->productsScheduledForDeletion->isEmpty()) {
                    \ProductQuery::create()
                        ->filterByPrimaryKeys($this->productsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->productsScheduledForDeletion = null;
                }
            }

            if ($this->collProducts !== null) {
                foreach ($this->collProducts as $referrerFK) {
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

        $this->modifiedColumns[CompanyTableMap::COL_COMPANYID] = true;
        if (null !== $this->companyid) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CompanyTableMap::COL_COMPANYID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CompanyTableMap::COL_COMPANYID)) {
            $modifiedColumns[':p' . $index++]  = 'CompanyID';
        }
        if ($this->isColumnModified(CompanyTableMap::COL_APIKEY)) {
            $modifiedColumns[':p' . $index++]  = 'APIkey';
        }
        if ($this->isColumnModified(CompanyTableMap::COL_LOCATIONID)) {
            $modifiedColumns[':p' . $index++]  = 'LocationID';
        }
        if ($this->isColumnModified(CompanyTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'Name';
        }
        if ($this->isColumnModified(CompanyTableMap::COL_TELEPHONE)) {
            $modifiedColumns[':p' . $index++]  = 'Telephone';
        }
        if ($this->isColumnModified(CompanyTableMap::COL_DELTED)) {
            $modifiedColumns[':p' . $index++]  = 'delted';
        }

        $sql = sprintf(
            'INSERT INTO company (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'CompanyID':
                        $stmt->bindValue($identifier, $this->companyid, PDO::PARAM_INT);
                        break;
                    case 'APIkey':
                        $stmt->bindValue($identifier, $this->apikey, PDO::PARAM_STR);
                        break;
                    case 'LocationID':
                        $stmt->bindValue($identifier, $this->locationid, PDO::PARAM_INT);
                        break;
                    case 'Name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'Telephone':
                        $stmt->bindValue($identifier, $this->telephone, PDO::PARAM_STR);
                        break;
                    case 'delted':
                        $stmt->bindValue($identifier, (int) $this->delted, PDO::PARAM_INT);
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
        $this->setCompanyid($pk);

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
        $pos = CompanyTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getCompanyid();
                break;
            case 1:
                return $this->getApikey();
                break;
            case 2:
                return $this->getLocationid();
                break;
            case 3:
                return $this->getName();
                break;
            case 4:
                return $this->getTelephone();
                break;
            case 5:
                return $this->getDelted();
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

        if (isset($alreadyDumpedObjects['Company'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Company'][$this->hashCode()] = true;
        $keys = CompanyTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getCompanyid(),
            $keys[1] => $this->getApikey(),
            $keys[2] => $this->getLocationid(),
            $keys[3] => $this->getName(),
            $keys[4] => $this->getTelephone(),
            $keys[5] => $this->getDelted(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aLocation) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'location';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'location';
                        break;
                    default:
                        $key = 'Location';
                }

                $result[$key] = $this->aLocation->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collOffers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'offers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'offers';
                        break;
                    default:
                        $key = 'Offers';
                }

                $result[$key] = $this->collOffers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProducts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'products';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'products';
                        break;
                    default:
                        $key = 'Products';
                }

                $result[$key] = $this->collProducts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Company
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CompanyTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Company
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setCompanyid($value);
                break;
            case 1:
                $this->setApikey($value);
                break;
            case 2:
                $this->setLocationid($value);
                break;
            case 3:
                $this->setName($value);
                break;
            case 4:
                $this->setTelephone($value);
                break;
            case 5:
                $this->setDelted($value);
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
        $keys = CompanyTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setCompanyid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setApikey($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setLocationid($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setName($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setTelephone($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setDelted($arr[$keys[5]]);
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
     * @return $this|\Company The current object, for fluid interface
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
        $criteria = new Criteria(CompanyTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CompanyTableMap::COL_COMPANYID)) {
            $criteria->add(CompanyTableMap::COL_COMPANYID, $this->companyid);
        }
        if ($this->isColumnModified(CompanyTableMap::COL_APIKEY)) {
            $criteria->add(CompanyTableMap::COL_APIKEY, $this->apikey);
        }
        if ($this->isColumnModified(CompanyTableMap::COL_LOCATIONID)) {
            $criteria->add(CompanyTableMap::COL_LOCATIONID, $this->locationid);
        }
        if ($this->isColumnModified(CompanyTableMap::COL_NAME)) {
            $criteria->add(CompanyTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(CompanyTableMap::COL_TELEPHONE)) {
            $criteria->add(CompanyTableMap::COL_TELEPHONE, $this->telephone);
        }
        if ($this->isColumnModified(CompanyTableMap::COL_DELTED)) {
            $criteria->add(CompanyTableMap::COL_DELTED, $this->delted);
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
        $criteria = ChildCompanyQuery::create();
        $criteria->add(CompanyTableMap::COL_COMPANYID, $this->companyid);

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
        $validPk = null !== $this->getCompanyid();

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
        return $this->getCompanyid();
    }

    /**
     * Generic method to set the primary key (companyid column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setCompanyid($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getCompanyid();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Company (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setApikey($this->getApikey());
        $copyObj->setLocationid($this->getLocationid());
        $copyObj->setName($this->getName());
        $copyObj->setTelephone($this->getTelephone());
        $copyObj->setDelted($this->getDelted());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getOffers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addOffer($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProducts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProduct($relObj->copy($deepCopy));
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
            $copyObj->setCompanyid(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Company Clone of current object.
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
     * Declares an association between this object and a ChildLocation object.
     *
     * @param  ChildLocation $v
     * @return $this|\Company The current object (for fluent API support)
     * @throws PropelException
     */
    public function setLocation(ChildLocation $v = null)
    {
        if ($v === null) {
            $this->setLocationid(NULL);
        } else {
            $this->setLocationid($v->getLocationid());
        }

        $this->aLocation = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildLocation object, it will not be re-added.
        if ($v !== null) {
            $v->addCompany($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildLocation object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildLocation The associated ChildLocation object.
     * @throws PropelException
     */
    public function getLocation(ConnectionInterface $con = null)
    {
        if ($this->aLocation === null && ($this->locationid !== null)) {
            $this->aLocation = ChildLocationQuery::create()->findPk($this->locationid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aLocation->addCompanies($this);
             */
        }

        return $this->aLocation;
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
        if ('Offer' == $relationName) {
            return $this->initOffers();
        }
        if ('Product' == $relationName) {
            return $this->initProducts();
        }
        if ('Vendingmachine' == $relationName) {
            return $this->initVendingmachines();
        }
    }

    /**
     * Clears out the collOffers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addOffers()
     */
    public function clearOffers()
    {
        $this->collOffers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collOffers collection loaded partially.
     */
    public function resetPartialOffers($v = true)
    {
        $this->collOffersPartial = $v;
    }

    /**
     * Initializes the collOffers collection.
     *
     * By default this just sets the collOffers collection to an empty array (like clearcollOffers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initOffers($overrideExisting = true)
    {
        if (null !== $this->collOffers && !$overrideExisting) {
            return;
        }
        $this->collOffers = new ObjectCollection();
        $this->collOffers->setModel('\Offer');
    }

    /**
     * Gets an array of ChildOffer objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCompany is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildOffer[] List of ChildOffer objects
     * @throws PropelException
     */
    public function getOffers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collOffersPartial && !$this->isNew();
        if (null === $this->collOffers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collOffers) {
                // return empty collection
                $this->initOffers();
            } else {
                $collOffers = ChildOfferQuery::create(null, $criteria)
                    ->filterByCompany($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collOffersPartial && count($collOffers)) {
                        $this->initOffers(false);

                        foreach ($collOffers as $obj) {
                            if (false == $this->collOffers->contains($obj)) {
                                $this->collOffers->append($obj);
                            }
                        }

                        $this->collOffersPartial = true;
                    }

                    return $collOffers;
                }

                if ($partial && $this->collOffers) {
                    foreach ($this->collOffers as $obj) {
                        if ($obj->isNew()) {
                            $collOffers[] = $obj;
                        }
                    }
                }

                $this->collOffers = $collOffers;
                $this->collOffersPartial = false;
            }
        }

        return $this->collOffers;
    }

    /**
     * Sets a collection of ChildOffer objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $offers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCompany The current object (for fluent API support)
     */
    public function setOffers(Collection $offers, ConnectionInterface $con = null)
    {
        /** @var ChildOffer[] $offersToDelete */
        $offersToDelete = $this->getOffers(new Criteria(), $con)->diff($offers);


        $this->offersScheduledForDeletion = $offersToDelete;

        foreach ($offersToDelete as $offerRemoved) {
            $offerRemoved->setCompany(null);
        }

        $this->collOffers = null;
        foreach ($offers as $offer) {
            $this->addOffer($offer);
        }

        $this->collOffers = $offers;
        $this->collOffersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Offer objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Offer objects.
     * @throws PropelException
     */
    public function countOffers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collOffersPartial && !$this->isNew();
        if (null === $this->collOffers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collOffers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getOffers());
            }

            $query = ChildOfferQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCompany($this)
                ->count($con);
        }

        return count($this->collOffers);
    }

    /**
     * Method called to associate a ChildOffer object to this object
     * through the ChildOffer foreign key attribute.
     *
     * @param  ChildOffer $l ChildOffer
     * @return $this|\Company The current object (for fluent API support)
     */
    public function addOffer(ChildOffer $l)
    {
        if ($this->collOffers === null) {
            $this->initOffers();
            $this->collOffersPartial = true;
        }

        if (!$this->collOffers->contains($l)) {
            $this->doAddOffer($l);
        }

        return $this;
    }

    /**
     * @param ChildOffer $offer The ChildOffer object to add.
     */
    protected function doAddOffer(ChildOffer $offer)
    {
        $this->collOffers[]= $offer;
        $offer->setCompany($this);
    }

    /**
     * @param  ChildOffer $offer The ChildOffer object to remove.
     * @return $this|ChildCompany The current object (for fluent API support)
     */
    public function removeOffer(ChildOffer $offer)
    {
        if ($this->getOffers()->contains($offer)) {
            $pos = $this->collOffers->search($offer);
            $this->collOffers->remove($pos);
            if (null === $this->offersScheduledForDeletion) {
                $this->offersScheduledForDeletion = clone $this->collOffers;
                $this->offersScheduledForDeletion->clear();
            }
            $this->offersScheduledForDeletion[]= clone $offer;
            $offer->setCompany(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Company is new, it will return
     * an empty collection; or if this Company has previously
     * been saved, it will retrieve related Offers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Company.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildOffer[] List of ChildOffer objects
     */
    public function getOffersJoinProduct(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildOfferQuery::create(null, $criteria);
        $query->joinWith('Product', $joinBehavior);

        return $this->getOffers($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Company is new, it will return
     * an empty collection; or if this Company has previously
     * been saved, it will retrieve related Offers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Company.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildOffer[] List of ChildOffer objects
     */
    public function getOffersJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildOfferQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getOffers($query, $con);
    }

    /**
     * Clears out the collProducts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addProducts()
     */
    public function clearProducts()
    {
        $this->collProducts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collProducts collection loaded partially.
     */
    public function resetPartialProducts($v = true)
    {
        $this->collProductsPartial = $v;
    }

    /**
     * Initializes the collProducts collection.
     *
     * By default this just sets the collProducts collection to an empty array (like clearcollProducts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProducts($overrideExisting = true)
    {
        if (null !== $this->collProducts && !$overrideExisting) {
            return;
        }
        $this->collProducts = new ObjectCollection();
        $this->collProducts->setModel('\Product');
    }

    /**
     * Gets an array of ChildProduct objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCompany is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildProduct[] List of ChildProduct objects
     * @throws PropelException
     */
    public function getProducts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collProductsPartial && !$this->isNew();
        if (null === $this->collProducts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProducts) {
                // return empty collection
                $this->initProducts();
            } else {
                $collProducts = ChildProductQuery::create(null, $criteria)
                    ->filterByCompany($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collProductsPartial && count($collProducts)) {
                        $this->initProducts(false);

                        foreach ($collProducts as $obj) {
                            if (false == $this->collProducts->contains($obj)) {
                                $this->collProducts->append($obj);
                            }
                        }

                        $this->collProductsPartial = true;
                    }

                    return $collProducts;
                }

                if ($partial && $this->collProducts) {
                    foreach ($this->collProducts as $obj) {
                        if ($obj->isNew()) {
                            $collProducts[] = $obj;
                        }
                    }
                }

                $this->collProducts = $collProducts;
                $this->collProductsPartial = false;
            }
        }

        return $this->collProducts;
    }

    /**
     * Sets a collection of ChildProduct objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $products A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCompany The current object (for fluent API support)
     */
    public function setProducts(Collection $products, ConnectionInterface $con = null)
    {
        /** @var ChildProduct[] $productsToDelete */
        $productsToDelete = $this->getProducts(new Criteria(), $con)->diff($products);


        $this->productsScheduledForDeletion = $productsToDelete;

        foreach ($productsToDelete as $productRemoved) {
            $productRemoved->setCompany(null);
        }

        $this->collProducts = null;
        foreach ($products as $product) {
            $this->addProduct($product);
        }

        $this->collProducts = $products;
        $this->collProductsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Product objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Product objects.
     * @throws PropelException
     */
    public function countProducts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collProductsPartial && !$this->isNew();
        if (null === $this->collProducts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProducts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getProducts());
            }

            $query = ChildProductQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCompany($this)
                ->count($con);
        }

        return count($this->collProducts);
    }

    /**
     * Method called to associate a ChildProduct object to this object
     * through the ChildProduct foreign key attribute.
     *
     * @param  ChildProduct $l ChildProduct
     * @return $this|\Company The current object (for fluent API support)
     */
    public function addProduct(ChildProduct $l)
    {
        if ($this->collProducts === null) {
            $this->initProducts();
            $this->collProductsPartial = true;
        }

        if (!$this->collProducts->contains($l)) {
            $this->doAddProduct($l);
        }

        return $this;
    }

    /**
     * @param ChildProduct $product The ChildProduct object to add.
     */
    protected function doAddProduct(ChildProduct $product)
    {
        $this->collProducts[]= $product;
        $product->setCompany($this);
    }

    /**
     * @param  ChildProduct $product The ChildProduct object to remove.
     * @return $this|ChildCompany The current object (for fluent API support)
     */
    public function removeProduct(ChildProduct $product)
    {
        if ($this->getProducts()->contains($product)) {
            $pos = $this->collProducts->search($product);
            $this->collProducts->remove($pos);
            if (null === $this->productsScheduledForDeletion) {
                $this->productsScheduledForDeletion = clone $this->collProducts;
                $this->productsScheduledForDeletion->clear();
            }
            $this->productsScheduledForDeletion[]= clone $product;
            $product->setCompany(null);
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
     * If this ChildCompany is new, it will return
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
                    ->filterByCompany($this)
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
     * @return $this|ChildCompany The current object (for fluent API support)
     */
    public function setVendingmachines(Collection $vendingmachines, ConnectionInterface $con = null)
    {
        /** @var ChildVendingmachine[] $vendingmachinesToDelete */
        $vendingmachinesToDelete = $this->getVendingmachines(new Criteria(), $con)->diff($vendingmachines);


        $this->vendingmachinesScheduledForDeletion = $vendingmachinesToDelete;

        foreach ($vendingmachinesToDelete as $vendingmachineRemoved) {
            $vendingmachineRemoved->setCompany(null);
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
                ->filterByCompany($this)
                ->count($con);
        }

        return count($this->collVendingmachines);
    }

    /**
     * Method called to associate a ChildVendingmachine object to this object
     * through the ChildVendingmachine foreign key attribute.
     *
     * @param  ChildVendingmachine $l ChildVendingmachine
     * @return $this|\Company The current object (for fluent API support)
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
        $vendingmachine->setCompany($this);
    }

    /**
     * @param  ChildVendingmachine $vendingmachine The ChildVendingmachine object to remove.
     * @return $this|ChildCompany The current object (for fluent API support)
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
            $vendingmachine->setCompany(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Company is new, it will return
     * an empty collection; or if this Company has previously
     * been saved, it will retrieve related Vendingmachines from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Company.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildVendingmachine[] List of ChildVendingmachine objects
     */
    public function getVendingmachinesJoinLocation(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildVendingmachineQuery::create(null, $criteria);
        $query->joinWith('Location', $joinBehavior);

        return $this->getVendingmachines($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aLocation) {
            $this->aLocation->removeCompany($this);
        }
        $this->companyid = null;
        $this->apikey = null;
        $this->locationid = null;
        $this->name = null;
        $this->telephone = null;
        $this->delted = null;
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
            if ($this->collOffers) {
                foreach ($this->collOffers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProducts) {
                foreach ($this->collProducts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collVendingmachines) {
                foreach ($this->collVendingmachines as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collOffers = null;
        $this->collProducts = null;
        $this->collVendingmachines = null;
        $this->aLocation = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CompanyTableMap::DEFAULT_STRING_FORMAT);
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

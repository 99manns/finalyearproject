<?php

namespace Base;

use \ItemQuery as ChildItemQuery;
use \Offer as ChildOffer;
use \OfferQuery as ChildOfferQuery;
use \Product as ChildProduct;
use \ProductQuery as ChildProductQuery;
use \User as ChildUser;
use \UserQuery as ChildUserQuery;
use \Vendingmachine as ChildVendingmachine;
use \VendingmachineQuery as ChildVendingmachineQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\ItemTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'item' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Item implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ItemTableMap';


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
     * The value for the itemid field.
     * @var        int
     */
    protected $itemid;

    /**
     * The value for the productid field.
     * @var        int
     */
    protected $productid;

    /**
     * The value for the userid field.
     * @var        int
     */
    protected $userid;

    /**
     * The value for the vendingmachineid field.
     * @var        int
     */
    protected $vendingmachineid;

    /**
     * The value for the offerid field.
     * @var        int
     */
    protected $offerid;

    /**
     * The value for the purchaseprice field.
     * @var        string
     */
    protected $purchaseprice;

    /**
     * The value for the saleprice field.
     * @var        string
     */
    protected $saleprice;

    /**
     * The value for the addeddate field.
     * @var        \DateTime
     */
    protected $addeddate;

    /**
     * @var        ChildOffer
     */
    protected $aOffer;

    /**
     * @var        ChildProduct
     */
    protected $aProduct;

    /**
     * @var        ChildUser
     */
    protected $aUser;

    /**
     * @var        ChildVendingmachine
     */
    protected $aVendingmachine;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of Base\Item object.
     */
    public function __construct()
    {
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
     * Compares this with another <code>Item</code> instance.  If
     * <code>obj</code> is an instance of <code>Item</code>, delegates to
     * <code>equals(Item)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Item The current object, for fluid interface
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
     * Get the [itemid] column value.
     *
     * @return int
     */
    public function getItemid()
    {
        return $this->itemid;
    }

    /**
     * Get the [productid] column value.
     *
     * @return int
     */
    public function getProductid()
    {
        return $this->productid;
    }

    /**
     * Get the [userid] column value.
     *
     * @return int
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Get the [vendingmachineid] column value.
     *
     * @return int
     */
    public function getVendingmachineid()
    {
        return $this->vendingmachineid;
    }

    /**
     * Get the [offerid] column value.
     *
     * @return int
     */
    public function getOfferid()
    {
        return $this->offerid;
    }

    /**
     * Get the [purchaseprice] column value.
     *
     * @return string
     */
    public function getPurchaseprice()
    {
        return $this->purchaseprice;
    }

    /**
     * Get the [saleprice] column value.
     *
     * @return string
     */
    public function getSaleprice()
    {
        return $this->saleprice;
    }

    /**
     * Get the [optionally formatted] temporal [addeddate] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getAddeddate($format = NULL)
    {
        if ($format === null) {
            return $this->addeddate;
        } else {
            return $this->addeddate instanceof \DateTime ? $this->addeddate->format($format) : null;
        }
    }

    /**
     * Set the value of [itemid] column.
     *
     * @param int $v new value
     * @return $this|\Item The current object (for fluent API support)
     */
    public function setItemid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->itemid !== $v) {
            $this->itemid = $v;
            $this->modifiedColumns[ItemTableMap::COL_ITEMID] = true;
        }

        return $this;
    } // setItemid()

    /**
     * Set the value of [productid] column.
     *
     * @param int $v new value
     * @return $this|\Item The current object (for fluent API support)
     */
    public function setProductid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->productid !== $v) {
            $this->productid = $v;
            $this->modifiedColumns[ItemTableMap::COL_PRODUCTID] = true;
        }

        if ($this->aProduct !== null && $this->aProduct->getProductid() !== $v) {
            $this->aProduct = null;
        }

        return $this;
    } // setProductid()

    /**
     * Set the value of [userid] column.
     *
     * @param int $v new value
     * @return $this|\Item The current object (for fluent API support)
     */
    public function setUserid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->userid !== $v) {
            $this->userid = $v;
            $this->modifiedColumns[ItemTableMap::COL_USERID] = true;
        }

        if ($this->aUser !== null && $this->aUser->getUserid() !== $v) {
            $this->aUser = null;
        }

        return $this;
    } // setUserid()

    /**
     * Set the value of [vendingmachineid] column.
     *
     * @param int $v new value
     * @return $this|\Item The current object (for fluent API support)
     */
    public function setVendingmachineid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->vendingmachineid !== $v) {
            $this->vendingmachineid = $v;
            $this->modifiedColumns[ItemTableMap::COL_VENDINGMACHINEID] = true;
        }

        if ($this->aVendingmachine !== null && $this->aVendingmachine->getVendingmachineid() !== $v) {
            $this->aVendingmachine = null;
        }

        return $this;
    } // setVendingmachineid()

    /**
     * Set the value of [offerid] column.
     *
     * @param int $v new value
     * @return $this|\Item The current object (for fluent API support)
     */
    public function setOfferid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->offerid !== $v) {
            $this->offerid = $v;
            $this->modifiedColumns[ItemTableMap::COL_OFFERID] = true;
        }

        if ($this->aOffer !== null && $this->aOffer->getOfferid() !== $v) {
            $this->aOffer = null;
        }

        return $this;
    } // setOfferid()

    /**
     * Set the value of [purchaseprice] column.
     *
     * @param string $v new value
     * @return $this|\Item The current object (for fluent API support)
     */
    public function setPurchaseprice($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->purchaseprice !== $v) {
            $this->purchaseprice = $v;
            $this->modifiedColumns[ItemTableMap::COL_PURCHASEPRICE] = true;
        }

        return $this;
    } // setPurchaseprice()

    /**
     * Set the value of [saleprice] column.
     *
     * @param string $v new value
     * @return $this|\Item The current object (for fluent API support)
     */
    public function setSaleprice($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->saleprice !== $v) {
            $this->saleprice = $v;
            $this->modifiedColumns[ItemTableMap::COL_SALEPRICE] = true;
        }

        return $this;
    } // setSaleprice()

    /**
     * Sets the value of [addeddate] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Item The current object (for fluent API support)
     */
    public function setAddeddate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->addeddate !== null || $dt !== null) {
            if ($this->addeddate === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->addeddate->format("Y-m-d H:i:s")) {
                $this->addeddate = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ItemTableMap::COL_ADDEDDATE] = true;
            }
        } // if either are not null

        return $this;
    } // setAddeddate()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ItemTableMap::translateFieldName('Itemid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->itemid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ItemTableMap::translateFieldName('Productid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->productid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ItemTableMap::translateFieldName('Userid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->userid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ItemTableMap::translateFieldName('Vendingmachineid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->vendingmachineid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ItemTableMap::translateFieldName('Offerid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->offerid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ItemTableMap::translateFieldName('Purchaseprice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->purchaseprice = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ItemTableMap::translateFieldName('Saleprice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->saleprice = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ItemTableMap::translateFieldName('Addeddate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->addeddate = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = ItemTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Item'), 0, $e);
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
        if ($this->aProduct !== null && $this->productid !== $this->aProduct->getProductid()) {
            $this->aProduct = null;
        }
        if ($this->aUser !== null && $this->userid !== $this->aUser->getUserid()) {
            $this->aUser = null;
        }
        if ($this->aVendingmachine !== null && $this->vendingmachineid !== $this->aVendingmachine->getVendingmachineid()) {
            $this->aVendingmachine = null;
        }
        if ($this->aOffer !== null && $this->offerid !== $this->aOffer->getOfferid()) {
            $this->aOffer = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(ItemTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildItemQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aOffer = null;
            $this->aProduct = null;
            $this->aUser = null;
            $this->aVendingmachine = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Item::setDeleted()
     * @see Item::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildItemQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
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
                ItemTableMap::addInstanceToPool($this);
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

            if ($this->aOffer !== null) {
                if ($this->aOffer->isModified() || $this->aOffer->isNew()) {
                    $affectedRows += $this->aOffer->save($con);
                }
                $this->setOffer($this->aOffer);
            }

            if ($this->aProduct !== null) {
                if ($this->aProduct->isModified() || $this->aProduct->isNew()) {
                    $affectedRows += $this->aProduct->save($con);
                }
                $this->setProduct($this->aProduct);
            }

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

            if ($this->aVendingmachine !== null) {
                if ($this->aVendingmachine->isModified() || $this->aVendingmachine->isNew()) {
                    $affectedRows += $this->aVendingmachine->save($con);
                }
                $this->setVendingmachine($this->aVendingmachine);
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

        $this->modifiedColumns[ItemTableMap::COL_ITEMID] = true;
        if (null !== $this->itemid) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ItemTableMap::COL_ITEMID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ItemTableMap::COL_ITEMID)) {
            $modifiedColumns[':p' . $index++]  = 'ItemID';
        }
        if ($this->isColumnModified(ItemTableMap::COL_PRODUCTID)) {
            $modifiedColumns[':p' . $index++]  = 'ProductID';
        }
        if ($this->isColumnModified(ItemTableMap::COL_USERID)) {
            $modifiedColumns[':p' . $index++]  = 'UserID';
        }
        if ($this->isColumnModified(ItemTableMap::COL_VENDINGMACHINEID)) {
            $modifiedColumns[':p' . $index++]  = 'vendingmachineID';
        }
        if ($this->isColumnModified(ItemTableMap::COL_OFFERID)) {
            $modifiedColumns[':p' . $index++]  = 'OfferID';
        }
        if ($this->isColumnModified(ItemTableMap::COL_PURCHASEPRICE)) {
            $modifiedColumns[':p' . $index++]  = 'PurchasePrice';
        }
        if ($this->isColumnModified(ItemTableMap::COL_SALEPRICE)) {
            $modifiedColumns[':p' . $index++]  = 'SalePrice';
        }
        if ($this->isColumnModified(ItemTableMap::COL_ADDEDDATE)) {
            $modifiedColumns[':p' . $index++]  = 'AddedDate';
        }

        $sql = sprintf(
            'INSERT INTO item (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ItemID':
                        $stmt->bindValue($identifier, $this->itemid, PDO::PARAM_INT);
                        break;
                    case 'ProductID':
                        $stmt->bindValue($identifier, $this->productid, PDO::PARAM_INT);
                        break;
                    case 'UserID':
                        $stmt->bindValue($identifier, $this->userid, PDO::PARAM_INT);
                        break;
                    case 'vendingmachineID':
                        $stmt->bindValue($identifier, $this->vendingmachineid, PDO::PARAM_INT);
                        break;
                    case 'OfferID':
                        $stmt->bindValue($identifier, $this->offerid, PDO::PARAM_INT);
                        break;
                    case 'PurchasePrice':
                        $stmt->bindValue($identifier, $this->purchaseprice, PDO::PARAM_STR);
                        break;
                    case 'SalePrice':
                        $stmt->bindValue($identifier, $this->saleprice, PDO::PARAM_STR);
                        break;
                    case 'AddedDate':
                        $stmt->bindValue($identifier, $this->addeddate ? $this->addeddate->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
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
        $this->setItemid($pk);

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
        $pos = ItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getItemid();
                break;
            case 1:
                return $this->getProductid();
                break;
            case 2:
                return $this->getUserid();
                break;
            case 3:
                return $this->getVendingmachineid();
                break;
            case 4:
                return $this->getOfferid();
                break;
            case 5:
                return $this->getPurchaseprice();
                break;
            case 6:
                return $this->getSaleprice();
                break;
            case 7:
                return $this->getAddeddate();
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

        if (isset($alreadyDumpedObjects['Item'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Item'][$this->hashCode()] = true;
        $keys = ItemTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getItemid(),
            $keys[1] => $this->getProductid(),
            $keys[2] => $this->getUserid(),
            $keys[3] => $this->getVendingmachineid(),
            $keys[4] => $this->getOfferid(),
            $keys[5] => $this->getPurchaseprice(),
            $keys[6] => $this->getSaleprice(),
            $keys[7] => $this->getAddeddate(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[7]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[7]];
            $result[$keys[7]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aOffer) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'offer';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'offer';
                        break;
                    default:
                        $key = 'Offer';
                }

                $result[$key] = $this->aOffer->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aProduct) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'product';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'product';
                        break;
                    default:
                        $key = 'Product';
                }

                $result[$key] = $this->aProduct->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUser) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'user';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user';
                        break;
                    default:
                        $key = 'User';
                }

                $result[$key] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aVendingmachine) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'vendingmachine';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'vendingmachine';
                        break;
                    default:
                        $key = 'Vendingmachine';
                }

                $result[$key] = $this->aVendingmachine->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\Item
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Item
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setItemid($value);
                break;
            case 1:
                $this->setProductid($value);
                break;
            case 2:
                $this->setUserid($value);
                break;
            case 3:
                $this->setVendingmachineid($value);
                break;
            case 4:
                $this->setOfferid($value);
                break;
            case 5:
                $this->setPurchaseprice($value);
                break;
            case 6:
                $this->setSaleprice($value);
                break;
            case 7:
                $this->setAddeddate($value);
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
        $keys = ItemTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setItemid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setProductid($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setUserid($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setVendingmachineid($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setOfferid($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPurchaseprice($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setSaleprice($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setAddeddate($arr[$keys[7]]);
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
     * @return $this|\Item The current object, for fluid interface
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
        $criteria = new Criteria(ItemTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ItemTableMap::COL_ITEMID)) {
            $criteria->add(ItemTableMap::COL_ITEMID, $this->itemid);
        }
        if ($this->isColumnModified(ItemTableMap::COL_PRODUCTID)) {
            $criteria->add(ItemTableMap::COL_PRODUCTID, $this->productid);
        }
        if ($this->isColumnModified(ItemTableMap::COL_USERID)) {
            $criteria->add(ItemTableMap::COL_USERID, $this->userid);
        }
        if ($this->isColumnModified(ItemTableMap::COL_VENDINGMACHINEID)) {
            $criteria->add(ItemTableMap::COL_VENDINGMACHINEID, $this->vendingmachineid);
        }
        if ($this->isColumnModified(ItemTableMap::COL_OFFERID)) {
            $criteria->add(ItemTableMap::COL_OFFERID, $this->offerid);
        }
        if ($this->isColumnModified(ItemTableMap::COL_PURCHASEPRICE)) {
            $criteria->add(ItemTableMap::COL_PURCHASEPRICE, $this->purchaseprice);
        }
        if ($this->isColumnModified(ItemTableMap::COL_SALEPRICE)) {
            $criteria->add(ItemTableMap::COL_SALEPRICE, $this->saleprice);
        }
        if ($this->isColumnModified(ItemTableMap::COL_ADDEDDATE)) {
            $criteria->add(ItemTableMap::COL_ADDEDDATE, $this->addeddate);
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
        $criteria = ChildItemQuery::create();
        $criteria->add(ItemTableMap::COL_ITEMID, $this->itemid);

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
        $validPk = null !== $this->getItemid();

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
        return $this->getItemid();
    }

    /**
     * Generic method to set the primary key (itemid column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setItemid($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getItemid();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Item (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setProductid($this->getProductid());
        $copyObj->setUserid($this->getUserid());
        $copyObj->setVendingmachineid($this->getVendingmachineid());
        $copyObj->setOfferid($this->getOfferid());
        $copyObj->setPurchaseprice($this->getPurchaseprice());
        $copyObj->setSaleprice($this->getSaleprice());
        $copyObj->setAddeddate($this->getAddeddate());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setItemid(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Item Clone of current object.
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
     * Declares an association between this object and a ChildOffer object.
     *
     * @param  ChildOffer $v
     * @return $this|\Item The current object (for fluent API support)
     * @throws PropelException
     */
    public function setOffer(ChildOffer $v = null)
    {
        if ($v === null) {
            $this->setOfferid(NULL);
        } else {
            $this->setOfferid($v->getOfferid());
        }

        $this->aOffer = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildOffer object, it will not be re-added.
        if ($v !== null) {
            $v->addItem($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildOffer object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildOffer The associated ChildOffer object.
     * @throws PropelException
     */
    public function getOffer(ConnectionInterface $con = null)
    {
        if ($this->aOffer === null && ($this->offerid !== null)) {
            $this->aOffer = ChildOfferQuery::create()->findPk($this->offerid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aOffer->addItems($this);
             */
        }

        return $this->aOffer;
    }

    /**
     * Declares an association between this object and a ChildProduct object.
     *
     * @param  ChildProduct $v
     * @return $this|\Item The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProduct(ChildProduct $v = null)
    {
        if ($v === null) {
            $this->setProductid(NULL);
        } else {
            $this->setProductid($v->getProductid());
        }

        $this->aProduct = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildProduct object, it will not be re-added.
        if ($v !== null) {
            $v->addItem($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildProduct object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildProduct The associated ChildProduct object.
     * @throws PropelException
     */
    public function getProduct(ConnectionInterface $con = null)
    {
        if ($this->aProduct === null && ($this->productid !== null)) {
            $this->aProduct = ChildProductQuery::create()->findPk($this->productid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProduct->addItems($this);
             */
        }

        return $this->aProduct;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Item The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setUserid(NULL);
        } else {
            $this->setUserid($v->getUserid());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addItem($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUser object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUser The associated ChildUser object.
     * @throws PropelException
     */
    public function getUser(ConnectionInterface $con = null)
    {
        if ($this->aUser === null && ($this->userid !== null)) {
            $this->aUser = ChildUserQuery::create()->findPk($this->userid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addItems($this);
             */
        }

        return $this->aUser;
    }

    /**
     * Declares an association between this object and a ChildVendingmachine object.
     *
     * @param  ChildVendingmachine $v
     * @return $this|\Item The current object (for fluent API support)
     * @throws PropelException
     */
    public function setVendingmachine(ChildVendingmachine $v = null)
    {
        if ($v === null) {
            $this->setVendingmachineid(NULL);
        } else {
            $this->setVendingmachineid($v->getVendingmachineid());
        }

        $this->aVendingmachine = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildVendingmachine object, it will not be re-added.
        if ($v !== null) {
            $v->addItem($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildVendingmachine object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildVendingmachine The associated ChildVendingmachine object.
     * @throws PropelException
     */
    public function getVendingmachine(ConnectionInterface $con = null)
    {
        if ($this->aVendingmachine === null && ($this->vendingmachineid !== null)) {
            $this->aVendingmachine = ChildVendingmachineQuery::create()->findPk($this->vendingmachineid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aVendingmachine->addItems($this);
             */
        }

        return $this->aVendingmachine;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aOffer) {
            $this->aOffer->removeItem($this);
        }
        if (null !== $this->aProduct) {
            $this->aProduct->removeItem($this);
        }
        if (null !== $this->aUser) {
            $this->aUser->removeItem($this);
        }
        if (null !== $this->aVendingmachine) {
            $this->aVendingmachine->removeItem($this);
        }
        $this->itemid = null;
        $this->productid = null;
        $this->userid = null;
        $this->vendingmachineid = null;
        $this->offerid = null;
        $this->purchaseprice = null;
        $this->saleprice = null;
        $this->addeddate = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
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
        } // if ($deep)

        $this->aOffer = null;
        $this->aProduct = null;
        $this->aUser = null;
        $this->aVendingmachine = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ItemTableMap::DEFAULT_STRING_FORMAT);
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

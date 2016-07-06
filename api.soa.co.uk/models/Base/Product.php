<?php

namespace Base;

use \Company as ChildCompany;
use \CompanyQuery as ChildCompanyQuery;
use \Item as ChildItem;
use \ItemQuery as ChildItemQuery;
use \Offer as ChildOffer;
use \OfferQuery as ChildOfferQuery;
use \Product as ChildProduct;
use \ProductQuery as ChildProductQuery;
use \Stock as ChildStock;
use \StockQuery as ChildStockQuery;
use \Exception;
use \PDO;
use Map\ProductTableMap;
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
 * Base class that represents a row from the 'product' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Product implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ProductTableMap';


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
     * The value for the productid field.
     * @var        int
     */
    protected $productid;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * The value for the companyid field.
     * @var        int
     */
    protected $companyid;

    /**
     * The value for the image field.
     * @var        string
     */
    protected $image;

    /**
     * The value for the delted field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $delted;

    /**
     * The value for the purchaseprice field.
     * @var        string
     */
    protected $purchaseprice;

    /**
     * @var        ChildCompany
     */
    protected $aCompany;

    /**
     * @var        ObjectCollection|ChildItem[] Collection to store aggregation of ChildItem objects.
     */
    protected $collItems;
    protected $collItemsPartial;

    /**
     * @var        ObjectCollection|ChildOffer[] Collection to store aggregation of ChildOffer objects.
     */
    protected $collOffers;
    protected $collOffersPartial;

    /**
     * @var        ObjectCollection|ChildStock[] Collection to store aggregation of ChildStock objects.
     */
    protected $collStocks;
    protected $collStocksPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildItem[]
     */
    protected $itemsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildOffer[]
     */
    protected $offersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStock[]
     */
    protected $stocksScheduledForDeletion = null;

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
     * Initializes internal state of Base\Product object.
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
     * Compares this with another <code>Product</code> instance.  If
     * <code>obj</code> is an instance of <code>Product</code>, delegates to
     * <code>equals(Product)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Product The current object, for fluid interface
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
     * Get the [productid] column value.
     *
     * @return int
     */
    public function getProductid()
    {
        return $this->productid;
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
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * Get the [image] column value.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
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
     * Get the [purchaseprice] column value.
     *
     * @return string
     */
    public function getPurchaseprice()
    {
        return $this->purchaseprice;
    }

    /**
     * Set the value of [productid] column.
     *
     * @param int $v new value
     * @return $this|\Product The current object (for fluent API support)
     */
    public function setProductid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->productid !== $v) {
            $this->productid = $v;
            $this->modifiedColumns[ProductTableMap::COL_PRODUCTID] = true;
        }

        return $this;
    } // setProductid()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Product The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[ProductTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return $this|\Product The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[ProductTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Set the value of [companyid] column.
     *
     * @param int $v new value
     * @return $this|\Product The current object (for fluent API support)
     */
    public function setCompanyid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->companyid !== $v) {
            $this->companyid = $v;
            $this->modifiedColumns[ProductTableMap::COL_COMPANYID] = true;
        }

        if ($this->aCompany !== null && $this->aCompany->getCompanyid() !== $v) {
            $this->aCompany = null;
        }

        return $this;
    } // setCompanyid()

    /**
     * Set the value of [image] column.
     *
     * @param string $v new value
     * @return $this|\Product The current object (for fluent API support)
     */
    public function setImage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->image !== $v) {
            $this->image = $v;
            $this->modifiedColumns[ProductTableMap::COL_IMAGE] = true;
        }

        return $this;
    } // setImage()

    /**
     * Sets the value of the [delted] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Product The current object (for fluent API support)
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
            $this->modifiedColumns[ProductTableMap::COL_DELTED] = true;
        }

        return $this;
    } // setDelted()

    /**
     * Set the value of [purchaseprice] column.
     *
     * @param string $v new value
     * @return $this|\Product The current object (for fluent API support)
     */
    public function setPurchaseprice($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->purchaseprice !== $v) {
            $this->purchaseprice = $v;
            $this->modifiedColumns[ProductTableMap::COL_PURCHASEPRICE] = true;
        }

        return $this;
    } // setPurchaseprice()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ProductTableMap::translateFieldName('Productid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->productid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ProductTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ProductTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ProductTableMap::translateFieldName('Companyid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->companyid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ProductTableMap::translateFieldName('Image', TableMap::TYPE_PHPNAME, $indexType)];
            $this->image = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ProductTableMap::translateFieldName('Delted', TableMap::TYPE_PHPNAME, $indexType)];
            $this->delted = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ProductTableMap::translateFieldName('Purchaseprice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->purchaseprice = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = ProductTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Product'), 0, $e);
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
        if ($this->aCompany !== null && $this->companyid !== $this->aCompany->getCompanyid()) {
            $this->aCompany = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(ProductTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildProductQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCompany = null;
            $this->collItems = null;

            $this->collOffers = null;

            $this->collStocks = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Product::setDeleted()
     * @see Product::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildProductQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProductTableMap::DATABASE_NAME);
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
                ProductTableMap::addInstanceToPool($this);
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

            if ($this->aCompany !== null) {
                if ($this->aCompany->isModified() || $this->aCompany->isNew()) {
                    $affectedRows += $this->aCompany->save($con);
                }
                $this->setCompany($this->aCompany);
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

            if ($this->itemsScheduledForDeletion !== null) {
                if (!$this->itemsScheduledForDeletion->isEmpty()) {
                    \ItemQuery::create()
                        ->filterByPrimaryKeys($this->itemsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->itemsScheduledForDeletion = null;
                }
            }

            if ($this->collItems !== null) {
                foreach ($this->collItems as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->offersScheduledForDeletion !== null) {
                if (!$this->offersScheduledForDeletion->isEmpty()) {
                    foreach ($this->offersScheduledForDeletion as $offer) {
                        // need to save related object because we set the relation to null
                        $offer->save($con);
                    }
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

            if ($this->stocksScheduledForDeletion !== null) {
                if (!$this->stocksScheduledForDeletion->isEmpty()) {
                    \StockQuery::create()
                        ->filterByPrimaryKeys($this->stocksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->stocksScheduledForDeletion = null;
                }
            }

            if ($this->collStocks !== null) {
                foreach ($this->collStocks as $referrerFK) {
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

        $this->modifiedColumns[ProductTableMap::COL_PRODUCTID] = true;
        if (null !== $this->productid) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ProductTableMap::COL_PRODUCTID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProductTableMap::COL_PRODUCTID)) {
            $modifiedColumns[':p' . $index++]  = 'ProductID';
        }
        if ($this->isColumnModified(ProductTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'Name';
        }
        if ($this->isColumnModified(ProductTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'Description';
        }
        if ($this->isColumnModified(ProductTableMap::COL_COMPANYID)) {
            $modifiedColumns[':p' . $index++]  = 'CompanyID';
        }
        if ($this->isColumnModified(ProductTableMap::COL_IMAGE)) {
            $modifiedColumns[':p' . $index++]  = 'Image';
        }
        if ($this->isColumnModified(ProductTableMap::COL_DELTED)) {
            $modifiedColumns[':p' . $index++]  = 'delted';
        }
        if ($this->isColumnModified(ProductTableMap::COL_PURCHASEPRICE)) {
            $modifiedColumns[':p' . $index++]  = 'Purchaseprice';
        }

        $sql = sprintf(
            'INSERT INTO product (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ProductID':
                        $stmt->bindValue($identifier, $this->productid, PDO::PARAM_INT);
                        break;
                    case 'Name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'Description':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'CompanyID':
                        $stmt->bindValue($identifier, $this->companyid, PDO::PARAM_INT);
                        break;
                    case 'Image':
                        $stmt->bindValue($identifier, $this->image, PDO::PARAM_STR);
                        break;
                    case 'delted':
                        $stmt->bindValue($identifier, (int) $this->delted, PDO::PARAM_INT);
                        break;
                    case 'Purchaseprice':
                        $stmt->bindValue($identifier, $this->purchaseprice, PDO::PARAM_STR);
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
        $this->setProductid($pk);

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
        $pos = ProductTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getProductid();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getDescription();
                break;
            case 3:
                return $this->getCompanyid();
                break;
            case 4:
                return $this->getImage();
                break;
            case 5:
                return $this->getDelted();
                break;
            case 6:
                return $this->getPurchaseprice();
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

        if (isset($alreadyDumpedObjects['Product'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Product'][$this->hashCode()] = true;
        $keys = ProductTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getProductid(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getDescription(),
            $keys[3] => $this->getCompanyid(),
            $keys[4] => $this->getImage(),
            $keys[5] => $this->getDelted(),
            $keys[6] => $this->getPurchaseprice(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aCompany) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'company';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'company';
                        break;
                    default:
                        $key = 'Company';
                }

                $result[$key] = $this->aCompany->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collItems) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'items';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'items';
                        break;
                    default:
                        $key = 'Items';
                }

                $result[$key] = $this->collItems->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->collStocks) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'stocks';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'stocks';
                        break;
                    default:
                        $key = 'Stocks';
                }

                $result[$key] = $this->collStocks->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Product
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ProductTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Product
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setProductid($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setDescription($value);
                break;
            case 3:
                $this->setCompanyid($value);
                break;
            case 4:
                $this->setImage($value);
                break;
            case 5:
                $this->setDelted($value);
                break;
            case 6:
                $this->setPurchaseprice($value);
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
        $keys = ProductTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setProductid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDescription($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCompanyid($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setImage($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setDelted($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setPurchaseprice($arr[$keys[6]]);
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
     * @return $this|\Product The current object, for fluid interface
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
        $criteria = new Criteria(ProductTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ProductTableMap::COL_PRODUCTID)) {
            $criteria->add(ProductTableMap::COL_PRODUCTID, $this->productid);
        }
        if ($this->isColumnModified(ProductTableMap::COL_NAME)) {
            $criteria->add(ProductTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(ProductTableMap::COL_DESCRIPTION)) {
            $criteria->add(ProductTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(ProductTableMap::COL_COMPANYID)) {
            $criteria->add(ProductTableMap::COL_COMPANYID, $this->companyid);
        }
        if ($this->isColumnModified(ProductTableMap::COL_IMAGE)) {
            $criteria->add(ProductTableMap::COL_IMAGE, $this->image);
        }
        if ($this->isColumnModified(ProductTableMap::COL_DELTED)) {
            $criteria->add(ProductTableMap::COL_DELTED, $this->delted);
        }
        if ($this->isColumnModified(ProductTableMap::COL_PURCHASEPRICE)) {
            $criteria->add(ProductTableMap::COL_PURCHASEPRICE, $this->purchaseprice);
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
        $criteria = ChildProductQuery::create();
        $criteria->add(ProductTableMap::COL_PRODUCTID, $this->productid);

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
        $validPk = null !== $this->getProductid();

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
        return $this->getProductid();
    }

    /**
     * Generic method to set the primary key (productid column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setProductid($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getProductid();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Product (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setCompanyid($this->getCompanyid());
        $copyObj->setImage($this->getImage());
        $copyObj->setDelted($this->getDelted());
        $copyObj->setPurchaseprice($this->getPurchaseprice());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getItems() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addItem($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getOffers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addOffer($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStocks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStock($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setProductid(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Product Clone of current object.
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
     * Declares an association between this object and a ChildCompany object.
     *
     * @param  ChildCompany $v
     * @return $this|\Product The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCompany(ChildCompany $v = null)
    {
        if ($v === null) {
            $this->setCompanyid(NULL);
        } else {
            $this->setCompanyid($v->getCompanyid());
        }

        $this->aCompany = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCompany object, it will not be re-added.
        if ($v !== null) {
            $v->addProduct($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCompany object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildCompany The associated ChildCompany object.
     * @throws PropelException
     */
    public function getCompany(ConnectionInterface $con = null)
    {
        if ($this->aCompany === null && ($this->companyid !== null)) {
            $this->aCompany = ChildCompanyQuery::create()->findPk($this->companyid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCompany->addProducts($this);
             */
        }

        return $this->aCompany;
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
        if ('Item' == $relationName) {
            return $this->initItems();
        }
        if ('Offer' == $relationName) {
            return $this->initOffers();
        }
        if ('Stock' == $relationName) {
            return $this->initStocks();
        }
    }

    /**
     * Clears out the collItems collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addItems()
     */
    public function clearItems()
    {
        $this->collItems = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collItems collection loaded partially.
     */
    public function resetPartialItems($v = true)
    {
        $this->collItemsPartial = $v;
    }

    /**
     * Initializes the collItems collection.
     *
     * By default this just sets the collItems collection to an empty array (like clearcollItems());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initItems($overrideExisting = true)
    {
        if (null !== $this->collItems && !$overrideExisting) {
            return;
        }
        $this->collItems = new ObjectCollection();
        $this->collItems->setModel('\Item');
    }

    /**
     * Gets an array of ChildItem objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProduct is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildItem[] List of ChildItem objects
     * @throws PropelException
     */
    public function getItems(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collItemsPartial && !$this->isNew();
        if (null === $this->collItems || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collItems) {
                // return empty collection
                $this->initItems();
            } else {
                $collItems = ChildItemQuery::create(null, $criteria)
                    ->filterByProduct($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collItemsPartial && count($collItems)) {
                        $this->initItems(false);

                        foreach ($collItems as $obj) {
                            if (false == $this->collItems->contains($obj)) {
                                $this->collItems->append($obj);
                            }
                        }

                        $this->collItemsPartial = true;
                    }

                    return $collItems;
                }

                if ($partial && $this->collItems) {
                    foreach ($this->collItems as $obj) {
                        if ($obj->isNew()) {
                            $collItems[] = $obj;
                        }
                    }
                }

                $this->collItems = $collItems;
                $this->collItemsPartial = false;
            }
        }

        return $this->collItems;
    }

    /**
     * Sets a collection of ChildItem objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $items A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildProduct The current object (for fluent API support)
     */
    public function setItems(Collection $items, ConnectionInterface $con = null)
    {
        /** @var ChildItem[] $itemsToDelete */
        $itemsToDelete = $this->getItems(new Criteria(), $con)->diff($items);


        $this->itemsScheduledForDeletion = $itemsToDelete;

        foreach ($itemsToDelete as $itemRemoved) {
            $itemRemoved->setProduct(null);
        }

        $this->collItems = null;
        foreach ($items as $item) {
            $this->addItem($item);
        }

        $this->collItems = $items;
        $this->collItemsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Item objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Item objects.
     * @throws PropelException
     */
    public function countItems(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collItemsPartial && !$this->isNew();
        if (null === $this->collItems || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collItems) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getItems());
            }

            $query = ChildItemQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProduct($this)
                ->count($con);
        }

        return count($this->collItems);
    }

    /**
     * Method called to associate a ChildItem object to this object
     * through the ChildItem foreign key attribute.
     *
     * @param  ChildItem $l ChildItem
     * @return $this|\Product The current object (for fluent API support)
     */
    public function addItem(ChildItem $l)
    {
        if ($this->collItems === null) {
            $this->initItems();
            $this->collItemsPartial = true;
        }

        if (!$this->collItems->contains($l)) {
            $this->doAddItem($l);
        }

        return $this;
    }

    /**
     * @param ChildItem $item The ChildItem object to add.
     */
    protected function doAddItem(ChildItem $item)
    {
        $this->collItems[]= $item;
        $item->setProduct($this);
    }

    /**
     * @param  ChildItem $item The ChildItem object to remove.
     * @return $this|ChildProduct The current object (for fluent API support)
     */
    public function removeItem(ChildItem $item)
    {
        if ($this->getItems()->contains($item)) {
            $pos = $this->collItems->search($item);
            $this->collItems->remove($pos);
            if (null === $this->itemsScheduledForDeletion) {
                $this->itemsScheduledForDeletion = clone $this->collItems;
                $this->itemsScheduledForDeletion->clear();
            }
            $this->itemsScheduledForDeletion[]= clone $item;
            $item->setProduct(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Product is new, it will return
     * an empty collection; or if this Product has previously
     * been saved, it will retrieve related Items from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Product.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildItem[] List of ChildItem objects
     */
    public function getItemsJoinOffer(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildItemQuery::create(null, $criteria);
        $query->joinWith('Offer', $joinBehavior);

        return $this->getItems($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Product is new, it will return
     * an empty collection; or if this Product has previously
     * been saved, it will retrieve related Items from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Product.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildItem[] List of ChildItem objects
     */
    public function getItemsJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildItemQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getItems($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Product is new, it will return
     * an empty collection; or if this Product has previously
     * been saved, it will retrieve related Items from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Product.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildItem[] List of ChildItem objects
     */
    public function getItemsJoinVendingmachine(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildItemQuery::create(null, $criteria);
        $query->joinWith('Vendingmachine', $joinBehavior);

        return $this->getItems($query, $con);
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
     * If this ChildProduct is new, it will return
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
                    ->filterByProduct($this)
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
     * @return $this|ChildProduct The current object (for fluent API support)
     */
    public function setOffers(Collection $offers, ConnectionInterface $con = null)
    {
        /** @var ChildOffer[] $offersToDelete */
        $offersToDelete = $this->getOffers(new Criteria(), $con)->diff($offers);


        $this->offersScheduledForDeletion = $offersToDelete;

        foreach ($offersToDelete as $offerRemoved) {
            $offerRemoved->setProduct(null);
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
                ->filterByProduct($this)
                ->count($con);
        }

        return count($this->collOffers);
    }

    /**
     * Method called to associate a ChildOffer object to this object
     * through the ChildOffer foreign key attribute.
     *
     * @param  ChildOffer $l ChildOffer
     * @return $this|\Product The current object (for fluent API support)
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
        $offer->setProduct($this);
    }

    /**
     * @param  ChildOffer $offer The ChildOffer object to remove.
     * @return $this|ChildProduct The current object (for fluent API support)
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
            $this->offersScheduledForDeletion[]= $offer;
            $offer->setProduct(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Product is new, it will return
     * an empty collection; or if this Product has previously
     * been saved, it will retrieve related Offers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Product.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildOffer[] List of ChildOffer objects
     */
    public function getOffersJoinCompany(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildOfferQuery::create(null, $criteria);
        $query->joinWith('Company', $joinBehavior);

        return $this->getOffers($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Product is new, it will return
     * an empty collection; or if this Product has previously
     * been saved, it will retrieve related Offers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Product.
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
     * Clears out the collStocks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStocks()
     */
    public function clearStocks()
    {
        $this->collStocks = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStocks collection loaded partially.
     */
    public function resetPartialStocks($v = true)
    {
        $this->collStocksPartial = $v;
    }

    /**
     * Initializes the collStocks collection.
     *
     * By default this just sets the collStocks collection to an empty array (like clearcollStocks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStocks($overrideExisting = true)
    {
        if (null !== $this->collStocks && !$overrideExisting) {
            return;
        }
        $this->collStocks = new ObjectCollection();
        $this->collStocks->setModel('\Stock');
    }

    /**
     * Gets an array of ChildStock objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProduct is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStock[] List of ChildStock objects
     * @throws PropelException
     */
    public function getStocks(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStocksPartial && !$this->isNew();
        if (null === $this->collStocks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStocks) {
                // return empty collection
                $this->initStocks();
            } else {
                $collStocks = ChildStockQuery::create(null, $criteria)
                    ->filterByProduct($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStocksPartial && count($collStocks)) {
                        $this->initStocks(false);

                        foreach ($collStocks as $obj) {
                            if (false == $this->collStocks->contains($obj)) {
                                $this->collStocks->append($obj);
                            }
                        }

                        $this->collStocksPartial = true;
                    }

                    return $collStocks;
                }

                if ($partial && $this->collStocks) {
                    foreach ($this->collStocks as $obj) {
                        if ($obj->isNew()) {
                            $collStocks[] = $obj;
                        }
                    }
                }

                $this->collStocks = $collStocks;
                $this->collStocksPartial = false;
            }
        }

        return $this->collStocks;
    }

    /**
     * Sets a collection of ChildStock objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $stocks A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildProduct The current object (for fluent API support)
     */
    public function setStocks(Collection $stocks, ConnectionInterface $con = null)
    {
        /** @var ChildStock[] $stocksToDelete */
        $stocksToDelete = $this->getStocks(new Criteria(), $con)->diff($stocks);


        $this->stocksScheduledForDeletion = $stocksToDelete;

        foreach ($stocksToDelete as $stockRemoved) {
            $stockRemoved->setProduct(null);
        }

        $this->collStocks = null;
        foreach ($stocks as $stock) {
            $this->addStock($stock);
        }

        $this->collStocks = $stocks;
        $this->collStocksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Stock objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Stock objects.
     * @throws PropelException
     */
    public function countStocks(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStocksPartial && !$this->isNew();
        if (null === $this->collStocks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStocks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStocks());
            }

            $query = ChildStockQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProduct($this)
                ->count($con);
        }

        return count($this->collStocks);
    }

    /**
     * Method called to associate a ChildStock object to this object
     * through the ChildStock foreign key attribute.
     *
     * @param  ChildStock $l ChildStock
     * @return $this|\Product The current object (for fluent API support)
     */
    public function addStock(ChildStock $l)
    {
        if ($this->collStocks === null) {
            $this->initStocks();
            $this->collStocksPartial = true;
        }

        if (!$this->collStocks->contains($l)) {
            $this->doAddStock($l);
        }

        return $this;
    }

    /**
     * @param ChildStock $stock The ChildStock object to add.
     */
    protected function doAddStock(ChildStock $stock)
    {
        $this->collStocks[]= $stock;
        $stock->setProduct($this);
    }

    /**
     * @param  ChildStock $stock The ChildStock object to remove.
     * @return $this|ChildProduct The current object (for fluent API support)
     */
    public function removeStock(ChildStock $stock)
    {
        if ($this->getStocks()->contains($stock)) {
            $pos = $this->collStocks->search($stock);
            $this->collStocks->remove($pos);
            if (null === $this->stocksScheduledForDeletion) {
                $this->stocksScheduledForDeletion = clone $this->collStocks;
                $this->stocksScheduledForDeletion->clear();
            }
            $this->stocksScheduledForDeletion[]= clone $stock;
            $stock->setProduct(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Product is new, it will return
     * an empty collection; or if this Product has previously
     * been saved, it will retrieve related Stocks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Product.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStock[] List of ChildStock objects
     */
    public function getStocksJoinVendingmachine(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStockQuery::create(null, $criteria);
        $query->joinWith('Vendingmachine', $joinBehavior);

        return $this->getStocks($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aCompany) {
            $this->aCompany->removeProduct($this);
        }
        $this->productid = null;
        $this->name = null;
        $this->description = null;
        $this->companyid = null;
        $this->image = null;
        $this->delted = null;
        $this->purchaseprice = null;
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
            if ($this->collItems) {
                foreach ($this->collItems as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collOffers) {
                foreach ($this->collOffers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStocks) {
                foreach ($this->collStocks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collItems = null;
        $this->collOffers = null;
        $this->collStocks = null;
        $this->aCompany = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ProductTableMap::DEFAULT_STRING_FORMAT);
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

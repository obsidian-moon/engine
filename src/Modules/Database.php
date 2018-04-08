<?php
/**
 * Obsidian Moon Engine by Dark Prospect Games
 *
 * An Open Source, Lightweight and 100% Modular Framework in PHP
 *
 * PHP version 7
 *
 * @category  ObsidianMoonEngine
 * @package   DarkProspectGames\ObsidianMoonEngine
 * @author    Alfonso E Martinez, III <opensaurusrex@gmail.com>
 * @copyright 2011-2018 Dark Prospect Games, LLC
 * @license   MIT https://darkprospect.net/MIT-License.txt
 * @link      https://github.com/dark-prospect-games/obsidian-moon-engine/
 */
namespace DarkProspectGames\ObsidianMoonEngine\Modules;

use DarkProspectGames\ObsidianMoonEngine\{AbstractModule, Core};
use PDO;
use PDOException;
use PDOStatement;

/**
 * Class Database
 *
 * Database class using PDO
 *
 * @category ObsidianMoonEngine
 * @package  DarkProspectGames\ObsidianMoonEngine\Modules
 * @author   Alfonso E Martinez, III <opensaurusrex@gmail.com>
 * @license  MIT https://darkprospect.net/MIT-License.txt
 * @link     https://github.com/dark-prospect-games/obsidian-moon-engine/
 * @since    1.0.0
 * @uses     PDO
 * @uses     AbstractModule
 * @uses     Core
 * @uses     CoreException
 */
class Database extends AbstractModule
{

    /**
     * Database connection
     *
     * @type PDO
     */
    protected $connection;

    /**
     * The last id
     *
     * @type int|null
     */
    protected $lastid;

    /**
     * Values
     *
     * @type mixed[]
     */
    protected $values;

    /**
     * Creates a new object to access database via PDO.
     *
     * @param mixed[] $configs The parameters that we will be passing to PDO.
     *
     * @since  1.0.0
     * @throws CoreException
     */
    public function __construct(array $configs = [])
    {
        // Set and replace the default configs
        $configs = array_replace(
            [
                'type'       => 'mysql',
                'fetch_mode' => PDO::FETCH_ASSOC,
                'error_mode' => PDO::ERRMODE_EXCEPTION,
            ],
            $configs
        );
        parent::__construct($configs);

        try {
            $this->connect();
        } catch (CoreException $e) {
            throw new CoreException($e->getMessage());
        }
    }

    /**
     * Create a database connection and instantiate PDO.
     *
     * @param mixed[] $configs These are the details pertaining to a newly created
     *                         connection, if not set it uses the config params.
     *
     * @since  1.0.0
     * @throws CoreException
     * @return void
     */
    protected function connect($configs = null): void
    {
        if ($configs !== null) {
            $this->configs = array_replace($this->configs, $configs);
        }

        $dsn = "{$this->configs['type']}:dbname={$this->configs['name']};host="
            . $this->configs['host'];
        try {
            $this->connection = new PDO(
                $dsn,
                $this->configs['user'],
                $this->configs['pass']
            );
            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                $this->configs['error_mode']
            );
        } catch (PDOException $e) {
            throw new CoreException(
                __CLASS__.'::__construct()->PDO::__construct() : ' . $e->getMessage()
            );
        }
    }

    /**
     * Excutes a prepared statement
     *
     * @param array  $array An array holding the values to be used in a prepared
     *                      statement.
     * @param string $stmt  The name of the variable where the statement was stored.
     *
     * @since  1.0.0
     * @return Database
     * @throws CoreException
     */
    public function execute($array, $stmt = 'stmt'): Database
    {
        $this->values = [];
        $this->lastid = null;
        $stmt         = 'prepare_' . $stmt;
        try {
            $sth = $this->$stmt->execute($array);
        } catch (PDOException $e) {
            throw new CoreException(
                __CLASS__.'::execute()->PDOStatement::execute() : '.$e->getMessage()
            );
        }
        if ($sth instanceof PDOStatement) {
            try {
                $this->values = $sth->fetchAll($this->configs['fetch_mode']);
            } catch (PDOException $e) {
                throw new CoreException(
                    __CLASS__.'::execute()->PDOStatement::fetchAll() : '
                    . $e->getMessage()
                );
            }
        }

        $store_sql = $stmt . '_sql';
        if (false !== strpos($this->$store_sql, 'insert')) {
            try {
                $this->lastid = $this->connection->lastInsertId();
            } catch (PDOException $e) {
                throw new CoreException(
                    __CLASS__.'::execute()->PDO::lastInsertId() : '.$e->getMessage()
                );
            }
        }

        return $this;
    }

    /**
     * Get the array of values fetched from database
     *
     * @param mixed[]|bool $params Specify the method that we are looking for.
     *
     * @since  1.0.0
     * @return mixed[]|bool
     */
    public function fetchArray($params = false)
    {
        if (\count($this->values) === 0) {
            return false;
        }
        if (\count($this->values) > 1) {
            return $this->values;
        }
        if ($params === true) {
            return $this->values;
        }
        if (\is_array($params) && array_key_exists('item', $params)) {
            $item = $params['item'];
            if (array_key_exists($item, $this->values)) {
                return $this->values[$item];
            }
            if (array_key_exists($item, $this->values[0])) {
                return $this->values[0][$item];
            }
            return false;
        }

        return $this->values[0];
    }

    /**
     * Get the last id of the query that in an insert event.
     *
     * @since  1.0.0
     * @return null|int
     */
    public function insertId(): int
    {
        return $this->lastid;
    }

    /**
     * Return the number of rows found in the database.
     *
     * @since  1.0.0
     * @return int
     */
    public function numRows(): int
    {
        return \count($this->values);
    }

    /**
     * Prepare a query statement to be executed at a later time.
     *
     * @param mixed  $sql  The SQL statement that will be prepared.
     * @param string $stmt The statement will be saved into this space.
     *
     * @since  1.0.0
     * @return Database
     * @throws CoreException
     */
    public function prepare($sql, string $stmt = 'stmt'): Database
    {
        $stmt = 'prepare_' . $stmt;
        try {
            $this->$stmt = $this->connection->prepare($sql);
        } catch (PDOException $e) {
            throw new CoreException(
                __CLASS__.'::prepare()->PDO::prepare() : ' . $e->getMessage()
            );
        }
        $store_sql        = $stmt . '_sql';
        $this->$store_sql = $sql;

        return $this;
    }

    /**
     * Execute a query
     *
     * @param mixed $sql    The content of the SQL query.
     * @param null  $params The parameters of the query.
     *
     * @since  1.0.0
     * @return Database
     * @throws CoreException
     */
    public function query($sql, $params = null): Database
    {
        $sth          = null;
        $this->values = [];
        $this->lastid = null;
        if ($sql === '') {
            throw new CoreException(
                __CLASS__
                . '::query(): Query was undefined, please make sure you pass one.'
            );
        }

        if ($params === null) {
            try {
                $sth = $this->connection->query($sql);
            } catch (PDOException $e) {
                throw new CoreException(
                    __CLASS__.'::query()->PDO::query() : ' . $e->getMessage()
                );
            }
        } else {
            try {
                $sth = $this->connection->prepare($sql);
            } catch (PDOException $e) {
                throw new CoreException(
                    __CLASS__.'::query()->PDO::prepare() : ' . $e->getMessage()
                );
            }
            try {
                $sth->execute($params);
            } catch (PDOException $e) {
                throw new CoreException(
                    __CLASS__.'::query()->PDO::execute() : ' . $e->getMessage()
                );
            }
        }

        if ($sth instanceof PDOStatement && 0 !== strpos($sql, 'select')) {
            try {
                $this->values = $sth->fetchAll($this->configs['fetch_mode']);
            } catch (PDOException $e) {
                throw new CoreException(
                    __CLASS__.'::query()->PDOStatement::fetchAll() : '
                    . $e->getMessage()
                );
            }
        }

        if (false !== strpos($sql, 'insert')) {
            try {
                $this->lastid = $this->connection->lastInsertId();
            } catch (PDOException $e) {
                throw new CoreException(
                    __CLASS__.'::query()->PDO::lastInsertId() : ' . $e->getMessage()
                );
            }
        }

        return $this;
    }

    /**
     * Allows the user to set configurations after the object is instantiated
     *
     * @param string $name  name of the config that you want to change
     * @param mixed  $value value of the config to set
     *
     * @since  1.0.0
     * @return void
     */
    public function setConfig(string $name, $value): void
    {
        if (array_key_exists($name, $this->configs)) {
            $this->configs[$name] = $value;
        }
    }
}

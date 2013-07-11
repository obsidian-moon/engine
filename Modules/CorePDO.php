<?php
/**
 * Obsidian Moon Engine by Dark Prospect Games
 *
 * An Open Source, Lightweight and 100% Modular Framework in PHP
 *
 * PHP version 5
 *
 * @category  ObsidianMoonEngine
 * @package   ObsidianMoonEngine
 * @author    Alfonso E Martinez, III <admin@darkprospect.net>
 * @copyright 2011-2013 Dark Prospect Games, LLC
 * @license   BSD https://darkprospect.net/BSD-License.txt
 * @link      https://github.com/DarkProspectGames/ObsidianMoonEngine
 */
namespace ObsidianMoonEngine;
/**
 * Obsidian Moon Engine by Dark Prospect Games
 *
 * Database class using PDO
 *
 * @category  ObsidianMoonEngine
 * @package   CorePDO
 * @author    Alfonso E Martinez, III <admin@darkprospect.net>
 * @copyright 2011-2013 Dark Prospect Games, LLC
 * @license   BSD https://darkprospect.net/BSD-License.txt
 * @link      https://github.com/DarkProspectGames/ObsidianMoonEngine
 * @link      http://www.php.net/manual/en/book.pdo.php
 */
class CorePDO extends Module
{

    /**
     * @var mixed
     */
    protected $connection;

    /**
     * @var mixed
     */
    protected $lastid;

    /**
     * @var mixed
     */
    protected $configs = array(
                          'type'       => 'mysql',
                          'fetch_mode' => \PDO::FETCH_ASSOC,
                          'error_mode' => \PDO::ERRMODE_EXCEPTION,
                         );

    /**
     * @var mixed
     */
    protected $values;

    /**
     * Creates a new object to access database via PDO.
     *
     * @param mixed $core    A reference to the ObsidianMoonEngine Core class.
     * @param mixed $configs The parameters that we will be passing to PDO.
     *
     * @throws \Exception
     */
    public function __construct(Core $core, $configs = null)
    {
        $this->core = $core;
        if ($configs !== null) {
            $this->configs = array_replace($this->configs, $configs);
        }

        try {
            $this->connect();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Create a database connection and instantiate PDO.
     *
     * @param null $configs These are the details pertaining to a newly created connection,
     *                      if not set it uses the config params.
     *
     * @throws \Exception
     * @return mixed
     */
    protected function connect($configs = null)
    {
        if ($configs !== null) {
            $this->configs = $configs;
        }

        $dsn = "{$this->configs['type']}:dbname={$this->configs['name']};host={$this->configs['host']}";
        try {
            $this->connection = new \PDO($dsn, $this->configs['user'], $this->configs['pass']);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, $this->configs['error_mode']);
        } catch (\PDOException $e) {
            throw new \Exception('CorePDO::__construct()->PDO::__construct() : ' . $e->getMessage());
        }
    }

    /**
     * Excutes a prepared statement
     *
     * @param array  $array An array holding the values to be used in a prepared statement.
     * @param string $stmt  The name of the variable where the statement was stored.
     *
     * @return $this
     * @throws \Exception
     */
    public function execute($array, $stmt = 'stmt')
    {
        $this->values = array();
        $this->lastid = null;
        $stmt         = 'prepare_' . $stmt;
        try {
            $sth = $this->$stmt->execute($array);
        } catch (\PDOException $e) {
            throw new \Exception('CorePDO::execute()->PDOStatement::execute() : ' . $e->getMessage());
        }
        if ($sth instanceof \PDOStatement) {
            try {
                $this->values = $sth->fetchAll($this->configs['fetch_mode']);
            } catch (\PDOException $e) {
                throw new \Exception('CorePDO::execute()->PDOStatement::fetchAll() : ' . $e->getMessage());
            }
        }

        $store_sql = $stmt . '_sql';
        if (preg_match('/insert/i', $this->$store_sql)) {
            try {
                $this->lastid = $this->connection->lastInsertId();
            } catch (\PDOException $e) {
                throw new \Exception('CorePDO::execute()->PDO::lastInsertId() : ' . $e->getMessage());
            }
        }

        return $this;
    }

    /**
     * Get the array of values fetched from database
     *
     * @param mixed $params Specify the method that we are looking for.
     *
     * @return array|bool
     */
    public function fetchArray($params = false)
    {
        if (count($this->values) == 0) {
            return false;
        } else if (count($this->values) > 1) {
            return $this->values;
        } else {
            if ($params === true) {
                return $this->values;
            } else if ($params['item']) {
                $item = $params['item'];
                if ($this->values[$item]) {
                    return $this->values[$item];
                } else if ($this->values[0][$item]) {
                    return $this->values[0][$item];
                } else {
                    return false;
                }
            } else {
                return $this->values[0];
            }
        }
    }

    /**
     * Get the last id of the query that in an insert event.
     *
     * @return null|int
     */
    public function insertId()
    {
        return $this->lastid;
    }

    /**
     * Return the number of rows found in the database.
     *
     * @return int
     */
    public function numRows()
    {
        return count($this->values);
    }

    /**
     * Prepare a query statement to be executed at a later time.
     *
     * @param mixed  $sql  The SQL statement that will be prepared.
     * @param string $stmt The statement will be saved into this space.
     *
     * @return $this
     * @throws \Exception
     */
    public function prepare($sql, $stmt = 'stmt')
    {
        $stmt = 'prepare_' . $stmt;
        try {
            $this->$stmt = $this->connection->prepare($sql);
        } catch (\PDOException $e) {
            throw new \Exception('CorePDO::prepare()->PDO::prepare() : ' . $e->getMessage());
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
     * @return $this|bool
     * @throws \Exception
     */
    public function query($sql, $params = null)
    {
        $sth          = null;
        $this->values = array();
        $this->lastid = null;
        if ($sql == '') {
            throw new \Exception('CorePDO::query(): Query was undefined, please make sure you pass one.');
        }

        if ($params === null) {
            try {
                $sth = $this->connection->query($sql);
            } catch (\PDOException $e) {
                throw new \Exception('CorePDO::query()->PDO::query() : ' . $e->getMessage());
            }
        } else {
            try {
                $sth = $this->connection->prepare($sql);
            } catch (\PDOException $e) {
                throw new \Exception('CorePDO::query()->PDO::prepare() : ' . $e->getMessage());
            }
            try {
                $sth->execute($params);
            } catch (\PDOException $e) {
                throw new \Exception('CorePDO::query()->PDO::execute() : ' . $e->getMessage());
            }
        }

        if ($sth instanceof \PDOStatement && preg_match('/select/i', $sql)) {
            try {
                $this->values = $sth->fetchAll($this->configs['fetch_mode']);
            } catch (\PDOException $e) {
                throw new \Exception('CorePDO::query()->PDOStatement::fetchAll() : ' . $e->getMessage());
            }
        }

        if (preg_match('/insert/i', $sql)) {
            try {
                $this->lastid = $this->connection->lastInsertId();
            } catch (\PDOException $e) {
                throw new \Exception('CorePDO::query()->PDO::lastInsertId() : ' . $e->getMessage());
            }
        }

        return $this;
    }

}

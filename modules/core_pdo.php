<?php

/**
 * Obsidian Moon Engine presented by Dark Prospect Games
 *
 * @author    Alfonso Martinez <admin@darkprospect.net>
 * @copyright 2011-2013 Dark Prospect Games, LLC
 *
 */
class core_pdo
{

    var $core = null;
    var $lastid = null;
    var $values = array();

    function __construct(ObsidianMoonCore $core, $params)
    {
        $this->core   = $core;
        $this->params = $params;
        if (empty($this->params['type'])) {
            $this->params['type'] = "mysql";
        }
        try {
            $this->connect();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function connect($connection = 'connection', $params = null)
    {
        /**
         * This function creates a connection and assigns it to a variable in.
         *
         * @param $connection - This is defaulted to 'connection' but supports anything the user may choose
         * @param $params     - These are the details pertaining to a newly created connection, if not set it uses the config params.
         */
        if ($params !== null) {
            $this->params = $params;
        }
        $dsn = "{$this->params['type']}:dbname={$this->params['name']};host={$this->params['host']}";
        try {
            $this->$connection = new PDO($dsn, $this->params['user'], $this->params['pass']);
            $this->$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception('core_pdo::__construct()->PDO::__construct() : ' . $e->getMessage());
        }
    }

    function execute($array, $stmt = 'stmt', $connection = 'connection')
    {
        $this->values = array();
        $this->lastid = null;
        $stmt         = 'prepare_' . $stmt;
        try {
            $sth = $this->$stmt->execute($array);
        } catch (PDOException $e) {
            throw new Exception('core_pdo::execute()->PDOStatement::execute() : ' . $e->getMessage());
        }
        if ($sth instanceof PDOStatement) {
            try {
                $this->values = $sth->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                throw new Exception('core_pdo::execute()->PDOStatement::fetchAll() : ' . $e->getMessage());
            }
        }
        $store_sql = $stmt . "_sql";
        if (preg_match("/insert/i", $this->$store_sql)) {
            try {
                $this->lastid = $this->$connection->lastInsertId();
            } catch (PDOException $e) {
                throw new Exception('core_pdo::execute()->PDO::lastInsertId() : ' . $e->getMessage());
            }
        }

        return $this;
    }

    function fetch_array($params = false)
    {
        if (count($this->values) == 0) {
            return false;
        } elseif (count($this->values) > 1) {
            return $this->values;
        } else {
            if ($params === true) {
                return $this->values;
            } elseif ($params['item']) {
                $item = $params['item'];
                if ($this->values[$item]) {
                    return $this->values[$item];
                } elseif ($this->values[0][$item]) {
                    return $this->values[0][$item];
                } else {
                    return false;
                }
            } else {
                return $this->values[0];
            }
        }
    }

    function insert_id()
    {
        return $this->lastid;
    }

    function num_rows()
    {
        return count($this->values);
    }

    function prepare($sql, $stmt = 'stmt', $connection = 'connection')
    {
        $stmt = 'prepare_' . $stmt;
        try {
            $this->$stmt = $this->$connection->prepare($sql);
        } catch (PDOException $e) {
            throw new Exception('core_pdo::prepare()->PDO::prepare() : ' . $e->getMessage());
        }
        $store_sql        = $stmt . "_sql";
        $this->$store_sql = $sql;

        return $this;
    }

    function query($sql, $params = null, $connection = 'connection')
    {
        $sth          = null;
        $this->values = array();
        $this->lastid = null;
        if ($sql == '') {
            return false;
        }
        if ($params === null) {
            try {
                $sth = $this->$connection->query($sql);
            } catch (PDOException $e) {
                throw new Exception('core_pdo::query()->PDO::query() : ' . $e->getMessage());
            }
        } else {
            try {
                $sth = $this->$connection->prepare($sql);
            } catch (PDOException $e) {
                throw new Exception('core_pdo::query()->PDO::prepare() : ' . $e->getMessage());
            }
            try {
                $sth->execute($params);
            } catch (PDOException $e) {
                throw new Exception('core_pdo::query()->PDO::execute() : ' . $e->getMessage());
            }
        }
        if ($sth instanceof PDOStatement && preg_match("/select/i", $sql)) {
            try {
                $this->values = $sth->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                throw new Exception('core_pdo::query()->PDOStatement::fetchAll() : ' . $e->getMessage());
            }
        }
        if (preg_match("/insert/i", $sql)) {
            try {
                $this->lastid = $this->$connection->lastInsertId();
            } catch (PDOException $e) {
                throw new Exception('core_pdo::query()->PDO::lastInsertId() : ' . $e->getMessage());
            }
        }

        return $this;
    }

}

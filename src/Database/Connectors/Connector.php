<?php

namespace Marquine\Etl\Database\Connectors;

use PDO;

abstract class Connector
{

    /**
     * The default PDO connection options.
     *
     * @var array
     */
    protected $options = [
        PDO::ATTR_CASE               => PDO::CASE_NATURAL,
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS       => PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES  => false,
        PDO::ATTR_EMULATE_PREPARES   => true,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    /**
     * Connect to a database.
     *
     * @param array $config
     * @return \PDO
     */
    abstract public function connect($config);

    /**
     * Create a new PDO connection.
     *
     * @param string $dsn
     * @param array $config
     * @return \PDO
     */
    public function createConnection($dsn, array $config)
    {
        // Merge custom PDO options from the connection config if available
        if (array_key_exists('pdo_options', $config) && is_array($config['pdo_options'])) {
            $this->options = array_merge($this->options, $config['pdo_options']);
        }

        $username = isset($config['username']) ? $config['username'] : null;

        $password = isset($config['password']) ? $config['password'] : null;

        return new PDO($dsn, $username, $password, $this->options);
    }

}

<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Db
 * @subpackage Adapter
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

namespace Zend\Db\Adapter;

use Zend\Db\ResultSet;

/**
 * @category   Zend
 * @package    Zend_Db
 * @subpackage Adapter
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 *
 *
 * @property Driver\DriverInterface $driver
 * @property Platform\PlatformInterface $platform
 */
class Adapter
{
    /**
     * Query Mode Constants
     */
    const QUERY_MODE_EXECUTE = 'execute';
    const QUERY_MODE_PREPARE = 'prepare';

    /**
     * Prepare Type Constants
     */
    const PREPARE_TYPE_POSITIONAL = 'positional';
    const PREPARE_TYPE_NAMED = 'named';

    const FUNCTION_FORMAT_PARAMETER_NAME = 'formatParameterName';
    const FUNCTION_QUOTE_IDENTIFIER = 'quoteIdentifier';
    const FUNCTION_QUOTE_VALUE = 'quoteValue';


    /**
     * @var Driver\DriverInterface
     */
    protected $driver = null;

    /**
     * @var Platform\PlatformInterface
     */
    protected $platform = null;

    /**
     * @var \Zend\Db\ResultSet\ResultSet
     */
    protected $queryResultSetPrototype = null;

    /**
     * @var string
     */
    protected $queryMode = self::QUERY_MODE_PREPARE;

    /**
     * @var Driver\StatementInterface
     */
    protected $lastPreparedStatement = null;

    /**
     * @param Driver\DriverInterface|array $driver
     * @param Platform\PlatformInterface $platform
     * @param ResultSet\ResultSet $queryResultPrototype
     */
    public function __construct($driver, Platform\PlatformInterface $platform = null, ResultSet\ResultSet $queryResultPrototype = null)
    {
        if (is_array($driver)) {
            $driver = $this->createDriverFromParameters($driver);
        }

        if (!$driver instanceof Driver\DriverInterface) {
            throw new \InvalidArgumentException(
                'The supplied or instantiated driver object does not implement Zend\Db\Adapter\Driver\DriverInterface'
            );
        }

        $driver->checkEnvironment();
        $this->driver = $driver;

        if ($platform == null) {
            $platform = $this->createPlatformFromDriver($driver);
        }

        $this->platform = $platform;
        $this->queryResultSetPrototype = ($queryResultPrototype) ?: new ResultSet\ResultSet();
    }

    /**
     * getDriver()
     * 
     * @throws Exception
     * @return Driver\DriverInterface
     */
    public function getDriver()
    {
        if ($this->driver == null) {
            throw new \Exception('Driver has not been set or configured for this adapter.');
        }
        return $this->driver;
    }

    /**
     * @param string $queryMode
     * @return Adapter
     * @throws \InvalidArgumentException
     */
    public function setQueryMode($queryMode)
    {
        if (!in_array($queryMode, array(self::QUERY_MODE_EXECUTE, self::QUERY_MODE_PREPARE))) {
            throw new \InvalidArgumentException(
                sprintf('Query Mode must be one of "%s" or "%s"', self::QUERY_MODE_EXECUTE, self::QUERY_MODE_PREPARE)
            );
        }
        
        $this->queryMode = $queryMode;
        return $this;
    }

    /**
     * @return Platform\PlatformInterface
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    public function getDefaultSchema()
    {
        return $this->driver->getConnection()->getDefaultSchema();
    }

    /**
     * query() is a convenience function
     *
     * @param string $sql
     * @param string|array $parametersOrQueryMode
     * @return Driver\StatementInterface
     */
    public function query($sql, $parametersOrQueryMode = self::QUERY_MODE_PREPARE)
    {
        if (is_string($parametersOrQueryMode) && in_array($parametersOrQueryMode, array(self::QUERY_MODE_PREPARE, self::QUERY_MODE_EXECUTE))) {
            $mode = $parametersOrQueryMode;
            $parameters = null;
        } elseif (is_array($parametersOrQueryMode)) {
            $mode = self::QUERY_MODE_PREPARE;
            $parameters = $parametersOrQueryMode;
        } else {
            throw new \Exception('Parameter 2 to this method must be a flag, an array, or ParameterContainer');
        }

        if ($mode == self::QUERY_MODE_PREPARE) {
            $this->lastPreparedStatement = null;
            $this->lastPreparedStatement = $this->driver->createStatement($sql);
            $this->lastPreparedStatement->prepare();
            if (is_array($parameters) || $parameters instanceof ParameterContainer) {
                $this->lastPreparedStatement->setParameterContainer((is_array($parameters)) ? new ParameterContainer($parameters) : $parameters);
                $result = $this->lastPreparedStatement->execute();
            } else {
                return $this->lastPreparedStatement;
            }
        } else {
            $result = $this->driver->getConnection()->execute($sql);
        }

        if ($result instanceof Driver\ResultInterface && $result->isQueryResult()) {
            $resultSet = clone $this->queryResultSetPrototype;
            $resultSet->setDataSource($result);
            return $resultSet;
        }

        return $result;
    }

    /**
     * Create statement
     * 
     * @param  string $initialSql
     * @param  ParameterContainerInterface $initialParameters
     * @return Driver\StatementInterface 
     */
    public function createStatement($initialSql = null, $initialParameters = null)
    {
        $statement = $this->driver->createStatement($initialSql);
        if ($initialParameters == null || !$initialParameters instanceof ParameterContainerInterface && is_array($initialParameters)) {
            $initialParameters = new ParameterContainer((is_array($initialParameters) ? $initialParameters : array()));
        }
        $statement->setParameterContainer($initialParameters);
        return $statement;
    }

    /**
     * @param $name
     * @return Driver\DriverInterface|Platform\PlatformInterface
     */
    public function __get($name)
    {
        switch (strtolower($name)) {
            case 'driver':
                return $this->driver;
            case 'platform':
                return $this->platform;
            default:
                throw new \InvalidArgumentException('Invalid magic property on adapter');
        }

    }

    /**
     * @param array $parameters
     * @return Driver\DriverInterface
     * @throws \InvalidArgumentException
     */
    protected function createDriverFromParameters(array $parameters)
    {
        if (!isset($parameters['driver']) || !is_string($parameters['driver'])) {
            throw new \InvalidArgumentException('createDriverFromParameters() expects a "driver" key to be present inside the parameters');
        }

        $driverName = strtolower($parameters['driver']);
        switch ($driverName) {
            case 'mysqli':
                $driver = new Driver\Mysqli\Mysqli($parameters);
                break;
            case 'sqlsrv':
                $driver = new Driver\Sqlsrv\Sqlsrv($parameters);
                break;
            case 'pdo':
            default:
                if ($driverName == 'pdo' || strpos($driverName, 'pdo') === 0) {
                    $driver = new Driver\Pdo\Pdo($parameters);
                }
        }

        if (!isset($driver) || !$driver instanceof Driver\DriverInterface) {
            throw new \InvalidArgumentException('DriverInterface expected', null, null);
        }

        return $driver;
    }

    /**
     * @param Driver\DriverInterface $driver
     * @return Platform\PlatformInterface
     */
    protected function createPlatformFromDriver(Driver\DriverInterface $driver)
    {
        // consult driver for platform implementation
        $platformName = $driver->getDatabasePlatformName(Driver\DriverInterface::NAME_FORMAT_CAMELCASE);
        switch ($platformName) {
            case 'Mysql':
                return new Platform\Mysql();
            case 'SqlServer':
                return new Platform\SqlServer();
            case 'Sqlite':
                return new Platform\Sqlite();
            default:
                return new Platform\Sql92();
        }
    }

}

<?php
/**
 * Part of the model layer that takes care of the user information
 *
 * PHP version 5.4
 *
 * @category   Application
 * @package    Models
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Application\Models;

/**
 * Part of the model layer that takes care of the user information
 *
 * @category   Application
 * @package    Models
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class User
{
    /**
     * @var \PDO The database connection
     */
    private $dbConnection;

    /**
     * Creates instance
     *
     * @param \PDO $dbConnection The database connection
     */
    public function __construct(\PDO $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    /**
     * Validates the user supplied credentials
     *
     * @param string $username The username to check
     * @param string $password The password to check
     *
     * @return boolean Whether the login was successful
     */
    public function login($username, $password)
    {
        $stmt = $this->dbConnection->prepare('SELECT userid, hash FROM users WHERE lower(username) = :username');
        $stmt->execute([
            'username' => strtolower($username),
        ]);
        $recordset = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$recordset || !password_verify($password, $recordset['hash'])) {
            return false;
        }

        $this->reHashWhenNeeded($recordset['userid'], $password, $recordset['hash']);

        return true;
    }

    /**
     * Check whether the provided hash still uses the safest algorithm
     *
     * @param int    $userId   The userid to which the hash and password belongs
     * @param string $password The password to rehash when needed
     * @param string $hash     The current hash
     */
    private function reHashWhenNeeded($userId, $password, $hash)
    {
        if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            if ($hash === false) {
                return;
            }

            $stmt = $this->dbConnection->prepare('UPDATE users SET hash = :hash WHERE userid = :userid');
            $stmt->execute([
                'hash'   => $hash,
                'userid' => $userId,
            ]);
        }
    }
}
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

use RichUploader\Security\CsrfToken,
    RichUploader\Storage\Session;

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
     * @var \RichUploader\Storage\Session The session
     */
    private $session;

    /**
     * Creates instance
     *
     * @param \PDO                          $dbConnection The database connection
     * @param \RichUploader\Storage\Session $session      The session
     */
    public function __construct(\PDO $dbConnection, Session $session)
    {
        $this->dbConnection = $dbConnection;
        $this->session      = $session;
    }

    /**
     * Validates the user supplied credentials. If the login is successful it will handle the session regeneration.
     *
     * @param string $username The username to check
     * @param string $password The password to check
     *
     * @return boolean Whether the login was successful
     */
    public function login($username, $password, CsrfToken $csrfToken)
    {
        $stmt = $this->dbConnection->prepare(
            'SELECT userid, username, email, hash FROM users WHERE lower(username) = :username'
        );
        $stmt->execute([
            'username' => strtolower($username),
        ]);
        $recordset = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$recordset || !password_verify($password, $recordset['hash'])) {
            return false;
        }

        $this->reHashWhenNeeded($recordset['userid'], $password, $recordset['hash']);

        $this->resetUserSession($recordset);

        $csrfToken->regenerateToken();

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

    /**
     * Reset the session superglobal and initializes the session with the userdata
     *
     * @param array $userData The user data to add to the fresh session
     */
    private function resetUserSession(array $userData)
    {
        $this->session->regenerate();
        $this->session->set('user', [
            'userid'   => $userData['userid'],
            'username' => $userData['username'],
            'email'    => $userData['email'],
        ]);
    }
}
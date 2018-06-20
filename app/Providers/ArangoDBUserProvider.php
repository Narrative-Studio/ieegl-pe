<?php
namespace App\Providers;

use App\ArangoDB\Auth\GenericUser as GenericUser;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Hash;
use App\Repositories\ArangoDB;
use ArangoDBClient\Document as ArangoDocument;

class ArangoDBUserProvider implements UserProvider
{
    protected $ArangoDB;
    protected $DocumentHandler;
    protected $CollectionHandler;

    public function __construct()
    {
        $this->ArangoDB = new ArangoDB();
        $this->DocumentHandler = $this->ArangoDB->DocumentHandler();
        $this->CollectionHandler = $this->ArangoDB->CollectionHandler();
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {

        $cursor = $this->CollectionHandler->byExample('users', ['email' => $identifier]);
        $user = $this->ArangoDB->Document($cursor->getAll());
        return $this->getGenericUser($user);
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed  $identifier
     * @param  string $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $cursor = $this->CollectionHandler->byExample('users', ['email' => (string) $identifier,'remember_token'=>$token]);
        $user = $this->ArangoDB->Document($cursor->getAll());
        return $this->getGenericUser($user);
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string                                     $token
     * @return void
     */
    public function updateRememberToken(UserContract $user, $token)
    {
        // update a document
        $cursor = $this->CollectionHandler->byExample('users', ['email' => $user->getAuthIdentifier()]);
        $usuario = $this->ArangoDB->Document($cursor->getAll());
        $id = $usuario->_key;

        $user = new ArangoDocument();
        $user->remember_token = $token;
        $result = $this->DocumentHandler->updateById('users', $id, $user);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $cursor = $this->CollectionHandler->byExample('users', ['email' => $credentials['email']]);
        $user = $this->ArangoDB->Document($cursor->getAll());
        return $this->getGenericUser($user);
    }

    /**
     * Get the generic user.
     *
     * @param  mixed $user
     * @return \Illuminate\Auth\GenericUser|null
     */
    protected function getGenericUser($user)
    {
        if ($user !== null) {
            return new GenericUser((array)$user);
        }
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array                                      $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password'];

        return Hash::check($plain, $user->getAuthPassword());
    }
}
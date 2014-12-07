<?php

use \Base;

/**
 * Authentication controller.
 */
class AuthCtrl extends \Base\BaseController {

    /**
     * Render the view of the log in.
     * @return [type] [description]
     */
    public function index()
    {
        return View::make('login');
    }

    public function getCurrentUser()
    {
        try
        {
            // Get the current logged in user
            $user = Sentry::getUser();

            if(isset($user)) {
                return User::find($user->id);
            } else {}

        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {

        }
    }

    /**
     * Log in
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function logIn($data)
    {
        try
        {

        // Decode entities
        $email = html_entity_decode($data['email']);

        $userByEmail = Sentry::findUserByLogin($email);
        $throttle = Sentry::findThrottlerByUserId($userByEmail['attributes']['id']);

        if($throttle->check()) {

                // Set login credentials
                $credentials = array(
                    'email' => $email,
                    'password' => $data['password']
                );

                // Remember me if true
                // This will simply remembere us as cookies
                // -> even if we close the browser
                if(isset($data['remember'])){
                    if($data['remember']) {
                        $user = Sentry::authenticateAndRemember($credentials);
                    }
                } else {
                    // Try to authenticate the user per default session duration
                    $user = Sentry::authenticate($credentials, false);
                }

                // Get current user
                $currentUser = $this->getCurrentUser();

                // Set session data
                Session::put('user', $currentUser);

                return ['user' => $user->group_id];

            }
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            throw new AuthenticationException('Login field is required.');
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            throw new AuthenticationException('Password field is required.');
        }
        catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
        {
            throw new AuthenticationException('User is not activated.');
        }
        catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
        {
            throw new AuthenticationException('Wrong password, try again.');
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            throw new AuthenticationException('code.0');
        }
        // The following is only required if throttle is enabled
        catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
        {
            $time = $throttle->getSuspensionTime();
            throw new AuthenticationException('User is suspended for '. $time .' minutes.');
        }
        catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
        {
            throw new AuthenticationException('User is banned.');
        }
    }

    /**
     * Create users.
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function createUser($data)
    {
        try
        {
            // Decode Esaped characters
            $email = html_entity_decode($data['email']);
            $first_name = html_entity_decode($data['first_name']);
            $last_name = html_entity_decode($data['last_name']);

            $this->validate($data);

            // Create the user
            $user = Sentry::register(
                [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'password' => $data['password'],
                    'group_id' => 3,
                    'first_login' => 0,
                    'company_id' => $data['company_id']
                ], true);

                return User::find($user->id);

        }

        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            throw new AuthenticationException('name_empty');
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            throw new AuthenticationException('password_empty');
        }
        catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {

            throw new AuthenticationException('exists_already');
        }
    }

}

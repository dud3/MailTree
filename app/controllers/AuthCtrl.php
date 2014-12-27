<?php

use \Base;
use Sentry\Throttling\UserSuspendedException;
use Sentry\Throttling\UserBannedException;
use \AuthenticationException;

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
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e){}
    }

    /**
     * Log in
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function logIn($data = null)
    {
        $data = Input::all();

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
                if(isset($data['remember']) && $data['remember']){
                        $user = Sentry::authenticateAndRemember($credentials);
                } else {
                    var_dump($credentials);
                    // Try to authenticate the user per default session duration
                    $user = Sentry::authenticate($credentials, false);
                }

                // Get current user
                $currentUser = $this->getCurrentUser();

                // Set session data
                Session::put('user', $currentUser);

                return ["msg" => "cool, come in..."];

            }
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            return Response::json(['msg' => 'Login field is required.', 'code' => 0.1], 406);
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            return Response::json([ 'msg' => 'Password field is required.', 'code' => 0.2], 406);
        }
        catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
        {
            return Response::json([ 'msg' => 'User is not activated.', 'code' => 0.3], 406);
        }
        catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
        {
            return Response::json([ 'msg' => 'Wrong password, try again.', 'code' => 0.4], 406);
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return Response::json([ 'msg' => 'User Not found.', 'code' => 0.5], 406);
        }
        // The following is only required if throttle is enabled
        catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
        {
            return Response::json([ 'msg' => 'User is suspended for '. $throttle->getSuspensionTime() .' minutes.', 'code' => 0.6], 406);
        }
        catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
        {
            return Response::json([ 'msg' => 'User is banned.', 'code' => 0.7], 406);
        }
    }

    /**
     * Logout.
     * @return [type] [description]
     */
    public function logout() {
        Sentry::logout();
        Session::flush();

        if (Request::ajax()) {
            return true;
        } else {
            return Redirect::to('/');
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
            return Response::json([ 'msg' => 'name_empty', 'code' => 0.1], 406);
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            return Response::json([ 'msg' => 'password_empty', 'code' => 0.2], 406);
        }
        catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {
            return Response::json([ 'msg' => 'exists_already', 'code' => 0.3], 406);
        }
    }

    /**
     * Just a simple JSON request to keep the sessions alive.
     * @return [type] [description]
     */
    public function keepAlive() {
        return true;
    }

}

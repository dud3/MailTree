<?php

use \Base;
use Sentry\Throttling\UserSuspendedException;
use Sentry\Throttling\UserBannedException;
use \AuthenticationException;

/**
 * Authentication controller.
 */
class UserCtrl extends \Base\BaseController {

    /**
     * Create users.
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function createUser($data = null)
    {

        if($data == null) {
            $data = Input::all();
        }

        try
        {
            // Decode Esaped characters
            $email = html_entity_decode($data['email']);
            $first_name = html_entity_decode($data['first_name']);
            $last_name = html_entity_decode($data['last_name']);

            // Create the user
            $user = Sentry::register(
                [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'password' => $data['password']
                ], true);

                return User::find($user->id);

        }

        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            return Response::json([ 'msg' => 'Login Required', 'code' => 0.1], 406);
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            return Response::json([ 'msg' => 'Password Required', 'code' => 0.2], 406);
        }
        catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {
            return Response::json([ 'msg' => 'User Already Exits', 'code' => 0.3], 406);
        }
    }

}

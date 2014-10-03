@extends('layouts.internal')
@section('main')


    <div toggle-switch class="switch-primary" model="switchStatus"></div>
    <div toggle-switch class="switch-info" model="switchStatus"></div>
    <div toggle-switch class="switch-success" model="switchStatus"></div>
    <div toggle-switch class="switch-warning" model="switchStatus"></div>
    <div toggle-switch class="switch-danger" model="switchStatus"></div>
    <div toggle-switch class="switch-default" model="switchStatus"></div>
    <div class="container animated fadeInDown" ng-controller="AuthCtrl">
    <div id='var_dump' style='display:none;'></div>
    <div class="allData">
    <div class="loginData">
    <!-- hide me for chrome -->
    <form name="login-form" id="login-form" method="post" action="" style="display: none;">
        <input name="login" id="login-login" type="text">
        <input name="password" id="login-password" type="password">
    </form>

    <form name="login-form" autocomplete="on" class="form-signin" id="form-signin" ng-login-submit="login">
    <h1 style="text-align:center;">Sign in to continue</h1>
    <div class="form-group">
        <div class="controls">
            <input type="email" ng-model="loginCredentials.email" name="email" id="email" class="form-control" placeholder="Email" ng-required="" autofocus="" autocomplete="on">
        </div>
    </div>

    <div class="form-group">            
        <div class="controls">
            <input type="password" ng-model="loginCredentials.password" name="password" id="password" class="form-control" placeholder="Password" ng-required="" autocomplete="on">
            <a href="#" id="forgot" class="text-info pull-right" style="margin-top:-10px;" ng-click="renderResetPasswordForm(1)">Forgot your password</a> 
        </div>
    </div>   

        <div class="control-group">
            <div class="controls">
            <label class="checkbox"><input type="checkbox" name="remember" value="" ng-model="loginCredentials.remember">Remember me</label>
            </div>
        </div>
        <button name="submit" id="submit" type="submit" value="" class="btn btn-large btn-primary btn-block ladda-button lading-btn login" data-style="zoom-in" data-spinner-size="30"><span class="ladda-label">Sign in</span></button>

    </form>
</div>

@stop
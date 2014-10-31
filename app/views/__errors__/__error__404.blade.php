@extends('__errors__.layout.index')
@section('main')

<style type="text/css">
body { 
                padding:5%;
                padding-bottom: 40px;
                background-color: #eee;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover; 
}
.error-template {padding: 40px 15px;text-align: center; color:#fff;}
.error-actions {margin-top:15px;margin-bottom:15px;}
.error-actions .btn { margin-right:10px; }
#content-404 {padding: 5%;}
</style>

<div class="container">
    <div class="row col-sm-5 col-sm-offset-4" id="content-404">
            <div class="error-template"  style="background:rgba(0, 0, 0, 0.55);
                                                box-shadow: 0 0 10px -5px #000; 
                                                color:#FFF; text-shadow:0px 1px 1px rgba(0, 0, 0, 0.25); 
                                                border-radius:10">
                <h1>Oops!</h1>
                <h2>404 Page Not Found</h2>

                <div class="error-details" style="padding-top:-10px;">
                    Sorry, the page that you are looking for, not found!
                </div>
                <div class="error-actions">
                    <a href="/" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                        Take Me Home </a><!-- a href="/" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a-->
                </div>
            </div>
    </div>
</div>

@stop
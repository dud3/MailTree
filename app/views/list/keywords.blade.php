@extends('layouts.internal')
@section('main')



    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <img src="/images/mini_icon.png" class="roundImage img-icon" style="float:left;" /> 
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="">Log out&nbsp<span class="glyphicon glyphicon-off" style="padding-top: 3px;"></span></a></li>
           
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>



	<div class="col-md-6">
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">

			<div class="panel-heading">
			  <h4 class="panel-title">
			    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="pull-right" onclick="alert('Sorry not working yet!')"><b>+</b></a>
			      Keywords: <span class="label label-primary">dabvis</span> <span class="label label-primary">CLA</span><a class="fa fa-pencil-square-o" style="float: right;"></a><a style="float:right;"><b>x</b></a>
			  </h4>
			</div>

			<div id="collapseOne" class="panel-collapse collapse in">
			  <div class="panel-body">
			  	<h5>Recipients:</h5>
			  	<table class="table table-bordered">
			  		<tr>
			  			<th>Salutation</th>
			  			<th>Email</th>
			  		</tr>
			  		<tr>
			  			<td>Tom</td>
			  			<td>t@gmail.com</td>
			  		</tr>
			  		<tr>
			  			<td>Mary</td>
			  			<td>m@gmail.com</td>
			  		</tr>
			  		<tr>
			  			<td>Cheryl</td>
			  			<td>ch@gmail.com</td>
			  		</tr>

			  	</table>

			  </div>
			</div>

			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">
				
			<div class="panel-heading">
			  <h4 class="panel-title">
			    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="pull-right" id="clickCol"><b>+</b></a>
			      Keywords: <span class="label label-primary">example1</span> <span class="label label-primary">example2</span>
			  </h4>
			</div>

			<div id="collapseOne" class="panel-collapse collapse in">
			  <div class="panel-body">
			  	Davis, ...
			  </div>
			</div>

			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">
				
			<div class="panel-heading">
			  <h4 class="panel-title">
			   <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="pull-right" onclick="alert('Sorry not working yet!')"><b>+</b></a>
			      Keywords: <span class="label label-primary">example1</span> <span class="label label-primary">example2</span>
			    
			  </h4>
			</div>

			<div id="collapseOne" class="panel-collapse collapse in">
			  <div class="panel-body">
			  	Davis, ...
			  </div>
			</div>

			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">
				
			<div class="panel-heading">
			  <h4 class="panel-title">
			    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="pull-right" onclick="alert('Sorry not working yet!')"><b>+</b></a>
			      Keywords: <span class="label label-primary">example1</span> <span class="label label-primary">example2</span>
			  </h4>
			</div>

			<div id="collapseOne" class="panel-collapse collapse in">
			  <div class="panel-body">
			  	Davis, ...
			  </div>
			</div>

			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">

			<div class="panel-heading">
			  <h4 class="panel-title">
			    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="pull-right" onclick="alert('Sorry not working yet!')"><b>+</b></a>
			      Keywords: <span class="label label-primary">dabvis</span> <span class="label label-primary">CLA</span>
			  </h4>
			</div>

			<div id="collapseOne" class="panel-collapse collapse in">
			  <div class="panel-body">
			  	California, ...
			  </div>
			</div>

			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">

			<div class="panel-heading">
			  <h4 class="panel-title">
			    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="pull-right" onclick="alert('Sorry not working yet!')"><b>+</b></a>
			      Keywords: <span class="label label-primary">dabvis</span> <span class="label label-primary">CLA</span>
			  </h4>
			</div>

			<div id="collapseOne" class="panel-collapse collapse in">
			  <div class="panel-body">
			  	California, ...
			  </div>
			</div>

			</div>
		</div>
	</div>


@stop
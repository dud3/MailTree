@extends('layouts.internal')
@section('main')


    <div class="col-md-12">
	<div class="col-md-6">
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">

			<div class="panel-heading">
			  <h4 class="panel-title">
			    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="pull-right"><b>+</b></a>
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
			  			<td>
			  				<a href="#" id="username" data-type="text" data-pk="1" data-title="Enter username" class="editable editable-click editable-open" data-original-title="" title="">superuser</a>
			  		   </td>
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
			    <a data-toggle="collapse" data-parent="" href="#collapseTwo" class="pull-right" id="clickCol"><b>+</b></a>
			      Keywords: <span class="label label-primary">example1</span> <span class="label label-primary">example2</span>
			  </h4>
			</div>

			<div id="collapseTwo" class="panel-collapse collapse in">
			  <div class="panel-body">
			    	<h5>Recipients:</h5>
			  	<table class="table table-bordered">
			  		<tr>
			  			<th>Salutation</th>
			  			<th>Email</th>
			  		</tr>
			  		<tr>
			  			<td>
			  				<a href="#" id="" data-type="text" data-pk="1" data-title="Enter username" class="editable editable-click editable-open" data-original-title="" title="">superuser</a>
			  		   </td>
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
			   <a data-toggle="collapse" data-parent="" href="#collapseThree" class="pull-right"><b>+</b></a>
			      Keywords: <span class="label label-primary">example1</span> <span class="label label-primary">example2</span>
			    
			  </h4>
			</div>

			<div id="collapseThree" class="panel-collapse collapse in">
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
			    <a data-toggle="collapse" data-parent="" href="#collapseFour" class="pull-right"><b>+</b></a>
			      Keywords: <span class="label label-primary">example1</span> <span class="label label-primary">example2</span>
			  </h4>
			</div>

			<div id="collapseFour" class="panel-collapse collapse in">
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
			    <a data-toggle="collapse" data-parent="" href="#collapseFive" class="pull-right"><b>+</b></a>
			      Keywords: <span class="label label-primary">dabvis</span> <span class="label label-primary">CLA</span>
			  </h4>
			</div>

			<div id="collapseFive" class="panel-collapse collapse in">
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
			    <a data-toggle="collapse" data-parent="" href="#collapseSix" class="pull-right"><b>+</b></a>
			      Keywords: <span class="label label-primary">dabvis</span> <span class="label label-primary">CLA</span>
			  </h4>
			</div>

			<div id="collapseSix" class="panel-collapse collapse in">
			  <div class="panel-body">
			  	California, ...
			  </div>
			</div>

			</div>
		</div>
	</div>
	</div>


@stop
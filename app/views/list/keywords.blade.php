@extends('layouts.internal')
@section('main')

    <div class="col-md-12" ng-controller="keyWordsListCtrl">

	<div style="padding-top:0px; margin-top:-30px; margin-bottom:20px;">
		<button class="btn btn-default" style="margin:0px;" ng-click="show_create_modal()">Add Keyword List <span class="fa fa-plus" style="font-size:13px"></span></button>
	</div>

    	<!-- <* keyWordsLists *> -->

		<div class="col-md-6 item" ng-repeat="keyWordsList in keyWordsLists | filter:__G__search">

			<div class="panel-group" id="accordion<* keyWordsList.id *>">
				<div class="panel panel-default">

					<div class="panel-heading">
					  <h4 class="panel-title">

					  	<div class="col-md-2 pull-right" style="padding:0px; width:11%;">

							<span data-animation="am-flip-x" placement="left" bs-tooltip="tooltip">
								<input
										type="checkbox"
										id="check_<* keyWordsList.id *>"
										ng-click="keepOriginalContent(<* keyWordsList.id *>)"
										ng-checked="keyWordsList.original_content"
										style="padding-right:0px; margin-right:0px;"
								/>
							</span>

							<a href="javascript:void(0)" ng-click="removeKeywordEntity($index, '<* keyWordsList.id *>')">
						  		<span class="text-danger" style="float:right; margin-left:15px;"><b>x</b></span>
						  	</a>

						    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<* keyWordsList.id *>" class="pull-right nounderline">
						    	<span class=""><b>+</b></span>
						    </a>

						</div>

					      Keywords: <span style="margin-right:2px;" ng-repeat="(key, value) in keyWordsList.keywords" class="label label-primary"><* value *></span>

					  </h4>
					</div>

					<div id="collapse<* keyWordsList.id *>" class="panel-collapse collapse in">
					  <div class="panel-body">

					  	<table class="table table-bordered" style="margin:4px 0px 4px 0px;">

					  		<tr>
					  			<th>Greetings</th>
					  			<th>Email</th>
					  			<th style="width:1%">Action</th>
					  		</tr>

					  		<tr ng-repeat="email in keyWordsList.email" id="id-tr-email-<* email.email_list_id *>">
					  			<td>
					  				<span editable-text="email.full_name" e-name="full_name" e-form="rowform" e-required>
					  					<* email.full_name || 'empty' *>
					  				</span>
					  			</td>
					  			<td>
					  				<span editable-text="email.email" e-name="email" e-form="rowform" e-required>
					  					<* email.email || 'empty' *>
					  				</span>
					  			</td>

					  			<td style="white-space: nowrap">
							        <!-- form -->
							        <form editable-form name="rowform" onbeforesave="saveRecipient($data, user.id)" ng-show="rowform.$visible" class="form-buttons form-inline" >
							          <button type="submit" ng-disabled="rowform.$waiting" class="btn btn-primary">
							            save
							          </button>
							          <button type="button" ng-disabled="rowform.$waiting" ng-click="rowform.$cancel()" class="btn btn-default">
							            cancel
							          </button>
							        </form>
							        <div class="buttons" ng-show="!rowform.$visible">
							          <button class="btn btn-primary" ng-click="rowform.$show()">edit</button>
							          <button class="btn btn-danger" ng-click="removeRecipent($parent.$index, $index)">del</button>
							        </div>
						      	</td>

					  		</tr>

					  	</table>

					  	 <button class="btn btn-sm btn-default" ng-click="addRecipent($index);">Add <span class="fa fa-plus" style="font-size:13px"></span></button>

					  </div>
					</div>

				</div>
			</div>

		</div>

		<!-- div class="col-md-6">
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">

			<div class="panel-heading">
			  <h4 class="panel-title">

				<a href="javascript:void(0)">
			  		<span class="text-danger" style="float:right; padding-left:15px;"><b>x</b></span>
			  	</a>

			    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="pull-right nounderline">
			    	<span class=""><b>+</b></span>
			    </a>

			      Keywords: <span class="label label-primary">dabvis</span> <span class="label label-primary">CLA</span>

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

			  	<a href="javascript:void(0)">
			  		<span class="text-danger" style="float:right; padding-left:15px;"><b>x</b></span>
			  	</a>

			    <a data-toggle="collapse" data-parent="" href="#collapseTwo" class="pull-right nounderline" id="clickCol">
			    	<span class=""><b>+</b></span>
			    </a>

			      Keywords: <span class="label label-primary">example1</span> <span class="label label-primary">example2</span>
			  </h4>
			</div>

			<div id="collapseTwo" class="panel-collapse collapse in">
			  <div class="panel-body">
			    	<h5>Recipients:</h5>
			  	<table class="table table-bordered">
			  		<tr>
			  			<th>Greetings</th>
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

			  	<a href="javascript:void(0)">
			  		<span class="text-danger" style="float:right; padding-left:15px;"><b>x</b></span>
			  	</a>

			   <a data-toggle="collapse" data-parent="" href="#collapseThree" class="pull-right nounderline">
			   		<span><b>+</b></span>
			   </a>

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

			  	<a href="javascript:void(0)">
			  		<span class="text-danger" style="float:right; padding-left:15px;"><b>x</b></span>
			  	</a>

			    <a data-toggle="collapse" data-parent="" href="#collapseFour" class="pull-right nounderline">
			    	<span><b>+</b></span>
			    </a>

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

			  	<a href="javascript:void(0)">
			  		<span class="text-danger" style="float:right; padding-left:15px;"><b>x</b></span>
			  	</a>

			    <a data-toggle="collapse" data-parent="" href="#collapseFive" class="pull-right nounderline">
			    	<span><b>+</b></span>
			    </a>

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

			  	<a href="javascript:void(0)">
			  		<span class="text-danger" style="float:right; padding-left:15px;"><b>x</b></span>
			  	</a>

			    <a data-toggle="collapse" data-parent="" href="#collapseSix" class="pull-right nounderline">
			    	<span><b>+</b></span>
			    </a>

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
	</div -->

	@include('__modals__.keywords_list.create')
	</div>


@stop
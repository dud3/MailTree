@extends('layouts.internal')
@section('main')

<div ng-controller="emailsListCtrl" style="margin-top:-20px;">

	<table class="table table-hover table-emails">

		<thead>
			<tr>
				<th style="width:3%; padding-left: 14px;"><input type="checkbox" id="mail-check-all" /></th>
				<th>Subject</th>
				<th>Date</th>
				<!-- th>Body</th -->
				<th style="width:5%;">Emails(<* emails.length *>) </th>
			</tr>
		</thead>

		<tbody>
			<tr ng-repeat="email in emails | filter:__G__search" id="id-email<* email.id *>" ng-class="{ 'mail-sent': email.sent }">
				<td style="padding:8px 0px 0px 15px; margin:0px;"><input type="checkbox" id="check-email<* email.id *>" name="check-email<* email.id *>"></td>
				<td ng-bind-html="email.subject"></td>
				<td><* email.utc_time *></td>
				<!-- td ng-bind-html="email.body"></td -->
				<td class="text-right" style="padding:6px 10px">
					<span ng-show="email.sent" class="label label-success mail-sent-label" style="padding:2.5px 19px 2.5px 15px;">
						Sent&nbsp;<span class="fa fa-envelope"></span>
					</span>
					<button ng-show="!email.sent" style="font-size:10px; padding:2px 15px 2px 15px;" class="btn btn-info btn-sm">
						Send&nbsp;<span class="fa fa-paper-plane"></span>
					</button>
				</td>
			</tr>

			<!-- 
				Smaple templates
			-->

			<!-- New Mails -->
			<!-- tr>
				<td><input type="checkbox" name="" value=""></td>
				<td>Title of email with some keywords like <span class="label label-primary">California</span> and whatever</td>
				<td>Date</td>
				<td><button class="btn btn-info btn-sm">Send&nbsp;<span class="fa fa-paper-plane"></span></button></td>
			</tr>
			<tr>
				<td><input type="checkbox" name="" value=""></td>
				<td>Title of email with some keywords like <span class="label label-primary">Davis</span> and <span class="label label-primary">mailing</span></td>
				<td>Date</td>
				<td><button class="btn btn-info btn-sm">Send&nbsp;<span class="fa fa-paper-plane"></span></button></td>
			</tr>
			<tr>
				<td><input type="checkbox" name="" value=""></td>
				<td>This title has <span class="label label-primary">Example1</span> and <span class="label label-primary">example2</span></td>
				<td>Date</td>
				<td><button class="btn btn-info btn-sm">Send&nbsp;<span class="fa fa-paper-plane"></span></button></td>
			</tr>
				<tr>
				<td><input type="checkbox" name="" value=""></td>
				<td>Title with some keywords <span class="label label-primary">Example3</span> and some more <span class="label label-primary">example4</span></td>
				<td>Date</td>
				<td><button class="btn btn-info btn-sm">Send&nbsp;<span class="fa fa-paper-plane"></span></button></td>
			</tr>
				</tr>
				<tr>
				<td><input type="checkbox" name="" value=""></td>
				<td>This title <span class="label label-primary">Example3</span> is pretty long <span class="label label-primary">example4</span>it has and some more <span class="label label-primary">keywords</span></td>
				<td>Date</td>
				<td><button class="btn btn-info btn-sm">Send&nbsp;<span class="fa fa-paper-plane"></span></button></td>
			</tr -->

			<!-- Sent mails -->
			<!-- tr class="mail-sent">
				<td><input type="checkbox" name="" value=""></td>
				<td>Title of email with some keywords like <span class="label label-primary">California</span> and whatever</td>
				<td>Date</td>
				<td><span class="label label-success mail-sent-label" style="padding:5px 19px 5px 15px;">Sent&nbsp;<span class="fa fa-envelope"></span><</td>
			</tr -->

		</tbody>

	</table>

</div>

@stop

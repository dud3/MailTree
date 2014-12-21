@extends('layouts.internal')
@section('main')

<div ng-controller="emailsListCtrl" style="margin-top:-20px;">

    <div class="row col-md-12" style="margin-bottom:5px; padding-right: 0px; width: 100%;">
        <button ng-click="composeEmail()" class="btn btn-primary btn-sm pull-left" style="margin-left: 10px;" ng-click="show_create_modal()" disabled>
        COMPOSE <!-- span class="fa fa-plus" style="font-size:13px"></span -->
        </button>
        <button ng-click="sendCollective()" style="padding:5px 15px 5px 15px; margin-right: 0px;" class="btn btn-info btn-sm pull-right" disabled>
        SEND <span class="fa fa-paper-plane" style="font-size:13px"></span>
        </button>
    </div>

    <div class="row col-md-12" style="padding-right: 0px; padding-left: 25px; margin-right: 0px;">
        <table class="table table-hover table-emails" style="font-size:12px;">

            <thead>
                <tr>
                    <th style="width:2%; padding-left: 10px;">
                        <input ng-show="count_sent_emails < emails.length" type="checkbox" id="mail-check-all" />
                        <span ng-show="count_sent_emails == emails.length" class="fa fa-check-square-o fa-lg text-success"></span>
                    </th>
                    <th>Subject</th>
                    <th>Date</th>
                    <!-- th>Body</th -->
                    <th style="; text-align: left;"></th>
                    <th style="width:1%;">Emails(<* emails.length *>) </th>
                </tr>
            </thead>

            <tbody>

                <tr ng-repeat="email in emails | filter:__G__search" id="id-email<* email.id *>" ng-class="{ 'mail-sent': email.sent }" class="item-email">
                    <td style="padding:7px 6px 6px 10px; background-color:#eee;">
                        <input ng-show="!email.sent" type="checkbox" id="check-email<* email.id *>" name="check-email<* email.id *>">
                        <span ng-show="email.sent" class="fa fa-check-square-o fa-lg text-success"></span>
                    </td>
                    <td ng-bind-html="email.subject"></td>
                    <td><* email.utc_time *></td>
                    <!-- td ng-bind-html="email.body"></td -->
                    <td class="text-left" style="width:5%; padding-right:0px; margin-right: 0px;">

                        <button class="btn btn-default btn-sm" style="padding:0px 3px 0px 3px"
                                ng-click="editEmail(email.id)">
                            <span class="fa fa-pencil-square-o" style="font-size:13px;"></span>
                        </button>

                        <button data-animation="am-flip-x" placement="left" bs-tooltip="tooltip" 
                                class="btn btn-default btn-sm" style="padding:0px 3px 0px 3px"
                                ng-click="viewEmail(email.id)">
                            <span class="fa fa-eye" style="font-size:13px"></span>
                        </button>

                    </td>
                    <td style="padding-left:3px; margin-left: 0px;">
                        <span ng-show="email.sent" class="label label-success mail-sent-label" style="padding:2.5px 19px 2.5px 19px;">
                            Sent&nbsp;<span class="fa fa-envelope"></span>
                        </span>
                        <button ng-show="!email.sent" style="font-size:10px; padding:2px 15px 2px 15px;" class="btn btn-info btn-sm">
                            Send&nbsp;<span class="fa fa-paper-plane"></span>
                        </button>
                    </td>
                </tr>

            </tbody>

        </table>
    </div>

{{-- View single email modal --}}
@include('__modals__.emails_list.modalViewEmail')
@include('__modals__.emails_list.modalEditEmail')

</div>

@stop

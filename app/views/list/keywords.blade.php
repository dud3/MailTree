@extends('layouts.internal')
@section('main')

    <div class="col-md-12" ng-controller="keyWordsListCtrl">

        <div style="padding-top:0px; margin-top:-30px; margin-bottom:20px;">
            <button class="btn btn-default" style="margin:0px;" ng-click="show_create_modal()">Add Keyword Entity <span class="fa fa-plus" style="font-size:13px"></span></button>
        </div>

        <div class="col-md-6 item" ng-repeat="keyWordsList in keyWordsLists | filter:__G__search">

            <div class="panel-group" id="accordion<* keyWordsList.id *>">
                <div class="panel panel-default">

                    <div class="panel-heading">
                      <h4 class="panel-title">

                            {{-- Right side actions --}}
                            <a href="javascript:void(0)" ng-click="removeKeywordEntity($index, '<* keyWordsList.id *>')">
                                <span class="text-danger" style="float:right; margin-left:15px;"><b>x</b></span>
                            </a>

                            <div class="dropdown pull-right" id="settings-dropdown<* keyWordsList.id *>" style="cursor:pointer; padding:0px; margin:1px">
                              <a id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                                <span class="fa fa-cog"></span>
                              </a>

                              <ul class="dropdown-menu" 
                                  style="font-size:12px; padding:5px;" 
                                  role="menu" aria-labelledby="dropdownMenu1" 
                                  ng-click="drodownStayOpen('settings-dropdown<* keyWordsList.id *>')">
                                
                                <li role="presentation">
                                <span style="cursor:pointer;">
                                    <label>
                                        <input
                                                type="checkbox"
                                                id="check_automatically_<* keyWordsList.id *>"
                                                ng-click="sendAutomatically(<* keyWordsList.id *>)"
                                                ng-checked="keyWordsList.send_automatically">
                                        </input>
                                        Send automatically
                                    </label>
                                </span>
                                </li>

                                <li role="presentation">
                                <span style="cursor:pointer;">
                                    <label>
                                        <input
                                                type="checkbox"
                                                id="check_original_<* keyWordsList.id *>"
                                                ng-click="keepOriginalContent(<* keyWordsList.id *>)"
                                                ng-checked="keyWordsList.original_content">
                                        </input>
                                        Keep Original Content
                                    </label>
                                </span>
                                </li>

                              </ul>

                            </div>

                          Keywords: <span style="margin-right:2px;" ng-repeat="(key, value) in keyWordsList.keywords" class="label label-primary"><* value *></span>

                      </h4>
                    </div>

                    <div id="collapse<* keyWordsList.id *>" class="panel-collapse collapse in">
                      <div class="panel-body" style="overflow: auto; width:100%; padding:10px 10px 5px;">

                        <table class="table table-bordered table-responsive" style="margin:4px 0px 4px 0px;">

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
                                    <form editable-form name="rowform" onbeforesave="saveRecipient($data, keyWordsList.id, $index)" ng-show="rowform.$visible" class="form-buttons form-inline" shown="inserted == email">
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

                         <button class="btn btn-block btn-default" style="background-color:#e7e7e7; marg%" ng-click="addRecipent($index);">Add <span class="fa fa-plus" style="font-size:13px"></span></button>

                      </div>
                    </div>

                    <div class="text-center" style="padding:0px; margin:0px; border-top: 1px solid #ddd; color:#ccc; cursor: pointer;" 
                        ng-click="collapse(keyWordsList.id)">
                        <span class="fa fa-chevron-up fa-2x"></span>
                    </div

                </div>
            </div>

        </div>

    @include('__modals__.keywords_list.create')
    </div>


@stop
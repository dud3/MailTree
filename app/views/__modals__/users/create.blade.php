<!-- Modal -->
<div class="modal fade" ng-controller="UserCtrl" id="id-modal-create_users" tabindex="-1" role="dialog" aria-labelledby="create_keywordList" aria-hidden="true">
  <div class="modal-dialog" style="width:35%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" ng-click="close()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title text-muted" id="myModalLabel">Create user</h4>
      </div>

      <div class="modal-body">

      <div class="row">

        <div class="col-md-12">

          <div id="id-recipients-container">
            <div ng-repeat="recipient in keywordEntity.recipients">
              <div class="col-md-12" style="padding:0px 0px 5px 0px;">
                <input type="text" ng-model="user.first_name" placeholder="First Name" class="form-control">
              </div>
              <div class="col-md-12" style="padding:0px 0px 5px 0px;">
                <input type="text" ng-model="user.last_name" placeholder="Last Name" class="form-control">
              </div>
              <div class="col-md-12" style="padding:0px 0px 5px 0px;">
                <input type="text" id="id-email" name="n-email" ng-model="user.email" placeholder="Email" class="form-control">
              </div>
              <div class="col-md-12" style="padding:0px 0px 5px 0px;">
                <input type="password" ng-model="user.password" placeholder="Password" class="form-control">
              </div>
            </div>
          </div>

          <!-- div class="col-md-12" style="padding:10px 0px;">
            <button ng-click="addRecipentInput()" class="btn btn-default btn-sm">Add more</button>
            <button id="id-remove-recipient" class="btn btn-danger btn-sm" ng-click="removeRecipentInput()" style="display:none;"><span>X</span></button>
          </div -->

        </div>

      </div>

      </div>

      <div class="modal-footer">
        <div id="id-modal-settings" class="checkbox pull-left">
        </div>
        <button type="button" id="id-close-modal_users" class="btn btn-default" data-dismiss="modal" ng-click="hide_create_modal()">Close</button>
        <button type="button" id="id-create-users" class="btn btn-primary" ng-click="createUser()" disabled="true">Submit</button>
      </div>
    </div>
  </div>
</div>
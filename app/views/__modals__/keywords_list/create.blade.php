<!-- Modal -->
<div class="modal fade" id="id-modal-create_keywordList" tabindex="-1" role="dialog" aria-labelledby="create_keywordList" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" ng-click="close()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title text-muted" id="myModalLabel">Create Keyworkds List</h4>
      </div>

      <div class="modal-body">

      <div class="row">

        <div class="col-md-4" style="border-right:1px solid #ccc;">
          <h4 style="padding-top:0px; padding-bottom:0px; margin-top:0px;">Keywords</h4><hr style="padding:0px; margin:0px;">

          <div class="col-md-12" style="padding:10px 0px;">
            <div id="id-keywords-container">
              <div ng-repeat="keyword in keywordEntity.keywords" style="padding-bottom:5px;">
                <input ng-focus="cleanKeywordsExists()" id="id-input-keyword" class="form-control" ng-model="keyword.keyword" placeholder="Enter keyword name...">
              </div>
            </div>
          </div>

          <div class="col-md-12" style="padding:0px 0px;">
            <button ng-click="addKeywordInput()" class="btn btn-default btn-sm">Add more</button>
             <button id="id-remove-keyword" class="btn btn-danger btn-sm" ng-click="removeKeywordInput()" style="display:none;"><span>X</span></button>
          </div>

        </div>

        <div class="col-md-8">
          <h4 style="padding-top:0px; padding-bottom:0px; margin-top:0px;">Recipents</h4><hr style="padding:0px; margin:0px 0px 10px 0px;">

          <div id="id-recipients-container">
            <div ng-repeat="recipient in keywordEntity.recipients">
              <div class="col-md-6" style="padding:0px 5px 5px 0px;">
                <input type="text" ng-model="recipient.full_name" placeholder="Greetings..." class="form-control">
              </div>
              <div class="col-md-6" style="padding:0px 0px 5px 0px;">
                <input ng-model="recipient.email" placeholder="Email..." class="form-control">
              </div>
            </div>
          </div>

          <div class="col-md-12" style="padding:10px 0px;">
            <button ng-click="addRecipentInput()" class="btn btn-default btn-sm">Add more</button>
            <button id="id-remove-recipient" class="btn btn-danger btn-sm" ng-click="removeRecipentInput()" style="display:none;"><span>X</span></button>
          </div>

        </div>

      </div>

      </div>

      <div class="modal-footer">
        <div id="id-modal-settings" class="checkbox pull-left">
          <!-- label>
            <input type="checkbox" ng-model="keywordEntity.original_content"><span class="text-info">Keep Original Content</span>
          </label -->

          @include('__partials__.settings_dropdown')

        </div>
        <button type="button" id="id-close-keywordList" class="btn btn-default" data-dismiss="modal" ng-click="hide_create_modal()">Close</button>
        <button type="button" id="id-create-keywordList" class="btn btn-primary" ng-click="create()" disabled="true">Save changes</button>
      </div>
    </div>
  </div>
</div>
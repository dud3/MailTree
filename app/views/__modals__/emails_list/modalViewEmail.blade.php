<!-- Modal -->
<div class="modal fade" id="id-modal-view_single_email" tabindex="-1" role="dialog" aria-labelledby="create_keywordList" aria-hidden="true">
  <div class="modal-dialog" style="min-width:800px;">
    <div class="modal-content" id="id-modal-content-view_single_email">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" ng-click="close()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title text-muted" id="myModalLabel">View Email</h4>
      </div>

      <div class="modal-body" style=" position: relative;
    overflow-y: auto;
    min-width: 780px;
    max-height: 680px;
    background: #f6f6f6;">

          <div class="row">
                @include('__modules__.viewEmail')
          </div>

      </div>

      <div class="modal-footer">
        <div class="checkbox pull-left" style="vertical-align:middle;" data-toggle="tooltip" data-placement="left" title="This option will save the email's original content, no matter keyword conditions.">
          <!-- label>
            <input type="checkbox" ng-model="keywordEntity.original_content"><span class="text-info">Keep Original Content</span>
          </label -->
        </div>
        <!-- button type="button" id="id-close-keywordList" class="btn btn-default" data-dismiss="modal" ng-click="hide_create_modal()">Close</button>
        <button type="button" id="id-create-keywordList" class="btn btn-primary" ng-click="create()">Save changes</button -->
      </div>
    </div>
  </div>
</div>
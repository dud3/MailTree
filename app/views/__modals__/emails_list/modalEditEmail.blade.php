<!-- Modal -->
<div class="modal fade" id="id-modal-edit_single_email" tabindex="-1" role="dialog" aria-labelledby="create_keywordList" aria-hidden="true">
  <div class="modal-dialog" style="min-width:800px;">
    <div class="modal-content" id="id-modal-content-view_single_email">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" ng-click="close()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title text-muted" id="myModalLabel">View Email</h4>
      </div>

      <div class="modal-body" style="background: #f6f6f6; padding:30px;">

          <div text-angular ng-model="email.message_body" class="row">
                
          </div>

      </div>

      <div class="modal-footer">
        <div class="checkbox pull-left" style="vertical-align:middle;" data-toggle="tooltip" data-placement="left" title="This option will save the email's original content, no matter keyword conditions.">
        </div>
        <button type="button" id="id-close-edit_single_email" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="id-save-edit_single_email" class="btn btn-primary" ng-click="saveEmail()">Save changes</button>
      </div>
    </div>
  </div>
</div>
<style>
.ta-editor.form-control.myform1-height, .ta-scroll-window.form-control.myform1-height  {
    min-height: 150px;
    height: auto;
    overflow: auto;
    font-family: inherit;
    font-size: 100%;
}

.form-control.myform1-height > .ta-bind {
    height: auto;
    min-height: 150px;
    padding: 6px 12px;
}
</style>

<!-- Modal -->
<div class="modal fade" id="id-modal-addLink_keywordList" tabindex="-1" role="dialog" aria-labelledby="addLink_keywordList" aria-hidden="true">
  <div class="modal-dialog" style="min-width:800px;">
    <div class="modal-content" id="id-modal-content-view_single_email">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" ng-click="close()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title text-muted" id="myModalLabel">Add link</h4>
      </div>

      <div class="modal-body" style="background: #f6f6f6; padding:10px 30px 10px 30px;">
          <div text-angular id="addlink-message_body" ng-model="addlink.message_body" class="row"
            ta-text-editor-class="form-control myform1-height"
            ta-html-editor-class="form-control myform1-height">
          </div>
      </div>

      <div style="padding:10px 0px 10px 15px" class="form-inline">
      <label for="exampleInputName2">Position: </label>
        <select class="form-control" id="addlink-position">
          <option value="Top">Top</option>
          <option value="Bottom">Bottom</option>
        </select>
      </div>

      <div class="modal-footer">
        <div class="checkbox pull-left" style="vertical-align:middle;" data-toggle="tooltip" data-placement="left" title="This option will save the email's original content, no matter keyword conditions.">
        </div>
        <button type="button" id="id-close-edit_single_email" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="id-save-edit_single_email" class="btn btn-primary" ng-click="submit_add_link()">Save changes</button>
      </div>
    </div>
  </div>
</div>

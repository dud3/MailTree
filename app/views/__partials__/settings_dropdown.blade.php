<div class="dropdown pull-left" id="m_settings-dropdown" style="cursor:pointer; padding:0px; margin:1px; font-weight:bold;">

    <a id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
      <span class="fa fa-cog"></span>&nbsp;<span class="text-info">Settings</span>
    </a>

    <ul class="dropdown-menu" 
        style="font-size:12px; padding:5px;  width:180px;" 
        role="menu" aria-labelledby="dropdownMenu1" 
        onclick="drodownStayOpen('m_settings-dropdown')">

      <li role="presentation" placement="top" bs-tooltip="tooltip.settings.auto">
      <span class="fa fa-info-circle pull-right text-info"></span>
      <span style="cursor:pointer;">
        <label>
          <input ng-model="keywordEntity.send_automatically"
              ng-checked="keywordEntity.send_automatically"
              style="margin-top:0px;"
              type="checkbox"
              id="check_automatically_">
          </input>
          Send automatically
        </label>
      </span>
      </li>

      <li role="presentation" placement="top" bs-tooltip="tooltip.settings.origin">
      <span class="fa fa-info-circle pull-right text-info"></span>
      <span style="cursor:pointer;">
        <label>
          <input  ng-model="keywordEntity.original_content"
              ng-checked="keywordEntity.original_content"
              style="margin-top:0px;"
              type="checkbox"
              id="check_original_">
          </input>
          Keep Original Content
        </label>
      </span>
      </li>

    </ul>

</div>
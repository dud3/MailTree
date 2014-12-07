<!-- Sidebar -->
<div id="sidebar-wrapper" ng-controller="activeFiltersCtrl">
    <ul class="sidebar-nav">
        <!-- li class="sidebar-brand">
            Extra Options
        </li -->
        <li ng-click="openFiltersList()">
            <a href="#"><span class="fa fa-filter" style="margin-left:-20px;"></span>&nbsp;Filters</a>
        </li>

        <li>
         <div id="id-filter-container" class="cls-filter-container" style="display:none;">

            <div>

                <ul id="id-filters-list" class="cls-filters-list">

                  <li id="id-open-rootKeywords" ng-click="openRootKeywords()">
                    <a href="#"><span class="fa fa-angle-right" style="padding:0px; margin-left:-20px;"></span>&nbsp;RootKeywords</a>
                  </li>

                  <li>
                    <div id="id-rootKeywords-list" style="display:none;">
                      <ul>
                        <li ng-repeat="rootKeyword in activeFilter.rootKeywords" >
                          <a href="#" ng-click="activateFilter('<* rootKeyword *>')">
                            <span class="fa fa-filter" style="margin-left:-30px; font-size:10px;"></span>
                            <span class="label label-primary ng-binding ng-scope"><* rootKeyword *></span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </li>

                  <li id="id-open-allKeywords" ng-click="openAllKeywords()">
                    <a href="#"><span class="fa fa-angle-right" style="padding:0px; margin-left:-20px;"></span>&nbsp;All keywords</a>
                  </li>

                  <li>
                    <div id="id-allKeywords-list" style="display:none;">
                       <ul>
                        <li ng-repeat="keyword in activeFilter.allKeywords" >
                          <a href="#" ng-click="activateFilter('<* keyword *>')">
                            <span class="fa fa-filter" style="margin-left:-30px; font-size:10px;"></span>
                            <span class="label label-primary ng-binding ng-scope"><* keyword *></span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </li>

                </ul>

            </div>

          </div>
        </li>

        <hr>
        <li>
            <a href="#">About</a>
        </li>
        <li>
            <a href="#">Contact</a>
        </li>
    </ul>
</div>
<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <div id="id-navbar-header" class="navbar-header" style="cursor:pointer;">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <img src="/images/mini_icon.png" id="barnd-img" class="roundImage img-icon" style="float:left;" />
      <span id="id-nav-slider" class="fa fa-th-list fa-3x img-icon" style="float:left; display:none;"></span>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">

        <li
          @if(Config::get('constant.g_currentPage') == 'app')
            class="active"
          @endif
        ><a href="/app">Home</a>
        </li>

        <li
          @if(Config::get('constant.g_currentPage') == 'app/emails')
            class="active"
          @endif
        ><a href="/app/emails">Emails</a>
        </li>

      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#"
             class="dropdown-toggle" data-toggle="dropdown">
            <span style="" class="user">Someone@xmail.com</span>
            <span class="caret"></span>
          </a>
           <ul class="dropdown-menu" role="menu">
            <li><a href="#">Settings</a></li>
            <li><a href="#">Create User</a></li>
            <li class="divider"></li>
            <li class="dropdown-header">Other</li>
            <li><a href="#"><span class="fa fa-at"></span> Contact(developer)</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-arrow-left"></span> Log out</a></li>
          </ul>
        </li>
      </ul>

    <div class="col-sm-3 col-md-3 pull-left" style="padding:0px;">
          <form class="navbar-form" role="search" autocomplete="off">
              <div class="input-group" style="width:100%;">
                  <input type="text" class="form-control" ng-model="__G__search" placeholder="Search anything..." name="q">
                  <div class="input-group-btn">
                      <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                  </div>
              </div>
          </form>
      </div>

    </div><!--/.nav-collapse -->
  </div>
</div>
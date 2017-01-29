    <div flex>
      
      <!-- Fixed navbar -->
      <nav class="navbar navbar-inverse hidden-xs">
        <div>
          <div layout="row">
            <div class="navbar-header" flex="30">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#"><img src="/img/icon.png" /></a>
              <ul class="nav navbar-nav navbar-inverse submenu">
                <li class="company-name"><strong>Organisation Name</strong></li>
                <li class="company-dropdown"><a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <span>
                    <md-tooltip md-direction="right">
                      {{__( "Switch Organisation" )}}
                    </md-tooltip>
                    <i class="fa fa-arrow-circle-down"></i>
                  </span></a>
                  <ul class="dropdown-menu">
                    <li><a href="/plans">Test Plans</a></li>
                    <li><a href="/users">Users</a></li>
                    <li><a href="/settings">Settings</a></li>
                  </ul>
                </li>
              </ul>
            </div>
            <div flex="70">
              <div layout="row">
                <div flex="60" ng-controller="SearchCtrl">
                  <input type="text" id="search-top" name="k" autocomplete="off" class="f/orm-control" placeholder="{{__( "Search..." )}}" />
                </div>
                <div flex="40">
                  <div layout="row">
                    <div flex="100">
                      <div layout="row">
                        <div flex="95">
                          <ul class="nav navbar-nav navbar-right">
                      <li><md-tooltip md-direction="down">
                            {{__( "My Account" )}}
                          </md-tooltip><a href="/"><i class="fa fa-user"></i></a></li>
                      <li><md-tooltip md-direction="down">
                            {{__( "Language" )}}
                          </md-tooltip><a href="/"><i class="fa fa-globe"></i></a></li>
                      <li><md-tooltip md-direction="down">
                            {{__( "Manage Team" )}}
                          </md-tooltip><a href="/"><i class="fa fa-group"></i></a></li>
                      <li><md-tooltip md-direction="down">
                            {{__( "Notifications" )}}
                          </md-tooltip><a href="/"><i class="fa fa-bell"></i></a></li>
                      <li><md-tooltip md-direction="down">
                            {{__( "Billing" )}}
                          </md-tooltip><a href="/"><i class="fa fa-dollar"></i></a></li>
                      <li><md-tooltip md-direction="down">
                            {{__( "Log Out" )}}
                          </md-tooltip><a href="/"><i class="fa fa-times"></i></a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </nav>

    </div>
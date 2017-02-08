@extends('index')

@section('title')
{{$project->title}} - {{___( "Test Suites" )}}
@stop

@section('left-side')

  @include('navs.project-manage', [ 'active' => 'suites', 'project_id' => $project->id ])

@stop

@section('page-heading')
{{___( "Test Suites" )}}
@stop

<?php $layout_toolbar = 1; ?>

@section('toolbar')
  <div id="header-toolbar">
    <ul class="toolbar">
      <li><a href="/projects/{{$project->id}}/suites/new"><img src="/img/toolbar/new.png" class="toolbar-icon" /> {{___( "Add Suite" )}}</a></li>
    </ul>
  </div>
@stop

@section('main')

  <div ng-controller="SuitesCtrl">

    <input type="hidden" id="project_id" value="{{$project->id}}" />
    @if ( arg( $_REQUEST, 'suite_id' ) )
    <input type="hidden" id="suite_id" value="{{arg( $_REQUEST, 'suite_id' )}}" />
    @endif
    @if ( arg( $_REQUEST, 'scenario_id' ) )
    <input type="hidden" id="scenario_id" value="{{arg( $_REQUEST, 'scenario_id' )}}" />
    @endif
    <div ng-show="suites.length < 1"><big>{{___( "No test suites were found on this project." )}}</big></div>
    
    <div layout="row" ng-show="suites.length > 0">

      <div flex="30" id="suite-list">

        <div class="suite-list suites" ng-show="suites.length > 0">
          
          <h5>{{___( "Suites" )}}</h5>
          <div ng-repeat="S in suites" ng-class="suiteClass(S.id)" ng-click="getSuite(S.id)">

            <div class="card-item">
              @{{S.name}} (@{{S.children}})

              <md-menu>
                <i class="fa fa-gear" ng-click="openMenu($mdOpenMenu, $event)" class="options-menu" style="float: right;"></i>
                <md-menu-content width="4">
                  <md-menu-item>
                    <md-button ng-click="editSuite(S.id)">
                      <i class="fa fa-edit"></i> &nbsp;
                      {{___( "Edit" )}}
                    </md-button>
                  </md-menu-item>
                  <md-menu-item>
                    <md-button ng-click="deleteSuite(S.id)">
                      <i class="fa fa-trash"></i> &nbsp;
                      {{___( "Delete" )}}
                    </md-button>
                  </md-menu-item>
                  <!-- <md-menu-item>
                    <md-button ng-click="copySuite(S.id)">
                      <i class="fa fa-copy"></i> &nbsp;
                      {{___( "Copy" )}}
                    </md-button>
                  </md-menu-item>
                  <md-menu-divider></md-menu-divider>
                  <md-menu-item>
                    <md-button ng-click="copySuite(S.id)">
                      <i class="fa fa-copy"></i> &nbsp;
                      {{___( "Copy To" )}} ...
                    </md-button>
                  </md-menu-item>
                  <md-menu-item>
                    <md-button ng-click="moveSuite(S.id)">
                      <i class="fa fa-arrows"></i> &nbsp;
                      {{___( "Move To" )}} ...
                    </md-button> -->
                  </md-menu-item>
                  
                </md-menu-content>
              </md-menu>

            </div>

          </div>
        
        </div>

      </div>

      <div flex="30" id="scenario-list">

        <div class="suite-list scenarios">

          <div>
            <h5>{{___( "Scenarios" )}}</h5>
            <i class="fa fa-plus push-right pull-up" ng-click="addScenario()"></i>
          </div>
        
          <div ng-repeat="s in scenarios" ng-class="scenarioClass(s.id)" ng-click="getScenario(s.id)">
            
            <div class="card-item">

              @{{s.name}} (@{{s.children}})

              <md-menu>
                <i class="fa fa-gear push-right" ng-click="openMenu($mdOpenMenu, $event)" class="options-menu"></i>
                <md-menu-content width="4">
                  <md-menu-item>
                    <md-button ng-click="editScenario(s.id)">
                      <i class="fa fa-edit"></i> &nbsp;
                      {{___( "Edit" )}}
                    </md-button>
                  </md-menu-item>
                  <md-menu-item>
                    <md-button ng-click="deleteScenario(s.id)">
                      <i class="fa fa-trash"></i> &nbsp;
                      {{___( "Delete" )}}
                    </md-button>
                  </md-menu-item>
                  <!-- <md-menu-item>
                    <md-button ng-click="copyScenario(s.id)">
                      <i class="fa fa-copy"></i> &nbsp;
                      {{___( "Copy" )}}
                    </md-button>
                  </md-menu-item>
                  <md-menu-divider></md-menu-divider>
                  <md-menu-item>
                    <md-button ng-click="copyScenario(s.id)">
                      <i class="fa fa-copy"></i> &nbsp;
                      {{___( "Copy To" )}} ...
                    </md-button>
                  </md-menu-item>
                  <md-menu-item>
                    <md-button ng-click="moveScenario(s.id)">
                      <i class="fa fa-arrows"></i> &nbsp;
                      {{___( "Move To" )}} ...
                    </md-button> -->
                  </md-menu-item>
                  
                </md-menu-content>
              </md-menu>

            </div>

          </div>

          <!-- <div ng-show="!activesuite() && hassuites()">{{___( "Select a test suite from the left." )}}</div>
          <div ng-show="activesuite() && !hasscenarios()">{{___( "No scenarios on this suite yet." )}}</div> -->

        </div>

      </div>

      <div flex id="case-list">

        <div class="suite-list suites" ng-show="suites.length > 0">
        
          <div>
            <h5>{{___( "Cases" )}}</h5>
            <i class="fa fa-plus push-right pull-up" ng-click="addCase($event)"></i>
          </div>

          <div ng-repeat="c in cases" ng-class="caseClass(c.id)" ng-click="editCase($event, c.id)">
            
            <div class="card-item">

              @{{c.name}}

              <!-- <md-menu>
                <i class="fa fa-gear" ng-click="openMenu($mdOpenMenu, $event)" class="options-menu" style="float: right;"></i>
                <md-menu-content width="4">
                  <md-menu-item>
                    <md-button ng-click="editCase($event, c.id)">
                      <i class="fa fa-edit"></i> &nbsp;
                      {{___( "Edit" )}}
                    </md-button>
                  </md-menu-item>
                  <md-menu-item>
                    <md-button ng-click="deleteCase(c.id)">
                      <i class="fa fa-trash"></i> &nbsp;
                      {{___( "Delete" )}}
                    </md-button>
                  </md-menu-item>
                  <md-menu-item>
                    <md-button ng-click="copyCase(c.id)">
                      <i class="fa fa-copy"></i> &nbsp;
                      {{___( "Copy" )}}
                    </md-button>
                  </md-menu-item>
                  
                </md-menu-content>
              </md-menu> -->

            </div>

          </div>

        </div>

        <!-- <div ng-show="!activesuite() && hassuites()">{{___( "Select a test suite from the left, then select a scenario." )}}</div>
        <div ng-show="activesuite() && hasscenarios() && !activescenario()">{{___( "Select a scenario from the left." )}}</div>
        <div ng-show="activesuite() && hasscenarios() && !hascases()">{{___( "No cases on this scenario yet." )}}</di> -->

      </div>

    </div>

  </div>

@stop

@section('javascript')
  <script src="/js/controllers/SuitesCtrl.js"></script>
@stop

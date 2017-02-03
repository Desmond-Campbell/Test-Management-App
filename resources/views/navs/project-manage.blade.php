        
      <md-content class="white-bg left-side-border" id="nav-left-container">

        <ul class="nav-list hidden-xs">

          <?php if ( !isset( $active ) ) $active = ''; ?>

          @if ( isset( $project_id ) )
          
          <li class="main-entry nav-list-item left-side-border-bottom project-link">
            <a href="/projects/{{$project->id}}/details">{{"<?= $project->title ?>" | shorten : false : 20 : '...' }} &nbsp; <i class="fa fa-pencil"></i></a>
          </li>
          <li class="main-entry nav-list-item @if ( $active == 'dashboard' ) active @endif">
            <a href="/projects/{{$project_id}}/dashboard"><i class="fa fa-home"></i> &nbsp; {{___( "Dashboard" )}}</a>
          </li>
            @if ( $active == 'dashboard' )
            <li role="separator" class="divider"></li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/dashboard">{{___( "Activity Feed" )}}</a>
              </li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/testing">{{___( "Testing Dashboard" )}}</a>
              </li>
            <li role="separator" class="divider"></li>
            @endif
          <li class="main-entry nav-list-item @if ( $active == 'details' ) active @endif">
             <a href="/projects/{{$project_id}}/details"><i class="fa fa-cog"></i> &nbsp; {{___( "Details" )}}</a>
          </li>
          <li class="main-entry nav-list-item @if ( $active == 'requirements' ) active @endif">
             <a  href="/projects/{{$project_id}}/requirements"><i class="fa fa-book"></i> &nbsp; {{___( "Requirements" )}}</a>
          </li>
            @if ( $active == 'requirements' )
            <li role="separator" class="divider"></li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/requirements">{{___( "Manage Requirements" )}}</a>
              </li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/requirements/new">{{___( "Add Requirements" )}}</a>
              </li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/requirements/import">{{___( "Import" )}}</a>
              </li>
            <li role="separator" class="divider"></li>
            @endif
          <li class="main-entry nav-list-item @if ( $active == 'suites' ) active @endif">
            <a href="/projects/{{$project_id}}/suites"><i class="fa fa-tasks"></i> &nbsp; {{___( "Test Suites" )}}</a>
          </li>
            @if ( $active == 'suites' )
            <li role="separator" class="divider"></li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/suites">{{___( "View Cases" )}}</a>
              </li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/suites/new">{{___( "Add Test Cases" )}}</a>
              </li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/suites/import">{{___( "Import Test Cases" )}}</a>
              </li>
            <li role="separator" class="divider"></li>
            @endif
          <li class="main-entry nav-list-item @if ( $active == 'tests' ) active @endif">
            <a href="/projects/{{$project_id}}/tests"><i class="fa fa-tasks"></i> &nbsp; {{___( "Test Runs" )}}</a>
          </li>
          <li class="main-entry nav-list-item @if ( $active == 'team' ) active @endif">
             <a href="/projects/{{$project_id}}/team"><i class="fa fa-group"></i> &nbsp; {{___( "Team Members" )}}</a>
          </li>
            @if ( $active == 'team' )
            <li role="separator" class="divider"></li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/team">{{___( "View Team" )}}</a>
              </li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/team/new-member">{{___( "Add Member" )}}</a>
              </li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/team/roles">{{___( "Manage Roles" )}}</a>
              </li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/team/new-role">{{___( "Add Role" )}}</a>
              </li>
            <li role="separator" class="divider"></li>
            @endif
          @endif
        
        </ul>

        <ul class="nav-list visible-xs">

          <?php if ( !isset( $active ) ) $active = ''; ?>

          @if ( isset( $project_id ) )
          
          <li class="main-entry nav-list-item left-side-border-bottom project-link">
            <a href="/projects/{{$project->id}}/details"><i class="fa fa-pencil"></i></a>
          </li>
          <li class="main-entry nav-list-item @if ( $active == 'dashboard' ) active @endif">
            <a href="/projects/{{$project_id}}/dashboard"><i class="fa fa-home"></i></a>
          </li>
          <li class="main-entry nav-list-item @if ( $active == 'details' ) active @endif">
             <a href="/projects/{{$project_id}}/details"><i class="fa fa-cog"></i></a>
          </li>
          <li class="main-entry nav-list-item @if ( $active == 'requirements' ) active @endif">
             <a  href="/projects/{{$project_id}}/requirements"><i class="fa fa-book"></i></a>
          </li>
            @if ( $active == 'requirements' )
            <li role="separator" class="divider"></li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/requirements">{{___( "Manage Requirements" )}}</a>
              </li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/requirements/new">{{___( "Add Requirements" )}}</a>
              </li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/requirements/import">{{___( "Import" )}}</a>
              </li>
            <li role="separator" class="divider"></li>
            @endif
          <li class="main-entry nav-list-item @if ( $active == 'cases' ) active @endif">
            <a href="/projects/{{$project_id}}/cases"><i class="fa fa-tasks"></i></a>
          </li>
            @if ( $active == 'cases' )
            <li role="separator" class="divider"></li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/cases">{{___( "View Cases" )}}</a>
              </li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/cases/new">{{___( "Add Test Cases" )}}</a>
              </li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/cases/import">{{___( "Import Test Cases" )}}</a>
              </li>
            <li role="separator" class="divider"></li>
            @endif
          <li class="main-entry nav-list-item @if ( $active == 'team' ) active @endif">
             <a href="/projects/{{$project_id}}/team/members"><i class="fa fa-group"></i></a>
          </li>
            @if ( $active == 'team' )
            <li role="separator" class="divider"></li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/team/members">{{___( "View Members" )}}</a>
              </li>
              <li class="nav-submenu-list-item">
                <a href="/projects/{{$project_id}}/tesm/permissions">{{___( "Manage Permissions" )}}</a>
              </li>
            <li role="separator" class="divider"></li>
            @endif
          @endif
        
        </ul>

        &nbsp;
      </md-content>


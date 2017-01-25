    <div flex="20" class="left-nav-menu">

        
      <md-content layout-padding md-whiteframe="1" class="white-bg">
  
        <md-list>

          <md-list-item>
            <md-icon><i class="fa fa-bars icon-float-1"></i></md-icon>
            <p> <a href="/projects">{{__( "All Projects" )}}</a> </p>
          </md-list-item>

        </md-list>

          <!--   <ul class="nav n/av-stacked leading-nav-menu">

          <li><a href="/projects"><i class="fa fa-bars icon-float-1"></i> &nbsp; &nbsp; {{__( "All Projects" )}}</a></li>
        
        </ul> -->

      </md-content>

      <md-content layout-padding md-whiteframe="1" class="white-bg">

      <md-list>

          <?php if ( !isset( $active ) ) $active = ''; ?>

          @if ( !isset( $project_id ) )
          
          <md-list-item>
            <md-icon><i class="fa fa-home icon-float-1"></i></md-icon>
            <p> Project Dashboard </p>
          </md-list-item>
          <md-list-item>
            <md-icon><i class="fa fa-cog icon-float-1"></i></md-icon>
            <p> Project Details </p>
          </md-list-item>
          <md-list-item>
            <md-icon><i class="fa fa-book icon-float-1"></i></md-icon>
            <p> Requirements </p>
          </md-list-item>
          <md-list-item>
            <md-icon><i class="fa fa-code-fork icon-float-1"></i></md-icon>
            <p> Test Cases </p>
          </md-list-item>
          <md-list-item>
            <md-icon><i class="fa fa-user icon-float-1"></i></md-icon>
            <p> Team Members </p>
          </md-list-item>
          @else
          <md-list-item class="@if ( $active == 'dashboard' ) active @endif">
            <md-icon><i class="fa fa-home icon-float-1"></i></md-icon>
            <p> <a href="/projects/{{$project_id}}/dashboard">Project Dashboard</a> </p>
          </md-list-item>
          <md-list-item class="@if ( $active == 'details' ) active @endif">
            <md-icon><i class="fa fa-cog icon-float-1"></i></md-icon>
            <p> <a href="/projects/{{$project_id}}/details">Project Details</a> </p>
          </md-list-item>
          <md-list-item class="@if ( $active == 'requirements' ) active @endif">
            <md-icon><i class="fa fa-book icon-float-1"></i></md-icon>
            <p> <a  href="/projects/{{$project_id}}/requirements">Requirements</a> </p>
          </md-list-item>
            @if ( $active == 'requirements' )
              <md-menu-divider></md-menu-divider>
                <md-list-item>
                  <md-icon></md-icon>
                  <p><a href="/projects/{{$project_id}}/requirements">Manage Requirements</a></p>
                </md-list-item>
                <md-list-item>
                  <md-icon></md-icon>
                  <p><a href="/projects/{{$project_id}}/requirements/new">Add Requirements</a></p>
                </md-list-item>
                <md-list-item>
                  <md-icon></md-icon>
                  <p><a href="/projects/{{$project_id}}/requirements/import">Import</a></p>
                </md-list-item>
              <md-menu-divider></md-menu-divider>
            @endif
          <md-list-item class="@if ( $active == 'cases' ) active @endif">
            <md-icon><i class="fa fa-code-fork icon-float-1"></i></md-icon>
            <p> <a href="/projects/{{$project_id}}/cases">Test Cases</a> </p>
          </md-list-item>
            @if ( $active == 'cases' )
              <md-menu-divider></md-menu-divider>
                <md-list-item>
                  <md-icon></md-icon>
                  <p><a href="/projects/{{$project_id}}/cases">View Cases</a></p>
                </md-list-item>
                <md-list-item>
                  <md-icon></md-icon>
                  <p><a href="/projects/{{$project_id}}/cases/new">Add Test Cases</a></p>
                </md-list-item>
                <md-list-item>
                  <md-icon></md-icon>
                  <p><a href="/projects/{{$project_id}}/cases/import">Import Test Cases</a></p>
                </md-list-item>
              <md-menu-divider></md-menu-divider>
            @endif
          <md-list-item class="@if ( $active == 'team' ) active @endif">
            <md-icon><i class="fa fa-user icon-float-1"></i></md-icon>
            <p> <a href="/projects/{{$project_id}}/team/members">Team Members</a></p>
          </md-list-item>
            @if ( $active == 'team' )
              <md-menu-divider></md-menu-divider>
                <md-list-item>
                  <md-icon></md-icon>
                  <p><a href="/projects/{{$project_id}}/team/members">View Members</a></p>
                </md-list-item>
                <md-list-item>
                  <md-icon></md-icon>
                  <p><a href="/projects/{{$project_id}}/tesm/permissions">Manage Permissions</a></p>
                </md-list-item>
            @endif
          @endif
        
        </md-list>

        &nbsp;
      </md-content>


    </div>


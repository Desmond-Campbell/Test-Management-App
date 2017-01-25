    <div class="col-lg-2 left-nav-menu">

      <ul class="nav nav-stacked leading-nav-menu">

        <li><a href="/projects"><i class="fa fa-bars icon-float-1"></i> &nbsp; &nbsp; {{__( "All Projects" )}}</a></li>
      
      </ul>

      <ul class="nav nav-stacked">

      <?php if ( !isset( $active ) ) $active = ''; ?>

        @if ( !isset( $project_id ) )
        <li class="disabled"><a><i class="fa fa-home icon-float-1"></i> &nbsp; &nbsp; Project Dashboard</a></li>
        <li class="disabled"><a><i class="fa fa-cog icon-float-1"></i> &nbsp; &nbsp; Project Details</a></li>
        <li class="disabled"><a><i class="fa fa-book icon-float-1"></i> &nbsp; &nbsp; Requirements</a></li>
        <li class="disabled"><a><i class="fa fa-code-fork icon-float-1"></i> &nbsp; &nbsp; Test Cases</a></li>
        <li class="disabled"><a><i class="fa fa-user icon-float-1"></i> &nbsp; &nbsp; Team Members</a></li>
        @else
        <li class="@if ( $active == 'dashboard' ) active @endif"><a href="/projects/{{$project_id}}/dashboard"><i class="fa fa-home icon-float-1"></i> &nbsp; &nbsp; Project Dashboard</a></li>
        <li class="@if ( $active == 'details' ) active @endif"><a href="/projects/{{$project_id}}/details"><i class="fa fa-cog icon-float-1"></i> &nbsp; &nbsp; Project Details</a></li>
        <li class="@if ( $active == 'requirements' ) active @endif"><a href="/projects/{{$project_id}}/requirements/manage"><i class="fa fa-book icon-float-1"></i> &nbsp; &nbsp; Requirements</a>
          @if ( $active == 'requirements' )
            <ul class="submenu">
              <li><a href="/projects/{{$project_id}}/requirements/manage">Manage Requirements</a>
              <li><a href="/projects/{{$project_id}}/requirements/import">Import</a>
            </ul>
          @endif
        </li>
        <li class="@if ( $active == 'cases' ) active @endif"><a href="/projects/{{$project_id}}/cases"><i class="fa fa-code-fork icon-float-1"></i> &nbsp; &nbsp; Test Cases</a>
          @if ( $active == 'cases' )
            <ul class="submenu">
              <li><a href="/projects/{{$project_id}}/cases">View Cases</a>
              <li><a href="/projects/{{$project_id}}/cases/new">Add Test Cases</a>
              <li><a href="/projects/{{$project_id}}/cases/import">Import Test Cases</a>
            </ul>
          @endif
        </li>
        <li class="@if ( $active == 'team' ) active @endif"><a href="/projects/{{$project_id}}/team/members"><i class="fa fa-user icon-float-1"></i> &nbsp; &nbsp; Team Members</a>
          @if ( $active == 'team' )
            <ul class="submenu">
              <li><a href="/projects/{{$project_id}}/team/members">View Members</a>
              <li><a href="/projects/{{$project_id}}/tesm/permissions">Manage Permissions</a>
            </ul>
          @endif
        </li>
        @endif
      </ul>

      &nbsp;

    </div>
    <div flex="20" class="left-nav-menu">

        
      <md-content layout-padding md-whiteframe="1">
  
          <ul class="nav n/av-stacked leading-nav-menu">

          <li><a href="/projects"><i class="fa fa-bars icon-float-1"></i> &nbsp; &nbsp; {{__( "All Projects" )}}</a></li>
        
        </ul>

      </md-content>

      <md-content layout-padding md-whiteframe="1">


        
        <ul class="nav nav-stacked">

          <?php if ( !isset( $active ) ) $active = ''; ?>

          @if ( !isset( $project_id ) )
          <li role="presentation" class="disabled"><a><i class="fa fa-home icon-float-1"></i> &nbsp; &nbsp; Project Dashboard</a></li>
          <li role="presentation" class="disabled"><a><i class="fa fa-cog icon-float-1"></i> &nbsp; &nbsp; Project Details</a></li>
          <li role="presentation" class="disabled"><a><i class="fa fa-book icon-float-1"></i> &nbsp; &nbsp; Requirements</a></li>
          <li role="presentation" class="disabled"><a><i class="fa fa-code-fork icon-float-1"></i> &nbsp; &nbsp; Test Cases</a></li>
          <li role="presentation" class="disabled"><a><i class="fa fa-user icon-float-1"></i> &nbsp; &nbsp; Team Members</a></li>
          @else
          <li role="presentation" class="@if ( $active == 'dashboard' ) active @endif"><a href="/projects/{{$project_id}}/dashboard"><i class="fa fa-home icon-float-1"></i> &nbsp; &nbsp; Project Dashboard</a></li>
          <li role="presentation" class="@if ( $active == 'details' ) active @endif"><a href="/projects/{{$project_id}}/details"><i class="fa fa-cog icon-float-1"></i> &nbsp; &nbsp; Project Details</a></li>
          <li role="presentation" class="@if ( $active == 'requirements' ) active @endif"><a href="/projects/{{$project_id}}/requirements"> <i class="fa fa-book icon-float-1"></i> &nbsp; &nbsp; Requirements</a></li>
            @if ( $active == 'requirements' )
              <li role="separator" class="divider"></li>
                <li role="presentation"><a href="/projects/{{$project_id}}/requirements">Manage Requirements</a>
                <li role="presentation"><a href="/projects/{{$project_id}}/requirements/new">Add Requirements</a>
                <li role="presentation"><a href="/projects/{{$project_id}}/requirements/import">Import</a>
              <li role="separator" class="divider"></li>
            @endif
          </li>
          <li role="presentation" class="@if ( $active == 'cases' ) active @endif"><a href="/projects/{{$project_id}}/cases"><i class="fa fa-code-fork icon-float-1"></i> &nbsp; &nbsp; Test Cases</a>
            @if ( $active == 'cases' )
              <li role="separator" class="divider"></li>
                <li role="presentation"><a href="/projects/{{$project_id}}/cases">View Cases</a>
                <li role="presentation"><a href="/projects/{{$project_id}}/cases/new">Add Test Cases</a>
                <li role="presentation"><a href="/projects/{{$project_id}}/cases/import">Import Test Cases</a>
              <li role="separator" class="divider"></li>
            @endif
          </li>
          <li role="presentation" class="@if ( $active == 'team' ) active @endif"><a href="/projects/{{$project_id}}/team/members"><i class="fa fa-user icon-float-1"></i> &nbsp; &nbsp; Team Members</a>
            @if ( $active == 'team' )
              <li role="separator" class="divider"></li>
                <li role="presentation"><a href="/projects/{{$project_id}}/team/members">View Members</a>
                <li role="presentation"><a href="/projects/{{$project_id}}/tesm/permissions">Manage Permissions</a>
              <li role="separator" class="divider"></li>
            @endif
          </li>
          @endif
        </ul>

        &nbsp;
      </md-content>


    </div>


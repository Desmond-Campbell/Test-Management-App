<?php

$menuitems = [ 
								'details' 	=> 'Details',
								'problem' 	=> 'Problem',
								'swot' 			=> 'SWOT',
								'operations'=> 'Operations',
								'budget'		=> 'Budget',
								'financials'=> 'Financials',
								'markets'		=> 'Markets',
								'model'			=> 'Business Model',
								'resources'	=> 'Resources',
								'tasks'			=> 'Tasks',
								'team'			=> 'Team',
								'scoring'		=> 'Scoring'
							];

?>

<ul class="nav nav-pills">
	@foreach ( $menuitems as $k => $v )
		<li role="presentation" class="@if ( $active == $k ) 'active' @endif"><a href="/projects/{{$project_id}}/{{$k}}">{{$v}}</a></li>
	@endforeach
</ul>
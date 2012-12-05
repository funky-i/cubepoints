<?php
if ( ! function_exists( 'add_action' ) )
	die();
?>

<div class="wrap">
	<div id="icon-plugins" class="icon32"></div>
	<h2>
		<?php _e('CubePoints', 'cubepoints'); ?> <?php _e('Modules', 'cubepoints'); ?>
		<a href="http://cubepoints.com/forums/forum/modules-releases/?utm_source=plugin&utm_medium=more_modules&utm_campaign=cubepoints" class="add-new-h2"><?php _e('Get More Modules', 'cubepoints'); ?></a>
	</h2>

	<?php if( $_GET['activate'] == 'true' ) : ?>
		<div id="message" class="updated"><p><?php _e( 'Module', 'cubepoints' ); ?> <strong><?php _e( 'activated', 'cubepoints' ); ?></strong>.</p></div>
	<?php elseif( $_GET['deactivate'] == 'true' ) : ?>
		<div id="message" class="updated"><p><?php _e( 'Module', 'cubepoints' ); ?> <strong><?php _e( 'deactivated', 'cubepoints' ); ?></strong>.</p></div>
	<?php endif; ?>

	<?php
		$currUri = $_SERVER[REQUEST_URI];
		$currUri = remove_query_arg( '_wpnonce', $currUri );
		$currUri = remove_query_arg( 'action', $currUri );
		$currUri = remove_query_arg( 'module', $currUri );
		$currUri = remove_query_arg( 'activate', $currUri );
		$currUri = remove_query_arg( 'deactivate', $currUri );
		$modules = $this->availableModules();
		$activeModules = array();
		$inactiveModules = array();
		foreach( $modules as $module ) {
			if( $this->moduleActivated( $module ) ) {
				$activeModules[] = $module;
			} else {
				$inactiveModules[] = $module;
			}
		}
		$moduleStatus = $_GET['module_status'];
		if( empty($moduleStatus) || ($moduleStatus == 'active' && count($activeModules) == 0) || ($moduleStatus == 'inactive' && count($inactiveModules) == 0) ) {
			$moduleStatus = 'all';
		}
		if( $moduleStatus == 'active' ) {
			$modulesToDisplay = $activeModules;
		} else if( $moduleStatus == 'inactive' ) {
			$modulesToDisplay = $inactiveModules;
		} else {
			$modulesToDisplay = $modules;
		}
		
	?>

	<?php if( count($modules) > 0 ) : ?>
		<ul class="subsubsub">
			<li class="all"><a href="<?php echo add_query_arg('module_status', 'all', $currUri); ?>"<?php echo ($moduleStatus == 'all') ? ' class="current"' : ''; ?>><?php _e('All', 'cubepoints'); ?> <span class="count">(<?php echo count($modules); ?>)</span></a></li>
			<?php if( count($activeModules) > 0 ) : ?>
				<li class="active">| <a href="<?php echo add_query_arg('module_status', 'active', $currUri); ?>"<?php echo ($moduleStatus == 'active') ? ' class="current"' : ''; ?>><?php _e('Active', 'cubepoints'); ?> <span class="count">(<?php echo count($activeModules); ?>)</span></a></li>
			<?php endif; ?>
			<?php if( count($inactiveModules) > 0 ) : ?>
			<li class="inactive">| <a href="<?php echo add_query_arg('module_status', 'inactive', $currUri); ?>"<?php echo ($moduleStatus == 'inactive') ? ' class="current"' : ''; ?>><?php _e('Inactive', 'cubepoints'); ?> <span class="count">(<?php echo count($inactiveModules); ?>)</span></a></li>
			<?php endif; ?>
		</ul>
	<?php endif; ?>

	<table class="wp-list-table widefat plugins" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" id="name"><?php _e('Module', 'cubepoints'); ?></th>
				<th scope="col" id="description"><?php _e('Description', 'cubepoints'); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col" id="name"><?php _e('Module', 'cubepoints'); ?></th>
				<th scope="col" id="description"><?php _e('Description', 'cubepoints'); ?></th>
			</tr>
		</tfoot>
		<tbody>
			<?php if( count($modulesToDisplay) == 0 ) : ?>
				<tr class="no-items"><td class="colspanchange" colspan="2"><?php _e('You do not appear to have any modules available at this time.', 'cubepoints'); ?></td></tr>
			<?php else : ?>

				<?php
					$modulesToDisplayDetails = array();
					$modulesToDisplayNames = array();
					foreach ( $modulesToDisplay as $module ) {
						$moduleDetails = $this->moduleDetails( $module );
						$modulesToDisplayDetails[ $module ] = $moduleDetails;
						$modulesToDisplayNames[] = $moduleDetails['name'];
					}
					array_multisort($modulesToDisplayNames, $modulesToDisplayDetails);
				?>

				<?php foreach ( $modulesToDisplayDetails as $module => $moduleDetails ) : ?>
				<?php
					$moduleActivated = $this->moduleActivated( $module );
				?>
					<tr id="<?php echo $module; ?>" class="<?php echo $moduleActivated ? 'active' : 'inactive'; ?>">
						<td class="plugin-title">
							<strong><?php echo $moduleDetails['name']; ?></strong>
							<div class="row-actions-visible">
								<?php if( ! $moduleActivated ) : ?>
									<span class="activate"><a href="<?php echo wp_nonce_url( add_query_arg( array( 'action' => 'activate_module', 'module' => $module ) ), 'activate_module_' . $module ); ?>" title="<?php _e('Activate this module', 'cubepoints'); ?>" class="edit"><?php _e('Activate', 'cubepoints'); ?></a></span>
								<?php else : ?>
									<span class="deactivate"><a href="<?php echo wp_nonce_url( add_query_arg( array( 'action' => 'deactivate_module', 'module' => $module ) ), 'deactivate_module_' . $module ); ?>" title="<?php _e('Deactivate this module', 'cubepoints'); ?>" class="edit"><?php _e('Deactivate', 'cubepoints'); ?></a></span>
								<?php endif; ?>
							</div>
						</td>
						<td class="column-description">
							<div class="plugin-description"><p><?php echo $moduleDetails['description']; ?></p></div>
							<div class="second plugin-version-author-uri">
								<?php _e('Version', 'cubepoints'); ?> <?php echo $moduleDetails['version']; ?> |
								<?php if( ! empty ( $moduleDetails['author_uri'] ) ) : ?>
									<?php _e('By', 'cubepoints'); ?> <a href="<?php echo $moduleDetails['author_uri']; ?>" title="<?php _e('Visit author homepage', 'cubepoints'); ?>"><?php echo $moduleDetails['author_name']; ?></a>
								<?php else : ?>
									<?php _e('By', 'cubepoints'); ?> <?php echo $moduleDetails['author_name']; ?>
								<?php endif; ?>
								<?php if( ! empty ( $moduleDetails['module_uri'] ) ) : ?>
									| <a href="<?php echo $moduleDetails['module_uri']; ?>" title="<?php _e('Visit module site', 'cubepoints'); ?>">Visit module site</a>
								<?php endif; ?>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>
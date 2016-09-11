<?php
/**
 * XS-Rowstyles
 *
 * @author Roland Dietz
 * @package xs-rowstyles
 * @subpackage Customizations
 */

namespace XitesolutionBB;

// get the helperfunctions
require_once( 'helperfunctions.php' );

add_filter( 'fl_builder_render_css', __NAMESPACE__ .'\add_row_style_css', 10, 3 ); // add callback that runs when rendering css. it loops through the rows and adds row dependant css

$global_settings = \FLBuilderModel::get_global_settings();

// get the default settings
$row_settings = \FLBuilderModel::$settings_forms[ 'row' ];

$new_bg_option = array(
	'ani-gradient'	=> _x( 'Animated Gradient', 'Background type.', 'bb-xs-rowstyles' ),
);

$new_bg_toggle_option = array(
	'ani-gradient' => array(
		'sections'   => array( 'bg_ani_gradient' ),
	),
);

$new_bg_section = array(
	'bg_ani_gradient' => array(
		'title'         => __( 'Animated Gradient' , 'bb-xs-rowstyles' ),
		'fields'        => array(
			'ani_gradient_type' 	=> array(
				'type'          => 'select',
				'label'         => __( 'Gradient Direction', 'bb-xs-rowstyles' ),
				'default'       => '90',
				'options'       => array(
					'90'          => __( 'Horizontal', 'bb-xs-rowstyles' ),
					'180'         => __( 'Vertical', 'bb-xs-rowstyles' ),
					'135'         => __( 'Diagonal Down', 'bb-xs-rowstyles' ),
					'45'          => __( 'Diagonal Up', 'bb-xs-rowstyles' ),
				),
			),
			'ani_colors'        => array(
				'type'          => 'color',
				'label'         => __('Animation Color', 'bb-xs-rowstyles'),
				'default'       => 'ff0000',
				'preview'       => array(
					'type'          => 'css',
					'selector'      => 'fl-row-bg-ani-gradient',
					'property'      => 'color'
				),
				'multiple'      => true // Doesn't work with editor or photo fields
			),
			'ani_duration' => array(
				'type'          => 'text',
				'label'         => __( 'Animation Duration', 'bb-xs-rowstyles' ),
				'default'       => '5',
				'maxlength'     => '5',
				'size'          => '6',
				'placeholder'   => __( 'Duration', 'bb-xs-rowstyles' ),
				'class'         => 'my-css-class',
				'description'   => __( 'Duration (seconds)', 'bb-xs-rowstyles' ),
				'help'          => __( 'Enter a Duration', 'bb-xs-rowstyles' ),
			),
			'ani_timing' 	=> array(
				'type'          => 'select',
				'label'         => __( 'Transition Timing', 'bb-xs-rowstyles' ),
				'default'       => 'ease',
				'options'       => array(
					'linear'      => __( 'Linear', 'bb-xs-rowstyles' ),
					'ease'        => __( 'Ease', 'bb-xs-rowstyles' ),
					'ease-in'     => __( 'Ease in', 'bb-xs-rowstyles' ),
					'ease-out'    => __( 'Ease out', 'bb-xs-rowstyles' ),
					'ease-in-out' => __( 'Ease In-Out', 'bb-xs-rowstyles' ),
				)
			)
		)
	)
);

// get the current number of options and sections
$current_num_options = count($row_settings['tabs']['style']['sections']['background']['fields']['bg_type']['options']);
$current_num_sections = count($row_settings['tabs']['style']['sections']);

$xsoptions = $row_settings['tabs']['style']['sections']['background']['fields']['bg_type']['options'];
$xstoggle = $row_settings['tabs']['style']['sections']['background']['fields']['bg_type']['toggle'];
$xssections = $row_settings['tabs']['style']['sections'];

if( function_exists( 'xdebug_break' ) ) { xdebug_break(); }

// insert the option to the selectbox as the last item
\XitesolutionBB\array_insert( $row_settings['tabs']['style']['sections']['background']['fields']['bg_type']['options'], $new_bg_option, 'ani-gradient', $current_num_options );

$xsoptions = $row_settings['tabs']['style']['sections']['background']['fields']['bg_type']['options'];


// insert the toggle settings to the option bg_type
\XitesolutionBB\array_insert( $row_settings['tabs']['style']['sections']['background']['fields']['bg_type']['toggle'], $new_bg_toggle_option, 'ani-gradient', $current_num_options );

$xstoggle = $row_settings['tabs']['style']['sections']['background']['fields']['bg_type']['toggle'];


// insert the section at the correct location (last)
// \XitesolutionBB\array_insert( $row_settings['tabs']['style']['sections'], $new_bg_section, 'bg_ani_gradient', $current_num_sections - 1 );
\XitesolutionBB\array_insert( $row_settings['tabs']['style']['sections'], $new_bg_section, 'bg_color' );

$xssections = $row_settings['tabs']['style']['sections'];


// re-register the row form
\FLBuilder::register_settings_form( 'row' , $row_settings );


/**
 * Filter callback that loops through $nodes[rows] and returns css needed for the inline css
 * @param string $css
 * @param object $nodes
 * @param array $global_settings
 * @since 0.1
 * @return string $css
 */
function add_row_style_css ( $css , $nodes , $global_settings ) {

	// Loop through rows
	foreach( $nodes['rows'] as $row ) {
// echo count( $row->settings->ani_colors );
// die();
		// if we need to set the bg_animation
		if ( $row->settings->bg_type == 'ani-gradient' && 1 < count( $row->settings->ani_colors ) ) {

			$bg_size = count( $row->settings->ani_colors ) * 200;

			if( ! is_numeric( $row->settings->ani_duration ) || 0 == $row->settings->ani_duration ) {
				$row->settings->ani_duration = (int) $row->settings->ani_duration = 10;
			}

			$keyframes = '';

			switch ( $row->settings->ani_gradient_type ) {
				case '90':
					$keyframes .= '0%{background-position:0% 50%}' . PHP_EOL;
					$keyframes .= '50%{background-position:100% 50%}' . PHP_EOL;
					$keyframes .= '100%{background-position:0% 50%}' . PHP_EOL;
					break;
				case '180':
					$keyframes .= '0%{background-position:50% 0%}' . PHP_EOL;
					$keyframes .= '50%{background-position:50% 100%}' . PHP_EOL;
					$keyframes .= '100%{background-position:50% 0%}' . PHP_EOL;
					break;
				case '135':
					$keyframes .= '0%{background-position:0% 0%}' . PHP_EOL;
					$keyframes .= '50%{background-position:100% 100%}' . PHP_EOL;
					$keyframes .= '100%{background-position:0% 0%}' . PHP_EOL;
					break;
				case '45':
					$keyframes .= '0%{background-position:100% 0%}' . PHP_EOL;
					$keyframes .= '50%{background-position:0% 100%}' . PHP_EOL;
					$keyframes .= '100%{background-position:100% 0%}' . PHP_EOL;
					break;
			}

			$css .= PHP_EOL . PHP_EOL;
			$css .= '@-webkit-keyframes AniGradient-' . $row->node . ' {' . PHP_EOL;
			$css .= $keyframes;
			$css .= '}' . PHP_EOL;

			$css .= '@-moz-keyframes AniGradient-' . $row->node . ' {' . PHP_EOL;
			$css .= $keyframes;
			$css .= '}' . PHP_EOL;

			$css .= '@-o-keyframes AniGradient-' . $row->node . ' {' . PHP_EOL;
			$css .= $keyframes;
			$css .= '}' . PHP_EOL;

			$css .= '@keyframes AniGradient-' . $row->node . ' {' . PHP_EOL;
			$css .= $keyframes;
			$css .= '}' . PHP_EOL;

			$css .= '.fl-node-' . $row->node . '.fl-row-bg-ani-gradient .fl-row-content-wrap {' . PHP_EOL;

			$css .= 'background: linear-gradient(' . $row->settings->ani_gradient_type . 'deg, #' . implode ( ', #', $row->settings->ani_colors ) . ');' . PHP_EOL;
			$css .= 'background-size: ' . $bg_size . '% ' . $bg_size . '%;' . PHP_EOL;
			$css .= '-webkit-animation: AniGradient-' . $row->node . ' ' . $row->settings->ani_duration . 's ease infinite;' . PHP_EOL;
			$css .= '-moz-animation: AniGradient-' . $row->node . ' ' . $row->settings->ani_duration . 's ease infinite;' . PHP_EOL;
				$css .= '-o-animation: AniGradient-' . $row->node . ' ' . $row->settings->ani_duration . 's ease infinite;' . PHP_EOL;
			$css .= 'animation: AniGradient-' . $row->node . ' ' . $row->settings->ani_duration . 's ease infinite;' . PHP_EOL;
			$css .= '}' . PHP_EOL;

		}
	}

	return $css;
}

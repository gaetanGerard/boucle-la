<?php
/**
 * bo-theme Theme Customizer
 *
 * @package bo-theme
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function bo_theme_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	//
	// Section pour enregistrer les options de personnalisation de couleur
	// DEBUT
	$wp_customize->add_setting( 'nav_link_color', array(
		'default'           => '#0073aa',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nav_link_color', array(
		'label'    => __( 'Couleur des liens de navigation', 'bo-theme' ),
		'section'  => 'colors',
		'settings' => 'nav_link_color',
	) ) );

	$wp_customize->add_setting( 'nav_link_hover_color', array(
		'default'           => '#005177',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nav_link_hover_color', array(
		'label'    => __( 'Couleur des liens de navigation au survol', 'bo-theme' ),
		'section'  => 'colors',
		'settings' => 'nav_link_hover_color',
	) ) );
	//
	// Section pour enregistrer les options de personnalisation de couleur
	// FIN


	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'bo_theme_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'bo_theme_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', 'bo_theme_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function bo_theme_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function bo_theme_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function bo_theme_customize_preview_js() {
	wp_enqueue_script( 'bo-theme-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'bo_theme_customize_preview_js' );

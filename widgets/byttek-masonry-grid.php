<?php
namespace Byttek_MasonryGrid\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Byttek_Masonry_Grid extends Widget_Base {
	public function get_name() {
		return 'byttek-masonry-grid';
	}
	
	public function get_title() {
		return __( 'Byttek Masonry Grid', 'byttek-masonry-grid-builder' );
	}
	
	public function get_icon() {
		return 'eicon-posts-ticker';
	}
	
	public function get_categories() {
		return [ 'basic' ];
	}
	
	public function get_style_depends() {
		return [ 'bmgb-style' ];
	}
	
	public function get_script_depends() {
		return [ 'bmgb-script' ];
	}
	
	protected function register_controls() {
		// Section: Content Start.
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'byttek-masonry-grid-builder' ),
			]
		);
			$this->add_control(
				'post_type',
				[
					'label'	=> __( 'Post Type', 'byttek-masonry-grid-builder' ),
					'type'	=> Controls_Manager::TEXT,
				]
			);

			$this->add_control(
				'category',
				[
					'label'	=> __( 'Category', 'byttek-masonry-grid-builder' ),
					'type'	=> Controls_Manager::TEXT,
				]
			);
		$this->end_controls_section();
		// Section: Content End.

		// Section: Style Start.
		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Typography', 'byttek-masonry-grid-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'filter_color',
				[
					'label'     => __( 'Color', 'byttek-masonry-grid-builder' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#333333',
					'selectors' => [
						'{{WRAPPER}} .bmgb_filters > li' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'filter_font',
					'label'    => __( 'Typography', 'byttek-masonry-grid-builder' ),
					'selector' => '{{WRAPPER}} .bmgb_filters > li',
				]
			);
		$this->end_controls_section();
		// Section: Content End.
	}
	
	protected function render() {
		$settings = $this->get_settings_for_display();

		/*
		

		
		
		// The Loop
		 
			
				
				?>
					<div class="portfolio-item">
						<h2><?php the_title(); ?></h2>
					</div>
				<?php
				 */ ?>

			<div class="bmgb_wrapper">
				<?php if ( !empty($settings['category']) ) { ?>
					<ul class="bmgb_filters">
						<li data-filter="*">All</li>
						<?php
							$terms = get_terms(array(
								'taxonomy'   => $settings['category'],
								'post_type'  => $settings['post_type'],
								'hide_empty' => true,
							));

							if (!is_wp_error($terms) && !empty($terms)) {
								foreach ($terms as $term) {
									echo '<li data-filter=".bmgb_filter--'. esc_attr($term->slug) .'">'. esc_html($term->name) .'</li>';
								}
							}
						?>
					</ul>
				<?php } ?>

				<div class="bmgb_items">
					<?php
						// Custom Post Query
						$args = array(
							'post_type'      => $settings['post_type'],
							'posts_per_page' => -1,
							'orderby'        => 'date',
							'order'          => 'DESC',
						);

						$portfolio_query = new \WP_Query($args);

						if ($portfolio_query->have_posts()) :
							while ($portfolio_query->have_posts()) :
								$portfolio_query->the_post();

								$cat_slug = '';
								if (!empty($settings['category'])) {
									$current_cat = get_the_terms(get_the_ID(), $settings['category']);
									$cat_slug = $current_cat[0]->slug;
								}
								?>
									<div class="bmgb_item bmgb_filter--<?php echo esc_attr( $cat_slug ); ?>">
										<?php
											if ( has_post_thumbnail() ) {
												the_post_thumbnail('large');
											}
										?>
										<h3><?php the_title(); ?></h3>

										<a href="<?php the_permalink(); ?>"></a>
									</div>
								<?php
							endwhile;
							
							wp_reset_postdata();
						else : ?>
							<p><?php esc_html_e('No portfolio items found.', 'byttek-masonry-grid-builder'); ?></p>
					<?php
						endif;
					?>
				</div>
			</div>
		<?php
	}
}

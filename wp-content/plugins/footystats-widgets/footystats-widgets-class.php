<?php 
/**
 * Adds Standing widget.
 */
class footystats_StandingsWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'standings_widget', // Base ID
			esc_html__( 'FootyStats: League Table', 'footystats_domain' ), // Name
			array( 'description' => esc_html__( 'Live League Tables', 'footystats_domain' ), ) // Args
		);
  }
  
  public function standing_html($id, $links=1){
    $url = plugin_dir_url( __FILE__ ).'js/main.js';
    if($links == 1){$links = 'true';}else{$links = 'false';}
    $content = "<div id='fs-standings'></div>
    <script>
        (function (w,d,s,o,f,js,fjs) {
            w['fsStandingsEmbed']=o;w[o] = w[o] || function () { (w[o].q = w[o].q || []).push(arguments) };
            js = d.createElement(s), fjs = d.getElementsByTagName(s)[0];
            js.id = o; js.src = f; js.async = 1; fjs.parentNode.insertBefore(js, fjs);
        }(window, document, 'script', 'mw', '{$url}'));
        mw('params', { leagueID: {$id}, showLinks: {$links}});
    </script>";
  return $content;
  }

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['selected_league_id'] ) ) {
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
      echo $this->standing_html($instance['selected_league_id'], $instance['show_links']);
    }
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

    $leagues = wp_remote_get('https://footystats.org/e/active-leagues');
    $leagues = wp_remote_retrieve_body( $leagues );
    $leagues = json_decode($leagues, true);

    $options = "";
    $country = "";
    foreach($leagues as $l){
      if($country != $l['country'] || $country == ""){
        $options .= "<option disabled>{$l['country']}</option>";
        $country = $l['country'];
      }
      $options .= "<option value='{$l['id']}'>&nbsp;&nbsp;&nbsp;{$l['name']}</option>";
    }

    $last_edited = !empty($instance['last_edited']) ? $instance['last_edited'] : "update";

    $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Widget Title', 'footystats_domain' );

    $league_id = ! empty( $instance['selected_league_id'] ) ? $instance['selected_league_id'] : esc_html__( '2012', 'footystats_domain' );

    if($last_edited == null || $last_edited == "" || $last_edited == "update"){
      $instance['show_links'] = 1;
    }

    // if(!isset($instance['selected_league_name'])){$instance['selected_league_name'] = "";}
    // $league_name = htmlentities($instance['selected_league_name'], null, 'utf-8');
    // $league_name = str_replace("&nbsp;", "", $league_name);
    // $league_name = html_entity_decode($league_name);

    ?>
    <div class='fs_form_wrapper'>
		<p>

    <!-- Widget Title -->

    <label style="display:block;" for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'footystats_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

    <!-- Widget Table -->

		<label style="display:block;" for="country">Find League ID</label> 
    <select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'selected_league_id' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'selected_league_id' ) ); ?>" data-uid='fs_league_standings'>
    <?php if(! empty ($instance['selected_league_id'])): ?>
      <option disabled>Selected</option>
      <option selected value="<?php echo $instance['selected_league_id']; ?>"><?php echo $league_id ?></option>
    <?php endif;?>
    <?= $options ?>
    </select>

    <input type="hidden" value='<?php echo esc_attr( $this->get_field_id( 'selected_league_id' ) ); ?>' id='get_selected_league_id'>

    <!-- Show links? -->
    <p>
      <label for="<?php echo $this->get_field_id( 'show_links' ); ?>">Include Links to FootyStats?</label>
      <input class="checkbox" type="checkbox" <?php checked( $instance[ 'show_links' ], 1); ?> id="<?php echo $this->get_field_id( 'show_links' ); ?>" name="<?php echo $this->get_field_name( 'show_links' ); ?>" /> 
    </p>

    </p>

    </div>

		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
    $instance = array();

    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
    
    $instance['selected_league_id'] = ( ! empty( $new_instance['selected_league_id'] ) ) ? sanitize_text_field( $new_instance['selected_league_id'] ) : '';

    $instance['show_links'] = isset($new_instance['show_links']) ? 1 : 0;
		$instance['last_edited'] = ( ! empty( $new_instance['last_edited'] ) ) ? time() : time();

		return $instance;
	}

} // Standing Widget Class

class footystats_NextFixtureWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'next_fixture_widget', // Base ID
			esc_html__( 'FootyStats: Next Fixture', 'footystats_domain' ), // Name
			array( 'description' => esc_html__( 'Next Fixture Widget', 'footystats_domain' ), ) // Args
		);
  }
  
  public function next_fixture($id, $links=1){
    $tz = get_option('timezone_string');
    $url = plugin_dir_url( __FILE__ ).'js/next_fixture.js';
    if($links == 1){$links = 'true';}else{$links = 'false';}
    $content = "<div id='fs-upcoming'></div> <script> (function (w,d,s,o,f,js,fjs) { w['fsUpcomingEmbed']=o;w[o] = w[o] || function () { (w[o].q = w[o].q || []).push(arguments) }; js = d.createElement(s), fjs = d.getElementsByTagName(s)[0]; js.id = o; js.src = f; js.async = 1; fjs.parentNode.insertBefore(js, fjs); }(window, document, 'script', 'fsUpcoming', '{$url}')); fsUpcoming('params', { teamID: {$id}, showLinks: {$links}, tz:'{$tz}' }); </script>";
  return $content;
  }

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['selected_club_id'] ) ) {
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
      echo $this->next_fixture($instance['selected_club_id'], $instance['show_links']);
    }
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

    $leagues = wp_remote_get('https://footystats.org/e/active-leagues');
    $leagues = wp_remote_retrieve_body( $leagues );
    $leagues = json_decode($leagues, true);

    $options = "";
    $country = "";
    foreach($leagues as $l){
      if($country != $l['country'] || $country == ""){
        $options .= "<option disabled>{$l['country']}</option>";
        $country = $l['country'];
      }
      $options .= "<option value='{$l['id']}'>&nbsp;&nbsp;&nbsp;&nbsp;{$l['name']}</option>";
    }

    $last_edited = !empty($instance['last_edited']) ? $instance['last_edited'] : "update";

    // $league_name = ! empty( $instance['selected_league_name'] ) ? $instance['selected_league_name'] : esc_html__( 'Select League', 'footystats_domain' );

    $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Widget Title', 'footystats_domain' );

    $league_id = ! empty( $instance['selected_league_id'] ) ? $instance['selected_league_id'] : esc_html__( 'N/A', 'footystats_domain' );

    if($last_edited == null || $last_edited == "" || $last_edited == "update"){
      $instance['show_links'] = 1;
    }

    $club_id = ! empty( $instance['selected_club_id'] ) ? $instance['selected_club_id'] : esc_html__( 'N/A', 'footystats_domain' );

    // $club_name = ! empty( $instance['selected_club_name'] ) ? $instance['selected_club_name'] : esc_html__( 'N/A', 'footystats_domain' );

    // $league_name = htmlentities($league_name, null, 'utf-8');
    // $league_name = str_replace("&nbsp;", "", $league_name);
    // $league_name = html_entity_decode($league_name);

    ?>
    <div class='fs_form_wrapper'>
		<p>

    <!-- Widget Title -->

    <label style="display:block;" for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'footystats_domain' ); ?></label> 
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>

    <!-- Widget League -->

    <p>

		<label style="display:block;" for="country">Find League ID</label> 
    <select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'selected_league_id' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'selected_league_id' ) ); ?>" data-uid='fs_next_fixture_league'>
    <?php if(! empty ($instance['selected_league_id'])): ?>
      <option disabled>Selected</option>
      <option selected value="<?php echo $instance['selected_league_id']; ?>"><?php echo $instance['selected_league_id']; ?></option>
    <?php endif;?>
    <?= $options ?>
    </select>
    
    </p>
    <!-- Widget Team -->
    <p>
    <label for="team">Find Team ID</label>

    <select data-uid='fs_next_fixture_club' class="fs_next_fixture_club widefat" name="<?php echo esc_attr( $this->get_field_name( 'selected_club_id' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'selected_club_id' ) ); ?>">
    <?php if(! empty ($instance['selected_club_id'])): ?>
      <option value="<?= $instance['selected_club_id'] ?>"><?= $instance['selected_club_id'] ?></option>
    <?php endif;?>
    </select>

    
    <input type="hidden" value='<?php echo esc_attr( $this->get_field_id( 'selected_club_id' ) ); ?>' id='get_selected_club_id'>
    <input type="hidden" value='<?php echo esc_attr( $this->get_field_id( 'selected_league_id' ) ); ?>' id='get_selected_league_id'>

        <!-- Show links? -->
    <p>
      <label for="<?php echo $this->get_field_id( 'show_links' ); ?>">Include Links to FootyStats?</label>
      <input class="checkbox" type="checkbox" <?php checked( $instance[ 'show_links' ], 1); ?> id="<?php echo $this->get_field_id( 'show_links' ); ?>" name="<?php echo $this->get_field_name( 'show_links' ); ?>" /> 
    </p>

    </p>

    </div>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
    $instance = array();

    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
    
		$instance['selected_league_id'] = ( ! empty( $new_instance['selected_league_id'] ) ) ? sanitize_text_field( $new_instance['selected_league_id'] ) : '';

    $instance['selected_league_name'] = ( ! empty( $new_instance['selected_league_name'] ) ) ? sanitize_text_field( $new_instance['selected_league_name'] ) : '';

    $instance['selected_club_id'] = ( ! empty( $new_instance['selected_club_id'] ) ) ? sanitize_text_field( $new_instance['selected_club_id'] ) : '';

    $instance['selected_club_name'] = ( ! empty( $new_instance['selected_club_name'] ) ) ? sanitize_text_field( $new_instance['selected_club_name'] ) : '';

    $instance['show_links'] = isset($new_instance['show_links']) ? 1 : 0;
		$instance['last_edited'] = ( ! empty( $new_instance['last_edited'] ) ) ? time() : time();

		return $instance;
	}

} // Standing Widget Class

class footystats_FixturesWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'fixtures_widget', // Base ID
			esc_html__( 'FootyStats: Fixtures / Results', 'footystats_domain' ), // Name
			array( 'description' => esc_html__( 'Your Teams Fixtures', 'footystats_domain' ), ) // Args
		);
  }
  
  public function club_fixtures($id, $links){
    $tz = get_option('timezone_string');
    $url = plugin_dir_url( __FILE__ ).'/js/fixtures.min.js';
    if($links == 1){$links = 'true';}else{$links = 'false';}
    $content = "<div id='fs-fixtures'></div> <script> (function (w,d,s,o,f,js,fjs) { w['fsFixturesEmbed']=o;w[o] = w[o] || function () { (w[o].q = w[o].q || []).push(arguments) }; js = d.createElement(s), fjs = d.getElementsByTagName(s)[0]; js.id = o; js.src = f; js.async = 1; fjs.parentNode.insertBefore(js, fjs); }(window, document, 'script', 'fsFixtures', '{$url}')); fsFixtures('params', { teamID: {$id}, showLinks:{$links}, tz:'{$tz}' }); </script>";
  return $content;
  }

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['selected_club_id'] ) ) {
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
      echo $this->club_fixtures($instance['selected_club_id'], $instance['show_links']);
    }
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

    $leagues = wp_remote_get('https://footystats.org/e/active-leagues');
    $leagues = wp_remote_retrieve_body( $leagues );
    $leagues = json_decode($leagues, true);

    $options = "";
    $country = "";
    foreach($leagues as $l){
      if($country != $l['country'] || $country == ""){
        $options .= "<option disabled>{$l['country']}</option>";
        $country = $l['country'];
      }
      $options .= "<option value='{$l['id']}'>&nbsp;&nbsp;&nbsp;&nbsp;{$l['name']}</option>";
    }

    $last_edited = !empty($instance['last_edited']) ? $instance['last_edited'] : "update";

    // $league_name = ! empty( $instance['selected_league_name'] ) ? $instance['selected_league_name'] : esc_html__( 'Select League', 'footystats_domain' );

    $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Widget Title', 'footystats_domain' );

    // $league_id = ! empty( $instance['selected_league_id'] ) ? $instance['selected_league_id'] : esc_html__( 'N/A', 'footystats_domain' );

    $club_id = ! empty( $instance['selected_club_id'] ) ? $instance['selected_club_id'] : esc_html__( 'N/A', 'footystats_domain' );

    // $club_name = ! empty( $instance['selected_club_name'] ) ? $instance['selected_club_name'] : esc_html__( 'N/A', 'footystats_domain' );

    if($last_edited == null || $last_edited == "" || $last_edited == "update"){
      $instance['show_links'] = 1;
    }

    // $league_name = htmlentities($league_name, null, 'utf-8');
    // $league_name = str_replace("&nbsp;", "", $league_name);
    // $league_name = html_entity_decode($league_name);

    ?>
    <div class='fs_form_wrapper'>
		<p>

    <!-- Widget Title -->

    <label style="display:block;" for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'footystats_domain' ); ?></label> 
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>

    <!-- Widget League -->

    <p>

		<label style="display:block;" for="country">Find League ID</label> 
    <select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'selected_league_id' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'selected_league_id' ) ); ?>" data-uid='fs_next_fixture_league'>
    <?php if(! empty ($instance['selected_league_id'])): ?>
      <option disabled>Selected</option>
      <option selected value="<?php echo $instance['selected_league_id']; ?>"><?php echo $instance['selected_league_id']; ?></option>
    <?php endif;?>
    <?= $options ?>
    </select>
    
    </p>
    <!-- Widget Team -->
    <p>
    <label for="team">Find Team ID</label>

    <select data-uid='fs_next_fixture_club' class="fs_next_fixture_club widefat" name="<?php echo esc_attr( $this->get_field_name( 'selected_club_id' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'selected_club_id' ) ); ?>">
    <?php if(! empty ($instance['selected_club_id'])): ?>
      <option value="<?= $instance['selected_club_id'] ?>"><?= $instance['selected_club_id']; ?></option>
    <?php endif;?>
    </select>
    
    <input type="hidden" value='<?php echo esc_attr( $this->get_field_id( 'selected_club_id' ) ); ?>' id='get_selected_club_id'>
    <input type="hidden" value='<?php echo esc_attr( $this->get_field_id( 'selected_league_id' ) ); ?>' id='get_selected_league_id'>

    </p>

    <!-- Show links? -->
    <p>
      <label for="<?php echo $this->get_field_id( 'show_links' ); ?>">Include Links to FootyStats?</label>
      <input class="checkbox" type="checkbox" <?php checked( $instance[ 'show_links' ], 1); ?> id="<?php echo $this->get_field_id( 'show_links' ); ?>" name="<?php echo $this->get_field_name( 'show_links' ); ?>" /> 
    </p>

    </div>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
    $instance = array();

    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
    
		$instance['selected_league_id'] = ( ! empty( $new_instance['selected_league_id'] ) ) ? sanitize_text_field( $new_instance['selected_league_id'] ) : '';

    // $instance['selected_league_name'] = ( ! empty( $new_instance['selected_league_name'] ) ) ? sanitize_text_field( $new_instance['selected_league_name'] ) : '';

    $instance['selected_club_id'] = ( ! empty( $new_instance['selected_club_id'] ) ) ? sanitize_text_field( $new_instance['selected_club_id'] ) : '';

    // $instance['selected_club_name'] = ( ! empty( $new_instance['selected_club_name'] ) ) ? sanitize_text_field( $new_instance['selected_club_name'] ) : '';

    $instance['show_links'] = isset($new_instance['show_links']) ? 1 : 0;
		$instance['last_edited'] = ( ! empty( $new_instance['last_edited'] ) ) ? time() : time();

		return $instance;
	}

} // Standing Widget Class

class footystats_Upcoming_RoundWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'upcoming_round_widget', // Base ID
			esc_html__( 'FootyStats: Upcoming Round', 'footystats_domain' ), // Name
			array( 'description' => esc_html__( 'Upcoming Round of Fixtures', 'footystats_domain' ), ) // Args
		);
  }
  
  public function upcoming_round_html($id, $links=1){
    $tz = get_option('timezone_string');
    $url = plugin_dir_url( __FILE__ ).'js/nextRound.js';
    if($links == 1){$links = 'true';}else{$links = 'false';}
    $content = "<div id='fs-upcoming-round'></div>
    <script>
        (function (w,d,s,o,f,js,fjs) {
            w['fsUpcomingRound']=o;w[o] = w[o] || function () { (w[o].q = w[o].q || []).push(arguments) };
            js = d.createElement(s), fjs = d.getElementsByTagName(s)[0];
            js.id = o; js.src = f; js.async = 1; fjs.parentNode.insertBefore(js, fjs);
        }(window, document, 'script', 'ur', '{$url}'));
        ur('params', { leagueID: {$id}, showLinks: {$links}, tz:'{$tz}'});
    </script>";
  return $content;
  }

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['selected_league_id'] ) ) {
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
      echo $this->upcoming_round_html($instance['selected_league_id'], $instance['show_links']);
    }
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

    $leagues = wp_remote_get('https://footystats.org/e/active-leagues');
    $leagues = wp_remote_retrieve_body( $leagues );
    $leagues = json_decode($leagues, true);

    $options = "";
    $country = "";
    foreach($leagues as $l){
      if($country != $l['country'] || $country == ""){
        $options .= "<option disabled>{$l['country']}</option>";
        $country = $l['country'];
      }
      $options .= "<option value='{$l['id']}'>&nbsp;&nbsp;&nbsp;{$l['name']}</option>";
    }

    $last_edited = !empty($instance['last_edited']) ? $instance['last_edited'] : "update";

    $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Widget Title', 'footystats_domain' );

    $league_id = ! empty( $instance['selected_league_id'] ) ? $instance['selected_league_id'] : esc_html__( '2012', 'footystats_domain' );

    if($last_edited == null || $last_edited == "" || $last_edited == "update"){
      $instance['show_links'] = 1;
    }

    // if(!isset($instance['selected_league_name'])){$instance['selected_league_name'] = "";}
    // $league_name = htmlentities($instance['selected_league_name'], null, 'utf-8');
    // $league_name = str_replace("&nbsp;", "", $league_name);
    // $league_name = html_entity_decode($league_name);

    ?>
    <div class='fs_form_wrapper'>
		<p>

    <!-- Widget Title -->

    <label style="display:block;" for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'footystats_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

    <!-- Widget Table -->

		<label style="display:block;" for="country">Find League ID</label> 
    <select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'selected_league_id' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'selected_league_id' ) ); ?>" data-uid='fs_league_standings'>
    <?php if(! empty ($instance['selected_league_id'])): ?>
      <option disabled>Selected</option>
      <option selected value="<?php echo $instance['selected_league_id']; ?>"><?php echo $league_id ?></option>
    <?php endif;?>
    <?= $options ?>
    </select>

    <input type="hidden" value='<?php echo esc_attr( $this->get_field_id( 'selected_league_id' ) ); ?>' id='get_selected_league_id'>

    <!-- Show links? -->
    <p>
      <label for="<?php echo $this->get_field_id( 'show_links' ); ?>">Include Links to FootyStats?</label>
      <input class="checkbox" type="checkbox" <?php checked( $instance[ 'show_links' ], 1); ?> id="<?php echo $this->get_field_id( 'show_links' ); ?>" name="<?php echo $this->get_field_name( 'show_links' ); ?>" /> 
    </p>

    </p>

    </div>

		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
    $instance = array();

    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
    
    $instance['selected_league_id'] = ( ! empty( $new_instance['selected_league_id'] ) ) ? sanitize_text_field( $new_instance['selected_league_id'] ) : '';

    $instance['show_links'] = isset($new_instance['show_links']) ? 1 : 0;
		$instance['last_edited'] = ( ! empty( $new_instance['last_edited'] ) ) ? time() : time();

		return $instance;
	}

} // Standing Widget Class

class footystats_Previous_RoundWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'previous_round_widget', // Base ID
			esc_html__( 'FootyStats: Previous Round', 'footystats_domain' ), // Name
			array( 'description' => esc_html__( 'Previous Round of Fixtures', 'footystats_domain' ), ) // Args
		);
  }
  
  public function previous_round_html($id, $links=1){
    $url = plugin_dir_url( __FILE__ ).'js/previousRound.js';
    if($links == 1){$links = 'true';}else{$links = 'false';}
    $content = "<div id='fs-previous-round'></div>
    <script>
        (function (w,d,s,o,f,js,fjs) {
            w['fsPreviousRound']=o;w[o] = w[o] || function () { (w[o].q = w[o].q || []).push(arguments) };
            js = d.createElement(s), fjs = d.getElementsByTagName(s)[0];
            js.id = o; js.src = f; js.async = 1; fjs.parentNode.insertBefore(js, fjs);
        }(window, document, 'script', 'pr', '{$url}'));
        pr('params', { leagueID: {$id}, showLinks: {$links}});
    </script>";
  return $content;
  }

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['selected_league_id'] ) ) {
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
      echo $this->previous_round_html($instance['selected_league_id'], $instance['show_links']);
    }
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

    $leagues = wp_remote_get('https://footystats.org/e/active-leagues');
    $leagues = wp_remote_retrieve_body( $leagues );
    $leagues = json_decode($leagues, true);

    $options = "";
    $country = "";
    foreach($leagues as $l){
      if($country != $l['country'] || $country == ""){
        $options .= "<option disabled>{$l['country']}</option>";
        $country = $l['country'];
      }
      $options .= "<option value='{$l['id']}'>&nbsp;&nbsp;&nbsp;{$l['name']}</option>";
    }

    $last_edited = !empty($instance['last_edited']) ? $instance['last_edited'] : "update";

    $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Widget Title', 'footystats_domain' );

    $league_id = ! empty( $instance['selected_league_id'] ) ? $instance['selected_league_id'] : esc_html__( '2012', 'footystats_domain' );

    if($last_edited == null || $last_edited == "" || $last_edited == "update"){
      $instance['show_links'] = 1;
    }

    // if(!isset($instance['selected_league_name'])){$instance['selected_league_name'] = "";}
    // $league_name = htmlentities($instance['selected_league_name'], null, 'utf-8');
    // $league_name = str_replace("&nbsp;", "", $league_name);
    // $league_name = html_entity_decode($league_name);

    ?>
    <div class='fs_form_wrapper'>
		<p>

    <!-- Widget Title -->

    <label style="display:block;" for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'footystats_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

    <!-- Widget Table -->

		<label style="display:block;" for="country">Find League ID</label> 
    <select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'selected_league_id' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'selected_league_id' ) ); ?>" data-uid='fs_league_standings'>
    <?php if(! empty ($instance['selected_league_id'])): ?>
      <option disabled>Selected</option>
      <option selected value="<?php echo $instance['selected_league_id']; ?>"><?php echo $league_id ?></option>
    <?php endif;?>
    <?= $options ?>
    </select>

    <input type="hidden" value='<?php echo esc_attr( $this->get_field_id( 'selected_league_id' ) ); ?>' id='get_selected_league_id'>

    <!-- Show links? -->
    <p>
      <label for="<?php echo $this->get_field_id( 'show_links' ); ?>">Include Links to FootyStats?</label>
      <input class="checkbox" type="checkbox" <?php checked( $instance[ 'show_links' ], 1); ?> id="<?php echo $this->get_field_id( 'show_links' ); ?>" name="<?php echo $this->get_field_name( 'show_links' ); ?>" /> 
    </p>

    </p>

    </div>

		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
    $instance = array();

    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
    
    $instance['selected_league_id'] = ( ! empty( $new_instance['selected_league_id'] ) ) ? sanitize_text_field( $new_instance['selected_league_id'] ) : '';

    $instance['show_links'] = isset($new_instance['show_links']) ? 1 : 0;
		$instance['last_edited'] = ( ! empty( $new_instance['last_edited'] ) ) ? time() : time();

		return $instance;
	}

} // Standing Widget Class

?>
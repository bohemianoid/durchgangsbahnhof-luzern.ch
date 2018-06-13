<?php

	//javascripts
	function db_javascripts() {

		//jquery
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', flase, false, false );
		wp_enqueue_script( 'jquery' );

		//modernizr
		wp_register_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.min.js', flase, false, false );
		wp_enqueue_script( 'modernizr' );

		//scrollto
		wp_register_script( 'scrollto', get_template_directory_uri() . '/js/jquery.scrollTo-1.4.2-min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'scrollto' );

		//localscroll
		wp_register_script( 'localscroll', get_template_directory_uri() . '/js/jquery.localscroll-1.2.7-min.js', array( 'scrollto' ), false, true );
		wp_enqueue_script( 'localscroll' );

		//form validation
		wp_register_script( 'validation', get_template_directory_uri() . '/js/jquery.validate.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'validation' );

		//fancybox
		wp_register_script( 'fancybox', get_template_directory_uri() . '/fancybox/jquery.fancybox.pack.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'fancybox' );

		//masonry
		wp_register_script( 'masonry', get_template_directory_uri() . '/js/jquery.masonry.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'masonry' );

		//functions
		wp_register_script( 'functions', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'functions' );

	}

	add_action( 'wp_enqueue_scripts', 'db_javascripts' );



	//lt ie 9
	function db_ie() {
		global $is_IE;
		if ( $is_IE ) : ?>
			<!--[if lt IE 9]>
				<link href="<?php echo get_stylesheet_directory_uri() ?>/style-ie.css" rel="stylesheet" type="text/css" media="screen" />
				<script src="<?php echo get_template_directory_uri() ?>/js/functions-ie.js"></script>
			<![endif]-->
		<?php endif;
	}

	add_action( 'wp_head', 'db_ie' );



	//piwik
	function db_piwik() { ?>
		<!-- Piwik -->
		<script type="text/javascript">
			var pkBaseURL = (("https:" == document.location.protocol) ? "https://piwik.simonroth.ch/" : "http://piwik.simonroth.ch/");
			document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
			try {
			var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 2);
			piwikTracker.trackPageView();
			piwikTracker.enableLinkTracking();
			} catch( err ) {}
		</script>
		<noscript><p><img src="http://piwik.simonroth.ch/piwik.php?idsite=2" style="border:0" alt="" /></p></noscript>
		<!-- End Piwik Tracking Code -->
	<?php }

	// add_action( 'wp_footer', 'db_piwik' );



	//register menu
	function db_menu() {
		register_nav_menus( array(
			'navigation'	=>	__( 'Navigation' )
		) );
	}

	add_action( 'init', 'db_menu' );



	//menu navigation
	$navigation = array(
		'theme_location'	=> 'navigation',
		'menu'				=> '',
		'container'			=> '',
		'container_class'	=> '',
		'container_id'		=> '',
		'menu_class'		=> '',
		'menu_id'			=> '',
		'echo'				=> true,
		'fallback_cb'		=> 'wp_page_menu',
		'before'			=> '',
		'after'				=> '',
		'link_before'		=> '',
		'link_after'		=> '',
		'items_wrap'		=> '<ul>%3$s</ul>',
		'depth'				=> 0,
		'walker'			=> ''
	);

	add_filter( 'nav_menu_item_id', 'db_navigation_li_id' );
	function db_navigation_li_id( $id ){
		$id = '';
		return $id;
	}

	add_filter( 'nav_menu_css_class', 'db_navigation_li_class' );
	function db_navigation_li_class( $classes ){
		$classes = array();
		return $classes;
	}



	//register sidebar
	function db_sidebar () {
		register_sidebar( array(
			'name'			=>	__( 'Sidebar' ),
			'id'			=>	'sidebar',
			'description'	=>	'',
			'class'			=>	'',
			'before_widget'	=>	'<li>',
			'after_widget'	=>	'</li>',
			'before_title'	=>	'<h3>',
			'after_title'	=>	'</h3>'
		) );
	}

	add_action( 'widgets_init', 'db_sidebar' );



	//material widget
	class db_materials_widget extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'db_materials_widget',
				'Materialien',
				array(
					'description' => __( 'Stellt Materialien des Projekts zum herunterladen bereit', 'text_domain' )
				)
			);
		}

		public function form( $instance ) {
			if ( isset( $instance[ 'title' ] ) ) {
				$title = $instance[ 'title' ];
			}
			else {
				$title = __( 'Neuer Titel', 'text_domain' );
			} ?>

			<p>
				<label for="<?php echo $this -> get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
				<input class="widefat" id="<?php echo $this -> get_field_id( 'title' ); ?>" name="<?php echo $this -> get_field_name( 'title' ) ?>" type="text" value="<?php echo esc_attr( $title ) ?>" />
			</p>
		<?php }

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
			return $instance;
		}

		public function widget( $args, $instance ) {
			extract( $args );
			$title = apply_filters( 'widget_title', $instance[ 'title' ] );

			global $query_string;
			query_posts( array(
				'post_status'		=>	'any',
				'post_type'			=>	'attachment',
				'orderby'			=>	'menu_order',
				'order'				=>	'ASC',
				'post_mime_type'	=>	array( 'application/pdf', 'application/vnd.openxmlformats-officedocument.presentationml' )
			) );

			if ( have_posts() ) :
				echo $before_widget;
					echo $before_title . $title . $after_title; ?>
					<ul>
						<?php while ( have_posts() ) : the_post(); ?>
							<li><a href="<?php echo wp_get_attachment_url(); ?>"><?php the_title(); ?></a></li>
						<?php endwhile; ?>
					</ul>
				<?php echo $after_widget;
			endif;

			wp_reset_query();
		}
	}

	register_widget( 'db_materials_widget' );



	//display presentations
	function db_presentations() {
		global $query_string;
		query_posts( array(
			'post_status'		=>	'any',
			'post_type'			=>	'attachment',
			'orderby'			=>	'menu_order',
			'order'				=>	'ASC',
			'post_mime_type'	=>	'application/x-shockwave-flash'
		) );

		if ( have_posts() ) : ?>
			<ul class="presentations">
				<?php while ( have_posts() ) : the_post(); ?>
					<li><a class="fancybox" href="<?php echo wp_get_attachment_url(); ?>"><?php the_title(); ?></a></li>
				<?php endwhile; ?>
			</ul>
		<?php endif;

		wp_reset_query();
	}



	//recommendation link
	function db_recommend_link() { ?>
		<ul class="recommend">
			<li><a class="fancybox" href="#recommend-inline">Projekt weiterempfehlen</a></li>
		</ul>

		<div id="recommend-inline">
			<h3>Projekt weiterempfehlen</h3>
			<form action="<?php the_permalink(); ?>" method="post" id="recommend-form">
				<fieldset id="recommend-data">
					<label for="toname">Empfänger Name <span>*</span></label>
					<input id="toname" name="toname" type="text" value="" size="30" required>
					<br />
					<label for="toemail">Empfänger E-Mail <span>*</span></label>
					<input id="toemail" name="toemail" type="email" value="" size="30" required>
					<br />
					<label for="fromname">Absender Name <span>*</span></label>
					<input id="fromname" name="fromname" type="text" value="" size="30" required>
					<br />
					<label for="fromemail">Absender E-Mail <span>*</span></label>
					<input id="fromemail" name="fromemail" type="email" value="" size="30" required>
					<br />
				</fieldset>
				<p class="form-submit">
					<input name="submit" type="submit" id="submit" value="Weiterempfehlung senden">
					<input id="submited" name="submited" type="hidden" value="submited">
				</p>
			</form>
		</div>

		<?php if ( $_COOKIE[ 'RecommendForm' ] == 'sent' ) : ?>
			<div id="recommend-sent">
				<div class="page">
					<p>Besten Dank für Ihre Weiterempfehlung.</p>
				</div>
			</div>
		<?php endif;
	}



	//send recommendation
	add_filter( 'wp_mail_content_type', 'db_html_mail' );
	function db_html_mail() {
		return 'text/html';
	}

	function db_recommend() {

		if( !isset( $_POST[ 'submited' ] ) ) {
			return;
		}

		$toname = $_POST[ 'toname' ];
		$toemail = $_POST[ 'toemail' ];
		$fromname = $_POST[ 'fromname' ];
		$fromemail = $_POST[ 'fromemail' ];

		if( date( 'G' ) > 0 && date( 'G' ) <= 10 ) {
			$hello = 'Guten Morgen';
		}
		if( date( 'G' ) > 10 && date( 'G' ) <= 17 ) {
			$hello = 'Guten Tag';
		}
		if( date( 'G' ) > 17 && date( 'G' ) <= 23 ) {
			$hello = 'Guten Abend';
		}

		$to = $toemail;
		$subject = 'Durchgangsbahnhof Luzern - die Alternative';
		$message = '
		<p>' . $hello . ' ' . $toname . ',<br />'
		. wordwrap( $fromname . ' hat Ihnen die Website des Projekts "Druchgangsbahnhof Luzern - die Alternative" weiterempfohlen:', 100, '<br />' ) . '</p>
		<h1>Durchgangsbahnhof Luzern - die Alternative</h1>
		<p>' . wordwrap( 'Der Bund zweifelt am Nutzen des Luzerner Tiefbahnhofes. Dieser 1,57 Milliarden teure Sackbahnhof dient ausschliesslich den Zügen nach Zug und Zürich und hat keine nationale Bedeutung.', 100, '<br />' ) . '</p>
		<p>' . wordwrap( 'Theophil Schreck hat eine sehr interessante Alternative entwickelt. Mit einem wesentlich kürzeren Tunnel könnten neben den Zügen von Zürich auch die Züge von Basel, Bern und dem Seetal in den Tiefbahnhof einfahren und ihn über eine Kurzrampe wieder verlassen.', 100, '<br />' ) . '</p>
		<a href="http://durchgangsbahnhof-luzern.ch">' . wordwrap( 'Weitere Informationen zum Projekt finden Sie auf der Website unter http://durchgangsbahnhof-luzern.ch', 100, '<br />' ) . '</a>
		';
		$headers[] = 'From: ' . $fromname . ' <' . $fromemail . '>';

		if( wp_mail( $to, $subject, $message, $headers ) ) {
			setcookie( 'RecommendForm', 'sent', time()+20 );
		}
		else {
			setcookie( 'RecommendForm', 'error', time()+60 );
		}

		header( 'Location: ' . $_SERVER[ 'HTTP_REFERER' ] );
		exit();

	}

	add_action( 'init', 'db_recommend' );



	//comment form
	function db_comment_form( $args = array(), $post_id = null ) {
		global $id;

		if ( null === $post_id )
			$post_id = $id;
		else
			$id = $post_id;

		$commenter = wp_get_current_commenter();
		$user = wp_get_current_user();
		$user_identity = $user -> exists() ? $user -> display_name : '';

		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " required" : '' );
		$fields =  array(
			'author'	=>	'<label for="author">' . __( 'Name' ) . ( $req ? ' <span>*</span>' : '' ) . '</label>' .
							'<input id="author" name="author" type="text" value="' . esc_attr( $commenter[ 'comment_author' ] ) . '" size="30"' . $aria_req . ' /><br />',
			'function'	=>	'<label for="function">' . __( 'Funktion' ) . '</label>' .
							'<input id="function" name="function" type="text" value="' . esc_attr( $commenter[ 'comment_author_function' ] ) . '" size="30" /><br />',
			'email'		=>	'<label for="email">' . __( 'E-Mail' ) . __( ' (wird nicht veröffentlicht)' ) . ( $req ? ' <span>*</span>' : '' ) . '</label>' .
							'<input id="email" name="email" type="email" value="' . esc_attr(  $commenter[ 'comment_author_email' ] ) . '" size="30"' . $aria_req . ' /><br />',
			'url'		=>	'',
			'privat'	=>	'<label for="privat">' . __( 'Private Nachricht' ) . '</label>' .
							'<input id="privat" name="privat" type="checkbox" value="privat" /> Ich möchte meine Meinung nur als private Nachricht an Theophil Schreck senden und nicht veröffentlichen.<br />'
		);

		$required_text = sprintf( ' ' . __('Mit <span>*</span> markierte Eingabefelder werden benötigt um Ihre Meinung zu senden.'), '<span>*</span>' );
		$defaults = array(
			'fields'				=> apply_filters( 'comment_form_default_fields', $fields ),
			'comment_field'			=> '<label for="comment">' . _x( 'Ihre Meinung (darf sinngemäss zitiert werden)', 'noun' ) . ( $req ? ' <span>*</span>' : '' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea><br />',
			'must_log_in'			=> '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
			'logged_in_as'			=> '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
			'comment_notes_before'	=> '',
			'comment_notes_after'	=> '<label class="required">' . ( $req ? $required_text : '' ) . '</label>',
			'id_form'				=> 'comment-form',
			'id_submit'				=> 'submit',
			'title_reply'			=> __( 'Ihre Meinung' ),
			'title_reply_to'		=> __( 'Ihre Meinung zu %s' ),
			'cancel_reply_link'		=> __( 'Ihre Meinung zurücksetzen' ),
			'label_submit'			=> __( 'Ihre Meinung senden' ),
		);

		$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

		if ( comments_open( $post_id ) ) : ?>
			<?php do_action( 'comment_form_before' ); ?>
			<section id="opinion">
				<h3 id="reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></h3>
				<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
					<?php echo $args['must_log_in']; ?>
					<?php do_action( 'comment_form_must_log_in_after' ); ?>
				<?php else : ?>
					<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">
						<?php do_action( 'comment_form_top' ); ?>
						<?php if ( is_user_logged_in() ) : ?>
							<?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
							<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
						<?php else : ?>
							<?php echo $args['comment_notes_before']; ?>
							<?php do_action( 'comment_form_before_fields' ); ?>
							<fieldset id="author-data">
								<?php foreach ( (array) $args['fields'] as $name => $field ) {
									echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
								} ?>
								<?php echo $args['comment_notes_after']; ?>
							</fieldset>
							<?php do_action( 'comment_form_after_fields' ); ?>
						<?php endif; ?>
						<fieldset id="comment-data">
							<?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
							<p class="form-submit">
								<input name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
								<?php comment_id_fields( $post_id ); ?>
							</p>
							<?php do_action( 'comment_form', $post_id ); ?>
						</fieldset>
					</form>
				<?php endif; ?>
			</section>
			<?php do_action( 'comment_form_after' ); ?>
			<?php else : ?>
				<?php do_action( 'comment_form_comments_closed' ); ?>
			<?php endif; ?>
		<?php
	}



	// redirect after comment submit
	function db_comment_submit_redirect( $redirect_to ) {
		$redirect_to = site_url( '#opinions' );
		return $redirect_to;
	}

	add_action('comment_post_redirect', 'db_comment_submit_redirect');



	//add comment meta data
	function db_comment_meta_data( $comment_id ) {
		if ( ( isset( $_POST[ 'function' ] ) ) && ( $_POST[ 'function' ] != '') )
			$function = wp_filter_nohtml_kses( $_POST[ 'function' ] );
			add_comment_meta( $comment_id, 'comment_author_function', $function );

		if ( ( isset( $_POST[ 'privat' ] ) ) && ( $_POST[ 'privat' ] != '') )
			$privat = wp_filter_nohtml_kses( $_POST[ 'privat' ] );
			add_comment_meta( $comment_id, 'comment_privat', $privat );
	}

	add_action( 'comment_post', 'db_comment_meta_data' );



	//add comment meta data boxes
	function db_comment_meta_boxes() {
		add_meta_box( 'author', __( 'Zusätzliche Informationen' ), 'db_comment_meta_author_box', 'comment', 'normal', 'high' );
		add_meta_box( 'display', __( 'Anzeige' ), 'db_comment_meta_display_box', 'comment', 'normal', 'high' );
		add_meta_box( 'quote', __( 'Kommentar zitieren' ), 'db_comment_meta_quote_box', 'comment', 'normal', 'high' );
	}

	add_action( 'add_meta_boxes_comment', 'db_comment_meta_boxes' );

	function db_comment_meta_author_box ( $comment ) {
		$function = get_comment_meta( $comment->comment_ID, 'comment_author_function', true );
		wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false ); ?>

		<table class="form-table editcomment">
			<tbody>
				<tr valign="top">
					<td class="first"><?php _e( 'Funktion:' ); ?></td>
					<td><input type="text" name="function" size="30" value="<?php echo esc_attr( $function ); ?>" tabindex="1" id="function" class="widefat" /></td>
				</tr>
			</tbody>
		</table>

	<?php }

	function db_comment_meta_display_box ( $comment ) {
		$privat = get_comment_meta( $comment->comment_ID, 'comment_privat', true );
		$anima = get_comment_meta( $comment->comment_ID, 'comment_anima', true );
		wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false ); ?>

		<table class="form-table editcomment">
			<tbody>
				<tr valign="top">
					<td><?php _e( 'Private Nachricht' ); ?></td>
					<td>
						<label for="privat">
							<input type="checkbox" name="privat" value="privat" <?php if ( ( isset( $privat ) ) && ( $privat != '') ) echo 'checked="checked"' ?> /> Diesen Kommentar als private Nachricht markieren.
						</label>
					</td>
				</tr>
				<tr valign="top">
					<td><?php _e( 'Animationskommentar' ); ?></td>
					<td>
						<label for="anima">
							<input type="checkbox" name="anima" value="anima" <?php if ( ( isset( $anima ) ) && ( $anima != '') ) echo 'checked="checked"' ?> /> Diesen Kommentar als Animationskommentar verwenden.
						</label>
					</td>
				</tr>
			</tbody>
		</table>

	<?php }

	function db_comment_meta_quote_box ( $comment ) {
		$quote = get_comment_meta( $comment->comment_ID, 'comment_quote', true );
		wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false ); ?>

		<table class="form-table editcomment">
			<tbody>
				<tr valign="top">
					<td class="field">
						<textarea name="quote" id="quote" rows="5" cols="30" class="widefat"><?php echo esc_textarea( $quote ); ?></textarea>
						<br />
						<span class="description">Text zwischen [q] und [/q] wird automatisch mit Anführungszeichen zitiert.</span>
					</td>
				</tr>
			</tbody>
		</table>

	<?php }


	//edit comment meta data
	function db_comment_edit( $comment_id ) {
		if( ! isset( $_POST[ 'extend_comment_update' ] ) || ! wp_verify_nonce( $_POST[ 'extend_comment_update' ], 'extend_comment_update' ) ) return;

		if ( ( isset( $_POST[ 'function' ] ) ) && ( $_POST[ 'function' ] != '') ) {
			$function = wp_filter_nohtml_kses( $_POST[ 'function' ] );
			update_comment_meta( $comment_id, 'comment_author_function', $function );
		} else {
			delete_comment_meta( $comment_id, 'comment_author_function');
		}

		if ( ( isset( $_POST[ 'privat' ] ) ) && ( $_POST[ 'privat' ] != '') ) {
			$privat = wp_filter_post_kses( $_POST[ 'privat' ] );
			update_comment_meta( $comment_id, 'comment_privat', $privat );
		} else {
			delete_comment_meta( $comment_id, 'comment_privat');
		}

		if ( ( isset( $_POST[ 'anima' ] ) ) && ( $_POST[ 'anima' ] != '') ) {
			$anima = wp_filter_post_kses( $_POST[ 'anima' ] );
			update_comment_meta( $comment_id, 'comment_anima', $anima );
		} else {
			delete_comment_meta( $comment_id, 'comment_anima');
		}

		if ( ( isset( $_POST[ 'quote' ] ) ) && ( $_POST[ 'quote' ] != '') ) {
			$short = $_POST[ 'quote' ];
			update_comment_meta( $comment_id, 'comment_quote', $short );
		} else {
			delete_comment_meta( $comment_id, 'comment_quote');
		}
	}

	add_action( 'edit_comment', 'db_comment_edit' );



	//get comment meta data
	function db_comment_author_function() {
		global $comment;
		return get_comment_meta( $comment->comment_ID, 'comment_author_function', true );
	}

	function db_comment_privat() {
		global $comment;
		return get_comment_meta( $comment->comment_ID, 'comment_privat', true );
	}

	function db_comment_anima() {
		global $comment;
		return get_comment_meta( $comment->comment_ID, 'comment_anima', true );
	}

	function db_comment_quote() {
		global $comment;
		return get_comment_meta( $comment->comment_ID, 'comment_quote', true );
	}



	//add quotes to comment
	add_filter( 'comment_text', 'db_comment_text_quotes' );
	function db_comment_text_quotes() {
		global $comment;

		$filter = strpos( get_comment_text( $comment ), '[q]' );

		if ( $filter === false ) {
			return '&laquo;' . get_comment_text( $comment ) . '&raquo;';
		} else {
			$comment_filtered = str_replace( array( '[q]', '[/q]' ), array( '&laquo;', '&raquo' ), get_comment_text( $comment ) );
			return $comment_filtered;
		}

	}


	//filter comment quote
	function db_comment_quote_filter() {
		$quote = db_comment_quote();
		$quote_filtered = str_replace( array( '[q]', '[/q]' ), array( '&laquo;', '&raquo' ), $quote );

		return '<p>' . $quote_filtered . '</p>';
	}



	//copyright
	function db_copyright() {
		$release = 2009;
		$current = date( 'Y' );

		if ( $release == $current ) {
			echo $release;
		} else {
			echo $release . ' - ' . $current;
		}
	}



	// change backend footer
	add_filter('admin_footer_text', 'db_backend_footer');
	function db_backend_footer () {
		echo 'Webdesign und Entwicklung <a href="http://simonroth.ch">Simon Roth</a> &mdash; <a href="mailto:support@simonroth.ch">support@simonroth.ch</a>';
	}

?>

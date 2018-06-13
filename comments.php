<section id="opinions">
	<h3>Stimmen</h3>
	<div class="masonry">
		<?php if ( have_comments() ) : ?>
			<?php foreach ( $comments as $comment ) : ?>
				<?php if ( db_comment_privat() == '' && db_comment_anima() == '' && $comment -> comment_approved == '1' ) : ?>
					<article>
						<h4><?php comment_author(); if ( db_comment_author_function() != '' ) : echo ', ' . db_comment_author_function(); endif; ?></h4>
						<?php if ( db_comment_quote() != '' ) : ?>
							<?php echo db_comment_quote_filter(); ?>
						<?php else : ?>
							<?php comment_text(); ?>
						<?php endif; ?>
					</article>
				<?php endif; ?>
				<?php if ( $comment -> comment_approved == '0' ) : ?>
					<div id="comment-sent">
						<div class="page">
							<?php if ( db_comment_privat() == '' ) : ?>
								<p>Ihre Meinung wurde an Theophil Schreck gesendet und befindet sich in der Moderation.</p>
							<?php else : ?>
								<p>Ihre Meinung wurde als private Nachricht an Theophil Schreck gesendet.</p>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<?php if ( have_comments() ) : ?>
			<?php foreach ( $comments as $comment ) : ?>
				<?php if ( db_comment_privat() == '' && db_comment_anima() != '' && $comment -> comment_approved == '1' ) : ?>
					<article>
						<h4><?php comment_author(); if ( db_comment_author_function() != '' ) : echo ', ' . db_comment_author_function(); endif; ?></h4>
						<?php if ( db_comment_quote() != '' ) : ?>
							<?php echo db_comment_quote_filter(); ?>
						<?php else : ?>
							<?php comment_text(); ?>
						<?php endif; ?>
					</article>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</section>

<?php db_comment_form(); ?>
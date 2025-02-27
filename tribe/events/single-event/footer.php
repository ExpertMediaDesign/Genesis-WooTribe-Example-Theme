<?php
/**
 * Single Event Footer Template Part
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/single-event/footer.php
 *
 * See more documentation about our Blocks Editor templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 4.7
 *
 */
?>

<?php
$events_label_singular = tribe_get_event_label_singular();
?>
<div id="emd-added-contact-forms">
    <h2>Interested in Joining Us?</h2>
    <p>Reach out below for more information! One of our certified instructors will be happy to answer your questions.</p>
    <?php  echo do_shortcode( '[contact-form-7 id="384" title="Event Signup Form"]' ); ?>
</div>
<div id="tribe-events-footer">
	<h3 class="tribe-events-visuallyhidden"><?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?></h3>
	<ul class="tribe-events-sub-nav">
		<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
		<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
	</ul>
</div>

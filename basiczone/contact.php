<?php
  /*
  Template Name: Contact Form
  */
if(isset($_POST['submitted'])) {
	if(trim($_POST['contactName']) === '') {
		$nameError = __( 'Please enter your name.', 'basiczone' );
		$hasError = true;
	} else {
		$name = trim($_POST['contactName']);
	}
	if(trim($_POST['email']) === '')  {
		$emailError = __( 'Please enter your valid email address.', 'basiczone' );
		$hasError = true;
	} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
		$emailError = __( 'You entered an invalid email address.', 'basiczone' );
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}
	if(trim($_POST['comments']) === '') {
		$commentError = __( 'Please write your message.', 'basiczone' );
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['comments']));
		} else {
			$comments = trim($_POST['comments']);
		}
	}
	require_once('includes/recaptchalib.php');
	$privatekey = "6Let7cwSAAAAAMHwVuPujRfvArAAH2Sg8oRMyt_5";
	$resp = recaptcha_check_answer ($privatekey,
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);
	if (!$resp->is_valid) {
		die (__('The reCAPTCHA wasn&rsquo;t entered correctly. Go back and try it again.', 'basiczone' ) );
	} else {
		// Your code here to handle a successful verification
	}									
	if(!isset($hasError)) {
		$emailTo = get_option('tz_email');
		if (!isset($emailTo) || ($emailTo == '') ){
			$emailTo = get_option('admin_email');
		}
		$subject = '[Contact Form Alert] From '.$name;
		$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
		$headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

		mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
	}

}
get_header(); ?>
	<div id="primary">
		<div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<div id="breadcrumbs"><?php if(function_exists('breadcrumbs')){ breadcrumbs(); } ?></div>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->
					<div class="entry-content">
						<?php if(isset($emailSent) && $emailSent == true) { ?>
							<div class="thanks">
								<p><?php _e( 'Thanks, your message was sent successfully.', 'basiczone' ); ?></p>
							</div>
						<?php } else { ?>
							<?php the_content(); ?>
							<?php if(isset($hasError) || isset($captchaError)) { ?>
								<p class="error"><?php _e( 'Sorry, an error occured.', 'basiczone' ); ?><p>
							<?php } ?>
							<form action="<?php the_permalink(); ?>" id="contactForm" method="post">
								<ul class="contactform">
									<li>
										<label for="contactName"><?php _e( 'Your Real Name:', 'basiczone' ); ?></label>
										<br />
										<input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="required requiredField" />
										<?php if($nameError != '') { ?>
											<span class="error">$nameError</span>
										<?php } ?>
									</li>
									<li>
										<label for="email"><?php _e( 'Your Valid Email Address :', 'basiczone' ); ?></label>
										<br />
										<input type="text" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="required requiredField email" />
										<?php if($emailError != '') { ?>
											<span class="error">$emailError</span>
										<?php } ?>
									</li>
									<li><label for="commentsText"><?php _e( 'Your Message:', 'basiczone' ); ?></label>
										<br />
										<textarea name="comments" id="commentsText" rows="15" cols="50" class="required requiredField"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
										<?php if($commentError != '') { ?>
											<br /><span class="error">$commentError</span>
										<?php } ?>
									</li>
									<li><script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6Let7cwSAAAAACCP-ibzGkv1OSArYtw1Bf2zPFhB"></script>
									<noscript>
										<iframe src="http://www.google.com/recaptcha/api/noscript?k=6Let7cwSAAAAACCP-ibzGkv1OSArYtw1Bf2zPFhB" height="300" width="500" frameborder="0"></iframe><br>
										<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
										<input type="hidden" name="recaptcha_response_field" value="manual_challenge">
									</noscript>
									</li>	
									<li><input type="submit" value="<?php _e( 'Send Message', 'basiczone' ); ?>" /></li>
								</ul>
							<input type="hidden" name="submitted" id="submitted" value="true" />
						</form>
					<?php } ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Page:', 'basiczone' ), 'after' => '</div>' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'basiczone' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-<?php the_ID(); ?> -->
			<?php endwhile; ?>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_sidebar() ?>
<?php get_footer() ?>
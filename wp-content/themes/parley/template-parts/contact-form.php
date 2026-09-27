<form class="contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
	<input type="hidden" name="action" value="parley_enquiry" />
	<?php wp_nonce_field( 'parley_enquiry', 'parley_enquiry_nonce' ); ?>
	<input class="visually-hidden" name="website" type="text" tabindex="-1" autocomplete="off" aria-hidden="true" />
	<div class="contact-form__row">
		<div class="form-field">
			<label class="form-field__label" for="name">Your name</label>

			<input class="form-field__control" id="name" name="name" type="text" autocomplete="name" required />
		</div>

		<div class="form-field">
			<label class="form-field__label" for="organisation">
				Organisation
				<span class="form-field__optional">(optional)</span>
			</label>

			<input
				class="form-field__control"
				id="organisation"
				name="organisation"
				type="text"
				autocomplete="organization"
			/>
		</div>
	</div>
	<div class="contact-form__row">
		<div class="form-field">
			<label class="form-field__label" for="email">Email address</label>

			<input class="form-field__control" id="email" name="email" type="email" autocomplete="email" required />
		</div>

		<div class="form-field">
			<label class="form-field__label" for="phone">
				Phone
				<span class="form-field__optional">(optional)</span>
			</label>
			<p class="form-field__hint" id="phone-hint">Include your country code.</p>
			<input
				class="form-field__control"
				id="phone"
				name="phone"
				type="tel"
				autocomplete="tel"
				aria-describedby="phone-hint"
			/>
		</div>
	</div>

	<div class="form-field">
		<label class="form-field__label" for="topic">What can we help with?</label>

		<select class="form-field__control" id="topic" name="topic" required>
			<option value="">Choose one</option>
			<option value="Media relations">Media relations</option>
			<option value="Digital &amp; social">Digital &amp; social</option>
			<option value="Crisis &amp; reputation">Crisis &amp; reputation</option>
			<option value="Issues advocacy">Issues advocacy</option>
			<option value="Podcasts &amp; audio">Podcasts &amp; audio</option>
			<option value="Film &amp; explainers">Film &amp; explainers</option>
			<option value="Design &amp; development">Design &amp; development</option>
			<option value="Not sure yet">Not sure yet</option>
		</select>
	</div>

	<div class="form-field">
		<label class="form-field__label" for="referral">
			Were you referred to us?
			<span class="form-field__optional">(optional)</span>
		</label>

		<select class="form-field__control" id="referral" name="referral">
			<option value="">Choose one</option>
			<option value="A law firm">A law firm</option>
			<option value="Another agency">Another agency</option>
			<option value="A client">A client</option>
			<option value="Search">Search</option>
			<option value="Press">Press</option>
			<option value="Other">Other</option>
		</select>
	</div>

	<div class="form-field">
		<label class="form-field__label" for="message">Tell us what’s happening</label>
		<p class="form-field__hint" id="message-hint">
			Share as much or as little as you’re comfortable with. If it’s highly sensitive, just leave a safe way to
			reach you and we’ll call.
		</p>
		<textarea
			class="form-field__control"
			id="message"
			name="message"
			rows="6"
			required
			aria-describedby="message-hint"
		></textarea>
	</div>
	<div class="form-check">
		<input class="form-check__input" id="consent" name="consent" type="checkbox" required />
		<label class="form-check__label" for="consent">
			I agree to Parley storing my details to respond to this enquiry.
		</label>
	</div>
	<button class="button button--solid contact-form__submit" type="submit">Send message</button>
</form>

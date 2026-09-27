<?php

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

if ( get_stylesheet() !== 'parley' ) {
	switch_theme( 'parley' );
	echo "theme: switched to parley\n";
}

function parley_seed_attachment( $filename, $alt ) {
	$existing = get_posts( [
		'meta_key'    => '_parley_seed_file',
		'meta_value'  => $filename,
		'numberposts' => 1,
		'post_status' => 'any',
		'post_type'   => 'attachment',
	] );

	if ( $existing ) {
		return (int) $existing[0]->ID;
	}

	$tmp = wp_tempnam( $filename );
	copy( __DIR__ . '/img/' . $filename, $tmp );

	$id = media_handle_sideload( [ 'name' => $filename, 'tmp_name' => $tmp ], 0 );

	if ( is_wp_error( $id ) ) {
		@unlink( $tmp );
		echo "media FAILED {$filename}: " . $id->get_error_message() . "\n";
		return 0;
	}

	update_post_meta( $id, '_parley_seed_file', $filename );
	update_post_meta( $id, '_wp_attachment_image_alt', $alt );

	return (int) $id;
}

function parley_seed_post( $type, $slug, $args, $meta = [], $thumb = 0 ) {
	$found = get_page_by_path( $slug, OBJECT, $type );
	$args  = array_merge( [ 'post_name' => $slug, 'post_status' => 'publish', 'post_type' => $type ], $args );

	if ( $found ) {
		$args['ID'] = $found->ID;
		$id         = wp_update_post( $args );
		$created    = 0;
	} else {
		$id      = wp_insert_post( $args );
		$created = 1;
	}

	foreach ( $meta as $key => $value ) {
		update_post_meta( $id, $key, $value );
	}

	if ( $thumb ) {
		set_post_thumbnail( $id, $thumb );
	}

	return [ (int) $id, $created ];
}

function parley_seed_menu( $name, $items ) {
	$menu = wp_get_nav_menu_object( $name );
	$id   = $menu ? $menu->term_id : wp_create_nav_menu( $name );

	if ( ! wp_get_nav_menu_items( $id ) ) {
		foreach ( $items as $item ) {
			wp_update_nav_menu_item( $id, 0, $item + [ 'menu-item-status' => 'publish' ] );
		}
	}

	return $id;
}

$alts = [
	'about-meeting.jpg'             => 'Journalists and speakers in conversation at a press event',
	'hero-westminster.jpg'          => 'Westminster at dusk seen from across the river',
	'panel-phone.jpg'               => 'A hand holding a phone showing social media apps',
	'post-boardroom.jpg'            => 'An empty boardroom at night with one chair pulled out',
	'post-committee.jpg'            => 'A parliamentary committee room',
	'post-containers.jpg'           => 'A container port at dawn',
	'post-keyboard.jpg'             => 'Hands on a keyboard with a screen reader visible',
	'post-microphone.jpg'           => 'A studio microphone in soft light',
	'post-newspaper.jpg'            => 'A newspaper opinion page with a pen resting on it',
	'post-notifications.jpg'        => 'A phone screen with blurred notifications',
	'post-press.jpg'                => 'A silhouette in front of a window wearing a press lanyard',
	'post-social-apps.jpg'          => 'Close-up of social media app icons on a phone screen',
	'region-africa.jpg'             => 'A senior public figure in West Africa',
	'region-asia.jpg'               => 'A crowd at a peaceful rally with one raised hand in focus',
	'region-europe.jpg'             => 'A candlelit vigil outside a court building in Central Europe',
	'region-latin-america.jpg'      => 'An Andean landscape in Colombia',
	'region-middle-east.jpg'        => 'A port construction site at dusk in the Levant',
	'team-eleanor-marsh.jpg'        => 'Portrait of Eleanor Marsh',
	'team-kasia-nowak.jpg'          => 'Portrait of Kasia Nowak',
	'team-priya-raman.jpg'          => 'Portrait of Priya Raman',
	'team-tunde-adeyemi-clarke.jpg' => 'Portrait of Tunde Adeyemi-Clarke',
];

$img = [];
foreach ( $alts as $file => $alt ) {
	$img[ $file ] = parley_seed_attachment( $file, $alt );
}
echo 'media: ' . count( array_filter( $img ) ) . " attachments ready\n";

$created_pages = 0;

$about_body = <<<'HTML'
<p>We started Parley because we kept meeting the same kind of client. A foundation with a strong case and no one listening. A family business caught in someone else's political fight. A campaigner whose name was being dragged through papers they had never read.</p>
<p>They had usually tried a big agency and been passed to a junior team within a month. Or they had tried a digital shop that built them a beautiful website nobody visited. Or they had hired lobbyists who secured meetings but never changed the headlines.</p>
<p>We built Parley to do all three jobs properly, with one senior team, in one campaign. We avoid breathless marketing language. We give our clients a clear, credible voice, put them in front of the audiences that matter, and make their case in every channel available.</p>
HTML;

$story_apart = <<<'HTML'
<p>London is full of PR agencies, digital studios and public affairs consultancies, and plenty of them are very good. What makes Parley different is the balance.</p>
<p>A traditional PR agency will chase the front page and the <em>Today</em> programme. A strong digital studio will build an excellent website, then leave you to fill it and find its audience. A public affairs firm will fill your diary with meetings in Westminster and Brussels, and send a thin clippings report.</p>
<p>We do all three, and we make each one feed the others. The interview drives traffic to the explainer. The explainer gives the MP something to share. The MP's question becomes tomorrow's news.</p>
HTML;

$story_not_for = <<<'HTML'
<p>If you want to be on breakfast television tomorrow to launch a new product, we're probably not your agency.</p>
<p>If you need to raise awareness of an issue that matters, build a profile as a serious voice in your field, or answer a campaign of misleading claims about you, we have the right mix of media, digital and advocacy experience to help.</p>
HTML;

$story_boutique = <<<'HTML'
<p><strong>Parley is small, and that's deliberate.</strong></p>
<p>We take on a limited number of clients and causes, and we only take ones we believe in. Many come to us through international law firms and other agencies. Others come directly: entrepreneurs, charities, campaigning groups and public figures.</p>
<p>Our job is more than posting on social media and sending press releases. We bring ideas and strategy that help clients shape outcomes, whether that's a court of public opinion, a parliamentary committee or a boardroom.</p>
<p>What that means in practice:</p>
<ul>
<li><strong>A partner on every account.</strong> The person who pitched you runs your campaign.</li>
<li><strong>Phones answered at 11pm.</strong> Crises don't keep office hours and neither do we.</li>
<li><strong>One team, one plan.</strong> Media, digital and public affairs sit in the same meeting.</li>
<li><strong>Honest advice.</strong> If an idea won't work, we'll say so before you pay for it.</li>
</ul>
<p>Meet our founder, Eleanor Marsh, and the rest of the team.</p>
HTML;

$story_standards = <<<'HTML'
<p>Parley works to the Chartered Institute of Public Relations (CIPR) Code of Conduct and the PRCA Professional Charter. We declare our clients where the law or the setting requires it, including on the UK Register of Consultant Lobbyists where applicable. We don't run anonymous attack campaigns, we don't use fake accounts, and we don't knowingly mislead journalists.</p>
HTML;

$credits_content = sprintf(
	<<<'HTML'
<div class="credits-table container">
<p class="credits-table__intro">Photography on this site comes from Wikimedia Commons and is used under the licences below. Images may be cropped, resized or converted to greyscale.</p>
<section class="credits-table__scroll" aria-labelledby="credits-caption" tabindex="0">
<table>
<caption id="credits-caption" class="visually-hidden">Image credits</caption>
<thead>
<tr><th scope="col"><span class="visually-hidden">Preview</span></th><th scope="col">Image</th><th scope="col">Author</th><th scope="col">Licence</th></tr>
</thead>
<tbody>
<tr><td><img src="%s" alt="" width="96" height="64" loading="lazy" /></td><td><a href="https://commons.wikimedia.org/wiki/File:Journalists_-_Press_Conference_-_Bengali_Wikipedia_10th_Anniversary_Celebration_-_Kolkata_2015-01-02_2254.JPG" rel="noopener">Journalists - Press Conference - Bengali Wikipedia 10th Anniversary Celebration - Kolkata 2015-01-02 2254.JPG</a></td><td>Biswarup Ganguly</td><td>CC BY 3.0</td></tr>
</tbody>
</table>
</section>
</div>
HTML,
	esc_url( (string) wp_get_attachment_image_url( $img['about-meeting.jpg'], 'medium' ) )
);

$placeholder_legal = <<<'HTML'
<p>This page is a placeholder. The final policy will be published before launch.</p>
HTML;

[ $front_id, $c ]   = parley_seed_post( 'page', 'home', [ 'post_title' => 'Home' ], [
	'approach_body'    => 'Parley is a London communications agency for clients caught up in complex international issues. We run media campaigns, build engaged online communities, handle reputational attack and make the case to policymakers, usually all at once. Every account is led by a senior partner who stays on it. No hand-offs to junior staff, no recycled press releases, no hype.',
	'approach_heading' => 'A different kind of agency',
	'hero_line_1'      => 'Earn trust.',
	'hero_line_2'      => 'Win the argument.',
], $img['hero-westminster.jpg'] );
$created_pages += $c;

[ $about_id, $c ] = parley_seed_post( 'page', 'about', [ 'post_content' => '', 'post_title' => 'About' ], [
	'subtitle'     => 'Because the story will be told either way',
	'intro_lead'   => 'Parley is a London communications agency. We run media relations, digital and social campaigns, crisis and reputation work, public affairs, podcasts, film and web design for clients facing complex international political and business issues. Our team has worked in more than 30 countries across Africa, Asia, Europe, Latin America and the Middle East.',
	'intro_body'   => $about_body,
	'venn_heading' => 'Where PR, digital and diplomacy meet',
	'venn_label_1' => 'Media relations',
	'venn_label_2' => 'Digital campaigns',
	'venn_label_3' => 'International public affairs',
	'venn_caption' => 'Most agencies are strong in one circle. We work in the overlap.',
	'story'        => [
		[ 'heading' => 'What sets us apart', 'body' => $story_apart ],
		[ 'heading' => "Who we're not for", 'body' => $story_not_for ],
		[ 'heading' => 'The benefits of a boutique agency', 'body' => $story_boutique ],
		[ 'heading' => 'Our standards', 'body' => $story_standards ],
	],
	'values'       => [
		[ 'title' => 'Straight talk', 'text' => 'We tell clients what they need to hear, not what they want to hear.' ],
		[ 'title' => 'Senior hands', 'text' => 'The people you meet are the people who do the work.' ],
		[ 'title' => 'On the record', 'text' => "Everything we do, we'd be comfortable defending in public." ],
	],
], $img['about-meeting.jpg'] );
$created_pages += $c;

[ $contact_id, $c ] = parley_seed_post( 'page', 'contact', [ 'post_title' => 'Contact' ], [
	'subtitle' => "Tell us what's happening",
] );
$created_pages += $c;

[ $dispatches_id, $c ] = parley_seed_post( 'page', 'dispatches', [ 'post_title' => 'Dispatches' ], [
	'subtitle' => 'Notes from the Parley team on international affairs, media, digital campaigning and reputation. Written by practitioners, for people who have to make the call.',
] );
$created_pages += $c;

[ $credits_id, $c ] = parley_seed_post( 'page', 'image-credits', [ 'post_content' => $credits_content, 'post_title' => 'Image credits' ] );
$created_pages += $c;

[ $privacy_id, $c ] = parley_seed_post( 'page', 'privacy', [ 'post_content' => $placeholder_legal, 'post_title' => 'Privacy Policy' ] );
$created_pages += $c;

[ $cookies_id, $c ] = parley_seed_post( 'page', 'cookies', [ 'post_content' => $placeholder_legal, 'post_title' => 'Cookie Policy' ] );
$created_pages += $c;

[ $accessibility_id, $c ] = parley_seed_post( 'page', 'accessibility', [ 'post_content' => $placeholder_legal, 'post_title' => 'Accessibility Statement' ] );
$created_pages += $c;

echo "pages: {$created_pages} created\n";

$services = [
	'media-relations' => [
		'cta_heading' => 'Got a story that needs telling?',
		'icon'        => 'microphone',
		'intro'       => <<<'HTML'
<p>Good coverage isn't luck, and it isn't volume. It's the right story, in the right outlet, told by the right person at the right moment.</p>
<p>We work with editors, producers and correspondents at national, international and specialist titles, from the <em>Financial Times</em> and the BBC World Service to regional broadcasters in Nairobi, São Paulo and Warsaw. We know what they need because several of us used to do their jobs.</p>
<p>Our media relations work covers features, interviews, broadcast appearances, profiles, op-eds, briefings and on-the-record comment, in English, Spanish, Portuguese, French and Polish.</p>
HTML,
		'faqs'        => [
			[ 'question' => 'Can you guarantee coverage?', 'answer' => 'No, and anyone who does is selling advertising. We can guarantee a story worth telling, pitched to the right people, and honest reporting on what landed.' ],
			[ 'question' => 'Do you only work with UK media?', 'answer' => 'No. Around half of our placements are outside the UK. We work with trusted partners in markets where local relationships matter.' ],
			[ 'question' => 'How soon can you start?', 'answer' => 'For urgent matters, the same day. For a planned campaign, allow two weeks for research and message development.' ],
		],
		'included'    => [
			[ 'item' => "Media audit: how you're covered now, by whom, and why" ],
			[ 'item' => 'Message development and a single, sharp narrative' ],
			[ 'item' => 'Targeted pitching to national, international and trade media' ],
			[ 'item' => 'Op-ed and long-read drafting and placement' ],
			[ 'item' => 'Press briefings and background sessions with correspondents' ],
			[ 'item' => 'Media training for spokespeople, including hostile interview practice' ],
			[ 'item' => 'Rapid-response comment on breaking stories' ],
			[ 'item' => 'Monthly reporting that tracks outcomes, not just clippings' ],
		],
		'panel'       => [
			[ 'heading' => "Why press releases don't work any more", 'body' => '<p>Newsrooms are smaller than they were 10 years ago, and journalists receive hundreds of pitches a week. Most go unread. The ones that land share three things: they offer something new, they come from someone the journalist trusts, and they\'re relevant to a conversation already happening.</p><p>A campaign built on self-promotional announcements will struggle, however much you spend. A campaign that brings evidence, access or a genuinely new angle to a live debate can earn coverage no advertising budget could buy.</p>' ],
			[ 'heading' => 'How Parley is different', 'body' => '<p>We don\'t blast lists. We pitch a small number of journalists we know, with stories built for them. We prepare our clients properly, so the interview goes the way it should. And we measure results by what changed (a correction, a policy question, a new supporter), not by column inches.</p><p>The partner who shapes your story is the one who calls the newsroom.</p>' ],
		],
		'steps'       => [
			[ 'title' => 'Listen.', 'text' => "We learn your issue, your audiences and what's been said about you." ],
			[ 'title' => 'Find the story.', 'text' => 'We shape the angle a journalist will actually want.' ],
			[ 'title' => 'Place it.', 'text' => 'We pitch the few outlets that matter and prepare your spokespeople.' ],
			[ 'title' => 'Build on it.', 'text' => 'We turn each piece of coverage into digital content, briefings and the next story.' ],
		],
		'summary'     => 'We work with editors, broadcast producers and correspondents across the UK, Europe and beyond to secure features, interviews, profiles and comment for our clients. A media campaign works best when it adds something to a public debate, not when it pushes self-promotion. So we find the story a journalist actually wants, and make sure our client is the best person to tell it.',
		'tagline'     => 'Coverage that adds to the debate',
		'title'       => 'Media Relations',
	],
	'digital-social' => [
		'cta_heading' => 'Want an audience that actually listens?',
		'icon'        => 'share',
		'intro'       => <<<'HTML'
<p>An online audience is only worth having if it listens, trusts you and does something when you ask.</p>
<p>We plan and run social and digital campaigns for NGOs, foundations, businesses and public figures working on difficult international issues. That means strategy, content, community management, influencer and partner outreach, paid amplification and the reporting to show what worked.</p>
<p>We work on LinkedIn, X, Instagram, YouTube, TikTok, WhatsApp channels and Telegram, and on the regional platforms that matter in the markets our clients care about.</p>
HTML,
		'faqs'        => [
			[ 'question' => 'Will you buy followers or use bots?', 'answer' => "Never. It breaches platform rules, it damages trust and it's usually obvious to journalists. Everything we build is organic or clearly paid." ],
			[ 'question' => 'Can you take over our existing channels?', 'answer' => "Yes. We'll audit what's there, keep what works and fix what doesn't. You keep full ownership and admin access at all times." ],
			[ 'question' => 'Do you work in languages other than English?', 'answer' => 'Yes: Spanish, Portuguese, French and Polish in-house, and trusted native-speaker partners for Arabic, Swahili, Thai and Bahasa.' ],
		],
		'included'    => [
			[ 'item' => 'Audit of your channels, audience and competitors' ],
			[ 'item' => 'Channel strategy and a realistic content plan' ],
			[ 'item' => 'Content creation: copy, graphics, short video, carousels, threads' ],
			[ 'item' => 'Community management and moderation, including out of hours' ],
			[ 'item' => 'Partner, creator and coalition outreach' ],
			[ 'item' => 'Paid social planning, targeting and optimisation' ],
			[ 'item' => 'Social listening and early warning for emerging risks' ],
			[ 'item' => 'Monthly insight reports with clear recommendations' ],
		],
		'panel'       => [
			[ 'heading' => "What's a social media consultant actually for?", 'body' => '<p>For many organisations, social media is an afterthought. The platforms are free and any graduate seems confident enough to post on them, so the job goes to a junior member of staff with no communications background and even less time. A year later, the chief executive wonders why there are 800 followers, a handful of likes and no sign that anyone important is paying attention.</p><p>So some organisations hire the big names. Plenty of large agencies will happily charge a hefty retainer, then pass the day-to-day work to their least experienced staff. The return is disappointing at best. At worst, a careless post becomes the story.</p>' ],
			[ 'heading' => 'How Parley is different', 'body' => '<p>We don\'t hand your account to the most junior person in the building. Good social media needs a clear strategy, well-crafted content and a voice people believe. Communities don\'t want to be broadcast at; they want a conversation. Humour, irony and the occasional controversy all have their place, but they need senior judgement.</p><p>There\'s no shortcut. You can\'t buy your way to a trusted audience. It takes a team that works at it, day by day and sometimes hour by hour.</p>' ],
		],
		'steps'       => [
			[ 'title' => 'Audit.', 'text' => "Where you are, who's listening and who isn't." ],
			[ 'title' => 'Plan.', 'text' => 'A strategy with measurable goals and a content calendar.' ],
			[ 'title' => 'Run.', 'text' => 'Daily publishing and community management by senior staff.' ],
			[ 'title' => 'Learn.', 'text' => 'Monthly reviews that change what we do next.' ],
		],
		'summary'     => "Followers are easy to buy. Attention isn't. We build online communities that care about an issue, trust the voice behind it and act when asked. Strategy, content, community management and paid amplification, all run by senior people who understand that a single careless post can undo a year of good press.",
		'tagline'     => 'Build communities that talk back',
		'title'       => 'Digital & Social',
	],
	'crisis-reputation' => [
		'cta_heading' => 'Facing a difficult story?',
		'icon'        => 'shield',
		'intro'       => <<<'HTML'
<p>A crisis rarely arrives with notice. A journalist emails at 6pm with a 10am deadline. A leaked document starts circulating. A foreign government puts your name in a press statement. What you do in the next 48 hours shapes how you're seen for years.</p>
<p>We advise organisations and individuals facing allegations, litigation, investigations, political attack, activist campaigns and online disinformation. We work closely with legal teams, so every public word is accurate, defensible and consistent with the case.</p>
HTML,
		'faqs'        => [
			[ 'question' => 'Will our conversation be confidential?', 'answer' => 'Yes. We sign NDAs as standard and, where appropriate, work under instruction from your solicitors.' ],
			[ 'question' => 'How quickly can you respond?', 'answer' => 'Within the hour, any day of the year. Call the number on our contact page.' ],
			[ 'question' => 'Can you get a story taken down?', 'answer' => "We can get factual errors corrected and, working with your lawyers, pursue legitimate complaints. We don't use intimidation or fake reviews, and we won't pretend accurate reporting is false." ],
		],
		'included'    => [
			[ 'item' => '24/7 crisis response with a named senior lead' ],
			[ 'item' => 'Holding statements, Q&A and reactive lines, agreed with counsel' ],
			[ 'item' => 'Journalist handling and correction requests' ],
			[ 'item' => 'Litigation communications alongside legal teams' ],
			[ 'item' => 'Monitoring across press, broadcast, social and messaging channels' ],
			[ 'item' => 'Disinformation response, including evidence packs for platforms and press' ],
			[ 'item' => 'Crisis preparedness: risk audits, playbooks and simulation exercises' ],
			[ 'item' => 'Reputation recovery: search, narrative and stakeholder rebuilding' ],
		],
		'panel'       => [
			[ 'heading' => "Why silence isn't a strategy", 'body' => '<p>The instinct under attack is to say nothing and wait for it to pass. Sometimes that\'s right. More often, the gap is filled by your opponents, by speculation or by a search result that follows you for a decade.</p><p>The opposite mistake is just as costly: a rushed statement, an angry post, a spokesperson who hasn\'t been prepared. Good crisis work is about judgement, knowing when to speak, what to say, who should say it and where.</p>' ],
			[ 'heading' => 'How Parley is different', 'body' => '<p>A senior partner takes your call, day or night, and stays with you until it\'s over. We\'ve handled crises in courtrooms, parliaments and newsrooms on four continents, so we know how a story travels from a local paper in one country to a wire service and then into the inbox of your board, your bank and your regulator.</p><p>We also do the unglamorous work that stops the next crisis: preparation, scenario planning and rebuilding trust once the headlines move on.</p>' ],
		],
		'steps'       => [
			[ 'title' => 'Assess.', 'text' => 'Within hours: the facts, the risks, who is saying what.' ],
			[ 'title' => 'Contain.', 'text' => 'Agreed lines, prepared spokespeople, a clear chain of sign-off.' ],
			[ 'title' => 'Respond.', 'text' => 'Proactive and reactive media, digital and stakeholder work.' ],
			[ 'title' => 'Recover.', 'text' => 'Rebuilding trust and hardening you against the next one.' ],
		],
		'summary'     => 'When allegations surface, a story breaks or a campaign turns against you, the first 48 hours decide the next five years. We work alongside your lawyers to take control of the facts, respond with precision and rebuild trust with the audiences that matter. We also help clients prepare, so the worst day is one they\'ve rehearsed.',
		'tagline'     => 'Calm, fast and on the record',
		'title'       => 'Crisis & Reputation',
	],
	'issues-advocacy' => [
		'cta_heading' => 'Need to reach the people who decide?',
		'icon'        => 'flag',
		'intro'       => <<<'HTML'
<p>Some problems can't be solved in a newspaper. They're solved in a select committee, a ministry, a UN working group or the office of an adviser who has never heard of you.</p>
<p>We help clients make their case to decision-makers in London, Brussels, Geneva, Washington and capitals across the Global South. That means understanding who holds power on an issue, what they need to hear and who they'll listen to, then building a campaign that reaches them from several directions at once.</p>
HTML,
		'faqs'        => [
			[ 'question' => 'Are you registered lobbyists?', 'answer' => 'Where our work requires it, we register on the UK Register of Consultant Lobbyists and the EU Transparency Register, and we declare clients accordingly.' ],
			[ 'question' => 'Do you work outside the UK and EU?', 'answer' => 'Yes. We have run campaigns aimed at the African Union, the UN Human Rights Council, the US Congress and national governments in Latin America and Asia.' ],
			[ 'question' => 'Can you represent foreign governments?', 'answer' => "We assess each case individually and publish our policy on state clients. We don't work for governments that jail journalists or suppress peaceful opposition." ],
		],
		'included'    => [
			[ 'item' => 'Political and stakeholder mapping' ],
			[ 'item' => 'Policy research, briefing papers and evidence reports' ],
			[ 'item' => 'Parliamentary engagement: briefings, written questions, APPGs, committee evidence' ],
			[ 'item' => 'Engagement with government, embassies and multilateral bodies' ],
			[ 'item' => 'Coalition building with NGOs, academics, business and diaspora groups' ],
			[ 'item' => 'Opposition research and narrative analysis' ],
			[ 'item' => 'Field work and on-the-ground partner networks' ],
			[ 'item' => 'Integrated media and digital support for every advocacy push' ],
		],
		'panel'       => [
			[ 'heading' => "Why meetings alone aren't enough", 'body' => '<p>Plenty of consultancies can fill a diary with meetings. But a meeting with a parliamentarian who has read nothing about your issue, heard nothing from constituents and seen nothing in the press rarely changes anything.</p><p>Policymakers move when an issue is visible, credible and backed by people they respect. That takes evidence, media attention, public support and allies, all working together.</p>' ],
			[ 'heading' => 'How Parley is different', 'body' => '<p>We run the whole campaign, not just the meetings. Our research gives you the evidence. Our media work makes the issue visible. Our digital campaigns show public support. Our public affairs team puts it in front of the people who decide.</p><p>We\'ve run advocacy on land rights, press freedom, political detention, investment disputes and election integrity, from Westminster to West Africa.</p>' ],
		],
		'steps'       => [
			[ 'title' => 'Map.', 'text' => 'Who decides, who influences them and what they currently believe.' ],
			[ 'title' => 'Build the case.', 'text' => 'Evidence, messages and credible messengers.' ],
			[ 'title' => 'Surround the issue.', 'text' => 'Media, digital, allies and direct engagement, timed together.' ],
			[ 'title' => 'Hold the gains.', 'text' => 'Follow-up, monitoring and keeping the issue alive.' ],
		],
		'summary'     => 'Parley has run advocacy campaigns large and small, from Africa to Asia and Latin America. With experience in policy, stakeholder mapping, research and field work, we help clients make their case to parliaments, governments, multilateral bodies and the people who advise them.',
		'tagline'     => 'Making the case where policy is made',
		'title'       => 'Issues Advocacy',
	],
	'podcasts-audio' => [
		'cta_heading' => 'Got something worth listening to?',
		'icon'        => 'broadcast',
		'intro'       => <<<'HTML'
<p>No other medium gets 40 uninterrupted minutes of someone's attention. Podcast listeners choose what they hear, listen to the end and come back each week. For organisations with a complicated story, that's a rare opportunity.</p>
<p>We help clients use audio in three ways: as guests on the shows their audiences already trust, as hosts of their own series, and as a way to turn dense reports and research into something people will actually hear.</p>
HTML,
		'faqs'        => [
			[ 'question' => 'Do we need a studio?', 'answer' => 'No. We record remotely to broadcast quality, or in partner studios in London when it matters.' ],
			[ 'question' => 'How long before a podcast finds an audience?', 'answer' => 'Plan for a season of at least eight episodes. Guest appearances on established shows can reach an audience from day one.' ],
			[ 'question' => 'Can you do video podcasts?', 'answer' => 'Yes. We film for YouTube and cut short clips for social as standard.' ],
		],
		'included'    => [
			[ 'item' => 'Guest booking on relevant UK and international podcasts' ],
			[ 'item' => 'Guest preparation and talking points' ],
			[ 'item' => 'Branded series: concept, format, pilot and full production' ],
			[ 'item' => 'Host coaching and scripting' ],
			[ 'item' => 'Audio versions of reports, briefings and long reads' ],
			[ 'item' => 'Editing, sound design, artwork and show notes' ],
			[ 'item' => 'Distribution, promotion and audience growth' ],
			[ 'item' => 'Listener analytics and quarterly reviews' ],
		],
		'panel'       => [
			[ 'heading' => 'Why audio, why now?', 'body' => '<p>Podcast listening in the UK has grown year on year for a decade, and it\'s strongest among the audiences our clients most want to reach: policymakers, journalists, professionals and engaged younger people.</p><p>Yet most organisational podcasts fail. They\'re launched without a clear audience, run out of ideas by episode six and sound like a corporate video with the pictures removed.</p>' ],
			[ 'heading' => 'How Parley is different', 'body' => '<p>We start with the listener, not the microphone. Before anything is recorded we agree who the series is for, why they\'d choose it over everything else in their feed and how it serves your wider campaign.</p><p>We book guests who have something to say, prepare hosts properly and produce to broadcast standard with trusted audio partners. Then we promote every episode through press, social and the networks you already have.</p>' ],
		],
		'steps'       => [
			[ 'title' => 'Define.', 'text' => 'Audience, purpose and format.' ],
			[ 'title' => 'Pilot.', 'text' => 'One episode, tested and refined before launch.' ],
			[ 'title' => 'Produce.', 'text' => 'A season recorded, edited and scheduled.' ],
			[ 'title' => 'Promote.', 'text' => 'Every episode pushed through media, social and partners.' ],
		],
		'summary'     => 'Around half of UK adults now listen to podcasts, and they listen for longer than they read. We help organisations launch, produce and place audio that builds lasting trust: branded series, guest bookings on the right shows and audio versions of reports that would otherwise go unread.',
		'tagline'     => 'Long-form trust, straight into their ears',
		'title'       => 'Podcasts & Audio',
	],
	'film-explainers' => [
		'cta_heading' => 'Need to explain something complicated?',
		'icon'        => 'play',
		'intro'       => <<<'HTML'
<p>Every campaign has a lot of moving parts. The one people remember is usually a film.</p>
<p>Online audiences are flooded with content, messages and choices, and video is the format they're most likely to stop for, watch and share. We make animated explainers, short documentaries, interview films and social cuts that take complicated issues and make them clear, human and hard to ignore.</p>
HTML,
		'faqs'        => [
			[ 'question' => 'How long should an explainer be?', 'answer' => 'Usually 90 seconds to two and a half minutes. Short enough to finish, long enough to make the case.' ],
			[ 'question' => 'Can you film in difficult locations?', 'answer' => "Yes, with proper risk assessment, local fixers and duty of care for crews and contributors. We'll tell you honestly when a location isn't safe." ],
			[ 'question' => 'How long does a project take?', 'answer' => 'A typical animated explainer takes four to six weeks from brief to delivery. Faster turnarounds are possible for rapid-response work.' ],
		],
		'included'    => [
			[ 'item' => 'Concept, research and scriptwriting' ],
			[ 'item' => 'Animated explainers (2D motion graphics and illustration)' ],
			[ 'item' => 'Interview and documentary-style filming, in the UK and abroad' ],
			[ 'item' => 'Testimony films with sensitive handling of vulnerable contributors' ],
			[ 'item' => 'Editing, subtitling and translation' ],
			[ 'item' => 'Cut-downs for social platforms in every aspect ratio' ],
			[ 'item' => 'Distribution planning, press screenings and paid promotion' ],
			[ 'item' => 'Performance reporting' ],
		],
		'panel'       => [
			[ 'heading' => "Why most organisational videos don't get watched", 'body' => '<p>Too long. Too many messages. Filmed before anyone decided who it was for or where it would be seen. The result is a polished film with 300 views, most of them from staff.</p><p>A good explainer starts with one question the audience already has, and answers it better than anyone else.</p>' ],
			[ 'heading' => 'How Parley is different', 'body' => '<p>We\'re communicators first and film-makers second. Every script is written by people who understand your issue, your opponents\' arguments and what a journalist or policymaker will pick apart. We plan distribution before a frame is shot, so the finished film has somewhere to go on the day it launches.</p><p>We produce in-house for animation and edit, and work with trusted camera crews in more than 20 countries for location filming.</p>' ],
		],
		'steps'       => [
			[ 'title' => 'Brief.', 'text' => 'One audience, one question, one action.' ],
			[ 'title' => 'Script.', 'text' => 'Written, tested and signed off before production.' ],
			[ 'title' => 'Produce.', 'text' => 'Animation, filming and edit.' ],
			[ 'title' => 'Launch.', 'text' => 'Press, social, partners and paid, planned in advance.' ],
		],
		'summary'     => 'A complex issue explained in two minutes will travel further than a 40-page report. We script, produce and edit explainer films, short documentaries and social cuts that make difficult subjects clear, and we plan their distribution before a frame is shot.',
		'tagline'     => 'Two minutes that explain everything',
		'title'       => 'Film & Explainers',
	],
	'design-development' => [
		'cta_heading' => 'Need a site that works as hard as your campaign?',
		'icon'        => 'rocket',
		'intro'       => <<<'HTML'
<p>Your website is where every interview, post and briefing eventually sends people. If it's slow, confusing or out of date, all that effort leaks away.</p>
<p>Our in-house design and development team builds websites, campaign microsites, evidence hubs and interactive reports for organisations that need to be taken seriously. Clean design, responsive on every device, accessible to WCAG 2.2 AA and fast enough to hold up when a story breaks and traffic spikes.</p>
HTML,
		'faqs'        => [
			[ 'question' => 'Which platforms do you build on?', 'answer' => "Most often WordPress or a headless CMS, chosen for how your team will actually use it. We'll recommend what suits you, not what suits us." ],
			[ 'question' => 'Can you protect a site that may be targeted?', 'answer' => 'Yes. For clients in contested situations we build in DDoS protection, hardened hosting and monitoring from day one.' ],
			[ 'question' => 'Do you work with other agencies?', 'answer' => 'Yes, often on a white-label basis. Talk to us about partnership rates.' ],
		],
		'included'    => [
			[ 'item' => 'Discovery, information architecture and content strategy' ],
			[ 'item' => 'UX and visual design, including brand identity where needed' ],
			[ 'item' => 'Development on WordPress, headless CMS or static builds' ],
			[ 'item' => 'Accessibility to WCAG 2.2 AA and performance optimisation' ],
			[ 'item' => 'Multilingual sites, including right-to-left languages' ],
			[ 'item' => 'Online newsrooms, evidence libraries and petition tools' ],
			[ 'item' => 'Security hardening, DDoS protection and uptime monitoring' ],
			[ 'item' => 'Hosting, maintenance and support plans' ],
		],
		'panel'       => [
			[ 'heading' => "Why beautiful isn't enough", 'body' => '<p>Many excellent studios build impressive websites. Far fewer know what to put on them, or how to get the right people to visit. A campaign site needs clear arguments, credible evidence, a newsroom journalists can use and a way for supporters to act, all updated as the story moves.</p>' ],
			[ 'heading' => 'How Parley is different', 'body' => '<p>Our designers and developers sit next to our strategists and media team. Content, structure and design are planned together, so the site says what it needs to and ranks for the searches that matter.</p><p>We\'re faster and more cost-effective than most specialist studios, which is why several London PR agencies already send their own web projects to us.</p>' ],
		],
		'steps'       => [
			[ 'title' => 'Discover.', 'text' => 'Goals, audiences, content and technical needs.' ],
			[ 'title' => 'Design.', 'text' => 'Wireframes, then full designs, reviewed with you.' ],
			[ 'title' => 'Build.', 'text' => 'Developed, tested on real devices and populated with content.' ],
			[ 'title' => 'Launch and look after.', 'text' => 'Go live, monitor and keep improving.' ],
		],
		'summary'     => 'Our design and development team builds fast, accessible, well-designed websites and campaign microsites, made to carry a campaign rather than sit still. Responsive, secure, easy to update and built to handle a surge of traffic on the day the story breaks. Several London agencies already send their own web projects to us.',
		'tagline'     => 'Websites built to carry a campaign',
		'title'       => 'Design & Development',
	],
];

$service_ids     = [];
$created_services = 0;
$order            = 0;
foreach ( $services as $slug => $s ) {
	$order++;
	[ $id, $c ] = parley_seed_post( 'service', $slug, [ 'menu_order' => $order, 'post_title' => $s['title'] ], [
		'cta_heading' => $s['cta_heading'],
		'faqs'        => $s['faqs'],
		'icon'        => $s['icon'],
		'included'    => $s['included'],
		'intro'       => $s['intro'],
		'panel'       => $s['panel'],
		'panel_image' => $img['panel-phone.jpg'],
		'steps'       => $s['steps'],
		'summary'     => $s['summary'],
		'tagline'     => $s['tagline'],
	] );
	$service_ids[ $slug ] = $id;
	$created_services    += $c;
}
echo "services: {$created_services} created, " . count( $service_ids ) . " total\n";

$case_studies = [
	'land-reform-colombia' => [
		'approach'       => '<p>We started with the evidence, not the outrage. We built a short, sourced rebuttal and took it privately to the editors who had got it wrong, asking for corrections rather than picking public fights.</p><p>At the same time, we offered the institute\'s director to correspondents who cover land and conflict seriously, in English and Spanish. We produced a two-minute animated explainer that set out what the report actually proposed, and ran it across social channels in both languages with targeted promotion to journalists, academics and policymakers.</p>',
		'challenge'      => '<p>The institute had spent three years researching land restitution in rural Colombia. When its report came out, a handful of outlets in Colombia, Spain and the US reported it as a call to confiscate private farms. It wasn\'t. Within a week the distortion was the story, researchers were receiving threats and funders were asking questions.</p>',
		'client_line'    => 'A regional think tank, Bogotá',
		'coordinates'    => '4.71° N · 74.07° W',
		'duration'       => '6 months',
		'image'          => 'region-latin-america.jpg',
		'outcome'        => '<p>Three outlets published corrections or clarifications. The director gave 11 interviews to international media, including broadcast. The explainer passed 2.4 million views and was cited in a Colombian Senate debate. Two funders renewed their grants the following year.</p>',
		'quote'          => "Parley didn't just defend us. They made more people understand our research than we'd ever reached before.",
		'quote_attribution' => 'Director, regional think tank',
		'region'         => 'latin-america',
		'region_summary' => 'Latin America is where Parley began. Our founder reported from Buenos Aires and Madrid for a decade and speaks Spanish and Portuguese. We\'ve advised on high-profile disputes and campaigns in Colombia, Guatemala and Venezuela, represented foreign investors in Brazil and Chile, and helped research institutes get their work read beyond the region. Talk to us about our track record across the Americas.',
		'results'        => [
			[ 'figure' => '3', 'label' => 'corrections published' ],
			[ 'figure' => '11', 'label' => 'international interviews' ],
			[ 'figure' => '2.4m', 'label' => 'explainer views' ],
		],
		'services'       => [ 'media-relations', 'digital-social', 'film-explainers' ],
		'teaser'         => 'When a Colombian policy institute\'s research on land reform was misreported across three countries, we rebuilt the story from the evidence up. Within six weeks its director had been interviewed by major international broadcasters and newspapers, and three outlets had published corrections.',
		'title'          => 'Setting the record straight on land reform',
	],
	'due-process-west-africa' => [
		'approach'       => '<p>Working under instruction from his London solicitors, we framed the case around due process and the rule of law rather than personality. We briefed correspondents in Lagos, London and Brussels with the documented legal facts, prepared the client and his family for interviews, and published a bilingual case website with court documents and a timeline.</p><p>We arranged briefings for parliamentarians in the UK and European Parliament with an interest in the region, and supported the legal team\'s submissions to international bodies.</p>',
		'challenge'      => '<p>After leaving office, our client was charged with offences his lawyers believed were politically motivated. Pro-government media ran daily stories, and international coverage repeated the allegations without context. His legal team needed the case understood abroad, where it could influence diplomatic attention and the conduct of the trial.</p>',
		'client_line'    => 'A former state governor, West Africa',
		'coordinates'    => '9.08° N · 7.40° E',
		'duration'       => '14 months',
		'image'          => 'region-africa.jpg',
		'outcome'        => '<p>The case was covered fairly in 14 international outlets. Three parliamentary groups raised it with ministers. After 14 months, the principal charges were withdrawn.</p>',
		'quote'          => 'They understood the law as well as the headlines, and never once said anything my lawyers had to walk back.',
		'quote_attribution' => 'Client',
		'region'         => 'africa',
		'region_summary' => 'Our team has worked in Africa for more than 15 years combined, starting in Nigeria, where we\'ve advised public figures facing politically motivated prosecution. Working alongside legal teams, we\'ve helped reframe disputes around due process and waged international campaigns to restore reputations. We\'re also active across West, East and Southern Africa, where past clients include mining, energy, financial services and agriculture businesses.',
		'results'        => [
			[ 'figure' => '14', 'label' => 'international titles' ],
			[ 'figure' => '3', 'label' => 'parliamentary groups briefed' ],
			[ 'figure' => 'Charges', 'label' => 'withdrawn' ],
		],
		'services'       => [ 'crisis-reputation', 'media-relations', 'issues-advocacy' ],
		'teaser'         => 'Facing politically motivated charges, our client was losing the story at home and abroad. Working alongside his legal team, we reframed the case around due process and the rule of law, secured fair coverage in 14 international titles and briefed three parliamentary groups in London and Brussels.',
		'title'          => 'Due process, not politics',
	],
	'press-freedom-central-europe' => [
		'approach'       => '<p>We rebuilt the campaign\'s digital presence around the journalist\'s own reporting, letting his work make the case for him. We launched a campaign microsite with a petition, recruited journalists and press freedom groups in eight countries to share it, and ran a weekly countdown of days in detention across social channels.</p><p>In parallel, we identified the officials preparing the summit and made sure the case reached them through their own parliaments, press and embassies.</p>',
		'challenge'      => '<p>A small foundation was campaigning for the release of a journalist held on vague national security charges. It had passionate supporters and strong arguments, but its audience barely reached beyond the NGO world. A foreign ministers\' summit was five months away.</p>',
		'client_line'    => 'A human rights foundation, Central Europe',
		'coordinates'    => '52.23° N · 21.01° E',
		'duration'       => '5 months',
		'image'          => 'region-europe.jpg',
		'outcome'        => '<p>The foundation\'s audience grew from 4,000 to 61,000 in five months, and the petition gathered 38,000 signatures. Two foreign ministers raised the case publicly at the summit. The journalist was moved to house arrest six weeks later.</p>',
		'quote'          => 'For the first time, people outside our bubble knew his name.',
		'quote_attribution' => 'Campaign director',
		'region'         => 'europe',
		'region_summary' => 'Parley has more than a decade of experience advising law firms, companies, foundations and individuals across Europe, including in Poland, Hungary, France, Italy, Spain and the Baltic states. We\'ve campaigned for jailed journalists, supported prominent business leaders in politically charged litigation and helped NGOs build their online presence and win support from the audiences that matter.',
		'results'        => [
			[ 'figure' => '4,000 to 61,000', 'label' => 'followers in five months' ],
			[ 'figure' => '38,000', 'label' => 'petition signatures' ],
			[ 'figure' => 'Raised', 'label' => "at a foreign ministers' summit" ],
		],
		'services'       => [ 'digital-social', 'issues-advocacy', 'design-development' ],
		'teaser'         => 'A foundation defending a jailed journalist needed to be heard beyond the usual NGO circles. We built a digital campaign that grew its audience from 4,000 to 61,000 in five months and put the case in front of foreign ministers ahead of a key summit.',
		'title'          => 'A voice for a jailed journalist',
	],
	'infrastructure-levant' => [
		'approach'       => '<p>We audited what had been published and separated fair criticism from misleading claims. With the group\'s lawyers, we built a clear factual record and an English-language project site setting out its environmental, labour and governance standards.</p><p>We arranged 12 private briefings with trade journalists and lender advisers, and prepared the family\'s second generation to speak for the business in English for the first time.</p>',
		'challenge'      => '<p>The group was in international arbitration with a former partner, who was feeding unflattering stories to European trade press. The client was simultaneously seeking financing for a new port project from European lenders, who were starting to ask questions.</p>',
		'client_line'    => 'A family-owned infrastructure group, the Levant',
		'coordinates'    => '33.89° N · 35.50° E',
		'duration'       => '9 months',
		'image'          => 'region-middle-east.jpg',
		'outcome'        => '<p>The misleading claims stopped appearing in new coverage. Lender due diligence closed without further communications queries, and financing was approved.</p>',
		'quote'          => "We had always let our work speak for itself. Parley showed us that isn't enough any more.",
		'quote_attribution' => 'Deputy chief executive',
		'region'         => 'middle-east',
		'region_summary' => 'In the Middle East, much of our work is quiet by design. We\'ve supported family businesses and investors through international arbitration, helped companies explain their record to European lenders and export-credit agencies, and advised civil society groups on engaging the foreign press safely. We work with Arabic-speaking partners and understand how a story in one Gulf capital lands in London and Brussels.',
		'results'        => [
			[ 'figure' => 'Financing', 'label' => 'approved' ],
			[ 'figure' => '0', 'label' => 'negative lender queries after launch' ],
			[ 'figure' => '12', 'label' => 'private briefings' ],
		],
		'services'       => [ 'crisis-reputation', 'media-relations', 'design-development' ],
		'teaser'         => 'A family-owned infrastructure group in international arbitration needed European lenders to hear its side of the story. We built the factual record, briefed the trade press and prepared a new generation of the family to speak for the business.',
		'title'          => 'Explaining a project to European lenders',
	],
	'civil-society-south-east-asia' => [
		'approach'       => '<p>We ran in-person and remote media training for 22 spokespeople across four cities, including hostile interview practice and safe handling of sensitive sources. We built a shared message framework, a rapid-response protocol for arrests or smears, and a verified contact list of foreign correspondents. We also set up basic digital security for their accounts.</p>',
		'challenge'      => '<p>A coalition of civic groups expected intense international attention ahead of a contested election, and a real risk of arrests and online smears. Its members were brave and articulate but had little experience of foreign media or coordinated digital security.</p>',
		'client_line'    => 'A civil society coalition, South East Asia',
		'coordinates'    => '13.76° N · 100.50° E',
		'duration'       => '4 months',
		'image'          => 'region-asia.jpg',
		'outcome'        => '<p>The protocol was triggered twice before polling day, once after a leader was detained and once after a coordinated smear campaign. Both times the coalition responded within two hours with a single, consistent voice, and was quoted accurately in international coverage.</p>',
		'quote'          => 'When the worst happened, we already knew what to do.',
		'quote_attribution' => 'Coalition spokesperson',
		'region'         => 'asia',
		'region_summary' => 'Our Asia work runs from corporate communications to pro bono human rights campaigns. Ahead of one contested election, we trained a pro-democracy coalition\'s spokespeople in social media and media strategy and built a protocol for dealing with the foreign press. We\'ve also advised clients on litigation-related disputes from Japan to Malaysia and Cambodia.',
		'results'        => [
			[ 'figure' => '22', 'label' => 'spokespeople trained' ],
			[ 'figure' => '4', 'label' => 'cities' ],
			[ 'figure' => 'Twice', 'label' => 'protocol used before polling day' ],
		],
		'services'       => [ 'media-relations', 'digital-social', 'crisis-reputation' ],
		'teaser'         => 'Ahead of a contested election, a pro-democracy coalition asked us to prepare its spokespeople for the foreign press. We trained 22 members across four cities and designed a crisis protocol they used twice before polling day.',
		'title'          => 'Ready for the foreign press',
	],
];

$created_cases = 0;
$order         = 0;
foreach ( $case_studies as $slug => $cs ) {
	$order++;
	[ $id, $c ] = parley_seed_post( 'case_study', $slug, [ 'menu_order' => $order, 'post_title' => $cs['title'] ], [
		'approach'          => $cs['approach'],
		'challenge'         => $cs['challenge'],
		'client_line'       => $cs['client_line'],
		'coordinates'       => $cs['coordinates'],
		'duration'          => $cs['duration'],
		'outcome'           => $cs['outcome'],
		'quote'             => $cs['quote'],
		'quote_attribution' => $cs['quote_attribution'],
		'region'            => $cs['region'],
		'region_summary'    => $cs['region_summary'],
		'results'           => $cs['results'],
		'services'          => array_map( fn ( $s ) => $service_ids[ $s ], $cs['services'] ),
		'teaser'            => $cs['teaser'],
	], $img[ $cs['image'] ] );
	$created_cases += $c;
}
echo "case studies: {$created_cases} created, " . count( $case_studies ) . " total\n";

$team = [
	'eleanor-marsh' => [
		'content'   => '<p>Eleanor began her career as a correspondent for an international news agency, reporting from Madrid and then Buenos Aires, where she covered elections, debt crises and human rights trials across South America. She joined a global PR firm in London in 2012, leading its Latin America practice and advising energy, mining and financial clients in disputes across the region.</p><p>She left to start Parley after realising the clients she most wanted to help, those with strong cases and weak voices, rarely fitted a big agency\'s model. She holds an MA in Latin American Studies from a London university and has taught crisis communications to postgraduate students.</p><p>Outside work Eleanor sails badly, reads Latin American fiction in the original and is learning Polish, very slowly.</p>',
		'languages' => 'English, Spanish, Portuguese',
		'lead'      => "Eleanor Marsh founded Parley in 2019. She has 20 years' experience in international media relations, crisis communications and advocacy, advising clients in the legal, political, corporate and non-profit worlds.",
		'name'      => 'Eleanor Marsh',
		'role'      => 'Founder & Managing Partner',
	],
	'tunde-adeyemi-clarke' => [
		'content'   => '<p>Tunde started as a researcher for a Member of Parliament on the International Development Committee, then spent five years at a Westminster public affairs consultancy. He later moved to Abuja to advise a governance NGO on election monitoring and media, before returning to London to join Parley as its first partner in 2020.</p><p>He has briefed parliamentarians in London, Brussels and Abuja, prepared evidence for select committees and advised clients through high-profile political prosecutions. He is a trustee of a small charity supporting young African journalists.</p>',
		'languages' => 'English, Yoruba, French',
		'lead'      => "Tunde leads Parley's public affairs work and our Africa practice. He has spent 15 years at the meeting point of politics, law and media in London and West Africa.",
		'name'      => 'Tunde Adeyemi-Clarke',
		'role'      => 'Partner, Public Affairs & Africa',
	],
	'priya-raman' => [
		'content'   => '<p>Priya spent eight years as a broadcast journalist, first in Kuala Lumpur and then on a London newsdesk, before moving into crisis communications at a specialist litigation PR firm. She has handled investigations, product recalls, political attacks and disinformation campaigns for clients in Asia, Europe and the Gulf.</p><p>She leads our media training and has prepared chief executives, campaigners and politicians for some of the toughest interviews of their lives. She also runs Parley\'s pro bono work with civil society groups in South East Asia.</p>',
		'languages' => 'English, Tamil, Malay',
		'lead'      => "Priya runs our crisis practice. When the phone rings late at night, it's usually her who answers it.",
		'name'      => 'Priya Raman',
		'role'      => 'Director, Crisis & Asia',
	],
	'kasia-nowak' => [
		'content'   => '<p>Born in Gdańsk and raised in Manchester, Kasia ran digital campaigns for an international press freedom organisation for six years, growing its audience tenfold and launching an award-shortlisted podcast. She then led social strategy for a European political foundation before joining Parley in 2021.</p><p>She is fluent in the data and the platforms, but her real skill is tone: knowing when to be serious, when to be funny and when to say nothing at all.</p>',
		'languages' => 'English, Polish, German',
		'lead'      => 'Kasia leads our digital, social and podcast work. She builds online communities that care about difficult issues and stick around.',
		'name'      => 'Kasia Nowak',
		'role'      => 'Director, Digital & Audio',
	],
	'rafael-duarte' => [
		'content'   => '<p>Rafael trained as a graphic designer in Lisbon and spent a decade as a front-end developer and design lead at digital studios in Lisbon and London, working for newspapers, universities and charities. He specialises in accessible, fast and secure sites for organisations that may be targeted by hostile actors.</p><p>He runs a monthly accessibility clinic for charities and still insists on sketching every site on paper first.</p>',
		'languages' => 'English, Portuguese, Spanish',
		'lead'      => "Rafael leads the team that designs and builds our clients' websites, campaign microsites and interactive reports.",
		'name'      => 'Rafael Duarte',
		'role'      => 'Head of Design & Development',
	],
	'oliver-grant' => [
		'content'   => '<p>Oliver joined Parley in 2022 after graduating in History and Politics and spending a year on a Westminster press team. He manages day-to-day client relationships, media monitoring and reporting, and has quickly become the team\'s go-to for fast, careful research. He is studying for the CIPR Professional PR Diploma.</p>',
		'languages' => 'English, French',
		'lead'      => 'Oliver keeps our campaigns running on time, on message and on budget.',
		'name'      => 'Oliver Grant',
		'role'      => 'Account Manager',
	],
];

$team_ids     = [];
$created_team = 0;
$order        = 0;
foreach ( $team as $slug => $member ) {
	$order++;
	[ $id, $c ] = parley_seed_post( 'team_member', $slug, [ 'menu_order' => $order, 'post_content' => $member['content'], 'post_title' => $member['name'] ], [
		'email'     => strtok( $slug, '-' ) . '@parley.co.uk',
		'languages' => $member['languages'],
		'lead'      => $member['lead'],
		'linkedin'  => 'https://www.linkedin.com/in/' . $slug,
		'role'      => $member['role'],
		'x'         => 'https://x.com/' . str_replace( '-', '', $slug ),
	], $img[ 'team-' . $slug . '.jpg' ] ?? 0 );
	$team_ids[ $slug ] = $id;
	$created_team     += $c;
}
echo "team members: {$created_team} created, " . count( $team_ids ) . " total\n";

$categories = [
	'advocacy'              => 'Advocacy',
	'crisis'                => 'Crisis',
	'digital'               => 'Digital',
	'international-affairs' => 'International affairs',
	'media'                 => 'Media',
];
foreach ( $categories as $slug => $name ) {
	if ( ! term_exists( $slug, 'category' ) ) {
		wp_insert_term( $name, 'category', [ 'slug' => $slug ] );
	}
}
echo "categories: ready\n";

$article_grow = <<<'HTML'
<p>Audience is everything. You can spend weeks making the perfect film, report or campaign, but if nobody sees it, the effort is wasted.</p>
<p>In the early days of social media, building an audience was slow and entirely earned. You commented on other people's work, shared generously, emailed people you admired and swapped links with like-minded accounts. It took years, and the audiences it built were remarkably loyal.</p>
<p>Today, many organisations assume an advertising budget will do the job. Paid reach has its place, and we use it. But the most engaged, most relevant followers rarely arrive through an advert. They arrive because someone they trust shared something worth reading.</p>
<blockquote class="article__pullquote"><p>An organic audience takes longer to build, but it's the one that turns up when you need it.</p></blockquote>
<p>You can buy followers and you can buy engagement. We don't recommend it, and it's usually obvious. If you're starting fresh or rebuilding, an organic approach creates the foundation everything else stands on: a community of people who chose to follow you.</p>
<p>We've spent years running social campaigns on difficult international issues, where attention is hard-won and trust is fragile. Here are the 10 approaches we come back to most.</p>
<h2>1. Know your audience</h2>
<p>Don't describe your audience from a hunch. Use your platform analytics, your website data and a simple survey to learn who they are, where they are and what they care about. The answers are often surprising: the campaign you thought was for policymakers may be followed mostly by students and journalists. Knowing that changes what you post.</p>
<h2>2. Create content worth sharing</h2>
<p>Ask of every post: would someone share this without being asked? Useful beats promotional. A clear chart, a short explainer, a quote that captures the issue or a genuinely new fact will travel. A logo and a slogan won't.</p>
<h2>3. Ask</h2>
<p>People are more willing to help than you think, but they need to be asked. Ask supporters to share, ask partners to amplify, ask your followers what they want to see. A direct, specific request ("Please share this with one colleague who works on trade policy") beats a general plea every time.</p>
<h2>4. Choose your platforms, not all of them</h2>
<p>You don't need to be everywhere. Two channels done well will beat five done badly. Go where your audience already spends time: LinkedIn for policy and business, Instagram and TikTok for younger supporters, WhatsApp and Telegram in markets where that's where news travels.</p>
<h2>5. Be consistent before you're clever</h2>
<p>Algorithms and audiences both reward reliability. A realistic schedule you can keep, even three posts a week, will outperform bursts of activity followed by silence. Plan a month ahead and leave room for the unexpected.</p>
<h2>6. Talk with people, not at them</h2>
<p>Reply to comments. Thank people who share your work. Join conversations that aren't about you. Communities form around people who listen, and the fastest way to grow is to be good company in someone else's thread.</p>
<h2>7. Borrow credibility carefully</h2>
<p>Partnerships with respected voices (academics, journalists, campaigners, creators) can introduce you to audiences who would never otherwise find you. Choose partners whose values you share, be transparent about the relationship and make it worth their while.</p>
<h2>8. Show the people behind the work</h2>
<p>Faces outperform logos. Let your researchers, field staff and spokespeople speak for themselves, in their own words and on camera. Audiences trust people more than organisations, especially on contested issues.</p>
<h2>9. Make your best work easy to find</h2>
<p>Pin your most important post. Keep your bio clear and your links working. Turn a strong report into a thread, a carousel and a 60-second video. Most people will meet your work in fragments, so make every fragment lead somewhere.</p>
<h2>10. Measure what matters</h2>
<p>Follower counts are a vanity metric. Track what shows real engagement: shares, saves, replies, click-throughs, sign-ups and whether the right people (journalists, officials, partners) are paying attention. Review monthly and change what isn't working.</p>
<h2>None of this is quick</h2>
<p>Organic growth is slow at first and then, if you've done the groundwork, it compounds. The audience you build this way will be smaller than a bought one for a while. It will also be the one that shares your statement at midnight, signs the petition and tells a journalist you're worth calling.</p>
<p>If you'd like help building that kind of audience, talk to us.</p>
HTML;

$article_crisis = <<<'HTML'
<p>The email usually arrives late in the afternoon. A journalist has a document, a source or a set of allegations, and they'd like your comment by 10 o'clock tomorrow morning.</p>
<p>What happens next depends far less on the allegation than on the preparation. In our experience, most reputational damage is done in the first 48 hours, before the organisation has even agreed what it thinks. Silence gets read as guilt. Panic gets read as guilt too. And a hurried statement that later turns out to be wrong can do more harm than the original story.</p>
<blockquote class="article__pullquote"><p>You can't choose when a crisis arrives. You can choose whether you've rehearsed it.</p></blockquote>
<p>Here's the checklist we give boards, split into what to agree now and what to do when the phone rings.</p>
<h2>Before the phone rings</h2>
<h3>1. Name the team</h3>
<p>Decide now who sits in the crisis room: usually the chief executive, the chair, general counsel, the head of communications and one operational lead. Keep it small. Name deputies for each, because crises have a habit of arriving when someone is on a long-haul flight.</p>
<h3>2. Agree who signs off</h3>
<p>The single biggest cause of delay we see is confusion over who approves a statement. Write it down. Two people, not seven. Agree what legal review looks like and how fast it can happen.</p>
<h3>3. Map your risks honestly</h3>
<p>Every organisation knows its soft spots: the disputed contract, the difficult market, the former employee with a grievance. List them, draft holding lines for each, and review them once a year.</p>
<h3>4. Know your audiences</h3>
<p>The press is only one audience. Staff, funders, lenders, regulators, partners and the communities you work with may matter more. Keep a current list of who needs to hear from you, and in what order.</p>
<h3>5. Rehearse</h3>
<p>Run a simulation at least once a year, with a realistic scenario, a ticking clock and someone playing an unhelpful journalist. It's uncomfortable. It's also where you discover that nobody knows the password to the corporate X account.</p>
<h2>When the phone rings</h2>
<h3>6. Get the facts before the lines</h3>
<p>In the first hour, establish what you know, what you don't know and what you can find out quickly. Resist the urge to start drafting before this is done.</p>
<h3>7. Call your lawyers and your communicators together</h3>
<p>Legal and communications advice work best in the same room. Your lawyers will protect your position; your communicators will protect your reputation. You need both, and they need to hear each other.</p>
<h3>8. Issue a holding statement, if you need one</h3>
<p>A short, accurate holding statement buys time without conceding anything. It should say that you're aware, that you take it seriously, what you're doing and when you'll say more. Then keep that promise.</p>
<h3>9. Tell your own people first</h3>
<p>Staff who learn about a crisis from the news feel betrayed, and some of them will talk. A brief, honest internal message, sent before or at the same time as any public statement, is one of the most effective things you can do.</p>
<h3>10. Watch, don't feed</h3>
<p>Monitor coverage and social media closely, but think hard before responding to every post. Engaging with bad-faith accounts often amplifies them. Correct factual errors with journalists privately and firmly.</p>
<h3>11. Pick one voice</h3>
<p>Choose a single spokesperson and prepare them properly. Consistency matters more than seniority, and a well-briefed communications director is better than an unprepared chief executive.</p>
<h3>12. Plan for day three</h3>
<p>By the second day, start planning the recovery: what you'll change, how you'll show it and who needs to see it. The story will move on. Your stakeholders' memories won't, unless you give them something new to remember.</p>
<h2>A final word</h2>
<p>The organisations that come through a crisis well aren't the ones that never make mistakes. They're the ones that respond quickly, honestly and in one voice, because they agreed how they'd do it long before they needed to.</p>
<p>If your board hasn't had this conversation yet, we're happy to help you start it. Talk to us about crisis preparedness and simulation exercises.</p>
HTML;

$posts = [
	'grow-social-audience-organically' => [
		'author'   => 'kasia-nowak',
		'category' => 'digital',
		'content'  => $article_grow,
		'date'     => '2026-09-22 09:00:00',
		'excerpt'  => "Paid reach has its place. But the followers who share, argue and turn up are usually the ones who found you on their own. Here's how to earn them.",
		'image'    => 'post-social-apps.jpg',
		'sticky'   => true,
		'title'    => 'Ten ways to grow a social media audience without buying one',
	],
	'first-48-hours-crisis-checklist' => [
		'author'   => 'priya-raman',
		'category' => 'crisis',
		'content'  => $article_crisis,
		'date'     => '2026-09-18 09:00:00',
		'excerpt'  => 'Most reputational damage is done before the first statement goes out. What every board should agree before the phone rings, and what to do when it does.',
		'image'    => 'post-boardroom.jpg',
		'title'    => 'The first 48 hours: a crisis checklist for boards',
	],
	'why-your-op-ed-was-rejected' => [
		'author'   => 'eleanor-marsh',
		'category' => 'media',
		'content'  => '<p>Comment editors turn down nine pieces in ten. A former newsdesk hand explains what gets through and why most submissions never stood a chance.</p>',
		'date'     => '2026-09-15 09:00:00',
		'excerpt'  => 'Comment editors turn down nine pieces in ten. A former newsdesk hand explains what gets through and why most submissions never stood a chance.',
		'image'    => 'post-newspaper.jpg',
		'title'    => 'Why your op-ed was rejected, and how to fix it',
	],
	'human-rights-and-trade' => [
		'author'   => 'tunde-adeyemi-clarke',
		'category' => 'international-affairs',
		'content'  => '<p>Supply-chain laws in Europe are turning human rights into a boardroom issue. What that means for companies, campaigners and the stories journalists chase next.</p>',
		'date'     => '2026-09-11 09:00:00',
		'excerpt'  => 'Supply-chain laws in Europe are turning human rights into a boardroom issue. What that means for companies, campaigners and the stories journalists chase next.',
		'image'    => 'post-containers.jpg',
		'title'    => 'Human rights and trade: why the two can no longer be kept apart',
	],
	'select-committee-evidence' => [
		'author'   => 'tunde-adeyemi-clarke',
		'category' => 'advocacy',
		'content'  => '<p>Written evidence is read by more people than you think, and ignored more often than it should be. How to write a submission MPs will quote.</p>',
		'date'     => '2026-09-08 09:00:00',
		'excerpt'  => 'Written evidence is read by more people than you think, and ignored more often than it should be. How to write a submission MPs will quote.',
		'image'    => 'post-committee.jpg',
		'title'    => 'What a select committee actually wants from you',
	],
	'disinformation-pr-problem' => [
		'author'   => 'priya-raman',
		'category' => 'crisis',
		'content'  => '<p>False stories about organisations now spread faster than corrections. How to spot a coordinated campaign early, and when responding makes it worse.</p>',
		'date'     => '2026-09-04 09:00:00',
		'excerpt'  => 'False stories about organisations now spread faster than corrections. How to spot a coordinated campaign early, and when responding makes it worse.',
		'image'    => 'post-notifications.jpg',
		'title'    => "Disinformation isn't a PR problem. Until it is.",
	],
	'should-you-start-a-podcast' => [
		'author'   => 'kasia-nowak',
		'category' => 'digital',
		'content'  => '<p>Most organisational podcasts stop by episode six. Four questions to answer honestly before you buy a microphone.</p>',
		'date'     => '2026-09-01 09:00:00',
		'excerpt'  => 'Most organisational podcasts stop by episode six. Four questions to answer honestly before you buy a microphone.',
		'image'    => 'post-microphone.jpg',
		'title'    => "Should your organisation start a podcast? Probably not. Here's when you should.",
	],
	'foreign-press-safety' => [
		'author'   => 'priya-raman',
		'category' => 'media',
		'content'  => '<p>For activists and civil society groups, one quote can protect or endanger. Practical rules for working with international correspondents.</p>',
		'date'     => '2026-08-28 09:00:00',
		'excerpt'  => 'For activists and civil society groups, one quote can protect or endanger. Practical rules for working with international correspondents.',
		'image'    => 'post-press.jpg',
		'title'    => "Speaking to the foreign press when it isn't safe at home",
	],
	'accessibility-campaign-issue' => [
		'author'   => 'rafael-duarte',
		'category' => 'digital',
		'content'  => '<p>One in five people in the UK has a disability. If your campaign site shuts them out, you\'re losing supporters before you\'ve started.</p>',
		'date'     => '2026-08-25 09:00:00',
		'excerpt'  => "One in five people in the UK has a disability. If your campaign site shuts them out, you're losing supporters before you've started.",
		'image'    => 'post-keyboard.jpg',
		'title'    => 'Accessibility is a campaign issue, not a compliance box',
	],
];

$created_posts = 0;
foreach ( $posts as $slug => $post ) {
	[ $id, $c ] = parley_seed_post( 'post', $slug, [
		'post_content' => $post['content'],
		'post_date'    => $post['date'],
		'post_excerpt' => $post['excerpt'],
		'post_title'   => $post['title'],
	], [
		'author_profile' => $team_ids[ $post['author'] ],
	], $img[ $post['image'] ] );

	wp_set_object_terms( $id, $post['category'], 'category' );

	if ( ! empty( $post['sticky'] ) ) {
		stick_post( $id );
	}

	$created_posts += $c;
}
echo "posts: {$created_posts} created, " . count( $posts ) . " total\n";

$options = [
	'address'             => "Parley\n3rd Floor, 12 Great James Street\nLondon WC1N 3DR",
	'careers_email'       => 'careers@parley.co.uk',
	'company_number'      => '00000000',
	'cta_default_body'    => "Most of our work starts with a quiet call before anything reaches the press. Tell us what's happening. We'll tell you honestly whether we can help.",
	'cta_default_heading' => 'Something brewing?',
	'email'               => 'hello@parley.co.uk',
	'legal_name'          => 'Parley Communications Ltd',
	'phone'               => '+44 (0)20 0000 0000',
	'phone_href'          => '+442000000000',
	'press_email'         => 'press@parley.co.uk',
	'social'              => [
		[ 'icon' => 'linkedin', 'label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/company/parley' ],
		[ 'icon' => 'x', 'label' => 'X', 'url' => 'https://x.com/parleyhq' ],
		[ 'icon' => 'instagram', 'label' => 'Instagram', 'url' => 'https://www.instagram.com/parleyhq' ],
	],
];
foreach ( $options as $name => $value ) {
	update_option( $name, $value );
}
echo "options: " . count( $options ) . " set\n";

parley_seed_menu( 'Primary', [
	[ 'menu-item-object' => 'page', 'menu-item-object-id' => $about_id, 'menu-item-title' => 'About', 'menu-item-type' => 'post_type' ],
	[ 'menu-item-object' => 'service', 'menu-item-title' => 'Services', 'menu-item-type' => 'post_type_archive' ],
	[ 'menu-item-object' => 'case_study', 'menu-item-title' => 'Our Work', 'menu-item-type' => 'post_type_archive' ],
	[ 'menu-item-object' => 'team_member', 'menu-item-title' => 'Team', 'menu-item-type' => 'post_type_archive' ],
	[ 'menu-item-object' => 'page', 'menu-item-object-id' => $dispatches_id, 'menu-item-title' => 'Dispatches', 'menu-item-type' => 'post_type' ],
	[ 'menu-item-object' => 'page', 'menu-item-object-id' => $contact_id, 'menu-item-title' => 'Contact', 'menu-item-type' => 'post_type' ],
] );

parley_seed_menu( 'Footer 1', [
	[ 'menu-item-object' => 'page', 'menu-item-object-id' => $about_id, 'menu-item-title' => 'About', 'menu-item-type' => 'post_type' ],
	[ 'menu-item-object' => 'service', 'menu-item-title' => 'Services', 'menu-item-type' => 'post_type_archive' ],
	[ 'menu-item-object' => 'team_member', 'menu-item-title' => 'Team', 'menu-item-type' => 'post_type_archive' ],
] );

parley_seed_menu( 'Footer 2', [
	[ 'menu-item-object' => 'case_study', 'menu-item-title' => 'Our Work', 'menu-item-type' => 'post_type_archive' ],
	[ 'menu-item-object' => 'page', 'menu-item-object-id' => $dispatches_id, 'menu-item-title' => 'Dispatches', 'menu-item-type' => 'post_type' ],
	[ 'menu-item-object' => 'page', 'menu-item-object-id' => $contact_id, 'menu-item-title' => 'Contact', 'menu-item-type' => 'post_type' ],
] );

parley_seed_menu( 'Legal', [
	[ 'menu-item-object' => 'page', 'menu-item-object-id' => $privacy_id, 'menu-item-title' => 'Privacy', 'menu-item-type' => 'post_type' ],
	[ 'menu-item-object' => 'page', 'menu-item-object-id' => $cookies_id, 'menu-item-title' => 'Cookies', 'menu-item-type' => 'post_type' ],
	[ 'menu-item-object' => 'page', 'menu-item-object-id' => $accessibility_id, 'menu-item-title' => 'Accessibility', 'menu-item-type' => 'post_type' ],
] );

$locations = get_theme_mod( 'nav_menu_locations', [] );
foreach ( [ 'primary' => 'Primary', 'footer-1' => 'Footer 1', 'footer-2' => 'Footer 2', 'legal' => 'Legal' ] as $location => $menu_name ) {
	$menu = wp_get_nav_menu_object( $menu_name );
	if ( $menu ) {
		$locations[ $location ] = $menu->term_id;
	}
}
set_theme_mod( 'nav_menu_locations', $locations );
echo "menus: 4 ready, locations assigned\n";

update_option( 'blogdescription', 'Be heard where it counts.' );
update_option( 'blogname', 'Parley' );
update_option( 'date_format', 'j F Y' );
update_option( 'page_for_posts', $dispatches_id );
update_option( 'page_on_front', $front_id );
update_option( 'show_on_front', 'page' );
update_option( 'start_of_week', 1 );
update_option( 'time_format', 'H:i' );
update_option( 'timezone_string', 'Europe/London' );

update_option( 'permalink_structure', '/%postname%/' );
flush_rewrite_rules( false );

echo "settings: reading, identity, timezone, permalinks done\n";

foreach ( [ [ 'post', 'hello-world' ], [ 'page', 'sample-page' ], [ 'page', 'privacy-policy' ] ] as [ $default_type, $default_slug ] ) {
	foreach ( get_posts( [ 'name' => $default_slug, 'numberposts' => 1, 'post_status' => 'any', 'post_type' => $default_type ] ) as $default_post ) {
		wp_delete_post( $default_post->ID, true );
	}
}
echo "defaults: removed\n";
echo "SEED COMPLETE\n";

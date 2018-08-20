<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?php the_field('description') ?>">
<meta name="keywords" content="<?php the_field('keywords') ?>">
<title><?php if ($title = get_field('title')): echo $title; else: the_title(); endif; ?></title>
<link rel="stylesheet" href="<?php echo get_stylesheet_uri() ?>" type="text/css" />
<!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php wp_head() ?>
<?php

/**
 *
 */

$args = [
    'number'  => 3,
    'post_id' => 58,
    'status'  => 'approve',
];

$comments = get_comments($args);
?>
        <div class="container">
            <div class="main_reviews">
                <div class="block_header">отзывы</div>
                <div class="row">
<?php
foreach ($comments as $comment) {
?>
                    <div class="col-md-4">
                        <div class="rev_block">
                            <div class="head_rev">
                                <strong><?php echo $comment->comment_author; ?></strong>
                                <span><?php echo mysql2date('d.m.Y', $comment->comment_date); ?></span>
                            </div>
                            <div class="text_rev">
                                <p><?php echo $comment->comment_content; ?></p>
                            </div>
                        </div>
                    </div>
<?php
}
?>
                </div>
            </div>
        </div>
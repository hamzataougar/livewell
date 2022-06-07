</div><!-- .container -->
</div>
<?php do_action('just_before_footer') ?>
<footer class="clearfix">
    <?php do_action('start_footer'); ?>
    <div class="container ">

        <?php //do_action('side_bar_before_footer'); ?>
        <?php //do_action('cache_nav_footer'); ?>


        <div class="row">

            <?php
            $sidebar = apply_filters('filter_all_sidebar', 'footer-v2') ;
            if (is_active_sidebar($sidebar)) {
                dynamic_sidebar($sidebar);
            }
            ?>
        </div>

        <?php do_action('side_bar_after_footer'); ?>


    </div>
    <?php do_action('end_footer'); ?>
</footer>


<?php do_action('just_after_footer'); ?>

</div><!-- #page -->
<?php
//do_action('before_wp_footer');
wp_footer();
//do_action('after_wp_footer');
?>
</body>
</html>

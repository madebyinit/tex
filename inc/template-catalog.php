    <div class="white-block white-projects">
        <div class="wrapper filter-line">

            <div class="select-block" style="text-align: center;">
                <h2 id="ku"><?php  echo get_admin_page_title() ?></h2>

                <select name="categoryfilter_model" class="car_model_q1" id="model_select">
                    <option selected>Car Model</option>
                    <?php $car_model_q2 = get_terms('model');
                    foreach ($car_model_q2 as $carModel) {
                        echo '<option value="'.$carModel->slug.'" data-model-id="'. $carModel->term_id.'">'.$carModel->name.'</option>';
                    }
                    ?>
                </select>

                <select name="categoryfilter_class" class="car_class_q1" id="class_select">
                    <option selected>Car Class</option>
                    <?php $car_class_q2 = get_terms('class');
                    foreach ($car_class_q2 as $carClass) {
                        echo '<option value="'.$carClass->slug.'" data-class-id="'. $carClass->term_id.'">'.$carClass->name.'</option>';
                    }
                    ?>
                </select>
            </div>
            <hr>

        </div>
    </div>
<?php
$args = array(
    'post_type' => 'vehicle',
);
$projects = new WP_Query($args);
$max_pages = $projects->max_num_pages;
if($projects->have_posts()) : ?>
    <div class="projects" id="ajax-portfolio-container">
        <div class="project-block" >
            <?php while($projects->have_posts()): $projects->the_post();
                $id = get_the_ID();
                $term_list_model = wp_get_post_terms( $id, 'model', array( 'fields' => 'names' ) );
                $term_list_class = wp_get_post_terms( $id, 'class', array( 'fields' => 'names' ) );
            ?>
            <div class="card">
                <a href="<?php the_permalink();?>">
                    <?php the_post_thumbnail(array( 250, 250))?>
                    <p class="title-events big-text"><?php the_title();?></p>
                </a>
                <p>
                    <span>
                        Model: <?php foreach ($term_list_model as $m) { echo $m  . ' '; } ?>
                    </span> <br>
                    <span>
                        Class:  <?php foreach ($term_list_class as $c) { echo $c . ' '; } ?>
                    </span>
                </p>
            </div>


            <?php endwhile;?>
        </div>
        <?php
        // TODO
        if($max_pages > 1){ ?>
            <a id="load-more-events" href="#" class="btn btn-orange" data-page="2">Load More</a>
        <?php }?>
    </div>

    <?php wp_reset_postdata();
endif;?>

<?php
$groups = array(
	"school" => __("Scuola", "design_scuole_italia"),
	"service" =>  __("Servizi", "design_scuole_italia"),
	"news" =>  __("Notizie", "design_scuole_italia"),
	"education" =>  __("Didattica", "design_scuole_italia")
);


$allowed_types = array( "any", "school", "news", "education", "service" );
if ( isset( $_GET["type"] ) && in_array( $_GET["type"], $allowed_types ) ) {
	$type = $_GET["type"];
	// associazione tra types e post_type
	$post_types = dsi_get_post_types_grouped( $type );

} else {
    if(isset( $_GET["type"] ))
    	$post_types = $_GET["post_types"];
    else
	    $post_types = array();
}
$post_terms = array();
if(isset($_GET["post_terms"]))
	$post_terms = $_GET["post_terms"];

//$data = array('foo', 'bar', 'baz', 'boom', 'cow' => 'milk', 'php' =>'hypertext processor');
//echo http_build_query($data) . "\n";

?>

<aside class="aside-list sticky-sidebar search-results-filters">
    <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="hidden" name="s" value="<?php echo get_search_query(); ?>" >
    <?php
    foreach ($groups as $key => $value){
        $types = dsi_get_post_types_grouped($key);
        ?>
        <h3 class="h6 text-uppercase"><strong><?php echo $value; ?></strong></h3>
        <ul>
            <?php
            foreach ( $types as $type ) {
	            $name = get_post_type_object( $type )->labels->name;
                ?>
                <li>
                    <div class="custom-control custom-checkbox custom-checkbox-outline">
                        <input type="checkbox" class="custom-control-input" name="post_types[]" value="<?php echo $type; ?>" id="check-<?php echo $type; ?>" <?php if(in_array($type, $post_types)) echo " checked "; ?> onChange="this.form.submit()">
                        <label class="custom-control-label" for="check-<?php echo $type; ?>"><?php echo $name; ?></label>
                    </div>
                </li>

            <?php
            }
            ?>
        </ul>

    <?php
    }
    ?>
        <h3 class="h6 text-uppercase"><strong><?php _e("Argomenti", "design-scuole-italia"); ?></strong></h3>
        <ul>
            <?php
            $terms = get_terms( array(
	            'taxonomy' => 'category',
	            'hide_empty' => true,
	            'orderby'    => 'count',
                'number' => 20,
            ) );
            foreach ($terms as $term){
                ?>
                <li>
                    <div class="custom-control custom-checkbox custom-checkbox-outline">
                        <input type="checkbox" class="custom-control-input" name="post_terms[]" value="<?php echo $term->term_id; ?>" id="check-<?php echo $term->slug; ?>" <?php if(in_array($term->term_id, $post_terms)) echo " checked "; ?> onChange="this.form.submit()">
                        <label class="custom-control-label" for="check-<?php echo $term->slug; ?>"><?php echo $term->name; ?></label>
                    </div>
                </li>
            <?php
            }
            ?>
        </ul>
    </form>
</aside>
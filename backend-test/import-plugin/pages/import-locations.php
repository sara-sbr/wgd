<?php 

// URL to get the data from
$get_url = 'https://gitlab.com/wholegrain/webdeveloper-test/-/raw/master/backend-test/locations.csv';
$i = 0;
$count = 0;
$already_exists = '';
$new_locations = '';

//Get the data from URL if form is submitted
if(!empty($_POST['submit'])) {

  $csvFile = file($get_url);
  $data = [];
  foreach ($csvFile as $line) {
    $data[] = str_getcsv($line);
  }

  foreach($data as $row) {
    if($i > 0) { // Ignore the first line as that is just titles

      //$row[0] = ID -> Custom field | a unique identifier for the post
      //$row[1] = Customer -> Post title
      //$row[2] = Category -> wgd-category
      //$row[3] = Description -> Post content
      //$row[4] = Address -> Custom field (add this to post type if time)
    
      if($row[0] > 0) { $count++; /* only count non-empty rows */}

      // First import categories if they don't exist
      $category = get_term_by('name', $row[2], 'wgd-category');

      if(gettype($category) == 'object' && $category->term_id > 0) {
        //Cat already exists so don't add it again
      } else {
        //Insert category if it doesn't exist
        wp_insert_term($row[2],'wgd-category'); 
        // Now get the id to add to location
        $category = get_term_by('name', $row[2], 'wgd-category');
      }

      // Next see if the location already exists
      $query = new WP_Query(array(
        'post_type' => 'wgd-locations', 
        'posts_per_page' => 1,
        'meta_key' => 'unique_location_identifier',
        'meta_query' => array(
            array(
                'key' => 'unique_location_identifier',
                'value' => $row[0],
                'compare' => '=',
              )
          )
        ));
        if ( $query->have_posts() ) :  

        while ( $query->have_posts() ) : $query->the_post(); 

          // If it already exists, print an info message
          $already_exists .= get_the_title() . ' already exists.<br>';
   
        endwhile; 

      else :

        // Else insert new location
        $location_post = array(
          'post_title'   => wp_strip_all_tags($row[1]),
          'post_type'    => 'wgd-locations',
          'post_content' => $row[3],
          'post_status'   => 'publish',
          'meta_input'   => array(
            'unique_location_identifier' => $row[0],
            'location_address' => $row[4],
          ),
        );

        // Insert the post into the database
        $post_id = wp_insert_post($location_post);
        // Add custom taxonomy
        wp_set_object_terms($post_id, $category->term_id, 'wgd-category');
        // Add info message
        $new_locations .= wp_strip_all_tags($row[1]) . ' added.<br>';

      endif; 
      wp_reset_query(); 

    }
    $i++;
  }
}

//If I had more time I would do better response checking and error handling
?>


<h1>Import Locations</h1>

<p>Click to import data from <?php echo $get_url; ?></p>

<form action="" method="post">
  <input type="submit" name="submit" value="Import">
</form>

<?php if($count > 0) {
  echo '<p>' . $count . ' location(s) inserted or updated.</p>';
  echo '<p>' . $already_exists . '</p>';
  echo '<p>' . $new_locations . '</p>';
} ?>

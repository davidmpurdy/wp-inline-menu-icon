<?php 
  
if (! class_exists( 'ACF_JSON_Location')):

class ACF_JSON_Location {

    // list of field group IDs used in my plugin
    private $comparison;

    /**
     * New location to use for JSON for matched groups
     */
    private $location;


    /**
     * Construct new location with 
     * 
     * @param string $location      New location to save JSON
     * @param array $comparison     Array of key/values to use to match which groups to save to new location
     */
    public function __construct($location, $comparison = array()) {
        $this->location = $location;
        $this->comparison = $comparison;

        add_action('acf/update_field_group', array($this, 'update_field_group'), 1, 1);
        add_filter('acf/settings/load_json', array($this, 'load_json_path'), 10, 1);
    }

    public function update_field_group($group) {
        
        foreach ($this->comparison as $key => $value) {
            if ($group[$key] != $value) {
                return $group;
            }
        }
        
        add_filter('acf/settings/save_json',  array($this, 'override_location'), 9999);
        
        return $group;
    } 

    public function override_location($path) {
        // remove this filter so it will not effect other goups
        remove_filter('acf/settings/save_json',  array($this, 'override_location'), 9999);
        // override save path
        return $this->location;
    } 


    public function load_json_path ( $paths ) {
        
        $paths[] = $this->location;
        
        return $paths;
    }
}

endif;
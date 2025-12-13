<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    protected $table = 'tbl_categories';
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all categories
     */
    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    /**
     * Get category by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, [$this->primaryKey => $id])->row();
    }

    /**
     * Get category by name
     */
    public function get_by_name($name)
    {
        return $this->db->get_where($this->table, ['name' => $name])->row();
    }

    /**
     * Create new category
     */
    public function create($data)
    {
        // Generate slug if not provided
        if (!isset($data['slug']) && isset($data['name'])) {
            $data['slug'] = $this->generate_slug($data['name']);
        }
        
        // Add timestamp
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update category
     */
    public function update($id, $data)
    {
        // Generate slug if name is updated
        if (isset($data['name'])) {
            $data['slug'] = $this->generate_slug($data['name'], $id);
        }
        
        // Update timestamp
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->where($this->primaryKey, $id)->update($this->table, $data);
    }

    /**
     * Delete category
     */
    public function delete($id)
    {
        return $this->db->where($this->primaryKey, $id)->delete($this->table);
    }

    /**
     * Get categories with product count
     */
    public function get_with_product_count()
    {
        $this->db->select('tbl_categories.*, COUNT(tbl_products.id) as product_count');
        $this->db->from($this->table);
        $this->db->join('tbl_products', 'tbl_products.category_id = tbl_categories.id', 'left');
        $this->db->group_by('tbl_categories.id');
        return $this->db->get()->result();
    }

    /**
     * Get dropdown list
     */
    public function get_dropdown()
    {
        $categories = $this->get_all();
        $dropdown = [];
        
        foreach ($categories as $category) {
            $dropdown[$category->id] = $category->name;
        }
        
        return $dropdown;
    }

    /**
     * Generate unique slug from name
     */
    private function generate_slug($name, $exclude_id = null)
    {
        // Convert to lowercase and replace spaces with hyphens
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        
        // Remove multiple hyphens
        $slug = preg_replace('/-+/', '-', $slug);
        
        // Trim hyphens from start and end
        $slug = trim($slug, '-');
        
        // Check if slug exists
        $original_slug = $slug;
        $counter = 1;
        
        while ($this->slug_exists($slug, $exclude_id)) {
            $slug = $original_slug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    /**
     * Check if slug exists
     */
    private function slug_exists($slug, $exclude_id = null)
    {
        $this->db->where('slug', $slug);
        
        if ($exclude_id !== null) {
            $this->db->where($this->primaryKey . ' !=', $exclude_id);
        }
        
        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Get by slug
     */
    public function get_by_slug($slug)
    {
        return $this->db->get_where($this->table, ['slug' => $slug])->row();
    }
}

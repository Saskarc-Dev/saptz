<?php
    class test extends CI_Model {
        
        public function dataload(){
            
            $query = $this->db->get('employees');
            return $query->result_array();

        }
    }
?>
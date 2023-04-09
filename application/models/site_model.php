<?php
class site_model extends CI_Model {
	public function login(){

	}
	public function insertProfesor(){
		$array = array(
			'nombre' => 'David',
			'apellidos' => 'Navarro',
			'curso' => 3
		);

		$this->db->insert('profesores', $array);

	}
	public function getProfesores(){
		$this->db->select('*');
		$this->db->from('profesores');
		$query = $this->db->get();  // Produces: SELECT title, content, date FROM mytable
		if($query->num_rows()>0){
        return$query->result();
		}else{
			return null;
		}
	}
     public function updateProfesor(){
		 $array = array(
			 'nombre' => 'David',
			 'apellidos' => 'Navarro Lopez',
			 'curso' => 3
		 );

		 $this->db->where('id', 1);
		 $this->db->update('profesores', $array);

	 }
}

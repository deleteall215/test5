<?php
class site_model extends CI_Model
{
    public function loginUser($data)
    {
        $this->db->select('*');
        $this->db->from('profesores');
        $this->db->where('username', $data['username']);
        $this->db->where('password', md5($data['password']));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            $this->db->select('*');
            $this->db->from('alumnos');
            $this->db->where('username', $data['username']);
            $this->db->where('password', md5($data['password']));
            $queryalumno = $this->db->get();
            if ($queryalumno->num_rows() > 0) {
                return $queryalumno->result();
            }
            return Null;

        }
    }

    public function insertProfesor()
    {
        $array = array(
            'nombre' => 'David',
            'apellidos' => 'Navarro',
            'curso' => 3
        );

        $this->db->insert('profesores', $array);

    }

    public function getProfesores()
    {
        $this->db->select('*');
        $this->db->from('profesores');
        $query = $this->db->get();  // Produces: SELECT title, content, date FROM mytable
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function updateProfesor()
    {
        $array = array(
            'nombre' => 'David',
            'apellidos' => 'Navarro Lopez',
            'curso' => 1
        );

        $this->db->where('id', 1);
        $this->db->update('profesores', $array);

    }

    function getAlumnos($curso){
        $this->db->select('*');
        $this->db->from('alumnos');
        $this->db->where('curso', $curso);
        $this->db->where('deleted', 0);
        $query = $this->db->get();
        //print_r($this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return Null;
        }
    }
    function deleteAlumno($id){
        $array = array(
            'deleted' => 1

        );
    $this->db->where('id', $id);
        $this->db->update('alumnos',$array);
    }
}


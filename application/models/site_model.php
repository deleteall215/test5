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
    function uploadTarea($data,$archivo=null){
        if ($archivo){
            $array = array(
                'nombre' => $data['nombre'],
                'descripcion' =>$data['descripcion'],
                'fecha_final' => $data['fecha'],
                'archivo' => $archivo,
                'curso' =>$data['curso'],
            );
        }else{
            $array = array(
                'nombre' => $data['nombre'],
                'descripcion' =>$data['descripcion'],
                'fecha_final' => $data['fecha'],
                'curso' =>$data['curso'],
            );
        }


        $this->db->insert('tareas',$array);

    }
     function getTareas($curso){
         $this->db->select('*');
         $this->db->from('tareas');
         $this->db->where('curso', $curso);
         $this->db->order_by("fecha_final", "ASC");
         $query = $this->db->get();
        //print_r($this->db->last_query());
         if ($query->num_rows() > 0) {
             return $query->result();
         } else {
             return Null;
         }
     }

     function getUsuarios($tipo,$curso){
         $this->db->select('*');
         if($tipo=="profesor"){
             $this->db->from('alumnos');
         }
         if($tipo=="alumno"){
             $this->db->from('profesores');
         }
         $this->db->where('curso', $curso);
         $query = $this->db->get();
         //print_r($this->db->last_query());
         if ($query->num_rows() > 0) {
             return $query->result();
         } else {
             return Null;
         }
     }

     function insertMensaje($data,$iduser){
         $array = array(
             'texto' =>$data['mensaje'] ,
             'id_from' =>$iduser ,
             'id_to' =>$data['id_to']

         );
         $this->db->insert('mensajes',$array);

         print_r($this->db->last_query());

     }

     function getToken($id,$tipo){
         $this->db->select('*');
         $this->db->where('id', $id);

         if($tipo=="profesor"){
             $this->db->from('profesores');
         }else if ($tipo=="alumno"){
             $this->db->from('alumnos');
         }
         $query = $this->db->get();
         if ($query->num_rows() > 0) {
             $result= $query->result();
             return $result[0]->token_mensaje;
         } else {
             return Null;
         }
     }
     function getMensajes($token){
         $this->db->select('*');
         $this->db->where("id_to",$token);
         $this->db->from("mensajes");
         $query = $this->db->get();

         if ($query->num_rows() > 0){
             return $query->result();
         }else{
             return Null;
         }
     }
     function getNombre($id){
         $this->db->select("*");
         $this->db->from("alumnos");
         $this->db->where("token_mensaje",$id);

         $query1=$this->db->get_compiled_select();

         $this->db->select("*");
         $this->db->from("profesores");
         $this->db->where("token_mensaje",$id);

         $query2=$this->db->get_compiled_select();

         $query=$this->db->query($query1." UNION ".$query2);
         print_r($this->db->last_query());
         if ($query->num_rows()>0){
             return $query->result();
         }else{
             return Null;
         }

     }
     function getTextmensaje($idmensaje){
         $this->db->select("*");
         $this->db->from("mensajes");
         $this->db->where("id",$idmensaje);
         $query = $this->db->get();
         if ($query->num_rows() > 0){
             $array=array(
                 "is_read"=> 1
             );
             $this->db->where('id', $idmensaje);
             $this->db->update('mensajes',$array);
             return $query->result();
         }else{
             return Null;
         }
     }
}


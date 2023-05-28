<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{


    public function index()
    {

        $this->loadViews('home');


    }

    public function login()
    {
        if($_POST['username'] && $_POST['password']){
            $login=$this->site_model->loginUser($_POST);
            print_r($login);
            if($login) {
                   $array = array(
                    'id' => $login[0]->id,
                    'nombre' => $login[0]->nombre,
                    'apellidos' => $login[0]->apellidos,
                    'username' => $login[0]->username,
                    'curso' => $login[0]->curso,
                );
                    // GUARDAR TIPO USUARIO (profesor/ alumno)
                   if(isset($login[0]->is_profesor)){
                    $array['tipo']='profesor';
                   }else if (isset($login[0]->is_alumno)){
                       $array['tipo']='alumno';
                   }
                $this->session->set_userdata($array);
            }
        }
        $this->loadViews('login');

    }
    function loadViews($view,$data=null)
    {
        // SI TENEMOS SESION CREADA
        if ($_SESSION['username']) {
            // si la vista es login se redirige a la home
            if ($view == "login") {
                redirect(base_url() . "Dashboard", "location");
            }
            // si la vista cualquiera se carga
            $this->load->view('includes/header');
            $this->load->view('includes/sidebar');
            $this->load->view($view, $data);
            $this->load->view('includes/footer');
        } else {
            // SI NO TENEMOS INICIADA SESION
            if ($view == "login") {
                // si la vista es login se carga
                $this->load->view($view);
            } else {
                // si la vista es otra cualquiera se redirege a login
                redirect(base_url() . "Dashboard/login", "location");
            }

        }
    }
    function gestionAlumnos(){
        if ($_SESSION['tipo']=="profesor"){
            $data['alumnos']=$this->site_model->getAlumnos($_SESSION['curso']);
            $this->loadViews('gestionalumnos',$data);
        }else{
            redirect(base_url()."Dashboard","location");
        }

    }


        public function crearTareas(){

           if($_POST){
               
              if($_FILES['archivo']){
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['file_name']            = uniqid().$_FILES['archivo']['name'] ;
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('archivo')) {
                    echo"error";
                } else{
                    $this->site_model->uploadTarea($_POST,$config['file_name'] );
                }
            }else{
                $this->site_model->uploadTarea($_POST );
            }


        }
        $this->loadViews('creartareas');

        }


    function misTareas(){
        if($_SESSION['id']){
            $data['tareas']= $this->site_model->getTareas($_SESSION['curso']);
            $this->loadViews('mistareas',$data);
        }else{
            redirect(base_url() . "Dashboard", "location");
        }

    }

    function mensajes(){
        if($_SESSION['id']){
            // INSERTAR MENSAJE
            if($_POST){
                $token=$this->site_model->getToken($_SESSION['id'],$_SESSION['tipo']);
                $this->site_model->insertMensaje($_POST,$token);
            }
            // OBTENER TODOS LOS USUARIOS
            $data['usuarios']= $this->site_model->getUsuarios($_SESSION['tipo'],$_SESSION['curso']);
            $token=$this->site_model->getToken($_SESSION['id'],$_SESSION['tipo']);
            $data['mensajes']= $this->site_model->getMensajes($token);

            $this->loadViews('mensajes',$data);
        }else{
            redirect(base_url() . "Dashboard", "location");
        }

    }
    function getMensaje(){
        $texto=$this->site_model->getTextmensaje($_POST['idmensaje']);
        echo $texto[0]->texto;
    }

       function eliminarAlumno(){
            if($_POST['idalumno']){
                $this->site_model->deleteAlumno($_POST['idalumno']);
            }
       }


}

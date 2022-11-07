<?php
require_once './app/models/park.model.php';
require_once './app/views/api.view.php';

class ApiParkController {
    private $model;
    private $view;
    private $data;

    public function __construct(){
        $this->model = new ParkModel();
        $this->view = new ApiView();

        $this->data = file_get_contents("php://input");

    }

    private function getData() {
        return json_decode($this->data);
    }

    public function getParks($params = null){
        $parks = $this->model->getAll();
        $this->view->response($parks);
    }

    public function getPark($params = null){
        $id = $params[':ID'];
        $park = $this->model->getPark($id);

        if ($park){
            $this->view->response($park);
        }
        else {
            $this->view->response("El parque con el id $id no existe", 404);
        }
    }

    public function deletePark($params = null){
        $id = $params[':ID'];
        $park = $this->model->getPark($id);

        if ($park) {
            $this->model->deletePark($id);
            $this->view->response($park);
        } else {
            $this->view->response("El parque con el id $id no existe", 404);
        }
    }

    public function insertPark($params = null){
        $park = $this->getData();

        if (empty($park->name) || empty($park->description) || empty($park->price) || empty($park->id_province_fk)){
            $this->view->response("Debe completar los datos", 400);
        } else {
            $id = $this->model->insert($park->name, $park->description, $park->price, $park->id_province_fk);
            $task = $this->model->getPark($id);
            $this->view->response($park, 201);
        }
    }

}
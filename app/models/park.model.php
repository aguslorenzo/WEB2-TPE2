<?php

class ParkModel{
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=parks;charset=utf8', 'root', '');
    }

    function getAll(){
        $query = $this->db->prepare('SELECT * FROM parks');
        $query->execute();
        $parks = $query->fetchAll(PDO::FETCH_OBJ);
        return $parks;
    }
    
    function getPark($id){
        $query = $this->db->prepare("SELECT * FROM parks WHERE id=?");
        $query->execute([$id]);
        $park= $query->fetch(PDO::FETCH_OBJ);
        return $park;
    }

    function insert($name, $description, $price, $province) {
        $query = $this->db->prepare("INSERT INTO parks (name, description, price, id_province_fk) VALUES (?, ? ,? ,?)");
        $query->execute([$name, $description, $price, $province]);
        
    }

    function getParksByProvince($provinceId){
        $query = $this->db->prepare("SELECT * FROM parks WHERE id_province_fk=?");
        $query->execute([$provinceId]);
        $parks = $query->fetchAll(PDO::FETCH_OBJ);
        return $parks;
    }

    function deletePark($id){
        $query = $this->db->prepare("DELETE FROM parks WHERE id=?");
        $query->execute([$id]);
    }
    
    function updatePark($id, $name, $description, $price, $province){
        $query = $this->db->prepare("UPDATE parks SET name=? , description=? , price=?, id_province_fk=? WHERE id= ?");
        $query->execute([$name, $description, $price, $province, $id]);
    }
}
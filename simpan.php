<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db_server = "localhost";
    $db_username = "amgpmdatabase"; // Ganti dengan username MySQL Anda
    $db_password = "amgpmdatabase2714"; // Ganti dengan password MySQL Anda
    $db_name = "informasi_orang"; // Ganti dengan nama database Anda

    $conn = new mysqli($db_server, $db_username, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }

    $nama = $_POST["nama"];
    $jenisKelamin = $_POST["jenisKelamin"];
    $status = $_POST["status"];
    $tglKelahiran = $_POST["tglKelahiran"];
    $foto = $_FILES["foto"]["name"];

    $sql = "INSERT INTO orang (nama, jenis_kelamin, status, tgl_kelahiran, foto) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nama, $jenisKelamin, $status, $tglKelahiran, $foto);

    if ($stmt
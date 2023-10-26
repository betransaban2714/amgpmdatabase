document.getElementById("tambahButton").addEventListener("click", function () {
    var nama = document.getElementById("nama").value;
    var jenisKelamin = document.getElementById("jenisKelamin").value;
    var status = document.getElementById("status").value;
    var tglKelahiran = document.getElementById("tglKelahiran").value;
    var fotoInput = document.getElementById("foto");

    var formData = new FormData();
    formData.append("nama", nama);
    formData.append("jenisKelamin", jenisKelamin);
    formData.append("status", status);
    formData.append("tglKelahiran", tglKelahiran);
    formData.append("foto", fotoInput.files[0]);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "simpan.php", true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            // Data berhasil disimpan, mungkin Anda ingin memperbarui tampilan di sini
            console.log(xhr.responseText);
        }
    };
    xhr.send(formData);

    document.getElementById
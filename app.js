// app.js

// ID penerapan dan URL aplikasi web dari Google Apps Script
const deploymentId = "AKfycbz5YBO-HLjk4NiMvuu8fmS4tUgwtA-kRPezTS8q2xyQGK9aRWcjn17mTUWBWfbioS6fPA";
const webAppUrl = "https://script.google.com/macros/s/AKfycbz5YBO-HLjk4NiMvuu8fmS4tUgwtA-kRPezTS8q2xyQGK9aRWcjn17mTUWBWfbioS6fPA/exec";

let currentRow = 1;

function previewImage() {
  // ... (kode lainnya)
}

function tambahAnggota() {
  // ... (kode lainnya)

  // Mengirim data ke aplikasi web dengan permintaan POST
  fetch(webAppUrl, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      nomorUrutan,
      gambar,
      nama,
      tempatTanggalLahir,
      jenisKelamin,
      status,
      pendidikan
    })
  })
    .then(response => response.text())
    .then(data => {
      console.log("Respon dari aplikasi web:", data);
    })
    .catch(error => {
      console.error("Terjadi kesalahan:", error);
    });
}
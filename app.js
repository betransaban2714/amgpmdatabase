// app.js

// ID penerapan dan URL aplikasi web dari Google Apps Script
const deploymentId = "AKfycbz5YBO-HLjk4NiMvuu8fmS4tUgwtA-kRPezTS8q2xyQGK9aRWcjn17mTUWBWfbioS6fPA";
const webAppUrl = "https://script.google.com/macros/s/AKfycbz5YBO-HLjk4NiMvuu8fmS4tUgwtA-kRPezTS8q2xyQGK9aRWcjn17mTUWBWfbioS6fPA/exec";

let currentRow = 1;

function previewImage(event) {
  const gambarInput = document.getElementById('gambar-input');
  const gambarPreview = document.getElementById('gambar-preview');

  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      gambarPreview.src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
}

function tambahAnggota() {
  // Mengambil nilai-nilai dari input
  const nama = document.getElementById('nama').value;
  const tempatTanggalLahir = document.getElementById('tempat-tanggal-lahir').value;
  const jenisKelamin = document.getElementById('jenis-kelamin').value;
  const status = document.getElementById('status').value;
  const pendidikan = document.getElementById('pendidikan').value;

  // Menampilkan pesan terimakasih sebagai alert tengah layar
  const pesanTerimakasih = 'Terima kasih telah mengisi formulir. Data Anda akan diproses.';
  alertCenter(pesanTerimakasih);

  // Mengirim data ke aplikasi web dengan permintaan POST
  fetch(webAppUrl, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      gambar: gambarPreview.src, // Gambar preview
      nama: nama,
      tempatTanggalLahir: tempatTanggalLahir,
      jenisKelamin: jenisKelamin,
      status: status,
      pendidikan: pendidikan,
    }),
  })
    .then((response) => response.text())
    .then((data) => {
      console.log('Respon dari aplikasi web:', data);
      // Setelah mendapatkan respons, tambahkan data ke tabel
      tambahDataKeTabel(data);
    })
    .catch((error) => {
      console.error('Terjadi kesalahan:', error);
    });
}

function tambahDataKeTabel(data) {
  const table = document.querySelector('table');

  // Membuat baris baru
  const newRow = table.insertRow();

  // Mengisi kolom-kolom dalam baris
  const cell0 = newRow.insertCell(0); // Nomor Urutan
  const cell1 = newRow.insertCell(1); // Gambar
  const cell2 = newRow.insertCell(2); // Nama
  const cell3 = newRow.insertCell(3); // Tempat Tanggal Lahir
  const cell4 = newRow.insertCell(4); // Jenis Kelamin
  const cell5 = newRow.insertCell(5); // Status
  const cell6 = newRow.insertCell(6); // Pendidikan

  const newData = JSON.parse(data);

  cell0.innerHTML = currentRow++;
  cell1.innerHTML = `<img src="${newData.gambar}" style="max-width: 50px; border-radius: 50%;">`;
  cell2.innerHTML = newData.nama;
  cell3.innerHTML = newData.tempatTanggalLahir;
  cell4.innerHTML = newData.jenisKelamin;
  cell5.innerHTML = newData.status;
  cell6.innerHTML = newData.pendidikan;

  // Reset form setelah data ditambahkan
  resetForm();
}

function resetForm() {
  document.getElementById('anggota-form').reset();
  document.getElementById('gambar-preview').src = ''; // Menghapus gambar preview
}

// Fungsi untuk menampilkan pesan alert tengah layar
function alertCenter(message) {
  const alertBox = document.createElement('div');
  alertBox.className = 'alert-center';
  alertBox.innerHTML = message;
  document.body.appendChild(alertBox);

  // Hilangkan pesan setelah beberapa detik
  setTimeout(() => {
    document.body.removeChild(alertBox);
  }, 3000);
}
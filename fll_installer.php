<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2020-08-15 08:39:32
 * @modify date 2021-06-18 08:39:32
 * @license GPL v3
 */

// Source https://subinsb.com/php-download-extract-zip-archives/
function downloadZipFile($url, $filepath){
    $zipResource = fopen($filepath, "w");
    // Get The Zip File From Server
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
    curl_setopt($ch, CURLOPT_FILE, $zipResource);
    $page = curl_exec($ch);
    if(!$page) {
    echo "Error :- ".curl_error($ch);
    }
    curl_close($ch);

    return (filesize($filepath) > 0)? true : false;
}

// Modified from https://www.php.net/manual/en/ziparchive.extractto.php
function extractZip($file, $extract_to)
{
    $zip = new ZipArchive;
    $res = $zip->open($file);
    if ($res === TRUE) {
        $zip->extractTo($extract_to);
        $zip->close();
        return true;
    } else {
        return false;
    }
}
?>
<!DOCTYPE Html>
<html>
    <head>
        <title>FLL :: Pemasang</title>
        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-400">
        <section class="block w-8/12 bg-white mx-auto p-10 mt-32">
            <h1 class="uppercase font-semibold block text-center mb-5">Surat Bebas Pustaka (FLL) :: v2.1.2</h1>
            <?php
            if (!isset($_GET['do'])):
            ?>
                <p class="mt-5 text-center">Klik "Pasang" untuk memulai proses pemasangan</p>
                <button onclick="window.location = '?do=install'" class="mt-5 font-semibold bg-blue-500 hover:bg-blue-700 w-32 text-white py-2 px-4 rounded-full block mx-auto">
                    <svg width="1em" class="inline-block text-white" height="1em" viewBox="0 0 16 16" style="color: white !important" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M11.646 11.354a.5.5 0 0 1 0-.708L14.293 8l-2.647-2.646a.5.5 0 0 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0z"/>
                        <path fill-rule="evenodd" d="M4.5 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
                        <path fill-rule="evenodd" d="M2 13.5A1.5 1.5 0 0 1 .5 12V4A1.5 1.5 0 0 1 2 2.5h7A1.5 1.5 0 0 1 10.5 4v1.5a.5.5 0 0 1-1 0V4a.5.5 0 0 0-.5-.5H2a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5v-1.5a.5.5 0 0 1 1 0V12A1.5 1.5 0 0 1 9 13.5H2z"/>
                    </svg> Pasang
                </button>
            <?php
            else:
                // cek sysconfig
                if (!file_exists('sysconfig.inc.php')):
                    echo '<div role="alert">
                            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            Galat
                            </div>
                            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <p>File <b>sysconfig.inc.php</b> tidak tersedia. Pastikan anda meletakan file ini pada folder utama <b>SLiMS</b></p>
                            </div>
                        </div>';
                    exit;
                endif;

                // siapkan kunci
                define('INDEX_AUTH', '1');

                // memasukan sysconfig
                include 'sysconfig.inc.php';

                // cek curl
                if (!function_exists('curl_init')):
                    echo '<div role="alert">
                            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            Galat
                            </div>
                            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <p>Ekstensi <b>curl</b> belum terinstall pada PHP yang anda gunakan.Klik <a class="font-bold" href="https://www.google.com/search?sxsrf=ALeKk01xPmnpMhzRYhxSvfV1bWXnHRVLSA%3A1597448435050&ei=8yA3X8bKApGvyAOolIvQCQ&q=%27cara+install+curl+di+php%27++AND+%27Windows%27+OR+%27Linux%27&oq=%27cara+install+curl+di+php%27++AND+%27Windows%27+OR+%27Linux%27&gs_lcp=CgZwc3ktYWIQAzIFCAAQzQI6BAgAEEc6BwgjEK4CECc6BQghEKABOgQIIRAKUMwvWJFHYOVMaABwAXgAgAFviAG_BpIBBDEwLjGYAQCgAQGqAQdnd3Mtd2l6wAEB&sclient=psy-ab&ved=0ahUKEwiGkJKU75vrAhWRF3IKHSjKApoQ4dUDCAs&uact=5" target="blank">Disini untuk Cari solusinya.</a></p>
                            </div>
                        </div>';
                endif;

                // cek zip
                if (!class_exists('ZipArchive')):
                    echo '<div role="alert">
                            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            Galat
                            </div>
                            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <p>Ekstensi <b>zip</b> belum terinstall pada PHP yang anda gunakan.Klik <a class="font-bold" href="https://www.google.com/search?sxsrf=ALeKk03I9CTFD8iwtBDEJ8KrUdfHJa_k4A%3A1597448729089&ei=GSI3X6L1BI-8rQG7npa4BA&q=%27cara+install+ekstensi+ziparchive+di+php%27++AND+%27Windows%27+OR+%27Linux%27&oq=%27cara+install+ekstensi+ziparchive+di+php%27++AND+%27Windows%27+OR+%27Linux%27&gs_lcp=CgZwc3ktYWIQAzoECAAQR1CNRFjBS2CdTWgAcAF4AIABTogB-gOSAQE3mAEAoAEBqgEHZ3dzLXdpesABAQ&sclient=psy-ab&ved=0ahUKEwji5ayg8JvrAhUPXisKHTuPBUcQ4dUDCAs&uact=5" target="blank">Disini untuk Cari solusinya.</a></p>
                            </div>
                        </div>';
                endif;

                // cek akses ke folder module dan file
                $folder = '';

                if (!is_writable(MDLBS)):
                    $folder .= '<b>admin/modules/</b>';
                endif;

                if (!empty($folder)):
                    echo '<div role="alert">
                            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            Galat
                            </div>
                            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <p>Folder '.$folder.' tidak dapat ditulis. Pastikan folder tersebut dapat ditulis.</p>
                            </div>
                        </div>';
                endif;

                // Proses instalasi
                /* set url */
                $url  = 'https://codeload.github.com/drajathasan/fll/zip/refs/heads/master';
                $file = MDLBS.'membership/fll.zip';
                /* Download */
                if (!downloadZipFile($url, $file)):
                    echo '<div role="alert">
                            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            Galat
                            </div>
                            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <p>Gagal mengunduh plugin, pastikan koneksi internet anda lancar dan folder admin/modules/ dapat ditulis.</p>
                            </div>
                        </div>'; 
                endif;

                // ekstrak file zip
                if (extractZip($file, MDLBS.'membership/')):
                    
                    if (file_exists(MDLBS.'membership/fll/')):
                        rmdir(MDLBS.'membership/fll/');
                    endif;
            
                    if (!rename(MDLBS.'membership/fll-master', MDLBS.'membership/fll/')):
                        echo '<div role="alert">
                            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            Galat
                            </div>
                            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <p>Gagal ekstrak file, pastikan folder admin/modules/ dapat ditulis.</p>
                            </div>
                        </div>';  
                    endif;
                else:
                    echo '<div role="alert">
                            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            Galat
                            </div>
                            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <p>Gagal ekstrak file, pastikan folder admin/modules/ dapat ditulis.</p>
                            </div>
                        </div>';  
                endif;

                // Menambahkan menu
                $submenu = file_get_contents(MDLBS.'membership/submenu.php');

                // tambah menu
                $submenu = str_replace(["\$menu[] = array('Header', __('Tools'));","\$menu[] = array('Header', __('TOOLS'));"],
                                       "\$menu[] = array('Header', 'Plugin Custom');\n\$menu[] = array('Surat Bebas Pustaka', MWB.'membership/fll/member_free_loan_letter.php', 'Cetak Bebas Pustak');\n\$menu[] = array('Tambah Judul Skripsi', MWB.'membership/fll/add_essay.php', 'Masukan judul skripsi');\n\$menu[] = array('Header', __('Tools'));",
                                       $submenu
                                      );
                // save file
                if (!file_put_contents(MDLBS.'membership/submenu.php', $submenu)):
                    echo '<div role="alert">
                            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            Galat
                            </div>
                            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <p>Gagal menambah menu di file submenu.php, pastikan folder admin/modules/ dapat ditulis.</p>
                            </div>
                        </div>';
                else:
                    // run query
                    $colExsits = $dbs->query('describe member member_essay');
                    $errorCreateColumn = false;
                    if ($colExsits->num_rows === 0):
                        $query = 'ALTER TABLE `member` ADD `member_essay` text COLLATE \'utf8_unicode_ci\' NULL AFTER `member_email`';
                        if (!$dbs->query($query)):
                            $errorCreateColumn = true;
                        endif;
                    endif;

                    // hapus file yang tidak perlu
                    $hapusfile = '';
                    if (!unlink($file)):
                        $hapusfile = '<b>'.$file.', </b>';
                    endif;

                    if (!unlink(SB.'fll_installer.php')):
                        $hapusfile .= '<b>'.SB.'fll_installer.php</b>';
                    endif;
                    
                    if (!empty($hapusfile)):
                        echo '<div role="alert">
                            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            Galat
                            </div>
                            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <p>File '.$hapusfile.' tidak dapat dihapus. Segara hapus untuk kenyamanan SLiMS anda :)</p>
                            </div>
                        </div><br/>';
                    endif;

                    if ($errorCreateColumn):
                        echo '<div role="alert">
                            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            Galat
                            </div>
                            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <p>Gagal membuat kolom member_essay di tabel member, silahkan jalankan query dibawah berikut di database manager kesayangan anda</p>
                            <code>ALTER TABLE `member` ADD `member_essay` text COLLATE \'utf8_unicode_ci\' NULL AFTER `member_email`</code>
                            </div>
                        </div><br/>';
                    endif;

                    // siapkan pesan
                    echo '<div role="alert">
                            <div class="bg-green-500 text-white font-bold rounded-t px-4 py-2">
                            Sukses
                            </div>
                            <div class="border border-t-0 border-green-400 rounded-b bg-green-100 px-4 py-3 text-green-700">
                            <p>
                                Berhasil menginstall plugin, sekarang login dan coba :D. 
                                <button onclick="window.location = \''.SWB.'?p=login\'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                                    Ayo, Coba...
                                </button>
                            </p>
                            </div>
                        </div>';                      
                endif;
            endif;
            ?>
        </section>
    </body>
</html>

<script>
    if (!window.navigator.onLine)
    {
        alert('Tidak ada koneksi internet. Instalasi tidak akan lancar.');
    }
</script>
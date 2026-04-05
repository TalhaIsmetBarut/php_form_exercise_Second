<?php
session_start();


function temizle($veri) {
    if (is_array($veri)) {
        return array_map('temizle', $veri);
    }
    return htmlspecialchars(strip_tags(trim($veri)), ENT_QUOTES, 'UTF-8');
}

$hatalar  = [];
$degerler = [
    'ad'             => '',
    'soyad'          => '',
    'tc_no'          => '',
    'eposta'         => '',
    'sifre'          => '',
    'dogum_tarihi'   => '',
    'randevu_saati'  => '',
    'cinsiyet'       => '',
    'pozisyon'       => '',
    'beceriler'      => [],
    'diller'         => [],
    'tecrube'        => '0',
    'renk'           => '#1a3a6b',
    'dosya'          => '',
    'onyazi'         => '',
    'kvkk'           => '',
];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $degerler['ad']             = temizle($_POST['ad']             ?? '');
    $degerler['soyad']          = temizle($_POST['soyad']          ?? '');
    $degerler['tc_no']          = temizle($_POST['tc_no']          ?? '');
    $degerler['eposta']         = temizle($_POST['eposta']         ?? '');
    $degerler['sifre']          = $_POST['sifre']                  ?? ''; // Şifre temizlenmez genelde (htmlspecialchars hariç)
    $degerler['dogum_tarihi']   = temizle($_POST['dogum_tarihi']   ?? '');
    $degerler['randevu_saati']  = temizle($_POST['randevu_saati']  ?? '');
    $degerler['cinsiyet']       = temizle($_POST['cinsiyet']       ?? '');
    $degerler['pozisyon']       = temizle($_POST['pozisyon']       ?? '');
    $degerler['beceriler']      = temizle($_POST['beceriler']      ?? []);
    $degerler['diller']         = temizle($_POST['diller']         ?? []);
    $degerler['tecrube']        = temizle($_POST['tecrube']        ?? '0');
    $degerler['renk']           = temizle($_POST['renk']           ?? '#1a3a6b');
    $degerler['onyazi']         = temizle($_POST['onyazi']         ?? '');
    $degerler['kvkk']           = $_POST['kvkk']                   ?? '';

    
    $degerler['dosya'] = $_FILES['dosya']['name'] ?? '';

    
    if ($degerler['ad'] === '') $hatalar['ad'] = 'Ad alanı zorunludur.';
    if ($degerler['soyad'] === '') $hatalar['soyad'] = 'Soyad alanı zorunludur.';
    
    if ($degerler['tc_no'] === '') {
        $hatalar['tc_no'] = 'TC No zorunludur.';
    } elseif (strlen($degerler['tc_no']) !== 11) {
        $hatalar['tc_no'] = 'TC No 11 hane olmalıdır.';
    }

    if ($degerler['eposta'] === '' || !filter_var($degerler['eposta'], FILTER_VALIDATE_EMAIL)) {
        $hatalar['eposta'] = 'Geçerli bir e-posta adresi giriniz.';
    }

    if (strlen($degerler['sifre']) < 6) {
        $hatalar['sifre'] = 'Şifre en az 6 karakter olmalıdır.';
    }

    if ($degerler['dogum_tarihi'] === '') $hatalar['dogum_tarihi'] = 'Doğum tarihi seçilmelidir.';
    if ($degerler['cinsiyet'] === '') $hatalar['cinsiyet'] = 'Cinsiyet seçilmelidir.';
    if ($degerler['pozisyon'] === '') $hatalar['pozisyon'] = 'Pozisyon seçilmelidir.';
    if ($degerler['kvkk'] === '') $hatalar['kvkk'] = 'KVKK metnini onaylamanız gerekmektedir.';


    if (empty($hatalar)) {
        $_SESSION['form_data'] = $degerler;
        header('Location: sonuc.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İş Başvuru Portalı - Kariyer</title>
    <style>
        :root {
            --primary-color: #1a3a6b;
            --bg-color: #f4f7f6;
            --text-color: #333;
            --border-color: #d1d1d1;
            --error-color: #cc0000;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-top: 5px solid var(--primary-color);
        }

        header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }

        header h1 {
            margin: 0;
            color: var(--primary-color);
            font-size: 24px;
        }

        header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 14px;
        }

        .form-section {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .form-section h2 {
            font-size: 16px;
            color: #555;
            text-transform: uppercase;
            margin-bottom: 15px;
            border-left: 4px solid var(--primary-color);
            padding-left: 10px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            font-size: 14px;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        input[type="time"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
            transition: border 0.3s;
        }

        input:focus, select:focus, textarea:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 5px rgba(26,58,107,0.2);
        }

        input.hatali {
            border-color: var(--error-color);
            background-color: #fff8f8;
        }

        .hata-mesaji {
            color: var(--error-color);
            font-size: 12px;
            margin-top: 4px;
        }

        .checkbox-group, .radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 5px;
        }

        .checkbox-group label, .radio-group label {
            font-weight: normal;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .range-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        input[type="range"] {
            flex: 1;
        }

        input[type="color"] {
            height: 40px;
            width: 80px;
            padding: 2px;
            cursor: pointer;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        .btn-submit {
            display: block;
            width: 100%;
            background-color: var(--primary-color);
            color: white;
            padding: 14px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: #14305a;
        }

        .kvkk-label {
            font-size: 13px;
            font-weight: normal;
            color: #555;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>İş Başvuru Formu</h1>
        <p>Lütfen tüm alanları profesyonel bir şekilde doldurunuz.</p>
    </header>

    <form action="index.php" method="POST" enctype="multipart/form-data">
        

        <div class="form-section">
            <h2>Kişisel Bilgiler</h2>
            <div class="form-row">
                <div class="form-group">
                    <label for="ad">Ad *</label>
                    <input type="text" id="ad" name="ad" value="<?= $degerler['ad'] ?>" class="<?= isset($hatalar['ad']) ? 'hatali' : '' ?>">
                    <?php if (isset($hatalar['ad'])): ?><div class="hata-mesaji"><?= $hatalar['ad'] ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="soyad">Soyad *</label>
                    <input type="text" id="soyad" name="soyad" value="<?= $degerler['soyad'] ?>" class="<?= isset($hatalar['soyad']) ? 'hatali' : '' ?>">
                    <?php if (isset($hatalar['soyad'])): ?><div class="hata-mesaji"><?= $hatalar['soyad'] ?></div><?php endif; ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="tc_no">TC Kimlik No * (11 Hane)</label>
                    <input type="text" id="tc_no" name="tc_no" value="<?= $degerler['tc_no'] ?>" maxlength="11" pattern="\d{11}" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="<?= isset($hatalar['tc_no']) ? 'hatali' : '' ?>">
                    <?php if (isset($hatalar['tc_no'])): ?><div class="hata-mesaji"><?= $hatalar['tc_no'] ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="dogum_tarihi">Doğum Tarihi *</label>
                    <input type="date" id="dogum_tarihi" name="dogum_tarihi" value="<?= $degerler['dogum_tarihi'] ?>" class="<?= isset($hatalar['dogum_tarihi']) ? 'hatali' : '' ?>">
                    <?php if (isset($hatalar['dogum_tarihi'])): ?><div class="hata-mesaji"><?= $hatalar['dogum_tarihi'] ?></div><?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label>Cinsiyet *</label>
                <div class="radio-group">
                    <label><input type="radio" name="cinsiyet" value="Erkek" <?= $degerler['cinsiyet'] === 'Erkek' ? 'checked' : '' ?>> Erkek</label>
                    <label><input type="radio" name="cinsiyet" value="Kadın" <?= $degerler['cinsiyet'] === 'Kadın' ? 'checked' : '' ?>> Kadın</label>
                    <label><input type="radio" name="cinsiyet" value="Belirtmek İstemiyorum" <?= $degerler['cinsiyet'] === 'Belirtmek İstemiyorum' ? 'checked' : '' ?>> Belirtmek İstemiyorum</label>
                </div>
                <?php if (isset($hatalar['cinsiyet'])): ?><div class="hata-mesaji"><?= $hatalar['cinsiyet'] ?></div><?php endif; ?>
            </div>
        </div>


        <div class="form-section">
            <h2>İletişim ve Hesap</h2>
            <div class="form-row">
                <div class="form-group">
                    <label for="eposta">E-posta Adresi *</label>
                    <input type="email" id="eposta" name="eposta" value="<?= $degerler['eposta'] ?>" placeholder="örnek@firma.com" class="<?= isset($hatalar['eposta']) ? 'hatali' : '' ?>">
                    <?php if (isset($hatalar['eposta'])): ?><div class="hata-mesaji"><?= $hatalar['eposta'] ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="sifre">Başvuru Takip Şifresi *</label>
                    <input type="password" id="sifre" name="sifre" placeholder="En az 6 karakter" class="<?= isset($hatalar['sifre']) ? 'hatali' : '' ?>">
                    <?php if (isset($hatalar['sifre'])): ?><div class="hata-mesaji"><?= $hatalar['sifre'] ?></div><?php endif; ?>
                </div>
            </div>
        </div>


        <div class="form-section">
            <h2>Mesleki Bilgiler</h2>
            <div class="form-group">
                <label for="pozisyon">Başvurulan Pozisyon *</label>
                <select id="pozisyon" name="pozisyon" class="<?= isset($hatalar['pozisyon']) ? 'hatali' : '' ?>">
                    <option value="">-- Lütfen Seçiniz --</option>
                    <option value="Yazılım Geliştirici" <?= $degerler['pozisyon'] === 'Yazılım Geliştirici' ? 'selected' : '' ?>>Yazılım Geliştirici</option>
                    <option value="UI/UX Tasarımcı" <?= $degerler['pozisyon'] === 'UI/UX Tasarımcı' ? 'selected' : '' ?>>UI/UX Tasarımcı</option>
                    <option value="Proje Yöneticisi" <?= $degerler['pozisyon'] === 'Proje Yöneticisi' ? 'selected' : '' ?>>Proje Yöneticisi</option>
                    <option value="Pazarlama Uzmanı" <?= $degerler['pozisyon'] === 'Pazarlama Uzmanı' ? 'selected' : '' ?>>Pazarlama Uzmanı</option>
                </select>
                <?php if (isset($hatalar['pozisyon'])): ?><div class="hata-mesaji"><?= $hatalar['pozisyon'] ?></div><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="beceriler">Teknik Beceriler (Çoklu Seçim - Ctrl ile seçiniz)</label>
                <select id="beceriler" name="beceriler[]" multiple style="height: 100px;">
                    <option value="PHP" <?= in_array('PHP', $degerler['beceriler']) ? 'selected' : '' ?>>PHP</option>
                    <option value="JavaScript" <?= in_array('JavaScript', $degerler['beceriler']) ? 'selected' : '' ?>>JavaScript</option>
                    <option value="Python" <?= in_array('Python', $degerler['beceriler']) ? 'selected' : '' ?>>Python</option>
                    <option value="SQL" <?= in_array('SQL', $degerler['beceriler']) ? 'selected' : '' ?>>SQL</option>
                    <option value="React" <?= in_array('React', $degerler['beceriler']) ? 'selected' : '' ?>>React</option>
                </select>
            </div>

            <div class="form-group">
                <label>Bilinen Yabancı Diller</label>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="diller[]" value="İngilizce" <?= in_array('İngilizce', $degerler['diller']) ? 'checked' : '' ?>> İngilizce</label>
                    <label><input type="checkbox" name="diller[]" value="Almanca" <?= in_array('Almanca', $degerler['diller']) ? 'checked' : '' ?>> Almanca</label>
                    <label><input type="checkbox" name="diller[]" value="Fransızca" <?= in_array('Fransızca', $degerler['diller']) ? 'checked' : '' ?>> Fransızca</label>
                    <label><input type="checkbox" name="diller[]" value="İspanyolca" <?= in_array('İspanyolca', $degerler['diller']) ? 'checked' : '' ?>> İspanyolca</label>
                </div>
            </div>

            <div class="form-group">
                <label for="tecrube">Tecrübe (Yıl: <span id="tecrubeDeger"><?= $degerler['tecrube'] ?></span>)</label>
                <div class="range-container">
                    <span>0</span>
                    <input type="range" id="tecrube" name="tecrube" min="0" max="40" value="<?= $degerler['tecrube'] ?>" oninput="document.getElementById('tecrubeDeger').innerHTML = this.value">
                    <span>40+</span>
                </div>
            </div>
        </div>


        <div class="form-section">
            <h2>Tercihler ve Dosyalar</h2>
            <div class="form-row">
                <div class="form-group">
                    <label for="randevu_saati">Uygun Mülakat Saati</label>
                    <input type="time" id="randevu_saati" name="randevu_saati" value="<?= $degerler['randevu_saati'] ?>">
                </div>
                <div class="form-group">
                    <label for="renk">Tercih Edilen Profil Rengi</label>
                    <input type="color" id="renk" name="renk" value="<?= $degerler['renk'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="dosya">CV / Özgeçmiş Yükle (PDF/DOC)</label>
                <input type="file" id="dosya" name="dosya" accept=".pdf,.doc,.docx">
            </div>

            <div class="form-group">
                <label for="onyazi">Önyazı / Kendinizden Bahsedin</label>
                <textarea id="onyazi" name="onyazi" placeholder="Neden sizi seçmeliyiz?"><?= $degerler['onyazi'] ?></textarea>
            </div>
        </div>


        <div class="form-group">
            <label class="kvkk-label">
                <input type="checkbox" name="kvkk" value="onay" <?= $degerler['kvkk'] === 'onay' ? 'checked' : '' ?>>
                KVKK Aydınlatma Metnini okudum ve verilerimin işlenmesini kabul ediyorum. *
            </label>
            <?php if (isset($hatalar['kvkk'])): ?><div class="hata-mesaji"><?= $hatalar['kvkk'] ?></div><?php endif; ?>
        </div>

        <button type="submit" class="btn-submit">Başvuruyu Tamamla</button>

    </form>
</div>

<footer>
    &copy; <?= date('Y') ?> T1B Portalı &ndash; Tüm Hakları Saklıdır.
</footer>

</body>
</html>

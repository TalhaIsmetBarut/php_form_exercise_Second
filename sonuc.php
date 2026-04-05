<?php
session_start();

if (empty($_SESSION['form_data'])) {
    header('Location: index.php');
    exit;
}

$data = $_SESSION['form_data'];
unset($_SESSION['form_data']); 

$tarih = date('d.m.Y - H:i');
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Başvuru Alındı - Kariyer Portalı</title>
    <style>
        :root {
            --primary-color: #1a3a6b;
            --bg-color: #f4f7f6;
            --text-color: #333;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #eee;
            margin-bottom: 25px;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #2e7d32;
            font-size: 24px;
            margin: 0;
        }

        .success-banner {
            background-color: #e8f5e9;
            border: 1px solid #a5d6a7;
            color: #2e7d32;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }

        table th {
            background-color: #f8f9fa;
            width: 200px;
            color: var(--primary-color);
            font-weight: 600;
        }

        .color-preview {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 1px solid #ccc;
            vertical-align: middle;
            margin-right: 5px;
        }

        .badge {
            display: inline-block;
            background: #e1e8f0;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            margin-right: 5px;
            margin-bottom: 5px;
            color: #1a3a6b;
        }

        .onyazi-box {
            background: #f9f9f9;
            padding: 10px;
            border: 1px dashed #ccc;
            border-radius: 4px;
            white-space: pre-wrap;
            font-style: italic;
        }

        .footer-nav {
            margin-top: 30px;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .btn-back {
            text-decoration: none;
            color: var(--primary-color);
            font-weight: bold;
        }

        .btn-back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Başvurunuz Alındı!</h1>
        <p>İş başvuru kaydınız başarıyla sisteme iletilmiştir.</p>
    </div>

    <div class="success-banner">
        ✓ Başvuru Tamamlandı - Referans No: <?= time() ?>
    </div>

    <table>
        <tr>
            <th>Ad Soyad</th>
            <td><?= $data['ad'] . ' ' . $data['soyad'] ?></td>
        </tr>
        <tr>
            <th>TC Kimlik No</th>
            <td><?= $data['tc_no'] ?></td>
        </tr>
        <tr>
            <th>E-posta</th>
            <td><?= $data['eposta'] ?></td>
        </tr>
        <tr>
            <th>Şifre</th>
            <td>******** (Güvenlik nedeniyle gizlenmiştir)</td>
        </tr>
        <tr>
            <th>Doğum Tarihi</th>
            <td><?= date('d/m/Y', strtotime($data['dogum_tarihi'])) ?></td>
        </tr>
        <tr>
            <th>Cinsiyet</th>
            <td><?= $data['cinsiyet'] ?></td>
        </tr>
        <tr>
            <th>Başvurulan Pozisyon</th>
            <td><strong><?= $data['pozisyon'] ?></strong></td>
        </tr>
        <tr>
            <th>Teknik Beceriler</th>
            <td>
                <?php if (!empty($data['beceriler'])): ?>
                    <?php foreach ($data['beceriler'] as $beceri): ?>
                        <span class="badge"><?= $beceri ?></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    Belirtilmedi
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Yabancı Diller</th>
            <td>
                <?php if (!empty($data['diller'])): ?>
                    <?php foreach ($data['diller'] as $dil): ?>
                        <span class="badge"><?= $dil ?></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    Belirtilmedi
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Tecrübe Seviyesi</th>
            <td><?= $data['tecrube'] ?> Yıl</td>
        </tr>
        <tr>
            <th>Mülakat Uygunluk Saati</th>
            <td><?= $data['randevu_saati'] ?: 'Belirtilmedi' ?></td>
        </tr>
        <tr>
            <th>Profil Tercih Rengi</th>
            <td>
                <span class="color-preview" style="background-color: <?= $data['renk'] ?>;"></span>
                <?= strtoupper($data['renk']) ?>
            </td>
        </tr>
        <tr>
            <th>CV / Özgeçmiş</th>
            <td><?= $data['dosya'] ?: 'Yüklenmedi' ?></td>
        </tr>
        <tr>
            <th>Önyazı</th>
            <td>
                <div class="onyazi-box"><?= nl2br($data['onyazi']) ?: 'Boş bırakıldı.' ?></div>
            </td>
        </tr>
        <tr>
            <th>KVKK Onayı</th>
            <td><?= $data['kvkk'] === 'onay' ? 'Kabul Edildi' : 'Hata' ?></td>
        </tr>
    </table>

    <p style="font-size: 12px; color: #888; text-align: center;">
        Bu başvuru <?= $tarih ?> tarihinde kaydedilmiştir.
    </p>

    <div class="footer-nav">
        <a href="index.php" class="btn-back">&larr; Yeni Başvuru Oluştur</a>
    </div>
</div>

</body>
</html>

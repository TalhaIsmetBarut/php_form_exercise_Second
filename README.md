# 🏛️ T1B İş Başvuru Portalı

Bu proje, modern web standartlarına uygun, kullanıcı dostu ve toplam **15 farklı form bileşeninden** oluşan kapsamlı bir iş başvuru sistemidir. PHP ve HTML5 teknolojileri kullanılarak geliştirilmiştir.

## 🚀 Özellikler

- **15+ Form Bileşeni:** HTML5'in sunduğu tüm temel ve gelişmiş girdi tipleri (Date, Range, Color, File, Select Multiple vb.) kullanılmıştır.
- **Dinamik Doğrulama:** PHP tarafında sunucu tabanlı (Server-side) veri doğrulama ve temizleme (Sanitization).
- **Session Yönetimi:** Form verileri güvenli bir şekilde oturum (Session) üzerinden sonuç sayfasına aktarılır.
- **Sade ve Profesyonel Tasarım:** Okul projesi gereksinimlerine uygun, göz yormayan, akademik ve kurumsal bir arayüz.
- **TC Kimlik Kontrolü:** 11 hane sınırlaması ve sadece rakam girişi özelliği.

## 🛠️ Kullanılan Bileşenler

Sistem içerisinde aşağıdaki 15 adet form bileşeni aktif olarak çalışmaktadır:

1.  **Metin Kutusu (Ad)**
2.  **Metin Kutusu (Soyad)**
3.  **TC Kimlik Girişi (Rakam sınırlı)**
4.  **E-Posta Girişi**
5.  **Şifre Girişi (Maskelenmiş)**
6.  **Doğum Tarihi Seçici (Takvim)**
7.  **Mülakat Saati Seçici**
8.  **Cinsiyet Seçimi (Radyo Butonları)**
9.  **Pozisyon Seçimi (Açılır Liste)**
10. **Teknik Beceriler (Çoklu Seçim - Multiple Select)**
11. **Yabancı Diller (Onay Kutuları - Checkbox Group)**
12. **Tecrübe Seviyesi (Kaydırma Çubuğu - Range)**
13. **Profil Rengi Seçici (Color Picker)**
14. **Dosya Yükleme (Özgeçmiş/CV)**
15. **Önyazı Alanı (Büyük Metin Alanı - Textarea)**
16. **KVKK Onayı (Tekli Onay Kutusu)**

## 📂 Dosya Yapısı

- `index.php`: Ana form sayfası ve doğrulama mantığı.
- `sonuc.php`: Başvuru özeti ve veri gösterim sayfası.
- `README.md`: Proje dokümantasyonu.

## 💻 Kurulum

1. Proje dosyalarını XAMPP veya benzeri bir PHP sunucusunun `htdocs` klasörüne kopyalayın.
2. Tarayıcınızdan `http://localhost/.../index.php` adresine gidin.
3. Formu doldurup "Başvuruyu Tamamla" butonuna tıklayarak sonuç sayfasını görün.

---
*Bu proje bir eğitim çalışması kapsamında geliştirilmiştir.*

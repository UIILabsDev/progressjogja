# progressjogja
This is Islamic University of Indonesia Labs Projects

# Tutorial Instalasi
```
  1. Buat dulu Account github
  2. Download Software Git disini http://git-scm.com/downloads
  3. Jangan lupa Install juga WT-NMP (seperti xampp, tapi menggunakan Nginx, sedangkan kalau
  xampp mnggunakan Apache). Download >> https://sourceforge.net/projects/wtnmp/files/latest/download
  4. Install dan jalankan Git Bash
  5. Kemudian pindahkan direktori Terminal Git Bash ke folder WWW milik WT-NMP. Caranya ketikkan
        $ cd /c/WT-NMP/WWW
  6. Kemudian buat sebuah folder baru, misalnya INVOSE
        $ mkdir INVOSE
  7. Setelah itu pindah ke direktori INVOSE
        $ cd INVOSE
  8. Setelah itu ketikkan (satu2) :
        $ git config --global user.name "Username_Github"
        $ git config --global user.email "Email_Github"
  9. Agar bisa melakukan push dan pull di github, harus ada yg namanya pairing (disini menggunakan ssh)
     Ketikkan perintahnya satu-satu (satu enter, satu enter) :
        $ cd
        $ ssh-keygen -t rsa -C "your_email@example.com"
  10. Kemudian akan keluar tulisan "Enter file in which to save the key...bla bla bla" (tekan enter saja)
      Kemudian akan keluar tulisan "Enter passphrase...", ketikkan password untuk koneksi ssh dan
      kemudian akan muncul lagi, ketikkan passwordnya lagi. Kemudian ketikkan perintah lagi :
        $ ssh-agent -s
        $ ssh-add ~/.ssh/id_rsa
        $ clip < ~/.ssh/id_rsa.pub
  11. Setelah itu, buka GitHub. Kemudian lihat di pojok kanan atas, dan klik Settings. Setelah itu,
      masuk ke "SSH Keys" (di samping). Dan klik Add SSH Key, setelah itu ketikkan judulnya terserah.
      Kemudian tekan CTRL + V di box "Key". Klik Add Key, DONE.
      
      IT'S TIME TO START. LET'S WRITE A CODE :)
```

# Keterangan
```
  Jadi, Versioning Control itu cara kerja para software developer zaman sekarang dengan memanfaatkan
  Github sebagai tempat untuk menghubungkan mereka semua. Jadi, ketika kita membangun sebuah website,
  kita tentunya (kebanyakan) melakukan development di localhost bukan? Nah, karena pekerjaan itu adalah
  sebuah team work, maka dibangunlah sebuah jalan untuk menghubungkan itu semua.
  
  Jadi, ketika seseorang sudah selesai dengan bagian yang mereka kerjakan, mereka bisa memperbaharui
  repositori ini dengan yang baru, sehingga kita bisa tetap terhubung dengan team walaupun berbeda PC.
```

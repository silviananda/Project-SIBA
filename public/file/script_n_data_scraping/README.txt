README :

A. Scraping Halaman Utama profile google scholar
1. File crawling_scraping_revisi_utama_update_data.py adalah script pertama yang dijalankan dengan menggunakan file data dataset_rp2u.csv(hanya data dengan nama dosen tertentu)
2. Syntax Cara menjalankannya dengan terminal adalah : python crawling_revisi_utama_update_data.py 0 10
	-> argv[0] = nama file
	-> argv[1] = int start 
	-> argv[2] = int ending
3. argv[1] dan argv[2] adalah range permulaan scraping, untuk awal diawali dengan 0 pada argv[1].
4. Hasil yang didapatkan data dalam format file csv.

B. Scraping Halaman detail judul publikasi google scholar
1. File crawling_scraping_revisi_detail_title_update_data.py adalah script kedua yang dijalankan setelah data halaman utama didapakan, dengan menggunakan file data data_0.csv(data keseluruhan judul dari halaman utama profile google scholar)
2. Syntax Cara menjalankannya dengan terminal adalah : python crawling_revisi_detail_title_update_data.py 0 10
	-> argv[0] = nama file
	-> argv[1] = int start 
	-> argv[2] = int ending
3. argv[1] dan argv[2] adalah range permulaan scraping, untuk awal diawali dengan 0 pada argv[1].
4. Hasil yang didapatkan data dalam format file csv.

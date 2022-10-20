from bs4 import BeautifulSoup
from itertools import zip_longest
import csv
from collections import defaultdict
import time
import random

"""
fungsi proses untuk scraping data bersih
halaman profil utama google scholar
"""
def ambil_data(filename,index,x,list_fak):
	dokumen = open(filename, "r")
	bsoup = BeautifulSoup(dokumen, 'html.parser')
	name = bsoup.find('div', attrs={'id' : 'gsc_prf_in'}).text.strip()
	print("====")
	print(name)

	list_title = []
	list_link_title_detail = []
	titles = bsoup.find_all('td', class_='gsc_a_t')
	for get_title in titles:
		title = get_title.find('a').text.strip()
		link_title_detail = get_title.find('a').attrs['href']
		#print(title_detail)
		list_title.append(title)
		list_link_title_detail.append(link_title_detail)
    	#print(title)

	print("====")
	print(list_title)
	print("====")
	print(list_link_title_detail)

	list_year = []
	years = bsoup.find_all('td', class_='gsc_a_y')
	for get_year in years:
		year = get_year.find('span').text.strip()
		list_year.append(year)
    	#print(title)

	print("====")
	print(list_year)

	max_data = len(list_title)
	print(max_data)
	nm = [name] * max_data
	fak = list_fak[index]
	fakultas = [fak] * max_data
	#print(nm)

	dict_data = {}
	dict_data["Name"] = nm
	dict_data["Faculty"] = fakultas
	dict_data["Document"] = list_title
	dict_data["Year"] = list_year
	dict_data['Link Detail Title'] = list_link_title_detail

	print("====")
	print(dict_data)

	# mulai memasukkan data bersih di simpan ke dalam file csv
	transposed_data = list(zip_longest(*dict_data.values()))
	with open('data_0.csv', 'a+', newline='') as f:
		writer = csv.writer(f)
		# writer.writerow(dict_data.keys())
		# for items in transposed_data:
		# 	writer.writerow(items)
		if(index == 0):
			if(x == 0):
				writer.writerow(dict_data.keys())
				for items in transposed_data:
					writer.writerow(items)
			else:
				for items in transposed_data:
					writer.writerow(items)
		else:
			for items in transposed_data:
				writer.writerow(items)
	
	print('selesai membuat file!')
	print("====")

#===============================================
"""
fungsi untuk menyimpan data 
html setelah berhasil request
"""
def simpan_data(soup,index,count):
	#filename = "data_profil_"+str(index)+"_"+str(count)+".html"
	filename = "data_profil_"+str(index)+"_"+str(count)+".html"
	with open(filename,"w") as fp:
   		fp.write(soup.decode('utf-8'))
	print("selesai simpan HTML!")

	return filename

#===============================================
"""
fungsi proses untuk scraping data bersih 
data detail title dokumen dari
halaman profil utama google scholar
"""
def ambil_data_detail_title(page, type_doc, dict_detail_title):
	soup = BeautifulSoup(page.content, 'html.parser')
	sec = random.randint(1,100)
	print('Akan break dalam ' + str(sec) + ' detik..')
	time.sleep(sec)
	print('====================')

	detail_title = []
	details = soup.find_all('div', class_='gs_scl')
	for get_detail in details:
		field = get_detail.find('div', class_='gsc_oci_field').text.strip()
		detail_title.append(field)
		val = get_detail.find('div', class_='gsc_oci_value').text.strip()
		detail_title.append(val)

	print(detail_title)
	print('====================')

	#intersection(sama) value antara 2 list untuk tipedoc jurnal/konferensi
	return_type_doc = (list(set(detail_title).intersection(type_doc)))
	print(return_type_doc)

	# Convert list of items to a string value
	final_str = ''.join(return_type_doc)
	#print(final_str)
	if (final_str == ''):
		final_str = 'Tidak Diketahui'

	print(final_str	)
	print('====================')
	#dict_detail_title['Document_Type'] = [final_str]
	dict_detail_title['Document Type'].append(final_str)

	temp_keys = ['Name','Document Type']
	for detail in detail_title:
		if detail in type_doc:
			#print(detail)
			idx = detail_title.index(detail)
			idx += 1
			#dict_detail_title['Name_Of_Document_Type'] = [detail_title[idx]]
			dict_detail_title['Name Of Document Type'].append(detail_title[idx])
			temp_keys.append('Name Of Document Type')
		elif detail in dict_detail_title.keys():
			#print(detail)
			idx = detail_title.index(detail)
			idx += 1
			#dict_detail_title[detail] = [detail_title[idx]]
			dict_detail_title[detail].append(detail_title[idx])
			temp_keys.append(detail)


	list_difference = [item for item in dict_detail_title.keys() if item not in temp_keys]
	for item in list_difference:
		dict_detail_title[item].append('None')

	print(temp_keys)
	print('====================')
	del temp_keys
	print(list_difference)
	print('====================')
	del list_difference

	return dict_detail_title

#===============================================
"""
fungsi untuk menyimpan data bersih detail ke csv
"""
def menyimpan_data_detail(dict_detail_title, mulai):
	# mulai memasukkan data bersih di simpan ke dalam file csv
	transposed_data = list(zip_longest(*dict_detail_title.values()))
	with open('data_detail_on.csv', 'a+', newline='') as f:
		writer = csv.writer(f)
		# writer.writerow(dict_detail_title.keys())
		# for items in transposed_data:
		# 	writer.writerow(items)
		if(mulai == 0):
			writer.writerow(dict_detail_title.keys())
			for items in transposed_data:
				writer.writerow(items)
		else:
			for items in transposed_data:
				writer.writerow(items)


	print('selesai membuat file!')
	print('============================')

#===============================================
"""
fungsi untuk menggabungkan data dari 2 file csv berbeda
data tentang detail title dengan data utama
"""
def gabung_data_csv(ending, links_detail):
	if (ending == len(links_detail)):

		f = 'data_0.csv'

		dict_of_lists = defaultdict(list)
		for record in csv.DictReader(open(f)):
		    for key, val in record.items():
		        dict_of_lists[key].append(val)


		print(dict_of_lists)
		print(dict_of_lists.keys())
		del dict_of_lists['Link Detail Title']
		a = dict(dict_of_lists)
		print(a)
		print(type(a))
		print('============================')

		fa = 'data_detail_on.csv'

		dict_of_lists_fa = defaultdict(list)
		for record in csv.DictReader(open(fa)):
		    for key, val in record.items():
		        dict_of_lists_fa[key].append(val)


		del dict_of_lists_fa['Name']
		b = dict(dict_of_lists_fa)
		print(b)
		print(type(b))

		#update dict menjadi 1
		dict_of_lists.update(dict_of_lists_fa)
		print(dict_of_lists)
		print(dict_of_lists.keys())

		# mulai memasukkan gabungan data bersih di simpan ke dalam file csv
		transposed_data = list(zip_longest(*dict_of_lists.values()))
		with open('data_gabung_semua.csv', 'a+', newline='') as f:
			writer = csv.writer(f)
			writer.writerow(dict_of_lists.keys())
			for items in transposed_data:
				writer.writerow(items)

		print('Selesai Menggabung Kolom Data!')
	else:
		print('Belum Melakukan Merge Dokumen CSV')
		print('TETAP SEMANGAT SCRAPING DATA TYA!!')


#===============================================
"""
fungsi untuk mengambil data link detail dosen 3 jurusan yaitu
matematika, informatika dan statistika USK dari data judul utama
jurnal google scholar
"""
def select_dosen_detail(df_detail):
	#df_fakultas = df[df["Fakultas"] == ["FMIPA"]]
	df_fakultas = df_detail.loc[df_detail['Faculty'].isin(['FMIPA','FT', 'FP'])]

	dosen_math = ['Siti Rusdiana', 'DR. SALMAWATY , M.SC', 'Intan Syahrini', 'Dr. Said Munzir , S.Si., M.Eng.Sc.', 'Nurmaulidar .', 'Taufiq Iskandar', 'Rini Oktavia, S. Si., M. Si., Ph. D', 'Mahyus Ihsan, S.Si, M.Si', 'Dr. RAHMA ZUHRA , S.SI., M.SI', 'Hafnani', 'Saiful Amri .', 'Syarifah Meurah Yuni, S.Si, M.Si', 'Mahmudi', 'Radhiah Radhiah', 'Ikhsan Maulidi', 'T Murdani Saputra', 'Vera  Halfiani']
	print(dosen_math)
	print(len(dosen_math))
	print('===^ Banyaknya dosen math ^====')
	dosen_infor = ['Taufik Fuadi Abidin', 'Hizir', 'Muhammad Subianto', 'Nazaruddin', 'Rasudin', 'Irvanizam', 'Dr. Nizamuddin, M.Info.Sc.', 'Muzailin Affan', 'Rahmad Dawood', 'Zahnur', 'Viska Mutiawani, S.Sn, M.IT', 'Muslim Amiren', 'MUHD. IQBAL , S.SI, M.KOM', 'juwita juwita', 'Junidar Junidar', 'Zulfan', 'Kurnia Saputra', 'Razief Perucha Fauzie Afidh', 'Ardiansyah', 'Amalia Mabrina Masbar Rus', 'Arie Budiansyah', 'Alim Misbullah', 'Khairul Munadi', 'Fitri Arnia', 'Rizal Munadi', 'Dr. Ramzi Adriman', 'Essy Harnelly', 'Muhammad Rusdi']
	print(dosen_infor)
	print(len(dosen_infor))
	print('===^ Banyaknya dosen infor ^====')
	dosen_stat = ['Asep Rusyana', 'Evi Ramadhani', 'Fitriana AR', 'Hizir', 'Latifah Rahayu', 'Marzuki', 'Miftahuddin', 'Muhammad Subianto', 'Munawar Munawar', 'Nany Salwa', 'Nurhasanah Nurhasanah', 'Ridha Ferdhiana', 'Saiful Mahdi', 'Samsul Anwar', 'Zurnila Marli Kesuma']
	print(dosen_stat)
	print(len(dosen_stat))
	print('===^ Banyaknya dosen stat ^====')

	names = dosen_math + dosen_infor + dosen_stat
	print(names)
	print(len(names))
	list_names = list(dict.fromkeys(names))
	print(list_names)
	print(len(list_names))
	print('===^ Banyaknya dosen yang digunakan untuk dataset ^====')
	print('=======================')

	df_select_name = df_fakultas.loc[df_fakultas['Name'].isin(list_names)]
	print(df_select_name.head())
	print('=======================')

	get_df_name = df_select_name['Name']
	#print(get_df_name)
	get_names = get_df_name.values.tolist()
	#print(get_names)
	convert_get_names = set(get_names)
	print(convert_get_names)
	print(type(convert_get_names))
	print(len(convert_get_names))
	print('===^ Banyaknya jenis nama dosen yang digunakan ^====')
	print('=======================')

	df_select_name_set_index = df_select_name.set_index("Name")
	print(df_select_name_set_index.head())
	print('=======================')

	# saving the dataframe 
	df_select_name_set_index.to_csv('dataset1.csv')
	print('Berhasil saving file dataset DETAIL!')

#===============================================
"""
fungsi untuk mengambil data link semua akun publikasi dosen 3 jurusan yaitu
matematika, informatika dan statistika USK dari data publikasi
rp2u usk
"""
def select_dosen_link_rp2u(df_rp2u):
	#df_fakultas = df[df["Fakultas"] == ["FMIPA"]]
	df_fakultas = df_rp2u.loc[df_rp2u['Fakultas/Unit Kerja'].isin(['FMIPA','FT', 'FP'])]

	dosen_math = ['Siti Rusdiana., Dr. Dra., M.Eng', 'Salmawaty., Dr., M.Sc', 'Intan Syahrini., Dra., M.Si', 'Said Munzir., Dr., S.Si., M.Eng.Sc', 'Nurmaulidar., S.Si., M.Sc', 'Taufiq Iskandar., S.Si., M.Si', 'Rini Oktavia., S.Si., M.Si., P', 'Mahyus Ihsan., S.Si, M.Si', 'Rahma Zuhra., Dr., S.Si., M.Si', 'Hafnani., S.Si, M.Si', 'Saiful Amri., S.Si., M.Si', 'Syarifah Meurah Yuni., S.Si., M.Si', 'Mahmudi., S.Si., M.Si.', 'Radhiah., S.Si., M.Sc.', 'Ikhsan Maulidi., S.Si., M.Si', 'T. Murdani Saputra., S.Pd., M.Si', 'Vera Halfiani., S.Si., M.Mat']
	print(dosen_math)
	print(len(dosen_math))
	print('===^ Banyaknya dosen math ^====')
	dosen_infor = ['Taufik Fuadi Abidin., Prof. Dr., S.Si., M.Tech', 'Hizir., Dr', 'Muhammad Subianto., Dr., S.Si, M.Si', 'Nazaruddin., S.Si., M. EngSc', 'Rasudin., S.Si., M.Info.', 'Irvanizam., S.Si, M.Sc', 'Nizamuddin., Dr., M.Info.Sc.', 'Muzailin., Dr., S.Si, M.Sc.', 'Rahmad Dawood., S.Kom, M.Sc', 'Zahnur., S.Si, M.Info Te', 'Viska Mutiawani., S.Sn, M.IT', 'Muslim., M.InfoTech', 'Muhd. Iqbal., S.Si, M.Kom', 'Juwita., ST, M.Kom', 'Junidar., S.Si, M.Kom', 'Zulfan., S.Si., M.Sc.', 'Kurnia Saputra., S.T., M.Sc.', 'Razief Perucha Fauzie Afidh., S.Si., M.Sc', 'Ardiansyah., BSEE.,M.Sc', 'Amalia Mabrina Masbar Rus., B.IT., MBIS.', 'Arie Budiansyah., ST., M.Eng.', 'Alim Misbullah., S.Si., M.S.', 'Khairul Munadi., Dr., ST, M.Eng.', 'Fitri Arnia., Dr., S.T., M.Eng.Sc', 'Rizal Munadi., Dr. Ir., M.M., MT', 'Ramzi Adriman., Dr., S.T, M. Sc', 'Essy Harnelly., Dr., S.Si, M.Si', 'Muhammad Rusdi., S.P, M.Si, Ph.D']
	print(dosen_infor)
	print(len(dosen_infor))
	print('===^ Banyaknya dosen infor ^====')
	dosen_stat = ['Asep Rusyana., S.Si., M.Si', 'Evi Ramadhani., Dr., S.Si.,M.Si', 'Fitriana AR., S.Si., M.Si', 'Hizir., Dr', 'Latifah Rahayu Siregar., S.Si., M.Sc.', 'Marzuki., S.Si., M.Si.', 'Miftahuddin., Dr., S.Si, M.Si', 'Muhammad Subianto., Dr., S.Si, M.Si', 'Munawar., S.Si., M. App.S', 'Nany Salwa., S.Si, M.Si', 'Nurhasanah., S.Si.,M.Si', 'Ridha Ferdhiana., S.Si., M.Sc', 'Saiful Mahdi., Dr., S.Si, M.Sc', 'Samsul Anwar., S.Si., M.Sc', 'Zurnila Marli Kesuma., Dr., S.Si., M.Si']
	print(dosen_stat)
	print(len(dosen_stat))
	print('===^ Banyaknya dosen stat ^====')

	names = dosen_math + dosen_infor + dosen_stat
	print(names)
	print(len(names))
	list_names = list(dict.fromkeys(names))
	print(list_names)
	print(len(list_names))
	print('===^ Banyaknya dosen yang digunakan untuk dataset ^====')
	print('=======================')

	df_select_name = df_fakultas.loc[df_fakultas['Author/Bidang Keahlian'].isin(list_names)]
	print(df_select_name.head())
	print('=======================')

	get_df_name = df_select_name['Author/Bidang Keahlian']
	#print(get_df_name)
	get_names = get_df_name.values.tolist()
	#print(get_names)
	convert_get_names = set(get_names)
	print(convert_get_names)
	print(type(convert_get_names))
	print(len(convert_get_names))
	print('===^ Banyaknya jenis nama dosen yang digunakan ^====')
	print('=======================')

	df_select_name_set_index = df_select_name.set_index("No.")
	print(df_select_name_set_index.head())
	print('=======================')

	# saving the dataframe 
	df_select_name_set_index.to_csv('dataset_rp2u.csv')
	print('Berhasil saving file dataset RP2U!')
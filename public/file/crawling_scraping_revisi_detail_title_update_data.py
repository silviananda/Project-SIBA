import function_scraping
from bs4 import BeautifulSoup
import requests
from csv import reader
import time
import random
import sys

fp = open('data_0.csv')
csv_reader = reader(fp)

links_detail = []
list_name = []
for row in csv_reader:
	links_detail.append(row[4])
	list_name.append(row[0])
#print(row[1])
fp.close()

print(len(links_detail))
print(type(links_detail))
print(len(list_name))
print(type(list_name))

return_value = links_detail.pop(0)
print('Return Value Link:', return_value)
return_value1 = list_name.pop(0)
print('Return Value Name:', return_value1)

#print(links_detail)
print('Banyaknya link detail : ', len(links_detail))
print('=====')
#print(list_name)
print('Banyaknya list nama : ', len(list_name))
print('=====')

mulai = int(sys.argv[1])
ending = int(sys.argv[2])
print('Mulai : ',mulai)
print(type(mulai))
print('=====')

if (ending == 0):
	ending = len(links_detail)

print('Berakhir : ',ending)
print(type(ending))
print('=====')

name = []
for i in range(mulai, ending):
	name.append(list_name[i])

print(name)
print(len(name))
print('=====')

dict_detail_title = {'Name': name, 'Publication date':[], 'Document Type':[], 'Authors':[], 'Name Of Document Type':[],'Volume':[], 'Issue':[], 'Pages':[], 'Publisher':[], 'Description':[]}
type_doc = ['Journal','Conference']

#for link in links_detail:
for x in range(mulai, ending):
	link = links_detail[x]
	index = links_detail.index(link)

	print('Data yang sudah didapatkan sementara')
	print(dict_detail_title)
	print('====================')

	if (link == 'None'):
		#print(links_detail.index(link))
		print(index)
		print("Ditemukan Link : ",link)
		for item in dict_detail_title.keys():
			if (item == 'Name'):
				continue
			else:
				dict_detail_title[item].append('None')

	else:
		print(index)
		#print(links_detail.index(link))
		result = 'https://scholar.google.co.id'+ link
		ganti = result.replace('&oe=ASCII&', '&')
		#ganti1 = ganti.replace('&amp;', '&')
		print(ganti)
		print('=====')

		headers = {'User Agent' : 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:75.0) Gecko/20100101 Firefox/75.0','Accept':'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'}
		page = requests.get(ganti, headers=headers)
		print(page)
		
		if page.status_code != 200:
			print('Karena Bad Gateway ' + str(page.status_code) + ', Akan break proses dan menyimpan data yang telah ada.')
			#function_scraping.menyimpan_data_detail(dict_detail_title, mulai)
			print('=====')
			break

		dict_detail_title = function_scraping.ambil_data_detail_title(page, type_doc, dict_detail_title)



print(dict_detail_title)
print('====================')
print("Link dimulai dari index "+str(mulai)+" sampai index ke- "+str(ending))
print('====================')

function_scraping.menyimpan_data_detail(dict_detail_title, mulai)
function_scraping.gabung_data_csv(ending, links_detail)

print("====================")
print('SEMUA PROSES SELESAI')
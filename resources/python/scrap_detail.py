import scrap_merge_json
from bs4 import BeautifulSoup
import requests
import re
import time
import random
import json
import sys


result = sys.argv[1]
ganti = result.replace('&oe=ASCII&', '&')
page = requests.get(ganti)

dict_detail_title = {'Name': [], 'Publication date':[], 'Document Type':[], 'Authors':[], 'Name Of Document Type':[],'Volume':[], 'Issue':[], 'Pages':[], 'Publisher':[], 'Description':[], 'Total citations':[]}
detail_title = scrap_merge_json.ambil_data_detail_title(page, dict_detail_title)

print(json.dumps(detail_title))

#============================================================
# # fp = open('data_1_merge.csv')
# # csv_reader = reader(fp)
# links_detail = []
# list_name = []
# for row in csv_reader:
# 	links_detail.append(row[3])
# 	list_name.append(row[0])
# #print(row[1])
# # fp.close()

# # print(len(links_detail))
# # print(type(links_detail))
# # print(len(list_name))
# # print(type(list_name))

# return_value = links_detail.pop(0)
# print('Return Value Link:', return_value)
# return_value1 = list_name.pop(0)
# print('Return Value Name:', return_value1)

# #print(links_detail)
# print('Banyaknya link detail : ', len(links_detail))
# print(links_detail)
# print('=====')
# #print(list_name)
# print('Banyaknya list nama : ', len(list_name))
# print(list_name)
# print('=====')

# # start scraping detail ======================================================

# dict_detail_title = {'Name': list_name, 'Publication date':[], 'Document Type':[], 'Authors':[], 'Name Of Document Type':[],'Volume':[], 'Issue':[], 'Pages':[], 'Publisher':[], 'Description':[], 'Total citations':[]}
# type_doc = ['Journal','Conference']

# mulai = 0
# ending = len(links_detail)
# #for link in links_detail:
# for x in range(len(links_detail)):
# 	link = links_detail[x]
# 	index = links_detail.index(link)

# 	print('Data yang sudah didapatkan sementara')
# 	print(dict_detail_title)
# 	print('====================')

# 	if (link == 'None'):
# 		#print(links_detail.index(link))
# 		print(index)
# 		print("Ditemukan Link : ",link)
# 		for item in dict_detail_title.keys():
# 			if (item == 'Name'):
# 				continue
# 			else:
# 				dict_detail_title[item].append('None')

# 	else:
# 		print(index)
# 		#print(links_detail.index(link))
# 		result = 'https://scholar.google.co.id'+ link
# 		ganti = result.replace('&oe=ASCII&', '&')
# 		#ganti1 = ganti.replace('&amp;', '&')
# 		print(ganti)
# 		print('=====')

# 		#headers = {'User Agent' : 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:75.0) Gecko/20100101 Firefox/75.0','Accept':'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'}
# 		#page = requests.get(ganti, headers=headers)
# 		page = requests.get(ganti)
# 		print(page)
		
# 		if page.status_code != 200:
# 			print('Karena Bad Gateway ' + str(page.status_code) + ', Akan break proses dan menyimpan data yang telah ada.')
# 			#function_scraping_merge.menyimpan_data_detail(dict_detail_title, mulai)
# 			print('=====')
# 			break

# 		dict_detail_title = function_scraping_merge_json.ambil_data_detail_title(page, type_doc, dict_detail_title)



# print(dict_detail_title)
# print('====================')
# # print("Link dimulai dari index "+str(mulai)+" sampai index ke- "+str(ending))
# # print('====================')

# function_scraping_merge_json.menyimpan_data_detail(dict_detail_title, mulai)
# function_scraping_merge_json.gabung_data_csv(ending, links_detail)

# print("====================")
# print('SEMUA PROSES SELESAI')

# # ending scraping detail ======================================================
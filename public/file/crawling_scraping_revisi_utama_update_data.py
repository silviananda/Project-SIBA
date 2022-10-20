import function_scraping
from bs4 import BeautifulSoup
import requests
import re
from csv import DictWriter
from csv import reader
import pandas as pd
import time
import random
import sys

# ======== step to open csv and get data link n fak =========
fp = open('dataset_rp2u.csv')
csv_reader = reader(fp)

links = []
list_fak = []
for row in csv_reader:
    list_fak.append(row[2])
    links.append(row[6])

#print(row[1])
fp.close()
return_value = links.pop(0)
print('Return Value Link:', return_value)
return_value = list_fak.pop(0)
print('Return Value Fakultas:', return_value)

print('list link : ', links)
print(len(links))
print(type(links))
print('list Fakultas : ', list_fak)
print(len(list_fak))
print(type(list_fak))
# ======== and step to open csv and get data link n fak =========

mulai = int(sys.argv[1])
ending = int(sys.argv[2])
print(mulai)
print(type(mulai))

if (ending == 0):
	ending = len(links)
print(ending)
print(type(ending))

#mulai proses request link
total_data = 0
no_data_list = []
#for link in links:
for x in range(mulai, ending):
	link = links[x]

	if (link == 'belum ada'):
		print("Ditemukan Link : ",link)
		print(links.index(link))
	else:
		if (link == 'tcHDn40AAAAJ'):
			str_add = "https://scholar.google.com/citations?user="
			x = links.index(link)
			link = str_add + link + '&hl=en'
			links.insert(x, link)
			x += 1
			return_value = links.pop(x)
			print('Return Value:', return_value)
			print('=====')
		elif (link.find('hl=id') != -1):
			#print(link)
			x = links.index(link)
			link = link.replace('hl=id','hl=en')
			links.insert(x, link)
			x += 1
			return_value = links.pop(x)
			print('Return Value:', return_value)
		elif (link.find('hl=id') == -1 and link.find('hl=en') == -1):
			#print(link)
			x = links.index(link)
			link = link + '&hl=en'
			links.insert(x, link)
			x += 1
			return_value = links.pop(x)
			print('Return Value:', return_value)
		elif (link.find('#') != -1):
			x = links.index(link)
			link = link.replace('#','')
			links.insert(x, link)
			x += 1
			return_value = links.pop(x)
			print('Return Value:', return_value)

		print(link)
		index = links.index(link)
		#index = x
		print(index)
		print('====')
		total_data += 1
		count = 0

		headers = {'User Agent' : 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:75.0) Gecko/20100101 Firefox/75.0','Accept':'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'}
		page = requests.get(link, headers=headers)
		print(page)

		soup = BeautifulSoup(page.content, 'html.parser')
		sec = random.randint(7,45)
		print('Akan break dalam ' + str(sec) + ' detik..')
		time.sleep(sec)
		print('====')

		while (True):
			#pass
			if (count == 0):
				tdk_ada_data = soup.find('td', class_='gsc_a_e')
				if tdk_ada_data is not None:
					print(tdk_ada_data.text.strip())
					name = soup.find('div', attrs={'id' : 'gsc_prf_in'}).text.strip()
					print(name)
					print("====")
				
					dict_data = {}
					dict_data["Nama"] = name
					dict_data["Faculty"] = list_fak[index]
					dict_data["Dokumen"] = 'None'
					dict_data["Tahun"] = 'None'
					dict_data['Link Detail Title'] = 'None'

					print(dict_data)
					list_key = dict_data.keys()

					with open('data_0.csv', 'a+', newline='') as write_obj:
					# Create a writer object from csv module
						dict_writer = DictWriter(write_obj, fieldnames=list_key)
						if(index == 0):
							dict_writer.writeheader()
							dict_writer.writerow(dict_data)
						else:
							dict_writer.writerow(dict_data)


					print("====")
					print('selesai membuat file!')
					break
				else:
					tdk_ada_data = None
					name = soup.find('div', attrs={'id' : 'gsc_prf_in'})
					if name is not None:
						print("Akan Proses Mengambil Data!")
						filename = function_scraping.simpan_data(soup,index,count)
						function_scraping.ambil_data(filename,index,count,list_fak)
					else:
						name = None
						no_data_list.append(link)
						print("Link Tidak Digunakan!")
						break

				count += 1
			elif (count == 1):
				append_str = "&cstart=20&pagesize=80"
				new_link = link + append_str
				print(new_link)

				headers = {'User Agent' : 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:75.0) Gecko/20100101 Firefox/75.0','Accept':'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'}
				page = requests.get(new_link, headers=headers)
				print(page)

				soup = BeautifulSoup(page.content, 'html.parser')
				tdk_ada_data = soup.find('td', class_='gsc_a_e')
				#print(tdk_ada_data)
				sec = random.randint(5,40)
				print('Akan break dalam ' + str(sec) + ' detik..')
				time.sleep(sec)
				print('====')

				if tdk_ada_data is not None:
					print(tdk_ada_data.text.strip())
					break
				else:
					tdk_ada_data = None
					print("Akan Proses Mengambil Data Lagi!")
					filename = function_scraping.simpan_data(soup,index,count)
					function_scraping.ambil_data(filename,index,count,list_fak)
		
				count += 1
				# print(count)
				# break
			elif (count == 2):
				change_link = new_link.replace("start=20", "start=100")
				new_link = change_link.replace("pagesize=80", "pagesize=100")
				print(new_link)

				headers = {'User Agent' : 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:75.0) Gecko/20100101 Firefox/75.0','Accept':'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'}
				page = requests.get(new_link, headers=headers)
				print(page)

				soup = BeautifulSoup(page.content, 'html.parser')
				tdk_ada_data = soup.find('td', class_='gsc_a_e')
				#print(tdk_ada_data)
				sec = random.randint(3,35)
				print('Akan break dalam ' + str(sec) + ' detik..')
				time.sleep(sec)
				print('====')

				if tdk_ada_data is not None:
					print(tdk_ada_data.text.strip())
					break
				else:
					tdk_ada_data = None
					print("Akan Proses Mengambil Data Lagi!")
					filename = function_scraping.simpan_data(soup,index,count)
					function_scraping.ambil_data(filename,index,count,list_fak)
			
				count += 1
				# break
			elif (count > 2):
				result = re.findall(r"\d+", new_link)
				no_start = int(result[-2])
				no_start += 100
				change_no_start = "start="+str(no_start)

				new_link = new_link.replace("start="+(result[-2]), change_no_start)
				print(new_link)

				headers = {'User Agent' : 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:75.0) Gecko/20100101 Firefox/75.0','Accept':'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'}
				page = requests.get(new_link, headers=headers)
				print(page)

				soup = BeautifulSoup(page.content, 'html.parser')
				tdk_ada_data = soup.find('td', class_='gsc_a_e')
				#print(tdk_ada_data)
				sec = random.randint(1,30)
				print('Akan break dalam ' + str(sec) + ' detik..')
				time.sleep(sec)
				print('====')

				if tdk_ada_data is not None:
					print(tdk_ada_data.text.strip())
					break
				else:
					tdk_ada_data = None
					print("Akan Proses Mengambil Data Lagi!")
					filename = function_scraping.simpan_data(soup,index,count)
					function_scraping.ambil_data(filename,index,count,list_fak)
			
				count += 1
				#break

			continue



print('===============================================')
print("Link dimulai dari index "+str(mulai)+" sampai index ke- "+str(ending))
print(links)
print(len(links))
print("====")
print(no_data_list)
print(len(no_data_list))
print("====")
print(total_data)
print("SEMUA PROSES SEMENTARA SELESAI!")

# ======================================================

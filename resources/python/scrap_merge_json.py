from bs4 import BeautifulSoup
from itertools import zip_longest
import csv
from collections import defaultdict
import time
import random
import re
import pandas as pd
import json

"""
fungsi proses untuk scraping data bersih
halaman profil utama google scholar
"""
def ambil_data(filebody):
    bsoup = BeautifulSoup(filebody, 'html.parser')
    name = bsoup.find('div', attrs={'id' : 'gsc_prf_in'}).text.strip()

    list_title = []
    list_link_title_detail = []
    titles = bsoup.find_all('td', class_='gsc_a_t')
    for get_title in titles:
        title = get_title.find('a').text.strip()
        link_title_detail = get_title.find('a').attrs['href']
        list_title.append(title)
        list_link_title_detail.append(link_title_detail)

    list_year = []
    years = bsoup.find_all('td', class_='gsc_a_y')
    for get_year in years:
        year = get_year.find('span').text.strip()
        list_year.append(year)

    max_data = len(list_title)
    nm = [name] * max_data
    #fak = list_fak[index]
    #fakultas = [fak] * max_data

    dict_data = {}
    dict_data["Name"] = nm
    #dict_data["Faculty"] = fakultas
    dict_data["Document"] = list_title
    #dict_data["Cited By"] = list_cited
    dict_data["Year"] = list_year
    dict_data["Link Detail Title"] = list_link_title_detail

    # mulai memasukkan data bersih di simpan ke dalam array
    transposed_data = list(zip_longest(*dict_data.values()))
    records = []
    for row in transposed_data:
        record = {
                "Name": row[0],
                "Document": row[1],
                "Year": row[2],
                "Link Detail Title": row[3]
            }
        records.append(record) 

    # return sebagai array 
    return records

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

    #tes get value of cited by
    if ('Total citations' in detail_title):
        cited_div = soup.find('div', style='margin-bottom:1em')
        cited_val = cited_div.find('a').text.strip()
        cited_val_num = re.findall(r'\d+', cited_val)

        get_idx_detail_title = detail_title.index('Total citations')
        get_idx_detail_title += 1
        detail_title[get_idx_detail_title] = " ".join(cited_val_num)

        print(detail_title)
        print('2 ==================== 2')
    #end tes get value of cited by

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
    with open('data_detail_on_merge.csv', 'a+', newline='') as f:
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

        f = 'data_1_merge.csv'

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

        fa = 'data_detail_on_merge.csv'

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
        with open('data_gabung_semua_merge.csv', 'a+', newline='') as f:
            writer = csv.writer(f)
            writer.writerow(dict_of_lists.keys())
            for items in transposed_data:
                writer.writerow(items)

        print('Selesai Menggabung Kolom Data!')
        print('============================')
        #print(pd.DataFrame.from_dict(dict_of_lists)) #print output dataframe
        app_json = json.dumps(dict_of_lists)
        print(app_json)

        with open('app.json', 'w') as fp:
            json.dump(dict_of_lists, fp)

    else:
        print('Belum Melakukan Merge Dokumen CSV')
        print('TETAP SEMANGAT SCRAPING DATA TYA!!')


#===============================================
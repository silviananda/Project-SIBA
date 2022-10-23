import scrap_merge_json
from bs4 import BeautifulSoup
import requests
import re
import time
import random
import json
# import sys

#mulai proses request link
total_data = 0
no_data_list = []
links = []
link = "https://scholar.google.com/citations?user=qvbW_WoAAAAJ&hl=en&authuser=1"


if (link.find('hl=id') != -1):
    x = links.index(link)
    link = link.replace('hl=id','hl=en')
    links.insert(x, link)
    x += 1
    return_value = links.pop(x)
elif (link.find('hl=id') == -1 and link.find('hl=en') == -1):
    x = links.index(link)
    link = link + '&hl=en'
    links.insert(x, link)
    x += 1
    return_value = links.pop(x)
elif (link.find('#') != -1):
    x = links.index(link)
    link = link.replace('#','')
    links.insert(x, link)
    x += 1
    return_value = links.pop(x)

index = 0
total_data += 1
count = 0

page = requests.get(link)

soup = BeautifulSoup(page.content, 'html.parser')
sec = random.randint(7,45)
time.sleep(sec)

#scraping utama
list_pub = []
list_html = []
while (True):
    #pass
    if (count == 0):
        tdk_ada_data = soup.find('td', class_='gsc_a_e')
        if tdk_ada_data is not None:
            name = soup.find('div', attrs={'id' : 'gsc_prf_in'}).text.strip()
            
            dict_data = {}
            dict_data["Name"] = name
            #dict_data["Faculty"] = fakultas
            dict_data["Document"] = 'None'
            #dict_data["Cited By"] = 'None'
            dict_data["Year"] = 'Non'
            dict_data['Link Detail Title'] = 'None'

            break
        else:
            tdk_ada_data = None
            name = soup.find('div', attrs={'id' : 'gsc_prf_in'})
            if name is not None:
                # print("Akan Proses Mengambil Data!")
                filebody = soup.decode('utf-8')
                list_html.append(filebody)
                records = scrap_merge_json.ambil_data(filebody)
                list_pub.append(records) # CHECKPOINT
            else:
                name = None
                no_data_list.append(link)
                break

        count += 1
    elif (count == 1):
        append_str = "&cstart=20&pagesize=80"
        new_link = link + append_str

        #headers = {'User Agent' : 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:75.0) Gecko/20100101 Firefox/75.0','Accept':'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'}
        #page = requests.get(new_link, headers=headers)
        page = requests.get(new_link)

        soup = BeautifulSoup(page.content, 'html.parser')
        tdk_ada_data = soup.find('td', class_='gsc_a_e')
        sec = random.randint(5,40)
        time.sleep(sec)

        if tdk_ada_data is not None:
            break
        else:
            tdk_ada_data = None
            # print("Akan Proses Mengambil Data Lagi!")
            filebody = soup.decode('utf-8')
            list_html.append(filebody)
            records = scrap_merge_json.ambil_data(filebody)
            list_pub.append(records) # CHECKPOINT

        count += 1
        # break
    elif (count == 2):
        change_link = new_link.replace("start=20", "start=100")
        new_link = change_link.replace("pagesize=80", "pagesize=100")

        #headers = {'User Agent' : 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:75.0) Gecko/20100101 Firefox/75.0','Accept':'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'}
        #page = requests.get(new_link, headers=headers)
        page = requests.get(new_link)

        soup = BeautifulSoup(page.content, 'html.parser')
        tdk_ada_data = soup.find('td', class_='gsc_a_e')
        sec = random.randint(3,35)
        time.sleep(sec)

        if tdk_ada_data is not None:
            break
        else:
            tdk_ada_data = None
            filebody = soup.decode('utf-8')
            list_html.append(filebody)
            records = scrap_merge_json.ambil_data(filebody)
            list_pub.append(records) # CHECKPOINT
           
        count += 1
        # break
    elif (count > 2):
        result = re.findall(r"\d+", new_link)
        no_start = int(result[-2])
        no_start += 100
        change_no_start = "start="+str(no_start)

        new_link = new_link.replace("start="+(result[-2]), change_no_start)

        #headers = {'User Agent' : 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:75.0) Gecko/20100101 Firefox/75.0','Accept':'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'}
        #page = requests.get(new_link, headers=headers)
        page = requests.get(new_link)

        soup = BeautifulSoup(page.content, 'html.parser')
        tdk_ada_data = soup.find('td', class_='gsc_a_e')
        sec = random.randint(1,30)
        time.sleep(sec)

        if tdk_ada_data is not None:
            break
        else:
            tdk_ada_data = None
            filebody = soup.decode('utf-8')
            list_html.append(filebody)
            records = scrap_merge_json.ambil_data(filebody)
            list_pub.append(records) # CHECKPOINT
            
        count += 1
        #break

    continue
print(json.dumps(records))
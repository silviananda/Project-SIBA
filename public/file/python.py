# from bs4 import BeautifulSoup
# import requests

# link = 'https://scholar.google.com/citations?user=qvbW_WoAAAAJ&hl=en&authuser=1'
# headers = {'User Agent' : 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:75.0) Gecko/20100101 Firefox/75.0','Accept':'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'}
# page = requests.get(link)

import requests
from bs4 import BeautifulSoup
import csv

URL = "http://www.values.com/inspirational-quotes"
r = requests.get(URL)
soup = BeautifulSoup(r.content, 'html5lib')
  
print(r.content)

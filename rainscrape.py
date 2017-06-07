from bs4 import BeautifulSoup
import requests
import pandas as pd
import numpy as np

#--------------------------------------------------------------------------------
# Scraping  Rainfall Data

#link = url.urlopen("http://hydro.imd.gov.in/hydrometweb/(S(lstlft55q4acaw2msf230t55))/landing.aspx")


r=requests.get("http://hydro.imd.gov.in/hydrometweb/(S(lstlft55q4acaw2msf230t55))/landing.aspx")
link=r.text
soup = BeautifulSoup(link, "html.parser")


#print (soup.prettify())

right_table = soup.find('table',id="rfGrid")
#print (right_table.prettify())

#Generate Lists
stateList = []
stationList = []
rainList = []


for row in right_table.findAll('tr')[1:]:
    cells = row.findAll('span')

    stateList.append(cells[0].find(text=True))
    stationList.append(cells[1].find(text=True))
    rainList.append(cells[2].find(text=True))

stateList = np.asarray(stateList)
stationList = np.asarray(stationList)
rainList = np.asarray(rainList).astype('str')

df=pd.DataFrame(stateList,columns=['State'])
df['Station Name']=stationList
df['Rainfall']=rainList

df.to_csv('/var/www/html/sample2.csv')
                                              
